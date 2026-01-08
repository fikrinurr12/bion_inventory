@extends('layouts.app')

@section('page-title', 'Penerimaan Barang')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-arrow-down-circle"></i> Daftar Penerimaan Barang</h5>
                <a href="{{ route('penerimaan.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Terima Barang
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>No. PO</th>
                            <th>Tanggal</th>
                            <th>Supplier</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Lokasi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penerimaan as $item)
                        <tr>
                            <td><code>{{ $item->nomor_po }}</code></td>
                            <td>{{ $item->tanggal_penerimaan->format('d/m/Y') }}</td>
                            <td>{{ $item->nama_supplier }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded p-2 me-2">
                                        <i class="bi bi-box text-success"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $item->barang->nama_barang ?? $item->barang_diterima }}</strong><br>
                                        <small class="text-muted">{{ $item->barang->kode_barang ?? '-' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-success">{{ $item->jumlah }}</span></td>
                            <td>{{ $item->lokasi_gudang }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('penerimaan.show', $item->id_penerimaan) }}" class="btn btn-sm btn-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('penerimaan.edit', $item->id_penerimaan) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('penerimaan.destroy', $item->id_penerimaan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus penerimaan ini? Stok akan dikurangi.')">
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
                            <td colspan="7" class="text-center py-4">
                                <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-2">Belum ada data penerimaan barang</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $penerimaan->links() }}
            </div>
        </div>
    </div>
</div>
@endsection