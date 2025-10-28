<?php

namespace App\Http\Traits;

use App\Models\User;
use Hash;

trait UserTrait
{

    /**
     * check and manage teams with item
     *
     * @return true
     */
    public function AddGrcUser($request)
    {

        $custom_display_settings = json_encode(array(
            'id',
            'subject',
            'calculated_risk',
            'submission_date',
            'mitigation_planned',
            'management_review'
        ));
        if($request->type == 'ldap'){
            $pass = Hash::make(12345678);
        }else{
            $pass = Hash::make($request->password);
        }
        $user = User::create([
            'enabled' => 1,
            'lockout' => 0,
            'type' => $request->type,
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $pass,
            'role_id' => $request->role_id,
            'job_id' => $request->job_id,
            'admin' => $request->admin,
            // 'multi_factor'=>$request->multi_factor,
            'manager_id' => $request->manager_id,
            'department_id' => $request->department_id,
            'salt' => $request->salt,
            'custom_display_settings' => $custom_display_settings,
            'phone_number' => $request->full_number,
        ]);
        return $user;
    }
    /**
     * check and manage teams with item
     *
     * @return true
     */
    public function EditGrcUser($request)
    {
        $manager = User::find($request->manager_id);
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->role_id = $request->role_id;
        $user->job_id = $request->job_id;
        $user->admin = $request->admin;
        $user->manager_id = $request->manager_id;
        $user->department_id = $request->department_id;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        if ($request->full_number) {
            $user->phone_number = $request->full_number;
        }
        $user->save();

        return $user;
    }
}
