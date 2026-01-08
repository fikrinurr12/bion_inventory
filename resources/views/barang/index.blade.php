@extends('layouts.app')

@section('page-title', 'Stok Barang')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-box"></i> Daftar Barang</h5>
                <a href="{{ route('barang.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Barang
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Search & Filter -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" placeholder="Cari barang..." id="searchInput">
                    </div>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-outline-secondary w-100">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-outline-success w-100">
                        <i class="bi bi-download"></i> Export
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="50"><input type="checkbox" class="form-check-input"></th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Lokasi</th>
                            <th class="text-end">Harga</th>
                            <th class="text-center">Stok</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barang as $item)
                        <tr>
                            <td><input type="checkbox" class="form-check-input"></td>
                            <td><code>{{ $item->kode_barang }}</code></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded p-2 me-2">
                                        <i class="bi bi-box text-primary"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $item->nama_barang }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $item->lokasi_penyimpanan ?? '-' }}</td>
                            <td class="text-end">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td class="text-center">
                                @if($item->jumlah_stok < 10)
                                    <span class="badge bg-danger">{{ $item->jumlah_stok }}</span>
                                @else
                                    <span class="badge bg-success">{{ $item->jumlah_stok }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('barang.show', $item->id_barang) }}" class="btn btn-sm btn-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('barang.edit', $item->id_barang) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('barang.destroy', $item->id_barang) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
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
                                <p class="text-muted mt-2">Belum ada data barang</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    Menampilkan {{ $barang->firstItem() ?? 0 }} sampai {{ $barang->lastItem() ?? 0 }} dari {{ $barang->total() }} data
                </div>
                <div>
                    {{ $barang->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Simple search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>
@endpush
@endsection