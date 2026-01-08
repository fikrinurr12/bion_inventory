@extends('layouts.app')

@section('page-title', 'Laporan Transaksi')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-arrow-left-right"></i> Laporan Transaksi</h5>
                <a href="{{ route('laporan.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Filter Form -->
            <form method="GET" action="{{ route('laporan.transaksi') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Dari</label>
                        <input type="date" 
                               name="tanggal_dari" 
                               class="form-control"
                               value="{{ request('tanggal_dari') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Sampai</label>
                        <input type="date" 
                               name="tanggal_sampai" 
                               class="form-control"
                               value="{{ request('tanggal_sampai') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Tipe</label>
                        <select name="tipe" class="form-select">
                            <option value="">Semua</option>
                            <option value="masuk" {{ request('tipe') == 'masuk' ? 'selected' : '' }}>Masuk</option>
                            <option value="keluar" {{ request('tipe') == 'keluar' ? 'selected' : '' }}>Keluar</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">&nbsp;</label>
                        <div class="btn-group w-100" role="group">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i> Filter
                            </button>
                            <a href="{{ route('laporan.transaksi') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Reset
                            </a>
                            <a href="{{ route('laporan.transaksi', array_merge(request()->all(), ['export' => 'pdf'])) }}" 
                               class="btn btn-danger"
                               target="_blank">
                                <i class="bi bi-file-pdf"></i> PDF
                            </a>
                            <a href="{{ route('laporan.transaksi', array_merge(request()->all(), ['export' => 'excel'])) }}" 
                               class="btn btn-success">
                                <i class="bi bi-file-excel"></i> Excel
                            </a>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h6>Total Transaksi</h6>
                            <h3>{{ $totalTransaksi }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h6>Total Masuk</h6>
                            <h3>{{ number_format($totalMasuk) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h6>Total Keluar</h6>
                            <h3>{{ number_format($totalKeluar) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <h6>Total Nilai</h6>
                            <h3>Rp {{ number_format($totalNilai, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Tanggal</th>
                            <th>Tipe</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksi as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                            <td>
                                @if($item->tipe_transaksi == 'masuk')
                                    <span class="badge bg-success">MASUK</span>
                                @else
                                    <span class="badge bg-danger">KELUAR</span>
                                @endif
                            </td>
                            <td><code>{{ $item->barang->kode_barang ?? '-' }}</code></td>
                            <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                            <td class="text-center">{{ $item->jumlah_barang }}</td>
                            <td class="text-end">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="5" class="text-end">TOTAL:</th>
                            <th class="text-center">{{ $totalMasuk + $totalKeluar }}</th>
                            <th class="text-end">Rp {{ number_format($totalNilai, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection