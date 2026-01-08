<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
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
            padding: 6px;
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
        .badge-success {
            background-color: #28a745;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
        }
        .badge-danger {
            background-color: #dc3545;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>PT BION DIGITAL INDONESIA</h2>
        <h3>LAPORAN TRANSAKSI</h3>
        <p>Tanggal Cetak: {{ date('d F Y') }}</p>
    </div>

    <div class="stats">
        <strong>Ringkasan:</strong><br>
        Total Transaksi: {{ $totalTransaksi }} | 
        Total Masuk: {{ number_format($totalMasuk) }} | 
        Total Keluar: {{ number_format($totalKeluar) }} |
        Total Nilai: Rp {{ number_format($totalNilai, 0, ',', '.') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Tipe</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                <td class="text-center">{{ strtoupper($item->tipe_transaksi) }}</td>
                <td>{{ $item->barang->kode_barang ?? '-' }}</td>
                <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                <td class="text-center">{{ $item->jumlah_barang }}</td>
                <td class="text-end">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-end">TOTAL:</th>
                <th class="text-center">{{ $totalMasuk + $totalKeluar }}</th>
                <th class="text-end">Rp {{ number_format($totalNilai, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>