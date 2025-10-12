<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\RiskToTeam;
class RiskTeamCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $RiskToTeam;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(RiskToTeam $RiskToTeam)
    {
        $this->RiskToTeam=$RiskToTeam;
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
