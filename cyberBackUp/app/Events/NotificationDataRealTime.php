<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class NotificationDataRealTime implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $notificationsData;


    public function __construct($notificationsData = null)
    {
        $this->notificationsData = $notificationsData;
    }

    public function broadcastOn()
    {
        return new Channel('notifications');
    }

    // public function broadcastOn()
    // {
    //     return ['notifications'];
    // }

    public function broadcastAs()
    {
        return 'notification-updated';
    }

}
