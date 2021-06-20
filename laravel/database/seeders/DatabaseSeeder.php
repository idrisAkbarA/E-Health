<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PoliSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PasienSeeder::class);
        $this->call(ObatSeeder::class);
    }
}
