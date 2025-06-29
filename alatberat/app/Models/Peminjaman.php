<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjamen';
    protected $primaryKey = 'id_peminjaman';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_peminjaman',
        'nama_peminjam',
        'tanggal_pinjam',
        'tanggal_kembali',
        'keperluan',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }
}

