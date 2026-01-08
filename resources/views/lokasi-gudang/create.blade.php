@extends('layouts.app')

@section('page-title', 'Tambah Lokasi Gudang')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Tambah Lokasi Gudang Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('lokasi-gudang.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="kode_lokasi" class="form-label">Kode Lokasi <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('kode_lokasi') is-invalid @enderror" 
                                       id="kode_lokasi" 
                                       name="kode_lokasi" 
                                       value="{{ old('kode_lokasi') }}"
                                       placeholder="Contoh: GDGA-R01"
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
                                       value="{{ old('nama_lokasi') }}"
                                       placeholder="Contoh: Gudang A - Rak 1"
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
                                      rows="4"
                                      placeholder="Contoh: Rak khusus untuk perangkat elektronik, lantai 1 sebelah kiri">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i>
                            <strong>Tips:</strong> Gunakan kode yang mudah diingat dan konsisten untuk memudahkan pencarian barang.
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('lokasi-gudang.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Lokasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection