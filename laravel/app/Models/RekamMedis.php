<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis';
    protected $guarded = ['id'];

    // Relations
    public function pasien()
    {
        return $this->belongsTo('App\Models\Pasien');
    }

    public function dokter()
    {
        return $this->belongsTo('App\Models\Dokter');
    }

    public function poli()
    {
        return $this->belongsTo('App\Models\Poli');
    }

    public function resep_obat()
    {
        return $this->hasOne('App\Models\AntrianObat');
    }
}
