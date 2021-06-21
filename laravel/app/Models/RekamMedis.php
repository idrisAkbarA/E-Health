<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis';
    protected $guarded = ['id'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['nama_poli', 'nama_pasien'];

    // Getters
    public function getNamaPoliAttribute()
    {
        return $this->poli()->first()->nama;
    }

    public function getNamaPasienAttribute()
    {
        return $this->pasien()->first()->nama;
    }

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

    public function antrian_obat()
    {
        return $this->hasOne('App\Models\AntrianObat');
    }
}
