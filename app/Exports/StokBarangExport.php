<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StokBarangExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $barang;

    public function __construct($barang)
    {
        $this->barang = $barang;
    }

    public function collection()
    {
        return $this->barang;
    }

    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'Jumlah Stok',
            'Harga Satuan',
            'Total Nilai',
            'Lokasi',
        ];
    }

    public function map($barang): array
    {
        return [
            $barang->kode_barang,
            $barang->nama_barang,
            $barang->jumlah_stok,
            $barang->harga,
            $barang->harga * $barang->jumlah_stok,
            $barang->lokasi_penyimpanan ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}