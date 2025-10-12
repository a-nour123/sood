<?php

namespace App\Events;

use App\Models\ControlControlObjective;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ControlObjectiveDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $ControlControlObjective;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ControlControlObjective $ControlControlObjective)
    {
        $this->ControlControlObjective = $ControlControlObjective;
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
