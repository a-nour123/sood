<?php

namespace App\Events;

use App\Models\PolicyAdoption;
use App\Models\PolicySignature;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PolicyAdoptionDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $policyAdoption;
    public $policySignature;

    public function __construct(PolicyAdoption $policyAdoption, PolicySignature $policySignature)
    {
        $this->policyAdoption = $policyAdoption;
        $this->policySignature = $policySignature;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}