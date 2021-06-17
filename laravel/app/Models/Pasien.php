<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';
    protected $guarded = [
        'id'
    ];

    // Relations
    public function rekam_medis()
    {
        return $this->hasMany('App\Models\RekamMedis');
    }
}
