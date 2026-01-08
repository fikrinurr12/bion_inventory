@extends('layouts.app')

@section('page-title', 'Laporan Stok Barang')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-box-seam"></i> Laporan Stok Barang</h5>
                <a href="{{ route('laporan.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Filter Form -->
            <form method="GET" action="{{ route('laporan.stok') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" 
                               name="search" 
                               class="form-control" 
                               placeholder="Cari nama/kode barang..."
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="stok_min" class="form-select">
                            <option value="">Semua Stok</option>
                            <option value="10" {{ request('stok_min') == '10' ? 'selected' : '' }}>Stok Rendah (≤10)</option>
                            <option value="5" {{ request('stok_min') == '5' ? 'selected' : '' }}>Stok Kritis (≤5)</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <div class="btn-group w-100" role="group">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i> Filter
                            </button>
                            <a href="{{ route('laporan.stok') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Reset
                            </a>
                            <a href="{{ route('laporan.stok', array_merge(request()->all(), ['export' => 'pdf'])) }}" 
                               class="btn btn-danger"
                               target="_blank">
                                <i class="bi bi-file-pdf"></i> PDF
                            </a>
                            <a href="{{ route('laporan.stok', array_merge(request()->all(), ['export' => 'excel'])) }}" 
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
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h6>Total Jenis Barang</h6>
                            <h3>{{ $totalBarang }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h6>Total Stok</h6>
                            <h3>{{ number_format($totalStok) }}</h3>
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
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h6>Stok Rendah</h6>
                            <h3>{{ $stokRendah }}</h3>
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
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th class="text-center">Stok</th>
                            <th class="text-end">Harga Satuan</th>
                            <th class="text-end">Total Nilai</th>
                            <th>Lokasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barang as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td><code>{{ $item->kode_barang }}</code></td>
                            <td>{{ $item->nama_barang }}</td>
                            <td class="text-center">
                                @if($item->jumlah_stok < 10)
                                    <span class="badge bg-danger">{{ $item->jumlah_stok }}</span>
                                @else
                                    <span class="badge bg-success">{{ $item->jumlah_stok }}</span>
                                @endif
                            </td>
                            <td class="text-end">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($item->harga * $item->jumlah_stok, 0, ',', '.') }}</td>
                            <td>{{ $item->lokasi_penyimpanan ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="3" class="text-end">TOTAL:</th>
                            <th class="text-center">{{ number_format($totalStok) }}</th>
                            <th></th>
                            <th class="text-end">Rp {{ number_format($totalNilai, 0, ',', '.') }}</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection