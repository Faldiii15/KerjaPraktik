<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitAlatBerat extends Model
{
    use HasFactory;

    protected $table = 'unit_alat_berats';
    protected $fillable = [
        'alat_id',
        'kode_alat',
        'status',
    ];

    public function alat()
    {
        return $this->belongsTo(Alat::class);
    }

    public function peminjamen()
    {
        return $this->belongsToMany(Peminjaman::class, 'peminjaman_unit_alat', 'unit_alat_berat_id', 'peminjaman_id')
                    ->withTimestamps();
    }

    public function pemeliharaans()
    {
        return $this->belongsToMany(Pemeliharaan::class, 'pemeliharaan_unit', 'unit_alat_id', 'pemeliharaan_id')
                    ->withTimestamps();
    }



}
