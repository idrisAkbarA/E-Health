<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $table = 'dokter';

    // Relations
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function poli()
    {
        return $this->belongsTo('App\Models\Poli');
    }
}
