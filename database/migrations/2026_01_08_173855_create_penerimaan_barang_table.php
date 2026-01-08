<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penerimaan_barang', function (Blueprint $table) {
            $table->string('id_penerimaan', 50)->primary();
            $table->string('nomor_po', 50);
            $table->string('nama_supplier', 100);
            $table->string('barang_diterima', 100);
            $table->integer('jumlah');
            $table->string('lokasi_gudang', 100);
            $table->string('id_barang', 50);
            $table->date('tanggal_penerimaan');
            $table->timestamps();

            $table->foreign('id_barang')->references('id_barang')->on('barang')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penerimaan_barang');
    }
};