<?php
namespace App\Http\Traits;
use App\Models\ItemsToUser;
trait ItemUserTrait {

    /**
     * check and manage teams with item
     *
     * @return true
     */
    public function UpdateUsersOfItem($item,$type,$teams) {
        // get current teams with specific item
        $teamsCurrent = $this->GetUsersOfItem($item,$type);
         // get current teams with specific item
        $teamsToRemove = array_diff($teamsCurrent, $teams);
        $teamsToAdd = array_diff($teams, $teamsCurrent);

        if($teamsToRemove){
            $this->RemoveUsersOfItem($item,$type,$teamsToRemove);
        }
        
        if($teamsToAdd){
            $this->AddUsersOfItem($item,$type,$teamsToAdd);
        }
        
        return true;
    }
    /**
     * get list of teams with specific item
     *
     * @return array
     */
    public function GetUsersOfItem($item_id, $type){

        $teamsID=ItemsToUser::where(['item_id'=>$item_id,'type'=>$type])->pluck('user_id')->toarray();
        return $teamsID;
    }
     /**
     * remove list teams of specific item
     *
     * @return true
     */
    public function RemoveUsersOfItem($item_id, $type,$teams=[]){

        ItemsToUser::where(['item_id'=>$item_id,'type'=>$type])->whereIn('user_id',$teams)->delete();
        return true;
    }
    /**
     * add list teams of specific item
     *
     * @return true
     */
    public function AddUsersOfItem($item_id, $type,$teams=[]){

        foreach ($teams as $team) {
            ItemsToUser::create([
                'item_id'=>$item_id,
                'type'=>$type,
                'user_id'=>$team
            ]);
        }
        return true;
    }

    /**
     * remove  specific item data
     *
     * @return true
     */
    public function RemoveItemUser($item_id, $type){

        ItemsToUser::where(['item_id'=>$item_id,'type'=>$type])->delete();
        return true;
    }
    
}