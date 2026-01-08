@extends('layouts.app')

@section('page-title', 'Detail Pengeluaran')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-info-circle"></i> Detail Pengeluaran Barang</h5>
                        <div>
                            <a href="{{ route('pengeluaran.edit', $pengeluaran->id_pengeluaran) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Informasi Pengeluaran</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150"><strong>Tanggal:</strong></td>
                                    <td>{{ $pengeluaran->tanggal_pengeluaran->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tujuan:</strong></td>
                                    <td><span class="badge bg-info">{{ $pengeluaran->tujuan }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Alasan:</strong></td>
                                    <td>{{ $pengeluaran->alasan_pengeluaran }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Informasi Barang</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150"><strong>Kode Barang:</strong></td>
                                    <td><code>{{ $pengeluaran->barang->kode_barang ?? '-' }}</code></td>
                                </tr>
                                <tr>
                                    <td><strong>Nama Barang:</strong></td>
                                    <td>{{ $pengeluaran->barang->nama_barang ?? $pengeluaran->nama_barang }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jumlah Keluar:</strong></td>
                                    <td><span class="badge bg-danger fs-6">{{ $pengeluaran->jumlah }} unit</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Stok Saat Ini:</strong></td>
                                    <td><span class="badge bg-primary">{{ $pengeluaran->barang->jumlah_stok ?? 0 }} unit</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Total Nilai:</strong></td>
                                    <td class="text-danger fw-bold">
                                        Rp {{ number_format(($pengeluaran->barang->harga ?? 0) * $pengeluaran->jumlah, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <div class="alert alert-info">
                        <i class="bi bi-clock-history"></i>
                        <strong>Riwayat:</strong><br>
                        <small>Dibuat: {{ $pengeluaran->created_at->format('d M Y H:i') }}</small><br>
                        <small>Terakhir Update: {{ $pengeluaran->updated_at->format('d M Y H:i') }}</small>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('pengeluaran.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection