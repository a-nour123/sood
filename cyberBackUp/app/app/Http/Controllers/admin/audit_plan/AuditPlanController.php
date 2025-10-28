<?php

namespace App\Http\Controllers\admin\audit_plan;

use App\Events\AuditResponsibleStoredCreated;
use App\Events\AuditResponsibleUpdated;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\AuditResponsible;
use App\Models\Family;
use App\Models\Framework;
use App\Models\FrameworkControl;
use App\Models\FrameworkControlMapping;
use App\Models\FrameworkControlTestAudit;
use App\Models\Regulator;
use App\Models\Team;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;
use App\Http\Traits\ItemTeamTrait;
use App\Http\Traits\ItemUserTrait;
use App\Models\FrameworkControlTest;
use App\Models\ItemsToUser;
use App\Exports\AuditResultsExport;
use Maatwebsite\Excel\Facades\Excel;

class AuditPlanController extends Controller
{
    use ItemTeamTrait;
    use ItemUserTrait;

    public function index()
    {
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Compliance Framework')],
            ['name' => __('locale.AuditPlan')]
        ];
        $frameworks = Framework::all();
        $regulators = Regulator::select('id', 'name')->get();
        $enabledUsers = User::where('enabled', true)
            ->with('manager:id,name,manager_id')
            ->get();
        $teams = Team::all();
        $auditData = $this->getAllStatusForAllFrameworks();
        $groupedByFramework = Helper::GetAllFrameworksAuditGraph();
        return view('admin.content.audit_plan.index', compact('breadcrumbs', 'frameworks', 'regulators', 'teams', 'enabledUsers', 'auditData', 'groupedByFramework'));
    }

    // Controller method
    public function getFrameworksByRegulator($regulatorId)
    {
        $frameworks = Framework::where('regulator_id', $regulatorId)->get();
        return response()->json($frameworks);
    }

    public function storeAduitResponsible(Request $request)
    {
        try {
            // Validate the request data
            $validated = $request->validate([
                'audit_name' => 'required|string|unique:audits_responsibles,audit_name',
                'regulator_id' => 'required|exists:regulators,id',
                'framework_id' => 'required|exists:frameworks,id',
                'owner_id' => 'required|exists:users,id',
                'responsibleType' => 'required|in:users,teams',
                'responsible' => 'required|array',
                'start_date' => 'required|date',
                'due_date' => 'required|date|after:start_date',
                'periodical_time' => 'required|integer|min:0',
                'next_initiate_date' => 'nullable|date',
            ]);

            // If validation passes, continue with saving data
            $lastintiate = AuditResponsible::where('framework_id', $request->framework_id)->latest()->first()->test_number_initiated ?? 0;

            $responsible = implode(',', $validated['responsible']);

            $audit = new AuditResponsible();
            $audit->regulator_id = $validated['regulator_id'];
            $audit->framework_id = $validated['framework_id'];
            $audit->owner_id = $validated['owner_id'];
            $audit->responsible = $responsible;
            $audit->responsible_type = $validated['responsibleType'];
            $audit->start_date = $validated['start_date'];
            $audit->due_date = $validated['due_date'];
            $audit->periodical_time = $validated['periodical_time'];
            $audit->next_initiate_date = $validated['next_initiate_date'];
            $audit->initiate_date = now();
            $audit->test_number_initiated = $lastintiate + 1;
            $audit->created_by = auth()->user()->id;
            $audit->audit_name =  $validated['audit_name'];

            $audit->save();

            $audit = AuditResponsible::latest()->first();
            event(new AuditResponsibleStoredCreated($audit));

            return response()->json(['success' => true]);
        } catch (ValidationException $e) {
            // Validation failed, return validation errors
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422); // 422 Unprocessable Entity
        } catch (Exception $e) {
            Log::error('Error storing audit responsible', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'error' => 'An error occurred while storing the audit responsible. Please try again later.'
            ], 500);
        }
    }


    public function updateAduitResponsible(Request $request)
    {
        try {
            // Validate the input fields
            $validated = $request->validate([
                'id' => 'required|exists:audits_responsibles,id',
                'owner_id' => 'required|exists:users,id',
                'responsibleTypeEdithidden' => 'required|in:users,teams',
                'responsibleEdit' => [
                    'required',
                    'array',
                    function ($attribute, $value, $fail) use ($request) {
                        // Validate that the array is not empty and does not contain null values
                        if (empty($request->responsibleEdit) || in_array(null, $request->responsibleEdit, true)) {
                            $fail('Please select at least one valid responsible user/team.');
                        }
                    }
                ],
                'start_date' => 'required|date',
                'due_date' => 'required|date|after:start_date',
                'periodical_time' => 'required|integer|min:0',
                'next_initiate_date' => 'nullable|date',
                'test_number_initiated' => 'required|integer',
            ]);

            // Handle the responsible selection
            $responsible = implode(',', $validated['responsibleEdit']);

            // Find the audit record
            $audit = AuditResponsible::find($validated['id']);

            // Check if the owner_id has changed
            if ($audit->owner_id != $validated['owner_id']) {
                // Update the tester field in FrameworkControlTestAudit
                FrameworkControlTestAudit::where('audit_id', $validated['id'])
                    ->update(['tester' => $validated['owner_id']]);
            }
            if ($audit->responsible_type != $validated['responsibleTypeEdithidden']) {
                // Update the tester field in FrameworkControlTestAudit
                $controlsAuditIds = FrameworkControlTestAudit::where('audit_id', $validated['id'])
                    ->pluck('id')->toArray();
                if ($audit->responsible_type == "users") {
                    ItemsToUser::whereIn('item_id', $controlsAuditIds)->delete();
                } else {
                    ItemsToUser::whereIn('item_id', $controlsAuditIds)->delete();
                }
            }
            if ($audit->due_date != $validated['due_date']) {
                // Update the last_date field in FrameworkControlTestAudit
                FrameworkControlTestAudit::where('audit_id', $validated['id'])
                    ->update(['last_date' => $validated['due_date']]);
            }

            if ($audit->next_initiate_date != $validated['next_initiate_date']) {
                // Update the tester field in FrameworkControlTestAudit
                FrameworkControlTestAudit::where('audit_id', $validated['id'])
                    ->update(['next_date' => $validated['next_initiate_date']]);
            }

            if (!$audit) {
                return response()->json(['success' => false, 'message' => 'Audit not found.'], 404);
            }

            // Update the audit with validated data
            $audit->update([
                'owner_id' => $validated['owner_id'],
                'responsible' => $responsible,
                'responsible_type' => $validated['responsibleTypeEdithidden'],
                'start_date' => $validated['start_date'],
                'due_date' => $validated['due_date'],
                'periodical_time' => $validated['periodical_time'],
                'next_initiate_date' => $validated['next_initiate_date'],
                'test_number_initiated' => $validated['test_number_initiated'],
            ]);

            // Trigger the event
            event(new AuditResponsibleUpdated($audit));

            // Return success response
            return response()->json(['success' => true, 'message' => 'Audit updated successfully.']);
        } catch (ValidationException $e) {
            // Return validation errors
            return response()->json([
                'success' => false,
                'errors' => $e->errors() // Validation errors
            ], 422); // 422 Unprocessable Entity
        } catch (Exception $e) {
            // Log unexpected errors
            Log::error('Error updating audit responsible', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Return general error response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the audit. Please try again later.'
            ], 500);
        }
    }


    public function getAuditerDataAudit(Request $request)
    {
        if ($request->ajax()) {
            $userId = auth()->user()->id;

            $query = DB::table('audits_responsibles')
                ->leftJoin('regulators', 'audits_responsibles.regulator_id', '=', 'regulators.id')
                ->leftJoin('frameworks', 'audits_responsibles.framework_id', '=', 'frameworks.id')
                ->leftJoin('users as responsible_users', function ($join) {
                    $join->on(DB::raw('FIND_IN_SET(responsible_users.id, audits_responsibles.responsible)'), '>', DB::raw('0'))
                        ->where('audits_responsibles.responsible_type', 'users');
                })
                ->leftJoin('user_to_teams', function ($join) {
                    $join->on(DB::raw('FIND_IN_SET(user_to_teams.team_id, audits_responsibles.responsible)'), '>', DB::raw('0'))
                        ->where('audits_responsibles.responsible_type', 'teams');
                })
                ->leftJoin('teams', 'user_to_teams.team_id', '=', 'teams.id')
                ->leftJoin('users as owner', 'audits_responsibles.owner_id', '=', 'owner.id')
                ->select([
                    'audits_responsibles.id',
                    'audits_responsibles.test_number_initiated',
                    'audits_responsibles.audit_name',
                    'audits_responsibles.owner_id',
                    'audits_responsibles.created_by',
                    'audits_responsibles.responsible_type',
                    'audits_responsibles.start_date',
                    'audits_responsibles.due_date',
                    'audits_responsibles.periodical_time',
                    'audits_responsibles.initiate_date',
                    'audits_responsibles.next_initiate_date',
                    'regulators.name as regulator_name',
                    'frameworks.name as framework_name',
                    DB::raw('GROUP_CONCAT(DISTINCT IF(audits_responsibles.responsible_type = "users", responsible_users.name, NULL) SEPARATOR ", ") as user_names'),
                    DB::raw('GROUP_CONCAT(DISTINCT IF(audits_responsibles.responsible_type = "teams", teams.name, NULL) SEPARATOR ", ") as team_names'),
                    'owner.name as owner_name',
                    DB::raw('IF(audits_responsibles.start_date IS NOT NULL AND audits_responsibles.start_date < NOW(), 1, NULL) as is_past_due'),
                    'audits_responsibles.framework_id'
                ])
                ->groupBy([
                    'audits_responsibles.id',
                    'audits_responsibles.audit_name',
                    'audits_responsibles.test_number_initiated',
                    'audits_responsibles.owner_id',
                    'audits_responsibles.created_by',
                    'audits_responsibles.responsible_type',
                    'audits_responsibles.start_date',
                    'audits_responsibles.due_date',
                    'audits_responsibles.periodical_time',
                    'audits_responsibles.initiate_date',
                    'audits_responsibles.next_initiate_date',
                    'regulators.name',
                    'frameworks.name',
                    'owner.name',
                    'audits_responsibles.framework_id'
                ])
                ->orderBy('audits_responsibles.id', 'desc');



            $data = $query->get();

            if (!$data->isEmpty()) {
                foreach ($data as $item) {
                    $item->closed_status_percentage = $this->calculateClosedStatusPercentage($item->framework_id, $item->test_number_initiated);
                }
            }

            return DataTables::of($data)
                ->addColumn('auto_increment', function ($row) {
                    static $count = 1;
                    return $count++;
                })
                ->addColumn('actions', function ($row) use ($userId) {
                    if ($row->id === null) {
                        return '';
                    }

                    // Check if the due date has passed
                    $isDueDatePassed = ($row->due_date !== null && strtotime($row->due_date) < strtotime(now()));

                    // Edit button will be hidden if start date is in the past
                    $editButton = !$row->is_past_due && !$isDueDatePassed ? '<a class="dropdown-item edit-btn" data-id="' . $row->id . '"><i class="fas fa-edit"></i> Edit</a>' : '';

                    // Sedation button should only appear if user is owner or creator and due date has not passed
                    $sedationButton = ($userId == $row->owner_id || $userId == $row->created_by) && !$isDueDatePassed
                        ? '<a class="dropdown-item sedation-btn" data-framework-id="' . $row->framework_id . '" data-test-control-number="' . $row->test_number_initiated . '"><i class="fas fa-medkit"></i> ' . __('locale.Sedation') . '</a>'
                        : '';
                    $resultAuditExcelButton = ($userId == $row->owner_id || $userId == $row->created_by)
                            ? '<a class="dropdown-item export-audit-result-btn" data-audit-id="' . $row->id . '">
                                <i class="fas fa-file-export"></i> ' . __('locale.ExportResult') . '
                            </a>'
                        : '';
                    $detailsButton = '<a class="dropdown-item details-btn" data-framework-id="' . $row->framework_id . '" data-test-control-number="' . $row->test_number_initiated . '"><i class="fas fa-eye"></i> ' . __('locale.Details') . '</a>';


                    // Only show dropdown if at least one button should appear and due date has not passed
                    if ($editButton || $sedationButton || $detailsButton || $resultAuditExcelButton) {
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
                                    ' . $sedationButton . '
                                    ' . $resultAuditExcelButton . '
                                    ' . $detailsButton . '
                                    
                                </ul>
                            </div>
                        ';
                    }

                    return '--'; // Return empty string if no buttons should be displayed
                })

                ->addColumn('closed_status_percentage', function ($row) {
                    return $row->closed_status_percentage !== null ? $row->closed_status_percentage . '%' : '';
                })
                ->rawColumns(['actions', 'closed_status_percentage'])
                ->addIndexColumn()
                ->make(true);
        }
    }
    public function calculateClosedStatusPercentage($frameworkId, $test_number_initiated)
    {
        // Fetch control IDs related to the framework
        $controlIds = FrameworkControlMapping::where('framework_id', $frameworkId)
            ->pluck('framework_control_id')
            ->toArray();

        // Fetch the latest controls with the specified test number
        $latestControls = FrameworkControlTestAudit::whereIn('framework_control_id', $controlIds)
            ->whereRaw('JSON_EXTRACT(test_number, "$[0]") = ?', [$test_number_initiated])
            ->get(['framework_control_id', 'status'])
            ->groupBy('framework_control_id');
        // Extract the latest status for each control
        $latestStatus = $latestControls->map(function ($controls) {
            return $controls->sortByDesc('id')->first();
        });

        // Get controls that are not closed
        $controlsNotClosed = $latestStatus->where('status', 2);

        $totalControls = $latestStatus->count();
        $percentage = $totalControls > 0 ? ($controlsNotClosed->count() / $totalControls) * 100 : 0;
        return number_format($percentage, 2); // Format to 2 decimal places
    }

    public function summaryOfResultsForEvaluationAndCompliancedetailsToSedation(Request $request)
    {
        $frameworkId = $request->framework_id;
        $testControlNumber = $request->test_number_initiated;
        $tempFramework = Framework::find($frameworkId);

        if ($testControlNumber && $tempFramework) {
            $frameWorkDomainIds = $tempFramework->only_families()->pluck('families.id')->toArray();
            $frameWorkSubDomainIds = $tempFramework->only_sub_families()->pluck('families.id')->toArray();
            $frameworkControlIds = $tempFramework->FrameworkControls()->pluck('framework_controls.id')->toArray();

            // Fetch all data for FrameworkControl instances with associated test audits
            $ma = FrameworkControl::with(['frameworkControlTestAudits' => function ($query) use ($testControlNumber) {
                $query->whereRaw('JSON_EXTRACT(test_number, "$[0]") = ?', [$testControlNumber]);
            }])->whereIn('id', $frameworkControlIds)->get()->toArray();

            // Fetch only the IDs
            Family::$frameworkControlIds = FrameworkControl::with(['frameworkControlTestAudits' => function ($query) use ($testControlNumber) {
                $query->whereRaw('JSON_EXTRACT(test_number, "$[0]") = ?', [$testControlNumber]);
            }])->whereIn('id', $frameworkControlIds)->pluck('id')->toArray();


            $domains = Family::whereIn('id', $frameWorkDomainIds)->orderBy('order')
                ->with(["families" => function ($q) use ($frameWorkSubDomainIds) {
                    $q->whereIn('id', $frameWorkSubDomainIds);
                }])->get();

            $audit = AuditResponsible::where('framework_id', $frameworkId)
                ->where('test_number_initiated', $testControlNumber)
                ->first();

            $teamNames = [];

            if ($audit && $audit->responsible_type == "teams") {
                // Assuming teams are stored as a comma-separated string in the database
                $teamIds = explode(',', $audit->responsible);
                // Fetch the team names based on the team IDs
                $teamNames = Team::whereIn('id', $teamIds)->pluck('name', 'id')->toArray();
            } else {
                $teamIds = explode(',', $audit->responsible);
                // Fetch the team users based on the team IDs
                $teamNames = User::whereIn('id', $teamIds)->pluck('name', 'id')->toArray();
            }

            return view('admin.content.audit_plan.sedation', [
                'domains' => $domains,
                'audit' => $audit,
                'teamNames' => $teamNames,
                'frameworkId' => $frameworkId,
                'testControlNumber' => $testControlNumber,
                'typeOfSedation' => $audit ? $audit->responsible_type : null
            ])->render();
        }
    }
    public function saveAssignment(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'assignments' => 'required|json',
            'testControlNumber' => 'required|integer',
            'frameworkId' => 'required|integer',
            'assignType' => 'required|string|in:users,teams', // Ensure assignType is either 'users' or 'teams'
        ]);

        // Extract data from the request
        $assignments = json_decode($request->input('assignments'), true);
        $testControlNumber = $request->input('testControlNumber');
        $frameworkId = $request->input('frameworkId');
        $assignType = $request->input('assignType');

        // Validate assignments data
        if (!is_array($assignments)) {
            return response()->json(['success' => false, 'message' => 'Invalid assignments data.']);
        }

        // Process assignments based on assignType
        foreach ($assignments as $domainId => $teamIds) {

            // Query to get all control IDs where the domainId matches the family column
            $controlIds = DB::table('framework_controls')
                ->where('family', $domainId)
                ->pluck('id')
                ->toArray();
            $controlsExistInframe = DB::table('framework_control_mappings')
                ->where('framework_id', $frameworkId)
                ->whereIn('framework_control_id', $controlIds)
                ->pluck('framework_control_id')
                ->toArray();

            // Get the test control IDs
            $controlIdstestAudits = DB::table('framework_control_test_audits')
                ->whereIn('framework_control_id', $controlsExistInframe)
                ->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(test_number, "$[0]")) = ?', [$testControlNumber])
                ->pluck('id')
                ->toArray();


            // Convert team IDs to strings
            $teamIds = array_map('strval', $teamIds);

            foreach ($controlIdstestAudits as $testID) {
                if ($assignType === 'users') {

                    // Call the function to update users of the item
                    $this->UpdateUsersOfItem($testID, 'test', $teamIds);
                    // Corrected update call
                    FrameworkControlTestAudit::where('id', $testID)->update([
                        'can_see' => 1
                    ]);
                } else if ($assignType === 'teams') {
                    // Call the function to update teams of the item
                    $this->UpdateTeamsOfItem($testID, 'test', $teamIds);
                    // Corrected update call
                    FrameworkControlTestAudit::where('id', $testID)->update([
                        'can_see' => 1
                    ]);
                }
            }
        }

        // Additional logic for testControlNumber and frameworkId if needed

        return response()->json(['success' => true, 'message' => 'Assignments saved successfully!']);
    }
    public function exportAuditResult(Request $request)
    {
        $auditId = $request->input('audit_id');

        // Validate the audit_id exists
        if (!AuditResponsible::where('id', $auditId)->exists()) {
            abort(404, 'Audit not found');
        }

        // You can pass any additional data you need here
        $data = []; // Your additional data if needed

        return Excel::download(
            new AuditResultsExport($auditId, $data), // Pass both parameters
            'audit_results_' . $auditId . '.xlsx'
        );
    }


    private function getAllStatusForAllFrameworks()
    {
        // Fetch all frameworks
        $frameworks = Framework::all();
        $auditData = [];

        foreach ($frameworks as $framework) {
            // Get test numbers for the current and previous audits
            $controlId = FrameworkControlMapping::where('framework_id', $framework->id)->latest()->first()->framework_control_id ?? Null;
            $testNumbers = FrameworkControlTestAudit::where('framework_control_id', $controlId)
                ->select(DB::raw("DISTINCT JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[0]')) as test_number"))
                ->orderBy('test_number', 'desc')
                ->limit(2) // Limit to two (current and previous)
                ->pluck('test_number')
                ->toArray();
            $currentTestNumber = $testNumbers[0] ?? null;
            $previousTestNumber = $testNumbers[1] ?? null;

            $auditData[$framework->id] = [
                'framework' => $framework,
                'currentAuditData' => $currentTestNumber ? $this->getAllStatusForAduit($currentTestNumber, $framework->id) : null,
                'previousAuditData' => $previousTestNumber ? $this->getAllStatusForAduit($previousTestNumber, $framework->id) : null,
            ];
        }
        return $auditData;
    }
    private function getAllStatusForAduit($testNumber, $frameworkId)
    {
        // Step 1: Fetch all relevant control IDs along with their children (if any)
        $controls = FrameworkControl::select('framework_controls.id', 'framework_controls.parent_id')
            ->leftJoin('framework_control_mappings', 'framework_controls.id', '=', 'framework_control_mappings.framework_control_id')
            ->whereNull('framework_controls.parent_id')
            ->where('framework_control_mappings.framework_id', $frameworkId)
            ->with('frameworkControls')  // Assuming 'frameworkControls' is the relationship for children
            ->get();

        $parentWithChildren = [];
        $parentWithoutChildren = [];

        // Step 2: Classify controls as having children or not
        foreach ($controls as $control) {
            if ($control->frameworkControls->isNotEmpty()) {
                // Replace with first child
                $firstChildId = $control->frameworkControls->first()->id;
                $parentWithChildren[] = $firstChildId;
            } else {
                $parentWithoutChildren[] = $control->id; // Otherwise, add parent as without children
            }
        }

        // Step 3: Query to get the implemented count for controls with children
        $auditCountChildren = FrameworkControlTestAudit::whereIn('framework_control_id', $parentWithChildren)
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[0]')) = ?", [$testNumber])
            ->whereRaw("IFNULL(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[2]')), ''), 'Not Implemented') = 'Implemented'")
            ->count();

        // Step 4: Query to get the implemented count for controls without children
        $auditCountParents = FrameworkControlTestAudit::whereIn('framework_control_id', $parentWithoutChildren)
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[0]')) = ?", [$testNumber])
            ->whereRaw("IFNULL(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[1]')), ''), 'Not Implemented') = 'Implemented'")
            ->count();
        // Step 5: Calculate totals
        $totalControls = count($parentWithChildren) + count($parentWithoutChildren);
        $totalImplemented = $auditCountChildren + $auditCountParents;
        $percentage = $totalControls > 0 ? number_format($totalImplemented * 100 / $totalControls, 2) : 0;

        // Return the result with separate and combined counts
        return [
            'test_number' => $testNumber ?? 0,
            'status_name' => 'Implemented',
            'child_count' => $auditCountChildren ?? 0,
            'parent_count' => $auditCountParents ?? 0,
            'total_count' => $totalImplemented ?? 0,
            'percentage' => $percentage,
            'total_controls' => $totalControls ?? 0,
        ];
    }
}
