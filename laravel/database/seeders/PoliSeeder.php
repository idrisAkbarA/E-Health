<?php

namespace Database\Seeders;

use App\Models\Poli;
use Illuminate\Database\Seeder;

class PoliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Poli::create([
            'nama' => 'Anak',
            'keterangan' => 'Poli Spesialis Anak adalah layanan pemeriksaan dan pengobatan terhadap bayi dan anak.'
        ]);

        Poli::create([
            'nama' => 'Jiwa',
            'keterangan' => 'Poli Spesialis Anak adalah layanan pemeriksaan dan pengobatan kondisi kejiwaan.'
        ]);
    }
}
