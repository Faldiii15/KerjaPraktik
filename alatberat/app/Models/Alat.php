<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'jenis',
        'merek',
        'kapasitas',
        'tahun_pembelian',
        'status',
        'lokasi',
        'gambar'
    ];
}