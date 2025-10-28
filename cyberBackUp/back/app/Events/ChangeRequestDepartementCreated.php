<?php

namespace App\Events;

use App\Models\Department;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChangeRequestDepartementCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $responsible_department;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($responsible_department)
    {
        $this->responsible_department = $responsible_department;

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
