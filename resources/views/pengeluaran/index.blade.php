@extends('layouts.app')

@section('page-title', 'Pengeluaran Barang')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-arrow-up-circle"></i> Daftar Pengeluaran Barang</h5>
                <a href="{{ route('pengeluaran.create') }}" class="btn btn-danger">
                    <i class="bi bi-plus-circle"></i> Keluarkan Barang
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Tujuan</th>
                            <th>Alasan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengeluaran as $item)
                        <tr>
                            <td>{{ $item->tanggal_pengeluaran->format('d/m/Y') }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded p-2 me-2">
                                        <i class="bi bi-box text-danger"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $item->barang->nama_barang ?? $item->nama_barang }}</strong><br>
                                        <small class="text-muted">{{ $item->barang->kode_barang ?? '-' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-danger">{{ $item->jumlah }}</span></td>
                            <td>{{ $item->tujuan }}</td>
                            <td><small>{{ Str::limit($item->alasan_pengeluaran, 30) }}</small></td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('pengeluaran.show', $item->id_pengeluaran) }}" class="btn btn-sm btn-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('pengeluaran.edit', $item->id_pengeluaran) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('pengeluaran.destroy', $item->id_pengeluaran) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pengeluaran ini? Stok akan dikembalikan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-2">Belum ada data pengeluaran barang</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $pengeluaran->links() }}
            </div>
        </div>
    </div>
</div>
@endsection