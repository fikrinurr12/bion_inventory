<?php

namespace App\Http\Controllers;

use App\Models\PengeluaranBarang;
use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PengeluaranBarangController extends Controller
{
    public function index()
    {
        $pengeluaran = PengeluaranBarang::with('barang')
            ->orderBy('tanggal_pengeluaran', 'desc')
            ->paginate(10);
        return view('pengeluaran.index', compact('pengeluaran'));
    }

    public function create()
    {
        $barang = Barang::where('jumlah_stok', '>', 0)
            ->orderBy('nama_barang')
            ->get();
        return view('pengeluaran.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_barang' => 'required|exists:barang,id_barang',
            'jumlah' => 'required|integer|min:1',
            'tujuan' => 'required|string|max:100',
            'alasan_pengeluaran' => 'required|string|max:255',
            'tanggal_pengeluaran' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            // Get barang
            $barang = Barang::findOrFail($validated['id_barang']);

            // Check stok availability
            if ($barang->jumlah_stok < $validated['jumlah']) {
                return redirect()->back()
                    ->with('error', 'Stok tidak mencukupi! Stok tersedia: ' . $barang->jumlah_stok)
                    ->withInput();
            }

            // Create pengeluaran
            $validated['id_pengeluaran'] = 'PGL-' . Str::uuid();
            $validated['nama_barang'] = $barang->nama_barang;
            
            $pengeluaran = PengeluaranBarang::create($validated);

            // Update stok barang (kurangi)
            $barang->decrement('jumlah_stok', $validated['jumlah']);

            // Create transaksi
            Transaksi::create([
                'id_transaksi' => 'TRX-' . Str::uuid(),
                'tipe_transaksi' => 'keluar',
                'tanggal' => $validated['tanggal_pengeluaran'],
                'jumlah_barang' => $validated['jumlah'],
                'total_harga' => $barang->harga * $validated['jumlah'],
                'id_barang' => $validated['id_barang'],
                'id_pengeluaran' => $pengeluaran->id_pengeluaran,
            ]);

            DB::commit();

            return redirect()->route('pengeluaran.index')
                ->with('success', 'Pengeluaran barang berhasil dicatat. Stok telah dikurangi.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(PengeluaranBarang $pengeluaran)
    {
        return view('pengeluaran.show', compact('pengeluaran'));
    }

    public function edit(PengeluaranBarang $pengeluaran)
    {
        $barang = Barang::orderBy('nama_barang')->get();
        return view('pengeluaran.edit', compact('pengeluaran', 'barang'));
    }

    public function update(Request $request, PengeluaranBarang $pengeluaran)
    {
        $validated = $request->validate([
            'id_barang' => 'required|exists:barang,id_barang',
            'jumlah' => 'required|integer|min:1',
            'tujuan' => 'required|string|max:100',
            'alasan_pengeluaran' => 'required|string|max:255',
            'tanggal_pengeluaran' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            // Calculate difference
            $oldJumlah = $pengeluaran->jumlah;
            $newJumlah = $validated['jumlah'];
            $difference = $newJumlah - $oldJumlah;

            // Get barang
            $barang = Barang::findOrFail($validated['id_barang']);
            $validated['nama_barang'] = $barang->nama_barang;

            // Update stok if there's difference
            if ($difference != 0) {
                if ($difference > 0) {
                    // Jika jumlah bertambah, cek stok dulu
                    if ($barang->jumlah_stok < abs($difference)) {
                        return redirect()->back()
                            ->with('error', 'Stok tidak mencukupi untuk penambahan jumlah!')
                            ->withInput();
                    }
                    $barang->decrement('jumlah_stok', abs($difference));
                } else {
                    // Jika jumlah berkurang, kembalikan ke stok
                    $barang->increment('jumlah_stok', abs($difference));
                }
            }

            // Update pengeluaran
            $pengeluaran->update($validated);

            // Update transaksi
            $transaksi = Transaksi::where('id_pengeluaran', $pengeluaran->id_pengeluaran)->first();
            if ($transaksi) {
                $transaksi->update([
                    'tanggal' => $validated['tanggal_pengeluaran'],
                    'jumlah_barang' => $validated['jumlah'],
                    'total_harga' => $barang->harga * $validated['jumlah'],
                    'id_barang' => $validated['id_barang'],
                ]);
            }

            DB::commit();

            return redirect()->route('pengeluaran.index')
                ->with('success', 'Data pengeluaran berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(PengeluaranBarang $pengeluaran)
    {
        DB::beginTransaction();
        try {
            // Kembalikan stok barang
            $barang = $pengeluaran->barang;
            $barang->increment('jumlah_stok', $pengeluaran->jumlah);

            // Hapus transaksi terkait
            Transaksi::where('id_pengeluaran', $pengeluaran->id_pengeluaran)->delete();

            // Hapus pengeluaran
            $pengeluaran->delete();

            DB::commit();

            return redirect()->route('pengeluaran.index')
                ->with('success', 'Pengeluaran barang berhasil dihapus. Stok telah dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}