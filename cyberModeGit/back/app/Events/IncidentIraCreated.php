<?php

namespace App\Events;

use App\Models\Incident;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class IncidentIraCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $incident;
    public $type;
    public $users;
    

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Incident $incident,$type,$users)
    {
        $this->incident = $incident;
        $this->type = $type;
        $this->users = $users;
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
