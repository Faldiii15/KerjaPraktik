<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{ 
    protected $fillable = [
        'id',
        'judul',
        'tipe',
        'tanggal_dibuat',
        'keterangan',
    ];
}
