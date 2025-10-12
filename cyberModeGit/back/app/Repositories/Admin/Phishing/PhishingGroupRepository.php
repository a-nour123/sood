<?php


namespace App\Repositories\Admin\Phishing;

use App\Helpers\Helper;
use App\Interfaces\Admin\Phishing\PhishingGroupInterface;
use App\Models\PhishingGroup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class PhishingGroupRepository implements PhishingGroupInterface
{

    public function getAll()
    {
        try {
            $groups = PhishingGroup::withoutTrashed()->get();

            $breadcrumbs = [
                ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
                ['link' => route('admin.phishing.campaign.index'), 'name' => __('phishing.campaign')],
                ['name' => __('phishing.group')]
            ];

            return view('admin.content.phishing.group.list', compact('breadcrumbs', 'groups'));
        } catch (\Exception $e) {
        }
    }

    public function PhishingGroupeDatatable(Request $request)
    {
        $groups = PhishingGroup::withoutTrashed()->orderBy('created_at','desc');
        return DataTables::of($groups)->setRowId(function ($row) {
            static $index = 0;
            return $index++;
            // return $row->id;
        })->addColumn('actions', function ($row) {
            $dropdown = '<div class="dropdown">' .
                        '<a class="pe-1 dropdown-toggle hide-arrow text-primary" href="#" role="button" id="actionsDropdown' . $row->id . '" data-bs-toggle="dropdown" aria-expanded="false">' .
                        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-small-4">' .
                        '<circle cx="12" cy="12" r="1"></circle>' .
                        '<circle cx="12" cy="5" r="1"></circle>' .
                        '<circle cx="12" cy="19" r="1"></circle>' .
                        '</svg>' .
                        '</a>' .
                        '<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionsDropdown' . $row->id . '">';

            // "Edit"
            $dropdown .= '<li><a class="dropdown-item show-frame edit-regulator" href="javascript:;" data-id="' . $row->id . '" data-name="' . $row->name . '">' .
                         '<i class="fa-solid fa-pen me-50 font-small-4"></i> Edit</a></li>';

            // "Delete"
            $dropdown .= '<li><a class="dropdown-item show-frame trash-domain" href="javascript:;" data-id="' . $row->id . '" data-name="' . $row->name . '" onclick="ShowModalTrashGroup(' . $row->id . ')">' .
                         '<i class="fa-solid fa-trash me-50 font-small-4"></i> Delete</a></li>';

            // "Add Users"
            $dropdown .= '<li><a class="dropdown-item show-frame add-users" href="javascript:;" data-bs-target="#add-users" data-bs-toggle="modal" data-id="' . $row->id . '">' .
                         '<i class="fa-solid fa-users me-50 font-small-4"></i> Add Users</a></li>';

            $dropdown .= '</ul></div>';

            return $dropdown;
        })
        ->editColumn('created_at', function ($row) {
            return Carbon::parse($row->created_at)->format('Y-m-d g:ia');
        })->rawColumns(['actions'])
        ->addIndexColumn()
        ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:200', 'unique:phishing_groups,name'],
        ]);

        // Check if there are any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = [
                'status' => false,
                'errors' => $errors,
                'message' => __('locale.ThereWasAProblemAddinggroup') . "<br>" . __('locale.Validation error'),
            ];
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();
            try {
                $newGroup = PhishingGroup::create([
                    'name' => $request->name,
                ]);

                // Audit log
                $message = __('phishing.An phishing group name') . ' "' . ($newGroup->name ?? __('locale.[No Name]')) . '" ' . __('asset.was added by username') . ' "' . (auth()->user()->name ?? __('locale.[No User Name]')) . '".';
                write_log($newGroup->id, auth()->id(), $message, 'group');

                DB::commit();
                $response = [
                    'status' => true,
                    'message' => __('phishing.GroupWasAddedSuccessfully'),
                ];
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();
                $response = [
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                ];
                return response()->json($response, 502);
            }
        }
    }

    public function update($id, Request $request)
    {
        $group = PhishingGroup::find($id);
        if ($group) {
            $validator = Validator::make($request->all(), [
                'name' => ['required']
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('locale.ThereWasAProblemUpdatingThegroup') . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                try {
                    $group->update([
                        'name' => $request->name,
                    ]);
                    $message = __('phishing.update phishing group name') . ' "' . ($group->name ?? __('locale.[No Name]')) . '" ' . __('asset.was added by username') . ' "' . (auth()->user()->name ?? __('locale.[No User Name]')) . '".';

                write_log($id, auth()->id(), $message, 'group');

                    $response = array(
                        'status' => true,
                        'message' => __('locale.GroupWasUpdatedSuccessfully'),
                    );
                    return response()->json($response, 200);
                } catch (\Throwable $th) {
                    return $th->getMessage();
                }
            }
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404'),
            );
            return response()->json($response, 404);
        }
    }
    public function trash($group)
    {
        // Find the group or fail
        $group = PhishingGroup::findOrFail($group);

        // Check if the group has users
        if ($group->users()->exists()) {
            $response = array(
                'status' => false,
                'message' => __('phishing.GroupHasUsersCannotTrash'),
            );
            return response()->json($response, 400);
        }

        // Update the deleted_at timestamp to mark the group as trashed
        $group->update([
            'deleted_at' => now(),
        ]);

        // Log the trashing action
        $message = __('phishing.trash phishing group name') . ' "' . ($group->name ?? __('locale.[No Name]')) . '" ' . __('phishing.was trashed by username') . ' "' . (auth()->user()->name ?? __('locale.[No User Name]')) . '".';
        write_log($group->id, auth()->id(), $message, 'group');

        // Return a success response
        $response = array(
            'status' => true,
            'message' => __('phishing.GroupWasTrashedSuccessfully'),
        );
        return response()->json($response, 200);
    }

    public function restore($id,Request $request)
    {
        try {
            // Use withTrashed() to include soft-deleted records
            $group = PhishingGroup::withTrashed()->findOrFail($id);
            // Restore the soft-deleted record
            $group->restore();

            $response = [
                'status' => true,
                'message' => __('phishing.GroupRestoreSuccessfully'),
            ];
            $message = __('phishing.restore phishing group name') . ' "' . ($group->name ?? __('locale.[No Name]')) . '" ' . __('phishing.was trashed by username') . ' "' . (auth()->user()->name ?? __('locale.[No User Name]')) . '".';

            write_log($group->id, auth()->id(), $message, 'group');
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = [
                'status' => false,
                'message' => __('locale.Error'),
            ];
            return response()->json($response, 502);
        }
    }
    public function delete($id)
    {
        $group = PhishingGroup::withTrashed()->findOrFail($id);
      if($group){
          $group->forceDelete();
          $response = array(
            'status' => true,
            'message' => __('phishing.GroupWasDeletedSuccessfully'),
        );
        $message = __('phishing.delete phishing group name') . ' "' . ($group->name ?? __('locale.[No Name]')) . '" ' . __('phishing.was deleted by username') . ' "' . (auth()->user()->name ?? __('locale.[No User Name]')) . '".';

        write_log($group->id, auth()->id(), $message, 'group');
        return response()->json($response, 200);
      }else{
        $response = [
            'status' => false,
            'message' => __('locale.Error'),
        ];
        return response()->json($response, 502);
      }

    }

    public function getArchivedGroups()
    {
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('Archivec Groups')]
        ];
        $archived_groups = PhishingGroup::onlyTrashed()->get();
        return view('admin.content.phishing.group.archived', get_defined_vars());
    }

    public function archivedGroupsDatatable(Request $request)
    {
        $groups = PhishingGroup::onlyTrashed()->orderBy('created_at','desc');
        return DataTables::of($groups)->setRowId(function ($row) {
            return $row->id;
        })->addColumn('actions', function ($row) {
                $data = '<div class="regulator-item">';
                $data = $data.'<button class="btn btn-secondary show-frame trash-domain" type="button" data-bs-toggle="modal"
                    data-id="'.$row->id.'" onclick="ShowModalRestoreGroup('.$row->id.')" data-name="'.$row->name.'">
                                               <i class="fa-solid fa-undo"></i>
                </button>';

                $data = $data.' <button class="btn btn-secondary show-frame trash-domain" type="button" data-bs-toggle="modal"
                    data-id="'.$row->id.'" onclick="ShowModalDeleteGroup('.$row->id.')" data-name="'.$row->name.'">
                                                <i class="fa-solid fa-trash"></i>
                </button>';

                $data = $data.'</div>';

            return $data;
        })->editColumn('created_at', function ($row) {
            $data = $row->created_at;

            return Carbon::parse($data)->format('Y-m-d g:ia');
        })->rawColumns(['actions'])
        ->make(true);
    }
    public function AddUsersToGroup(Request $request)
    {
        // Debugging request data
        $group = PhishingGroup::findOrFail($request->id);

        if ($group) {
            $users = array_filter($request->input('users', [])); // Remove null values

            if (!empty($users)) {
                $group->users()->sync($users);

                $response = [
                    'status' => true,
                    'message' => __('phishing.UsersWasAddedSuccessfully'),
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => __('locale.NoUsersSelected'),
                ];
            }

            return response()->json($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => __('locale.Error'),
            ];

            return response()->json($response, 502);
        }
    }
    public function getUsersForGroup($id)
    {
        $group = PhishingGroup::find($id);

        if ($group) {
            $userIds = $group->users->pluck('id');
            return response()->json(['users' => $userIds]);
        }

        return response()->json(['users' => []], 404);
    }

}
