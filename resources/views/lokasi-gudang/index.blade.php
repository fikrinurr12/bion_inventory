@extends('layouts.app')

@section('page-title', 'Lokasi Gudang')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-geo-alt"></i> Daftar Lokasi Gudang</h5>
                <a href="{{ route('lokasi-gudang.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Lokasi
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Kode Lokasi</th>
                            <th>Nama Lokasi</th>
                            <th>Deskripsi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lokasi as $item)
                        <tr>
                            <td><code>{{ $item->kode_lokasi }}</code></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded p-2 me-2">
                                        <i class="bi bi-geo-alt text-danger"></i>
                                    </div>
                                    <strong>{{ $item->nama_lokasi }}</strong>
                                </div>
                            </td>
                            <td>{{ $item->deskripsi ?? '-' }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('lokasi-gudang.edit', $item->id_lokasi) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('lokasi-gudang.destroy', $item->id_lokasi) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus lokasi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-2">Belum ada data lokasi gudang</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $lokasi->links() }}
            </div>
        </div>
    </div>
</div>
@endsection