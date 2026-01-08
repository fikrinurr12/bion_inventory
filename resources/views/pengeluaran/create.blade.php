@extends('layouts.app')

@section('page-title', 'Keluarkan Barang')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-arrow-up-circle"></i> Form Pengeluaran Barang</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('pengeluaran.store') }}" method="POST" id="formPengeluaran">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_pengeluaran" class="form-label">Tanggal Pengeluaran <span class="text-danger">*</span></label>
                                <input type="date" 
                                       class="form-control @error('tanggal_pengeluaran') is-invalid @enderror" 
                                       id="tanggal_pengeluaran" 
                                       name="tanggal_pengeluaran" 
                                       value="{{ old('tanggal_pengeluaran', date('Y-m-d')) }}"
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
                                       value="{{ old('tujuan') }}"
                                       placeholder="Contoh: Proyek X / Divisi IT"
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
                                                data-kode="{{ $item->kode_barang }}"
                                                data-stok="{{ $item->jumlah_stok }}"
                                                data-harga="{{ $item->harga }}"
                                                {{ old('id_barang') == $item->id_barang ? 'selected' : '' }}>
                                            {{ $item->kode_barang }} - {{ $item->nama_barang }} (Stok: {{ $item->jumlah_stok }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_barang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($barang->count() == 0)
                                    <small class="text-danger">Tidak ada barang dengan stok tersedia!</small>
                                @endif
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
                                <small class="text-muted" id="max-stok"></small>
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
                                      placeholder="Contoh: Kebutuhan proyek instalasi jaringan client ABC"
                                      required>{{ old('alasan_pengeluaran') }}</textarea>
                            @error('alasan_pengeluaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Info Box -->
                        <div id="infoBarang" class="alert alert-warning d-none">
                            <h6 class="mb-2"><i class="bi bi-info-circle"></i> Informasi Barang:</h6>
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td width="150"><strong>Kode Barang:</strong></td>
                                    <td><span id="info-kode">-</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Stok Tersedia:</strong></td>
                                    <td><span class="badge bg-secondary" id="info-stok">0</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Stok Setelah:</strong></td>
                                    <td><span class="badge bg-danger" id="info-stok-baru">0</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Total Nilai:</strong></td>
                                    <td><span class="text-danger fw-bold" id="info-total">Rp 0</span></td>
                                </tr>
                            </table>
                        </div>

                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle"></i>
                            <strong>Perhatian:</strong> Stok barang akan berkurang secara otomatis setelah proses pengeluaran.
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('pengeluaran.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-danger" id="btnSubmit" disabled>
                                <i class="bi bi-check-circle"></i> Proses Pengeluaran
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
    const btnSubmit = document.getElementById('btnSubmit');
    const maxStok = document.getElementById('max-stok');
    
    function updateInfo() {
        const selected = selectBarang.options[selectBarang.selectedIndex];
        if (selected.value) {
            const kode = selected.dataset.kode;
            const stok = parseInt(selected.dataset.stok);
            const harga = parseFloat(selected.dataset.harga);
            const jumlah = parseInt(inputJumlah.value) || 0;
            const stokBaru = stok - jumlah;
            const total = harga * jumlah;
            
            document.getElementById('info-kode').textContent = kode;
            document.getElementById('info-stok').textContent = stok;
            document.getElementById('info-stok-baru').textContent = stokBaru;
            document.getElementById('info-total').textContent = 'Rp ' + total.toLocaleString('id-ID');
            
            // Validation
            inputJumlah.max = stok;
            maxStok.textContent = 'Maksimal: ' + stok;
            
            if (jumlah > stok || jumlah <= 0) {
                btnSubmit.disabled = true;
                infoBox.classList.remove('alert-warning');
                infoBox.classList.add('alert-danger');
                document.getElementById('info-stok-baru').classList.remove('bg-danger');
                document.getElementById('info-stok-baru').classList.add('bg-dark');
            } else {
                btnSubmit.disabled = false;
                infoBox.classList.remove('alert-danger');
                infoBox.classList.add('alert-warning');
                document.getElementById('info-stok-baru').classList.remove('bg-dark');
                document.getElementById('info-stok-baru').classList.add('bg-danger');
            }
            
            infoBox.classList.remove('d-none');
        } else {
            infoBox.classList.add('d-none');
            btnSubmit.disabled = true;
            maxStok.textContent = '';
        }
    }
    
    selectBarang.addEventListener('change', updateInfo);
    inputJumlah.addEventListener('input', updateInfo);
</script>
@endpush
@endsection