@extends('layouts.app')

@section('page-title', 'Tambah Barang')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Tambah Barang Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('barang.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="kode_barang" class="form-label">Kode Barang <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('kode_barang') is-invalid @enderror" 
                                       id="kode_barang" 
                                       name="kode_barang" 
                                       value="{{ old('kode_barang') }}"
                                       placeholder="Contoh: BRG001"
                                       required>
                                @error('kode_barang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="nama_barang" class="form-label">Nama Barang <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('nama_barang') is-invalid @enderror" 
                                       id="nama_barang" 
                                       name="nama_barang" 
                                       value="{{ old('nama_barang') }}"
                                       placeholder="Contoh: Laptop Dell Latitude"
                                       required>
                                @error('nama_barang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jumlah_stok" class="form-label">Jumlah Stok <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control @error('jumlah_stok') is-invalid @enderror" 
                                       id="jumlah_stok" 
                                       name="jumlah_stok" 
                                       value="{{ old('jumlah_stok', 0) }}"
                                       min="0"
                                       required>
                                @error('jumlah_stok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="harga" class="form-label">Harga Satuan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" 
                                           class="form-control @error('harga') is-invalid @enderror" 
                                           id="harga" 
                                           name="harga" 
                                           value="{{ old('harga', 0) }}"
                                           min="0"
                                           step="0.01"
                                           required>
                                </div>
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="lokasi_penyimpanan" class="form-label">Lokasi Penyimpanan</label>
                            <input type="text" 
                                   class="form-control @error('lokasi_penyimpanan') is-invalid @enderror" 
                                   id="lokasi_penyimpanan" 
                                   name="lokasi_penyimpanan" 
                                   value="{{ old('lokasi_penyimpanan') }}"
                                   placeholder="Contoh: Gudang A - Rak 1">
                            @error('lokasi_penyimpanan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('barang.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Barang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection