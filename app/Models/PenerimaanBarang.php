<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerimaanBarang extends Model
{
    use HasFactory;

    protected $table = 'penerimaan_barang';
    protected $primaryKey = 'id_penerimaan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_penerimaan',
        'nomor_po',
        'nama_supplier',
        'barang_diterima',
        'jumlah',
        'lokasi_gudang',
        'id_barang',
        'tanggal_penerimaan',
    ];

    protected $casts = [
        'tanggal_penerimaan' => 'date',
        'jumlah' => 'integer',
    ];

    // Relationship: Penerimaan belongs to Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    // Relationship: Penerimaan has many Transaksi
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_penerimaan', 'id_penerimaan');
    }
}