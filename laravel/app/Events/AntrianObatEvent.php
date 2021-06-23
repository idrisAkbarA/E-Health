<?php

namespace App\Events;

use App\Models\AntrianObat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AntrianObatEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Data details
     *
     * @var \App\Models\AntrianObat
     */
    public $antrianObat;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('antrian-obat');
    }

    public function broadcastWith()
    {
        return ['antrianObat' => AntrianObat::whereDate('created_at', today())
            ->with('rekam_medis')
            ->latest()
            ->get()];
    }
}
