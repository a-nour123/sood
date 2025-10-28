<?php

namespace App\Http\Controllers\admin\change_request;

use App\Exports\ChangeRequestsExport;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\ChangeRequest;
use App\Models\Department;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Technovistalimited\Notific\Notific;

class ChangeRequestController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function (Request $request, $next) {
            // Get the authenticated user
            $user = auth()->user();
    
            // If user has role_id 1, skip the department check
            if ($user->role_id == 1) {
                return $next($request);
            }
    
            // Check if the user has a department
            $userHaveDepartment = User::whereNotNull('department_id')->where('id', $user->id)->exists();
    
            // Disable all functions if the user doesn't have a department
            if (!$userHaveDepartment) {
                if ($request->ajax()) {
                    $response = array(
                        'status' => false,
                        'message' => __('locale.YouDonotHavePermissionToDoThat'),
                    );
                    return response()->json($response, 401);
                } else {
                    return abort(401);
                }
            }
    
            return $next($request);
        });
    }
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['name' => __('locale.ChangeRequests')]];

        return view('admin.content.change_request.index', compact('breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $managerIds = Department::pluck('manager_id')->toArray();
        if (auth()->user()->department_id == change_requests_responsible_department_id()) {
            array_push($managerIds, auth()->id());
        }

        $currentUserIsDepartmentManager = array_search(auth()->id(), $managerIds) === false ? false : true;
        // $currentUserIsInResponsibleDepartment = auth()->user()->department_id == change_requests_responsible_department_id();
        $currentUserIsInResponsibleDepartment = auth()->id() == change_requests_responsible_department_manager_id();
        $currentUserDepartmentManagerNotFounded = (auth()->user()->department->manager->id ?? null) ? false : true;

        // change requests responsible department manager isn't able to create change request
        if (is_null(change_requests_responsible_department_manager_id()) || auth()->id() == change_requests_responsible_department_manager_id()) {
            $response = array(
                'status' => false,
                'message' => __('locale.YouDonotHaveAbilityToCreateChangeRequest'),
            );
            return response()->json($response, 401);
        }

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'max:255'],
            'description' => ['required', 'string'],
            'file' => ['required', 'file'],
        ]);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('locale.ThereWasAProblemAddingTheChangeRequest') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();

            $fileData = [
                'display_name' => null,
                'unique_name' => null
            ];

            try {
                $changeRequest = ChangeRequest::create([
                    'title' => $request->title,
                    'description' => $request->description,
                    'created_by' => auth()->id(),
                    'review_cycle' => ($currentUserIsDepartmentManager || $currentUserIsInResponsibleDepartment || $currentUserDepartmentManagerNotFounded) ? 'Responsible-Department-Review' : 'Department-Manager-Review',
                    'start_review_cycle' => ($currentUserIsDepartmentManager || $currentUserIsInResponsibleDepartment || $currentUserDepartmentManagerNotFounded) ? 'Responsible-Department-Review' : 'Department-Manager-Review',
                    'status' => ($currentUserIsDepartmentManager || $currentUserIsInResponsibleDepartment || $currentUserDepartmentManagerNotFounded) ? 'Responsible-Department-In-Review' : 'Department-Manager-In-Review',
                ]);

                // File upload Start
                if ($request->hasFile('file')) {
                    $file = $request->file('file');
                    if ($file->isValid()) {
                        $path = $file->store('change_request/' . $changeRequest->id);
                        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $fileName .= pathinfo($path, PATHINFO_EXTENSION) ? '.' . pathinfo($path, PATHINFO_EXTENSION) : '';
                        $fileData['display_name'] = $fileName;
                        $fileData['unique_name'] = $path;

                        $changeRequest->update([
                            'display_file_name' => $fileData['display_name'],
                            'unique_file_name' => $fileData['unique_name']
                        ]);
                    } else {
                        DB::rollBack();
                        Storage::deleteDirectory('change_request/' . $changeRequest->id);
                        $response = array(
                            'status' => false,
                            'errors' => ['file' => ['There were problems uploading the files']],
                            'message' => __('locale.ThereWasAProblemAddingTheChangeRequest') . "<br>" . __('locale.Validation error'),
                        );

                        return response()->json($response, 422);
                    }
                }
                // File upload End

                $users = [];
                // Notification
                if (($currentUserIsDepartmentManager || $currentUserIsInResponsibleDepartment || $currentUserDepartmentManagerNotFounded))
                    $users[] = change_requests_responsible_department_manager_id();
                else {
                    $users[] = auth()->user()->department->manager->id;
                }

                $message = " Make change request (" . $request->title . ") you have to approve or reject it as you are " .
                    (($currentUserIsDepartmentManager || $currentUserIsInResponsibleDepartment || $currentUserDepartmentManagerNotFounded) ? 'change requests responsible department manager' : 'department manager');
                Notific::notify(
                    $users,
                    auth()->user()->name . $message,
                    'notification',
                    ['link' => route('admin.change_request.index')],
                    date('d F Y')
                );
                $message = __('locale.A Change Request named') . ' "' . ($changeRequest->title ?? __('locale.[No Title]')) . '" ' . __('locale.CreatedBy') . ' "' . (auth()->user()->name ?? __('locale.[No User Name]')) . '".';
                write_log($changeRequest->id, auth()->id(), $message, 'asset');
                DB::commit();

                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('locale.ChangeRequestWasAddedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                    // 'message' => $th->getLine()
                    // 'message' => $th->getMessage()
                );
                return response()->json($response, 502);
            }
        }
    }

    /**
     * Get specified resource data for editing.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxGet($id)
    {
        $changeRequest = ChangeRequest::find($id);
        if ($changeRequest) {

            $data = $changeRequest->toArray();
            $data['created_at'] = $changeRequest->created_at->format('Y-m-d H:i');

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
        // change requests responsible department manager isn't able to create change request
        if (is_null(change_requests_responsible_department_manager_id())) {
            $response = array(
                'status' => false,
                'message' => __('locale.YouDonotHaveAbilityToUpdateChangeRequest'),
            );
            return response()->json($response, 401);
        }

        $changeRequest = ChangeRequest::find($id);
        if ($changeRequest) {

            // Only creator can update change request
            $editableStatus = null;
            if ($changeRequest->start_review_cycle == 'Department-Manager-Review') {
                $editableStatus = 'Department-Manager-In-Review';
            } else if ($changeRequest->start_review_cycle == 'Responsible-Department-Review') {
                $editableStatus = 'Responsible-Department-In-Review';
            }
            if (!(auth()->id() == $changeRequest->created_by && $changeRequest->status == $editableStatus)) {
                $response = array(
                    'status' => false,
                    'message' => __('locale.YouDonotHavePermissionToDoThat'),
                );
                return response()->json($response, 401);
            }

            $validator = Validator::make($request->all(), [
                'title' => ['required', 'max:255'],
                'description' => ['required', 'string'],
                'file' => ['nullable', 'file'],
            ]);

            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('locale.ThereWasAProblemUpdatingTheChangeRequest') . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();
                try {
                    $changeRequest->update([
                        'title' => $request->title,
                        'description' => $request->description
                    ]);

                    // File upload Start
                    if ($request->hasFile('file')) {
                        $file = $request->file('file');
                        if ($file->isValid()) {
                            $path = $file->store('change_request/' . $changeRequest->id);
                            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                            $fileName .= pathinfo($path, PATHINFO_EXTENSION) ? '.' . pathinfo($path, PATHINFO_EXTENSION) : '';
                            $fileData['display_name'] = $fileName;
                            $fileData['unique_name'] = $path;

                            // Delete old file
                            Storage::delete($changeRequest->unique_file_name);
                            $changeRequest->update([
                                'display_file_name' => $fileData['display_name'],
                                'unique_file_name' => $fileData['unique_name']
                            ]);
                        } else {
                            DB::rollBack();
                            $response = array(
                                'status' => false,
                                'errors' => ['file' => ['There were problems uploading the files']],
                                'message' => __('locale.ThereWasAProblemAddingTheChangeRequest') . "<br>" . __('locale.Validation error'),
                            );

                            return response()->json($response, 422);
                        }
                    }
                    // File upload End


                    DB::commit();

                    $response = array(
                        'status' => true,
                        'reload' => true,
                        'message' => __('locale.ChangeRequestWasUpdatedSuccessfully'),
                    );
                    return response()->json($response, 200);
                } catch (\Throwable $th) {
                    DB::rollBack();
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $changeRequest = ChangeRequest::find($id);

        $changeRequestId = $changeRequest->id;
        if ($changeRequest) {

            // Only creator can update change request
            $editableStatus = null;
            if ($changeRequest->start_review_cycle == 'Department-Manager-Review') {
                $editableStatus = 'Department-Manager-In-Review';
            } else if ($changeRequest->start_review_cycle == 'Responsible-Department-Review') {
                $editableStatus = 'Responsible-Department-In-Review';
            }
            if (!(auth()->id() == $changeRequest->created_by && $changeRequest->status == $editableStatus)) {
                $response = array(
                    'status' => false,
                    'message' => __('locale.YouDonotHavePermissionToDoThat'),
                );
                return response()->json($response, 401);
            }
            DB::beginTransaction();
            try {
                $changeRequest->delete();
                Storage::deleteDirectory('change_request/' . $changeRequestId);

                DB::commit();

                $response = array(
                    'status' => true,
                    'message' => __('locale.ChangeRequestWasDeletedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                if ($th->errorInfo[0] == 23000) {
                    $errorMessage = __('locale.ThereWasAProblemDeletingTheEmployee') . "<br>" . __('locale.CannotDeleteRecordRelationError');
                } else {
                    $errorMessage = __('locale.ThereWasAProblemDeletingTheEmployee');
                }
                $response = array(
                    'status' => false,
                    'message' => $errorMessage,
                    // 'message' => $th->getMessage(),
                );
                return response()->json($response, 404);
            }
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404'),
            );
            return response()->json($response, 404);
        }
    }

    /**
     * Return a listing of the resource after some manipulation.
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxGetList(Request $request)
    {
        /* Start reading datatable data and custom fields for filtering */
        $dataTableDetails = [];
        $customFilterFields = [
            'normal' => ['title', 'description', 'status'],
            'relationships' => ['created_by_user'],
            'other_global_filters' => ['display_file_name', 'rejection_reason', 'created_at'],
        ];
        $relationshipsWithColumns = [
            // 'relationshipName:column1,column2,....'
            'created_by_user:id,username,department_id'
        ];

        prepareDatatableRequestFields($request, $dataTableDetails, $customFilterFields);
        /* End reading datatable data and custom fields for filtering */

        $currentUserId = auth()->id();
        $managerIds = Department::pluck('manager_id')->toArray();
        $currentUserIsDepartmentManager = array_search($currentUserId, $managerIds) === false ? false : true;
        // $currentUserIsInResponsibleDepartment = auth()->user()->department_id == change_requests_responsible_department_id();
        $currentUserIsInResponsibleDepartment = auth()->id() == change_requests_responsible_department_manager_id();
        $_changeRequests = collect();


        // current user is change requests responsible department manager
        $mainTableColumns = getTableColumnsSelect(
            'change_requests',
            [
                'id',
                'title',
                'description',
                'display_file_name',
                'status',
                'review_cycle',
                'created_at',
                'created_by',
                'rejection_reason',
                'start_review_cycle'
            ]
        );
        if ($currentUserIsInResponsibleDepartment) {
            // Getting total records count with and without apply global search
            [$totalRecords, $totalRecordswithFilter] = getDatatableFilterTotalRecordsCount(
                ChangeRequest::class,
                $dataTableDetails,
                $customFilterFields,
                [
                    'where' => [
                        'review_cycle' => 'Responsible-Department-Review'
                    ]
                ]
            );

            // Getting records with apply global search */
            $_changeRequests = getDatatableFilterRecords(
                ChangeRequest::class,
                $dataTableDetails,
                $customFilterFields,
                $relationshipsWithColumns,
                $mainTableColumns,
                [
                    'where' => [
                        'review_cycle' => 'Responsible-Department-Review'
                    ]
                ]
            );
        }
        // current user is department manager
        else if ($currentUserIsDepartmentManager) {
            $departments = Department::where('manager_id', $currentUserId)->get();
            $departmentEmployees = [];
            foreach ($departments as $department) {
                $departmentEmployees = array_merge($departmentEmployees, $department->employees()->where('id', '<>', $currentUserId)->pluck('id')->toArray());
            }

            // Getting total records count with and without apply global search
            [$totalRecords, $totalRecordswithFilter] = getDatatableFilterTotalRecordsCount(
                ChangeRequest::class,
                $dataTableDetails,
                $customFilterFields,
                [
                    'whereIn' => [
                        'created_by' => $departmentEmployees
                    ],
                    'where' => [
                        'review_cycle' => 'Department-Manager-Review'
                    ],
                    'orWhere' => [
                        'created_by' => $currentUserId
                    ]
                ]
            );

            // Getting records with apply global search */
            $_changeRequests = getDatatableFilterRecords(
                ChangeRequest::class,
                $dataTableDetails,
                $customFilterFields,
                $relationshipsWithColumns,
                $mainTableColumns,
                [
                    'whereIn' => [
                        'created_by' => $departmentEmployees
                    ],
                    'where' => [
                        'review_cycle' => 'Department-Manager-Review'
                    ],
                    'orWhere' => [
                        'created_by' => $currentUserId
                    ]
                ]
            );
        }
        // current user is belongs to department and normal employee
        else {
            // Getting total records count with and without apply global search
            [$totalRecords, $totalRecordswithFilter] = getDatatableFilterTotalRecordsCount(
                ChangeRequest::class,
                $dataTableDetails,
                $customFilterFields,
                [
                    'where' => [
                        'created_by' => $currentUserId
                    ]
                ]
            );

            // Getting records with apply global search */
            $_changeRequests = getDatatableFilterRecords(
                ChangeRequest::class,
                $dataTableDetails,
                $customFilterFields,
                $relationshipsWithColumns,
                $mainTableColumns,
                [
                    'where' => [
                        'created_by' => $currentUserId
                    ]
                ]
            );
        }

        // Custom changeRequests response data as needs
        $data_arr = [];
        $data_arr = $_changeRequests->map(function ($changeRequest) use ($currentUserId, $currentUserIsInResponsibleDepartment) {
            $editableStatus = null;
            $decision = false;

            // Get if current review cycle in reviewing
            if ($changeRequest->start_review_cycle == 'Department-Manager-Review') {
                $editableStatus = 'Department-Manager-In-Review';
            } else if ($changeRequest->start_review_cycle == 'Responsible-Department-Review') {
                $editableStatus = 'Responsible-Department-In-Review';
            }

            // Get if current user have ability to make decision or not
            if ($currentUserIsInResponsibleDepartment && $changeRequest->review_cycle == 'Responsible-Department-Review' && !in_array($changeRequest->status, ['Responsible-Department-Accepted', 'Responsible-Department-Rejected'])) { // current user is change requests responsible department manager
                $decision = true;
            } else {
                $changeRequestCreatorDepartmantManagerId = $changeRequest->created_by_user->department->manager_id ?? null;

                if ($currentUserId == $changeRequestCreatorDepartmantManagerId && $changeRequest->review_cycle == 'Department-Manager-Review' && $changeRequest->status != 'Department-Manager-Rejected') { // current user is change request department manager
                    $decision = true;
                }
            }

            $creatorUserName = $changeRequest->created_by_user->username ?? null;
            return [
                'id' =>  $changeRequest->id,
                'title' => $changeRequest->title,
                'description' => $changeRequest->description,
                'file' => $changeRequest->display_file_name,
                'status' => __('locale.' . $changeRequest->status),
                'original_status' => $changeRequest->status,
                'review_cycle' => $changeRequest->review_cycle,
                'created_at' => $changeRequest->created_at->format('Y-m-d H:i'),
                'deletable' => ($changeRequest->created_by == $currentUserId && $changeRequest->status == $editableStatus),
                'editable' => (!is_null(change_requests_responsible_department_manager_id())) && ($changeRequest->created_by == $currentUserId && $changeRequest->status == $editableStatus),
                'decision' => $decision,
                'reason' => $changeRequest->rejection_reason,
                'created_by_user' => ($creatorUserName) == auth()->user()->username ? __('locale.Me') : $creatorUserName,
                'Actions' => $changeRequest->id,
            ];
        })->toArray();

        // Get custom response for datatable ajax request
        $response = getDatatableAjaxResponse(intval($dataTableDetails['draw']), $totalRecords, $totalRecordswithFilter, $data_arr);

        return response()->json($response, 200);
    }

    /**
     * Download the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downloadFile(Request $request)
    {
        $changeRequest = ChangeRequest::where('id', $request->id)->first();

        $exists = Storage::disk('local')->exists($changeRequest->unique_file_name);
        if ($changeRequest && $exists) {
            return Storage::download($changeRequest->unique_file_name, $changeRequest->display_name);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Make decision for change request (Approve or Reject)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function make_decision(Request $request)
    {
        $changeRequestData = ChangeRequest::with('created_by_user')->find($request->id);

        $changeRequest = null;
        $currentUserId = auth()->id();
        $managerIds = Department::pluck('manager_id')->toArray();
        // $currentUserIsInResponsibleDepartment = auth()->user()->department_id == change_requests_responsible_department_id();
        $currentUserIsInResponsibleDepartment = auth()->id() == change_requests_responsible_department_manager_id();

        // current user is change requests responsible department manager
        if ($currentUserIsInResponsibleDepartment) {
            $changeRequest = ChangeRequest::where('review_cycle', 'Responsible-Department-Review')->whereNotIn('status', ['Responsible-Department-Accepted', 'Responsible-Department-Rejected'])->find($request->id);
        } else {
            $changeRequestCreatorDepartmantManagerId = $changeRequestData->created_by_user->department->manager_id;

            // current user is change request department manager
            if ($currentUserId == $changeRequestCreatorDepartmantManagerId) {
                $changeRequest = ChangeRequest::where('review_cycle', 'Department-Manager-Review')->where('status', '<>', 'Department-Manager-Rejected')->find($request->id);
            }
        }

        if ($changeRequest) {
            $rules = [
                'decision' => ['required', Rule::in('Approved', 'Rejected')]
            ];

            if ($request->decision == 'Rejected') {
                $rules['reason'] = ['required', 'string'];
            }
            $validator = Validator::make($request->all(), $rules);

            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('locale.ThereWasAProblemMakingTheChangeRequest') . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();
                try {


                    if ($changeRequest->review_cycle == 'Department-Manager-Review') { // In Department manager review
                        if ($request->decision == 'Approved') { // department manager approved
                            // next review will assign to change request responsible department 
                            $changeRequest->update([
                                'review_cycle' => 'Responsible-Department-Review',
                                'status' => 'Responsible-Department-In-Review'
                            ]);
                            $message = " (Department Manager) approved on your change request (" . $request->title . ") and now in Responsible Department Review";

                            // Notify responsible department manager
                            $users = [change_requests_responsible_department_manager_id()];
                            Notific::notify(
                                $users,
                                auth()->user()->name . "(Department Manager) approved on change request (" . $request->title . ") you have to approve or reject it as you are ",
                                'notification',
                                ['link' => route('admin.change_request.index')],
                                date('d F Y')
                            );
                        } else if ($request->decision == 'Rejected') {
                            $changeRequest->update([
                                'status' => 'Department-Manager-Rejected',
                                'rejection_reason' => $request->reason
                            ]);
                            $message = " (Department Manager) Rejected your change request (" . $request->title . ")";
                        }

                        // Notification creator
                        $users = [$changeRequest->created_by];
                        Notific::notify(
                            $users,
                            auth()->user()->name . $message,
                            'notification',
                            ['link' => route('admin.change_request.index')],
                            date('d F Y')
                        );
                    } else if ($changeRequest->review_cycle == 'Responsible-Department-Review') {
                        if ($request->decision == 'Approved') { // responsible department manager approved
                            // this is final approval cycle
                            $changeRequest->update([
                                'status' => 'Responsible-Department-Accepted'
                            ]);
                            $message = " (Responsible Department Review) approved on your change request (" . $request->title . ")";
                        } else if ($request->decision == 'Rejected') {
                            $changeRequest->update([
                                'status' => 'Responsible-Department-Rejected',
                                'rejection_reason' => $request->reason
                            ]);
                            $message = " (Responsible Department Review) Rejected your change request (" . $request->title . ")";
                        }

                        // Notification creator
                        $users = [$changeRequest->created_by];
                        Notific::notify(
                            $users,
                            auth()->user()->name . $message,
                            'notification',
                            ['link' => route('admin.change_request.index')],
                            date('d F Y')
                        );
                    }

                    DB::commit();

                    $response = array(
                        'status' => true,
                        'reload' => true,
                        'message' => __('locale.ChangeRequestDecisionWasMadeSuccessfully', ['status' => __('locale.' . $request->decision .  '-action')]),
                    );
                    return response()->json($response, 200);
                } catch (\Throwable $th) {
                    DB::rollBack();
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

    /**
     * Return an Export file for listing of the resource after some manipulation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxExport(Request $request)
    {
        if ($request->type != 'pdf')
            return Excel::download(new ChangeRequestsExport, 'Change-reuqests.xlsx');
        else
            return 'Change-reuqests.pdf';
    }
}
