<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Risk;

class RiskResetMitigation
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $risk;
    public $resetRiskReviews;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Risk $risk,$resetRiskReviews)
    {
        $this->risk=$risk;
        $this->resetRiskReviews=$resetRiskReviews;

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
