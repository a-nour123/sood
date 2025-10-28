<?php

namespace App\Http\Controllers\admin\configure;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Role;
use App\Models\User;
use App\Models\UserToTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
  public function index(){
     $user= User::with(['teams', 'department:id,name'])->find(Auth::user()->id);
     $teams=UserToTeam::where('user_id',$user->id)->get();
     $roles = Role::all();
     $permissions_group = PermissionGroup::all();
     $permissions = Permission::all();
    //   dd($teams);
      return view('admin.content.configure.Userprofile',compact('user','roles','permissions_group','permissions','teams'));
  }
  public function security(){
    $user= User::find(Auth::user()->id);
    $teams=UserToTeam::where('user_id',$user->id)->get();
    $roles = Role::all();
    $permissions_group = PermissionGroup::all();
    $permissions = Permission::all();
   //   dd($teams);
     return view('admin.content.configure.Userprofilechangepassword',compact('user','roles','permissions_group','permissions'));
  }
}
