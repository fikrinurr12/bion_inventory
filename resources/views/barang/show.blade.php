@extends('layouts.app')

@section('page-title', 'Detail Barang')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-info-circle"></i> Detail Barang</h5>
                        <div>
                            <a href="{{ route('barang.edit', $barang->id_barang) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('barang.destroy', $barang->id_barang) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center mb-4">
                            <div class="bg-light rounded p-4">
                                <i class="bi bi-box text-primary" style="font-size: 5rem;"></i>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <h3 class="mb-3">{{ $barang->nama_barang }}</h3>
                            
                            <table class="table table-borderless">
                                <tr>
                                    <td width="200"><strong>Kode Barang</strong></td>
                                    <td><code class="fs-6">{{ $barang->kode_barang }}</code></td>
                                </tr>
                                <tr>
                                    <td><strong>Jumlah Stok</strong></td>
                                    <td>
                                        @if($barang->jumlah_stok < 10)
                                            <span class="badge bg-danger fs-6">{{ $barang->jumlah_stok }} unit</span>
                                        @else
                                            <span class="badge bg-success fs-6">{{ $barang->jumlah_stok }} unit</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Harga Satuan</strong></td>
                                    <td class="text-success fw-bold fs-5">Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total Nilai</strong></td>
                                    <td class="text-primary fw-bold">Rp {{ number_format($barang->harga * $barang->jumlah_stok, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Lokasi Penyimpanan</strong></td>
                                    <td>
                                        <i class="bi bi-geo-alt text-danger"></i> 
                                        {{ $barang->lokasi_penyimpanan ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Dibuat</strong></td>
                                    <td>{{ $barang->created_at->format('d M Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Terakhir Update</strong></td>
                                    <td>{{ $barang->updated_at->format('d M Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Riwayat Transaksi -->
                    <h5 class="mb-3"><i class="bi bi-clock-history"></i> Riwayat Transaksi</h5>
                    @if($barang->transaksi->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Tipe</th>
                                        <th class="text-end">Jumlah</th>
                                        <th class="text-end">Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($barang->transaksi->take(10) as $trans)
                                    <tr>
                                        <td>{{ $trans->tanggal->format('d/m/Y') }}</td>
                                        <td>
                                            @if($trans->tipe_transaksi == 'masuk')
                                                <span class="badge bg-success">Masuk</span>
                                            @else
                                                <span class="badge bg-danger">Keluar</span>
                                            @endif
                                        </td>
                                        <td class="text-end">{{ $trans->jumlah_barang }}</td>
                                        <td class="text-end">Rp {{ number_format($trans->total_harga, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center py-4">Belum ada transaksi untuk barang ini</p>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('barang.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection