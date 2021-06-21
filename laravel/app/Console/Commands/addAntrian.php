<?php

namespace App\Console\Commands;

use App\Events\AntrianPoli;
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
    protected $signature = 'addAntrian {--dokter} {--pembayaran} {--obat}';

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
