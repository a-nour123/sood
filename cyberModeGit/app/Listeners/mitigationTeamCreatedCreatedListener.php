<?php

namespace App\Listeners;

use App\Events\mitigationTeamCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notific;
use App\Http\Traits\NotificationTeamTrait;
class mitigationTeamCreatedCreatedListener
{
    use NotificationTeamTrait;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\mitigationTeamCreated  $event
     * @return void
     */
    public function handle(mitigationTeamCreated $event)
    {
        $MitigationToTeam=$event->MitigationToTeam;
        if($MitigationToTeam->team_id){
            $message=__('locale.NotificationCreatedMitigation');

            $this->sendNotificationOToUserInOneTeam($MitigationToTeam->team_id , $message,[]);
        }
    }
}
