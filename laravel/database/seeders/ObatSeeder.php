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
        $items = [
            [
                'nama' => 'Paracetamol Tablet',
                'bentuk' => 'Tablet',
                'satuan' => 'Butir',
                'harga' => 1500,
            ],
            [
                'nama' => 'Acetaminophen',
                'bentuk' => 'Kaplet',
                'satuan' => 'gram',
                'harga' => 5500,
            ],
            [
                'nama' => 'Bodrexin',
                'bentuk' => 'Kapsul',
                'satuan' => 'gram',
                'harga' => 9500,
            ],
            [
                'nama' => 'Antalgin',
                'bentuk' => 'Kaplet',
                'satuan' => 'gram',
                'harga' => 10500,
            ],
        ];
        foreach ($items as $item) {
            Obat::create($item);
        }
    }
}
