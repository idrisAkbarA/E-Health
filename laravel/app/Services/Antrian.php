<?php

namespace App\Services;

use App\Models\Pasien;
use App\Models\RekamMedis;
use Illuminate\Support\Facades\DB;

class Antrian
{
    public function storePasienAddQueue($data)
    {
        DB::transaction(function () use ($data) {
            $pasien = Pasien::create($data);
            RekamMedis::create([
                'pasien_id' => $pasien->id,
                'poli_id' => $data['poli_id']
            ]);
        });
    }
}
