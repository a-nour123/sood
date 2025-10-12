<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\SecurityAwareness;

class SecurityAwarenesAdd
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $securityAwareness;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(SecurityAwareness $securityAwareness)
    {
        $this->securityAwareness=$securityAwareness;
        // dd($securityAwareness);
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
