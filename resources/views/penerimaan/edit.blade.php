@extends('layouts.app')

@section('page-title', 'Edit Penerimaan Barang')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-pencil"></i> Edit Penerimaan Barang</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('penerimaan.update', $penerimaan->id_penerimaan) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nomor_po" class="form-label">Nomor PO <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('nomor_po') is-invalid @enderror" 
                                       id="nomor_po" 
                                       name="nomor_po" 
                                       value="{{ old('nomor_po', $penerimaan->nomor_po) }}"
                                       required>
                                @error('nomor_po')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tanggal_penerimaan" class="form-label">Tanggal Penerimaan <span class="text-danger">*</span></label>
                                <input type="date" 
                                       class="form-control @error('tanggal_penerimaan') is-invalid @enderror" 
                                       id="tanggal_penerimaan" 
                                       name="tanggal_penerimaan" 
                                       value="{{ old('tanggal_penerimaan', $penerimaan->tanggal_penerimaan->format('Y-m-d')) }}"
                                       required>
                                @error('tanggal_penerimaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="nama_supplier" class="form-label">Nama Supplier <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('nama_supplier') is-invalid @enderror" 
                                   id="nama_supplier" 
                                   name="nama_supplier" 
                                   value="{{ old('nama_supplier', $penerimaan->nama_supplier) }}"
                                   required>
                            @error('nama_supplier')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="id_barang" class="form-label">Pilih Barang <span class="text-danger">*</span></label>
                                <select class="form-select @error('id_barang') is-invalid @enderror" 
                                        id="id_barang" 
                                        name="id_barang" 
                                        required>
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach($barang as $item)
                                        <option value="{{ $item->id_barang }}" 
                                                {{ old('id_barang', $penerimaan->id_barang) == $item->id_barang ? 'selected' : '' }}>
                                            {{ $item->kode_barang }} - {{ $item->nama_barang }} (Stok: {{ $item->jumlah_stok }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_barang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="jumlah" class="form-label">Jumlah <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control @error('jumlah') is-invalid @enderror" 
                                       id="jumlah" 
                                       name="jumlah" 
                                       value="{{ old('jumlah', $penerimaan->jumlah) }}"
                                       min="1"
                                       required>
                                @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="lokasi_gudang" class="form-label">Lokasi Gudang <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('lokasi_gudang') is-invalid @enderror" 
                                   id="lokasi_gudang" 
                                   name="lokasi_gudang" 
                                   value="{{ old('lokasi_gudang', $penerimaan->lokasi_gudang) }}"
                                   required>
                            @error('lokasi_gudang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i>
                            <strong>Perhatian:</strong> Mengubah jumlah akan mempengaruhi stok barang secara otomatis.
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('penerimaan.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Update Penerimaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection