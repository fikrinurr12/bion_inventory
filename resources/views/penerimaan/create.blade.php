@extends('layouts.app')

@section('page-title', 'Terima Barang')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-arrow-down-circle"></i> Form Penerimaan Barang</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('penerimaan.store') }}" method="POST" id="formPenerimaan">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nomor_po" class="form-label">Nomor PO <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('nomor_po') is-invalid @enderror" 
                                       id="nomor_po" 
                                       name="nomor_po" 
                                       value="{{ old('nomor_po') }}"
                                       placeholder="Contoh: PO-2025-001"
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
                                       value="{{ old('tanggal_penerimaan', date('Y-m-d')) }}"
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
                                   value="{{ old('nama_supplier') }}"
                                   placeholder="Contoh: PT. Supplier Teknologi"
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
                                                data-kode="{{ $item->kode_barang }}"
                                                data-stok="{{ $item->jumlah_stok }}"
                                                {{ old('id_barang') == $item->id_barang ? 'selected' : '' }}>
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
                                       value="{{ old('jumlah', 1) }}"
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
                                   value="{{ old('lokasi_gudang') }}"
                                   placeholder="Contoh: Warehouse 1"
                                   required>
                            @error('lokasi_gudang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Info Box -->
                        <div id="infoBarang" class="alert alert-info d-none">
                            <h6 class="mb-2"><i class="bi bi-info-circle"></i> Informasi Barang:</h6>
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td width="150"><strong>Kode Barang:</strong></td>
                                    <td><span id="info-kode">-</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Stok Saat Ini:</strong></td>
                                    <td><span class="badge bg-secondary" id="info-stok">0</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Stok Setelah:</strong></td>
                                    <td><span class="badge bg-success" id="info-stok-baru">0</span></td>
                                </tr>
                            </table>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('penerimaan.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Proses Penerimaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const selectBarang = document.getElementById('id_barang');
    const inputJumlah = document.getElementById('jumlah');
    const infoBox = document.getElementById('infoBarang');
    
    function updateInfo() {
        const selected = selectBarang.options[selectBarang.selectedIndex];
        if (selected.value) {
            const kode = selected.dataset.kode;
            const stok = parseInt(selected.dataset.stok);
            const jumlah = parseInt(inputJumlah.value) || 0;
            const stokBaru = stok + jumlah;
            
            document.getElementById('info-kode').textContent = kode;
            document.getElementById('info-stok').textContent = stok;
            document.getElementById('info-stok-baru').textContent = stokBaru;
            
            infoBox.classList.remove('d-none');
        } else {
            infoBox.classList.add('d-none');
        }
    }
    
    selectBarang.addEventListener('change', updateInfo);
    inputJumlah.addEventListener('input', updateInfo);
</script>
@endpush
@endsection