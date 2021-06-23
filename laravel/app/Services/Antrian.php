<?php

namespace App\Services;

use App\Events\AntrianPoli;
use App\Models\AntrianObat;
use App\Models\Pasien;
use App\Models\RekamMedis;
use Carbon\Carbon;
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
        broadcast(new AntrianPoli());
    }
    public function receivePayment($rekamMedis, $data)
    {
        DB::transaction(function () use ($rekamMedis, $data) {
            $rekamMedis->update([
                'is_bayar' => true,
                'lunas_at' => Carbon::now()
            ]);
            $antrianObat = AntrianObat::where(['rekam_medis_id' => $data->id])->first();

            if ($antrianObat !== null) {
                $antrianObat->is_bayar = 1;
                $antrianObat->save();
            }
        });
        broadcast(new AntrianPoli());
        broadcast(new AntrianObat());
    }
}
