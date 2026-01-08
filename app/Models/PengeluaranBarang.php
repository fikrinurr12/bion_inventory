<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranBarang extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran_barang';
    protected $primaryKey = 'id_pengeluaran';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pengeluaran',
        'nama_barang',
        'jumlah',
        'tujuan',
        'alasan_pengeluaran',
        'id_barang',
        'tanggal_pengeluaran',
    ];

    protected $casts = [
        'tanggal_pengeluaran' => 'date',
        'jumlah' => 'integer',
    ];

    // Relationship: Pengeluaran belongs to Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    // Relationship: Pengeluaran has many Transaksi
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_pengeluaran', 'id_pengeluaran');
    }
}