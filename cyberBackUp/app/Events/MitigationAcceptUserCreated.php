<?php

namespace App\Events;

use App\Models\MitigationAcceptUser;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MitigationAcceptUserCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $MitigationAcceptUser;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(MitigationAcceptUser $MitigationAcceptUser)
    {
        $this->MitigationAcceptUser=$MitigationAcceptUser;

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
