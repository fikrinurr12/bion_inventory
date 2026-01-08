<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengeluaran_barang', function (Blueprint $table) {
            $table->string('id_pengeluaran', 50)->primary();
            $table->string('nama_barang', 100);
            $table->integer('jumlah');
            $table->string('tujuan', 100);
            $table->string('alasan_pengeluaran', 255);
            $table->string('id_barang', 50);
            $table->date('tanggal_pengeluaran');
            $table->timestamps();

            $table->foreign('id_barang')->references('id_barang')->on('barang')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengeluaran_barang');
    }
};