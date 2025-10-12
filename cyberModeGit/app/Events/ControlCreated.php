<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\FrameworkControlTestAudit;
use App\Models\FrameworkControlTest;
use App\Models\FrameworkControl;

class ControlCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $frameworkControlTest;
    public $control;

    

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(FrameworkControlTest $frameworkControlTest ,FrameworkControl $control  )
    {
        $this->frameworkControlTest = $frameworkControlTest;
        $this->control = $control;
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
