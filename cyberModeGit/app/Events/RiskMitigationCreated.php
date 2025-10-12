<?php

namespace App\Events;

use App\Models\FrameworkControl;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Risk;
use App\Models\Mitigation;

class RiskMitigationCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $risk;
    public $mitigation;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Risk $risk, Mitigation $mitigation )
    {
        $this->risk=$risk;
        $this->mitigation=$mitigation;
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
