<?php

namespace App\Http\Controllers\admin\reporting;

use App\Http\Controllers\Controller;
use App\Http\Traits\RiskAssetTrait;
use App\Models\AuditResponsible;
use App\Models\Family;
use App\Models\Framework;
use App\Models\FrameworkControl;
use App\Models\FrameworkControlMapping;
use App\Models\FrameworkControlTestAudit;
use App\Models\FrameworkControlTestResult;
use App\Models\TestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrameWorkControllerReportingController extends Controller
{

    /**
     * Display framewrok control compliance status report
     *
     * @return String
     */
    public function framewrokControlComplianceStatus(Request $request)
    {
        // Retrieve framework_id or set to null if not provided
        $frameworkId = $request->query('framework_id', null);

        // Your existing code
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Compliance Framework')],
            ['link' => route('admin.audit.frame.index'), 'name' => __('locale.AuditPlan')],
            ['name' => __('locale.framework_control_compliance_status')]
        ];
        $frameworks = Framework::get();
        $auditNames = FrameworkControlTestAudit::select('audit_name')->distinct()->get();

        // Pass $frameworkId to the view, if you need it to set a default selection
        return view('admin.content.reporting.framewrok-control-compliance-status', compact('breadcrumbs', 'frameworks', 'auditNames', 'frameworkId'));
    }


    public function auditTestNumber($id = null)
    {
        try {
            if ($id !== null) {
                // Retrieve a random framework control ID based on the selected framework
                $frameworkControlIds = FrameworkControlMapping::where('framework_id', $id)
                    ->inRandomOrder()
                    ->pluck('framework_control_id')
                    ->first();
    
                // Retrieve the latest test result for the selected framework control
                $latestTestResult = FrameworkControlTestAudit::where('framework_control_id', $frameworkControlIds)
                    ->latest('created_at')
                    ->first();
    
                // Get audit names and test_number_initiated from AuditResponsible
                $auditData = AuditResponsible::where('framework_id', $id)
                    ->select('audit_name', 'test_number_initiated')
                    ->get();
    
                // Extract test result numbers from JSON
                $testresultnumbers = [];
                if ($latestTestResult !== null) {
                    $testNumberArray = json_decode($latestTestResult->test_number, true);
                    $testresultnumbers = ($testNumberArray && count($testNumberArray) > 0) ? [$testNumberArray[0]] : [];
                }
    
                // Return both audit names with test numbers and test result numbers
                return response()->json([
                    'auditData' => $auditData,
                    'testresultnumbers' => $testresultnumbers,
                ]);
            } else {
                return response()->json(['auditData' => [], 'testresultnumbers' => []]);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    





    /**
     * Get framewrok control compliance status report
     *
     * @return String
     */
    public function framewrokControlComplianceStatusInfo(Request $request)
    {

        $frameworkId = $request->framework_id;
        $testControlNumber = $request->testControlNumber;
        $auditName = $request->audit_name;
        // Assuming $testNumber is the JSON string
        $testNumber = FrameworkControlTestAudit::where('audit_name', $auditName)->value('test_number');
        // Decode the JSON string
        $testNumberArray = json_decode($testNumber, true);
        // Get the first index
        $firstIndex = $testNumberArray[0] ?? null; // Use null coalescing to avoid undefined index notice
        // Debug output
        if ($firstIndex) {
            $testControlNumber = $firstIndex; // Assign the value to $testControlNumber
        }
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

            // Iterate through each FrameworkControl in Family::$frameworkControlIds
            foreach (Family::$frameworkControlIds as &$frameworkControl) {
                // Check if there are related frameworkControlTestAudits
                if (isset($frameworkControl['framework_control_test_audits']) && count($frameworkControl['framework_control_test_audits']) > 0) {
                    // Get the test_number value from the first related frameworkControlTestAudit
                    $testNumber = $frameworkControl['framework_control_test_audits'][0]['test_number'];
                    // Decode the JSON array and get the value at index 2
                    $testStatus = json_decode($testNumber)[1];
                    // Store the original control_status value before updating
                    $frameworkControl['original_control_status'] = $frameworkControl['control_status'];
                    // Update the control_status value based on the test_number value
                    $frameworkControl['control_status'] = $testStatus;
                }
            }

            $domains = Family::whereIn('id', $frameWorkDomainIds)->orderBy('order')
                ->with(["families" => function ($q) use ($frameWorkSubDomainIds) {
                    $q->whereIn('id', $frameWorkSubDomainIds);
                }])->get();

            foreach ($domains as &$domain) {
                foreach ($domain->families as &$family) {
                    if (isset($family->frameworkControls)) {
                        foreach ($family->frameworkControls as &$control) {
                            $this->handleControlUpdate($control, $ma);
                            if (isset($control->frameworkControls)) {
                                foreach ($control->frameworkControls as &$childControl) {
                                    $this->handleControlUpdate($childControl, $ma);
                                }
                            }
                        }
                    }
                }
            }

            // Fetch all data for FrameworkControl instances with associated test audits
            $time = FrameworkControl::with(['frameworkControlTestAudits' => function ($query) use ($testControlNumber) {
                $query->whereRaw('JSON_EXTRACT(test_number, "$[0]") = ?', [$testControlNumber]);
            }])->whereIn('id', $frameworkControlIds)->get()->toArray();

            // Get the earliest created_at timestamp among all the framework_control_test_audits
            $earliestAuditCreatedAt = null;

            foreach ($time as $frameworkControl) {
                if (isset($frameworkControl['framework_control_test_audits'])) {
                    foreach ($frameworkControl['framework_control_test_audits'] as $audit) {
                        $auditCreatedAt = $audit['created_at'];

                        if ($earliestAuditCreatedAt === null || $auditCreatedAt < $earliestAuditCreatedAt) {
                            $earliestAuditCreatedAt = $auditCreatedAt;
                        }
                    }
                }
            }

            // Include the earliest created_at timestamp in the response
            $response = array(
                'status' => true,
                'data' => [
                    'domains' => $domains,
                    'control_status_colors' => TestResult::pluck('background_class', 'name'),
                    'dateTime' => date("Y/m/d h:i:s A"),
                    'earliestAuditCreatedAt' => $earliestAuditCreatedAt,
                ],
            );

            return response()->json($response, 200);
        } else if ($tempFramework) {
            $frameWorkDomainIds = $tempFramework->only_families()->pluck('families.id')->toArray();
            $frameWorkSubDomainIds = $tempFramework->only_sub_families()->pluck('families.id')->toArray();
            Family::$frameworkControlIds = $tempFramework->FrameworkControls()->pluck('framework_controls.id')->toArray();
            $domains = Family::whereIn('id', $frameWorkDomainIds)->orderBy('order')
                ->with(["families" => function ($q) use ($frameWorkSubDomainIds) {
                    $q->whereIn('id', $frameWorkSubDomainIds);
                }])->get();
            $response = array(
                'status' => true,
                'data' => [
                    'domains' => $domains,
                    'control_status_colors' => TestResult::pluck('background_class', 'name'),
                    'dateTime' => date("Y/m/d h:i:s A")
                ],
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


    protected function handleControlUpdate(&$control, $ma)
    {
        $controlId = $control->id;
        $matchingFrameworkControl = array_filter($ma, function ($item) use ($controlId) {
            return is_array($item) && $item['id'] == $controlId;
        });
        $matchingFrameworkControl = reset($matchingFrameworkControl);

        if ($matchingFrameworkControl) {
            $originalControlStatus = $control->control_status;

            if (isset($matchingFrameworkControl['framework_control_test_audits'][0]['test_number'])) {
                $testNumberString = $matchingFrameworkControl['framework_control_test_audits'][0]['test_number'];

                $testNumberArray = json_decode($testNumberString, true);

                if (is_array($testNumberArray) && isset($testNumberArray[1])) {
                    $newControlStatus = trim($testNumberArray[1]);

                    if ($originalControlStatus !== $newControlStatus) {
                        // Update the array directly
                        $control->control_status = $newControlStatus;
                        $matchingFrameworkControl['control_status'] = $newControlStatus;
                    }
                }
            } else {
                // Fetch the parent control and its related framework_control_test_audits
                $testId = $matchingFrameworkControl['id'];
                $parentControl = FrameworkControl::with('frameworkControlTestAudits')->find($testId);

                if ($parentControl) {
                    // Now, use the ID of the latest child control
                    $latestChildControl = FrameworkControl::where('parent_id', $testId)
                        ->orderBy('created_at', 'desc')
                        ->first();

                    if ($latestChildControl) {
                        // Fetch the latest child control and its related framework_control_test_audits
                        $latestChildControlId = $latestChildControl->id;
                        $latestChildControl = FrameworkControl::with('frameworkControlTestAudits')->find($latestChildControlId);

                        // Now, compare the relationship
                        if ($parentControl->id === $latestChildControl->parent_id) {
                            $controlId = $parentControl->id;
                            $childControlId = $latestChildControl->id;

                            $matchingFrameworkControlchild = array_filter($ma, function ($item) use ($childControlId) {
                                return is_array($item) && $item['id'] == $childControlId;
                            });

                            $matchingFrameworkControlparent = array_filter($ma, function ($item) use ($controlId) {
                                return is_array($item) && $item['id'] == $controlId;
                            });

                            $matchingFrameworkControlchild = reset($matchingFrameworkControlchild);
                            $matchingFrameworkControlparent = reset($matchingFrameworkControlparent);

                            // Your additional logic here
                            // For example, merge framework_control_test_audits
                            $mergedTestAudits = array_merge(
                                $matchingFrameworkControlparent['framework_control_test_audits'],
                                $matchingFrameworkControlchild['framework_control_test_audits']
                            );

                            // Remove duplicates based on the 'id' field, you may need to adjust based on your structure
                            $uniqueMergedTestAudits = collect($mergedTestAudits)->unique('id')->values()->all();

                            // Update the framework_control_test_audits for parent control
                            $matchingFrameworkControlparent['framework_control_test_audits'] = $uniqueMergedTestAudits;
                            // Check if the array is not empty before accessing its elements
                            if (!empty($matchingFrameworkControlparent['framework_control_test_audits'])) {
                                $testNumberString = $matchingFrameworkControlparent['framework_control_test_audits'][0]['test_number'];

                                $testNumberArray = json_decode($testNumberString, true);

                                if (is_array($testNumberArray) && isset($testNumberArray[2])) {
                                    $newControlStatus = trim($testNumberArray[2]);

                                    if ($originalControlStatus !== $newControlStatus) {
                                        // Update the array directly
                                        $control->control_status = $newControlStatus;
                                        $matchingFrameworkControlparent['control_status'] = $newControlStatus;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }


    /**
     * Display summary of results for evaluation and compliance report
     *
     * @return String
     */
    public function summaryOfResultsForEvaluationAndCompliance(Request $request)
    {
        $frameworkId = $request->query('framework_id', null);
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Compliance Framework')],
            ['link' => route('admin.audit.frame.index'), 'name' => __('locale.AuditPlan')],
            ['name' => __('locale.summary_of_results_for_evaluation_and_compliance')]
        ];
        $statuses = TestResult::pluck('background_class', 'name');
        $frameworks = Framework::get();
        $auditNames = FrameworkControlTestAudit::select('audit_name')->distinct()->get();

        return view('admin.content.reporting.summary-of-results-for-evaluation-and-compliance', compact('breadcrumbs', 'statuses', 'frameworks', 'auditNames', 'frameworkId'));
    }

    // /**
    //  * Get summary of results for evaluation and compliance report
    //  *
    //  * @return String
    //  */
    public function summaryOfResultsForEvaluationAndComplianceInfo(Request $request)
    {
        $frameworkId = $request->framework_id;
        $testControlNumber = $request->testControlNumber;

        $tempFramework = Framework::find($frameworkId);
        if ($request->audit_name) {
            $auditId = AuditResponsible::where('audit_name', $request->audit_name)->first()->id;
            // Assuming $testNumber is the JSON string
            $testNumber = FrameworkControlTestAudit::where('audit_id', $auditId)->value('test_number');

            // Decode the JSON string
            $testNumberArray = json_decode($testNumber, true);
            // Get the first index
            $firstIndex = $testNumberArray[0] ?? null; // Use null coalescing to avoid undefined index notice
            // Debug output
            if ($firstIndex) {
                $testControlNumber = $firstIndex; // Assign the value to $testControlNumber
            }
        }

        if ($testControlNumber && $tempFramework) {
            // $data['total'] = $tempFramework->FrameworkControls()->groupBy('control_status')->select('control_status', DB::raw('count(*) as total'))->pluck('total', 'control_status')->toArray();
            $data['total'] = $tempFramework->only_parent_controls()->groupBy('control_status')->select('control_status', DB::raw('count(*) as total'))->pluck('total', 'control_status')->toArray();
            $controlStatuses = ['Not Applicable', 'Not Implemented', 'Partially Implemented', 'Implemented'];

            foreach ($controlStatuses as $controlStatus) {
                if (!array_key_exists($controlStatus, $data['total'])) {
                    $data['total'][$controlStatus] = 0;
                }
            }
            unset($controlStatuses);

            // $data['all'] = $tempFramework->FrameworkControls()->count();
            // $data['all'] = $tempFramework->only_parent_controls()->count();
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

            // Iterate through each FrameworkControl in Family::$frameworkControlIds
            foreach (Family::$frameworkControlIds as &$frameworkControl) {
                // Check if there are related frameworkControlTestAudits
                if (isset($frameworkControl['framework_control_test_audits']) && count($frameworkControl['framework_control_test_audits']) > 0) {
                    // Get the test_number value from the first related frameworkControlTestAudit
                    $testNumber = $frameworkControl['framework_control_test_audits'][0]['test_number'];
                    // Decode the JSON array and get the value at index 2
                    $testStatus = json_decode($testNumber)[1];
                    // Store the original control_status value before updating
                    $frameworkControl['original_control_status'] = $frameworkControl['control_status'];
                    // Update the control_status value based on the test_number value
                    $frameworkControl['control_status'] = $testStatus;
                }
            }


            $domains = Family::whereIn('id', $frameWorkDomainIds)
                ->orderBy('order')
                ->with([
                    "custom_families_report_time" => function ($q) use ($frameWorkSubDomainIds) {
                        $q->whereIn('id', $frameWorkSubDomainIds);
                    },
                    "custom_families_report_time.custom_frameworkControls.frameworkControlTestAudits" => function ($q) use ($testControlNumber) {
                        $q->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(test_number, "$[0]")) = ?', [$testControlNumber]);
                    }
                ])
                ->get();





            $domains = Family::whereIn('id', $frameWorkDomainIds)->orderBy('order')
                ->with(["families" => function ($q) use ($frameWorkSubDomainIds) {
                    $q->whereIn('id', $frameWorkSubDomainIds);
                }])->get();

            foreach ($domains as &$domain) {
                foreach ($domain->families as &$family) {
                    if (isset($family->frameworkControls)) {
                        foreach ($family->frameworkControls as &$control) {
                            $this->handleControlUpdate($control, $ma);
                            if (isset($control->frameworkControls)) {
                                foreach ($control->frameworkControls as &$childControl) {
                                    $this->handleControlUpdate($childControl, $ma);
                                }
                            }
                        }
                    }
                }
            }

            $domainsArray = [];

            foreach ($domains as $mainKey => $domain) {
                $domainsArray[$mainKey] = [];
                $domainsArray[$mainKey]['id'] = $domain['id'];
                $domainsArray[$mainKey]['name'] = $domain['name'];
                $domainsArray[$mainKey]["Partially Implemented"] = 0;
                $domainsArray[$mainKey]["Implemented"] = 0;
                $domainsArray[$mainKey]["Not Applicable"] = 0;
                $domainsArray[$mainKey]["Not Implemented"] = 0; // Fix this line
                $domainsArray[$mainKey]["total"] = 0;

                foreach ($domain->families as $family) {
                    // Check if the family ID is in $frameWorkSubDomainIds
                    if (in_array($family->id, $frameWorkSubDomainIds)) {
                        $formattedFamily = [
                            'id' => $family->id,
                            'name' => $family->name,
                            'order' => $family->order,
                            'parent_id' => $family->parent_id,
                            'custom_framework_controls' => [],
                        ];

                        foreach ($family->frameworkControls as $control) {
                            $formattedControl = [
                                'control_status' => $control->control_status,
                                'family' => $control->family,
                            ];

                            // Update the counters based on control status
                            switch ($control->control_status) {
                                case 'Partially Implemented':
                                    $domainsArray[$mainKey]["Partially Implemented"]++;
                                    break;
                                case 'Implemented':
                                    $domainsArray[$mainKey]["Implemented"]++;
                                    break;
                                case 'Not Applicable':
                                    $domainsArray[$mainKey]["Not Applicable"]++;
                                    break;
                                case 'Not Implemented':
                                    $domainsArray[$mainKey]["Not Implemented"]++; // Fix this line
                                    break;
                                case '':
                                    $domainsArray[$mainKey]["Not Implemented"]++; // Optional: Handle empty status separately if needed
                                    break;
                            }

                            $formattedFamily['custom_framework_controls'][] = $formattedControl;
                        }

                        $domainsArray[$mainKey]['total'] += count($family->frameworkControls);
                    }
                }
            }


            $totals = [
                'Partially Implemented' => 0,
                'Implemented' => 0,
                'Not Applicable' => 0,
                'Not Implemented' => 0,
            ];

            $totalAll = 0;

            foreach ($domainsArray as $domain) {
                $totals['Partially Implemented'] += $domain['Partially Implemented'];
                $totals['Implemented'] += $domain['Implemented'];
                $totals['Not Applicable'] += $domain['Not Applicable'];
                $totals['Not Implemented'] += $domain['Not Implemented'];
                $totalAll += $domain['total'];
            }

            $data = [
                'total' => $totals,
                'all' => $totalAll,
            ];

            unset($domains);
            $domainStatusCounts = $this->GetDomainGraphsForReport($testControlNumber ?? null, $tempFramework ?? null);
            $response = [
                'status' => true,
                'data' => [
                    'data' => $data,
                    'domains' => $domainsArray,
                    'dateTime' => date("Y/m/d h:i:s A"),
                    'domainStatusCounts' => $domainStatusCounts, // Include domainStatusCounts in the response
                ]
            ];
             return response()->json($response, 200);
        } else if ($tempFramework) {
            // $data['total'] = $tempFramework->FrameworkControls()->groupBy('control_status')->select('control_status', DB::raw('count(*) as total'))->pluck('total', 'control_status')->toArray();
            $data['total'] = $tempFramework->only_parent_controls()->groupBy('control_status')->select('control_status', DB::raw('count(*) as total'))->pluck('total', 'control_status')->toArray();
            $controlStatuses = ['Not Applicable', 'Not Implemented', 'Partially Implemented', 'Implemented'];

            foreach ($controlStatuses as $controlStatus) {
                if (!array_key_exists($controlStatus, $data['total'])) {
                    $data['total'][$controlStatus] = 0;
                }
            }
            unset($controlStatuses);

            // $data['all'] = $tempFramework->FrameworkControls()->count();
            $data['all'] = $tempFramework->only_parent_controls()->count();
            $frameWorkDomainIds = $tempFramework->only_families()->pluck('families.id')->toArray();
            $frameWorkSubDomainIds = $tempFramework->only_sub_families()->pluck('families.id')->toArray();
            $domains = Family::whereIn('id', $frameWorkDomainIds)->orderBy('order')
                ->with(["custom_families" => function ($q) use ($frameWorkSubDomainIds) {
                    $q->whereIn('id', $frameWorkSubDomainIds);
                }])->get();


            Family::$frameworkControlIds = $tempFramework->FrameworkControls()->pluck('framework_controls.id')->toArray();
            $domains = Family::whereIn('id', $frameWorkDomainIds)->orderBy('order')
                ->with(["families" => function ($q) use ($frameWorkSubDomainIds) {
                    $q->whereIn('id', $frameWorkSubDomainIds);
                }])->get();

            $domainsArray = [];
            foreach ($domains as $mainKey => $domain) {

                $domainsArray[$mainKey] = [];
                $domainsArray[$mainKey]['id'] = $domain['id'];
                $domainsArray[$mainKey]['name'] = $domain['name'];
                $domainsArray[$mainKey]["Partially Implemented"] = 0;
                $domainsArray[$mainKey]["Implemented"] = 0;
                $domainsArray[$mainKey]["Not Applicable"] = 0;
                $domainsArray[$mainKey]["Not Implemented"] = 0;
                $domainsArray[$mainKey]["total"] = 0;

                foreach ($domain->custom_families as $key => $subDomain) {

                    foreach ($subDomain->custom_frameworkControls as $key => $frameworkControl) {

                        $domainsArray[$mainKey][$frameworkControl['control_status']]++;
                        $domainsArray[$mainKey]['total']++;
                    }
                }
            }
            unset($domains);

            $domainStatusCounts = $this->GetDomainGraphsForReport($testControlNumber ?? null, $tempFramework ?? null);
            $response = [
                'status' => true,
                'data' => [
                    'data' => $data,
                    'domains' => $domainsArray,
                    'dateTime' => date("Y/m/d h:i:s A"),
                    'domainStatusCounts' => $domainStatusCounts, // Include domainStatusCounts in the response
                ]
            ];

            return response()->json($response, 200);
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404'),
            );
            return response()->json($response, 404);
        }
    }
    private function GetDomainGraphsForReport($testControlNumber, $tempFramework)
    {

        $frameworkId = $tempFramework->id;
        // Find family IDs that match the criteria
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
        // Merging the two collections
        $mergedDomainIds = $domainId->merge($familyIds)->unique();


        // Fetch the controls
        $controlMappings = DB::table('framework_control_mappings')
            ->where('framework_id', $frameworkId)
            ->pluck('framework_control_id');

        // Fetch all controls with family information (as a collection)
        $controls = FrameworkControl::select('id', 'short_name', 'parent_id', 'family')
            ->with('Family:id,name') // Assuming `name` is the column you need from `Family`
            ->whereIn('id', $controlMappings)
            ->whereIn('family', $mergedDomainIds)
            ->get();

        // Prepare to collect statuses by domain and family
        $domainStatusCounts = [];

        foreach ($domainId as $domain) {
            // Fetch families under the current domain
            $families = DB::table('framework_families')
                ->where('parent_family_id', $domain)
                ->pluck('family_id');

            // Convert $domain to a collection if it's an integer
            $domainCollection = collect([$domain]);

            // Merge and get unique values
            $mergedSpecificeDomainIds = $domainCollection->merge($families)->unique();

            // Separate controls that have a parent
            $childControls = $controls->whereNotNull('parent_id');
            $parentIdsToRemove = $childControls->pluck('parent_id')->unique();

            $controlIds = $controls->pluck('id')->toArray(); // Get an array of IDs

            $statusCounts = $this->staticsStatusForDomain(
                FrameworkControl::whereIn('id', $controlIds)
                    ->whereIn('family', $mergedSpecificeDomainIds)
                    ->whereNull('parent_id')
                    ->pluck('id'),
                $testControlNumber,
                $tempFramework
            );

            $domainName = Family::findOrFail($domain)->name;

            // Store the counts for this domain
            $domainStatusCounts[$domainName] = $statusCounts->getData()->countsByTestNumber;
        }
         return $domainStatusCounts;
    }
    private function staticsStatusForDomain($latestControls, $testControlNumber, $tempFramework)
    {
        if ($testControlNumber && $tempFramework) {
            // Initialize the status labels and counts
            $statuses = ["Implemented", "Not Implemented", "Not Applicable", "Partially Implemented"];
            $statusCounts = array_fill_keys($statuses, 0); // Initialize counts to 0 for each status
            $totalStatusCounts = array_fill_keys($statuses, 0); // Initialize total counts

            // Step 1: Fetch all relevant control IDs along with their children (if any)
            $controls = FrameworkControl::select('framework_controls.id', 'framework_controls.parent_id')
                ->whereNull('framework_controls.parent_id')
                ->whereIn('id', $latestControls)
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

            // Calculate the total number of control IDs
            $numControlIds = count($parentWithChildren) + count($parentWithoutChildren);

            // Step 3: Loop through each status and calculate counts
            $countsByTestNumber = [];
            foreach ($statuses as $status) {
                // Count for parents with children
                $auditCountChildren = FrameworkControlTestAudit::whereIn('framework_control_id', $parentWithChildren)
                    ->where(function ($query) use ($status, $testControlNumber) {
                        $query->where('audit_id', $testControlNumber)
                            ->where(DB::raw("IFNULL(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[2]')), ''), 'Not Implemented')"), $status);
                    })
                    ->count();

                // Count for parents without children
                $auditCountParents = FrameworkControlTestAudit::whereIn('framework_control_id', $parentWithoutChildren)
                    ->where(function ($query) use ($status, $testControlNumber) {
                        $query->where('audit_id', $testControlNumber)
                            ->where(DB::raw("IFNULL(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[1]')), ''), 'Not Implemented')"), $status);
                    })
                    ->count();

                // Total count for the current status
                $auditCountAll = $auditCountChildren + $auditCountParents;

                // Update total status counts
                $totalStatusCounts[$status] = $auditCountAll;

                // Add the result to the $countsByTestNumber array for the current framework
                $countsByTestNumber[] = [
                    'status_name' => $status,
                    'count' => $auditCountAll,
                    'percentage' => $numControlIds > 0 ? number_format($auditCountAll * 100 / $numControlIds, 2) : 0,
                    'total_controls' => $numControlIds
                ];
            }
            // Return the results in the desired JSON format
            return response()->json(['countsByTestNumber' => $countsByTestNumber]);
        } elseif ($tempFramework) {
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
    }
}
