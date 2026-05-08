<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_alternatif',
        'nama_alternatif',
    ];

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class);
    }

    public function hasilPerhitungan()
    {
        return $this->hasMany(HasilPerhitungan::class, 'alternatif_id');
    }
}
