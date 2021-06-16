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
            'keterangan' => 'Poli Anak'
        ]);

        Poli::create([
            'nama' => 'Jiwa',
            'keterangan' => 'Poli Jiwa'
        ]);
    }
}
