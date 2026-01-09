<?php

namespace App\Http\Controllers;

use App\Models\PenerimaanBarang;
use App\Models\Barang;
use App\Models\LokasiGudang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PenerimaanBarangController extends Controller
{
    public function index()
    {
        $penerimaan = PenerimaanBarang::with('barang')
            ->orderBy('tanggal_penerimaan', 'desc')
            ->paginate(10);
        return view('penerimaan.index', compact('penerimaan'));
    }

    public function create()
    {
        $barang = Barang::orderBy('nama_barang')->get();
        $lokasiGudang = LokasiGudang::orderBy('nama_lokasi')->get(); // Tambahkan ini
        return view('penerimaan.create', compact('barang', 'lokasiGudang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_po' => 'required|string|max:50',
            'nama_supplier' => 'required|string|max:100',
            'id_barang' => 'required|exists:barang,id_barang',
            'jumlah' => 'required|integer|min:1',
            'lokasi_gudang' => 'required|string|max:100',
            'tanggal_penerimaan' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            // Get barang
            $barang = Barang::findOrFail($validated['id_barang']);

            // Create penerimaan
            $validated['id_penerimaan'] = 'PNM-' . Str::uuid();
            $validated['barang_diterima'] = $barang->nama_barang;
            
            $penerimaan = PenerimaanBarang::create($validated);

            // Update stok barang
            $barang->increment('jumlah_stok', $validated['jumlah']);

            // Create transaksi
            Transaksi::create([
                'id_transaksi' => 'TRX-' . Str::uuid(),
                'tipe_transaksi' => 'masuk',
                'tanggal' => $validated['tanggal_penerimaan'],
                'jumlah_barang' => $validated['jumlah'],
                'total_harga' => $barang->harga * $validated['jumlah'],
                'id_barang' => $validated['id_barang'],
                'id_penerimaan' => $penerimaan->id_penerimaan,
            ]);

            DB::commit();

            return redirect()->route('penerimaan.index')
                ->with('success', 'Penerimaan barang berhasil dicatat. Stok telah diupdate.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(PenerimaanBarang $penerimaan)
    {
        return view('penerimaan.show', compact('penerimaan'));
    }

    public function edit(PenerimaanBarang $penerimaan)
    {
        $barang = Barang::orderBy('nama_barang')->get();
        $lokasiGudang = LokasiGudang::orderBy('nama_lokasi')->get(); // Tambahkan ini
        return view('penerimaan.edit', compact('penerimaan', 'barang', 'lokasiGudang'));
    }

    public function update(Request $request, PenerimaanBarang $penerimaan)
    {
        $validated = $request->validate([
            'nomor_po' => 'required|string|max:50',
            'nama_supplier' => 'required|string|max:100',
            'id_barang' => 'required|exists:barang,id_barang',
            'jumlah' => 'required|integer|min:1',
            'lokasi_gudang' => 'required|string|max:100',
            'tanggal_penerimaan' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            // Calculate difference
            $oldJumlah = $penerimaan->jumlah;
            $newJumlah = $validated['jumlah'];
            $difference = $newJumlah - $oldJumlah;

            // Get barang
            $barang = Barang::findOrFail($validated['id_barang']);
            $validated['barang_diterima'] = $barang->nama_barang;

            // Update stok if there's difference
            if ($difference != 0) {
                if ($difference > 0) {
                    $barang->increment('jumlah_stok', abs($difference));
                } else {
                    $barang->decrement('jumlah_stok', abs($difference));
                }
            }

            // Update penerimaan
            $penerimaan->update($validated);

            // Update transaksi
            $transaksi = Transaksi::where('id_penerimaan', $penerimaan->id_penerimaan)->first();
            if ($transaksi) {
                $transaksi->update([
                    'tanggal' => $validated['tanggal_penerimaan'],
                    'jumlah_barang' => $validated['jumlah'],
                    'total_harga' => $barang->harga * $validated['jumlah'],
                    'id_barang' => $validated['id_barang'],
                ]);
            }

            DB::commit();

            return redirect()->route('penerimaan.index')
                ->with('success', 'Data penerimaan berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(PenerimaanBarang $penerimaan)
    {
        DB::beginTransaction();
        try {
            // Kurangi stok barang
            $barang = $penerimaan->barang;
            $barang->decrement('jumlah_stok', $penerimaan->jumlah);

            // Hapus transaksi terkait
            Transaksi::where('id_penerimaan', $penerimaan->id_penerimaan)->delete();

            // Hapus penerimaan
            $penerimaan->delete();

            DB::commit();

            return redirect()->route('penerimaan.index')
                ->with('success', 'Penerimaan barang berhasil dihapus. Stok telah dikurangi.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}