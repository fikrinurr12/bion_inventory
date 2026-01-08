@extends('layouts.app')

@section('page-title', 'Detail Penerimaan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-info-circle"></i> Detail Penerimaan Barang</h5>
                        <div>
                            <a href="{{ route('penerimaan.edit', $penerimaan->id_penerimaan) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Informasi Penerimaan</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150"><strong>No. PO:</strong></td>
                                    <td><code>{{ $penerimaan->nomor_po }}</code></td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal:</strong></td>
                                    <td>{{ $penerimaan->tanggal_penerimaan->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Supplier:</strong></td>
                                    <td>{{ $penerimaan->nama_supplier }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Lokasi:</strong></td>
                                    <td><i class="bi bi-geo-alt text-danger"></i> {{ $penerimaan->lokasi_gudang }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Informasi Barang</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150"><strong>Kode Barang:</strong></td>
                                    <td><code>{{ $penerimaan->barang->kode_barang ?? '-' }}</code></td>
                                </tr>
                                <tr>
                                    <td><strong>Nama Barang:</strong></td>
                                    <td>{{ $penerimaan->barang->nama_barang ?? $penerimaan->barang_diterima }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jumlah Diterima:</strong></td>
                                    <td><span class="badge bg-success fs-6">{{ $penerimaan->jumlah }} unit</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Stok Saat Ini:</strong></td>
                                    <td><span class="badge bg-primary">{{ $penerimaan->barang->jumlah_stok ?? 0 }} unit</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <div class="alert alert-info">
                        <i class="bi bi-clock-history"></i>
                        <strong>Riwayat:</strong><br>
                        <small>Dibuat: {{ $penerimaan->created_at->format('d M Y H:i') }}</small><br>
                        <small>Terakhir Update: {{ $penerimaan->updated_at->format('d M Y H:i') }}</small>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('penerimaan.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection