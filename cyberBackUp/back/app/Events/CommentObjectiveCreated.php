<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentObjectiveCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $comment;
    public $controlControlObjective;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\ObjectiveComment $comment
     * @param \App\Models\ControlControlObjective $controlControlObjective
     * @return void
     */
    public function __construct($comment, $controlControlObjective)
    {
        $this->comment = $comment;
        $this->controlControlObjective = $controlControlObjective;
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
