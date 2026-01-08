<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\PenerimaanBarang;
use App\Models\PengeluaranBarang;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Barang
        $totalBarang = Barang::count();
        
        // Total Stok
        $totalStok = Barang::sum('jumlah_stok');
        
        // Total Nilai Inventori
        $totalNilai = Barang::sum(DB::raw('jumlah_stok * harga'));
        
        // Penerimaan Bulan Ini
        $penerimaanBulanIni = PenerimaanBarang::whereMonth('tanggal_penerimaan', date('m'))
            ->whereYear('tanggal_penerimaan', date('Y'))
            ->sum('jumlah');
        
        // Pengeluaran Bulan Ini
        $pengeluaranBulanIni = PengeluaranBarang::whereMonth('tanggal_pengeluaran', date('m'))
            ->whereYear('tanggal_pengeluaran', date('Y'))
            ->sum('jumlah');
        
        // Barang dengan Stok Rendah (< 10)
        $barangStokRendah = Barang::where('jumlah_stok', '<', 10)
            ->orderBy('jumlah_stok', 'asc')
            ->limit(5)
            ->get();
        
        // Transaksi Terakhir
        $transaksiTerakhir = Transaksi::with('barang')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Data untuk Chart (6 bulan terakhir)
        $chartData = $this->getChartData();
        
        return view('dashboard', compact(
            'totalBarang',
            'totalStok',
            'totalNilai',
            'penerimaanBulanIni',
            'pengeluaranBulanIni',
            'barangStokRendah',
            'transaksiTerakhir',
            'chartData'
        ));
    }
    
    private function getChartData()
    {
        $months = [];
        $penerimaan = [];
        $pengeluaran = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M');
            
            $penerimaan[] = PenerimaanBarang::whereMonth('tanggal_penerimaan', $date->month)
                ->whereYear('tanggal_penerimaan', $date->year)
                ->sum('jumlah');
            
            $pengeluaran[] = PengeluaranBarang::whereMonth('tanggal_pengeluaran', $date->month)
                ->whereYear('tanggal_pengeluaran', $date->year)
                ->sum('jumlah');
        }
        
        return [
            'months' => $months,
            'penerimaan' => $penerimaan,
            'pengeluaran' => $pengeluaran,
        ];
    }
}