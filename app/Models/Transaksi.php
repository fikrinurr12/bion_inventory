<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_transaksi',
        'tipe_transaksi',
        'tanggal',
        'jumlah_barang',
        'total_harga',
        'id_barang',
        'id_penerimaan',
        'id_pengeluaran',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'total_harga' => 'decimal:2',
        'jumlah_barang' => 'integer',
    ];

    // Relationship: Transaksi belongs to Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    // Relationship: Transaksi belongs to Penerimaan
    public function penerimaan()
    {
        return $this->belongsTo(PenerimaanBarang::class, 'id_penerimaan', 'id_penerimaan');
    }

    // Relationship: Transaksi belongs to Pengeluaran
    public function pengeluaran()
    {
        return $this->belongsTo(PengeluaranBarang::class, 'id_pengeluaran', 'id_pengeluaran');
    }
}