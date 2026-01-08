<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_barang',
        'nama_barang',
        'kode_barang',
        'jumlah_stok',
        'harga',
        'lokasi_penyimpanan',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'jumlah_stok' => 'integer',
    ];

    // Relationship: Barang has many Penerimaan
    public function penerimaanBarang()
    {
        return $this->hasMany(PenerimaanBarang::class, 'id_barang', 'id_barang');
    }

    // Relationship: Barang has many Pengeluaran
    public function pengeluaranBarang()
    {
        return $this->hasMany(PengeluaranBarang::class, 'id_barang', 'id_barang');
    }

    // Relationship: Barang has many Transaksi
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_barang', 'id_barang');
    }
}