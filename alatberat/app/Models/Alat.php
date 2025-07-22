<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    use HasFactory;
    protected $table = 'alats';

    protected $fillable = [
        'nama',
        'jenis',
        'merek',
        'tahun_pembelian',
        'foto',
    ];
    public function units()
    {
        return $this->hasMany(UnitAlatBerat::class);
    }

    public function tersediaUnits()
    {
        return $this->hasMany(UnitAlatBerat::class)->where('status', 'tersedia');
    }

}