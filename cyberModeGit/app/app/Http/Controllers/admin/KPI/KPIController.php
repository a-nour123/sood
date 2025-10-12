<?php

namespace App\Http\Controllers\admin\KPI;

use App\Events\initiateAssessmentCreated;
use App\Events\initiateAssessmentKpiValue;
use App\Exports\KPIsExport;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\KPI;
use App\Models\KPIAssessment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Action;
use App\Events\KpiCreated;
use App\Events\KpiUpdated;
use App\Events\KpiDeleted;

class KPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->hasPermission('KPI.list')) {
            abort(403, 'Unauthorized action.');
        }
        $KPIs = KPI::with('department:id,name')->get();
        $departments = Department::all();
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
        ['name' => __('KPI')],
          ['name' => __('locale.KPIs')]];

        return view('admin.content.KPI.index', compact('breadcrumbs', 'KPIs', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'max:255', 'unique:kpis,title'],
            'description' => ['required', 'string'],
            'value_type' => ['required', Rule::in('Time', 'Percentage', 'Number')],
            'value' => ['required', 'max:50'],
            'period_of_assessment' => ['required', Rule::in('3', '6', '9', '12')],
            'department' => ['required', 'exists:departments,id'],
        ]);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('hierarchy.ThereWasAProblemAddingTheKPI') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();
            try {
                $kpi = KPI::create([
                    'title' => $request->title,
                    'description' => $request->description,
                    'value_type' => $request->value_type,
                    'value' => $request->value,
                    'period_of_assessment' => $request->period_of_assessment,
                    'created_by' => auth()->id(),
                    'department_id' => $request->department,
                ]);


                DB::commit();
                event(new KpiCreated($kpi));

                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('hierarchy.KPIWasAddedSuccessfully'),
                );
                $message = __('hierarchy.A New Kpi created with name') . ' "' . ($kpi->title ?? __('locale.[No Name]')) . '". '
                    . __('hierarchy.And with description is') . ' "' . ($kpi->description ?? __('locale.[No Description]')) . '" '
                    . __('hierarchy.and department belongs to') . ' "' . ($kpi->department->name ?? __('locale.[No Name]')) . '". '
                    . __('locale.CreatedBy') . ' "' . auth()->user()->name . '".';
                write_log($kpi->id, auth()->id(), $message, 'Creating kpi');
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                    // 'message' => $th->getMessage(),
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
        $KPI = KPI::with('department:id,name')->find($id);
        if ($KPI) {
            $data = $KPI->toArray();
            $data['created_at'] = $KPI->created_at->format('Y-m-d H:i');

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
        $KPI = KPI::find($id);
        if ($KPI) {
            $validator = Validator::make($request->all(), [
                'title' => ['required', 'max:255', 'unique:kpis,title,' .  $KPI->id],
                'description' => ['required', 'string'],
                'value_type' => ['required', Rule::in('Time', 'Percentage', 'Number')],
                'value' => ['required', 'max:50'],
                'period_of_assessment' => ['required', Rule::in('3', '6', '9', '12')],
                'department' => ['required', 'exists:departments,id'],
            ]);

            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('hierarchy.ThereWasAProblemUpdatingTheKPI') . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();
                try {
                    // to get the old data of department to use it in log
                    $kpiOldDetAils = Kpi::find($id);
                    $KPI->update([
                        'title' => $request->title,
                        'description' => $request->description,
                        'value_type' => $request->value_type,
                        'value' => $request->value,
                        'period_of_assessment' => $request->period_of_assessment,
                        'department_id' => $request->department,
                    ]);
                    $kpi = $KPI->fresh();
                    DB::commit();
                    event(new KpiUpdated($kpi));
                    $response = array(
                        'status' => true,
                        'reload' => true,
                        'message' => __('hierarchy.KPIWasUpdatedSuccessfully'),
                    );
                    $message = __('hierarchy.A Kpi that name is') . ' "' . ($kpiOldDetAils->title ?? __('locale.[No Name]')) . '"';

                    if ($kpiOldDetAils->title != $kpi->title) {
                        $message .= ' ' . __('hierarchy.changed to') . ' "' . ($kpi->title ?? __('locale.[No Name]')) . '"';
                    } else {
                        $message .= ' ' . __('hierarchy.That Description of it is') . ' "' . ($kpiOldDetAils->description ?? __('locale.[No Description]')) . '"';
                    }

                    if ($kpiOldDetAils->description != $kpi->description) {
                        $message .= ' ' . __('hierarchy.And the description changed from') . ' "' . ($kpiOldDetAils->description ?? __('locale.[No Description]')) . '"';
                    }

                    if ($kpiOldDetAils->department_id != $kpi->department_id) {
                        $message .= ' ' . __('hierarchy.and department belongs to it changed from') . ' "' . ($kpiOldDetAils->department->name ?? __('locale.[No Name]')) . '"';
                    }

                    $message .= ' ' . __('locale.to') . ' "' . ($kpi->department->name ?? __('locale.[No Name]')) . '"';
                    $message .= ' ' . __('locale.UpdatedBy') . ' "' . auth()->user()->name . '".';


                    write_log($kpi->id, auth()->id(), $message, 'Updating Kpi');
                    return response()->json($response, 200);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    $response = array(
                        'status' => false,
                        'errors' => [],
                        'message' => __('locale.Error'),
                        // 'message' => $th->getMessage(),
                    );
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
        $KPI = KPI::find($id);
        if ($KPI) {
            DB::beginTransaction();
            try {
                // Check for related data
                $relatedData = $KPI->hasRelations();

                if (!empty($relatedData)) {
                    $relatedMessages = [];
                    foreach ($relatedData as $relation => $count) {
                        // Format each relation with details
                        $relatedMessages[] = __('locale.RelationExists', [
                            'relation' => ucfirst($relation),
                            'count' => $count
                        ]);
                    }

                    $response = [
                        'status' => false,
                        'message' => __('locale.CannotDeleteDueToRelations') . "<br>" . implode('<br>', $relatedMessages),
                    ];

                    return response()->json($response, 400);
                }
                $KPI->delete();

                // $kpi = $KPI->fresh();
                DB::commit();
                event(new KpiDeleted($KPI));

                $response = array(
                    'status' => true,
                    'message' => __('locale.KPIWasDeletedSuccessfully'),
                );
                $message = __('hierarchy.A Kpi that name is') . ' "' . ($KPI->title ?? __('locale.[No Name]')) . '" '
                    . __('hierarchy.That Description of it is') . ' "' . ($KPI->description ?? __('locale.[No Description]')) . '" '
                    . __('hierarchy.and department belongs to') . ' "' . ($KPI->department->name ?? __('locale.[No Name]')) . '" '
                    . __('locale.DeletedBy') . ' "' . auth()->user()->name . '".';
                write_log($KPI->id, auth()->id(), $message, 'Updating Kpi');
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                if ($th->errorInfo[0] == 23000) {
                    $errorMessage = __('hierarchy.ThereWasAProblemDeletingTheEmployee') . "<br>" . __('locale.CannotDeleteRecordRelationError');
                } else {
                    $errorMessage = __('hierarchy.ThereWasAProblemDeletingTheEmployee');
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

    public function KpiType($id)
    {
         $kpiId = Kpi::findOrFail($id); // Fetch the KPI or throw a 404 error if not found
 
        return response()->json($kpiId); // Return the KPI as a JSON response
    }
    
    public function KpiTypeAssessment($id)
    {
         $kpiId = KPIAssessment::findOrFail($id); // Fetch the KPI or throw a 404 error if not found
 
        $kpi = Kpi::where('id',$kpiId->kpi_id)->first(); // Fetch the KPI or throw a 404 error if not found

        return response()->json($kpi); // Return the KPI as a JSON response
    }
    public function ajaxGetList(Request $request)
    {
        /* Start reading datatable data and custom fields for filtering */
        $dataTableDetails = [];
        $customFilterFields = [
            'normal' => ['title', 'description', 'value_type'],
            'relationships' => ['department', 'created_by_user'],
            'other_global_filters' => ['value', 'period_of_assessment', 'created_at'],
        ];
        $relationshipsWithColumns = [
            // 'relationshipName:column1,column2,....'
            'department:id,name,manager_id',
            'created_by_user:id,name'
        ];

        prepareDatatableRequestFields($request, $dataTableDetails, $customFilterFields);
        /* End reading datatable data and custom fields for filtering */

        // Getting total records count with and without apply global search
        [$totalRecords, $totalRecordswithFilter] = getDatatableFilterTotalRecordsCount(KPI::class, $dataTableDetails, $customFilterFields);

        $mainTableColumns = getTableColumnsSelect(
            'kpis',
            [
                'id',
                'department_id',
                'title',
                'description',
                'value_type',
                'value',
                'period_of_assessment',
                'created_by',
                'created_at',
            ]
        );

        // Getting records with apply global search */
        $KPIs = getDatatableFilterRecords(
            KPI::class,
            $dataTableDetails,
            $customFilterFields,
            $relationshipsWithColumns,
            $mainTableColumns
        );

        // Custom KPIs response data as needs
        $data_arr = [];
        foreach ($KPIs as $KPI) {
            $data_arr[] = array(
                'id' => $KPI->id,
                'title' => $KPI->title,
                'description' => $KPI->description,
                'value_type' => $KPI->value_type,
                'value' => $KPI->value,
                'period_of_assessment' => $KPI->period_of_assessment . ' ' . __('locale.Months'),
                'department' => ($KPI->department) ? $KPI->department->name : '',
                'department_manager' => isset($KPI->department->manager) ? $KPI->department->manager->name : '',
                'created_at' => $KPI->created_at->format('Y-m-d H:i:s'),
                'created_by_user' => $KPI->created_by_user->name ?? '',
                'Actions' => $KPI->id,
            );
        }

        // Get custom response for datatable ajax request
        $response = getDatatableAjaxResponse(intval($dataTableDetails['draw']), $totalRecords, $totalRecordswithFilter, $data_arr);

        return response()->json($response, 200);
    }

    /**
     * Store a newly KPI assessment resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function initiateAssessment($KPIId)
    {
        $KPI = KPI::find($KPIId);

        if ($KPI) {
            DB::beginTransaction();
            try {
                // Create KPI Assessment with auth user
                $KPI->assessments()->create([
                    'created_by' => auth()->id()
                ]);
                DB::commit();
                event(new initiateAssessmentCreated($KPI));
                $message = __('locale.A Kpi that name is') . ' "' . $KPI->title . '" ' .  __('locale.InitaitedBy') . ' "' . auth()->user()->name . '".';
                write_log($KPI->id, auth()->id(), $message, 'Initiate KPI');
                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('hierarchy.KPIAssessmentWasInitiatedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                    // 'message' => $th->getMessage(),
                );
                return response()->json($response, 502);
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
     * Return a listing of the KPI assessment after some manipulation.
     *
     * @return \Illuminate\Http\Response
     */
    public function KPIAssessment($KPIId)
    {
        $KPI = KPI::with('assessments')->find($KPIId);

        if ($KPI) {
            $assessments = $KPI->assessments->map(function ($assessment) use ($KPI) {
                return (object)[
                    'kpi_value' => $KPI->value ?? '',
                    'value' => $assessment->assessment_value ?? '',
                    'createdBy' => $assessment->created_by_user->username ?? '',
                    'actionBy' => $assessment->action_by_user->username ?? '',
                    'created_at' => $assessment->created_at->format('Y-m-d H:i'),
                    'assessment_date' => $assessment->assessment_date ? $assessment->assessment_date->format('Y-m-d H:i') : '',
                ];
            });

            $response = array(
                'status' => true,
                'data' => $assessments,
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
     * Return a listing of the KPIs assessments for department manager after some manipulation.
     *
     * @return \Illuminate\Http\Response
     */
    public function listAssessment()
    {

        if (!auth()->user()->hasPermission('KPI.list_Kpi_Assessment')) {
            abort(403, 'Unauthorized action.');
        }
        $KPIs = KPI::select('title', 'value_type')->get();
        $departments = Department::select('name')->get();
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
        ['name' => __('KPI')],
        ['name' => __('Set KPI Assessment')]];

        return view('admin.content.KPI.assessment', compact('breadcrumbs', 'KPIs', 'departments'));
    }

    /**
     * Return a listing of the KPIs assessments for department manager after some manipulation.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxListAssessment()
    {
        $assessments = [];
        $currentUserId = auth()->id();
        $managerIds = Department::pluck('manager_id')->toArray();
        $currentUserIsDepartmentManager = array_search($currentUserId, $managerIds) !== false;
        $currentUserDepartmentIds = Department::where('manager_id', $currentUserId)->pluck('id')->toArray();
        $currentUserIsAssignedToKPI = KPIAssessment::where('assigned_to', $currentUserId)->exists(); // Check if the user is assigned to any KPIAssessment

        if ($currentUserIsDepartmentManager || $currentUserIsAssignedToKPI) {
            // Fetch KPIAssessments where the user is either the department manager or assigned to the KPI assessment
            $assessmentsQuery = KPIAssessment::with([
                'kpi.department:id,name,manager_id',
                'created_by_user:id,username',
                'action_by_user:id,username',
                'assigned_To:id,name' // Relationship to the assigned user
            ])
                ->whereHas('kpi', function ($query) use ($currentUserId, $currentUserDepartmentIds) {
                    $query->whereIn('department_id', $currentUserDepartmentIds) // Filter by the department the manager is in charge of
                        ->orWhere('assigned_to', $currentUserId); // Also include KPI assessments assigned to the current user
                });

            // Execute the query and get the results
            $KPIs = $assessmentsQuery->get();

            // Loop through the KPIAssessments and their related data to return the necessary data
            foreach ($KPIs as $assessment) {
                $assessments[] = (object)[
                    'responsive_id' => $assessment->id,
                    'description' => $assessment->kpi->description ?? '', // Get description from KPI model
                    'value' => $assessment->assessment_value ?? '',
                    'createdBy' => $assessment->created_by_user->username ?? '',
                    'actionBy' => $assessment->action_by_user->username ?? '',
                    'created_at' => $assessment->created_at->format('Y-m-d H:i'),
                    'assessment_date' => $assessment->assessment_date ? $assessment->assessment_date->format('Y-m-d H:i') : '',
                    'kpi' => $assessment->kpi->title, // Get title from KPI model
                    'type' => $assessment->kpi->value_type, // Get value type from KPI model
                    'department' => $assessment->kpi->department->name ?? '', // Get department name from KPI model
                    'assigned_to' => $assessment->assigned_To->name ?? '', // Get assigned user's name from KPIAssessment
                    'enabled' => is_null($assessment->assessment_value), // Check if assessment value is null (enabled for editing)
                    'Actions' => $assessment->id
                ];
            }
        }

        return response()->json($assessments, 200);
    }



    /**
     * Set KPI asssessment resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function setAssessment(Request $request)
    {
        $currentUserId = auth()->id();
        $managerIds = Department::pluck('manager_id')->toArray();
        $currentUserIsDepartmentManager = array_search($currentUserId, $managerIds) === false ? false : true;
        $currentUserDepartmentIds = Department::where('manager_id', $currentUserId)->pluck('id')->toArray();
        $currentUserIsAssignedToKPI = KPIAssessment::where('assigned_to', $currentUserId)->exists(); // Check if the user is assigned to any KPIAssessment

        // Initialize $assessment to null by default
        $assessment = null;
        // Check if the current user is either a department manager or assigned to a KPIAssessment
        if ($currentUserIsDepartmentManager || $currentUserIsAssignedToKPI) {
            // Try to find the KPIAssessment by the provided ID where the assessment_value is null
            $_assessment = KPIAssessment::whereNull('assessment_value')
                ->with('kpi.department:id')
                ->find($request->id);

            // If no assessment found, return a 404 error
            if (!$_assessment) {
                return response()->json([
                    'status' => false,
                    'message' => __('locale.Error 404'),
                ], 404);
            }

            // If the user is a department manager, check if they manage the department of the KPI
            if ($currentUserIsDepartmentManager) {
                if (in_array($_assessment->kpi->department->id, $currentUserDepartmentIds)) {
                    $assessment = $_assessment; // The assessment belongs to a department managed by the current user
                }
            }

            // If the user is assigned to the KPI, allow them to access the assessment
            if ($currentUserIsAssignedToKPI && !$assessment) {
                if ($_assessment->assigned_to == $currentUserId) {
                    $assessment = $_assessment; // User is assigned to this KPIAssessment
                }
            }

            // If an assessment is found, proceed with validation and update
            if ($assessment) {
                $validator = Validator::make($request->all(), [
                    'value' => ['required', 'max:50'],
                ]);

                // If validation fails, return an error response
                if ($validator->fails()) {
                    $errors = $validator->errors()->toArray();
                    return response()->json([
                        'status' => false,
                        'errors' => $errors,
                        'message' => __('hierarchy.ThereWasAProblemUpdatingTheKPIAssessment') . "<br>" . __('locale.Validation error'),
                    ], 422);
                }

                DB::beginTransaction();
                try {
                    // Update the KPIAssessment with the provided value
                    $assessment->update([
                        'assessment_value' => $request->value,
                        'assessment_date' => now(),
                        'action_by' => auth()->id(),
                    ]);

                    DB::commit();
                    event(new initiateAssessmentKpiValue($assessment));

                    // Log the action
                    $message = __('locale.A Kpi that name is') . ' "' . ($assessment->kpi->title ?? __('locale.[No Name]')) . '" ' . __('locale.HasBeenAssessedWithValue') . ' "' . $assessment->assessment_value . '" ' . __('locale.AssessedBy') . ' "' . auth()->user()->name . '".';
                    write_log($assessment->id, auth()->id(), $message, 'set assessment kpi value');

                    // Return success response
                    return response()->json([
                        'status' => true,
                        'reload' => true,
                        'message' => __('hierarchy.KPIAssessmentWasSettedSuccessfully'),
                    ], 200);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return response()->json([
                        'status' => false,
                        'errors' => [],
                        'message' => __('locale.Error'),
                    ]);
                }
            } else {
                // If the assessment is not found or accessible by the current user
                return response()->json([
                    'status' => false,
                    'message' => __('locale.Error 404'),
                ], 404);
            }
        } else {
            // If the user is not a manager or assigned to the KPIAssessment
            return response()->json([
                'status' => false,
                'message' => __('locale.Error 404'),
            ], 404);
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
            return Excel::download(new KPIsExport, 'KPIs.xlsx');
        else
            return 'KPIs.pdf';
    }
    public function notificationsSettingsKPi()
    {
        // defining the breadcrumbs that will be shown in page

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('KPI')],
            ['link' => route('admin.KPI.index'), 'name' => __('locale.KPI')],
            ['name' => __('locale.NotificationsSettings')]
        ];

        $users = User::where('enabled', true)->select('id', 'name')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [28, 29, 30, 74, 83];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [84];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            28 => ['title', 'value_type', 'description', 'value', 'period_of_assessment', 'Created_by', 'Departement_Owner'],
            29 =>  ['title', 'value_type', 'description', 'value', 'period_of_assessment', 'Created_by', 'Departement_Owner'],
            30 => ['title', 'value_type', 'description', 'value', 'period_of_assessment', 'Created_by', 'Departement_Owner'],
            74 => ['Title', 'Description', 'Department_Name', 'Department_Owner'],
            83 => ['Title', 'Description', 'Department_Name', 'Department_Owner', 'assessment_value', 'Kpi_Creator'],
            84 => ['title', 'value_type', 'description', 'value', 'period_of_assessment', 'Created_by', 'Departement_Owner'],

        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [
            28 => ['manager' => __('locale.Kpimanager'), 'creator' => __('locale.KpiCreator')],
            29 => ['manager' => __('locale.Kpimanager'), 'creator' => __('locale.KpiCreator')],
            30 => ['manager' => __('locale.Kpimanager'), 'creator' => __('locale.KpiCreator')],
            74 => ['manager' => __('locale.DepartmentManager'), 'creator' => __('locale.InitiateCreator')],
            83 => ['manager' => __('locale.DepartmentManager'), 'creator' => __('locale.InitiateCreator')],
            84 => ['manager' => __('locale.Kpimanager'), 'creator' => __('locale.KpiCreator')],

        ];
        // getting actions with their system notifications settings, sms settings and mail settings to list them in tables
        $actionsWithSettings = Action::whereIn('actions.id', $moduleActionsIds)
            ->leftJoin('system_notifications_settings', 'actions.id', '=', 'system_notifications_settings.action_id')
            ->leftJoin('mail_settings', 'actions.id', '=', 'mail_settings.action_id')
            ->leftJoin('sms_settings', 'actions.id', '=', 'sms_settings.action_id')
            ->leftJoin('auto_notifies', 'actions.id', '=', 'auto_notifies.action_id')
            ->get([
                'actions.id as action_id',
                'actions.name as action_name',
                'system_notifications_settings.id as system_notification_setting_id',
                'system_notifications_settings.status as system_notification_setting_status',
                'mail_settings.id as mail_setting_id',
                'mail_settings.status as mail_setting_status',
                'sms_settings.id as sms_setting_id',
                'sms_settings.status as sms_setting_status',
                'auto_notifies.id as auto_notifies_id',
                'auto_notifies.status as auto_notifies_status',
            ]);
        $actionsWithSettingsAuto = Action::whereIn('actions.id', $moduleActionsIdsAutoNotify)
            ->leftJoin('auto_notifies', 'actions.id', '=', 'auto_notifies.action_id')
            ->get([
                'actions.id as action_id',
                'actions.name as action_name',
                'auto_notifies.id as auto_notifies_id',
                'auto_notifies.status as auto_notifies_status',
            ]);
        return view('admin.notifications-settings.index', compact('breadcrumbs', 'users', 'actionsWithSettings', 'actionsVariables', 'actionsRoles', 'moduleActionsIdsAutoNotify', 'actionsWithSettingsAuto'));
    }
    public function getUsersByDepartment(Request $request)
    {
        // Find the KPIAssessment by the provided ID in the request
        $assessment = KPIAssessment::find($request->id);

        // If no KPIAssessment exists, return an error response
        if (!$assessment) {
            return response()->json([
                'status' => false,
                'message' => __('locale.AssessmentNotFound'),
            ], 404);
        }

        // Fetch the assigned_to value directly from the KPIAssessment record
        $assignedTo = $assessment->assigned_to;

        // Fetch the users based on the department of the current user, excluding the current user
        $users = User::where('department_id', auth()->user()->department_id)
            ->where('id', '!=', auth()->user()->id)
            ->pluck('name', 'id');

        // Return the users as a JSON response, along with the assigned_to value for pre-select
        return response()->json([
            'users' => $users,
            'assigned_to' => $assignedTo, // Handle case where no assigned user exists
        ]);
    }


    public function StoreAssignedUser(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'id' => 'required|exists:kpi_assessments,id',  // Ensure the KPIAssessment exists
            'assigned_to' => 'required|exists:users,id',  // Ensure the user exists
        ]);

        // Fetch the KPIAssessment record by ID
        $assessment = KPIAssessment::find($request->id);

        // If the KPIAssessment record is not found, return an error
        if (!$assessment) {
            return response()->json([
                'status' => false,
                'message' => __('locale.AssessmentNotFound'),
            ], 404);
        }

        // Update the assigned_to in the KPIAssessment model
        $assessment->assigned_to = $request->assigned_to;

        // Save the changes
        $assessment->save();

        // Return a success response
        return response()->json([
            'status' => true,
            'message' => __('locale.AssignmentSuccessful'),
        ]);
    }
}
