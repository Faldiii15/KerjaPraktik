<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalians';
    // protected $primaryKey = 'id';


    protected $fillable = [
        'peminjaman_id',
        'tanggal_kembali',
        'kondisi_alat', // Kondisi alat saat dikembalikan, bisa 'baik', 'rusak', atau 'hilang'
        'catatan',
        'status_pengembalian',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class , 'peminjaman_id');
    }
}
    