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
    protected $appends = ['poli', 'nama'];

    // Getters
    public function getPoliAttribute()
    {
        return $this->poli()->first()->nama;
    }

    public function getNamaAttribute()
    {
        return $this->user()->first()->name;
    }

    public function getPendidikanAttribute($value)
    {
        return json_decode($value);
    }

    // Setters
    public function setPendidikanAttribute($value)
    {
        foreach($value as $index => $row){
            if(!$row){
                unset($value[$index]);
            }
        }
        return $this->attributes['pendidikan'] = json_encode($value);
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
