<?php

namespace Database\Factories;

use App\Models\Pasien;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

class PasienFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = pasien::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create("id_ID");
        return [

            "nama" => $faker->name,
            "nik" => $faker->unique()->numerify('################'),
            "tempat_lahir" => $faker->city,
            "tanggal_lahir" => $faker->date,
            "alamat" => $faker->address,
            "jenis_kelamin" => ['Laki-Laki', 'Perempuan'][rand(0, 1)],
            "agama" => ['Islam', 'Kristen', 'Konghucu', 'Budha', 'Hindu'][rand(0, 4)],

        ];
    }
}
