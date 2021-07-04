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
            'username' => 'admin',
            'password' => 'asd',
            'name' => 'Administrator',
            'role' => 'Admin'
        ]);

        $user = User::create([
            'username' => 'dokter',
            'password' => '1',
            'name' => 'Dr. Idris',
            'role' => 'Dokter'
        ]);
        $user->dokter()->create([
            'poli_id' => 1,
            'tempat_tanggal_lahir' => 'Pekanbaru, 16 Juli 1999',
            'jenis_kelamin' => 'Laki-Laki',
            'agama' => 'Islam',
            'pendidikan' => ["S1 Pendidikan Dokter", "S2 Kedokteran Anak"],
            'spesialis' => 'Anak',
            'is_aktif' => 1
        ]);

        User::create([
            'username' => 'pelayanan',
            'password' => '1',
            'name' => 'Pelayanan',
            'role' => 'Pelayanan'
        ]);

        User::create([
            'username' => 'kasir',
            'password' => '1',
            'name' => 'Kasir',
            'role' => 'Kasir'
        ]);

        User::create([
            'username' => 'kepala',
            'password' => '1',
            'name' => 'Kepala Instansi',
            'role' => 'Kepala Instansi'
        ]);

        User::create([
            'username' => 'apoteker',
            'password' => '1',
            'name' => 'Apoteker',
            'role' => 'Apoteker'
        ]);
    }
}
