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
use App\Models\Evidence;

class ControlAuditCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $audit;
    public $frameworkControl;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(FrameworkControlTestAudit $audit ,FrameworkControl $frameworkControl)
    {
        $this->audit = $audit;
        $this->frameworkControl = $frameworkControl;

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
