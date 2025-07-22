<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggotas';


    protected $fillable = [
        'user_id',
        'nama',
        'nama_pt',
        'no_hp',
        'alamat_pt',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

}

