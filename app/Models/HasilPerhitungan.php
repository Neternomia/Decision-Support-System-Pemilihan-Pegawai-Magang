<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPerhitungan extends Model
{
    use HasFactory;

    protected $table = 'hasil_perhitungan'; // Nama tabel di database

    protected $fillable = [
        'alternatif_id',
        'period_id',
        'nilai_akhir',
        'ranking',
    ];

    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class, 'alternatif_id');
    }
}
