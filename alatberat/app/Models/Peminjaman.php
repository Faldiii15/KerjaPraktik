<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjamen';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'alat_id',
        'nama_pt',
        'nama_peminjam',
        'alamat',
        'tanggal_pinjam',
        'tanggal_kembali',
        'keperluan',
        'status_peminjaman',
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

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}