<?php

namespace Database\Seeders;

use App\Models\Obat;
use Illuminate\Database\Seeder;

class ObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Obat::create([
            'nama' => 'Paracetamol Tablet',
            'bentuk' => 'Tablet',
            'satuan' => 'Butir',
            'harga' => 1500,
        ]);
    }
}
