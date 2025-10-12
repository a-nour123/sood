<?php

namespace App\Http\Controllers\admin\remidation;

use App\Http\Controllers\Controller;
use App\Models\RemediationDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\DataTables;

class RemidationController extends Controller
{
    public function index()
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
        ['name' => __('locale.Compliance Framework')],
         ['name' => __('locale.Remidation Requests')]];
        return view('admin.content.remidation.index', compact('breadcrumbs'));
    }



    public function getRemediationData(Request $request)
    {
        if ($request->ajax()) {
            $user = auth()->user();

            $userId = $user->id;
            $roleId = $user->role_id;

            $query = DB::table('remediation_details')
                ->leftJoin('users as responsible_users', 'remediation_details.responsible_user', '=', 'responsible_users.id')
                ->leftJoin('framework_control_test_audits', 'remediation_details.control_test_id', '=', 'framework_control_test_audits.id')
                ->select(
                    'remediation_details.id',
                    'remediation_details.responsible_user',
                    'remediation_details.corrective_action_plan',
                    'remediation_details.budgetary',
                    'remediation_details.status',
                    'remediation_details.due_date',
                    'remediation_details.comments',
                    'remediation_details.control_test_id',
                    'responsible_users.name as responsible_user_name',
                    'framework_control_test_audits.name as control_name'
                );

            // If the user is not an admin, filter by responsible_user
            if ($roleId != 1) {
                $query->where('remediation_details.responsible_user', $userId);
            }

            $data = $query->get();

            return DataTables::of($data)
                ->addColumn('corrective_action_plan', function ($row) {
                    return $row->corrective_action_plan;
                })
                ->addColumn('auto_increment', function ($row) {
                    static $count = 1;
                    return $count++;
                })
                ->addColumn('actions', function ($row) use ($user) {
                    if ($row->id === null) {
                        return '';
                    }

                    $editButton = '';
                    // Check if the user has permission to edit
                    $editButton = '<a class="dropdown-item edit-btn" data-id="' . $row->id . '" data-bs-toggle="modal" data-bs-target="#remediationModal"><i class="fas fa-edit"></i> Edit</a>';
                    if ($user->hasPermission('remidation.update')) {

                        return '
                        <div class="d-inline-flex">
                            <a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown" aria-expanded="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-small-4">
                                    <circle cx="12" cy="12" r="1"></circle>
                                    <circle cx="12" cy="5" r="1"></circle>
                                    <circle cx="12" cy="19" r="1"></circle>
                                </svg>
                            </a>
                            <ul class="dropdown-menu">
                                ' . $editButton . '
                            </ul>
                        </div>
                    ';
                    }else{
                        return '----';
                    }
                })
                ->rawColumns(['corrective_action_plan', 'actions']) // Ensure raw HTML is rendered
                ->addIndexColumn()
                ->make(true);
        }
    }




    public function getDetails(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id;
            $remediation = DB::table('remediation_details')
                ->leftJoin('users as responsible_users', 'remediation_details.responsible_user', '=', 'responsible_users.id')
                ->leftJoin('framework_control_test_audits', 'remediation_details.control_test_id', '=', 'framework_control_test_audits.id')
                ->where('remediation_details.id', $id)
                ->select(
                    'remediation_details.corrective_action_plan',
                    'remediation_details.budgetary',
                    'remediation_details.status',
                    'remediation_details.due_date',
                    'remediation_details.comments'
                )
                ->first();

            return response()->json($remediation);
        }
    }


    public function update(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'id' => 'required|exists:remediation_details,id',
            'budgetary' => 'sometimes|numeric', // Use 'sometimes' for optional fields
            'status' => 'sometimes|string',
            'due_date' => 'sometimes|date',
            'comments' => 'sometimes|string',
        ]);
    
        // Extract the ID and filter only provided fields for updating
        $id = $request->input('id');
        $data = $request->only(['budgetary', 'status', 'due_date', 'comments']);
    
        // Update only the provided fields
        if (!empty($data)) {
            DB::table('remediation_details')
                ->where('id', $id)
                ->update($data);
        }
    
        return response()->json(['success' => true, 'message' => 'Record updated successfully']);
    }
    
    
    
}
