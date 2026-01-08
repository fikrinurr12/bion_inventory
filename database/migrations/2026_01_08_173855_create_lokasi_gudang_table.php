<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lokasi_gudang', function (Blueprint $table) {
            $table->string('id_lokasi', 50)->primary();
            $table->string('nama_lokasi', 100);
            $table->string('kode_lokasi', 50)->unique();
            $table->string('deskripsi', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lokasi_gudang');
    }
};