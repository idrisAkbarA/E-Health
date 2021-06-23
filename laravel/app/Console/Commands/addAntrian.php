<?php

namespace App\Console\Commands;

use App\Events\AntrianObatEvent;
use App\Events\AntrianPoli;
use App\Models\AntrianObat;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\RekamMedis;
use Illuminate\Console\Command;

class addAntrian extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'addAntrian {--dokter} {--pembayaran} {--pembayaran_obat} {--obat}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    private $pasien;
    private $rekamMedis;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->option('dokter')) {
            $this->dokter();
            return 0;
        }
        if ($this->option('pembayaran')) {
            $this->dokter();
            $rekamMedis = RekamMedis::find($this->rekamMedis->id);
            $rekamMedis->status = 1;
            $rekamMedis->dokter_id = 1;
            $rekamMedis->total_biaya = 100000;
            $rekamMedis->save();

            broadcast(new AntrianPoli());
            echo "antrian pembayaran added\n";
            return 0;
        }
        if ($this->option('pembayaran_obat')) {
            $this->dokter();
            $rekamMedis = RekamMedis::find($this->rekamMedis->id);
            $rekamMedis->status = 1;
            $rekamMedis->dokter_id = 1;
            $rekamMedis->total_biaya = 100000;
            $rekamMedis->save();
            $jumlah_obat = rand(1, 5);
            $obats = [];
            for ($i = 0; $i < $jumlah_obat; $i++) {
                array_push($obats, $this->obat());
            }
            AntrianObat::create([
                "rekam_medis_id" => $rekamMedis->id,
                "catatan" => "it is all fun and games until you taste your own medicine",
                "resep_obat" => $obats
            ]);

            broadcast(new AntrianPoli());
            broadcast(new AntrianObatEvent());
            echo "antrian pembayaran added\n";
            return 0;
        }
    }
    public function obat()
    {
        $obat = ["obat" => rand(1, 4), "jumlah" => rand(1, 50)];
        return $obat;
    }
    public function dokter()
    {
        $pasien = Pasien::inRandomOrder()->first();
        $this->pasien = $pasien;
        $rekamMedis = RekamMedis::create([
            'pasien_id' => $pasien->id,
            'poli_id' => 1,
        ]);
        $this->rekamMedis = $rekamMedis;
        broadcast(new AntrianPoli());
        echo "antrian dokter umum added";
    }
}
