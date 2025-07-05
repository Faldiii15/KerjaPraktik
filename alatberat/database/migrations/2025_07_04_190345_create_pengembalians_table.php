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
            $table->enum('kondisi_alat', ['baik', 'rusak', 'hilang'])->default('baik');
            $table->text('catatan')->nullable();
            $table->enum('status_pengembalian', ['pending', 'Diterima', 'ditolak'])->default('pending');
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
