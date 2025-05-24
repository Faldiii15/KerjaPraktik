<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alats', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->string('jenis');
            $table->string('merek');
            $table->string('kapasitas');
            $table->string('tahun_pembelian');
            $table->enum('status', ['Tersedia', 'Rusak', 'Dipinjam']);
            $table->string('lokasi');
            $table->string('gambar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alats');
    }
};
