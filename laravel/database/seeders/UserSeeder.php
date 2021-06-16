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
            'password' => Hash::make('asd'),
            'name' => 'Administrator',
            'role' => 'Admin'
        ]);

        $user = User::create([
            'email' => 'dokter@gmail.com',
            'username' => 'dokter',
            'password' => Hash::make('1'),
            'name' => 'Dr. Idris',
            'role' => 'Dokter'
        ]);
        $user->dokter()->create([
            'poli_id' => 1,
            'tempat_tanggal_lahir' => 'Pekanbaru 16 Juli 1999',
            'jenis_kelamin' => 'Laki-Laki',
            'agama' => 'Islam',
            'pendidikan' => '["S1 Pendidikan Dokter", "S2 Kedokteran Anak"]',
            'spesialis' => 'Anak',
            'is_aktif' => 1
        ]);

        User::create([
            'email' => '2@asd.asd',
            'username' => 'pelayanan',
            'password' => Hash::make('1'),
            'name' => 'Pelayanan',
            'role' => 'Pelayanan'
        ]);

        User::create([
            'email' => '3@asd.asd',
            'username' => 'kasir',
            'password' => Hash::make('1'),
            'name' => 'Kasir',
            'role' => 'Kasir'
        ]);

        User::create([
            'email' => '4@asd.asd',
            'username' => 'kepala',
            'password' => Hash::make('1'),
            'name' => 'Kepala Instansi',
            'role' => 'Kepala Instansi'
        ]);
        User::create([
            'email' => '5@asd.asd',
            'username' => 'apoteker',
            'password' => Hash::make('1'),
            'name' => 'Apoteker',
            'role' => 'Apoteker'
        ]);
    }
}
