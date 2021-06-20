<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntrianObat extends Model
{
    use HasFactory;

    protected $table = 'antrian_obat';
    protected $guarded = ['id'];

    // Getters
    public function getResepObatAttribute($value)
    {
        return json_decode($value);
    }

    // Setters
    public function setResepObatAttribute($value)
    {
        $harga = 0;
        $resep = [];
        foreach ($value as $row) {
            $obat = Obat::find($row['obat']);
            $row['obat'] = $obat;
            array_push($resep, $row);
            $harga += $obat->harga * $row['jumlah'];
        }
        $this->attributes['resep_obat'] = json_encode($resep);
        $this->attributes['total_harga'] = $harga;
    }

    // Relations
    public function rekam_medis()
    {
        return $this->belongsTo('App\Models\RekamMedis');
    }
}
