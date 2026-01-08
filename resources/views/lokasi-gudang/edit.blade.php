@extends('layouts.app')

@section('page-title', 'Edit Lokasi Gudang')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-pencil"></i> Edit Lokasi Gudang</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('lokasi-gudang.update', $lokasiGudang->id_lokasi) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="kode_lokasi" class="form-label">Kode Lokasi <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('kode_lokasi') is-invalid @enderror" 
                                       id="kode_lokasi" 
                                       name="kode_lokasi" 
                                       value="{{ old('kode_lokasi', $lokasiGudang->kode_lokasi) }}"
                                       required>
                                <small class="text-muted">Format: GDGA-R01 (Gudang A - Rak 01)</small>
                                @error('kode_lokasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="nama_lokasi" class="form-label">Nama Lokasi <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('nama_lokasi') is-invalid @enderror" 
                                       id="nama_lokasi" 
                                       name="nama_lokasi" 
                                       value="{{ old('nama_lokasi', $lokasiGudang->nama_lokasi) }}"
                                       required>
                                @error('nama_lokasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" 
                                      name="deskripsi" 
                                      rows="4">{{ old('deskripsi', $lokasiGudang->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> 
                            <small>Terakhir diupdate: {{ $lokasiGudang->updated_at->format('d M Y H:i') }}</small>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('lokasi-gudang.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Update Lokasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection