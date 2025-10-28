<?php

namespace App\Events;

use App\Models\Incident;
use App\Models\IncidentPlayBookAction;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class playBookCategoryIncidentAction
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public array $changedActions;

    public function __construct(array $changedActions)
    {
        $this->changedActions = $changedActions;
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