<?php
namespace App\Http\Traits;

use App\Models\Team;
use App\Models\UserToTeam;
use Notific;
trait NotificationTeamTrait
{

    /**
     * check and manage teams with user_id
     *
     * @return true
     */
    public function sendNotificationOToUser($teams,$message,$option)
    {
        if($teams){

            $Users=$this->GetUsersOfTeam($teams);
            Notific::notify( $Users, $message, 'notification', $option, date('d F Y') );
            return true;
        }

    }
    /**
     * check and manage teams with user_id
     *
     * @return true
     */
    public function sendNotificationOToUserInOneTeam($team,$message,$option)
    {
        if($team){
            $Users=$this->GetUsersOfTeamOneTeam($team);
            Notific::notify( $Users, $message, 'notification', $option, date('d F Y') );
            return true;
        }

    }

    public function GetUsersOfTeam($teams)
    {
        $UsersID = UserToTeam::whereIn('team_id' , $teams)->pluck('user_id')->toarray();
        return $UsersID;
    }
    public function GetUsersOfTeamOneTeam($team)
    {
        $UsersID = UserToTeam::where('team_id' , $team)->pluck('user_id')->toarray();
        return $UsersID;
    }

}
