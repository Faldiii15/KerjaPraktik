<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemeliharaans', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('alat_id')->constrained('alats')->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('status', ['Proses', 'Selesai'])->default('Proses');
            $table->string('teknisi')->nullable();
            $table->text('catatan')->nullable();
            $table->integer('jumlah_unit')->default(1); // Jumlah alat yang diperbaiki
            $table->integer('biaya_pemeliharaan')->nullable(); // Biaya total (dalam rupiah)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeliharaans');
    }
};
