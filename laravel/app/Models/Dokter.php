<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $table = 'dokter';
    protected $guarded = ['id'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['poli'];

    // Getters
    public function getPoliAttribute()
    {
        return $this->poli()->first()->nama;
    }

    // Relations
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function poli()
    {
        return $this->belongsTo('App\Models\Poli');
    }

    public function rekam_medis()
    {
        return $this->hasMany('App\Models\RekamMedis');
    }
}
