<?php

namespace App\Events;

use App\Models\ControlAuditEvidence;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EvidenceAchievementCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $controlAuditEvidence ; 
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ControlAuditEvidence $controlAuditEvidence)
    {
        $this->controlAuditEvidence=$controlAuditEvidence;
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
