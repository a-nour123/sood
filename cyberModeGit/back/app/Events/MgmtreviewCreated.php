<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\MgmtReview;
use App\Models\Risk;

class MgmtreviewCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $mgmtReview;
    public $risk;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(MgmtReview $mgmtReview, Risk $risk)
    {
        $this->mgmtReview=$mgmtReview;
        $this->risk=$risk;        
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
