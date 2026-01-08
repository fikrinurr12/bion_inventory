<?php

namespace App\Http\Controllers;

use App\Models\LokasiGudang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LokasiGudangController extends Controller
{
    public function index()
    {
        $lokasi = LokasiGudang::orderBy('created_at', 'desc')->paginate(10);
        return view('lokasi-gudang.index', compact('lokasi'));
    }

    public function create()
    {
        return view('lokasi-gudang.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lokasi' => 'required|string|max:100',
            'kode_lokasi' => 'required|string|max:50|unique:lokasi_gudang,kode_lokasi',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        $validated['id_lokasi'] = 'LOK-' . Str::uuid();

        LokasiGudang::create($validated);

        return redirect()->route('lokasi-gudang.index')
            ->with('success', 'Lokasi gudang berhasil ditambahkan');
    }

    public function show(LokasiGudang $lokasiGudang)
    {
        return view('lokasi-gudang.show', compact('lokasiGudang'));
    }

    public function edit(LokasiGudang $lokasiGudang)
    {
        return view('lokasi-gudang.edit', compact('lokasiGudang'));
    }

    public function update(Request $request, LokasiGudang $lokasiGudang)
    {
        $validated = $request->validate([
            'nama_lokasi' => 'required|string|max:100',
            'kode_lokasi' => 'required|string|max:50|unique:lokasi_gudang,kode_lokasi,' . $lokasiGudang->id_lokasi . ',id_lokasi',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        $lokasiGudang->update($validated);

        return redirect()->route('lokasi-gudang.index')
            ->with('success', 'Lokasi gudang berhasil diupdate');
    }

    public function destroy(LokasiGudang $lokasiGudang)
    {
        $lokasiGudang->delete();

        return redirect()->route('lokasi-gudang.index')
            ->with('success', 'Lokasi gudang berhasil dihapus');
    }
}