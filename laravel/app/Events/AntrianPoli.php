<?php

namespace App\Events;

use App\Models\RekamMedis;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

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
    public $pasien;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(RekamMedis $rekamMedis)
    {
        $this->rekamMedis = $rekamMedis;
        $this->pasien = $rekamMedis->pasien;
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
}
