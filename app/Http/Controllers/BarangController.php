<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\LokasiGudang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::orderBy('created_at', 'desc')->paginate(10);
        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        // Ambil semua lokasi gudang
        $lokasiGudang = LokasiGudang::orderBy('nama_lokasi')->get();
        return view('barang.create', compact('lokasiGudang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:100',
            'kode_barang' => 'required|string|max:50|unique:barang,kode_barang',
            'jumlah_stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'lokasi_penyimpanan' => 'nullable|string|max:100',
        ]);

        $validated['id_barang'] = 'BRG-' . Str::uuid();

        Barang::create($validated);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan');
    }

    public function show(Barang $barang)
    {
        return view('barang.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        // Ambil semua lokasi gudang
        $lokasiGudang = LokasiGudang::orderBy('nama_lokasi')->get();
        return view('barang.edit', compact('barang', 'lokasiGudang'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:100',
            'kode_barang' => 'required|string|max:50|unique:barang,kode_barang,' . $barang->id_barang . ',id_barang',
            'jumlah_stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'lokasi_penyimpanan' => 'nullable|string|max:100',
        ]);

        $barang->update($validated);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil diupdate');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil dihapus');
    }
}