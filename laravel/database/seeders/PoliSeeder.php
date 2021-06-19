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
            'nama' => 'Umum',
            'penanggungjawab' => 'Dr. Stanger',
            'keterangan' => 'Poli Umum adalah layanan pemeriksaan dan pengobatan umum.'
        ]);

        Poli::create([
            'nama' => 'Anak',
            'penanggungjawab' => 'Dr. Idris',
            'keterangan' => 'Poli Spesialis Anak adalah layanan pemeriksaan dan pengobatan terhadap bayi dan anak.'
        ]);

        Poli::create([
            'nama' => 'Jiwa',
            'penanggungjawab' => 'Dr. Stone',
            'keterangan' => 'Poli Spesialis Anak adalah layanan pemeriksaan dan pengobatan kondisi kejiwaan.'
        ]);
    }
}
