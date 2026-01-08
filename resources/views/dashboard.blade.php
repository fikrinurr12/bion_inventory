@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card stat-card primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Barang</h6>
                            <h2 class="mb-0 fw-bold">{{ $totalBarang }}</h2>
                        </div>
                        <div class="text-primary">
                            <i class="bi bi-box" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stat-card success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Stok</h6>
                            <h2 class="mb-0 fw-bold">{{ number_format($totalStok) }}</h2>
                        </div>
                        <div class="text-success">
                            <i class="bi bi-boxes" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stat-card warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Nilai</h6>
                            <h2 class="mb-0 fw-bold">Rp {{ number_format($totalNilai, 0, ',', '.') }}</h2>
                        </div>
                        <div class="text-warning">
                            <i class="bi bi-currency-dollar" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stat-card danger">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Stok Rendah</h6>
                            <h2 class="mb-0 fw-bold">{{ $barangStokRendah->count() }}</h2>
                        </div>
                        <div class="text-danger">
                            <i class="bi bi-exclamation-triangle" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Tables -->
    <div class="row">
        <!-- Chart -->
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-graph-up"></i> Laba & Pendapatan</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartTransaksi" height="80"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Categories -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-tags"></i> Kategori Penjualan Terbaik</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Analog</span>
                            <span class="text-success fw-bold">3.2%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: 32%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Digital</span>
                            <span class="text-primary fw-bold">2%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" style="width: 20%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Smartwatch</span>
                            <span class="text-warning fw-bold">1.2%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-warning" style="width: 12%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables -->
    <div class="row">
        <!-- Barang Stok Rendah -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-exclamation-triangle text-danger"></i> Barang Stok Rendah</h5>
                </div>
                <div class="card-body">
                    @if($barangStokRendah->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama Barang</th>
                                        <th class="text-end">Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($barangStokRendah as $item)
                                    <tr>
                                        <td><code>{{ $item->kode_barang }}</code></td>
                                        <td>{{ $item->nama_barang }}</td>
                                        <td class="text-end">
                                            <span class="badge bg-danger">{{ $item->jumlah_stok }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center py-4">Semua barang memiliki stok yang cukup</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Transaksi Terakhir -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-clock-history"></i> Transaksi Terakhir</h5>
                </div>
                <div class="card-body">
                    @if($transaksiTerakhir->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Tipe</th>
                                        <th>Barang</th>
                                        <th class="text-end">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transaksiTerakhir as $transaksi)
                                    <tr>
                                        <td><small>{{ $transaksi->tanggal->format('d/m/Y') }}</small></td>
                                        <td>
                                            @if($transaksi->tipe_transaksi == 'masuk')
                                                <span class="badge bg-success">Masuk</span>
                                            @else
                                                <span class="badge bg-danger">Keluar</span>
                                            @endif
                                        </td>
                                        <td>{{ $transaksi->barang->nama_barang ?? 'N/A' }}</td>
                                        <td class="text-end">{{ $transaksi->jumlah_barang }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center py-4">Belum ada transaksi</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart Transaksi
    const ctx = document.getElementById('chartTransaksi');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartData['months']),
            datasets: [{
                label: 'Penerimaan',
                data: @json($chartData['penerimaan']),
                borderColor: '#2ecc71',
                backgroundColor: 'rgba(46, 204, 113, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'Pengeluaran',
                data: @json($chartData['pengeluaran']),
                borderColor: '#e74c3c',
                backgroundColor: 'rgba(231, 76, 60, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush