<?php
namespace App\Http\Traits;
use App\Models\ItemsToTeam;
trait ItemTeamTrait {

    /**
     * check and manage teams with item
     *
     * @return true
     */
    public function UpdateTeamsOfItem($item,$type,$teams) {
        // get current teams with specific item
        $teamsCurrent = $this->GetTeamsOfItem($item,$type);
         // get current teams with specific item
        $teamsToRemove = array_diff($teamsCurrent, $teams);
        $teamsToAdd = array_diff($teams, $teamsCurrent);

        if($teamsToRemove){
            $this->RemoveTeamsOfItem($item,$type,$teamsToRemove);
        }
        
        if($teamsToAdd){
            $this->AddTeamsOfItem($item,$type,$teamsToAdd);
        }
        
        return true;
    }
    /**
     * get list of teams with specific item
     *
     * @return array
     */
    public function GetTeamsOfItem($item_id, $type){

        $teamsID=ItemsToTeam::where(['item_id'=>$item_id,'type'=>$type])->pluck('team_id')->toarray();
        return $teamsID;
    }
     /**
     * remove list teams of specific item
     *
     * @return true
     */
    public function RemoveTeamsOfItem($item_id, $type,$teams=[]){

        ItemsToTeam::where(['item_id'=>$item_id,'type'=>$type])->whereIn('team_id',$teams)->delete();
        return true;
    }
    /**
     * add list teams of specific item
     *
     * @return true
     */
    public function AddTeamsOfItem($item_id, $type,$teams=[]){

        foreach ($teams as $team) {
            ItemsToTeam::create([
                'item_id'=>$item_id,
                'type'=>$type,
                'team_id'=>$team
            ]);
        }
        return true;
    }

    /**
     * remove  specific item data
     *
     * @return true
     */
    public function RemoveItem($item_id, $type){

        ItemsToTeam::where(['item_id'=>$item_id,'type'=>$type])->delete();
        return true;
    }
    
}