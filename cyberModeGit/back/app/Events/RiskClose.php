<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Risk;
use App\Models\Closure;

class RiskClose
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $risk;
    public $close_reason;
    public $note;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Risk $risk,$close_reason,$note)
    {
        $this->risk=$risk;
        $this->close_reason=$close_reason;
        $this->note=$note;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
