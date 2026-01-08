<!DOCTYPE html>
<html>
<head>
    <title>Laporan Stok Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 5px 0;
        }
        .stats {
            margin: 20px 0;
            border: 1px solid #ddd;
            padding: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        table th {
            background-color: #343a40;
            color: white;
        }
        .text-center {
            text-align: center;
        }
        .text-end {
            text-align: right;
        }
        .badge-danger {
            background-color: #dc3545;
            color: white;
            padding: 3px 8px;
            border-radius: 3px;
        }
        .badge-success {
            background-color: #28a745;
            color: white;
            padding: 3px 8px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>PT BION DIGITAL INDONESIA</h2>
        <h3>LAPORAN STOK BARANG</h3>
        <p>Tanggal Cetak: {{ date('d F Y') }}</p>
    </div>

    <div class="stats">
        <strong>Ringkasan:</strong><br>
        Total Jenis Barang: {{ $totalBarang }} | 
        Total Stok: {{ number_format($totalStok) }} | 
        Total Nilai: Rp {{ number_format($totalNilai, 0, ',', '.') }} |
        Stok Rendah: {{ $stokRendah }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Total Nilai</th>
                <th>Lokasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barang as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->kode_barang }}</td>
                <td>{{ $item->nama_barang }}</td>
                <td class="text-center">{{ $item->jumlah_stok }}</td>
                <td class="text-end">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                <td class="text-end">Rp {{ number_format($item->harga * $item->jumlah_stok, 0, ',', '.') }}</td>
                <td>{{ $item->lokasi_penyimpanan ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">TOTAL:</th>
                <th class="text-center">{{ number_format($totalStok) }}</th>
                <th></th>
                <th class="text-end">Rp {{ number_format($totalNilai, 0, ',', '.') }}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</body>
</html>