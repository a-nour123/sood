<?php

namespace App\Events;

use App\Models\KPI;
use App\Models\KPIAssessment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class initiateAssessmentKpiValue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $assessment;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(KPIAssessment $assessment)
    {
        $this->assessment = $assessment;

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
