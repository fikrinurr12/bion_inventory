<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->string('id_barang', 50)->primary();
            $table->string('nama_barang', 100);
            $table->string('kode_barang', 50)->unique();
            $table->integer('jumlah_stok')->default(0);
            $table->decimal('harga', 15, 2)->default(0);
            $table->string('lokasi_penyimpanan', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};