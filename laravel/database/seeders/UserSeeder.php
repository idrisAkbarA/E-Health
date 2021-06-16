<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'asd@asd.asd',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'name' => 'Administrator',
            'role' => 'Admin'
        ]);

        $user = User::create([
            'email' => 'asd@asd.asd',
            'username' => 'dokter',
            'password' => Hash::make('1'),
            'name' => 'Dr. Idris',
            'role' => 'Dokter'
        ]);


        User::create([
            'email' => 'asd@asd.asd',
            'username' => 'pelayanan',
            'password' => Hash::make('1'),
            'name' => 'Pelayanan'
        ]);
    }
}
