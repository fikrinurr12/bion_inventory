<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransaksiExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $transaksi;

    public function __construct($transaksi)
    {
        $this->transaksi = $transaksi;
    }

    public function collection()
    {
        return $this->transaksi;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Tipe',
            'Kode Barang',
            'Nama Barang',
            'Jumlah',
            'Total Harga',
        ];
    }

    public function map($transaksi): array
    {
        return [
            $transaksi->tanggal->format('d/m/Y'),
            strtoupper($transaksi->tipe_transaksi),
            $transaksi->barang->kode_barang ?? '-',
            $transaksi->barang->nama_barang ?? '-',
            $transaksi->jumlah_barang,
            $transaksi->total_harga,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}