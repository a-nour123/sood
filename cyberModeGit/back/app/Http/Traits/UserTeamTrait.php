<?php
namespace App\Http\Traits;

use App\Models\Team;
use App\Models\UserToTeam;
trait UserTeamTrait
{

    /**
     * check and manage teams with user_id
     *
     * @return true
     */
    public function UpdateTeamsOfUser($user_id, $teams)
    {
        if ($teams) {
            // get current teams with specific user_id
            $teamsCurrent = $this->GetTeamsOfUser($user_id);
            // get current teams with specific user_id
            $teamsToRemove = array_diff($teamsCurrent, $teams);
            $teamsToAdd = array_diff($teams, $teamsCurrent);

            if ($teamsToRemove) {
                $this->RemoveTeamsOfUser($user_id, $teamsToRemove);
            }

            if ($teamsToAdd) {
                $this->AddTeamsOfUser($user_id, $teamsToAdd);
            }
        }
        return true;
    }
    /**
     * get list of teams with specific user_id
     *
     * @return array
     */
    public function GetTeamsOfUser($user_id)
    {

        $teamsID = UserToTeam::where(['user_id' => $user_id])->pluck('team_id')->toarray();
        return $teamsID;
    }
    /**
     * remove list teams of specific user_id
     *
     * @return true
     */
    public function RemoveTeamsOfUser($user_id, $teams = [])
    {

        UserToTeam::where(['user_id' => $user_id])->whereIn('team_id', $teams)->delete();
        return true;
    }
    /**
     * add list teams of specific user_id
     *
     * @return true
     */
    public function AddTeamsOfUser($user_id, $teams = [])
    {
        if (!empty($teams)) {
            foreach ($teams as $team) {
                UserToTeam::create([
                    'user_id' => $user_id,
                    'team_id' => $team,
                ]);
            }
        }
        return true;
    }

    /**
     * remove  specific user_id data
     *
     * @return true
     */
    public function RemoveUserTeam($user_id)
    {

        UserToTeam::where(['user_id' => $user_id])->delete();
        return true;
    }
    /**
     * add all teams to user
     *
     * @return true
     */
    public function AllTeamToUser($user_id)
    {
        $teams = Team::all()->pluck('id')->toarray();
        $this->AddTeamsOfUser($user_id, $teams);
        return true;
    }

}
