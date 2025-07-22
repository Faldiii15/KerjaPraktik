<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamen';

    protected $fillable = [
        'alat_id',
        'anggota_id',
        'nama_pt',
        'nama_peminjam',
        'alamat',
        'no_hp',
        'tanggal_pinjam',
        'tanggal_kembali',
        'keperluan',
        'jumlah',               
        'status_peminjaman',
        'alasan_penolakan',      
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function units()
    {
        return $this->belongsToMany(UnitAlatBerat::class, 'peminjaman_unit_alat', 'peminjaman_id', 'unit_alat_berat_id')
                    ->withTimestamps();
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'peminjaman_id');
    }

}
