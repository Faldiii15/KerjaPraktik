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
            $table->uuid('id')->primary();
            $table->string('kode_alat')->unique();
            $table->string('nama');
            $table->string('jenis');
            $table->string('merek');
            $table->year('tahun_pembelian');
            $table->integer('jumlah')->default(0); // jumlah stok unit alat
            $table->string('status')->default('tersedia'); // <-- Tambahkan status di sini
            $table->string('foto')->nullable(); // path file gambar
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
