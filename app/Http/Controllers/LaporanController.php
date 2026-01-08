<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\PenerimaanBarang;
use App\Models\PengeluaranBarang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function stok(Request $request)
    {
        $query = Barang::query();

        // Filter
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('stok_min') && $request->stok_min !== null) {
            $query->where('jumlah_stok', '<=', $request->stok_min);
        }

        $barang = $query->orderBy('nama_barang')->get();

        // Statistics
        $totalBarang = $barang->count();
        $totalStok = $barang->sum('jumlah_stok');
        $totalNilai = $barang->sum(function($item) {
            return $item->jumlah_stok * $item->harga;
        });
        $stokRendah = $barang->where('jumlah_stok', '<', 10)->count();

        // Export PDF
        if ($request->has('export') && $request->export == 'pdf') {
            $pdf = PDF::loadView('laporan.stok-pdf', compact('barang', 'totalBarang', 'totalStok', 'totalNilai', 'stokRendah'));
            return $pdf->download('Laporan-Stok-Barang-' . date('Y-m-d') . '.pdf');
        }

        // Export Excel (CSV)
        if ($request->has('export') && $request->export == 'excel') {
            return $this->exportStokExcel($barang);
        }

        return view('laporan.stok', compact('barang', 'totalBarang', 'totalStok', 'totalNilai', 'stokRendah'));
    }

    public function transaksi(Request $request)
    {
        $query = Transaksi::with('barang');

        // Filter by date range
        if ($request->has('tanggal_dari') && $request->tanggal_dari) {
            $query->where('tanggal', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai) {
            $query->where('tanggal', '<=', $request->tanggal_sampai);
        }

        // Filter by type
        if ($request->has('tipe') && $request->tipe) {
            $query->where('tipe_transaksi', $request->tipe);
        }

        $transaksi = $query->orderBy('tanggal', 'desc')->get();

        // Statistics
        $totalTransaksi = $transaksi->count();
        $totalMasuk = $transaksi->where('tipe_transaksi', 'masuk')->sum('jumlah_barang');
        $totalKeluar = $transaksi->where('tipe_transaksi', 'keluar')->sum('jumlah_barang');
        $totalNilai = $transaksi->sum('total_harga');

        // Export PDF
        if ($request->has('export') && $request->export == 'pdf') {
            $pdf = PDF::loadView('laporan.transaksi-pdf', compact('transaksi', 'totalTransaksi', 'totalMasuk', 'totalKeluar', 'totalNilai'));
            $pdf->setPaper('a4', 'landscape');
            return $pdf->download('Laporan-Transaksi-' . date('Y-m-d') . '.pdf');
        }

        // Export Excel (CSV)
        if ($request->has('export') && $request->export == 'excel') {
            return $this->exportTransaksiExcel($transaksi);
        }

        return view('laporan.transaksi', compact('transaksi', 'totalTransaksi', 'totalMasuk', 'totalKeluar', 'totalNilai'));
    }

    private function exportStokExcel($barang)
    {
        $filename = 'Laporan-Stok-Barang-' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($barang) {
            $file = fopen('php://output', 'w');
            
            // UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header
            fputcsv($file, ['Kode Barang', 'Nama Barang', 'Jumlah Stok', 'Harga Satuan', 'Total Nilai', 'Lokasi']);
            
            // Data
            foreach ($barang as $item) {
                fputcsv($file, [
                    $item->kode_barang,
                    $item->nama_barang,
                    $item->jumlah_stok,
                    $item->harga,
                    $item->harga * $item->jumlah_stok,
                    $item->lokasi_penyimpanan ?? '-'
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportTransaksiExcel($transaksi)
    {
        $filename = 'Laporan-Transaksi-' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($transaksi) {
            $file = fopen('php://output', 'w');
            
            // UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header
            fputcsv($file, ['Tanggal', 'Tipe', 'Kode Barang', 'Nama Barang', 'Jumlah', 'Total Harga']);
            
            // Data
            foreach ($transaksi as $item) {
                fputcsv($file, [
                    $item->tanggal->format('d/m/Y'),
                    strtoupper($item->tipe_transaksi),
                    $item->barang->kode_barang ?? '-',
                    $item->barang->nama_barang ?? '-',
                    $item->jumlah_barang,
                    $item->total_harga
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}