<?php

namespace App\Http\Controllers\admin\compliance;

use App\Exports\FrameworkControlTestAuditsExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FrameworkControlTest;
use App\Models\FrameworkControlTestAudit;
use App\Models\FrameworkControlTestResult;
use App\Models\User;
use App\Models\Framework;
use App\Models\Family;
use App\Models\Team;
use App\Models\FrameworkControl;
use App\Models\TestStatus;
use App\Models\TestResult;
use App\Models\Risk;
use App\Models\FrameworkControlTestResultsToRisk;
use Carbon\Carbon;
use App\Http\Traits\ItemTeamTrait;
use App\Http\Traits\ItemUserTrait;
use App\Models\Asset;
use App\Models\AssetGroup;
use App\Models\Category;
use App\Models\ControlAuditPolicy;
use App\Models\Department;
use App\Models\Document;
use App\Models\Impact;
use App\Models\Likelihood;
use App\Models\Location;
use App\Models\RiskGrouping;
use App\Models\ScoringMethod;
use App\Models\Source;
use App\Models\Tag;
use App\Models\Technology;
use App\Models\ThreatGrouping;
use App\Events\AuditResultCreated;
use App\Models\File;
use App\Models\RiskToAdditionalStakeholder;
use App\Models\RiskToLocation;
use App\Models\RiskToTeam;
use App\Models\RiskToTechnology;
use App\Models\Setting;
use App\Traits\AssetTrait;
use App\Events\AuditRiskCreated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use phpDocumentor\Reflection\PseudoTypes\False_;
use SplFileInfo;
use App\Models\Action;
use App\Models\AuditResponsible;
use App\Models\ControlAuditEvidence;
use App\Models\FrameworkControlExtension;
use App\Models\FrameworkControlMapping;
use App\Models\ItemsToTeam;
use App\Models\ItemsToUser;
use App\Models\RemediationDetail;
use Yajra\DataTables\Facades\DataTables;

class AuditComplianceController extends Controller
{
    use AssetTrait;
    use ItemTeamTrait;
    use ItemUserTrait;
    private $path = 'admin.content.compliance.active-audit';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Compliance Framework')],
            ['name' => __('locale.Active Audits')]
        ];

        $testers = User::all();
        $controls = FrameworkControl::all();
        // Fetch unique frameworks with audited controls
        $frameworks = Framework::query()
            ->join('framework_control_mappings as fcm', 'frameworks.id', '=', 'fcm.framework_id')
            ->join('framework_control_test_audits as fcta', 'fcm.framework_control_id', '=', 'fcta.framework_control_id')
            ->select('frameworks.id', 'frameworks.name')
            ->distinct()
            ->get();
        $families = Family::has('parentFamily')->get();
        $teams = Team::all();
        $firstIndexes = FrameworkControlTestAudit::pluck('test_number')->map(function ($testNumber) {
            $decodedArray = json_decode($testNumber, true);
            return intval($decodedArray[0] ?? 0); // Using intval to convert to integer and providing a default value of 0
        });
        $seriesData = [];
        $chartData = [];
        $remidationdData = [];
        $StatusAduitImp = [];
        $ControlsReqSkipDueDate = [];
        foreach ($frameworks as $framework) {
            // Get count of controls related to each framework
            $controlCount = FrameworkControlMapping::where('framework_id', $framework->id)
                ->count();



            // Get control IDs for the current framework
            $controlIds = FrameworkControlMapping::where('framework_id', $framework->id)
                ->pluck('framework_control_id')
                ->toArray();

            // Get the latest control status data
            $latestControls = FrameworkControlTestAudit::select('framework_control_id', 'status', 'action_status', 'id')
                ->whereIn('framework_control_id', $controlIds)
                ->whereIn('id', function ($query) {
                    $query->select(DB::raw('MAX(id)'))
                        ->from('framework_control_test_audits')
                        ->groupBy('framework_control_id');
                })
                ->get();


            // Total controls and closed controls
            $totalControls = $latestControls->count();
            // $closedStatusId = TestStatus::where('name', 'Closed')->first()->id;
            $closedControls = $latestControls->where('action_status', 1)->count();
            $totalControls = $latestControls->count();

            // Grouping the controls by action_status and counting each group
            $statusCounts = $latestControls->groupBy('action_status')->map(function ($group) {
                return $group->count();
            });
            $notClosedControls = $totalControls - $closedControls;

            // Percentages
            $closedPercentage = $totalControls > 0 ? ($closedControls / $totalControls) * 100 : 0;
            $notClosedPercentage = $totalControls > 0 ? ($notClosedControls / $totalControls) * 100 : 0;

            // Get remediation counts for the current framework
            $remediationCounts = $latestControls->map(function ($control) {
                return RemediationDetail::where('control_test_id', $control->id)->count();
            })->sum();
            $StatusAduitImp[] = [$this->getDefaultStatus($framework->id)];
            $ControlsReqSkipDueDate[] = $this->getDefaultRequirementSkipDueDate($framework->id);
            // Add data to remidationdData array
            $remidationdData[] = [
                'frameworkName' => $framework->name,
                'remediationCounts' => $remediationCounts,
            ];

            // Add to chartData if total controls > 0
            if ($totalControls > 0) {
                $chartData[] = [
                    'frameworkName' => $framework->name,
                    'closedControls' => $closedControls,
                    'notClosedControls' => $notClosedControls,
                    'closedPercentage' => $closedPercentage,
                    'notClosedPercentage' => $notClosedPercentage
                ];
            }
            // Add the data to the series array
            $seriesData[] = [
                'id' => $framework->id,
                'name' => $framework->name,
                'data' => $closedPercentage ?? 0,
            ];
        }
        // Filter out null or non-integer values if needed
        $testNumbers = $firstIndexes->filter(function ($value) {
            return is_int($value);
        })->unique();

        $totalRemediationCounts = array_sum(array_column($remidationdData, 'remediationCounts'));

        return view($this->path . '.index', compact('frameworks', 'ControlsReqSkipDueDate', 'StatusAduitImp', 'remidationdData', 'totalRemediationCounts', 'chartData', 'seriesData', 'families', 'controls', 'testers', 'breadcrumbs', 'teams', 'testNumbers'));
    }


    private function getDefaultStatus($id)
    {
        $frameworkId =  $id;

        // Get parent controls
        $controlIds = FrameworkControl::select('framework_controls.*')
            ->leftJoin('framework_control_mappings', 'framework_controls.id', '=', 'framework_control_mappings.framework_control_id')
            ->whereNull('framework_controls.parent_id')
            ->where('framework_control_mappings.framework_id', $frameworkId)
            ->pluck('id')
            ->toArray();

        $numcontrolIds = count($controlIds);

        // Get existing control test audits
        $existingIds = FrameworkControlTestAudit::whereIn('framework_control_id', $controlIds)
            ->distinct()
            ->pluck('framework_control_id')
            ->toArray();

        // Get non-existing controls and fetch their first child IDs
        $nonExistingIds = array_diff($controlIds, $existingIds);
        $childIds = FrameworkControl::whereIn('parent_id', $nonExistingIds)
            ->selectRaw('MIN(id) as first_child_id')
            ->groupBy('parent_id')
            ->pluck('first_child_id')
            ->toArray();

        // Fetch test numbers for parent and child controls
        $auditsTestNumbers = FrameworkControlTestAudit::whereIn('framework_control_id', $existingIds)
            ->selectRaw("JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[0]')) AS first_test_number")
            ->distinct()
            ->pluck('first_test_number')
            ->toArray();

        $auditsTestNumbersChild = FrameworkControlTestAudit::whereIn('framework_control_id', $childIds)
            ->selectRaw("JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[0]')) AS first_test_number")
            ->distinct()
            ->pluck('first_test_number')
            ->toArray();

        $encounteredTestNumbers = [];
        $countsByTestNumber = [];

        foreach (array_merge($auditsTestNumbers, $auditsTestNumbersChild) as $testNumber) {
            if (!in_array($testNumber, $encounteredTestNumbers)) {
                $encounteredTestNumbers[] = $testNumber;

                // Default status
                $childStatus = "Not Implemented";  // Default status if not found

                $auditCountAll = FrameworkControlTestAudit::whereIn('framework_control_id', $existingIds)
                    ->where(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[0]'))"), $testNumber)
                    ->where(function ($query) {
                        $query->where(DB::raw("IFNULL(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[1]')), ''), 'Not Implemented')"), 'Implemented');
                    })
                    ->orWhereIn('framework_control_id', $childIds)
                    ->where(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[0]'))"), $testNumber)
                    ->where(function ($query) {
                        $query->where(DB::raw("IFNULL(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[2]')), ''), 'Not Implemented')"), 'Implemented');
                    })
                    ->count();

                $childStatus = $auditCountAll > 0 ? 'Implemented' : 'Not Implemented';

                $countsByTestNumber[] = [
                    'test_number' => $testNumber,
                    'status_name' => $childStatus,
                    'count' => $auditCountAll,
                    'percentage' => $numcontrolIds > 0 ? number_format($auditCountAll * 100 / $numcontrolIds, 2) : 0,
                    'total_controls' => $numcontrolIds
                ];
            }
        }

        $jsonString = json_encode(['countsByTestNumber' => $countsByTestNumber]);
        return $jsonString;
    }


    private function getDefaultRequirementSkipDueDate($id)
    {
        // Fetch all framework_control_ids associated with the given framework ID
        $controlIds = FrameworkControlMapping::where('framework_id', $id)
            ->pluck('framework_control_id')
            ->toArray();

        // Get the latest control status data with ControlAuditObjectives and related controlControlObjective
        $frameworkControlTestAudits = FrameworkControlTestAudit::with([
            'ControlAuditObjectives.controlControlObjective:id,due_date'
        ])
            ->whereIn('framework_control_id', $controlIds)
            ->whereIn('id', function ($query) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('framework_control_test_audits')
                    ->groupBy('framework_control_id');
            })
            ->get();

        // Initialize counts and arrays
        $objectivesWithoutActionCount = 0;
        $totalRequirements = 0;

        // Count ControlAuditObjectives and others
        foreach ($frameworkControlTestAudits as $frameworkControlTestAudit) {
            foreach ($frameworkControlTestAudit->ControlAuditObjectives as $controlAuditObjective) {
                // Count objectives without action specifically
                if ($controlAuditObjective->objective_audit_status == 'no_action') {
                    // Check if the related controlControlObjective has a due_date
                    if (!empty($controlAuditObjective->controlControlObjective->due_date)) {
                        // Convert due_date to a Carbon instance and compare it with today's date
                        if (Carbon::parse($controlAuditObjective->controlControlObjective->due_date)->lt(Carbon::today())) {
                            // If due_date is less than today, increment the counter
                            $objectivesWithoutActionCount++;
                        }
                    }
                }

                $totalRequirements++;
            }
        }

        // Calculate percentage
        $percentageWithoutAction = $totalRequirements > 0 ? ($objectivesWithoutActionCount / $totalRequirements) * 100 : 0;

        return [
            'Objectives without Action' => $objectivesWithoutActionCount,
            'Total Requirements' => $totalRequirements,
            'percentage without action' => number_format($percentageWithoutAction, 2), // Formatting percentage to 2 decimal places
        ];
    }






    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function PastAudits()
    {
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Compliance Framework')],
            ['name' => __('locale.Past Audits')]
        ];

        $testers = User::all();
        $controls = FrameworkControl::all();
        $frameworks = Framework::all();
        $families = Family::all();
        $teams = Team::all();

        return view($this->path . '.past-audits', compact('frameworks', 'families', 'controls', 'testers', 'breadcrumbs', 'teams'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ListTestIds = explode(',', $request->id);
        $ListTestIds = array_filter($ListTestIds, 'strlen');
        foreach ($ListTestIds as $id) {


            $test = FrameworkControlTest::find($id);

            $lastTestLog = $test->FrameworkControlTestAudits()->orderBy('id', 'desc')->first() ?? null;
            $lastDate = null;
            $nextDate = null;

            if ($lastTestLog) {
                $lastDate = $lastTestLog->next_date;
                $nextDate = date('Y-m-d', strtotime($lastDate) + ($test->test_frequency ?? 0) * 24 * 60 * 60);
            } else {
                $lastDate = $test->last_date;
                $nextDate = date('Y-m-d', strtotime($lastDate) + ($test->test_frequency ?? 0) * 24 * 60 * 60);
            }

            $countAudit = $test->FrameworkControlTestAudits->count() + 1;
            $auditName = $test->name . "(" . $countAudit . ")";

            $audit = FrameworkControlTestAudit::create([
                'test_id' => $test->id,
                'tester' => $test->tester,
                'last_date' => $lastDate,
                'next_date' => $nextDate,
                'name' => $auditName,
                'test_steps' => $test->test_steps,
                'status' => 1,
                'approximate_time' => $test->approximate_time,
                'framework_control_id' => $test->framework_control_id,
                'expected_results' => $test->expected_results,
                'desired_frequency' => $test->desired_frequency,
                'test_frequency' => $test->test_frequency,
            ]);
            FrameworkControlTestResult::create([
                'test_audit_id' => $audit->id
            ]);

            $message =  __(
                'compliance.NotifyAuditCreated',
                [
                    'user' => auth()->user()->name
                ]
            );
            write_log($audit->id, auth()->id(), $message, FrameworkControlTestAudit::class);
        }
        return response()->json($ListTestIds, 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.compliance.audit.index'), 'name' => __('locale.Compliance')],
            ['name' => __('locale.ViewActiveAudits')]
        ];

        $frameworkControlTestAudit = FrameworkControlTestAudit::with('compliance_files:ref_id,name,unique_name', 'UserTester:id,name', 'ControlAuditPolicies', 'controlAuditObjectives')
            ->findOrFail($id);

        // Check if the user has permission to view all audits
        if (!auth()->user()->hasPermission('audits.all')) {
            if (isDepartmentManager()) {
                // Logic for department manager
                $departmentId = Department::where('manager_id', auth()->id())->first()->id;
                $departmentMembersIds = User::with('teams')
                    ->where('department_id', $departmentId)
                    ->orWhere('id', auth()->id())
                    ->pluck('id')
                    ->toArray();

                // Collect assistant audit IDs for all department members
                $assistantAuditIds = [];

                foreach ($departmentMembersIds as $memberId) {
                    // Ensure that this returns an array, not a boolean
                    $assistantAuditIds = array_merge($assistantAuditIds, $this->CanAuditInTheControl($id, $frameworkControlTestAudit));
                }

                // Remove duplicates from the assistantAuditIds
                $assistantAuditIds = array_unique($assistantAuditIds);

                // Check if the authenticated user is either the tester or part of the assistant audit IDs
                if (empty($assistantAuditIds) && !in_array($frameworkControlTestAudit['tester'], $assistantAuditIds)) {
                    abort(403, 'Unauthorized');
                }
            } else {
                // Regular user checks: Allow if the user is the tester or can audit the control
                if (
                    !$this->CanAuditInTheControl($id, $frameworkControlTestAudit) &&  // Check if the user can audit this control
                    $frameworkControlTestAudit['tester'] !== auth()->id()  // Ensure the user is not the tester
                ) {
                    abort(403, 'Unauthorized');
                }
            }
        }

        $editable = true;
        $pending = true;

        // Check if the framework control has many audits and this audit isn't last audit
        if (!$this->isLastAudit($frameworkControlTestAudit)) {
            $editable = false;
            // return redirect()->route('admin.compliance.audit.index');
        }
        if (!$this->closedAduit($frameworkControlTestAudit)) {
            $editable = false;
            // return redirect()->route('admin.compliance.audit.index');
        }
        // the auditer give the control status closed now for reason
        if (!$this->closedAduitAction($frameworkControlTestAudit)) {
            $editable = false;
            // return redirect()->route('admin.compliance.audit.index');
        }
        if (!$this->pendingAduit($frameworkControlTestAudit)) {
            $pending = false;
            // return redirect()->route('admin.compliance.audit.index');
        }
        $mapping = FrameworkControlExtension::where('control_id', $frameworkControlTestAudit->framework_control_id)->exists();




        $frameworkControlTestResult = $frameworkControlTestAudit->FrameworkControlTestResult;
        $auditStatusGroups = TestStatus::all();

        // $frameworkControlTestAuditsmapping = FrameworkControlTestAudit::with([
        //     'compliance_files:ref_id,name,unique_name',
        //     'UserTester:id,name',
        //     'ControlAuditPolicies',
        //     'controlAuditObjectives'
        // ])
        // ->whereIn('test_id', $extensionControls)
        // ->get();

        $extensionControls = FrameworkControlExtension::where('control_id', $frameworkControlTestAudit->framework_control_id)
            ->pluck('extend_control_id')
            ->toArray();
        $relatedControls = FrameworkControl::whereIn('id', $extensionControls)->get();

        $controlOwner = $frameworkControlTestAudit->FrameworkControl->control_owner;

        // Calculate the combined status of related controls
        // Merge $frameworkControl status with $relatedControls
        // Filter out duplicate controls by ID
        $uniqueControls = $relatedControls->unique('id');
        // Calculate the combined status of related controls including $frameworkControl
        $relatedStatus = $this->calculateCombinedStatus($uniqueControls);


        // // Set test results depending on control audit policies
        // $testResultGroups = [];
        // // here i checj the total of objective and the polices and the total of implemented of control that he related to them
        // if (count($frameworkControlTestAudit->ControlAuditPolicies) == 0 && count($frameworkControlTestAudit->ControlAuditObjectives) == 0 && $relatedStatus != "Not Implemented" && $relatedStatus == "Not Applicable" && $relatedStatus != "Partially Implemented") // There is no control audit policies or Objectives
        //     $testResultGroups = TestResult::all();
        // else { // There are control audit policies or objectives
        //     $controlAuditPolicyAndObjectiveActions = [];
        //     $controlAuditPolicyAndObjectiveActions['no_action'] = 0;
        //     $controlAuditPolicyAndObjectiveActions['approved'] = 0;
        //     $controlAuditPolicyAndObjectiveActions['rejected'] = 0;
        //     if ($frameworkControlTestAudit->ControlAuditPolicies) {
        //         foreach ($frameworkControlTestAudit->ControlAuditPolicies as $controlAuditPolicy) {
        //             $controlAuditPolicyAndObjectiveActions[$controlAuditPolicy->document_audit_status]++;
        //         }
        //     }
        //     if ($frameworkControlTestAudit->ControlAuditObjectives) {
        //         foreach ($frameworkControlTestAudit->ControlAuditObjectives as $controlAuditObjective) {
        //             $controlAuditPolicyAndObjectiveActions[$controlAuditObjective->objective_audit_status]++;
        //         }
        //     }
        //     /* Values of test results */
        //     /*
        //         "1" => 'Not Applicable',
        //         "2" => 'Not Implemented',
        //         "3" => 'Partially Implemented',
        //         "4" => 'Implemented',
        //     */
        //     $testResultIds = [];
        //     $testResultIds[] = 1; // Append 'Not Applicable'
        //     $testResultIds[] = 2; // Append 'Not Implemented'
        //     // Initialize the test result IDs based on conditions

        //     // Check if all control audit policies have actions
        //     if ($controlAuditPolicyAndObjectiveActions['no_action'] == 0) {
        //         // Check if all control audit policies and objectives are approved
        //         if ($controlAuditPolicyAndObjectiveActions['approved'] == (count($frameworkControlTestAudit->ControlAuditPolicies) + count($frameworkControlTestAudit->ControlAuditObjectives))) {
        //             // All control audit policies and objectives are approved
        //             if ($relatedStatus == "Partially Implemented" || $relatedStatus == "Not Implemented") {
        //                 $testResultIds = [1, 2, 3]; // 'Not Applicable', 'Not Implemented', and 'Partially Implemented'
        //             } else {
        //                 $testResultIds = [1, 2, 3, 4]; // 'Not Applicable', 'Not Implemented', 'Partially Implemented', and 'Implemented'
        //             }
        //         } elseif ($controlAuditPolicyAndObjectiveActions['approved'] > 0) {
        //             // Some control audit policies are approved
        //             $testResultIds = [1, 2, 3]; // 'Not Applicable', 'Not Implemented', and 'Partially Implemented'
        //         } else {
        //             // No control audit policies are approved
        //             if ($relatedStatus == "Partially Implemented" || $relatedStatus == "Implemented") {
        //                 $testResultIds = [1, 2, 3]; // 'Not Applicable', 'Not Implemented', and 'Partially Implemented'
        //             }
        //         }
        //     } else {
        //         // Some control audit policies have no action
        //         if ($relatedStatus == "Partially Implemented" || $relatedStatus == "Implemented") {
        //             $testResultIds = [1, 2, 3]; // 'Not Applicable', 'Not Implemented', and 'Partially Implemented'
        //         }
        //     }

        //     // Fetch the test result groups based on the determined IDs
        //     $testResultGroups = TestResult::whereIn('id', $testResultIds)->get();
        // }
        $frameworksId = Framework::with('FrameworkControls:id')->get();
        $testNumber = FrameworkControlTestAudit::where('id', $id)
            ->selectRaw('JSON_EXTRACT(test_number, "$[0]") as first_index')
            ->value('first_index');

        // Ensure $frameworkIds is an array of IDs
        $frameworkIds = $frameworksId->pluck('id')->toArray();

        // Query AuditResponsible with the list of framework IDs
        $existingUserOrTeam = AuditResponsible::whereIn('framework_id', $frameworkIds)
            ->where('test_number_initiated', $testNumber)
            ->select('responsible_type', 'responsible', 'owner_id', 'id', 'due_date')
            ->first(); // Use first() to get only the first result
        if ($existingUserOrTeam) {
            if ($existingUserOrTeam->responsible_type == "users") {

                // Convert the comma-separated string to an array of IDs
                $responsibleIds = explode(',', $existingUserOrTeam->responsible);
                // Ensure IDs are integers
                $responsibleIds = array_map('intval', $responsibleIds);

                // Query User model using whereIn with the array of IDs
                $teams = User::whereIn('id', $responsibleIds)->select('id', 'name')->get();

                // If you need to get specific user names or perform additional operations
                $testTeams = $this->GetUsersOfItem($frameworkControlTestAudit->id, 'test');

                $testTeamsNames = User::whereIn('id', $testTeams)->pluck('name')->toArray();
            } else {
                // Convert the comma-separated string to an array of IDs
                $responsibleIds = explode(',', $existingUserOrTeam->responsible);
                // Ensure IDs are integers
                $responsibleIds = array_map('intval', $responsibleIds);
                // Query User model using whereIn with the array of IDs
                $teams = Team::whereIn('id', $responsibleIds)->get();
                // If you need to get specific user names or perform additional operations
                $testTeams = $this->GetTeamsOfItem($frameworkControlTestAudit->id, 'test');

                $testTeamsNames = Team::whereIn('id', $testTeams)->pluck('name')->toArray();
            }
        }

        $testers = User::all();
        $comments = $frameworkControlTestAudit->FrameworkControlTestComments;
        $SelectedRiskIds = FrameworkControlTestResultsToRisk::where('test_results_id', $frameworkControlTestResult->id)->pluck('risk_id')->toArray();
        $remediationDetails = RemediationDetail::where('control_test_id', $id)->first();
        if ($remediationDetails && !empty($remediationDetails->due_date)) {
            $remediationDetails->due_date = \Carbon\Carbon::parse($remediationDetails->due_date)->format('Y-m-d');
        }
        $resultRisks = Risk::whereIn('id', $SelectedRiskIds)->get();
        $risks = Risk::all();
        //data show in the info tab 
        $aduiterResponsible = $existingUserOrTeam->owner->name ?? null;
        $testAssistants = $testTeamsNames ?? null;
        $dueDate = $existingUserOrTeam->due_date ?? null;
        // Initialize arrays to store evidence IDs, responsible users, and responsible teams
        // Initialize arrays to store evidence IDs, responsible users, and responsible teams
        $evidenceIds = [];
        $responsibleUsers = [];
        $responsibleTeams = [];

        // Loop through each ControlAuditEvidence related to the FrameworkControlTestAudit
        $frameworkControlTestAudit->controlAuditObjectives->each(function ($evidence) use (&$responsibleUsers, &$responsibleTeams) {

            // Get the related ControlControlObjective through the Evidence model
            $controlObjective = $evidence->controlControlObjective ?? null;

            // Check if the ControlControlObjective exists
            if ($controlObjective) {
                // If a responsible user exists, add their name to the $responsibleUsers array
                if ($controlObjective->responsibleUser) {
                    $responsibleUsers[] = $controlObjective->responsibleUser->name;
                }

                // If a responsible team exists, add their name to the $responsibleTeams array
                if ($controlObjective->responsibleTeam) {
                    $responsibleTeams[] = $controlObjective->responsibleTeam->name;
                }
            }
        });

        // Combine responsible users and teams into a single array
        $collectiveEvidenceArray = array_merge($responsibleUsers, $responsibleTeams);

        // Use implode to convert the array into a string with each name separated by a comma
        $collectiveEvidence = implode(', ', array_unique($collectiveEvidenceArray));

        // data show in the info tab 

        $riskGroupings = RiskGrouping::with('RiskCatalogs:id,number,name,risk_grouping_id')->get();
        $threatGroupings = ThreatGrouping::with('ThreatCatalogs:id,number,name,threat_grouping_id')->get();
        $categories = Category::all();
        $locations = Location::all();
        $frameworks = Framework::with('FrameworkControls:id,short_name,control_number')->get();
        $assets = Asset::select('id', 'name')->orderBy('id')->get();
        $assetGroups = AssetGroup::all();
        $technologies = Technology::all();
        $enabledUsers = User::where('enabled', true)->with('manager:id,name,manager_id')->get();
        $tags = Tag::all();
        if (isDepartmentManager()) {
            $departmentId = (Department::where('manager_id', auth()->id())->first())->id;
            $owners = User::where('department_id', $departmentId)->orWhere('id', auth()->id())->get();
        } else {
            $departmentManagersIds = Department::pluck('manager_id')->toArray();
            $owners = User::whereIn('id', $departmentManagersIds)->get();
        }
        $riskSources = Source::all();
        $riskScoringMethods = ScoringMethod::all();
        $riskLikelihoods = Likelihood::all();
        $impacts = Impact::all();

        // return count($resultRisks);
        return view($this->path . '.view', compact('auditStatusGroups', 'controlOwner', 'remediationDetails', 'aduiterResponsible', 'testAssistants', 'dueDate', 'collectiveEvidence', 'frameworkControlTestAudit', 'frameworkControlTestResult', 'testers', 'teams', 'breadcrumbs', 'id', 'testTeams', 'comments', 'risks', 'SelectedRiskIds', 'resultRisks', 'riskGroupings', 'threatGroupings', 'locations', 'frameworks', 'assets', 'assetGroups', 'categories', 'technologies', 'enabledUsers', 'riskSources', 'riskScoringMethods', 'riskLikelihoods', 'impacts', 'tags', 'editable', 'testTeamsNames', 'owners', 'mapping', 'pending', 'existingUserOrTeam'));
    }

    public function fetchChartDataForAuditLive(Request $request)
    {
        $id = $request->input('id'); // Retrieve the ID from the request
        $frameworkControlTestAudit = FrameworkControlTestAudit::with('ControlAuditObjectives')->findOrFail($id);
        $controlAuditEvidences = ControlAuditEvidence::where('framework_control_test_audit_id', $id)->get();

        $objectives = [
            'approved' => $frameworkControlTestAudit->ControlAuditObjectives->where('objective_audit_status', 'approved')->count(),
            'rejected' => $frameworkControlTestAudit->ControlAuditObjectives->where('objective_audit_status', 'rejected')->count(),
            'noAction' => $frameworkControlTestAudit->ControlAuditObjectives->where('objective_audit_status', 'no_action')->count(),
            'total' => $frameworkControlTestAudit->ControlAuditObjectives->count(),
        ];

        $evidences = [
            'approved' => $controlAuditEvidences->where('evidence_audit_status', 'approved')->count(),
            'rejected' => $controlAuditEvidences->where('evidence_audit_status', 'rejected')->count(),
            'notRelevant' => $controlAuditEvidences->where('evidence_audit_status', 'not_relevant')->count(),
            'noAction' => $controlAuditEvidences->where('evidence_audit_status', 'no_action')->count(),
            'total' => $controlAuditEvidences->count(),
        ];

        return response()->json([
            'objectives' => $objectives,
            'evidences' => $evidences,
        ]);
    }



    public function fetchTestResults(Request $request)
    {
        // Assuming $frameworkControlTestAudit is retrieved based on some criteria (e.g., ID from the request)
        $frameworkControlTestAudit = FrameworkControlTestAudit::find($request->framework_control_test_audit_id);
        $extensionControls = FrameworkControlExtension::where('control_id', $frameworkControlTestAudit->framework_control_id)
            ->pluck('extend_control_id')
            ->toArray();
        $relatedControls = FrameworkControl::whereIn('id', $extensionControls)->get();

        $controlOwner = $frameworkControlTestAudit->FrameworkControl->control_owner;

        // Calculate the combined status of related controls
        // Merge $frameworkControl status with $relatedControls
        // Filter out duplicate controls by ID
        $uniqueControls = $relatedControls->unique('id');
        // Calculate the combined status of related controls including $frameworkControl
        $relatedStatus = $this->calculateCombinedStatus($uniqueControls);

        // Set test results depending on control audit policies
        $testResultGroups = [];
        // here i checj the total of objective and the polices and the total of implemented of control that he related to them
        if (
            // count($frameworkControlTestAudit->ControlAuditPolicies) == 0 && 
            count($frameworkControlTestAudit->ControlAuditObjectives) == 0 && $relatedStatus != "Not Implemented" && $relatedStatus == "Not Applicable" && $relatedStatus != "Partially Implemented"
        ) // There is no control audit policies or Objectives
            $testResultGroups = TestResult::all();
        else { // There are control audit policies or objectives
            $controlAuditPolicyAndObjectiveActions = [];
            $controlAuditPolicyAndObjectiveActions['no_action'] = 0;
            $controlAuditPolicyAndObjectiveActions['approved'] = 0;
            $controlAuditPolicyAndObjectiveActions['rejected'] = 0;
            // if ($frameworkControlTestAudit->ControlAuditPolicies) {
            //     foreach ($frameworkControlTestAudit->ControlAuditPolicies as $controlAuditPolicy) {
            //         $controlAuditPolicyAndObjectiveActions[$controlAuditPolicy->document_audit_status]++;
            //     }
            // }
            if ($frameworkControlTestAudit->ControlAuditObjectives) {
                foreach ($frameworkControlTestAudit->ControlAuditObjectives as $controlAuditObjective) {
                    $controlAuditPolicyAndObjectiveActions[$controlAuditObjective->objective_audit_status]++;
                }
            }
            /* Values of test results */
            /*
                       "1" => 'Not Applicable',
                       "2" => 'Not Implemented',
                       "3" => 'Partially Implemented',
                       "4" => 'Implemented',
                   */
            $testResultIds = [];
            $testResultIds[] = 1; // Append 'Not Applicable'
            $testResultIds[] = 2; // Append 'Not Implemented'
            // Initialize the test result IDs based on conditions

            // Check if all control audit policies have actions
            if ($controlAuditPolicyAndObjectiveActions['no_action'] == 0) {
                // Check if all control audit policies and objectives are approved
                if ($controlAuditPolicyAndObjectiveActions['approved'] == (
                    // count($frameworkControlTestAudit->ControlAuditPolicies) + 
                    count($frameworkControlTestAudit->ControlAuditObjectives))) {
                    // All control audit policies and objectives are approved
                    if ($relatedStatus == "Partially Implemented" || $relatedStatus == "Not Implemented") {
                        $testResultIds = [1, 2, 3]; // 'Not Applicable', 'Not Implemented', and 'Partially Implemented'
                    } else {
                        $testResultIds = [1, 2, 3, 4]; // 'Not Applicable', 'Not Implemented', 'Partially Implemented', and 'Implemented'
                    }
                } elseif ($controlAuditPolicyAndObjectiveActions['approved'] > 0) {
                    // Some control audit policies are approved
                    $testResultIds = [1, 2, 3]; // 'Not Applicable', 'Not Implemented', and 'Partially Implemented'
                } else {
                    // No control audit policies are approved
                    if ($relatedStatus == "Partially Implemented" || $relatedStatus == "Implemented") {
                        $testResultIds = [1, 2, 3]; // 'Not Applicable', 'Not Implemented', and 'Partially Implemented'
                    }
                }
            } else {
                // Some control audit policies have no action
                if ($relatedStatus == "Partially Implemented" || $relatedStatus == "Implemented") {
                    $testResultIds = [1, 2, 3]; // 'Not Applicable', 'Not Implemented', and 'Partially Implemented'
                }
            }

            // Fetch the test result groups based on the determined IDs
            $testResultGroups = TestResult::whereIn('id', $testResultIds)->get();
        }
        return response()->json($testResultGroups);
    }


    private function CanAuditInTheControl($itemId, $frameworkControlTestAudit)
    {
        $userIdsFromItemsToUsers = [];
        $userIdsFromUserToTeams = [];

        if ($frameworkControlTestAudit->auditResponsible->responsible_type === "users") {
            $userIdsFromItemsToUsers = DB::table('items_to_users')
                ->where('item_id', $itemId)
                ->pluck('user_id')
                ->toArray();
        } else {
            $teamIds = DB::table('items_to_teams')
                ->where('item_id', $itemId)
                ->pluck('team_id')
                ->toArray();

            $userIdsFromUserToTeams = DB::table('user_to_teams')
                ->whereIn('team_id', $teamIds)
                ->pluck('user_id')
                ->toArray();
        }

        // Merge both arrays and ensure uniqueness
        $allUserIds = array_unique(array_merge($userIdsFromItemsToUsers, $userIdsFromUserToTeams));

        // Return the array of user IDs, even if it's empty
        return $allUserIds; // Ensure this is always an array
    }









    // public function edit($id)
    // {
    //     $breadcrumbs = [
    //         ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
    //         ['link' => route('admin.compliance.audit.index'), 'name' => __('locale.Compliance')], ['name' => __('locale.ViewActiveAudits')]
    //     ];
    //     $frameworkControlTestAudit = FrameworkControlTestAudit::with('compliance_files:ref_id,name,unique_name', 'UserTester:id,name', 'ControlAuditPolicies', 'controlAuditObjectives')->findOrFail($id);
    //     if (!auth()->user()->hasPermission('audits.all')) {
    //         if (isDepartmentManager()) {
    //             $departmentId = (Department::where('manager_id', auth()->id())->first())->id;
    //             $departmentMembersIds =  User::with('teams')->where('department_id', $departmentId)->orWhere('id', auth()->id())->pluck('id')->toArray();
    //             if (!in_array($frameworkControlTestAudit['tester'], $departmentMembersIds)) {
    //                 abort(403, 'Unauthorized');
    //             }
    //         } elseif (!$frameworkControlTestAudit['tester'] == auth()->id()) {
    //             abort(403, 'Unauthorized');
    //         }
    //     }
    //     $editable = true;
    //     // Check if the framework control has many audits and this audit isn't last audit
    //     if (!$this->isLastAudit($frameworkControlTestAudit)) {
    //         $editable = false;
    //         // return redirect()->route('admin.compliance.audit.index');
    //     }
    //     if (!$this->closedAduit($frameworkControlTestAudit)) {
    //         $editable = false;
    //         // return redirect()->route('admin.compliance.audit.index');
    //     }
    //     // dd($frameworkControlTestAudit->controlAuditObjectives);
    //     $mapping = FrameworkControlExtension::where('control_id', $frameworkControlTestAudit->framework_control_id)->exists();



    //     $frameworkControlTestResult = $frameworkControlTestAudit->FrameworkControlTestResult;
    //     $auditStatusGroups = TestStatus::all();

    //     // Get the extension controls related to the framework control


    //     // Retrieve the 'extend_control_id' values for the given 'framework_control_id'
    //     $extensionControls = FrameworkControlExtension::where('control_id', $frameworkControlTestAudit->framework_control_id)
    //         ->pluck('extend_control_id')
    //         ->toArray();

    //     // Fetch the latest 'FrameworkControlTestAudit' records where 'test_id' is in the retrieved 'extend_control_id' values
    //     $frameworkControlTestAuditsmapping = FrameworkControlTestAudit::with([
    //         'compliance_files:ref_id,name,unique_name',
    //         'UserTester:id,name',
    //         'ControlAuditPolicies',
    //         'controlAuditObjectives'
    //     ])
    //         ->whereIn('test_id', $extensionControls)
    //         ->whereIn('id', function ($query) {
    //             // Use a subquery to get the latest 'id' for each 'framework_control_id'
    //             $query->selectRaw('MAX(id)')
    //                 ->from('framework_control_test_audits')
    //                 ->groupBy('framework_control_id');
    //         })
    //         ->get();

    //     // Initialize counters for policies and objectives
    //     $policiesCount = 0;
    //     $objectivesCount = 0;

    //     // Initialize an array to hold the counts for each status
    //     $controlAuditPolicyAndObjectiveActionsMapping = [
    //         'no_action' => 0,
    //         'approved' => 0,
    //         'rejected' => 0
    //     ];

    //     // Iterate through each 'FrameworkControlTestAudit' record in the collection
    //     foreach ($frameworkControlTestAuditsmapping as $audit) {
    //         // Count related 'ControlAuditPolicies' and 'controlAuditObjectives'
    //         $policiesCount += $audit->ControlAuditPolicies->count();
    //         $objectivesCount += $audit->controlAuditObjectives->count();

    //         // For each 'ControlAuditPolicy', increment the corresponding status count
    //         foreach ($audit->ControlAuditPolicies as $controlAuditPolicy) {
    //             $controlAuditPolicyAndObjectiveActionsMapping[$controlAuditPolicy->document_audit_status]++;
    //         }

    //         // For each 'controlAuditObjective', increment the corresponding status count
    //         foreach ($audit->controlAuditObjectives as $controlAuditObjective) {
    //             $controlAuditPolicyAndObjectiveActionsMapping[$controlAuditObjective->objective_audit_status]++;
    //         }
    //     }



    //     // Set test results depending on control audit policies
    //     $testResultGroups = [];
    //     // here i checj the total of objective and the polices and the total of implemented of control that he related to them
    //     if (count($frameworkControlTestAudit->ControlAuditPolicies) == 0 && count($frameworkControlTestAudit->ControlAuditObjectives) == 0 && $objectivesCount == 0 && $policiesCount == 0) // There is no control audit policies or Objectives
    //         $testResultGroups = TestResult::all();
    //     else { // There are control audit policies or objectives
    //         $controlAuditPolicyAndObjectiveActions = [];
    //         $controlAuditPolicyAndObjectiveActions['no_action'] = 0;
    //         $controlAuditPolicyAndObjectiveActions['approved'] = 0;
    //         $controlAuditPolicyAndObjectiveActions['rejected'] = 0;
    //         if ($frameworkControlTestAudit->ControlAuditPolicies) {
    //             foreach ($frameworkControlTestAudit->ControlAuditPolicies as $controlAuditPolicy) {
    //                 $controlAuditPolicyAndObjectiveActions[$controlAuditPolicy->document_audit_status]++;
    //             }
    //         }
    //         if ($frameworkControlTestAudit->ControlAuditObjectives) {
    //             foreach ($frameworkControlTestAudit->ControlAuditObjectives as $controlAuditObjective) {
    //                 $controlAuditPolicyAndObjectiveActions[$controlAuditObjective->objective_audit_status]++;
    //             }
    //         }
    //         /* Values of test results */
    //         /*
    //             "1" => 'Not Applicable',
    //             "2" => 'Not Implemented',
    //             "3" => 'Partially Implemented',
    //             "4" => 'Implemented',
    //         */
    //         $testResultIds = [];
    //         $testResultIds[] = 1; // Append 'Not Applicable'
    //         $testResultIds[] = 2; // Append 'Not Implemented'
    //         if ($controlAuditPolicyAndObjectiveActions['no_action'] == 0) { // All control audit policies has action

    //                 if (($controlAuditPolicyAndObjectiveActionsMapping['approved'] == ($policiesCount + $objectivesCount)) && ($controlAuditPolicyAndObjectiveActions['approved'] == (count($frameworkControlTestAudit->ControlAuditPolicies) + count($frameworkControlTestAudit->ControlAuditObjectives)))) 
    //                     $testResultIds = [1, 2, 3, 4]; // 'Not Applicable', 'Not Implemented', 'Partially Implemented', and 'Implemented'
    //             else if ($controlAuditPolicyAndObjectiveActions['approved'] > 0 && $controlAuditPolicyAndObjectiveActionsMapping['approved'] )
    //                 $testResultIds = [1, 2, 3]; // 'Not Applicable', 'Not Implemented', and 'Partially Implemented'
    //             else
    //                 $testResultIds = [1, 2]; // 'Not Applicable', and 'Not Implemented'
    //         } else {
    //             $testResultIds = [1, 2]; // 'Not Applicable , Not Implemented'
    //         }

    //         $testResultGroups = TestResult::whereIn('id', $testResultIds)->get();
    //     }

    //     $testers = User::all();
    //     $teams = Team::all();
    //     $testTeams = $this->GetTeamsOfItem($frameworkControlTestAudit->test_id, 'test');
    //     $testTeamsNames = Team::whereIn('id', $testTeams)->pluck('name')->toArray();

    //     $comments = $frameworkControlTestAudit->FrameworkControlTestComments;
    //     $SelectedRiskIds = FrameworkControlTestResultsToRisk::where('test_results_id', $frameworkControlTestResult->id)->pluck('risk_id')->toArray();
    //     $resultRisks = Risk::whereIn('id', $SelectedRiskIds)->get();
    //     $risks = Risk::all();

    //     $riskGroupings = RiskGrouping::with('RiskCatalogs:id,number,name,risk_grouping_id')->get();
    //     $threatGroupings = ThreatGrouping::with('ThreatCatalogs:id,number,name,threat_grouping_id')->get();
    //     $categories = Category::all();
    //     $locations = Location::all();
    //     $frameworks = Framework::with('FrameworkControls:id,short_name,control_number')->get();
    //     $assets = Asset::select('id', 'name')->orderBy('id')->get();
    //     $assetGroups = AssetGroup::all();
    //     $technologies = Technology::all();
    //     $enabledUsers = User::where('enabled', true)->with('manager:id,name,manager_id')->get();
    //     $tags = Tag::all();
    //     if (isDepartmentManager()) {
    //         $departmentId = (Department::where('manager_id', auth()->id())->first())->id;
    //         $owners = User::where('department_id', $departmentId)->orWhere('id', auth()->id())->get();
    //     } else {
    //         $departmentManagersIds = Department::pluck('manager_id')->toArray();
    //         $owners = User::whereIn('id', $departmentManagersIds)->get();
    //     }
    //     $riskSources = Source::all();
    //     $riskScoringMethods = ScoringMethod::all();
    //     $riskLikelihoods = Likelihood::all();
    //     $impacts = Impact::all();

    //     // return count($resultRisks);
    //     return view($this->path . '.view', compact('auditStatusGroups', 'testResultGroups', 'frameworkControlTestAudit', 'frameworkControlTestResult', 'testers', 'teams', 'breadcrumbs', 'id', 'testTeams', 'comments', 'risks', 'SelectedRiskIds', 'resultRisks', 'riskGroupings', 'threatGroupings', 'locations', 'frameworks', 'assets', 'assetGroups', 'categories', 'technologies', 'enabledUsers', 'riskSources', 'riskScoringMethods', 'riskLikelihoods', 'impacts', 'tags', 'editable', 'testTeamsNames', 'owners', 'mapping'));
    // }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, $id)
    {
        $data = array(
            'status' => 1,
            'errors' => [],
            'reload' => true,
        );

        // Get framewrok control test result
        $FrameworkControlTestResult = FrameworkControlTestResult::where('test_audit_id', $id)->first();
        // Get framewrok control test audit
        $frameworkControlTestAudit = $FrameworkControlTestResult->FrameworkControlTestAudit;

        // Check if the framework control has many audits and this audit isn't last audit
        if (!$this->isLastAudit($frameworkControlTestAudit)) {
            $response = array(
                'status' => false,
                'message' => __('compliance.ThereWasAProblemUpdatingTheAuditResultIsNotLastResult'),
            );
            return response()->json($response, 403);
        }

        // validation rules
        $validator = Validator::make($request->all(), [
            'test_result' => 'required|integer',
        ]);

        // check  rules valid or not
        if ($validator->fails()) {

            $errors = $validator->errors();
            $data = array(
                'status' => 0,
                'errors' => $errors,
                'message' => __('compliance.ThereWasAProblemUpdatingTheAuditResult') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($data, 200);
        } else {
            $FrameworkControlTestResultOldArray = $FrameworkControlTestResult->toArray();

            $FrameworkControlTestResult->update([
                'test_result' => $request->test_result,
            ]);
            $FrameworkControlTestAudit = FrameworkControlTestAudit::where('id', $id)->first();

            $FrameworkControlTestAuditOldArray = $FrameworkControlTestAudit->toArray();

            $frameworkControl = $FrameworkControlTestAudit->frameworkControl;
            $frameworkControlChildrenCount = $frameworkControl->frameworkControls()->count();

            $FrameworkControlTestAudit->update([
                // 'status' => $request->status,
                // 'last_date' =>  $request->test_date,
            ]);

            // to get the aduit to edit the test_number status on it the column testnumber array 
            $audit = FrameworkControlTestAudit::where('framework_control_id', $frameworkControl->id)
                ->orderBy('id', 'desc')
                ->first();
            if ($audit) {

                $test_number = json_decode($audit->test_number, true) ?? []; // Ensure it’s an array

                // Check if the array has at least 2 elements, if not, initialize them
                if (!isset($test_number[1])) {
                    $test_number[1] = ''; // or some default value
                }

                $test_number[1] = $FrameworkControlTestResult->testResult->name; // Update the second index
                $audit->test_number = json_encode($test_number); // Encode the array back to JSON
                $audit->save(); // Save the changes
            }



            // If framework control doesn't have children
            if ($frameworkControlChildrenCount == 0) {
                $frameworkControl->update([
                    'control_status' => $FrameworkControlTestResult->testResult->name
                ]);

                $parentFrameworkControl = $frameworkControl->parentFrameworkControl;

                // framework control hasn't child & has parent
                if ($parentFrameworkControl) {
                    $frameworkControlChildren = $parentFrameworkControl->frameworkControls;
                    $statuses = ['Not Implemented' => 0, 'Partially Implemented' => 0, 'Implemented' => 0];
                    $frameworkControlChildrenStatuses = $frameworkControlChildren->where('control_status', '<>', 'Not Applicable')->pluck('control_status')->toArray();

                    // If all statuses == 'Not Applicable'
                    if (count($frameworkControlChildrenStatuses) == 0) {
                        $parentFrameworkControl->update([
                            'control_status' => 'Not Applicable'
                        ]);
                    } else {
                        foreach ($frameworkControlChildrenStatuses as $frameworkControlChildrenStatus) {
                            if (array_key_exists($frameworkControlChildrenStatus, $statuses)) {
                                $statuses[$frameworkControlChildrenStatus]++;
                            }
                        }

                        foreach ($statuses as $key => $value) {
                            if ($statuses[$key] == 0)
                                unset($statuses[$key]);
                        }

                        // All status are matched one status
                        if (count($statuses) == 1) {
                            $parentFrameworkControl->update([
                                'control_status' => array_keys($statuses)[0]
                            ]);
                        } else { // has mix of statuses
                            $parentFrameworkControl->update([
                                'control_status' => 'Partially Implemented'
                            ]);
                        }
                    }
                }
            }



            // this is used for report not used in cycle
            if ($parentFrameworkControl) {
                $StatusOfParent = $parentFrameworkControl->control_status;
                $frmaeChild = FrameworkControl::where('parent_id', $parentFrameworkControl->id)->first();
                $StatusOfTestAduit = FrameworkControlTestAudit::where('test_id', $frmaeChild->id)->latest()->first();

                if ($StatusOfTestAduit) {
                    $testNumber = json_decode($StatusOfTestAduit->test_number, true);

                    // Update the last index of the array
                    $testNumber[2] = $StatusOfParent;

                    // Save the updated value back to the database
                    $StatusOfTestAduit->update(['test_number' => json_encode($testNumber)]);
                }
            }
            $changes = [];
            if ($FrameworkControlTestResultOldArray) {
                if ($FrameworkControlTestResultOldArray['test_result'] != $FrameworkControlTestResult['test_result']) {
                    $changes[] = "`test result` (`" .
                        ($FrameworkControlTestResultOldArray['test_result'] ? (TestResult::where('id', $FrameworkControlTestResultOldArray['test_result'])->pluck('name')[0]) : '') . "`=>`" .
                        (TestResult::where('id', $FrameworkControlTestResult['test_result'])->pluck('name')[0]) . "`)";
                }

                if ($FrameworkControlTestResultOldArray['summary'] != $FrameworkControlTestResult['summary']) {
                    $changes[] = "`summary` (`" .
                        ($FrameworkControlTestResultOldArray['summary']) . "`=>`" .
                        ($FrameworkControlTestResult['summary']) . "`)";
                }

                if ($FrameworkControlTestResultOldArray['test_date'] != $FrameworkControlTestResult['test_date']) {
                    $changes[] = "`test date` (`" .
                        ($FrameworkControlTestResultOldArray['test_date']) . "`=>`" .
                        ($FrameworkControlTestResult['test_date']) . "`)";
                }
            }

            if ($FrameworkControlTestAuditOldArray) {
                if ($FrameworkControlTestAuditOldArray['status'] != $FrameworkControlTestAudit['status']) {
                    $changes[] = "`status` (`" .
                        (TestStatus::where('id', $FrameworkControlTestAuditOldArray['status'])->pluck('name')[0]) . "`=>`" .
                        (TestStatus::where('id', $FrameworkControlTestAudit['status'])->pluck('name')[0]) . "`)";
                }

                if ($FrameworkControlTestAuditOldArray['tester'] != $FrameworkControlTestAudit['tester']) {
                    $changes[] = "`test result` (`" .
                        (User::where('id', $FrameworkControlTestAuditOldArray['tester'])->pluck('username')[0]) . "`=>`" .
                        (User::where('id', $FrameworkControlTestAudit['tester'])->pluck('username')[0]) . "`)";
                }
            }

            $message =  __(
                'locale.NotifyAuditUpdated',
                [
                    'user' => auth()->user()->name,
                    'changes' => implode(', ', $changes)
                ]
            );

            write_log($FrameworkControlTestAudit->id, auth()->id(), $message, FrameworkControlTestAudit::class);

            DB::commit();
            // event(new AuditResultCreated($FrameworkControlTestResult));


            $response = array(
                'status' => true,
                'reload' => true,
                'message' => __('compliance.AuditStatusWasUpdatedSuccessfully'),
            );
            return response()->json($response, 200);
        }
    }

    public function updateCurrentAduit(Request $request)
    {
        $id = $request->input('id');
        // dd($request->all());
        $data = array(
            'status' => 1,
            'errors' => [],
            'reload' => true,
        );

        // Get framewrok control test result
        $FrameworkControlTestResult = FrameworkControlTestResult::where('test_audit_id', $id)->first();
        // Get framewrok control test audit
        $frameworkControlTestAudit = $FrameworkControlTestResult->FrameworkControlTestAudit;

        // Check if the framework control has many audits and this audit isn't last audit
        if (!$this->isLastAudit($frameworkControlTestAudit)) {
            $response = array(
                'status' => false,
                'message' => __('compliance.ThereWasAProblemUpdatingTheAuditResultIsNotLastResult'),
            );
            return response()->json($response, 403);
        }

        // validation rules
        $validator = Validator::make($request->all(), [
            'summary' => 'required',
            'action_status' => 'required',
        ]);

        // check  rules valid or not
        if ($validator->fails()) {
            $errors = $validator->errors();
            $data = array(
                'status' => 0,
                'errors' => $errors,
                'message' => __('compliance.ThereWasAProblemUpdatingTheAuditResult') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($data, 422); // Use 422 for validation errors
        } else {

            $FrameworkControlTestResult->update([
                'summary' =>  $request->summary,
                'test_date' =>  Carbon::now()->format('Y-m-d'),
                'submission_date' =>  Carbon::now()->format('Y-m-d'),
                'remediation' => $request->remediation,
            ]);

            $FrameworkControlTestAudit = FrameworkControlTestAudit::where('id', $id)->first();
            $FrameworkControlTestAudit->update([
                'action_status' => $request->action_status,
            ]);


            $teams = $request->teams ?? []; // Set $teams to an empty array if it's null

            $testID = FrameworkControlTestAudit::find($id)->id;
            if ($request->responsible_type == "users") {
                $this->UpdateUsersOfItem($testID, 'test', $teams);
            } else {
                $this->UpdateTeamsOfItem($testID, 'test', $teams);
            }

            DB::commit();
            // event(new AuditResultCreated($FrameworkControlTestResult));


            return response()->json([
                'status' => true,
                'reload' => true,
                'message' => __('compliance.AuditResultWasUpdatedSuccessfully'),
            ], 200);
            return response()->json($response, 200);
        }
    }


    function calculateCombinedStatus($relatedControls)
    {
        // Extract statuses from the related controls
        $statuses = $relatedControls->pluck('control_status')->toArray();

        // Count occurrences of each status
        $countImplemented = count(array_filter($statuses, fn($status) => $status == "Implemented"));
        $countNotImplemented = count(array_filter($statuses, fn($status) => $status == "Not Implemented"));
        $countPartiallyImplemented = count(array_filter($statuses, fn($status) => $status == "Partially Implemented"));
        $countNotApplicable = count(array_filter($statuses, fn($status) => $status == "Not Applicable"));

        // Check if all statuses are "Implemented"
        if ($countImplemented >= 1 && $countNotImplemented === 0 && $countPartiallyImplemented === 0 && $countNotApplicable === 0) {
            return 'Implemented';
        }

        // Check if all statuses are "Not Implemented"
        if ($countNotImplemented >= 1 && $countImplemented === 0 && $countPartiallyImplemented === 0 && $countNotApplicable === 0) {
            return 'Not Implemented';
        }

        // Check if all statuses are "Partially Implemented"
        if ($countPartiallyImplemented >= 1 && $countImplemented === 0 && $countNotImplemented === 0 && $countNotApplicable === 0) {
            return 'Partially Implemented';
        }

        // If the count of "Implemented" is equal to the count of "Partially Implemented"
        if ($countImplemented >= 1 && $countPartiallyImplemented >= 1 && $countNotImplemented === 0 && $countNotApplicable === 0) {
            return 'Partially Implemented';
        }

        // If the count of "Partially Implemented" is equal to or greater than 1
        if ($countPartiallyImplemented >= 1) {
            return 'Partially Implemented';
        }

        // Check if the count of "Implemented" is equal to the count of "Not Implemented"
        if ($countImplemented >= 1 && $countNotImplemented >= 1 && $countImplemented === $countNotImplemented) {
            return 'Partially Implemented';
        }

        // Check if the count of "Implemented" is equal to the count of "Not Applicable"
        if ($countImplemented >= 1 && $countNotApplicable >= 1 && $countImplemented === $countNotApplicable) {
            return 'Implemented';
        }

        // Check if the count of "Not Implemented" is equal to the count of "Not Applicable"
        if ($countNotImplemented >= 1 && $countNotApplicable >= 1 && $countNotImplemented === $countNotApplicable) {
            return 'Not Implemented';
        }

        // Default to "Not Applicable" if none of the above conditions are met
        return 'Not Applicable';
    }

    function getStatusAndResult($controlStatus, $relatedStatus)
    {

        if ($controlStatus == "Not Implemented" && $relatedStatus == "Not Implemented") {
            $newStatus = 'Not Implemented';
            $testResult = 2;
        } elseif ($controlStatus == "Partially Implemented" && $relatedStatus == "Partially Implemented") {
            $newStatus = 'Partially Implemented';
            $testResult = 3;
        } elseif ($controlStatus == "Implemented" && $relatedStatus == "Implemented") {
            $newStatus = 'Implemented';
            $testResult = 4;
        } elseif ($controlStatus == "Implemented" && $relatedStatus == "Not Implemented") {
            $newStatus = 'Partially Implemented';
            $testResult = 3;
        } elseif ($controlStatus == "Not Applicable" && $relatedStatus == "Not Implemented") {
            $newStatus = 'Not Implemented';
            $testResult = 2;
        } elseif ($controlStatus == "Not Applicable" && $relatedStatus == "Implemented") {
            $newStatus = 'Implemented';
            $testResult = 4;
        } elseif ($controlStatus == "Partially Implemented" && $relatedStatus == "Implemented") {
            $newStatus = 'Partially Implemented';
            $testResult = 3;
        } elseif ($controlStatus == "Partially Implemented" && $relatedStatus == "Not Implemented") {
            $newStatus = 'Partially Implemented';
            $testResult = 3;
        } elseif ($controlStatus == "Partially Implemented" && $relatedStatus == "Not Applicable") {
            $newStatus = 'Partially Implemented';
            $testResult = 3;
        } elseif ($controlStatus ==  "Not Implemented" && $relatedStatus == "Partially Implemented") {
            $newStatus = 'Partially Implemented';
            $testResult = 3;
        } elseif ($controlStatus ==  "Implemented" && $relatedStatus == "Partially Implemented") {
            $newStatus = 'Partially Implemented';
            $testResult = 3;
        } elseif ($controlStatus ==  "Not Applicable" && $relatedStatus == "Partially Implemented") {
            $newStatus = 'Partially Implemented';
            $testResult = 3;
        } elseif ($controlStatus ==  "Partially Implemented" && $relatedStatus == "Partially Implemented") {
            $newStatus = 'Partially Implemented';
            $testResult = 3;
        } elseif ($controlStatus ==  "Not Implemented" && $relatedStatus == "Implemented") {
            $newStatus = 'Partially Implemented';
            $testResult = 3;
        }
        return [
            'newStatus' => $newStatus,
            'testResult' => $testResult
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $frameworkControlTestAudit = FrameworkControlTestAudit::find($id);
        $frameworkControlTestResult = FrameworkControlTestResult::where('test_audit_id', $id)->delete();
        $frameworkControlTestAudit->delete();
        return response()->json($id, 200);
    }

    /**
     * Return a listing of the resource after some manipulation.
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    private function getAudit($request, $statusArray)
    {
        /* Start reading datatable data and custom fields for filtering */
        $dataTableDetails = [];
        $customFilterFields = [
            'normal' => ['name'],
            'relationships' => ['FrameworkControlWithFramworks', 'UserTester'],
            // 'other_global_filters' => [],
            'other_global_filters' => ['last_date', 'next_date'],
        ];
        $relationshipsWithColumns = [
            // 'relationshipName:column1,column2,....'
            'FrameworkControlWithFramworks:id,short_name,family',
            'UserTester:id,name',
            'auditResponsible:id,audit_name,audit_type'
        ];

        prepareDatatableRequestFields($request, $dataTableDetails, $customFilterFields);
        /* End reading datatable data and custom fields for filtering */
        // Custom condition for filter controls
        $customConditions = [
            'where' => [],
            'whereIn' => [
                'status' => $statusArray, // Example status conditions
            ],
            'orWhereIn' => [], // Initialize orWhereIn
        ];
        $assistantAuditIds = $this->getAssistantAuditIds(auth()->id(), $statusArray);

        // Check if the user does not have 'audits.all' permission
        if (!auth()->user()->hasPermission('audits.all')) {
            // Check if the user is a department manager
            if (isDepartmentManager()) {
                $departmentId = (Department::where('manager_id', auth()->id())->first())->id;
                $departmentMembersIds =  User::with('teams')->where(
                    'department_id',
                    $departmentId
                )->orWhere('id', auth()->id())->pluck('id')->toArray();
                $customConditions['whereIn']['tester'] =  $departmentMembersIds;
                // Initialize an array to collect assistant audit IDs for all department members
                $assistantAuditIds = [];

                // Loop through each department member ID to get their assistant audit IDs
                foreach ($departmentMembersIds as $memberId) {
                    $assistantAuditIds = array_merge($assistantAuditIds, $this->getAssistantAuditIds($memberId, $statusArray));
                }

                // Remove duplicates from the assistantAuditIds
                $assistantAuditIds = array_unique($assistantAuditIds);

                // Apply the assistant audit IDs to the custom conditions
                $customConditions['orWhereIn']['id'] = $assistantAuditIds ?? [];
            } else {
                // Assign the tester condition for non-manager users
                $customConditions['where']['tester'] = auth()->id();
                $assistantAuditIds = $this->getAssistantAuditIds(auth()->user()->id, $statusArray);
                $customConditions['orWhereIn']['id'] = $assistantAuditIds ?? [];
            }
        }

        // Start filter via advanced search
        // framework
        $controlFrameworkFilter = $request->columns[2]['search']['value'] ?? '';
        $frameworkControlIdsAdvancedSearch = [];
        if ($controlFrameworkFilter) {
            $framework = Framework::where('name', $controlFrameworkFilter)->first();
            $frameworkControlIdsAdvancedSearch = $framework->FrameworkControls()->pluck('framework_controls.id')->toArray();
        }

        // family
        $familyControlIdsAdvancedSearch = [];
        $controlFamilyFilter = $request->columns[3]['search']['value'] ?? '';
        if ($controlFamilyFilter) {
            $family = FrameworkControl::where('short_name', $controlFamilyFilter)->first();
            $familyControlIdsAdvancedSearch = $family->frameworkControls()->pluck('framework_controls.id')->toArray();
        }

        $advancedSearchControlIds = [];
        if (count($frameworkControlIdsAdvancedSearch) && count($familyControlIdsAdvancedSearch)) {
            $advancedSearchControlIds = array_intersect(
                $frameworkControlIdsAdvancedSearch,
                $familyControlIdsAdvancedSearch
            );
        } else {
            if (count($frameworkControlIdsAdvancedSearch)) {
                $advancedSearchControlIds = $frameworkControlIdsAdvancedSearch;
            } else if (count($familyControlIdsAdvancedSearch)) {
                $advancedSearchControlIds = $familyControlIdsAdvancedSearch;
            }
        }
        // End filter via advanced search

        // Start filter via global search
        $frameworkControlIdsGlobalSearch = [];
        $familyControlIdsGlobalSearch = [];
        if ($dataTableDetails['search']['global']) {
            // framework
            $frameworks = Framework::where('name', 'like', '%' . $dataTableDetails['search']['global'] . '%')->get();
            foreach ($frameworks as $framework) {
                $frameworkControlIdsGlobalSearch = array_unique(array_merge(
                    $frameworkControlIdsGlobalSearch,
                    $framework->FrameworkControls()->pluck('framework_controls.id')->toArray()
                ), SORT_REGULAR);
            }

            // family
            $families = FrameworkControl::where('short_name', 'like', '%' . $dataTableDetails['search']['global'] . '%')->get();
            foreach ($families as $family) {
                $familyControlIdsGlobalSearch = array_unique(array_merge(
                    $familyControlIdsGlobalSearch,
                    $family->frameworkControls()->pluck('framework_controls.id')->toArray()
                ), SORT_REGULAR);
            }
        }
        $globalSearchControlIds = [];
        if (count($frameworkControlIdsGlobalSearch) && count($familyControlIdsGlobalSearch)) {
            $globalSearchControlIds = array_unique(array_merge(
                $frameworkControlIdsGlobalSearch,
                $familyControlIdsGlobalSearch
            ), SORT_REGULAR);
        } else {
            if (count($frameworkControlIdsGlobalSearch)) {
                $globalSearchControlIds = $frameworkControlIdsGlobalSearch;
            } else if (count($familyControlIdsGlobalSearch)) {
                $globalSearchControlIds = $familyControlIdsGlobalSearch;
            }
        }
        // End filter via global search

        if ($controlFrameworkFilter || $controlFamilyFilter) {
            $customConditions['whereIn']['framework_control_id'] = $advancedSearchControlIds;
        }

        $testNumberFilter = $request->columns[5]['search']['value'] ?? '';

        if ($testNumberFilter) {
            // Decode the JSON string
            $decodedTestNumber = json_decode($testNumberFilter, true);
            $customConditions['whereJsonContains']['test_number'] = $decodedTestNumber;
        }

        // Filter by audit name
        $auditNameFilter = $request->columns[1]['search']['value'] ?? '';
        if ($auditNameFilter) {
            $customConditions['where']['audit_name'] = $auditNameFilter; // Add this line
        }


        // Getting total records count with and without apply global search
        [$totalRecords, $totalRecordswithFilter] = getDatatableFilterTotalRecordsCount(
            FrameworkControlTestAudit::class,
            $dataTableDetails,
            $customFilterFields,
            $customConditions,
            [
                'whereIn' => [
                    'framework_control_id' => $globalSearchControlIds
                ]
            ]
        );

        $mainTableColumns = getTableColumnsSelect(
            'framework_control_test_audits',
            [
                'id',
                'audit_id',
                'test_id',
                'tester',
                'name',
                'action_status',
                'last_date',
                'next_date',
                'created_at',
                'audit_name',
                'framework_control_id',
                'test_number',
                'can_see',
            ]
        );

        // Getting records with apply global search */
        $customConditions["orderBy"] = [
            "created_at" => "desc"
        ];
        $activeAudits = getDatatableFilterRecords(
            FrameworkControlTestAudit::class,
            $dataTableDetails,
            $customFilterFields,
            $relationshipsWithColumns,
            $mainTableColumns,
            $customConditions,
            [],
            [
                'whereIn' => [
                    'framework_control_id' => $globalSearchControlIds
                ]
            ]
        );

        // Custom activeAudits response data as needs
        $data_arr = [];
        foreach ($activeAudits as $activeAudit) {
            // Fetch the responsible type for the active audit in a single query
            $checkResponsibleType = AuditResponsible::where('id', $activeAudit->audit_id)
                ->latest('id') // Use a specific column for latest to avoid ambiguity
                ->first()->responsible_type; // Use `value()` to directly get the responsible_type

            // Initialize an array to store user or team names
            $userTesterNames = '';

            if ($checkResponsibleType === "users") {
                // Fetch user names directly using a join to avoid multiple queries
                $userTester = User::join('items_to_users', 'users.id', '=', 'items_to_users.user_id')
                    ->where('items_to_users.item_id', $activeAudit->id)
                    ->pluck('users.name')
                    ->toArray();

                // Implode the names into a single string
                if (!empty($userTester)) {
                    $userTesterNames = implode(', ', $userTester);
                }
            } else {
                // Fetch team names directly using a join to avoid multiple queries
                $userTester = Team::join('items_to_teams', 'teams.id', '=', 'items_to_teams.team_id')
                    ->where('items_to_teams.item_id', $activeAudit->id)
                    ->pluck('teams.name')
                    ->toArray();

                // Implode the names into a single string
                if (!empty($userTester)) {
                    $userTesterNames = implode(', ', $userTester);
                }
            }

            // Check if the user has the permission to see all audits
            if (auth()->user()->hasPermission('audits.all') || auth()->user()->id == $activeAudit->tester) {
                // Users with this permission can see everything
                $visibleAudit = true;
            } else {
                // Check the can_see condition for non-permitted users
                $visibleAudit = $activeAudit->can_see == 1;
            }

            // If the audit is not visible to the user, skip to the next iteration
            if (!$visibleAudit) {
                continue;
            }

            // Handle framework names and family names
            $frameworkNames = '';
            $familyNames = '';

            if ($activeAudit->FrameworkControlWithFramworks) {
                if (count($activeAudit->FrameworkControlWithFramworks->Frameworks)) {
                    $frameworkNames .= implode(
                        ', ',
                        array_map(function ($element) {
                            return $element['name'];
                        }, $activeAudit->FrameworkControlWithFramworks->Frameworks->toArray())
                    );
                }

                if (count($activeAudit->FrameworkControlWithFramworks->Families)) {
                    $familyNames .= implode(
                        ', ',
                        array_map(function ($element) {
                            return $element['name'];
                        }, $activeAudit->FrameworkControlWithFramworks->Families->toArray())
                    );
                }
            }
            $data_arr[] = array(
                'id' => $activeAudit->id,
                'audit_name' => $activeAudit->audit_name,
                'audit_type' => $activeAudit->auditResponsible->audit_type == 1
                    ? __('locale.Internal')
                    : __('locale.External'),
                'framework' => $frameworkNames,
                'FrameworkControlWithFramworks' => $activeAudit->FrameworkControlWithFramworks->short_name ?? '',
                'name' => $activeAudit->name,
                'action_status' => $activeAudit->action_status ?? 0,
                'test_number' => intval(json_decode($activeAudit->test_number, true)[0] ?? 0),
                'auditer' => ($activeAudit->UserTester) ? $activeAudit->UserTester->name : '',
                'UserTester' => $userTesterNames,
                'created_at' => $activeAudit->created_at,
                'last_date' => $activeAudit->last_date,
                'next_date' => $activeAudit->next_date,
                'editable' => $this->isLastAudit($activeAudit),
                'pending' => $this->pendingAduit($activeAudit),
                'audit_status' => json_decode($activeAudit->test_number, true)[1] ?? 'No Action',
                'Actions' => $activeAudit->id,
            );
        }

        // Get custom response for datatable ajax request
        $response = getDatatableAjaxResponse(intval($dataTableDetails['draw']), $totalRecords, $totalRecordswithFilter, $data_arr);

        return response()->json($response, 200);
    }
    private function getAssistantAuditIds($userId, $statusArray)
    {
        // Use Eloquent to retrieve audit IDs directly for the user
        $userAuditIds = \DB::table('items_to_users')
            ->where('user_id', $userId)
            ->pluck('item_id');

        // Retrieve team IDs where the user is part of the team
        $teamIds = \DB::table('user_to_teams')
            ->where('user_id', $userId)
            ->pluck('team_id');

        // Retrieve audit IDs based on team responsibilities
        $teamAuditIds = \DB::table('items_to_teams')
            ->whereIn('team_id', $teamIds)
            ->pluck('item_id');

        // Combine user and team audit IDs, ensuring uniqueness
        $assistantAuditIds = $userAuditIds->merge($teamAuditIds)->unique();

        // If no audit IDs found, return an empty array early
        if ($assistantAuditIds->isEmpty()) {
            return [];
        }

        // Filter by status in frameworkcontroltestaudit using Eloquent
        $filteredAuditIds = FrameworkControlTestAudit::whereIn('id', $assistantAuditIds)
            ->whereIn('status', $statusArray)
            ->pluck('id');

        return $filteredAuditIds->toArray();
    }




    public function GetRelatedTestNumber(Request $request)
    {
        $frameworkId = $request->get('framework_id');
        $frameworkName = $request->get('framework_id');
        $frameId = Framework::where('name', $frameworkName)->first()->id;
        $ControlId = FrameworkControlMapping::where('framework_id', $frameId)->first()->framework_control_id;
        // Fetch related test numbers based on the framework ID
        $firstIndexes = FrameworkControlTestAudit::where('framework_control_id', $ControlId)
            ->pluck('test_number', 'audit_name')
            ->map(function ($testNumber) {
                $decodedArray = json_decode($testNumber, true);
                return intval($decodedArray[0] ?? 0); // Convert to integer
            });

        // Filter out null or non-integer values
        $testNumbers = $firstIndexes->filter(function ($value) {
            return is_int($value);
        })->unique();

        // Fetch related audit names based on the framework ID
        $auditNames = FrameworkControlTestAudit::where('framework_control_id', $ControlId)
            ->pluck('audit_name')
            ->unique(); // Assuming audit_name is a field in the table

        $controlsIds = FrameworkControlMapping::where('framework_id', $frameId)->pluck('framework_control_id');
        $controlsNames = FrameworkControl::whereIn('id', $controlsIds)
            ->pluck('short_name')
            ->unique(); // Assuming audit_name is a field in the table
        // Return both test numbers and audit names as JSON
        return response()->json([
            'testNumbers' => $testNumbers,
            'auditNames' => $auditNames,
            'controlsNames' => $controlsNames
        ]);
    }

    /**
     * Return a listing of the resource after some manipulation.
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function GetAudits(Request $request)
    {
        return $this->getAudit($request, [1]);
    }

    /**
     * Return a listing of the resource after some manipulation.
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function GetPastAudits(Request $request)
    {
        return $this->getAudit($request, [2]);
    }

    public function GetLogsAudits($id)
    {
        // Retrieve the logs for the given audit ID
        $logs = FrameworkControlTestAudit::itemLogs($id);

        // Using DataTables to format the response for server-side processing
        return DataTables::of($logs)
            ->addIndexColumn()  // Adds the 'Counter' column (DT_RowIndex)
            ->editColumn('message', function ($log) {
                // Ensure 'message' exists or default it to 'No message'
                return $log->message ?? 'No message';
            })
            ->editColumn('updated_at', function ($log) {
                // Use the 'updated_at' field from the log or default to 'No timestamp'
                return $log->timestamp ? $log->timestamp->toDateTimeString() : 'No timestamp';
            })
            ->addColumn('user', function ($log) {
                // Access the 'user' relationship and return the user's name, default to 'Unknown'
                return $log->user->name ?? 'Unknown';
            })
            ->make(true);  // Return the data in JSON format for DataTables
    }





    public function RiskToResult(Request $request)
    {

        $risks = $request->risks;
        $auditID = $request->auditID;
        $resultID = FrameworkControlTestAudit::find($auditID)->FrameworkControlTestResult->id;
        FrameworkControlTestResultsToRisk::where('test_results_id', $resultID)->delete();
        if ($risks) {
            foreach ($risks as $risk) {
                FrameworkControlTestResultsToRisk::create([
                    'risk_id' => $risk,
                    'test_results_id' => $resultID
                ]);
            }
        }
        $SelectedRiskIds = FrameworkControlTestResultsToRisk::where('test_results_id', $resultID)->pluck('risk_id')->toArray();
        $resultRisks = Risk::whereIn('id', $SelectedRiskIds)->get();
        $html = '';
        foreach ($resultRisks as  $key => $resultRisk) {
            $html .= "<tr>";
            $html .= "<td>";
            $html .= $key + 1;
            $html .= "</td>";
            $html .= "<td>";
            $html .= $resultRisk->status;
            $html .= "</td>";
            $html .= "<td>";
            $html .= $resultRisk->subject;
            $html .= "</td>";
            $html .= "<td>";
            $html .= $resultRisk->created_at->format('d/m/Y');
            $html .= "</td>";
            $html .= "</tr>";
        }
        return response()->json($html, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeRiskWithAudit(Request $request)
    {
        $risk = [];
        // Validation rules
        $validator = Validator::make($request->all(), [
            'subject' => ['required'],
            'reference_id' => ['nullable', 'max:20'],
            'framework_id' => ['nullable', 'exists:frameworks,id'],
            'control_id' => ['nullable', 'exists:framework_controls,id'],
            'location_id' => ['nullable', 'array'],
            'location_id.*' => ['exists:locations,id'],
            'affected_asset_id' => ['nullable', 'array'],
            'affected_asset_id.*' => ['exists:assets,id'],
            'risk_source_id' => ['nullable', 'exists:sources,id'],
            'risk_scoring_method_id' => ['nullable', 'exists:scoring_methods,id'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'owner_id' => ['nullable', 'exists:users,id'],
            'owner_manager_id' => ['nullable', 'exists:users,id'],
            'assessment' => ['nullable'],
            'notes' => ['nullable'],
            'review_date' => ['nullable'],
            'mitigation_id' => ['nullable', 'exists:mitigations,id'],
            'mgmt_review' => ['nullable'],
            'project_id' => ['nullable'],
            'project_id' => ['nullable', 'exists:projects,id'],
            'close_id' => ['nullable'],
            'risk_catalog_mapping_id' => ['nullable', 'array'],
            'risk_catalog_mapping_id.*' => ['exists:risk_catalogs,id'],
            'threat_catalog_mapping_id' => ['nullable', 'array'],
            'threat_catalog_mapping_id.*' => ['exists:threat_catalogs,id'],
            'template_group_id' => ['nullable'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:tags,id'],
            'team_id' => ['nullable', 'array'],
            'team_id.*' => ['exists:teams,id'],
            'technology_id' => ['nullable', 'exists:technologies,id'],
            'additional_stakeholder_id' => ['nullable', 'array'],
            'additional_stakeholder_id.*' => ['exists:users,id'],
            'current_likelihood_id' => ['nullable', 'exists:likelihoods,id'],
            'current_impact_id' => ['nullable', 'exists:impacts,id'],
            'risk_assessment' => ['nullable', 'string'],
            'additional_notes' => ['nullable', 'string'],
            'supporting_documentation' => ['nullable', 'array'],
            'supporting_documentation.*' => ['nullable', 'file'],
            'auditID' => ['required', 'exists:framework_control_test_results,id'],
        ]);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('compliance.ThereWasAProblemAddingTheRisk') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {

            // Limit the subject's length
            $alert = false;
            $maxlength = Setting::where('name', 'maximum_risk_subject_length')->first()['value'];
            if (strlen($request->subject) > $maxlength) {
                $alert = __('locale.RiskSubjectTruncated', ['limit' => $maxlength]);
                $request->subject = substr($request->subject, 0, $maxlength);
            }
            DB::beginTransaction();
            try {
                // Start submitting basic risk data
                $additionalNotes = $request->additional_notes;
                $risk = Risk::create([
                    'status' => 'New',
                    'subject' => $request->subject,
                    'reference_id' => $request->reference_id,
                    'regulation' => $request->framework_id,
                    'control_id' => $request->control_id, // control_number
                    'source_id' => $request->risk_source_id,
                    'category_id' => $request->category_id,
                    'owner_id' => $request->owner_id,
                    'manager_id' => $request->owner_manager_id,
                    'assessment' => $request->risk_assessment, // try_encrypt customization_extra
                    'notes' => $additionalNotes, // Use the additional_notes value here
                    'project_id' => $request->project_id,
                    'risk_description' => $request->risk_description,
                    'submitted_by' => auth()->id() ?? 1, // now to test without login
                    'risk_catalog_mapping' => $request->has('risk_catalog_mapping_id') ? implode(",", $request->risk_catalog_mapping_id) : "",
                    'threat_catalog_mapping' => $request->has('threat_catalog_mapping_id') ? implode(",", $request->threat_catalog_mapping_id) : "",
                    'template_group_id' => $request->template_group_id ?? 0, // customization_extra
                ]);

                // Save locations
                foreach ($request->location_id ?? [] as $location_id) {
                    RiskToLocation::create([
                        'risk_id' => $risk->id,
                        'location_id' => $location_id,
                    ]);
                }
                // Save teams
                foreach ($request->team_id ?? [] as $team_id) {
                    RiskToTeam::create([
                        'risk_id' => $risk->id,
                        'team_id' => $team_id,
                    ]);
                }
                // Save technologies
                foreach ($request->technology_id ?? [] as $technology_id) {
                    RiskToTechnology::create([
                        'risk_id' => $risk->id,
                        'technology_id' => $technology_id,
                    ]);
                }
                // Save additional stakeholders
                foreach ($request->additional_stakeholder_id ?? [] as $additional_stakeholder_id) {
                    RiskToAdditionalStakeholder::create([
                        'risk_id' => $risk->id,
                        'user_id' => $additional_stakeholder_id,
                    ]);
                }
                // End submitting basic risk data

                // Start Submit risk scoring
                $riskScoringMethodId = $request->risk_scoring_method_id;
                if (!$riskScoringMethodId) { // If the scoring method is not passed (If the scoring method is invalid then go with the defaults)
                    submit_risk_scoring($risk->id);
                } else { // If the scoring method is passed (If there's a valid scoring method use the provided values)
                    submit_risk_scoring($risk->id, $riskScoringMethodId, $request->current_likelihood_id, $request->current_impact_id);
                }
                // End Submit risk scoring

                // Start Process the data from the Affected Assets widget
                if ($request->has('affected_asset_id')) {
                    $this->processSelectedAssetsAssetGroupsOfType($risk->id, $request->affected_asset_id, 'risk');
                }
                // End Process the data from the Affected Assets widget

                // Store tags for risk
                $allAssetTags = Tag::whereIn('id', $request->tags ?? [])->get();
                $risk->tags()->saveMany($allAssetTags);

                // File upload Start
                if ($request->hasFile('supporting_documentation')) {
                    foreach ($request->file('supporting_documentation') as $supporting_documentation) {
                        if ($supporting_documentation->isValid()) {
                            $path = $supporting_documentation->store('risk/' . $risk->id);
                            $fileName = pathinfo($supporting_documentation->getClientOriginalName(), PATHINFO_FILENAME);
                            $fileName .= pathinfo($path, PATHINFO_EXTENSION) ? '.' . pathinfo($path, PATHINFO_EXTENSION) : '';
                            File::create([
                                'risk_id' => $risk->id,
                                'view_type' => 1,
                                'name' => $fileName,
                                'unique_name' => $path,
                                'type' => $supporting_documentation->getClientMimeType(),
                                'size' => $supporting_documentation->getSize(),
                                'user' => auth()->id()
                            ]);
                        } else {
                            DB::rollBack();
                            Storage::deleteDirectory('risk/' . $risk->id);
                            $response = array(
                                'status' => false,
                                'errors' => ['supporting_documentation' => ['There were problems uploading the files']],
                                'message' => __('compliance.ThereWasAProblemAddingTheRisk') . "<br>" . __('locale.Validation error'),
                            );

                            return response()->json($response, 422);
                        }
                    }
                }
                // File upload End

                $FrameworkControlTestResultsToRisk = FrameworkControlTestResultsToRisk::create([
                    'risk_id' => $risk->id,
                    'test_results_id' => $request->auditID
                ]);

                DB::commit();
                event(new AuditRiskCreated($risk, $FrameworkControlTestResultsToRisk));

                $response = array(
                    'status' => true,
                    'alert' => $alert,
                    // 'message' => __('locale.RiskWasAddedSuccessfully'),
                    // 'redirect_to' => [
                    //     route('admin.compliance.audit.edit', $request->auditID),
                    //     route('admin.compliance.audit.view', $request->auditID),
                    // ],
                    'redirect_to' => route('admin.compliance.audit.edit', $request->auditID),

                    'message' => __('compliance.RiskSubmitSuccess', ["subject" => $request->subject]),

                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();
                Storage::deleteDirectory('risk/' . $risk->id);

                $response = array(
                    'status' => false,
                    'errors' => [],
                    // 'message' => $th->getMessage(),
                    'message' => __('locale.Error'),
                );
                return response()->json($response, 502);
            }
        }
    }

    /**
     * Get last audit
     *
     * @param  FrameworkControlTestAudit $frameworkControlTestAudit
     * @return Boolean
     */
    protected function isLastAudit($frameworkControlTestAudit)
    {
        // Get the framework control last audit
        $lastAudit = $frameworkControlTestAudit->FrameworkControlTest->FrameworkControlTestAudits()->orderBy('id', 'desc')->first();

        // Check if the framework control has many audits and this audit isn't last audit
        if (($lastAudit->id ?? null) != $frameworkControlTestAudit->id) {
            return false;
        } else {
            return true;
        }
    }

    protected function closedAduit($frameworkControlTestAudit)
    {
        // Get the framework control last audit
        $lastAudit = $frameworkControlTestAudit->FrameworkControlTest->FrameworkControlTestAudits()->orderBy('id', 'desc')->first();
        // Check if the framework control has status closed to make the view disabled at past aduit
        if ($lastAudit->status == 2) {
            return false;
        } else {
            return true;
        }
    }
    protected function closedAduitAction($frameworkControlTestAudit)
    {
        // Get the framework control last audit
        $lastAudit = $frameworkControlTestAudit->FrameworkControlTest->FrameworkControlTestAudits()->orderBy('id', 'desc')->first();
        // Check if the framework control has action status closed to make the view disabled at the current audit
        if ($lastAudit->action_status == 1) {
            return false;
        } else {
            return true;
        }
    }


    protected function pendingAduit($frameworkControlTestAudit)
    {
        // Extract the test number
        $testControlNumber = $frameworkControlTestAudit->test_number;
        // Decode the JSON string into a PHP array
        $decodedArray = json_decode($testControlNumber, true);
        $firstIndexValue = $decodedArray[0];
        $frame = FrameworkControlMapping::where('framework_control_id', $frameworkControlTestAudit->framework_control_id)->value('framework_id');
        $framePending = AuditResponsible::where('framework_id', $frame)
            ->where('test_number_initiated', $firstIndexValue)
            ->value('start_date');
        $framePendingFormatted = \Carbon\Carbon::parse($framePending)->format('d/m/Y');
        $nowFormatted = now()->format('d/m/Y');        // Check if the framework control has status closed to make the view disabled at past aduit
        if ($framePendingFormatted <= $nowFormatted) {
            return false;
        } else {
            return true;
        }
    }

    public function ReopenAuditControl(Request $request)
    {
        // Validate the request data
        $request->validate([
            'id' => 'required|integer|exists:framework_control_test_audits,id', // Update the table name here
            'action' => 'required|string',
        ]);


        // Find the record by ID
        $audit = FrameworkControlTestAudit::find($request->id);

        // Check if the record exists
        if ($audit) {
            // Update the record with the new action status
            $audit->action_status = $request->action === 'reopen' ? 0 : 1; // Adjust condition as needed
            $audit->save();

            // Return a successful response
            return response()->json([
                'success' => true,
                'message' => 'Control Reopen successfully!',
                'data' => $audit,
            ]);
        }

        // If the record is not found, return an error
        return response()->json([
            'success' => false,
            'message' => 'Record not found.',
        ], 404);
    }


    /**
     * Return an Export file for listing of the resource after some manipulation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxActiveExport(Request $request)
    {
        if ($request->type != 'pdf')
            return Excel::download(new FrameworkControlTestAuditsExport('active'), 'Active_audits.xlsx');
        else
            return 'Active_audits.pdf';
    }

    /**
     * Return an Export file for listing of the resource after some manipulation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxPastExport(Request $request)
    {
        if ($request->type != 'pdf')
            return Excel::download(new FrameworkControlTestAuditsExport('past'), 'Past_audits.xlsx');
        else
            return 'Past_audits.pdf';
    }


    public function StoreRemidation(Request $request)
    {
        try {
            $request->validate([
                'responsible_user' => 'required|exists:users,id',
                'corrective_action_plan' => 'nullable|string',
                'budgetary' => 'nullable|numeric',
                'status' => 'nullable|integer',
                'due_date' => 'nullable|date',
                'comments' => 'nullable|string',
                'controlTestId' => 'nullable|exists:framework_control_test_audits,id'
            ]);

            $data = $request->only([
                'responsible_user',
                'corrective_action_plan',
                'budgetary',
                'status',
                'due_date',
                'comments',
                'controlTestId'
            ]);

            $remediationDetail = RemediationDetail::updateOrCreate(
                ['control_test_id' => $request->input('controlTestId')],
                $data
            );

            return response()->json(['success' => true, 'message' => 'Data saved successfully']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->validator->errors()], 422);
        }
    }








    public function notificationsSettingsActiveAduit()
    {
        // defining the breadcrumbs that will be shown in page

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Compliance Framework')],
            ['link' => route('admin.compliance.audit.index'), 'name' => __('locale.ActiveAudits')],
            ['name' => __('locale.NotificationsSettings')]
        ];

        $users = User::select('id', 'name')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [44, 45, 46, 73, 91];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [72];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            44 => ['Summary', 'Test_Date', 'Test_Name', 'Test_Tester', 'Test_Result', 'Control_Owner', 'Submission_Date', 'Aduit_Status'],
            45 => ['Control_Owner', 'Desired_Maturity', 'Control_Priority', 'Control_class', 'Control_Maturity', 'Control_Phase', 'Control_Type', 'Tester', 'Test_Frequency', 'Test_Name', 'Test_Steps', 'Approximate_Time', 'Expected_Results', 'Source', 'Category', 'Regulation', 'Additional_Stakeholder', 'Teams', 'Owner_Risk'],
            46 => ['comment', 'Comment_By', 'Control_Owner', 'Desired_Maturity', 'Control_Priority', 'Control_class', 'Control_Maturity', 'Control_Phase', 'Control_Type', 'Tester', 'Test_Frequency', 'Test_Name', 'Test_Steps', 'Approximate_Time', 'Expected_Results'],
            // 19 => ['Document_Audit_Status', 'Test_Tester', 'Control_Owner', 'Control_Name', 'Document_Name', 'Document_Owner'],
            73 => ['Control_Name', 'Control_Owner', 'Control_Tester', 'Objective_Audit_status', 'Control_Objective_Name'],
            72 => ['Control_Name', 'Summary', 'Test_Date', 'Test_Name', 'Test_Tester', 'Test_Result', 'Control_Owner', 'Submission_Date'],
            91 => ['Control_Name', 'Control_Owner', 'Control_Tester', 'Evidence_status'],

        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [
            44 => ['Control-Owner' => __('locale.ControlOwner'), 'Control-Tester' => __('locale.ControlTester')],
            45 => ['Control-Owner' => __('locale.ControlOwner'), 'Control-Tester' => __('locale.ControlTester'), 'creator' => __('locale.RiskCreator'), 'Team-teams' => __('locale.TeamsOfRisk'), 'Stakeholder-teams' => __('locale.StakeholdersOfRisk')],
            46 => ['Control-Owner' => __('locale.ControlOwner'), 'Control-Tester' => __('locale.ControlTester')],
            // 19 => ['Control-Owner' => __('locale.ControlOwner'), 'Control-Tester' => __('locale.ControlTester'), 'Document-Owner' => __('locale.DocumentOwner'), 'Document-Stakeholder' => __('locale.DocumentStakeholder'), 'Document-Teams' => __('locale.DocumentTeams'), 'Document-reviewers' => __('locale.DocumentReviewers'), 'Document-Creator' => __('locale.DocumentCreator')],
            73 => ['Control-Owner' => __('locale.ControlOwner'), 'Control-Tester' => __('locale.ControlTester'), 'Responsible_Person' => __('locale.Responsible_Person')],
            72 => ['Control-Owner' => __('locale.ControlOwner'), 'Control-Tester' => __('locale.ControlTester')],
            91 => ['Control-Owner' => __('locale.ControlOwner'), 'Control-Tester' => __('locale.ControlTester'), 'Responsible_Person' => __('locale.Responsible_Person')],

        ];
        // getting actions with their system notifications settings, sms settings and mail settings to list them in tables
        $actionsWithSettings = Action::whereIn('actions.id', $moduleActionsIds)
            ->leftJoin('system_notifications_settings', 'actions.id', '=', 'system_notifications_settings.action_id')
            ->leftJoin('mail_settings', 'actions.id', '=', 'mail_settings.action_id')
            ->leftJoin('sms_settings', 'actions.id', '=', 'sms_settings.action_id')
            ->get([
                'actions.id as action_id',
                'actions.name as action_name',
                'system_notifications_settings.id as system_notification_setting_id',
                'system_notifications_settings.status as system_notification_setting_status',
                'mail_settings.id as mail_setting_id',
                'mail_settings.status as mail_setting_status',
                'sms_settings.id as sms_setting_id',
                'sms_settings.status as sms_setting_status',
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

    public function getFrameworkControls($frameworkName)
    {
        if ($frameworkName == -1) {
            $controls = FrameworkControl::all();
        } else {
            $framework = Framework::where('name', $frameworkName)->first();
            if ($framework) {
                $controls = $framework->FrameworkControls()->get();
            } else {
                $controls = [];
            }
        }
        return $controls;
    }
    public function checkForStatusTaken(Request $request)
    {
        $auditId = $request->input('audit_id');
        $status = ['Implemented', 'Not Implemented', 'Not Applicable', 'Partial Implemented'];

        $record = FrameworkControlTestAudit::where('id', $auditId)->first();

        if ($record) {
            $takeStatus = json_decode($record->test_number, true)[1];
            if (in_array($takeStatus, $status)) {
                return response()->json(['success' => true, 'message' => 'Action Token']);
            } else {
                return response()->json(['success' => false, 'message' => "There is No Action In Audit"], 422);
            }
        }

        return response()->json(['success' => false, 'message' => 'Audit record not found'], 404);
    }
}