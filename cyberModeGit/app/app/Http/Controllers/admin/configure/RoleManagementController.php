<?php

namespace App\Http\Controllers\admin\configure;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Risk;
use App\Models\Role;
use App\Models\RoleResponsibility;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoleManagementController extends Controller
{

    public function index()
    {

        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
        ['name' => __('locale.role_management')],
    ];
        $roles = Role::all();
        $permissions_group = PermissionGroup::all();
        $permissions = Permission::all();
        return view('admin.content.configure.RoleManagement', compact('breadcrumbs', 'roles', 'permissions', 'permissions_group'));
    }

    public function permissions()
    {
        $permissions = Permission::get()->map(function ($permissions) {
            return (object)[
                'responsive_id' =>  $permissions->id,
                'id' => $permissions->id,
                'key' => $permissions->key,
                'created_at' => $permissions->created_at,
                'updated_at' => $permissions->updated_at,

            ];
        });

        // dd($tests);
        return response()->json($permissions, 200);
    }

    public function Allpermissions()
    {
        $permissions = Permission::all();
        return view('admin.content.configure.All-Permissions', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|unique:roles,name',
        ]);
    
        $role = new Role();
        $role->name = $validated['name'];
        $role->save();
    
        if (isset($request->keys) && is_array($request->keys)) {
            foreach ($request->keys as $key) {
                RoleResponsibility::create([
                    'role_id' => $role->id,
                    'permission_id' => $key
                ]);
            }
        }
    
        return response()->json([
            'status' => true,
            'message' => __('locale.Role created successfully!')
        ], 200);
    }
    
    

    /**
     * Get specified resource data for editing.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxGet($id)
    {
        $role = Role::with('permissions')->find($id);
        // $role = Role::where('id',$id)->with('permissions')->first();
        if ($role) {

            $data = $role->toArray();
            $data['permissions'] = $role->permissions()->pluck('permission_id');

            $response = array(
                'status' => true,
                'data' => $data,
            );
            return response()->json($response, 200);
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404'),
            );
            return response()->json($response, 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $request->validate([
            'name' => ['required', 'max:100', 'unique:roles,name,' .  $role->id]
        ]);
        $role->update([
            'name' => $request->name
        ]);
        $currentTags = $role->permissions()->pluck('permission_id')->toArray();
        $deletedTags = array_diff($currentTags ?? [], $request->keys ?? []);
        $addedTags = array_diff($request->keys ?? [], $currentTags ?? []);

        // Delete deleted tags
        $role->permissions()->whereIn('permission_id', $deletedTags)->delete();
        // Add added tags
        foreach ($addedTags as $permission_id) {
            RoleResponsibility::create([
                'role_id' => $role->id,
                'permission_id' => $permission_id
            ]);
        }
        $message = __('configure.A Role Of Employee have updated by') . ' "' . auth()->user()->name . '".';
        write_log($role->id, auth()->id(), $message, 'Updating');
        return response()->json([
            'status' => true,
            'message' => __('locale.Role updated successfully!')
        ], 200);
        // if ($role) {
        //     $validator = Validator::make($request->all(), [
        //         'name' => ['required', 'max:100', 'unique:roles,name,' .  $role->id],
        //     ]);

        //     // Check if there is any validation errors
        //     if ($validator->fails()) {
        //         $errors = $validator->errors()->toArray();

        //         $response = array(
        //             'status' => false,
        //             'errors' => $errors,
        //             'message' => __('locale.ThereWasAProblemUpdatingTheRole') . "<br>" . __('locale.Validation error'),
        //         );
        //         return response()->json($response, 422);
        //     } else {
        //         DB::beginTransaction();
        //         try {
        //             $role->update([
        //                 'name' => $request->name
        //             ]);

        //             DB::commit();

        //             $response = array(
        //                 'status' => true,
        //                 'message' => __('locale.RoleWasUpdatedSuccessfully'),
        //             );
        //             return response()->json($response, 200);
        //         } catch (\Throwable $th) {
        //             DB::rollBack();
        //             return $th->getMessage();
        //         }
        //     }
        // } else {
        //     $response = array(
        //         'status' => false,
        //         'message' => __('locale.Error 404'),
        //     );
        //     return response()->json($response, 404);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        if ($role) {
            $role->delete();
            $message = __('configure.A Roles Of Employee have Deleted item from it by') . ' "' . auth()->user()->name . '".';
            write_log($role->id, auth()->id(), $message, 'deleting');
            
            // Redirect back with a query parameter indicating deletion
            return redirect()->back()->with('deleted', true);
        } else {
            // Handle the case where the role with the given ID was not found
            return response()->json(['message' => 'Role not found'], 404);
        }
        // if ($role) {
        //     DB::beginTransaction();
        //     try {
        //         $role->delete();

        //         DB::commit();

        //         $response = array(
        //             'status' => true,
        //             'message' => __('locale.RoleWasDeletedSuccessfully'),
        //         );
        //         return response()->json($response, 200);
        //     } catch (\Throwable $th) {
        //         DB::rollBack();

        //         if ($th->errorInfo[0] == 23000) {
        //             $errorMessage = __('locale.ThereWasAProblemDeletingTheEmployee') . "<br>" . __('locale.CannotDeleteRecordRelationError');
        //         } else {
        //             $errorMessage = __('locale.ThereWasAProblemDeletingTheEmployee');
        //         }
        //         $response = array(
        //             'status' => false,
        //             'message' => $errorMessage,
        //         );
        //         return response()->json($response, 404);
        //     }
        // } else {
        //     $response = array(
        //         'status' => false,
        //         'message' => __('locale.Error 404'),
        //     );
        //     return response()->json($response, 404);
        // }
    }
}
