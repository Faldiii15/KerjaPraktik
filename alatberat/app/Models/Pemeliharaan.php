<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Alat;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemeliharaan extends Model
{
    use HasFactory;
    protected $table = 'pemeliharaans';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'alat_id',   // foreign key
        'tanggal',
        'status',
        'teknisi',
        'catatan',
        'jumlah_unit',    
        'biaya_pemeliharaan',
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
}
