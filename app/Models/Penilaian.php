<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $fillable = ['periods_id', 'alternatif_id', 'kriteria_id', 'parameter_id', 'nilai'];

    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }

    public function parameter()
    {
        return $this->belongsTo(Parameter::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }
}

