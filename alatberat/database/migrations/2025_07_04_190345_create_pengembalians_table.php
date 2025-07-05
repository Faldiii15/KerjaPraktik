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
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('peminjaman_id')->constrained('peminjamen')->onDelete('cascade');
            $table->date('tanggal_kembali')->nullable();
            $table->string('kondisi_alat')->default('baik'); // Kondisi alat saat dikembalikan, bisa 'baik', 'rusak', atau 'hilang'
            $table->text('catatan')->nullable(); // Catatan tambahan
            $table->text('status_pengembalian')->default('pending'); // pending, diterima, ditolak
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};
