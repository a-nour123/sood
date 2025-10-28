<?php
namespace App\Http\Traits;
use App\Models\PermissionToUser;
use App\Models\Permission;
trait UserPermissionTrait {

    /**
     * check and manage permissions with user_id
     *
     * @return true
     */
    public function UpdatePermissionsOfUser($user_id,$permissions) {
        // get current permissions with specific user_id
        $permissionsCurrent = $this->GetPermissionsOfUser($user_id);
         // get current permissions with specific user_id
        $permissionsToRemove = array_diff($permissionsCurrent, $permissions);
        $permissionsToAdd = array_diff($permissions, $permissionsCurrent);

        if($permissionsToRemove){
            $this->RemovePermissionsOfUser($user_id,$permissionsToRemove);
        }
        
        if($permissionsToAdd){
            $this->AddPermissionsOfUser($user_id,$permissionsToAdd);
        }
        
        return true;
    }
    /**
     * get list of permissions with specific user_id
     *
     * @return array
     */
    public function GetPermissionsOfUser($user_id){

        $permissionsID=PermissionToUser::where(['user_id'=>$user_id])->pluck('permission_id')->toarray();
        return $permissionsID;
    }
     /**
     * remove list permissions of specific user_id
     *
     * @return true
     */
    public function RemovePermissionsOfUser($user_id,$permissions=[]){

        PermissionToUser::where(['user_id'=>$user_id])->whereIn('permission_id',$permissions)->delete();
        return true;
    }
    /**
     * add list permissions of specific user_id
     *
     * @return true
     */
    public function AddPermissionsOfUser($user_id,$permissions=[]){

        foreach ($permissions as $permission) {
            PermissionToUser::create([
                'user_id'=>$user_id,
                'permission_id'=>$permission
            ]);
        }
        return true;
    }

    /**
     * remove  specific user_id data
     *
     * @return true
     */
    public function RemoveUserPermission($user_id){

        PermissionToUser::where(['user_id'=>$user_id])->delete();
        return true;
    }
    /**
     * add all permissions to user
     *
     * @return true
     */
    public function AllPermissionToUser($user_id){
        $permissions=Permission::all()->pluck('id')->toarray();
        $this->AddPermissionsOfUser($user_id,$permissions);
        return true;
    }
    
}