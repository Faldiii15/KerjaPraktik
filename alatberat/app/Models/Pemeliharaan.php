<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Alat;
use App\Models\UnitAlatBerat;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Pemeliharaan extends Model
{
    use HasFactory;
    protected $table = 'pemeliharaans';

    protected $fillable = [
        'alat_id',   // foreign key
        'tanggal',
        'status',
        'teknisi',
        'catatan',
        'jumlah_unit',    
        'biaya_pemeliharaan',
    ];
    
    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id', 'id');
    }

    public function units()
    {
        return $this->belongsToMany(UnitAlatBerat::class, 'pemeliharaan_unit', 'pemeliharaan_id', 'unit_alat_id');
    }

}
