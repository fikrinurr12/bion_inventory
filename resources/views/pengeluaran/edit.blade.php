@extends('layouts.app')

@section('page-title', 'Edit Pengeluaran Barang')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-pencil"></i> Edit Pengeluaran Barang</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('pengeluaran.update', $pengeluaran->id_pengeluaran) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_pengeluaran" class="form-label">Tanggal Pengeluaran <span class="text-danger">*</span></label>
                                <input type="date" 
                                       class="form-control @error('tanggal_pengeluaran') is-invalid @enderror" 
                                       id="tanggal_pengeluaran" 
                                       name="tanggal_pengeluaran" 
                                       value="{{ old('tanggal_pengeluaran', $pengeluaran->tanggal_pengeluaran->format('Y-m-d')) }}"
                                       required>
                                @error('tanggal_pengeluaran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tujuan" class="form-label">Tujuan <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('tujuan') is-invalid @enderror" 
                                       id="tujuan" 
                                       name="tujuan" 
                                       value="{{ old('tujuan', $pengeluaran->tujuan) }}"
                                       required>
                                @error('tujuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
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
                                                {{ old('id_barang', $pengeluaran->id_barang) == $item->id_barang ? 'selected' : '' }}>
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
                                       value="{{ old('jumlah', $pengeluaran->jumlah) }}"
                                       min="1"
                                       required>
                                @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alasan_pengeluaran" class="form-label">Alasan Pengeluaran <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('alasan_pengeluaran') is-invalid @enderror" 
                                      id="alasan_pengeluaran" 
                                      name="alasan_pengeluaran" 
                                      rows="3"
                                      required>{{ old('alasan_pengeluaran', $pengeluaran->alasan_pengeluaran) }}</textarea>
                            @error('alasan_pengeluaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i>
                            <strong>Perhatian:</strong> Mengubah jumlah akan mempengaruhi stok barang secara otomatis.
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('pengeluaran.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-save"></i> Update Pengeluaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection