<?php

namespace App\Events;

use App\Models\RekamMedis;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AntrianPoli implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Data details
     *
     * @var \App\Models\RekamMedis
     * @var \App\Models\Pasien
     */
    public $rekamMedis;
    // public $pasien;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        // old code
        // $this->rekamMedis = $rekamMedis;
        // $this->pasien = $rekamMedis->pasien;
        // Log::info('broadcasting');
        // $this->rekamMedis = RekamMedis::whereDate('created_at', today())->with('pasien')->latest()->get();


    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('antrian-poli');
    }
    public function broadcastWith()
    {
        return ['rekamMedis' => RekamMedis::whereDate('created_at', today())
            ->with('pasien')
            ->latest()
            ->get()];
    }
}
