@extends('layouts.app')

@section('page-title', 'Laporan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="bi bi-box-seam text-primary" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="card-title">Laporan Stok Barang</h4>
                    <p class="card-text text-muted">
                        Lihat laporan lengkap stok barang yang tersedia, termasuk informasi detail dan nilai total inventori.
                    </p>
                    <a href="{{ route('laporan.stok') }}" class="btn btn-primary">
                        <i class="bi bi-file-earmark-text"></i> Buka Laporan
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="bi bi-arrow-left-right text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="card-title">Laporan Transaksi</h4>
                    <p class="card-text text-muted">
                        Lihat riwayat transaksi barang masuk dan keluar dengan filter berdasarkan tanggal dan tipe transaksi.
                    </p>
                    <a href="{{ route('laporan.transaksi') }}" class="btn btn-success">
                        <i class="bi bi-file-earmark-text"></i> Buka Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-graph-up"></i> Ringkasan Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <h3 class="text-primary">{{ \App\Models\Barang::count() }}</h3>
                            <p class="text-muted">Total Jenis Barang</p>
                        </div>
                        <div class="col-md-3">
                            <h3 class="text-success">{{ \App\Models\Barang::sum('jumlah_stok') }}</h3>
                            <p class="text-muted">Total Stok</p>
                        </div>
                        <div class="col-md-3">
                            <h3 class="text-warning">{{ \App\Models\Transaksi::count() }}</h3>
                            <p class="text-muted">Total Transaksi</p>
                        </div>
                        <div class="col-md-3">
                            <h3 class="text-danger">{{ \App\Models\Barang::where('jumlah_stok', '<', 10)->count() }}</h3>
                            <p class="text-muted">Barang Stok Rendah</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection