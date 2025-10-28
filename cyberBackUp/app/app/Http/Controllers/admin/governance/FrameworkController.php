<?php

namespace App\Http\Controllers\admin\governance;

use App\Exports\FrameworksExport;
use App\Http\Controllers\Controller;
use App\Imports\FrameworksImport;
use App\Models\ControlAuditEvidence;
use App\Models\ControlControlObjective;
use App\Models\Department;
use App\Models\Family;
use App\Models\Framework;
use App\Models\FrameworkControl;
use App\Models\FrameworkControlMapping;
use App\Models\FrameworkControlTestAudit;
use App\Models\TestStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class FrameworkController extends Controller
{
    /**
     * Return an Export file for listing of the resource after some manipulation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxExport(Request $request)
    {
        if ($request->type != 'pdf')
            return Excel::download(new FrameworksExport, 'Frameworks.xlsx');
        else
            return 'Frameworks.pdf';
    }


    // This function is used to open the import form and send the required data for it
    public function openImportForm()
    {
        // Defining breadcrumbs for the page
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => 'javascript:void(0)', 'name' => __('locale.Governance')],
            ['link' => route('admin.governance.index'), 'name' => __('locale.Frameworks')],
            ['name' => __('locale.Import')]
        ];

        // Defining database columns with rules and examples
        $databaseColumns = [
            // Column: 'name'
            ['name' => 'name', 'rules' => ['required', 'should be unique in frameworks table'], 'example' => 'Framework1'],

            // Column: 'description'
            ['name' => 'description', 'rules' => ['required'], 'example' => 'some description'],

            // Column: 'domain'
            ['name' => 'domain', 'rules' => ['required', 'comma separated string containing domain names', 'must exist in domains table'], 'example' => 'domain1'],


            // Column: 'sub_domain'
            ['name' => 'sub_domain', 'rules' => ['required', 'comma separated string containing sub domain names', 'must exist in domains table', 'must be child of any of domains in domain field'], 'example' => 'sub_domain1'],

        ];

        // Define the path for the import data function
        $importDataFunctionPath = route('admin.governance.framework.ajax.importData');

        // Return the view with necessary data
        return view('admin.import.index', compact('breadcrumbs', 'databaseColumns', 'importDataFunctionPath'));
    }


    // This function is used to validate the data coming from mapping column and then
    // sending them to "FrameworksImport" class to import its data
    public function importData(Request $request)
    {
        // Validate the incoming request for the 'import_file' field
        $validator = Validator::make($request->all(), [
            'import_file' => ['required', 'file', 'max:5000'],
        ]);

        // Check for validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            // Prepare response with validation errors
            $response = [
                'status' => false,
                'errors' => $errors,
                'message' => __('locale.ThereWasAProblemImportingTheItem', ['item' => __('locale.Frameworks')])
                    . "<br>" . __('locale.Validation error'),
            ];
            return response()->json($response, 422);
        } else {
            // Start a database transaction
            DB::beginTransaction();
            try {
                // Mapping columns from the request to database columns
                $columnsMapping = array();
                $columns = ['name', 'description', 'domain', 'sub_domain'];

                foreach ($columns as $column) {
                    if ($request->has($column)) {
                        $inputValue = $request->input($column);
                        $cleanedColumn = str_replace(
                            ["/", "(", ")", "'", "#", "*", "+", "%", "&", "$", "=", "<", ">", "?", "؟", ":", ";", '"', ".", "^", ",", "@", "-", " "],
                            ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '_at_', '_', '_'],
                            strtolower($inputValue)
                        );

                        $cleanedColumn = str_replace(
                            ["__"],
                            ['_'],
                            $cleanedColumn
                        );
                        $cleanedColumn = preg_replace('/(\w+)_\b/', '$1', $cleanedColumn);
                        $snakeCaseColumn = Str::snake($cleanedColumn);
                        $columnsMapping[$column] = $snakeCaseColumn;
                    }
                }

                // Extract values and filter out null values
                $values = array_values(array_filter($columnsMapping, function ($value) {
                    if ($value != null && $value != '') {
                        return $value;
                    }
                }));

                // Check for duplicate values
                if (count($values) !== count(array_unique($values))) {
                    $response = [
                        'status' => false,
                        'message' => __('locale.YouCantUseTheSameFileColumnForMoreThanOneDatabaseColumn'),
                    ];
                    return response()->json($response, 422);
                }

                // Import data using the specified columns mapping
                (new FrameworksImport($columnsMapping))->import(request()->file('import_file'));

                // Commit the transaction
                DB::commit();
                $message = __("locale.New Data Imported In FrameWork") . " \" " . __("locale.CreatedBy") . " \"" . auth()->user()->name . "\".";
                write_log(1, auth()->id(), $message);
                // Prepare success response
                $response = [
                    'status' => true,
                    'reload' => true,
                    'message' => __('locale.ItemWasImportedSuccessfully', ['item' => __('locale.Frameworks')]),
                ];
                return response()->json($response, 200);
            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                // Rollback the transaction in case of an exception
                DB::rollBack();

                // Handle validation exceptions and prepare error response
                $failures = $e->failures();
                $errors = [];
                foreach ($failures as $failure) {
                    if (!array_key_exists($failure->row(), $errors)) {
                        $errors[$failure->row()] = [];
                    }
                    $errors[$failure->row()][] = [
                        'attribute' => $failure->attribute(),
                        'value' =>  $failure->values()[$failure->attribute()] ?? '',
                        'error' => $failure->errors()[0]
                    ];
                }

                $response = [
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('locale.ThereWasAProblemImportingTheItem', ['item' => __('locale.Frameworks')]),
                ];
                return response()->json($response, 502);
            }
        }
    }

    public function graphViewFramework($id)
    {
        // Retrieve the framework by ID
        $frameworks = Framework::where('id', $id)->get();

        // Set up breadcrumbs for navigation
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Regulators')],

            ['link' => route('admin.governance.framework.show', ['id' => $id]), 'name' => __('locale.Frameworks')],
            ['name' => $frameworks[0]->name],
            ['link' => 'javascript:void(0)', 'name' => __('locale.Graph')],

        ];

        // Fetch all departments (for dropdowns or filters)
        $departments = Department::select('id', 'name')->get();
        $frameworkId = $id; // For better readability

        // Fetch parent domains (families with no parent family)
        $domainId = DB::table('framework_families')
            ->where('framework_id', $frameworkId)
            ->whereNull('parent_family_id')
            ->distinct()
            ->pluck('family_id');

        // Fetch child families related to the parent domains
        $familyIds = DB::table('framework_families')
            ->where('framework_id', $frameworkId)
            ->whereIn('parent_family_id', $domainId)
            ->pluck('family_id');

        // Merge domain and family IDs to get all relevant family IDs
        $mergedDomainIds = $domainId->merge($familyIds)->unique();

        // Fetch control mappings for the current framework
        $controlMappings = DB::table('framework_control_mappings')
            ->where('framework_id', $frameworkId)
            ->pluck('framework_control_id');

        // Fetch controls with the family condition
        $controls = FrameworkControl::select('id', 'short_name', 'parent_id', 'family')
            ->with('Family:id,name') // Include family details
            ->whereIn('id', $controlMappings)
            ->whereIn('family', $mergedDomainIds)
            ->get();

        // Fetch all controls without applying the family condition
        $allControls = FrameworkControl::select('id', 'short_name', 'parent_id', 'family')
            ->with('Family:id,name')
            ->whereIn('id', $controlMappings)
            ->get();

        // Get controls directly related to the framework
        $controlsFromFrame = FrameworkControlMapping::where('framework_id', $id)
            ->pluck('framework_control_id')
            ->toArray();

        // Fetch overall control status counts
        $allStatus = $this->totalControlsCountStatus(
            FrameworkControl::whereIn('id', $controlsFromFrame)
                ->whereNull('parent_id')
                ->pluck('id')
        );

        // Separate child controls and remove their parent IDs from the collection
        $childControls = $allControls->whereNotNull('parent_id');
        $parentIdsToRemove = $childControls->pluck('parent_id')->unique();
        $filteredControls = $allControls->whereNotIn('id', $parentIdsToRemove)
            ->pluck('id', 'short_name')
            ->toArray();

        // Fetch related control objectives, evidence, and responsible entities
        $frameworkControlTestAudits = ControlControlObjective::with([
            'ResponsibleUser',
            'ResponsibleTeam',
            'control',
            'evidences',
            'ResponsibleUser.department'
        ])
            ->whereIn('control_id', $filteredControls)
            ->get();

        // Fetch filtered controls with objectives
        $filteredControlsIds = FrameworkControl::select('id')
            ->with(['objectives'])
            ->whereIn('id', $filteredControls)
            ->get();

        // Calculate total counts for requirements and evidence related to the framework
        $totalCounts = $this->GetTotalReqEveFramework($frameworkControlTestAudits, $filteredControlsIds);

        // Initialize domain-specific status counts
        $domainStatusCounts = [];

        // Process each domain and fetch its associated data
        foreach ($domainId as $domain) {
            // Fetch families belonging to the current domain
            $families = DB::table('framework_families')
                ->where('parent_family_id', $domain)
                ->where('framework_id', $frameworkId)
                ->pluck('family_id');

            // Merge the domain ID and its families to get unique IDs
            $mergedSpecificeDomainIds = collect([$domain])
                ->merge($families)
                ->unique();

            // Extract control IDs within the specific domain
            $controlIds = $controls->pluck('id')->toArray();

            // Calculate status counts for controls in the domain
            $statusCounts = $this->staticsStatusForDomain(
                FrameworkControl::whereIn('id', $controlIds)
                    ->whereIn('family', $mergedSpecificeDomainIds)
                    ->whereNull('parent_id')
                    ->pluck('id')
            );

            // Fetch domain name for mapping
            $domainName = Family::findOrFail($domain)->name;

            // Store status counts for the current domain
            $domainStatusCounts[$domainName] = $statusCounts->getData()->countsByTestNumber;
        }

        // Return the data to the view
        return view('admin.content.governance.FrameWorkGraph', [
            'frameworks' => $frameworks,
            'departments' => $departments,
            'breadcrumbs' => $breadcrumbs,
            'controls' => $allControls, // Include all controls
            'id' => $id,
            'domainStatusCounts' => $domainStatusCounts,
            'allStatus' => $allStatus,
            'totalCounts' => $totalCounts, // Pass total counts
        ]);
    }

    private function totalControlsCountStatus($allControls)
    {

        // Initialize the status counts
        $statuses = ["Implemented", "Not Implemented", "Not Applicable", "Partially Implemented"];
        $statusCounts = array_fill_keys($statuses, 0); // Set all counts to 0

        // Fetch the control objectives for the given control IDs
        $controlStatus = FrameworkControl::whereIn('id', $allControls)->select('id', 'control_status')->get();
        // Iterate through the control objectives and count the statuses
        foreach ($controlStatus as $controlSta) {
            // Assuming 'status' is a field in your ControlControlObjective that holds the status
            $status = $controlSta->control_status; // Replace with the actual field name if different

            // Increment the count for the corresponding status
            if (array_key_exists($status, $statusCounts)) {
                $statusCounts[$status]++;
            }
        }

        return $statusCounts;
    }

    private function GetTotalReqEveFramework($frameworkControlTestAudits, $totalfilteredControls)
    {
        // Convert the $totalfilteredControls to an array of IDs for easy checking
        $filteredControlIdsArray = $totalfilteredControls->pluck('id')->toArray();
        $controlsWithEvidence = 0;
        $controlsWithoutEvidence = 0;
        $controlsWithRequirements = 0;
        $controlsWithoutRequirements = 0;
        $totalEvidences = 0;
        $totalObjectives = $frameworkControlTestAudits->count(); // Total number of objectives

        // Track unique control IDs that have requirements
        $uniqueControlsWithRequirements = [];

        // Track unique control IDs that have evidence
        $uniqueControlsWithEvidence = [];

        foreach ($frameworkControlTestAudits as $frameworkControlTestAudit) {
            // Check if the control_id is in the filtered controls
            if (in_array($frameworkControlTestAudit->control_id, $filteredControlIdsArray)) {
                // Check for requirements (objectives)
                if ($frameworkControlTestAudit->objective_id) {
                    // Track unique control IDs with requirements
                    if (!in_array($frameworkControlTestAudit->control_id, $uniqueControlsWithRequirements)) {
                        $uniqueControlsWithRequirements[] = $frameworkControlTestAudit->control_id;
                        $controlsWithRequirements++;
                    }
                }

                // Check for evidence
                $Withevidence = $frameworkControlTestAudit->evidences->count();
                if ($Withevidence > 0) {
                    // Track unique control IDs with evidence
                    if (!in_array($frameworkControlTestAudit->control_id, $uniqueControlsWithEvidence)) {
                        $uniqueControlsWithEvidence[] = $frameworkControlTestAudit->control_id;
                        $controlsWithEvidence++;
                    }
                    $totalEvidences += $Withevidence;
                }
            }
        }

        // Ensure controlsWithoutEvidence and controlsWithoutRequirements are correctly calculated
        $totalFilteredControlsCount = count($filteredControlIdsArray);
        $controlsWithoutEvidence = $totalFilteredControlsCount - $controlsWithEvidence;
        $controlsWithoutRequirements = $totalFilteredControlsCount - $controlsWithRequirements;

        return [
            'controlsWithEvidence' => $controlsWithEvidence,
            'controlsWithoutEvidence' => max($controlsWithoutEvidence, 0), // Avoid negative values
            'controlsWithRequirements' => $controlsWithRequirements,
            'controlsWithoutRequirements' => max($controlsWithoutRequirements, 0),
            'totalRequirements' => $totalObjectives, // Total number of objectives
            'totalEvidences' => $totalEvidences,
            'totalFilteredControls' => $totalFilteredControlsCount, // Total controls count
        ];
    }






    private function staticsStatusForDomain($latestControls)
    {
        // Initialize the status labels and counts
        $statuses = ["Implemented", "Not Implemented", "Not Applicable", "Partially Implemented"];
        $statusCounts = array_fill_keys($statuses, 0); // Initialize counts to 0 for each status

        // Fetch controls for the given IDs and their statuses
        $controlStatus = FrameworkControl::whereIn('id', $latestControls)
            ->select('id', 'control_status')
            ->get();

        // Calculate total controls count
        $totalControls = $controlStatus->count();

        // Iterate through each control and count the occurrences of each status
        foreach ($controlStatus as $controlSta) {
            $status = $controlSta->control_status;
            if (array_key_exists($status, $statusCounts)) {
                $statusCounts[$status]++;
            }
        }

        // Prepare the results array with counts and percentages
        $countsByTestNumber = [];
        foreach ($statuses as $status) {
            $count = $statusCounts[$status];
            $percentage = $totalControls > 0 ? number_format(($count * 100) / $totalControls, 2) : 0;

            $countsByTestNumber[] = [
                'status_name' => $status,
                'count' => $count,
                'percentage' => $percentage,
                'total_controls' => $totalControls
            ];
        }
        // Return the results in JSON format
        return response()->json(['countsByTestNumber' => $countsByTestNumber]);
    }


    public function FrameWorkStatusReqAndEvedience(Request $request)
    {
        if ($request->ajax()) {
            $frameworkId = $request->frame_id;
            $controlIds = FrameworkControlMapping::where('framework_id', $frameworkId)->pluck('framework_control_id')->toArray();

            $controls = FrameworkControl::select('id', 'short_name', 'parent_id')
                ->whereIn('id', $controlIds)
                ->get();
            // Separate controls that have a parent
            $childControls = $controls->whereNotNull('parent_id');
            $parentIdsToRemove = $childControls->pluck('parent_id')->unique();
            // Filter out the controls with IDs that match the `parent_id` values
            $filteredControls = $controls->whereNotIn('id', $parentIdsToRemove)
                ->pluck('id')
                ->toArray();

            // Start the query
            $query = ControlControlObjective::with(['ResponsibleUser', 'ResponsibleTeam', 'control', 'evidences', 'ResponsibleUser.department'])
                ->whereIn('control_id', $filteredControls);

            // Apply evidences filter if set
            if ($request->has_evidences) {
                if ($request->has_evidences === 'yes') {
                    $query->has('evidences');
                } elseif ($request->has_evidences === 'no') {
                    $query->doesntHave('evidences');
                }
            }

            // Apply department filter if set
            if ($request->department_id) {
                $query->whereHas('ResponsibleUser.department', function ($q) use ($request) {
                    $q->where('id', $request->department_id);
                });
            }

            $controlObjectives = $query->get();

            // Prepare data for DataTables
            $dataArr = [];
            foreach ($controlObjectives as $controlObjective) {
                $dataArr[] = [
                    'id' => $controlObjective->id,
                    'objective' => $controlObjective->objective->name,
                    'control_name' => $controlObjective->control->short_name ?? '',
                    'responsible' => $controlObjective->ResponsibleUser->name ?? $controlObjective->ResponsibleTeam->name ?? '',
                    'department' => $controlObjective->ResponsibleUser->department->name ?? null,
                    'due_date' => $controlObjective->due_date,
                    'evidences' => $controlObjective->evidences,
                ];
            }

            return DataTables::of($dataArr)->make(true);
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }









    public function processData(Request $request)
    {
        $requestData = $request->all();
        $frameworkId = Framework::where('name', $requestData['frameworkId'])->value('id');
        $childStatus = $requestData['childStatus'];
        $controlIds = FrameworkControl::select('framework_controls.*')
            ->leftJoin('framework_control_mappings', 'framework_controls.id', '=', 'framework_control_mappings.framework_control_id')
            ->whereNull('framework_controls.parent_id')
            ->where('framework_control_mappings.framework_id', $frameworkId)
            ->pluck('id')
            ->toArray();
        $numcontrolIds = count($controlIds);
        $existingIds = FrameworkControlTestAudit::whereIn('framework_control_id', $controlIds)
            ->distinct()
            ->pluck('framework_control_id')
            ->toArray();

        $nonExistingIds = array_diff($controlIds, $existingIds);
        $childIds = FrameworkControl::whereIn('parent_id', $nonExistingIds)
            ->selectRaw('MIN(id) as first_child_id')
            ->groupBy('parent_id')
            ->pluck('first_child_id')
            ->toArray();

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

        $countsByTestNumber = [];

        $encounteredTestNumbers = []; // Array to keep track of encountered test numbers
        $countsByTestNumber = []; // Initialize the array for storing counts

        // Initialize the array for storing counts

        foreach (array_merge($auditsTestNumbers, $auditsTestNumbersChild) as $testNumber) {
            // Check if the test number has not been encountered before
            if (!in_array($testNumber, $encounteredTestNumbers)) {
                $encounteredTestNumbers[] = $testNumber; // Add the test number to encountered array

                $auditCountAll = 0; // Initialize audit count for the current test number
                // Check if the test number is from $auditsTestNumbers
                if (in_array($testNumber, $auditsTestNumbers)) {
                    $auditCountAll += FrameworkControlTestAudit::whereIn('framework_control_id', $existingIds)
                        ->where(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[0]'))"), $testNumber)
                        ->where(function ($query) use ($childStatus) {
                            $query->where(DB::raw("IFNULL(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[1]')), ''), 'Not Implemented')"), $childStatus);
                            // ->orWhere(DB::raw("IFNULL(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[2]')), ''), 'Not Implemented')"), $childStatus);
                        })
                        ->orwhereIn('framework_control_id', $childIds)
                        ->where(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[0]'))"), $testNumber)
                        ->where(function ($query) use ($childStatus) {
                            $query->
                                // where(DB::raw("IFNULL(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[1]')), ''), 'Not Implemented')"), $childStatus)
                                Where(DB::raw("IFNULL(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[2]')), ''), 'Not Implemented')"), $childStatus);
                        })
                        ->count();
                }
                // Add the result to the $countsByTestNumber array
                $countsByTestNumber[] = [
                    'test_number' => $testNumber,
                    'status_name' => $childStatus,
                    'count' => $auditCountAll,
                    'percentage' => number_format($auditCountAll * 100 / $numcontrolIds, 2),
                    'total_controls' => $numcontrolIds
                ];
            }
        }
        $jsonString = json_encode(['countsByTestNumber' => $countsByTestNumber]);

        return $jsonString;
    }
    public function fetchGraphClosedControls($frameworkId)
    {
        try {
            // Get control IDs for the current framework
            $controlIds = FrameworkControlMapping::where('framework_id', $frameworkId)
                ->pluck('framework_control_id')
                ->toArray();

            // Get the latest control status data
            $latestControls = FrameworkControlTestAudit::select('framework_control_id', 'status', 'id')
                ->whereIn('framework_control_id', $controlIds)
                ->whereIn('id', function ($query) {
                    $query->select(DB::raw('MAX(id)'))
                        ->from('framework_control_test_audits')
                        ->groupBy('framework_control_id');
                })
                ->get();

            // Count controls in each status
            $statusCounts = $latestControls->groupBy('status')->map(function ($group) {
                return $group->count();
            });

            // Define closed status ID
            $closedStatusId = 2; // Assuming 2 is the 'Closed' status ID

            // Total controls
            $totalControls = $latestControls->count();

            // Calculate closed and open controls
            $closedControls = $statusCounts->get($closedStatusId, 0); // Count controls with status = 2
            $openControls = $totalControls - $closedControls; // All other statuses are considered "open"

            // Percentages
            $closedPercentage = $totalControls > 0 ? ($closedControls / $totalControls) * 100 : 0;
            $openPercentage = $totalControls > 0 ? ($openControls / $totalControls) * 100 : 0;

            // Prepare data for chart
            $statusData = [
                [
                    'status' => 'Closed',
                    'count' => $closedControls,
                    'percentage' => $closedPercentage
                ],
                [
                    'status' => 'Open',
                    'count' => $openControls,
                    'percentage' => $openPercentage
                ]
            ];

            // Return chart data in JSON format
            return response()->json([
                'totalControls' => $totalControls,
                'statusData' => $statusData
            ]);
        } catch (\Exception $e) {
            // Log the exception and return an error message
            Log::error('Error fetching graph data: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }
}
