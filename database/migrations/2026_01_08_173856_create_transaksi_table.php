<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->string('id_transaksi', 50)->primary();
            $table->string('tipe_transaksi', 50);
            $table->date('tanggal');
            $table->integer('jumlah_barang');
            $table->decimal('total_harga', 15, 2);
            $table->string('id_barang', 50);
            $table->string('id_penerimaan', 50)->nullable();
            $table->string('id_pengeluaran', 50)->nullable();
            $table->timestamps();

            $table->foreign('id_barang')->references('id_barang')->on('barang')->onDelete('cascade');
            $table->foreign('id_penerimaan')->references('id_penerimaan')->on('penerimaan_barang')->onDelete('set null');
            $table->foreign('id_pengeluaran')->references('id_pengeluaran')->on('pengeluaran_barang')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};