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
        Schema::create('peminjamen', function (Blueprint $table) {
            $table->id(); // auto increment
            $table->foreignId('anggota_id')->nullable()->constrained('anggotas')->onDelete('cascade');
            $table->foreignId('alat_id')->constrained('alats')->onDelete('cascade');
            $table->string('nama_pt');
            $table->string('nama_peminjam');
            $table->string('alamat');
            $table->string('no_hp');
            $table->date('tanggal_pinjam')->nullable();
            $table->date('tanggal_kembali')->nullable();
            $table->unsignedInteger('jumlah'); // jumlah alat dipinjam
            $table->text('keperluan')->nullable();
            $table->text('status_peminjaman')->default('pending'); // pending, disetujui, ditolak, selesai
            $table->text('alasan_penolakan')->nullable(); // alasan jika ditolak
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};
