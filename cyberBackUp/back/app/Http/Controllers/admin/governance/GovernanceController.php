<?php

namespace App\Http\Controllers\admin\governance;

use App\Events\AuditResponsibleStoredCreated;
use App\Events\AuditResponsibleUpdated;
use App\Http\Controllers\Controller;
use App\Models\ControlAuditEvidence;
use App\Models\ControlAuditObjective;
use App\Models\ControlAuditPolicy;
use App\Models\RiskFunction;
use App\Models\RiskGrouping;
use App\Models\ThreatGrouping;
use Illuminate\Http\Request;
use App\Models\Framework;
use App\Models\FrameworkControlMapping;
use App\Models\FrameworkControl;
use App\Models\User;
use App\Models\Family;
use App\Models\ControlPriority;
use App\Models\ControlPhase;
use App\Models\ControlType;
use App\Models\ControlMaturity;
use App\Models\ControlClass;
use App\Models\ControlControlObjective;
use App\Models\ControlDesiredMaturity;
use App\Models\ControlObjective;
use App\Models\Department;
use App\Models\Team;
use App\Models\FrameworkControlTest;
use App\Models\ItemsToTeam;
use App\Models\FrameworkControlTestAudit;
use App\Models\FrameworkControlTestResult;
use App\Models\TestResult;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use App\Events\FrameworkCreated;
use App\Events\FrameworkUpdated;
use App\Events\FrameworkDeleted;
use App\Events\ControlCreated;
use App\Events\ControlUpdated;
use App\Events\ControlDeleted;
use App\Events\DocumentCreated;
use App\Events\DocumentUpdated;
use App\Events\DocumentDeleted;
use App\Events\ControlObjectiveCreated;
use App\Events\ControlEvidenceCreated;
use App\Events\ControlEvidenceUpdated;
use App\Events\ControlAuditCreated;
use App\Events\CateogryCreated;
use App\Events\CateogryUpdated;
use App\Events\ControlObjectiveDeleted;
use App\Events\ControlObjectiveEditCreated;
//Document
use App\Models\Document;
use App\Models\DocumentTypes;
use App\Models\DocumentStatus;
use App\Models\File;
use App\Models\Privacy;
use App\Models\DocumentNote;
use App\Models\DocumentNoteFile;
use App\Models\Evidence;
use App\Models\Action;
use App\Models\AuditResponsible;
use App\Models\FrameworkControlExtension;
use App\Models\ObjectiveComment;
use App\Models\Regulator;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Response;
use Yajra\DataTables\Facades\DataTables;
use Log;
use App\Http\Traits\ItemTeamTrait;
use App\Http\Traits\ItemUserTrait;
use App\Models\ItemsToUser;
use App\Models\TestStatus;
use Carbon\Carbon;
use Spatie\PdfToImage\Pdf;
use PhpOffice\PhpWord\IOFactory;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Session;
use Intervention\Image\ImageManagerStatic as Image;

class GovernanceController extends Controller
{
    use ItemTeamTrait;
    use ItemUserTrait;

    /**
     * Display a dump message for testing
     *
     * @return String
     */
    public function index()
    {

        //Frameworks
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Regulators')],
            ['link' => route('admin.governance.control.list'), 'name' => __('locale.Governance')],
            ['name' => __('governance.Define Control Frameworks')]
        ];
        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'todo-application',
        ];

        $frameworks = Framework::with('FrameworkControls', 'families')->get();
        $families = Family::whereNull('parent_id')->select('id', 'name')->with('custom_families_framework:id,name,parent_id')->get();
        $priorities = ControlPriority::all();
        $phases = ControlPhase::all();
        $types = ControlType::all();
        $maturities = ControlMaturity::all();
        $classes = ControlClass::all();
        $owners = User::all();
        $desiredMaturities = ControlDesiredMaturity::all();
        $testers = User::all();
        $teams = Team::all();
        $parentControls = FrameworkControl::doesntHave('parentFrameworkControl')->with('Frameworks')->get();
        $category1 = DB::select('SELECT parent  , framework_control_mappings.id  ,frameworks.id as value,
    framework_id ,frameworks.description, short_name , name FROM frameworks ,framework_control_mappings , framework_controls where frameworks.id = framework_id and framework_control_mappings.framework_control_id  = framework_controls.id GROUP BY name ,short_name;
        ');

        $category2 = DB::select('SELECT * FROM frameworks;');
        $category2 = Framework::with(['only_families', 'only_sub_families'])->get();

        $tempDomainsId = [];
        foreach ($category2 as $framework) {
            $tempDomainsId = [];
            foreach ($framework->only_families as $family) {
                array_push($tempDomainsId, $family->id);
            }
            $framework->_only_families = $tempDomainsId;

            $tempDomainsId = [];
            foreach ($framework->only_sub_families as $family) {
                array_push($tempDomainsId, $family->id);
            }
            $framework->_only_sub_families = $tempDomainsId;
        }
        $group = array();
        // dd($category2->toArray());

        foreach ($category1 as $value) {
            $group[$value->name][] = $value;
        }

        return view('admin.content.governance.index', ['pageConfigs' => $pageConfigs], compact('teams', 'testers', 'group', 'frameworks', 'breadcrumbs', 'category2', 'families', 'priorities', 'owners', 'phases', 'types', 'maturities', 'classes', 'owners', 'desiredMaturities', 'parentControls'));
    }
    public function configure()
    {
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Regulators')],
            ['link' => route('admin.governance.control.list'), 'name' => __('locale.Controls')],
            ['name' => __('locale.Configure')],
        ];
        $risk_groupings = RiskGrouping::all();
        $risk_functions = RiskFunction::all();
        $threat_groupings = ThreatGrouping::all();

        $addValueTables = [
            // TableName => Language key
            'control_types' => 'ControlType',
            'control_maturities' => 'ControlMaturity',
        ];

        return view('admin.content.configure.Add_Values', compact('breadcrumbs', 'risk_groupings', 'risk_functions', 'threat_groupings', 'addValueTables'));
    }
    public function ajaxGetListTest(Request $request, $id)
    {

        $tests = FrameworkControlMapping::with('FrameworkControl')->where('framework_id', $id)->get()->map(function ($test) {
            // parentFamily
            if ($test->FrameworkControl[0]) {
                $controlName = $test->FrameworkControl[0]->short_name;
                if ($test->FrameworkControl[0]->Frameworks()->count()) {
                    $controlName .= ' (' . implode(', ', $test->FrameworkControl[0]->Frameworks()->pluck('name')->toArray()) . ')';
                }
            } else {
                $controlName = "";
            }

            return (object)[
                'responsive_id' => '',
                'id' => $test->FrameworkControl[0]->id,
                'control' => $controlName,
                'description' => $test->FrameworkControl[0]->description,
                // 'control_number' => $test->FrameworkControl[0]->control_number,
                // 'role' => $test->FrameworkControl[0]->id,
                'map_id' => $test->id,

                // 'owner_name' => $test->FrameworkControl[0]->User->name,
                'family_name' => $test->FrameworkControl[0]->Family->name ?? null,
                'parent_family_name' => $test->FrameworkControl[0]->Family->parentFamily->name ?? null,
                // 'class_name' => $test->FrameworkControl[0]->classes->pluck('name'),
                // 'phases_name' => $test->FrameworkControl[0]->phases->pluck('name'),
                // 'prio_name' => $test->FrameworkControl[0]->priorities->pluck('name'),
                // 'mat_name' => $test->FrameworkControl[0]->maturities->pluck('name'),
                // 'desired_name' => $test->FrameworkControl[0]->desiredMaturities->pluck('name'),
            ];
        });


        return response()->json($tests, 200);
    }

    public function ajaxGetListMap(Request $request, $id)
    {

        $controls = DB::select('select * from framework_controls where id not
    in ( SELECT framework_control_id FROM frameworks ,framework_control_mappings ,
                                          framework_controls where frameworks.id = framework_id and framework_id = "' . $id . '" and framework_control_mappings.framework_control_id = framework_controls.id ) ;
        ');


        $html = "";
        if (!empty($controls)) {
            foreach ($controls as $control) {
                $FrameworkControl = FrameworkControl::find($control->id);

                if ($FrameworkControl) {
                    $controlName = $FrameworkControl->short_name;
                    if ($FrameworkControl->Frameworks()->count()) {
                        $controlName .= ' (' . implode(', ', $FrameworkControl->Frameworks()->pluck('name')->toArray()) . ')';
                    }
                } else {
                    $controlName = "";
                }

                $html .= "<input type= checkbox  id= control  name= control[]  value=" . $control->id . ">";
                $html .= "<label class = gov_check for=control>" . $controlName . "</label><br>";
            }
            $html .= "<input type= hidden  id= control  name= frame_id  value=" . $id . ">";
            $html .= "  <button type= submit  class= gov_btn> mapping </button>";
        } else {
            $html .= "<h3 class=gov_err> no controls for mapping </h3><br>";
        }
        echo $html;
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'max:255', 'unique:frameworks,name'],
            'description' => ['required', 'string'],
            'icon' => ['required', 'string'],
            'family' => ['required', 'array'],
            'family.*' => ['required', 'exists:families,id'],
            'sub_family' => ['required', 'array'],
            'sub_family.*' => ['required', 'exists:families,id'],
        ];
        // Validation rules
        $validator = Validator::make($request->all(), $rules);
        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('governance.ThereWasAProblemAddingTheFrameworkControl') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();

            try {
                // Start adding framework data
                $framework = Framework::create([
                    "name" => $request->name,
                    "description" => $request->description,
                    "icon" => $request->icon
                ]); // End adding framework data


                $framework->families()->attach($request->family); // attach domains to framewrok

                $subDomains = [];

                foreach ($request->sub_family as $subFamily) {
                    $parentDomainId = Family::where('id', $subFamily)->pluck('parent_id')->first();
                    $subDomains[$subFamily] = ['parent_family_id' => $parentDomainId];
                }

                $framework->families()->attach($subDomains); // attach sub-domains to framewrok

                DB::commit();
                event(new FrameworkCreated($framework));

                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('governance.FrameworkControlWasAddingSuccessfully'),
                );

                $message = __('governance.A New Framework Created by name') . ' "' . ($framework->name ?? __('locale.[No FrameWork Name]')) . '" '
                    . __('governance.and the Description of it is') . ' "' . ($framework->description ?? __('locale.[No Description]')) . '" '
                    . __('locale.CreatedBy') . ' "' . auth()->user()->name . '".';
                write_log($framework->id, auth()->id(), $message, 'Creating Framework');

                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                    // 'message' => $th->getMessage()
                );
                return response()->json($response, 502);
            }
        }
    }
    public function store_regulator(Request $request)
    {
        $rules = [
            'name' => ['required', 'max:255', 'unique:frameworks,name'],
            'description' => ['required', 'string'],
            'icon' => ['required', 'string'],
            'family' => ['required', 'array'],
            'family.*' => ['required', 'exists:families,id'],
            'sub_family' => ['required', 'array'],
            'sub_family.*' => ['required', 'exists:families,id'],
        ];
        // Validation rules
        $validator = Validator::make($request->all(), $rules);
        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('governance.ThereWasAProblemAddingTheFrameworkControl') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();

            try {
                // Start adding framework data
                $framework = Framework::create([
                    "name" => $request->name,
                    "description" => $request->description,
                    "icon" => $request->icon,
                    'regulator_id' => $request->regulator_id
                ]); // End adding framework data


                $framework->families()->attach($request->family); // attach domains to framewrok

                $subDomains = [];

                foreach ($request->sub_family as $subFamily) {
                    $parentDomainId = Family::where('id', $subFamily)->pluck('parent_id')->first();
                    $subDomains[$subFamily] = ['parent_family_id' => $parentDomainId];
                }

                $framework->families()->attach($subDomains); // attach sub-domains to framewrok

                DB::commit();
                event(new FrameworkCreated($framework));

                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('governance.FrameworkControlWasAddingSuccessfully'),
                );

                $message = __('governance.A New Framework Created by name') . ' "' . ($framework->name ?? __('locale.[No FrameWork Name]')) . '" '
                    . __('governance.and the Description of it is') . ' "' . ($framework->description ?? __('locale.[No Description]')) . '" '
                    . __('locale.CreatedBy') . ' "' . auth()->user()->name . '".';
                write_log($framework->id, auth()->id(), $message, 'Creating Framework');

                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                    // 'message' => $th->getMessage()
                );
                return response()->json($response, 502);
            }
        }
    }


    public function update(Request $request, $id)
    {
        $id = $request->id;
        $framework = Framework::find($id);

        if ($framework) {
            $rules = [
                'name' => ['required', 'max:255', 'unique:frameworks,name,' . $framework->id],
                'description' => ['required', 'string'],
                'family' => ['required', 'array'],
                'family.*' => ['required', 'exists:families,id'],
                'sub_family' => ['required', 'array'],
                'sub_family.*' => ['required', 'exists:families,id'],
            ];

            // Validation rules
            $validator = Validator::make($request->all(), $rules);
            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('governance.ThereWasAProblemUpdatingTheFrameworkControl') . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();
                try {
                    // to get the old data of department to use it in log
                    $frameworkOldDetAils = Framework::find($id);
                    // Start updating framework data
                    $framework->update([
                        "name" => $request->name,
                        "description" => $request->description,
                        "icon" => $request->icon
                    ]); // End updating framework data

                    $subDomains = $framework->families()->whereNotNull('parent_family_id')->pluck('family_id')->toArray();
                    // Start saving domains and  sub-domains
                    $currentDomains = $framework->families()->whereNull('parent_family_id')->pluck('family_id')->toArray();

                    $deletedDomains = array_diff($currentDomains ?? [], $request->family ?? []);
                    $addedDomains = array_diff($request->family ?? [], $currentDomains ?? []);

                    $currentSubDomains = $framework->families()->whereNotNull('parent_family_id')->pluck('family_id')->toArray();
                    $deletedSubDomains = array_diff($currentSubDomains ?? [], $request->sub_family ?? []);
                    $addedSubDomains = array_diff($request->sub_family ?? [], $currentSubDomains ?? []);

                    $frameControls = $framework->FrameworkControls()->pluck('family')->toArray();

                    // Check if any deleted subdomains are related to controls
                    $conflictingControls = FrameworkControl::whereIn('family', $deletedSubDomains)
                        ->pluck('short_name') // Get the control short names
                        ->toArray();

                    if (count($conflictingControls)) {
                        DB::rollBack();
                        $response = [
                            'status' => false,
                            'reload' => false,
                            'message' => __('governance.ThereWasAProblemUpdatingTheFrameworkControl') . "<br>" .
                                __('governance.FrameworkDeletedDomainsOrSubDomainsFoundedInItsControls') . "<br><br>" .
                                __('governance.Related Controls:') . '<br>' . implode('<br>', $conflictingControls),
                        ];
                        return response()->json($response, 502);
                    }

                    // Delete deleted domains
                    $framework->families()->detach($deletedDomains);

                    // Add added domains
                    $framework->families()->attach($addedDomains); // attach domains to framewrok


                    // Delete deleted sub-domains
                    $framework->families()->detach($deletedSubDomains);

                    $subDomains = [];
                    // Add added sub-domains
                    foreach ($addedSubDomains as $subFamily) {
                        $parentDomainId = Family::where('id', $subFamily)->pluck('parent_id')->first();
                        $subDomains[$subFamily] = ['parent_family_id' => $parentDomainId];
                    }

                    // Retrieve all control IDs associated with the given framework IDs
                    $controlIds = FrameworkControlMapping::where('framework_id', $id)
                        ->pluck('framework_control_id')
                        ->toArray();
                    // Update control owner for all relevant controls
                    FrameworkControl::whereIn('id', $controlIds)
                        ->update(['control_owner' => $request->input('owner')]);

                    $framework->families()->attach($subDomains); // attach sub-domains to framewrok
                    // End saving domains and  sub-domains

                    DB::commit();
                    event(new FrameworkUpdated($framework));

                    $response = array(
                        'status' => true,
                        'reload' => true,
                        'message' => __('governance.FrameworkControlWasUpdatedSuccessfully'),
                    );
                    $message = __('governance.A Framework that name is') . ' "' . ($framework->name ?? __('locale.[No Name]')) . '"';

                    if ($framework->name != $frameworkOldDetAils->name) {
                        $message .= ' ' . __('governance.changed to') . ' "' . ($framework->name ?? __('locale.[No Name]')) . '"';
                    } else {
                        $message .= ' ' . __('governance.and the description of it') . ' "' . ($frameworkOldDetAils->description ?? __('locale.[No Description]')) . '"';
                    }

                    if ($framework->description != $frameworkOldDetAils->description) {
                        $message .= ' ' . __('governance.And the description changed from') . ' "' . ($frameworkOldDetAils->description ?? __('locale.[No Description]')) . '"';
                    }

                    $message .= ' ' . __('governance.to') . ' "' . ($framework->description ?? __('locale.[No Description]')) . '"';
                    $message .= ' ' . __('locale.UpdatedBy') . ' "' . auth()->user()->name . '".';


                    write_log($framework->id, auth()->id(), $message, 'Updating Framework');
                    return response()->json($response, 200);
                } catch (\Throwable $th) {
                    DB::rollBack();

                    $response = array(
                        'status' => false,
                        'errors' => [],
                        'message' => __('locale.Error')
                        // 'message' => $th->getMessage()
                    );
                    return response()->json($response, 502);
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

    public function show($id)
    {
        $framework = Framework::find($id);
        $departments = Department::all();
        $frameworkControlIds = FrameworkControlMapping::where('framework_id', $id)
            ->inRandomOrder()
            ->pluck('framework_control_id')
            ->first();
        $owners = User::all();

        // Retrieve the latest test result for the selected framework control
        $latestTestResult = FrameworkControlTestAudit::where('framework_control_id', $frameworkControlIds)
            // ->latest('created_at')
            ->get();

        $regulatorFramework = Framework::where('id', $id)->pluck('regulator_id')->first(); // Use first() to get the single value
        $frameworksname = Framework::pluck('id', 'name')->toArray(); // Use first() to get the single value
        $teams = Team::all();
        $enabledUsers = User::where('enabled', true)
            ->with('manager:id,name,manager_id')
            ->get();

        $allregulators = Regulator::pluck('id', 'name')->toArray();

        $testControlNumbers = FrameworkControlTestAudit::where('framework_control_id', $frameworkControlIds)
            ->latest('created_at')
            ->first();

        if ($testControlNumbers !== null) {
            // Decode the JSON string and get the first element
            $testNumberArray = json_decode($testControlNumbers->test_number, true);

            // Assuming the structure is [2, ""], retrieve the first element
            $testControlNumber = ($testNumberArray && count($testNumberArray) > 0) ? $testNumberArray[0] : null;
            $testNumberIntiated = intval($testNumberArray[0] ?? 0);
        } else {
            // Handle the case when no record is found
            $testControlNumber = null;
            $testNumberIntiated = 0;
        }

        // Check if testNumberIntiated is 0 to handle it appropriately
        if ($testNumberIntiated == 0) {
            // When testNumberIntiated is 0, set before last to null or some default value
            $testNumberIntiatedCurrent = 0;
            $testNumberIntiatedBeforeLast = 0; // Or set to 0 if you prefer
        } else {
            $testNumberIntiatedCurrent = $testNumberIntiated;
            $testNumberIntiatedBeforeLast = $testNumberIntiated - 1;
        }
        $statusData = [];

        if ($testControlNumber && $framework) {
            // $data['total'] = $framework->FrameworkControls()->groupBy('control_status')->select('control_status', DB::raw('count(*) as total'))->pluck('total', 'control_status')->toArray();
            $data['total'] = $framework->only_parent_controls()->groupBy('control_status')->select('control_status', DB::raw('count(*) as total'))->pluck('total', 'control_status')->toArray();
            $controlStatuses = ['Not Applicable', 'Not Implemented', 'Partially Implemented', 'Implemented'];

            foreach ($controlStatuses as $controlStatus) {
                if (!array_key_exists($controlStatus, $data['total'])) {
                    $data['total'][$controlStatus] = 0;
                }
            }
            unset($controlStatuses);
            $StatusAduitImp = $this->getDefaultStatus($framework->id);
            $statusData = json_decode($StatusAduitImp, true);

            // $data['all'] = $framework->FrameworkControls()->count();
            // $data['all'] = $framework->only_parent_controls()->count();
            $frameWorkDomainIds = $framework->only_families()->pluck('families.id')->toArray();
            $frameWorkSubDomainIds = $framework->only_sub_families()->pluck('families.id')->toArray();
            $frameworkControlIds = $framework->FrameworkControls()->pluck('framework_controls.id')->toArray();

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

            $response = array(
                'data' => $data,
                'domains' => $domainsArray
            );
        } else {
            // $data['total'] = $framework->FrameworkControls()->groupBy('control_status')->select('control_status', DB::raw('count(*) as total'))->pluck('total', 'control_status')->toArray();
            $data['total'] = $framework->only_parent_controls()->groupBy('control_status')->select('control_status', DB::raw('count(*) as total'))->pluck('total', 'control_status')->toArray();
            $controlStatuses = ['Not Applicable', 'Not Implemented', 'Partially Implemented', 'Implemented'];

            foreach ($controlStatuses as $controlStatus) {
                if (!array_key_exists($controlStatus, $data['total'])) {
                    $data['total'][$controlStatus] = 0;
                }
            }
            unset($controlStatuses);

            // $data['all'] = $framework->FrameworkControls()->count();
            $data['all'] = $framework->only_parent_controls()->count();
            $frameWorkDomainIds = $framework->only_families()->pluck('families.id')->toArray();
            $frameWorkSubDomainIds = $framework->only_sub_families()->pluck('families.id')->toArray();
            $domains = Family::whereIn('id', $frameWorkDomainIds)->orderBy('order')
                ->with(["custom_families" => function ($q) use ($frameWorkSubDomainIds) {
                    $q->whereIn('id', $frameWorkSubDomainIds);
                }])->get();

            $StatusAduitImp = Null;
            Family::$frameworkControlIds = $framework->FrameworkControls()->pluck('framework_controls.id')->toArray();
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
            $response = array(
                'data' => $data,
                'domains' => $domainsArray
            );
        }
        //Frameworks
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Regulators')],

            ['link' => route('admin.governance.regulator.index'), 'name' => __('locale.Framework')],
            ['name' => $framework->name]
        ];

        $currentAuditData = $this->getAllStatusForAduit($testNumberIntiatedCurrent, $framework->id);
        $previousAuditData = $this->getAllStatusForAduit($testNumberIntiatedBeforeLast, $framework->id);
        // $allfamilies = Family::whereNull('parent_id') // Main families
        //     ->with('familiesOlny') // Include sub-families
        //     ->select('id', 'name')
        //     ->get();


        return view('admin.content.governance.ShowFrameWork', compact('breadcrumbs', 'departments', 'StatusAduitImp', 'testNumberIntiatedBeforeLast', 'testNumberIntiatedCurrent', 'framework', 'response', 'latestTestResult', 'regulatorFramework', 'allregulators', 'frameworksname', 'teams', 'enabledUsers', 'testNumberIntiated', 'statusData', 'currentAuditData', 'previousAuditData', 'owners'));
    }

    public function frameDetails(Request $request)
    {

        $id = $request->id;
        // Get the framework with its families and sub-families
        $frame = Framework::with(['only_families', 'only_sub_families'])->where('id', $id)->first();

        // Fetch the families data
        $families = Family::whereNull('parent_id')->select('id', 'name')
            ->with('custom_families_framework:id,name,parent_id')->get();

        // Prepare families data with 'selected' flag
        $families_data = [];
        foreach ($families as $family) {
            $families_data[] = [
                'id' => $family->id,
                'name' => $family->name,
                'selected' => in_array($family->id, $frame->only_families->pluck('id')->toArray())
            ];
        }

        // Fetch the sub-families data
        $subfamilies = Family::whereNotNull('parent_id')->select('id', 'name')
            ->with('custom_families_framework:id,name,parent_id')->get();
        // Prepare sub-families data with 'selected' flag
        $subfamilies_data = [];
        foreach ($subfamilies as $subFamily) {
            $subfamilies_data[] = [
                'id' => $subFamily->id,
                'name' => $subFamily->name,
                'selected' => in_array($subFamily->id, $frame->only_sub_families->pluck('id')->toArray())
            ];
        }

        // Return the response as a JSON array
        return response()->json([
            'name' => $frame->name,
            'description' => $frame->description,
            'families' => $families_data,   // Families with selection status
            'subfamilies' => $subfamilies_data  // Sub-families with selection status
        ]);
    }
    private function getDefaultStatus($id)
    {
        $frameworkId =  $id;

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
                    $childStatus = "Implemented";
                    $auditCountAll += FrameworkControlTestAudit::whereIn('framework_control_id', $existingIds)
                        ->where(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[0]'))"), $testNumber)
                        ->where(function ($query) use ($childStatus) {
                            $query->where(DB::raw("IFNULL(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[1]')), ''), 'Not Implemented')"), $childStatus);
                        })
                        ->orwhereIn('framework_control_id', $childIds)
                        ->where(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[0]'))"), $testNumber)
                        ->where(function ($query) use ($childStatus) {
                            $query->Where(DB::raw("IFNULL(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[2]')), ''), 'Not Implemented')"), $childStatus);
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
    public function getAllStatusForAduitInAuditScreen($testNumber, $frameworkId)
    {
        // Get control IDs associated with the framework
        $controlIds = FrameworkControl::select('framework_controls.*')
            ->leftJoin('framework_control_mappings', 'framework_controls.id', '=', 'framework_control_mappings.framework_control_id')
            ->whereNull('framework_controls.parent_id')
            ->where('framework_control_mappings.framework_id', $frameworkId)
            ->pluck('id')
            ->toArray();
        $numcontrolIds = count($controlIds);

        // Get existing control IDs in FrameworkControlTestAudit
        $existingIds = FrameworkControlTestAudit::whereIn('framework_control_id', $controlIds)
            ->distinct()
            ->pluck('framework_control_id')
            ->toArray();

        // Get non-existing control IDs (those not found in FrameworkControlTestAudit)
        $nonExistingIds = array_diff($controlIds, $existingIds);

        // Get the first child control ID for each non-existing parent control ID
        $childIds = FrameworkControl::whereIn('parent_id', $nonExistingIds)
            ->selectRaw('MIN(id) as first_child_id')
            ->groupBy('parent_id')
            ->pluck('first_child_id')
            ->toArray();

        // Define the statuses you want to include in the result
        $statuses = ["Implemented", "Partially Implemented", "Not Implemented", "Not Applicable"];

        $countsByTestNumber = []; // Initialize array for results

        // Loop over each status and calculate count and percentage
        foreach ($statuses as $status) {
            $auditCountAll = FrameworkControlTestAudit::whereIn('framework_control_id', $existingIds)
                ->where(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[0]'))"), $testNumber)
                ->where(function ($query) use ($status) {
                    $query->where(DB::raw("IFNULL(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[1]')), ''), 'Not Implemented')"), $status);
                })
                ->orWhereIn('framework_control_id', $childIds)
                ->where(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[0]'))"), $testNumber)
                ->where(function ($query) use ($status) {
                    $query->Where(DB::raw("IFNULL(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[2]')), ''), 'Not Implemented')"), $status);
                })
                ->count();

            // Add the result to the $countsByTestNumber array
            $countsByTestNumber[] = [
                'test_number' => $testNumber,
                'status_name' => $status,
                'count' => $auditCountAll,
                'percentage' => $numcontrolIds > 0 ? number_format($auditCountAll * 100 / $numcontrolIds, 2) : 0,
                'total_controls' => $numcontrolIds
            ];
        }

        // Encode the results into JSON and return them
        return response()->json(['countsByTestNumber' => $countsByTestNumber]);
    }


    public function storeAduitResponsible(Request $request)
    {
        try {
            // Validate the request data
            $validated = $request->validate([
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
            $lastintiate = AuditResponsible::latest()->first()->test_number_initiated ?? 0;

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


    public function getAuditerData(Request $request)
    {
        if ($request->ajax()) {
            $userId = auth()->user()->id;
            $frameworkId = $request->input('framework_id'); // Get the framework_id from the request

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

            if ($frameworkId) {
                $query->where('audits_responsibles.framework_id', $frameworkId);
            }

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


                    $detailsButton = '<a class="dropdown-item details-btn" data-framework-id="' . $row->framework_id . '" data-test-control-number="' . $row->test_number_initiated . '"><i class="fas fa-eye"></i> ' . __('locale.Details') . '</a>';


                    // Only show dropdown if at least one button should appear and due date has not passed
                    if ($detailsButton) {
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




    public function getEditData(Request $request)
    {
        if ($request->ajax()) {
            $audit = AuditResponsible::find($request->id);

            // Assuming teams are stored as a comma-separated string in the database
            $audit->responsible = explode(',', $audit->responsible);

            return response()->json($audit);
        }
    }















    public function destroy(Request $request, $id)
    {
        $framework = Framework::find($id);

        if ($framework) {
            DB::beginTransaction();
            try {
                //Delete Related Mapping Controls
                DB::table('framework_control_mappings')->where('framework_id', $id)->delete();
                $framework->delete();

                DB::commit();
                // event(new FrameworkDeleted($framework));
                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('governance.FrameworkControlWasDeletedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                if ($th->errorInfo[0] == 23000) {
                    $errorMessage = __('governance.ThereWasAProblemDeletingTheFrameworkControl') . "<br>" . __('governance.CannotDeleteRecordRelationError');
                } else {
                    $errorMessage = __('governance.ThereWasAProblemDeletingTheFrameworkControl');
                }
                $response = array(
                    'status' => false,
                    'reload' => false,
                    'message' => $errorMessage,
                    // 'message' => $th->getMessage(),
                );
                return response()->json($response, 404);
            }
        } else {
            $response = array(
                'status' => false,
                'reload' => false,
                'message' => __('locale.Error 404'),
            );
            return response()->json($response, 404);
        }
    }

    public function frameMap(Request $request)
    {
        foreach ($request->get("control") as $subject) {
            $frames = new FrameworkControlMapping();
            $frames->framework_control_id = $subject;
            $frames->framework_id = $request->get("frame_id");
            $frames->save();
        }
        return redirect()->back();
    }

    public function unMapControl(Request $request, $id)
    {

        DB::table('framework_control_mappings')->where('id', $id)->delete();
        // return redirect()->back();

    }

    public function editControl(Request $request, $id)
    {
        $isParent = FrameworkControl::find($id)->frameworkControls()->count();
        $isChild = FrameworkControl::find($id)->parentFrameworkControl()->exists();

        $controls = DB::select('select * from framework_controls where id = "' . $id . '"  ');
        $_control = FrameworkControl::with('Frameworks:id')->find($id);
        // dd($_control->toArray());
        $family = Family::where('id', $controls[0]->family)->with('parentFamily')->first();
        $parentFamily = $family->parentFamily;
        $subFamilies = $parentFamily->families;
        $parentControls = [];

        if ($isParent == 0) {
            $parentControls = FrameworkControl::doesntHave('parentFrameworkControl')->where('id', '<>', $id)->get();
        }

        $families = Family::whereNull('parent_id')->with('families')->get();
        $priorities = ControlPriority::all();
        $phases = ControlPhase::all();
        $types = ControlType::all();
        $maturities = ControlMaturity::all();
        $classes = ControlClass::all();
        // $owners=ControlOwner::all();
        if (isDepartmentManager()) {
            $departmentId = (Department::where('manager_id', auth()->id())->first())->id;
            $owners = User::where('department_id', $departmentId)->orWhere('id', auth()->id())->get();
        } else {
            $departmentManagersIds = Department::pluck('manager_id')->toArray();
            $owners = User::whereIn('id', $departmentManagersIds)->get();
        }

        $desiredMaturities = ControlDesiredMaturity::all();
        $testers = User::whereHas('role.rolePermissions', function ($query) {
            $query->where('key', 'audits.result');
        })->get();
        $test_name = FrameworkControlTest::where('framework_control_id', $id)->first();

        $_frameworks = Framework::select('id', 'name')->with(['only_families:id,name', 'only_sub_families:id,name,parent_id', 'FrameworkControlsFrameworks:id,short_name'])->get();
        $frameworks = [];
        foreach ($_frameworks as $framework) {
            $tempFramework = [
                'id' => $framework->id,
                'name' => $framework->name,
                'domains' => [],
                'controls' => array_map(function ($control) {
                    return [
                        "id" => $control['id'],
                        // "short_name" => $control['short_name'],
                        "name" => $control['short_name'] . ' (' . implode(', ', array_map(
                            function ($framework) {
                                return $framework['name'];
                            },
                            $control['frameworks']
                        )) . ')'
                    ];
                }, $framework->FrameworkControlsFrameworks->toArray()),
            ];
            $frameworkDomains = [];
            foreach ($framework->only_families as $family) {
                $frameworkDomains = [
                    'id' => $family->id,
                    'name' => $family->name,
                ];

                $frameworkDomainSunDomains = [];
                foreach ($framework->only_sub_families as $sub_family) {
                    if ($family->id == $sub_family->parent_id) {
                        array_push($frameworkDomainSunDomains, [
                            'id' => $sub_family->id,
                            'name' => $sub_family->name,
                        ]);
                    }
                }
                $frameworkDomains['sub_domains'] = $frameworkDomainSunDomains;
                array_push($tempFramework['domains'], $frameworkDomains);
            }
            array_push($frameworks, $tempFramework);
        }

        unset($_frameworks);

        $html = "";
        foreach ($controls as $control) {
            // id
            $html .= "<input type='hidden' name='id' value='$control->id' />";

            //name
            $html .= "<div class='mb-1'>
                    <label for='title' class='form-label'>name</label>
                    <input type='text' name='name' class=' form-control' placeholder='' required value='$control->short_name' />
                    <span class='error error-name '></span>
                </div>";


            //description
            $html .= "<div class='mb-1'>
                  <label for='desc' class='form-label'>Description</label>
                  <textarea   class='form-control'  name='description' >$control->description</textarea>
                  <span class='error error-description ' ></span>

                </div>";
            // control number
            $html .= "<div class='mb-1'>
                  <label for='title' class='form-label'>Control number</label>
                  <input type='text' name='number' class=' form-control' placeholder='' value='$control->control_number' />
                </div>";

            //long_name
            $html .= "<div class='mb-1'>
                <label class = 'form-label' for='long_name'>  long name </label>
                <input class ='form-control'  type= 'text'    name='long_name' value='$control->long_name' />
              </div>";

            // framework
            $html .= "<div class='mb-1 framework-container'>
       <label class = 'form-label' for='family'>" . __('locale.Framework') . "</label>
       <select class='select2 form-select  add-control-framework-select' name='framework' required " . ($isParent ? 'disabled' : '') . ">
       <option value='' disabled selected>" . __('locale.select-option') . "</option>";
            $controlFramework = null;

            foreach ($frameworks as $framework) {

                if (isset($_control['frameworks']) && @$_control['frameworks'][0]->id == $framework['id'])
                    $controlFramework = $framework;

                if ($isParent)
                    if (isset($_control['frameworks']) && @$_control['frameworks'][0]->id != $framework['id'])
                        continue;
                $html .= "<option value='" . @$framework['id'] . "' data-domains='" . json_encode(@$framework['domains']) . "' data-controls='" . json_encode(@$framework['controls']) . "'  " . (@$_control['frameworks'][0]->id == $framework['id'] ? 'selected' : '') . ">" . $framework['name'] . "</option>";
            }

            $html .= "</select>
        <span class='error error-framework'></span>
       </div>";

            // domain
            $html .= "<div class='mb-1 family-container'>
       <label class = 'form-label' for='family'>  Control domain </label>
       <select class='select2 form-select domain_select' name='family' " . ($isChild ? 'disabled' : '') . ">
       <option value='' disabled selected>" . __('locale.select-option') . "</option>";
            $controDomains = null;
            if (isset($controlFramework['domains'])) {
                foreach ($controlFramework['domains'] as $domain) {
                    if ($parentFamily->id == $domain['id'])
                        $controDomains = $domain;
                    $html .= "<option value='" . $domain['id'] . "' " . ($parentFamily->id == $domain['id'] ? 'selected' : '') . " data-families='" . json_encode($domain['sub_domains']) . "'>" . $domain['name'] . "</option>";
                }
            }

            $html .= "</select>
        <span class='error error-family'></span>
       </div>";

            // sub domain
            $html .= "<div class='mb-1'>
      <label class = 'form-label' for='family'>" . __('locale.control_sub_domain') . "</label>
      <select class='select2 form-select' name='sub_family' " . ($isChild ? 'disabled' : '') . ">
      <option value='' disabled selected>" . __('locale.select-option') . "</option>";
            if (isset($controDomains['sub_domains'])) {
                foreach ($controDomains['sub_domains'] as $subDomain) {
                    $html .= "<option value='" . $subDomain['id'] . "' " . ($control->family == $subDomain['id'] ? 'selected' : '') . ">" . $subDomain['name'] . "</option>";
                }
            }

            $html .= "</select>
      <span class='error error-sub_family'></span>
      </div>";

            // Parent control
            $html .= "<div class='mb-1'>
      <label class = 'form-label' for='family'>" . __('governance.ParentControlFramework') . "</label>
      <select class='select2 form-select' name='parent_id' " . ($isParent ? 'disabled' : '') . ">
        <option  value=''>" . __('locale.select-option') . "</option>";
            foreach ($parentControls as $parentControl) {
                $controlName = $parentControl->short_name;
                if ($parentControl->Frameworks()->count()) {
                    $controlName .= ' (' . implode(', ', $parentControl->Frameworks()->pluck('name')->toArray()) . ')';
                }
                $html .= "<option value='$parentControl->id' " . ($parentControl->id == $control->parent_id ? 'selected' : '') . ">$controlName</option>";
            }
            $html .= "</select>
      <span class='error error-parent_id'></span>
      </div>";

            // mitigation_guidance
            $html .= "<div class='mb-1'>
                <label class = 'form-label' for='mitigation_percent'>  mitigation percent  </label>
                <input class ='form-control'  type= 'text'    name='mitigation_percent' value='$control->mitigation_percent' />
              </div>";

            // supplemental_guidance
            // $html .= "<div class='mb-1'>
            //       <label class = 'form-label' for='supplemental_guidance'>Control Guide Implementation</label>
            //       <div class='form-control'  name='supplemental_guidance' rows='7'>{!!$control->supplemental_guidance!!}</div>
            //     </div>";
            $html .= "<div class='mb-1'>
            <label class='form-label' for='supplemental_guidance'>Control Guide Implementation</label>
            <div id='control_guide_implementation' style='height: 60px;'>$control->supplemental_guidance</div>
            <input type='hidden' name='supplemental_guidance' id='supplemental_guidance_input' value='$control->supplemental_guidance'>
        </div>";


            // $html .= "<script>
            //     // Make sure Quill is included and initialized after the content is added to the DOM
            //     var quill = new Quill('#control_guide_implementation', {
            //         theme: 'snow',
            //     });name='supplemental_guidance'
            // </script>";



            // priority
            $html .= "<div class='mb-1'>
                  <label class = 'form-label' for='priority'>  Control priority </label>
                  <select class='select2 form-select' name='priority'>
                    <option  value=''> select priority</option>";
            foreach ($priorities as $priority) {
                $html .= "<option value='$priority->id' " . ($control->control_priority == $priority->id ? 'selected' : '') . "> $priority->name</option>";
            }
            $html .= "</select>
                </div>";

            // phase
            $html .= "<div class='mb-1'>
                <label class = 'form-label' for='phase'>  Control Phase </label>
                <select class='select2 form-select' name='phase'>
                  <option  value=''> select phase</option>";
            foreach ($phases as $phase) {
                $html .= "<option value='$phase->id' " . ($control->control_phase == $phase->id ? 'selected' : '') . "> $phase->name</option>";
            }
            $html .= "</select>
          </div>";


            // type
            $html .= "<div class='mb-1'>
                <label class = 'form-label' for='type'>  Control type </label>
                <select class='select2 form-select' name='type'>
                  <option  value=''> select type</option>";
            foreach ($types as $type) {
                $html .= "<option value='$type->id' " . ($control->control_type == $type->id ? 'selected' : '') . "> $type->name</option>";
            }
            $html .= "</select>
              </div>";

            // maturity
            $html .= "<div class='mb-1'>
                <label class = 'form-label' for='maturity'>  Control Maturity </label>
                <select class='select2 form-select' name='maturity'>
                  <option  value=''> select maturity</option>";
            foreach ($maturities as $maturity) {
                $html .= "<option value='$maturity->id' " . ($control->control_maturity == $maturity->id ? 'selected' : '') . "> $maturity->name</option>";
            }
            $html .= "</select>
                </div>";

            // class
            $html .= "<div class='mb-1'>
              <label class = 'form-label' for='class'>  Control class </label>
              <select class='select2 form-select' name='class'>
                <option  value=''> select class</option>";
            foreach ($classes as $class) {
                $html .= "<option value='$class->id' " . ($control->control_class == $class->id ? 'selected' : '') . "> $class->name</option>";
            }
            $html .= "</select>
              </div>";

            // Desired  Maturity
            $html .= "<div class='mb-1'>
              <label class = 'form-label' for='desired_maturity'>  Control desired maturity </label>
              <select class='select2 form-select' name='desired_maturity'>
                <option  value=''> select desired maturity</option>";
            foreach ($desiredMaturities as $desiredMaturity) {
                $html .= "<option value='$desiredMaturity->id' " . ($control->desired_maturity == $desiredMaturity->id ? 'selected' : '') . "> $desiredMaturity->name</option>";
            }
            $html .= "</select>
              </div>";

            $testResultBackgroundClass = TestResult::where('name', $control->control_status)->select('background_class')->first()->background_class;

            // Status
            $html .= "<div class='mb-1'>
                <label for='title' class='form-label'>" . "Control Status" . "</label>
                <input type='text'  class=' form-control' disabled value='$control->control_status' style='background-color:" . $testResultBackgroundClass . "' />
            </div>";

            // $html .= "<div class='mb-1'>
            //         <label class = 'form-label' for='Status'>  Control Status</label>
            //         <select class='select2 form-select' name='Status'>
            //         <option  value=''> select Status</option>
            //         <option  value='1' " . ($control->control_status == 1 ? 'selected' : '') . "> Pass</option>
            //           <option  value='0' " . ($control->control_status == 0 ? 'selected' : '') . " > Failed</option>
            //       </select>
            //     </div>";


            // owner
            $html .= "<div class='mb-1'>
              <label class = 'form-label' for='owner'>  Control owner</label>
              <select class='select2 form-select' name='owner'>
                <option  value=''> select desired maturity</option>";
            foreach ($owners as $owner) {
                $html .= "<option value='$owner->id' " . ($control->control_owner == $owner->id ? 'selected' : '') . "> $owner->name</option>";
            }
            $html .= "</select>
              </div>";

            //  tester
            $html .= "<div class='mb-1'>
              <label class = 'form-label' for='tester'>" . __('governance.Tester') . "</label>
              <select class='select2 form-select' name='tester'>
                <option value='' disabled selected>" . __('locale.select-option') . "</option>";
            foreach ($testers as $tester) {
                $html .= "<option value='$tester->id' " . ($test_name->tester == $tester->id ? 'selected' : '') . "> $tester->name</option>";
            }
            $html .= "</select>
              </div>";

            // test name
            //     $html .= "<div class='mb-1'>
            //       <label for='title' class='form-label'>" . __('locale.TestName') . "</label>
            //       <input type='text'  class=' form-control' disabled value='$test_name->name' />
            //   </div>";

            // test frequency
            $html .= "<div class='mb-1'>
              <label for='title' class='form-label'>" . __('governance.TestFrequency') . "(" . __('locale.days') . ")" . "</label>
              <input type='text'  class=' form-control' name='test_frequency' value='$test_name->test_frequency' />
          </div>";

            // latest test date
            //     $html .= "<div class='mb-1'>
            //       <label for='title' class='form-label'>" . __('locale.LastTestDate') . "</label>
            //       <input type='text'  class=' form-control js-datepicker' name='last_date' placeholder='YYYY-MM-DD' value='$test_name->last_date' />
            //   </div>";

            // test step
            $html .= "<div class='mb-1'>
                <label class='form-label' for='exampleFormControlTextarea1'>" . __('governance.TestSteps') . "</label>
                <textarea
                  class='form-control'
                  name='test_steps'
                  id='exampleFormControlTextarea1'
                  rows='3'
                >$test_name->test_steps</textarea>
                <span class='error error-test_steps ' ></span>
              </div>";

            // approximate time
            $html .= "<div class='mb-1'>
                  <label class='form-label' for='normalMultiSelect1'> " . __('locale.ApproximateTime') . "(" . __('locale.minutes') . ")</label>
                  <input name='approximate_time' type='number' id='basic-icon-default-post' class='form-control dt-post' aria-label='Web Developer' value='$test_name->approximate_time' />
                  <span class='error error-approximate_time ' ></span>
                </div>";

            // expected results
            $html .= "<div class='mb-1'>
                <label class='form-label' for='exampleFormControlTextarea1'>" . __('locale.ExpectedResults') . "</label>
                <textarea
                  class='form-control'
                  name='expected_results'
                  id='exampleFormControlTextarea1'
                  rows='3'
                >$test_name->expected_results</textarea>
                <span class='error error-expected_results' ></span>
              </div>";

            // Submit button
            $html .= "</div>
                <div class='my-1'>
                  <button type='submit' class='btn btn-primary   add-todo-item me-1'>update</button>
                  <button type='button' class='btn btn-outline-secondary add-todo-item ' data-bs-dismiss='modal'>
                    Cancel
                  </button>
                </div>
              </div>";

            //mitigation_percent
            // $html .= "<label class = gov_check for=mitigation_percent>  Mitigation Percent </label><br>";
            // $html .= "<input class =form-control  type= number    name=mitigation_percent  value=" . $control->mitigation_percent . ">";

        }
        // $html .= "<input type= hidden  id= control  name=id  value=" . $control->id . ">";
        // $html .= "<button type= submit  class= gov_btn> update </button>";

        echo $html;
    }

    public function updateControl(Request $request)
    {
        $isParent = FrameworkControl::find($request->id)->frameworkControls()->count();

        $rules = [
            'name' => ['required', 'max:1000'],
            'parent_id' => ['nullable', 'exists:framework_controls,id'], // the parent framework_control for this framework_control
        ];

        $hasParent = !is_null($request->parent_id);
        if (!$hasParent) {
            $rules['sub_family'] = ['required', 'exists:families,id'];
            $rules['family'] = ['required', 'exists:families,id'];
        }

        if (!$isParent) {
            $rules['framework'] = ['required', 'exists:frameworks,id']; // the framework that this control belongs to
        }

        $validator = Validator::make($request->all(), $rules);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('governance.ThereWasAProblemUpdatingTheFrameworkControl') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();
            try {
                $data["status"] = "success";
                $id = $request->id;

                // Set family as parent family
                if ($hasParent) {
                    $parentControl = FrameworkControl::find($request->parent_id);
                    $request->sub_family = $parentControl->family;
                }

                // Get framework control old parent
                $frameControlOldParent = FrameworkControl::find($id)->parent_id;

                $updatedData = [
                    'short_name' => $request->get("name"),
                    'description' => $request->get("description"),
                    'control_number' => $request->get("number"),
                    // 'family'  => $request->sub_family,
                    'control_class' => $request->get("class"),
                    'control_type' => $request->get("type"),
                    'control_maturity' => $request->get("maturity"),
                    'control_phase' => $request->get("phase"),
                    'control_priority' => $request->get("priority"),
                    'long_name' => $request->get("long_name"),
                    'supplemental_guidance' => $request->get("supplemental_guidance"),
                    'mitigation_percent' => $request->get("mitigation_percent"),
                    'desired_maturity' => $request->get("desired_maturity"),
                    // 'control_status'  => $request->get("control_status"),
                    'control_owner' => $request->get("owner"),
                    'parent_id' => $request->get("parent_id")
                ];

                $currentControl = FrameworkControl::find($id);
                $frameworksIdArray = $currentControl->Frameworks->pluck('id')->toArray();

                // Update sub-domain (family)

                if ($isParent) { // If is parent
                    if (!($request->has('framework')) || in_array($request->framework, $frameworksIdArray)) { // and change domains or sub-domain in the same framework
                        $updatedData['family'] = $request->sub_family;
                        // Set family for its children as its family
                        FrameworkControl::find($request->id)->frameworkControls()->update([
                            'family' => $request->sub_family
                        ]);
                    } else { // and changes in framework
                        $response = array(
                            'status' => false,
                            'errors' => [
                                "framework" =>
                                [__('governance.CanNotUpdateParentControlFramework')]
                            ],
                            'message' => __('governance.CanNotUpdateParentControlFramework') . "<br>" . __('locale.Validation error'),
                        );
                        return response()->json($response, 422);
                    }
                } else if (!$hasParent && !$isParent) { /* Isn't parent and isn't child */
                    $updatedData['family'] = $request->sub_family;
                } else if ($request->has("parent_id")) { // parent_id is passed (is child)
                    $updatedData['family'] = $request->sub_family;
                }
                // to get the data to write log
                $framesGetOldData = FrameworkControl::where('id', $id)->find($id);
                $frames = FrameworkControl::where('id', $id)->find($id);
                $frames = $frames->update($updatedData);

                // dd($frames);
                // $frames = DB::table('framework_controls')->where('id', $id)->update($updatedData);

                if ($frameControlOldParent != $request->parent_id) {
                    // from null to has parent
                    if (is_null($frameControlOldParent) && $request->get("parent_id")) {
                        // Update parent framweork control status
                        if ($request->parent_id) { // framework control has parent
                            $parentFrameworkControl = FrameworkControl::find($request->parent_id);
                            $frameworkControlChildren = $parentFrameworkControl->frameworkControls;

                            // detach frameworks
                            $currentControl->Frameworks()->detach($frameworksIdArray);
                            // Attach frameworks
                            $currentControl->Frameworks()->attach($parentFrameworkControl->Frameworks->pluck('id')->toArray()); // attach frameworks to control

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
                    } // from has parent to null
                    else if ($frameControlOldParent && is_null($request->get("parent_id"))) {
                        // Update old parent framwork control status
                        if ($frameControlOldParent) { // framework control has parent
                            $parentFrameworkControl = FrameworkControl::find($frameControlOldParent);
                            $frameworkControlChildren = $parentFrameworkControl->frameworkControls;

                            if (count($frameworkControlChildren) == 0) { // old parent now has no children (get framework control status from last audit test result)
                                $lastTestAudit = $parentFrameworkControl->FrameworkControlTest->FrameworkControlTestAudits()->orderBy('id', 'desc')->first() ?? null;
                                if ($lastTestAudit) {
                                    $lastTestAuditResultStatus = $lastTestAudit->FrameworkControlTestResult->testResult->name ?? null;
                                    if ($lastTestAuditResultStatus) {
                                        $newFrameWorkControlStatus = $lastTestAuditResultStatus;
                                    } else {
                                        $newFrameWorkControlStatus = 'Not Applicable';
                                    }
                                    $parentFrameworkControl->update([
                                        'control_status' => $newFrameWorkControlStatus
                                    ]);
                                }
                            } else { // old parent now has children (recalculated framework control status from its children)
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
                    } // from has parent to another parent
                    else {
                        $frameControlNewParent = $request->parent_id;

                        $parentFrameworkControl = FrameworkControl::find($request->parent_id);
                        $frameworkControlChildren = $parentFrameworkControl->frameworkControls;

                        // detach frameworks
                        $currentControl->Frameworks()->detach($frameworksIdArray);
                        // Attach frameworks
                        $currentControl->Frameworks()->attach($parentFrameworkControl->Frameworks->pluck('id')->toArray()); // attach frameworks to control

                        // Update old parent framwork control status
                        if ($frameControlOldParent) { // framework control has parent
                            $parentFrameworkControl = FrameworkControl::find($frameControlOldParent);
                            $frameworkControlChildren = $parentFrameworkControl->frameworkControls;

                            if (count($frameworkControlChildren) == 0) { // old parent now has no children (get framework control status from last audit test result)
                                $lastTestAudit = $parentFrameworkControl->FrameworkControlTest->FrameworkControlTestAudits()->orderBy('id', 'desc')->first() ?? null;
                                if ($lastTestAudit) {
                                    $lastTestAuditResultStatus = $lastTestAudit->FrameworkControlTestResult->testResult->name ?? null;
                                    if ($lastTestAuditResultStatus) {
                                        $newFrameWorkControlStatus = $lastTestAuditResultStatus;
                                    } else {
                                        $newFrameWorkControlStatus = 'Not Implemented';
                                    }
                                    $parentFrameworkControl->update([
                                        'control_status' => $newFrameWorkControlStatus
                                    ]);
                                }
                            } else { // old parent now has children (recalculated framework control status from its children)
                                $statuses = ['Not Implemented' => 0, 'Partially Implemented' => 0, 'Implemented' => 0];
                                $frameworkControlChildrenStatuses = $frameworkControlChildren->where('control_status', '<>', 'Not Applicable')->pluck('control_status')->toArray();

                                // If all statuses == 'Not Applicable'
                                if (count($frameworkControlChildrenStatuses) == 0) {
                                    $parentFrameworkControl->update([
                                        'control_status' => 'Not Implemented'
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

                        // Update new parent framwork control status
                        if ($frameControlNewParent) {
                            $parentFrameworkControl = FrameworkControl::find($frameControlNewParent);
                            $frameworkControlChildren = $parentFrameworkControl->frameworkControls;

                            $statuses = ['Not Implemented' => 0, 'Partially Implemented' => 0, 'Implemented' => 0];
                            $frameworkControlChildrenStatuses = $frameworkControlChildren->where('control_status', '<>', 'Not Applicable')->pluck('control_status')->toArray();

                            // If all statuses == 'Not Applicable'
                            if (count($frameworkControlChildrenStatuses) == 0) {
                                $parentFrameworkControl->update([
                                    'control_status' => 'Not Implemented'
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
                }
                // get old data of FrameworkControlTest to use it in write log
                $frameworkControlTestoldData = FrameworkControlTest::where('framework_control_id', $id)->first();
                $frameworkControlTest = FrameworkControlTest::where('framework_control_id', $id)->first();
                $frameworkControlTest->update([
                    'tester' => $request->tester,
                    // 'last_date' =>$request->last_date,
                    // 'next_date' => $next_date,
                    // 'name' => $request->test_name,
                    'test_steps' => $request->test_steps,
                    // 'approximate_time' =>$request->approximate_time ,
                    // 'framework_control_id' =>$request->framework_control_id ,
                    // 'expected_results' =>$request->expected_results ,
                    // 'test_frequency' =>$request->test_frequency ,
                    'test_frequency' => $request->test_frequency ?? 0,


                    //'additional_stakeholders' =>implode(",", $request->additional_stakeholders),
                ]);


                if ($request->teams != "") {
                    $this->UpdateTeamsOfItem($id, 'test', $request->teams);
                }

                if (!$hasParent && !$isParent) { // Isn't parent and isn't child
                    if (!in_array($request->framework, $frameworksIdArray)) {
                        // detach frameworks
                        $currentControl->Frameworks()->detach($frameworksIdArray);
                        // Attach frameworks
                        $currentControl->Frameworks()->attach([$request->framework]); // attach frameworks to control
                    }
                }
                $updatedFrames = FrameworkControl::find($id);
                DB::commit();
                event(new ControlUpdated($updatedFrames, $frameworkControlTest));
                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('governance.FrameworkControlWasUpdatedSuccessfully'),
                );

                $message = __('governance.A Control that name is') . ' "' . ($framesGetOldData->short_name ?? __('locale.[No Name]')) . '"';

                if ($framesGetOldData->short_name != $updatedFrames->short_name) {
                    $message .= ' ' . __('locale.Updated to') . ' "' . ($updatedFrames->short_name ?? __('locale.[No Name]')) . '"';
                }

                $message .= ' ' . __('locale.UpdatedBy') . ' "' . auth()->user()->name . '".';

                write_log($updatedFrames->id, auth()->id(), $message, 'Updating Control');

                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                );
                return response()->json($response, 502);
            }
        }
    }

    public function storeControl(Request $request, $id)
    {
        $rules = [
            'name' => ['required', 'max:1000'],
            'test_name' => ['required'],
            'parent_id' => ['nullable', 'exists:framework_controls,id'], // the parent framework_control for this framework_control
            'tester' => ['required', 'exists:users,id'], // the manager for department
        ];

        $hasParent = !is_null($request->parent_id);
        if (!$hasParent) {
            $rules['family'] = ['required', 'exists:families,id'];
            $rules['sub_family'] = ['required', 'exists:families,id'];
        }

        $validator = Validator::make($request->all(), $rules);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('governance.ThereWasAProblemAddingTheFrameworkControl') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();
            try {

                // Set family as parent family
                $parentControl = null;
                if ($hasParent) {
                    $parentControl = FrameworkControl::find($request->parent_id);
                    $request->sub_family = $parentControl->family;
                }

                $data["status"] = "success";
                //add in control
                $frameControl = new FrameworkControl();
                $frameControl->short_name = $request->name;
                $frameControl->description = $request->description;
                $frameControl->control_number = $request->number;
                $frameControl->control_type = $request->type;
                $frameControl->family = $request->sub_family;
                $frameControl->control_class = $request->class;
                $frameControl->control_maturity = $request->maturity;
                $frameControl->control_phase = $request->phase;
                $frameControl->control_priority = $request->priority;
                $frameControl->long_name = $request->long_name;
                $frameControl->supplemental_guidance = $request->supplemental_guidance;
                $frameControl->mitigation_percent = $request->mitigation_percent;
                $frameControl->desired_maturity = $request->desired_maturity;
                // $frameControl->control_status =  $request->control_status;
                $frameControl->parent_id = $request->parent_id;

                if ($request->owner != "") {
                    $frameControl->control_owner = $request->owner;
                } else {
                    $frameControl->control_owner = auth()->user()->id;
                }
                $frameControl->save();
                //add in mapp

                $control_id = DB::getPdo()->lastInsertId();
                $frame_map = new FrameworkControlMapping();
                $frame_map->framework_control_id = $control_id;
                $frame_map->framework_id = $id;
                $frame_map->save();
                $request->last_date = $request->last_date ?? date('Y-m-d');

                //add test*
                // calc  next_date form last date * test_frequency
                $next_date = date('Y-m-d', strtotime($request->last_date) + ($request->test_frequency ?? 0) * 24 * 60 * 60);
                // add new test to database
                $frameworkControlTest = FrameworkControlTest::create([
                    'tester' => $request->tester,
                    'last_date' => $request->last_date,
                    'next_date' => $next_date,
                    'name' => $request->test_name,
                    'test_steps' => $request->test_steps,
                    'approximate_time' => $request->approximate_time,
                    'framework_control_id' => $control_id,
                    'expected_results' => $request->expected_results,
                    'test_frequency' => $request->test_frequency ?? 0,
                    // 'additional_stakeholders' =>implode(",", $request->additional_stakeholders),
                ]);

                $test_id = DB::getPdo()->lastInsertId();

                $audit = FrameworkControlTestAudit::create([
                    'test_id' => $test_id,
                    'tester' => $request->tester,
                    'name' => $request->test_name . "(1)",
                    'framework_control_id' => $control_id,
                    'last_date' => $request->last_date,
                    'next_date' => $next_date,
                    'test_frequency' => $request->test_frequency ?? 0,
                ]);


                //
                FrameworkControlTestResult::create([
                    'test_audit_id' => $audit->id
                ]);


                // $this->AddTeamsOfItem($frameworkControlTest->id,'test',$request->teams);

                // Update parent framweork control status
                if ($request->parent_id) { // framework control has parent
                    $parentFrameworkControl = FrameworkControl::find($request->parent_id);
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
                //end test

                // Map to parent control framework
                if ($hasParent) {
                    foreach ($parentControl->Frameworks()->select('framework_id')->get() as $framework) {
                        $frames = new FrameworkControlMapping();
                        $frames->framework_control_id = $control_id;
                        $frames->framework_id = $framework->framework_id;
                        $frames->save();
                    }
                }

                DB::commit();

                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('governance.FrameworkControlWasAddedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                );
                return response()->json($response, 502);
            }
        }
    }

    public function listControl()
    {

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Regulators')],
            ['link' => route('admin.governance.control.list'), 'name' => __('locale.Control')]
        ];

        $controls = FrameworkControl::all();
        // $parentControls = FrameworkControl::doesntHave('parentFrameworkControl')->get();
        $families = Family::whereNull('parent_id')->with('families')->get();
        $priorities = ControlPriority::all();
        $phases = ControlPhase::all();
        $types = ControlType::all();
        $maturities = ControlMaturity::all();
        $classes = ControlClass::all();
        // $owners=ControlOwner::all();
        $departmentManagersIds = Department::pluck('manager_id')->toArray();
        $owners = User::whereIn('id', $departmentManagersIds)->get();

        $desiredMaturities = ControlDesiredMaturity::all();
        $testers = User::whereHas('role.rolePermissions', function ($query) {
            $query->where('key', 'audits.result');
        })->get();
        $teams = Team::all();

        // $_frameworks = Framework::select('id', 'name')->with(['only_families:id,name', 'only_sub_families:id,name,parent_id', 'FrameworkControls:id,short_name'])->get();
        $_frameworks = Framework::select('id', 'name')->with(['only_families:id,name', 'only_sub_families:id,name,parent_id', 'FrameworkControlsFrameworks:id,short_name'])->get();

        // Add logic to get to framework with custom structure
        /*
          "id" => 3
          "name" => "NCA-CCC – 1: 2020"
          "domains" => []
          "controls" => array:1 [▼
            0 => array:2 [▼
              "id" => 1
              "name" => "c1 (NCA-SMACC, NCA-CCC – 1: 2020)"
            ]
          ]
        */
        $frameworks = [];
        foreach ($_frameworks as $framework) {
            $tempFramework = [
                'id' => $framework->id,
                'name' => $framework->name,
                'domains' => [],
                'controls' => array_map(function ($control) {
                    return [
                        "id" => $control['id'],
                        // "short_name" => $control['short_name'],
                        "name" => $control['short_name'] . ' (' . implode(', ', array_map(
                            function ($framework) {
                                return $framework['name'];
                            },
                            $control['frameworks']
                        )) . ')'
                    ];
                }, $framework->FrameworkControlsFrameworks->toArray()),
            ];
            $frameworkDomains = [];
            foreach ($framework->only_families as $family) {
                $frameworkDomains = [
                    'id' => $family->id,
                    'name' => $family->name,
                ];

                $frameworkDomainSunDomains = [];
                foreach ($framework->only_sub_families as $sub_family) {
                    if ($family->id == $sub_family->parent_id) {
                        array_push($frameworkDomainSunDomains, [
                            'id' => $sub_family->id,
                            'name' => $sub_family->name,
                        ]);
                    }
                }
                $frameworkDomains['sub_domains'] = $frameworkDomainSunDomains;
                array_push($tempFramework['domains'], $frameworkDomains);
            }
            array_push($frameworks, $tempFramework);
        }

        unset($_frameworks);

        return view("admin.content.governance.control_list", compact('teams', 'testers', 'frameworks', 'controls', 'families', 'priorities', 'phases', 'types', 'maturities', 'classes', 'owners', 'desiredMaturities', 'breadcrumbs'));
    }

    /**
     * Return a listing of the resource after some manipulation.
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxGetListControl(Request $request)
    {
        /* Start reading datatable data and custom fields for filtering */
        $dataTableDetails = [];
        $customFilterFields = [
            'normal' => ['short_name', 'control_status'],
            'relationships' => ['Frameworks', 'family_with_parent'],
            'other_global_filters' => ['description'],
        ];
        $relationshipsWithColumns = [
            // 'relationshipName:column1,column2,....'
            'Frameworks:id,name',
            'family_with_parent:id,name,parent_id'
        ];

        $relationshipsCount = [
            // 'relationshipName'
            'frameworkControls',
        ];

        prepareDatatableRequestFields($request, $dataTableDetails, $customFilterFields);
        $parentFamilyFilter = $request->columns[5]['search']['value'] ?? '';
        $subFamilyIds = [];
        if ($parentFamilyFilter && !$dataTableDetails['search']['family_with_parent']) {
            $family = Family::where('name', $parentFamilyFilter)->first();
            $subFamilyIds = $family->families()->pluck('id')->toArray();
        }
        $customConditions = [];
        if (count($subFamilyIds)) {
            $customConditions['whereIn']['family'] =  $subFamilyIds;
        }
        if (!auth()->user()->hasPermission('control.all')) {
            if (isDepartmentManager()) {
                $departmentId = (Department::where('manager_id', auth()->id())->first())->id;
                $departmentMembers =  User::with('teams')->where('department_id', $departmentId)->orWhere('id', auth()->id())->get();
                $departmentMembersIds =  $departmentMembers->pluck('id')->toArray();
                $ownedControlsIds = FrameworkControl::whereIn('control_owner', $departmentMembersIds)->pluck('id')->toArray();
                $testControlsIds =  FrameworkControlTest::whereIn('tester', $departmentMembersIds)->pluck('framework_control_id')->toarray();
                $departmentTeams = [];
                foreach ($departmentMembers as $departmentMember) {
                    $departmentTeams = array_merge($departmentTeams, $departmentMember->teams->pluck('id')->toArray());
                }
                $objectivesControlsIds =  ControlControlObjective::whereIn('responsible_id', $departmentMembersIds)->orWhereIn('responsible_team_id', $departmentTeams)->pluck('control_id')->toarray();
                $controlsIds = array_unique(array_merge($ownedControlsIds, $testControlsIds, $objectivesControlsIds));
            } else {
                $ownedControlsIds = FrameworkControl::where('control_owner', auth()->id())->pluck('id')->toArray();
                $testControlsIds =  FrameworkControlTest::where('tester', auth()->id())->pluck('framework_control_id')->toarray();
                $loggedUserTeams = User::with('teams')->find(auth()->id())->teams->pluck('id')->toArray();
                $objectivesControlsIds =  ControlControlObjective::where('responsible_id', auth()->id())->orWhereIn('responsible_team_id', $loggedUserTeams)->pluck('control_id')->toarray();
                $controlsIds = array_unique(array_merge($ownedControlsIds, $testControlsIds, $objectivesControlsIds));
            }
            $customConditions['whereIn']['id'] =  $controlsIds;
        }



        /* End reading datatable data and custom fields for filtering */

        // Getting total records count with and without apply global search
        [$totalRecords, $totalRecordswithFilter] = getDatatableFilterTotalRecordsCount(
            FrameworkControl::class,
            $dataTableDetails,
            $customFilterFields,
            $customConditions
        );

        $mainTableColumns = getTableColumnsSelect(
            'framework_controls',
            [
                'id',
                'short_name',
                'description',
                'family',
                'control_status',
                'created_at'
            ]
        );

        // Getting records with apply global search */
        $frameworkControls = getDatatableFilterRecords(
            FrameworkControl::class,
            $dataTableDetails,
            $customFilterFields,
            $relationshipsWithColumns,
            $mainTableColumns,
            $customConditions,
            $relationshipsCount
        );

        // Custom frameworkControls response data as needs
        $data_arr = [];
        foreach ($frameworkControls as $frameworkControl) {

            $data_arr[] = array(
                'id' => $frameworkControl->id,
                'short_name' => $frameworkControl->short_name ?? null,
                'description' => $frameworkControl->description ?? null,
                // 'control_number' => $frameworkControl->control_number ?? null,
                // 'owner_name' => $frameworkControl->owners->pluck('name') ?? null,
                // 'owner_name' => $frameworkControl->User->name ?? null,
                'family_name' => $frameworkControl->family_with_parent->name ?? null,
                'family_with_parent' => $frameworkControl->family_with_parent->parentFamily->name ?? null,
                // 'class_name' => $frameworkControl->classes->pluck('name') ?? null,
                // 'phases_name' => $frameworkControl->phases->pluck('name') ?? null,
                // 'prio_name' => $frameworkControl->priorities->pluck('name') ?? null,
                // 'mat_name' => $frameworkControl->maturities->pluck('name') ?? null,
                // 'desired_name' => $frameworkControl->desiredMaturities->pluck('name') ?? null,
                'Frameworks' => $frameworkControl->Frameworks->pluck('name') ?? [],
                // 'parent' => $frameworkControl->parentFrameworkControl->short_name ?? null,
                'isParent' => $frameworkControl->framework_controls_count ? true : false,
                'control_status' => $frameworkControl->control_status ?? null,
                'Actions' => $frameworkControl->id ?? null,
            );
        }

        // Get custom response for datatable ajax request
        $response = getDatatableAjaxResponse(intval($dataTableDetails['draw']), $totalRecords, $totalRecordswithFilter, $data_arr);

        return response()->json($response, 200);
    }

    public function storeControl2(Request $request)
    {
        $rules = [
            'name' => ['required', 'max:1000'],
            // 'test_name' => ['required'],
            'test_frequency' => ['required'],
            'parent_id' => ['nullable', 'exists:framework_controls,id'], // the parent framework_control for this framework_control
            'framework' => ['required', 'exists:frameworks,id'], // the framework that this control belongs to
            'tester' => ['required', 'exists:users,id'], // the manager for department
        ];

        $hasParent = !is_null($request->parent_id);
        if (!$hasParent) {
            $rules['family'] = ['required', 'exists:families,id'];
            $rules['sub_family'] = ['required', 'exists:families,id'];
        }

        $validator = Validator::make($request->all(), $rules);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('governance.ThereWasAProblemAddingTheFrameworkControl') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();
            try {

                // Set family as parent family
                $parentControl = null;
                if ($hasParent) {
                    $parentControl = FrameworkControl::find($request->parent_id);
                    $request->sub_family = $parentControl->family;
                }

                $data["status"] = "success";
                //add in control
                $supplementalGuidance = $request->supplemental_guidance;
                $control = new FrameworkControl();
                $control->short_name = $request->name;
                $control->description = $request->description;
                $control->control_number = $request->number;
                $control->control_type = $request->type;
                $control->family = $request->sub_family;
                $control->control_class = $request->class;
                $control->control_maturity = $request->maturity;
                $control->control_phase = $request->phase;
                $control->control_priority = $request->priority;
                $control->long_name = $request->long_name;
                $control->supplemental_guidance = $supplementalGuidance;
                $control->mitigation_percent = $request->mitigation_percent;
                $control->desired_maturity = $request->desired_maturity;
                // $control->control_status =  $request->control_status;
                $control->parent_id = $request->parent_id;

                if ($request->owner != "") {
                    $control->control_owner = $request->owner;
                } else {
                    $control->control_owner = auth()->user()->id;
                }

                $control->save();

                //add test
                // $request->last_date = $request->last_date ?? date('Y-m-d');
                $request->last_date = null;
                $control_id = DB::getPdo()->lastInsertId();
                // calc  next_date form last date * test_frequency
                // $next_date = date('Y-m-d', strtotime($request->last_date) + ($request->test_frequency ?? 0) * 24 * 60 * 60);
                $next_date = null;
                // add new test to database
                $frameworkControlTest = FrameworkControlTest::create([
                    'tester' => $request->tester,
                    'last_date' => $request->last_date,
                    'next_date' => $next_date,
                    'name' => $request->name,
                    'test_steps' => $request->test_steps,
                    'approximate_time' => $request->approximate_time,
                    'framework_control_id' => $control_id,
                    'expected_results' => $request->expected_results,
                    'test_frequency' => $request->test_frequency ?? 0,
                    // 'additional_stakeholders' =>implode(",", $request->additional_stakeholders),
                ]);

                $test_id = DB::getPdo()->lastInsertId();

                // $audit = FrameworkControlTestAudit::create([
                //     'test_id' => $test_id,
                //     'tester' => $request->tester,
                //     'name' => $request->name . "(1)",
                //     'framework_control_id' => $control_id,
                //     'last_date' => $request->last_date,
                //     'next_date' => $next_date,
                //     'test_frequency' => $request->test_frequency ?? 0,

                // ]);
                //
                // FrameworkControlTestResult::create([
                //     'test_audit_id' => $audit->id
                // ]);

                // Update parent framweork control status
                if ($request->parent_id) { // framework control has parent
                    $parentFrameworkControl = FrameworkControl::find($request->parent_id);
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
                //end test

                // Map to parent control framework
                if ($hasParent) {
                    foreach ($parentControl->Frameworks()->select('framework_id')->get() as $framework) {
                        $frames = new FrameworkControlMapping();
                        $frames->framework_control_id = $control_id;
                        $frames->framework_id = $framework->framework_id;
                        $frames->save();
                    }
                } else {
                    $_control = FrameworkControl::find($control_id);
                    $_control->Frameworks()->attach($request->framework); // attach the framework to the control
                }

                DB::commit();
                event(new ControlCreated($frameworkControlTest, $control));
                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('governance.FrameworkControlWasAddedSuccessfully'),
                );

                $message = __('governance.A New Control created with name') . ' "' . ($control->short_name ?? __('locale.[No Name]')) . '". '
                    . __('governance.The owner of control is') . ' "' . ($control->User->name ?? __('locale.[No User Name]')) . '" '
                    . __('governance.and the tester is') . ' "' . ($frameworkControlTest->UserTester->name ?? __('locale.[No User Tester Name]')) . '" '
                    . __('locale.CreatedBy') . ' "' . auth()->user()->name . '".';
                write_log($control->id, auth()->id(), $message, 'Creating Control');

                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

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

    public function destroyControl(Request $request, $id)
    {
        $frameworkControl = FrameworkControl::find($id);
        $documentframeworkControlIds = [];
        foreach (Document::pluck('control_ids') as $control_ids) {
            $documentframeworkControlIds = array_merge($documentframeworkControlIds, explode(',', $control_ids));
        }
        $documentframeworkControlIds = array_unique($documentframeworkControlIds);

        $getParent = null;  // Initialize getParent variable outside the try block
        $getAuditTocontrol = null;  // Initialize getAuditTocontrol variable outside the try block

        if ($frameworkControl) {
            DB::beginTransaction();
            try {
                // Check if the control is associated with any documents
                if (in_array($id, $documentframeworkControlIds)) {
                    $relatedDocuments = Document::whereRaw("FIND_IN_SET(?, control_ids)", [$id])->get();
                    throw new Exception("Related documents found", 23000);
                }

                // Check if this control is a parent control
                $getParent = FrameworkControl::where('parent_id', $id)->first();
                if ($getParent) {
                    throw new Exception("This control is a parent control and cannot be deleted.", 23001);
                }

                // Check if this control is associated with an audit
                $getAuditTocontrol = FrameworkControlTestAudit::where('framework_control_id', $id)->first();
                if ($getAuditTocontrol) {
                    throw new Exception("This control is associated with an audit and cannot be deleted.", 23002);
                }

                // Delete related records
                $getTester = FrameworkControlTest::where('framework_control_id', $id)->first();
                if ($getTester) {
                    $getTester->delete();
                }

                $getFrame = FrameworkControlMapping::where('framework_control_id', $id)->first();
                if ($getFrame) {
                    $getFrame->delete();
                }

                // Now delete the FrameworkControl itself
                $frameworkControl->delete();

                DB::commit();
                event(new ControlDeleted($frameworkControl, $getTester));

                $response = array(
                    'status' => true,
                    'message' => __('governance.ControlWasDeletedSuccessfully'),
                );
                $message = __('governance.A Control with name') . ' "' . ($frameworkControl->short_name ?? __('locale.[No FrameWork Name]')) . '" ' . __('locale.DeletedBy') . ' "' . auth()->user()->name . '".';
                write_log($frameworkControl->id, auth()->id(), $message, 'Deleting Control');

                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                // Handle specific exception codes
                if ($th->getCode() == 23000) {
                    $relatedDocuments = Document::whereRaw("FIND_IN_SET(?, control_ids)", [$id])->get(['id', 'document_name']);
                    $errorMessage = __('governance.ThereWasAProblemDeletingTheFrameworkControl') . "<br>" . __('governance.CannotDeleteRecordRelationError') . "<br><br>";

                    if ($relatedDocuments->isNotEmpty()) {
                        $errorMessage .= __('governance.Related Documents:') . '<br>';
                        foreach ($relatedDocuments as $document) {
                            $errorMessage .= "- " . $document->document_name . "<br>";
                        }
                    }
                } elseif ($th->getCode() == 23001) {
                    // Parent control related
                    $errorMessage = __('governance.This control is a parent control and cannot be deleted.') . ": " . $frameworkControl->short_name;
                } elseif ($th->getCode() == 23002) {
                    // Audit control related
                    $errorMessage = __('governance.This control is associated with an audit and cannot be deleted This Control Is Exist In Audit Name') . ": " . ($getAuditTocontrol->audit_name ?? 'N/A');
                } else {
                    $errorMessage = __('governance.ThereWasAProblemDeletingTheFrameworkControl');
                }

                $response = array(
                    'status' => false,
                    'message' => $errorMessage,
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


    public function ajaxGetListControlMap(Request $request, $id)
    {
        // Step 1: Fetch extend_control_id using control_id
        $controlsextends = FrameworkControlExtension::where('control_id', $id)->pluck('extend_control_id');

        // Step 2: Fetch the short_name and id of these controls
        $controls = FrameworkControl::whereIn('id', $controlsextends)->get(['id', 'short_name']);

        // Prepare an array to hold the final response
        $response = [
            'id' => $id,  // Include the $id parameter in the response
            'controls' => []
        ];

        // Step 3: Fetch the framework_id and corresponding framework details for each control
        foreach ($controls as $control) {
            $frameworkMapping = FrameworkControlMapping::where('framework_control_id', $control->id)->first();

            if ($frameworkMapping) {
                $framework = Framework::where('id', $frameworkMapping->framework_id)->first();
                if ($framework) {
                    $response['controls'][] = [
                        'control_id' => $control->id,
                        'control_name' => $control->short_name,
                        'framework_id' => $framework->id,
                        'framework_name' => $framework->name
                    ];
                }
            }
        }
        return response()->json($response);
    }

    public function deleteMappingControl(Request $request)
    {
        $request->validate([
            'control_id' => 'required|exists:framework_controls,id',
            'child_control_id' => 'required|exists:framework_controls,id',
        ]);

        $controlId = $request->input('control_id');
        $childControlId = $request->input('child_control_id');

        // Check if the framework_control_test_audits table has records with framework_control_id equal to $controlId or $childControlId
        $existsInAudits = DB::table('framework_control_test_audits')
            ->where(function ($query) use ($controlId, $childControlId) {
                $query->where('framework_control_id', $controlId)
                    ->orWhere('framework_control_id', $childControlId);
            })
            ->exists();

        if ($existsInAudits) {
            return response()->json([
                'status' => false,
                'message' => 'Control cannot be deleted because there are related records in Aduit.',
            ], 400);
        }

        // Check if there are any child records in the framework_controls table where parent_id == $controlId
        $childControlExists = DB::table('framework_controls')
            ->where('parent_id', $controlId)
            ->exists();

        if ($childControlExists) {
            // Get the first child record
            $firstChild = DB::table('framework_controls')
                ->where('parent_id', $controlId)
                ->first();

            // Check if the first child record exists in the framework_control_test_audits table
            $existsInAudits = DB::table('framework_control_test_audits')
                ->where('framework_control_id', $firstChild->id)
                ->exists();

            if ($existsInAudits) {
                return response()->json([
                    'status' => false,
                    'message' => 'Control cannot be deleted because there are related the child of parent in aduit.',
                ], 400);
            }
        }

        // Delete the mapping control
        $deleted = FrameworkControlExtension::where('extend_control_id', $controlId)
            ->where('control_id', $childControlId)
            ->delete();

        if ($deleted) {
            return response()->json(['status' => true, 'message' => 'Control deleted successfully!']);
        } else {
            return response()->json(['status' => false, 'message' => 'Control deletion failed.'], 500);
        }
    }


    public function fetchTreeData($id)
    {
        // Fetch the parent control
        $frameworkControlTestAudit = FrameworkControl::find($id);
        $parentName = $frameworkControlTestAudit->short_name ?? '';
        $parentStatus = $frameworkControlTestAudit->control_status ?? '';
        $frameworkControlId = $frameworkControlTestAudit->id ?? '';

        // Fetch related controls based on the framework_control_id
        $relatedControls = FrameworkControlExtension::where('control_id', $frameworkControlId)->pluck('extend_control_id');

        // Fetch details of related controls including their status
        $relatedControlsDetails = FrameworkControl::whereIn('id', $relatedControls)->get(['id', 'short_name', 'control_status', 'created_at']);

        // Fetch child-to-child relationships
        $childToChild = FrameworkControl::whereIn('parent_id', $relatedControls)->get(['id', 'short_name', 'control_status', 'parent_id', 'created_at']);

        // Fetch test numbers and their created_at for related controls
        $testNumbers = FrameworkControlTestAudit::whereIn('framework_control_id', $relatedControls)
            ->get(['framework_control_id', 'test_number', 'created_at'])
            ->groupBy('framework_control_id')
            ->map(function ($testAudits) {
                return $testAudits->map(function ($audit) {
                    // Extract test_number and created_at
                    $testNumberArray = json_decode($audit->test_number, true);
                    return [
                        'test_number' => intval($testNumberArray[0] ?? 0),
                        'created_at' => $audit->created_at,
                    ];
                })->toArray();
            });

        // Function to build a hierarchical tree of controls
        $buildTree = function ($parentId) use ($childToChild, &$buildTree, $testNumbers) {
            $children = $childToChild->where('parent_id', $parentId);

            return $children->map(function ($child) use ($buildTree, $testNumbers) {
                // Get the test numbers and created_at for the child control
                $childTestNumbers = FrameworkControlTestAudit::where('framework_control_id', $child->id)
                    ->get(['test_number', 'created_at'])
                    ->map(function ($audit) {
                        $testNumberArray = json_decode($audit->test_number, true);
                        return [
                            'test_number' => intval($testNumberArray[0] ?? 0),
                            'created_at' => $audit->created_at,
                        ];
                    });

                // Get the first test number and created_at from the array if available
                $testNumber = 'No Audit Yet';
                $testNumberCreatedAt = null;
                if ($childTestNumbers->isNotEmpty() && $childTestNumbers->count() == 1) {
                    $testNumberData = $childTestNumbers->first();
                    $testNumber = $testNumberData['test_number'];
                    $testNumberCreatedAt = $testNumberData['created_at'];
                }

                $childrenTree = $buildTree($child->id);

                return [
                    'name' => $child->short_name,
                    'status' => $child->control_status,
                    'test_number' => $testNumber,  // Set to 'No Audit Yet' if no test number
                    'test_number_created_at' => $testNumberCreatedAt,  // Include created_at for the test number
                    'children' => $childrenTree  // Recursive call to build tree for children
                ];
            })->toArray();
        };

        // Prepare the response data
        $data = [
            'parentName' => $parentName,
            'parentStatus' => $parentStatus,
            'controls' => $relatedControlsDetails->map(function ($control) use ($buildTree, $testNumbers) {

                // Get the test numbers and created_at for the control
                $testNumbersData = $testNumbers->get($control->id, []);
                $testNumber = 'No Audit Yet';  // Default value
                $testNumberCreatedAt = null;
                if (!empty($testNumbersData) && count($testNumbersData) == 1) {
                    $testNumberData = $testNumbersData[0];
                    $testNumber = $testNumberData['test_number'];
                    $testNumberCreatedAt = $testNumberData['created_at'];
                }

                return [
                    'name' => $control->short_name,
                    'status' => $control->control_status,
                    'test_number' => $testNumber,  // Set to 'No Audit Yet' if no test number
                    'test_number_created_at' => $testNumberCreatedAt,  // Include created_at for the test number
                    'children' => $buildTree($control->id)  // Build tree for each child
                ];
            })->toArray()
        ];

        return response()->json($data);
    }

















    public function saveMappingControls(Request $request)
    {
        try {
            $request->validate([
                'control_id' => [
                    'required',
                    'exists:framework_controls,id',
                ],
                'extend_control_id' => [
                    'required',
                    function ($attribute, $value, $fail) use ($request) {
                        $control_id = $request->input('control_id');
                        $extend_control_id = $value;

                        $exists = DB::table('framework_controls_extension')
                            ->where('control_id', $control_id)
                            ->where('extend_control_id', $extend_control_id)
                            ->exists();

                        if ($exists) {
                            $fail('The Control mapping with this control before.');
                        }
                    },
                ],
            ]);

            $extension = new FrameworkControlExtension();
            $extension->control_id = $request->input('control_id');
            $extension->extend_control_id = $request->input('extend_control_id');
            $extension->save();

            return response()->json(['message' => 'Form submitted successfully!', 'status' => true]);
        } catch (ValidationException $e) {
            $errors = $e->errors();
            $customMessage = implode(' ', array_map(function ($error) {
                return implode(' ', $error);
            }, $errors));

            return response()->json(['message' => $customMessage, 'status' => false], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred!', 'errors' => $e->getMessage(), 'status' => false], 500);
        }
    }
    public function getControlsByFramework(Request $request)
    {
        $frameworkId = $request->input('framework_id');
        $controlId = $request->input('control_id');

        // Fetch controls related to the framework ID, excluding the specified control ID if provided
        $controlsIdQuery = FrameworkControlMapping::where('framework_id', $frameworkId);

        if ($controlId) {
            $controlsIdQuery->where('framework_control_id', '!=', $controlId);
        }

        $controlsId = $controlsIdQuery->pluck('framework_control_id');

        // Fetch controls with id and short_name
        $controls = FrameworkControl::whereIn('id', $controlsId)->get(['id', 'short_name']);

        // Return the controls as a JSON response
        return response()->json(['controls' => $controls]);
    }

    public function AddTeamsOfItem($item_id, $type, $teams = [])
    {

        foreach ($teams as $team) {
            ItemsToTeam::create([
                'item_id' => $item_id,
                'type' => $type,
                'team_id' => $team
            ]);
        }
        return true;
    }

    public function getFrameworkTests(Request $request)
    {
        $rules = [
            'audits_framework_id' => ['required', 'exists:frameworks,id'],
        ];

        $customAttributes = [
            'audits_framework_id' => 'framework',
        ];


        $validator = Validator::make($request->all(), $rules);
        $validator->setAttributeNames($customAttributes);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('governance.ThereWasAProblemInitiatingAudit') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            $framework = Framework::find($request->audits_framework_id);

            $controls = $framework->FrameworkControlsWithoutChilds()->get();

            $testIds = $controls->pluck('FrameworkControlTest.id')->toArray();
            $testIds = implode(',', $testIds);
            if (!empty($testIds)) {
                $response = array(
                    'status' => true,
                    'data' => $testIds,
                );
                return response()->json($response, 200);
            } else {
                $errors['audits_framework_id'] = [__("governance.TheFrameworkDoesntHaveControlsToAudit")];
                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('governance.ThereWasAProblemInitiatingAudit') . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            }
        }
    }

    public function storeAudit(Request $request)
    {
        // Fetch all control IDs related to the given framework ID
        $controlIdsInFramework = FrameworkControlMapping::where('framework_id', $request->framework_id)
            ->pluck('framework_control_id') // Retrieve only control IDs
            ->toArray();
        // Check if there are any related controls before attempting to update
        if (!empty($controlIdsInFramework)) {
            // Update the status of all related control test audits to '2' (status code)
            FrameworkControlTestAudit::whereIn('framework_control_id', $controlIdsInFramework)->update(['status' => 2]);
        }
        $ListTestIds = explode(',', $request->id);
        $ListTestIds = array_filter($ListTestIds, 'strlen');
        foreach ($ListTestIds as $id) {


            $test = FrameworkControlTest::where('framework_control_id', $id)->first();

            $frameworkControl = $test->FrameworkControl()->withCount('frameworkControls')->first();
            if ($frameworkControl->framework_controls_count) {
                continue;
            }
            // Last test result audit on control
            $lastTestLog = $test->FrameworkControlTestAudits()->orderBy('id', 'desc')->first() ?? null;
            $lastTestResult = $lastTestLog->FrameworkControlTestResult->test_result ?? null;
            $lastDate = null;
            $nextDate = null;
            $auditCreatedAt = date("Y-m-d H:i:s");

            $lastAuditResbonsible = AuditResponsible::where('framework_id', $request->framework_id)->latest()->first() ?? null;
            $countAudit = $lastAuditResbonsible->test_number_initiated ?? 0;
            // $auditName=$test->name.'-('.$countAudit.')';
            // $auditName = "Control" . $test->framework_control_id . " Audit(" . $test->framework_control_id . ')-(' . $countAudit . ')';
            $auditName = $test->name . "(" . $countAudit . ")";
            $test_number = json_encode([$countAudit, '', '']);
            $audit = FrameworkControlTestAudit::create([
                'test_id' => $test->id,
                'tester' => $lastAuditResbonsible->owner_id,
                // 'last_date' => $lastDate,
                'last_date' => $lastAuditResbonsible->due_date,
                'next_date' => $lastAuditResbonsible->next_initiate_date,

                // 'next_date' => $nextDate,
                'name' => $auditName,
                'test_steps' => $test->test_steps,
                'status' => 1,
                'approximate_time' => $test->approximate_time,
                'framework_control_id' => $test->framework_control_id,
                'expected_results' => $test->expected_results,
                'desired_frequency' => $test->desired_frequency,

                'test_frequency' => $lastAuditResbonsible->periodical_time ?? 0,
                // 'test_frequency' => $test->test_frequency ?? 0,
                'created_at'  => $auditCreatedAt,
                'test_number' => $test_number,
                'audit_name' => $lastAuditResbonsible->audit_name ?? null,
                'audit_id' => $lastAuditResbonsible->id,
                'can_see' => 0,
                'action_status' => 0
            ]);

            FrameworkControlTestResult::create([
                'test_audit_id' => $audit->id,
                // 'test_result' => $lastTestResult
            ]);

            // Store related policy
            $controlDocumentIds = getControlDocuments($test->framework_control_id); // Get documents related to control
            foreach ($controlDocumentIds as $controlDocumentId) {
                ControlAuditPolicy::create([
                    'document_id' => $controlDocumentId,
                    'framework_control_test_audit_id' => $audit->id
                ]);
            }


            // Store related objectives and evidences
            $objectivesIds = ControlControlObjective::where('control_id', $test->framework_control_id)->pluck('id')->toArray(); // Get objectives related to control

            // update all requirment to make the due_date of it == to due date in the audti reponsible intiate
            if (!empty($objectivesIds) && $lastAuditResbonsible->due_date !== null) {
                ControlControlObjective::whereIn('id', $objectivesIds)
                    ->update(['due_date' => $lastAuditResbonsible->due_date]);
            }

            // this is th old logic to get all evideence and releated direct with audit in tioate 

            foreach ($objectivesIds as $objectiveId) {
                ControlAuditObjective::create([
                    'control_control_objective_id' => $objectiveId,
                    'framework_control_test_audit_id' => $audit->id
                ]);
            }
            // Check the count of $testAudit records
            $testAuditCount = FrameworkControlTestAudit::where('framework_control_id', $id)->count();

            // Only create ControlAuditEvidence records if it's the first insert
            if ($testAuditCount === 1) {
                $evidencesIds = Evidence::whereIn('control_control_objective_id', $objectivesIds)->pluck('id')->toArray();

                foreach ($evidencesIds as $evidenceId) {
                    ControlAuditEvidence::create([
                        'evidence_id' => $evidenceId,
                        'framework_control_test_audit_id' => $audit->id
                    ]);
                }
            }

            event(new ControlAuditCreated($audit, $frameworkControl));
            $message = __(
                'governance.NotifyAuditCreated',
                [
                    'user' => auth()->user()->name
                ]
            );
            $message = __('governance.A Control with name') . ' "' . ($frameworkControl->short_name ??  __('locale.[No Name]')) . '". '
                . __('governance.Added to Aduit') . ' "' . $audit->name . '" '
                . __('locale.CreatedBy') . ' "' . auth()->user()->name . '".';
            write_log($audit->id, auth()->id(), $message, 'Creating Aduit');
            // write_log($audit->id, auth()->id(), $message, FrameworkControlTestAudit::class);
        }
        return response()->json($ListTestIds, 200);
    }

    //document
    public function storeCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:250', 'unique:document_types,name'],
            // 'icon' => ['required', 'max:250'],
        ]);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('governance.ThereWasAProblemAddingTheCategory') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();
            try {
                $documentType = DocumentTypes::create([
                    'name' => $request->name,
                    'icon' => $request->icon,
                    'type_category' => $request->type_category
                ]);

                DB::commit();
                event(new CateogryCreated($documentType));
                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('governance.CategoryWasAddedSuccessfully'),
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
        }
    }

    public function updateCategory(Request $request)
    {
        $documentType = DocumentTypes::find($request->category_id);
        if ($documentType) {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'max:250', 'unique:document_types,name,' . $documentType->id],
            ]);

            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('governance.ThereWasAProblemUpdatingTheCategory') . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();
                try {
                    $documentType->update([
                        'name' => $request->name,
                        'type_category' => $request->type_category
                    ]);

                    DB::commit();
                    event(new CateogryUpdated($documentType));

                    $response = array(
                        'status' => true,
                        'reload' => true,
                        'message' => __('governance.CategoryWasUpdatedSuccessfully'),
                    );
                    return response()->json($response, 200);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    $response = array(
                        'status' => false,
                        'message' => __('locale.Error'),
                        // 'message' => $th->getMessage(),
                    );
                    return response()->json($response, 404);
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

    public function destroyCategory(Request $request, $id)
    {
        $documentType = DocumentTypes::find($id);
        if ($documentType) {
            DB::beginTransaction();
            try {
                $documentType->delete();

                DB::commit();

                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('governance.CategoryWasDeletedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                if ($th->errorInfo[0] == 23000) {
                    $errorMessage = __('governance.ThereWasAProblemDeletingTheCategory') . "<br>" . __('locale.CannotDeleteRecordRelationError');
                } else {
                    $errorMessage = __('governance.ThereWasAProblemDeletingTheCategory');
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

    public function listCategory()
    {
        //Documents
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.governance.control.list'), 'name' => __('locale.Governance')],
            ['name' => __('locale.Documentation')]
        ];
        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'todo-application',
        ];

        $documents = Document::all();
        $frameworks = Framework::with('FrameworkControls:id,short_name,control_number')->get();
        // $owners=ControlOwner::all();
        $owners = User::all();

        $desiredMaturities = ControlDesiredMaturity::all();
        $testers = User::all();
        $teams = Team::all();
        $controls = FrameworkControl::all();
        $category2 = DB::select('SELECT * FROM document_types;');
        $status = DocumentStatus::all();
        $privacies = Privacy::all();

        $activeDocumentType = request()->query('doc_type');

        if (!DocumentTypes::where('id', $activeDocumentType)->exists())
            $activeDocumentType = null;

        if (!$activeDocumentType) {
            $activeDocumentType = $category2[0]->id ?? null;
        }


        return view('admin.content.governance.category', ['pageConfigs' => $pageConfigs], compact('breadcrumbs', 'controls', 'testers', 'teams', 'documents', 'frameworks', 'owners', 'desiredMaturities', 'category2', 'status', 'privacies', 'activeDocumentType'));
    }

    public function storeDocument(Request $request)
    {
        $rules = [
            'name' => ['required', 'max:255'],
            'framework_ids' => ['nullable', 'array'],
            'framework_ids.*' => ['exists:frameworks,id'],
            'control_ids' => ['nullable', 'array'],
            'control_ids.*' => ['exists:framework_controls,id'],
            'additional_stakeholders' => ['nullable', 'array'],
            'additional_stakeholders.*' => ['exists:users,id'],
            'owner' => ['nullable', 'exists:users,id'],
            'team_ids' => ['nullable', 'array'],
            'team_ids.*' => ['exists:teams,id'],
            'creation_date' => ['required', 'date'],
            'last_review_date' => ['required', 'date', 'after_or_equal:creation_date'],
            'review_frequency' => ['required', 'integer'],
            // 'next_review_date' => ['nullable', 'date', 'after:last_review_date'],
            // 'approval_date' => ['nullable', 'date'],
            'status' => ['nullable', 'exists:document_statuses,id'],
            // 'reviewer' => ['nullable', 'exists:users,id'],
            // 'privacy' => ['nullable', 'exists:privacies,id'],
            'file' => ['required', 'file'],
        ];

        // [1 => Draft],[2=> InReview, [3 => Approved]
        if ($request->status == 2) {
            $rules['reviewer'] = ['required', 'exists:users,id'];
        } else {
            $rules['reviewer'] = ['nullable', 'exists:users,id'];
        }

        if ($request->status == 3) {
            $rules['privacy'] = ['required', 'exists:privacies,id'];
            $rules['approval_date'] = ['required', 'date', 'after_or_equal:creation_date'];
        } else {
            $rules['privacy'] = ['nullable', 'exists:privacies,id'];
            $rules['approval_date'] = ['nullable', 'date'];
        }

        // Validation rules
        $validator = Validator::make($request->all(), $rules);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('governance.ThereWasAProblemAddingTheDocument') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();

            $owner = null;
            if (auth()->user()->role_id == 1) { // current user is administrator
                $owner = $request->owner ?? auth()->id();
            } else {
                $owner = auth()->id();
            }

            $document = null;
            try {
                $document = Document::create([
                    'document_name' => $request->name,
                    'framework_ids' => implode(',', $request->framework_ids ?? []),
                    'control_ids' => implode(',', $request->control_ids ?? []),
                    'additional_stakeholders' => implode(',', $request->additional_stakeholders ?? []),
                    'team_ids' => implode(',', $request->team_ids ?? []),
                    'document_owner' => $owner,
                    'document_reviewer' => $request->reviewer,
                    'creation_date' => date('Y-m-d', strtotime($request->creation_date)),
                    'last_review_date' => date('Y-m-d', strtotime($request->last_review_date)),
                    'review_frequency' => $request->review_frequency,
                    'next_review_date' => date('Y-m-d', strtotime($request->last_review_date) + $request->review_frequency * 24 * 60 * 60),
                    'approval_date' => $request->approval_date,
                    'document_type' => $request->category_id,
                    'document_status' => $request->status ?? 1,
                    'privacy' => $request->privacy,
                    'created_by' => auth()->id()
                ]);


                if ($request->hasFile('file')) {
                    $fileId = null;
                    /////////////////
                    if ($request->file('file')->isValid()) {
                        $path = $request->file('file')->store('docs/' . $document->id);
                        $fileId = File::create([
                            'name' => $request->file('file')->getClientOriginalName(),
                            'unique_name' => $path
                        ]);
                    } else {
                        Storage::deleteDirectory('docs/' . $document->id);
                        $response = array(
                            'status' => false,
                            'errors' => ['file' => ['There were problems uploading the files']],
                            'message' => __('governance.ThereWasAProblemAddingTheDocument') . "<br>" . __('locale.Validation error'),
                        );
                    }

                    $document->update([
                        'file_id' => $fileId->id
                    ]);
                }
                // $controlsIds = $request->control_ids ?? [];
                // foreach ($controlsIds as $controlId) {

                //     $lastControlOpenAudit = FrameworkControlTestAudit::where('framework_control_id', $controlId)
                //         ->where(function ($query) {
                //             $query->where('status', '!=', 2)
                //                 ->orWhereNull('status');
                //         })
                //         ->latest()
                //         ->first();
                //     if ($lastControlOpenAudit) {
                //         ControlAuditPolicy::create([
                //             'document_id' => $document->id,
                //             'framework_control_test_audit_id' => $lastControlOpenAudit->id
                //         ]);
                //     }
                // }

                DB::commit();
                event(new DocumentCreated($document));
                $message = __('locale.New Document Created With Name') . ' "' . $document->document_name .   __('locale.CreatedBy') . ' "' . auth()->user()->name . '".';
                write_log($document->id, auth()->id(), $message, 'Creating Document');

                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('governance.DocumentWasAddedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                Storage::deleteDirectory('docs/' . ($document->id ?? ''));
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                    'message' => $th->getMessage(),
                );
                return response()->json($response, 502);
            }
        }
    }

    /**
     * Update the specified resource (documnets) in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateDocument(Request $request)
    {
        $document = Document::find($request->id);
        if ($document) {
            $rules = [
                'name' => ['required', 'max:255'],
                'framework_ids' => ['nullable', 'array'],
                'framework_ids.*' => ['exists:frameworks,id'],
                'control_ids' => ['nullable', 'array'],
                'control_ids.*' => ['exists:framework_controls,id'],
                'additional_stakeholders' => ['nullable', 'array'],
                'additional_stakeholders.*' => ['exists:users,id'],
                'owner' => ['nullable', 'exists:users,id'],
                'team_ids' => ['nullable', 'array'],
                'team_ids.*' => ['exists:teams,id'],
                // 'creation_date' => ['nullable', 'date'],
                'last_review_date' => ['required', 'date', 'after_or_equal:creation_date'],
                'review_frequency' => ['required', 'integer'],
                // 'next_review_date' => ['nullable', 'date', 'after:last_review_date'],
                // 'approval_date' => ['nullable', 'date'],
                // 'status' => ['nullable', 'exists:document_statuses,id'],
                'reviewer' => ['nullable', 'exists:users,id'],
                // 'privacy' => ['nullable', 'exists:privacies,id'],
                'file' => ['nullable', 'file'],
            ];

            // [1 => Draft],[2=> InReview, [3 => Approved]
            if ($request->status == 2) {
                $rules['reviewer'] = ['required', 'exists:users,id'];
            } else {
                $rules['reviewer'] = ['nullable', 'exists:users,id'];
            }

            if ($request->status == 3) {
                $rules['privacy'] = ['required', 'exists:privacies,id'];
                $rules['approval_date'] = ['required', 'date', 'after_or_equal:creation_date'];
            } else {
                $rules['privacy'] = ['nullable', 'exists:privacies,id'];
                $rules['approval_date'] = ['nullable', 'date'];
            }
            // Validation rules
            $validator = Validator::make($request->all(), $rules);

            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('governance.ThereWasAProblemUpdatingTheDocument') . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();
                $uploadfilePath = null;
                try {

                    $owner = null;
                    if (auth()->user()->role_id == 1) { // current user is administrator
                        $owner = $request->owner ?? auth()->id();
                    } else {
                        $owner = auth()->id();
                    }

                    // Start updating document data
                    $document->update([
                        // 'document_type' => $request->title,
                        'privacy' => $request->privacy,
                        'document_name' => $request->name,
                        // 'parent' => $request->parent,
                        'document_status' => $request->status ?? 1,
                        // 'file_id' => $request->title,
                        // // 'creation_date' => $request->creation_date,
                        'last_review_date' => date('Y-m-d', strtotime($request->last_review_date)),
                        'review_frequency' => $request->review_frequency,
                        'next_review_date' => date('Y-m-d', strtotime($request->last_review_date) + $request->review_frequency * 24 * 60 * 60),
                        'approval_date' => $request->approval_date,
                        'control_ids' => implode(',', $request->control_ids ?? []),
                        'framework_ids' => implode(',', $request->framework_ids ?? []),
                        'document_owner' => $owner,
                        'document_reviewer' => $request->reviewer,
                        'additional_stakeholders' => implode(',', $request->additional_stakeholders ?? []),
                        // // 'approver' => $request->title,
                        'team_ids' => implode(',', $request->team_ids ?? []),
                    ]);

                    // File upload Start
                    if ($request->hasFile('file')) {
                        if ($request->file('file')->isValid()) {
                            // Get the original file name and extension
                            $originalName = $request->file('file')->getClientOriginalName();
                            $extension = $request->file('file')->getClientOriginalExtension();
                    
                            // Store the file with the correct extension
                            $path = $request->file('file')->storeAs('docs/' . $document->id, $originalName);
                    
                            // Create a file record
                            $file = File::create([
                                'name' => $originalName,
                                'unique_name' => $path
                            ]);
                    
                            $uploadfilePath = $path;
                    
                            // Delete old file if exists
                            $oldFile = File::find($document->file_id);
                            if ($oldFile) {
                                Storage::delete($oldFile->unique_name);
                                $oldFile->delete();
                            }
                    
                            // Update the document with the new file ID
                            $document->update([
                                'file_id' => $file->id,
                            ]);
                        } else {
                            DB::rollBack();
                            if (isset($uploadfilePath)) {
                                Storage::delete($uploadfilePath);
                            }
                    
                            $response = array(
                                'status' => false,
                                'errors' => ['file' => ['There were problems uploading the files']],
                                'message' => __('governance.ThereWasAProblemUpdatingTheDocument') . "<br>" . __('locale.Validation error'),
                            );
                    
                            return response()->json($response, 422);
                        }
                    }
                    
                    // File upload End

                    // End updating task data

                    DB::commit();
                    event(new DocumentUpdated($document));
                    $message = __('locale.A Document With Name') . ' "' . $document->document_name .   __('locale.UpdatedBy') . ' "' . auth()->user()->name . '".';
                    write_log($document->id, auth()->id(), $message, 'Updating Document');
                    $response = array(
                        'status' => true,
                        'reload' => true,
                        'message' => __('governance.TaskWasUpdatedSuccessfully'),
                    );
                    return response()->json($response, 200);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    Storage::delete($uploadfilePath);
                    $response = array(
                        'status' => false,
                        'errors' => [],
                        // 'message' => $th->getMessage()
                        'message' => __('locale.Error'),
                    );
                    return response()->json($response, 502);
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

    public function download(Request $request, $id)
    {
        $file = Document::where('id', $id)->first()->file ?? null;
        if ($file) {
            $pathToFile = storage_path('app/docs/' . $file->name);
            return Response::download($pathToFile);
        } else {
            return redirect()->route('admin.governance.category');
        }
    }

    public function ajaxGetListDocument(Request $request, $id)
    {
        $currentUserId = auth()->id();
        $_documents = Document::where('document_type', $id)->get();

        $statuses = [];
        $statuses[1] = "Draft";
        $statuses[2] = "InReview";
        $statuses[3] = "Approved";

        // Filter if current user is adminstator, owner, creator or has ability to view document depending on document status and privacy
        $filteredDocuments = $_documents->filter(function ($document) use ($currentUserId) {
            return (auth()->user()->role_id == 1) || ($currentUserId == $document->document_owner) || ($currentUserId == $document->created_by) || $this->getUserHaveAbilityToViewDocument($document, $currentUserId);
        })->values();

        $documents = $filteredDocuments->map(function ($document) use ($currentUserId, $statuses) {
            return (object)[
                'id' => $document->id,
                'responsive_id' => $document->id,
                'document_name' => $document->document_name,
                // 'framework_ids' => $document->framework_ids,
                'framework_name' => Framework::whereIn('id', explode(',', $document->framework_ids))->pluck('name'),
                // 'control_ids' => $document->control_ids,
                'control' => FrameworkControl::whereIn('id', explode(',', $document->control_ids))->pluck('short_name'),
                'creation_date' => $document->creation_date,
                'approval_date' => $document->approval_date,
                'status' => $statuses[$document->document_status],
                'deletable' => ($currentUserId == $document->document_owner) ? true : false,
                'editable' => ($currentUserId == $document->document_owner) ? true : false,
            ];
        });

        return response()->json($documents, 200);
    }

    public function editDocument(Request $request, $id)
    {
        $document = Document::find($id);
        if (($document->document_owner != auth()->id()) && (auth()->user()->role_id != 1)) {
            $response = array(
                'status' => false,
                'message' => __('locale.YouDonotHavePermissionToDoThat'),
            );
            return response()->json($response, 401);
        }

        if ($document) {
            $data['id'] = $document->id;
            $data['document_type'] = $document->document_type;
            $data['privacy'] = $document->privacy;
            $data['document_name'] = $document->document_name;
            $data['parent'] = $document->parent;
            $data['document_status'] = $document->document_status;
            $data['document_status_name'] = $document->documentStatus->name ?? '';
            $data['file_id'] = $document->file_id;
            $data['creation_date'] = $document->creation_date;
            $data['last_review_date'] = $document->last_review_date;
            $data['review_frequency'] = $document->review_frequency;
            $data['next_review_date'] = $document->next_review_date;
            $data['approval_date'] = $document->approval_date;
            // $data['control_ids'] = $document->control_ids;
            $data['control_ids'] = ($document->control_ids) ? explode(',', $document->control_ids) : [];
            // $data['framework_ids'] = $document->framework_ids;
            $data['framework_ids'] = ($document->framework_ids) ? explode(',', $document->framework_ids) : [];
            // $data['frameworks'] = $document->Frameworks;
            $data['document_owner'] = $document->document_owner;
            // $data['owner'] = $document->owner;
            $data['document_reviewer'] = $document->document_reviewer;
            // $data['additional_stakeholders'] = $document->additional_stakeholders;
            $data['additional_stakeholders'] = ($document->additional_stakeholders) ? explode(',', $document->additional_stakeholders) : [];
            $data['approver'] = $document->approver;
            // $data['team_ids'] = $document->team_ids;
            $data['team_ids'] = ($document->team_ids) ? explode(',', $document->team_ids) : [];
            $notes = $document->notes->map(function ($note) {
                return [
                    'type' => 't',
                    'note' => $note->note,
                    'user_id' => $note->user_id,
                    'user_name' => $note->user->name,
                    'custom_user_name' => getFirstChartacterOfEachWord($note->user->name, 2),
                    'created_at' => $note->created_at->format('Y-m-d H:i:s'),
                ];
            });

            $noteFiles = $document->note_files->map(function ($noteFile) {
                return [
                    'type' => 'f',
                    'id' => $noteFile->id,
                    'user_id' => $noteFile->user_id,
                    'note' => $noteFile->display_name,
                    'user_name' => $noteFile->user->name,
                    'custom_user_name' => getFirstChartacterOfEachWord($noteFile->user->name, 2),
                    'created_at' => $noteFile->created_at->format('Y-m-d H:i:s'),
                ];
            });
            $data['notes'] = new Collection();

            if ($notes->count()) {
                $data['notes'] = $notes;
            } else if ($noteFiles->count()) {
                if ($data['notes']->count())
                    $data['notes'] = $data['notes']->merge($noteFiles);
                else
                    $data['notes'] = $noteFiles;
            }

            // $data['notes'] = $data['notes']->merge($noteFiles)->sortBy('created_at')->values()->all();
            $data['notes'] = $data['notes']->merge($noteFiles)->sortBy('created_at')->values()->all();
            unset($noteFiles);

            $response = array(
                'status' => true,
                // 'data' => $data,
                'data' => mb_convert_encoding($data, "UTF-8", "auto")
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

    public function showDocument(Request $request, $id)
    {
        $document = Document::find($id);

        if ($document) {
            $data['id'] = $document->id;
            $data['document_type'] = $document->document_type;
            $data['privacy'] = $document->privacy;
            $data['document_name'] = $document->document_name;
            $data['parent'] = $document->parent;
            $data['document_status'] = $document->document_status;
            $data['document_status_name'] = $document->documentStatus->name ?? '';
            $data['file_id'] = $document->file_id;
            $data['creation_date'] = $document->creation_date;
            $data['last_review_date'] = $document->last_review_date;
            $data['review_frequency'] = $document->review_frequency;
            $data['next_review_date'] = $document->next_review_date;
            $data['approval_date'] = $document->approval_date;
            $data['controls'] = FrameworkControl::whereIn('id', ($document->control_ids) ? explode(',', $document->control_ids) : [])->pluck('short_name')->toArray();
            $data['frameworks'] = Framework::whereIn('id', ($document->framework_ids) ? explode(',', $document->framework_ids) : [])->pluck('name')->toArray();
            $data['additional_stakeholders'] = User::whereIn('id', ($document->additional_stakeholders) ? explode(',', $document->additional_stakeholders) : [])->pluck('name')->toArray();
            $data['document_owner'] = User::where('id', $document->document_owner)->pluck('name')->first();
            $data['teams'] = Team::whereIn('id', ($document->team_ids) ? explode(',', $document->team_ids) : [])->pluck('name')->toArray();
            $data['document_reviewer'] = User::where('id', $document->document_reviewer)->pluck('name')->first() ?? '';


            // $data['owner'] = $document->owner;
            // $data['additional_stakeholders'] = $document->additional_stakeholders;
            $data['approver'] = $document->approver;
            // $data['team_ids'] = $document->team_ids;
            $notes = $document->notes->map(function ($note) {
                return [
                    'type' => 't',
                    'note' => $note->note,
                    'user_id' => $note->user_id,
                    'user_name' => $note->user->name,
                    'custom_user_name' => getFirstChartacterOfEachWord($note->user->name, 2),
                    'created_at' => $note->created_at->format('Y-m-d H:i:s'),
                ];
            });

            $noteFiles = $document->note_files->map(function ($noteFile) {
                return [
                    'type' => 'f',
                    'id' => $noteFile->id,
                    'user_id' => $noteFile->user_id,
                    'note' => $noteFile->display_name,
                    'user_name' => $noteFile->user->name,
                    'custom_user_name' => getFirstChartacterOfEachWord($noteFile->user->name, 2),
                    'created_at' => $noteFile->created_at->format('Y-m-d H:i:s'),
                ];
            });
            $data['notes'] = new Collection();

            if ($notes->count()) {
                $data['notes'] = $notes;
            } else if ($noteFiles->count()) {
                if ($data['notes']->count())
                    $data['notes'] = $data['notes']->merge($noteFiles);
                else
                    $data['notes'] = $noteFiles;
            }

            // $data['notes'] = $data['notes']->merge($noteFiles)->sortBy('created_at')->values()->all();
            $data['notes'] = $data['notes']->merge($noteFiles)->sortBy('created_at')->values()->all();
            unset($noteFiles);

            $response = array(
                'status' => true,
                // 'data' => $data,
                'data' => mb_convert_encoding($data, "UTF-8", "auto")
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

    public function destroyDocument($id)
    {
        $document = Document::find($id);

        if (($document->document_owner != auth()->id()) && (auth()->user()->role_id != 1)) {
            $response = array(
                'status' => false,
                'message' => __('locale.YouDonotHavePermissionToDoThat'),
            );
            return response()->json($response, 401);
        }

        if ($document) {
            DB::beginTransaction();

            $document_id = $document->id;
            try {
                // Check for related data
                $relatedData = $document->hasRelations();

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
                // Remove file
                $oldFile = File::find($document->file_id);

                if ($oldFile) {
                    $oldFile->delete();
                }

                // Remove the document
                $document->delete(); // documents

                Storage::deleteDirectory('docs/' . $document_id);
                DB::commit();
                event(new DocumentDeleted($document));

                $message = __('locale.A Document With Name') . ' "' . $document->document_name .   __('locale.DeletedBy') . ' "' . auth()->user()->name . '".';
                write_log($document->id, auth()->id(), $message, 'Deleting Document');
                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('governance.DocumentWasDeletedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                if ($th->errorInfo[0] == 23000) {
                    $errorMessage = __('governance.ThereWasAProblemDeletingTheDocument') . "<br>" . __('locale.CannotDeleteRecordRelationError');
                } else {
                    $errorMessage = __('governance.ThereWasAProblemDeletingTheDocument');
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

    public function ajaxGetListFrameControl($ids)
    {
        $var = explode(",", $ids);

        $var2 = implode(" OR   framework_id =", $var);

        $controls = DB::select("select  DISTINCT  framework_controls.id , short_name from framework_control_mappings , framework_controls where  framework_control_mappings.framework_control_id = framework_controls.id  and (framework_id =  $var2)   ");


        $html = "";
        if (!empty($controls)) {

            $html .= '<option value="" > select controls </option>';

            foreach ($controls as $control) {
                $html .= '<option value="' . $control->id . '"> ' . $control->short_name . ' </option>';
            }
        } else {
            $html .= '<option selected value=""> no controls </option>';
        }

        // var_dump( $id );


        echo $html;
    }

    public function ajaxAddNextReviewToFrequency($test_frequency, $last_date = null)
    {
        $next_date = date('Y-m-d', strtotime($last_date) + ($test_frequency ?? 0) * 24 * 60 * 60);

        return $next_date;
    }

    //note
    public function send_note(Request $request)
    {
        $rules = [
            'document_id' => ['required', 'exists:documents,id'],
            'note' => ['required', 'string'],
        ];

        // Validation rules
        $validator = Validator::make($request->all(), $rules);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('governance.ThereWasAProblemAddingTheDocumentNote') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {

            DB::beginTransaction();
            try {
                $note = DocumentNote::create([
                    'user_id' => auth()->id(),
                    'document_id' => $request->document_id,
                    'note' => $request->note,
                ]);

                $note = DocumentNote::find($note->id);

                DB::commit();

                $response = array(
                    'status' => true,
                    'message' => __('governance.DocumentNoteWasAddedSuccessfully'),
                    'data' => [
                        'note' => $note,
                        'document' => $note->document
                    ],
                    'reload' => false,
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    // 'message' => $th->getMessage(),
                    'message' => __('governance.ThereAreUnexpectedProblems')
                );
                return response()->json($response, 502);
            }
        }
    }

    public function send_note_file(Request $request)
    {
        $rules = [
            'note_file' => ['file'],
            'document_id' => ['required', 'exists:documents,id'],
        ];

        // Validation rules
        $validator = Validator::make($request->all(), $rules);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('governance.ThereWasAProblemAddingTheDocumentNote') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {

            DB::beginTransaction();
            try {

                $fileName = '';
                $path = '';
                // File upload Start
                if ($request->hasFile('note_file')) {
                    $note_file = $request->file('note_file');
                    $path = '';
                    if ($note_file->isValid()) {
                        $path = $note_file->store('document/' . $request->document_id . '/notes');
                        $fileName = pathinfo($note_file->getClientOriginalName(), PATHINFO_FILENAME);
                        $fileName .= pathinfo($path, PATHINFO_EXTENSION) ? '.' . pathinfo($path, PATHINFO_EXTENSION) : '';
                    } else {
                        if ($path)
                            Storage::delete($path);
                        $response = array(
                            'status' => false,
                            'errors' => ['note_file' => ['There were problems uploading the files']],
                            'message' => __('governance.ThereWasAProblemAddingTheDocumentNote') . "<br>" . __('locale.Validation error'),
                        );

                        return response()->json($response, 422);
                    }
                }

                $documentFile = DocumentNoteFile::create([
                    'user_id' => auth()->id(),
                    'document_id' => $request->document_id,
                    'display_name' => $fileName,
                    'unique_name' => $path
                ]);
                // File upload End

                DB::commit();
                $documentFile = DocumentNoteFile::find($documentFile->id);

                $response = array(
                    'status' => true,
                    'message' => __('governance.DocumentNoteWasAddedSuccessfully'),
                    'data' => [
                        'note' => $documentFile,
                        'document' => $documentFile->document
                    ],
                    'reload' => false,
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();
                if ($path)
                    Storage::delete($path);
                $response = array(
                    'status' => false,
                    'errors' => [],
                    // 'message' => $th->getMessage(),
                    'message' => __('locale.ThereAreUnexpectedProblems')
                );
                return response()->json($response, 502);
            }
        }
    }

    public function downloadNoteFile(Request $request)
    {
        $file = Document::where('id', $request->document_id)->first()->note_files()->where('id', $request->id)->first() ?? null;
        $exists = Storage::disk('local')->exists($file->unique_name);
        if ($file && $exists) {
            return Storage::download($file->unique_name, $file->display_name);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Download the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function downloadFile(Request $request)
    {
        $file = Document::where('id', $request->document_id)->first()->file ?? null;
        $exists = Storage::disk('local')->exists($file->unique_name ?? '');

        if ($file && $exists) {
            return Storage::download($file->unique_name, $file->name);
        } else {
            return redirect()->route('admin.governance.category');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function copy(Request $request, $id)
    {
        $framework = Framework::find($request->id);

        if ($framework) {
            $rules = [
                'name' => ['required', 'max:255', 'unique:frameworks,name'],
                'description' => ['required', 'string'],
                'icon' => ['required', 'string'],
            ];

            // Validation rules
            $validator = Validator::make($request->all(), $rules);

            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('governance.ThereWasAProblemCopyingTheFrameworkControl') . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();

                try {
                    // Start coping framework data
                    $copyedFramework = Framework::create([
                        "name" => $request->name,
                        "description" => $request->description,
                        "icon" => $request->icon
                    ]);

                    $copyedControlData = [
                        "short_name" => null,
                        "long_name" => null,
                        "description" => null,
                        "control_number" => null,
                        "family" => null,
                        "parent_id" => null
                    ];
                    $copyedControlTestName = null;

                    // Get framework controls that doesn't have parent with framework control test
                    $onlyNotChildControls = $framework->FrameworkControls()->doesntHave('parentFrameworkControl')->with('FrameworkControlTest:framework_control_id,name')->get();
                    foreach ($onlyNotChildControls as $onlyNotChildControl) {

                        $copyedControlData["short_name"] = $onlyNotChildControl->short_name;
                        $copyedControlData["long_name"] = $onlyNotChildControl->long_name;
                        $copyedControlData["description"] = $onlyNotChildControl->description;
                        $copyedControlData["control_number"] = $onlyNotChildControl->control_number;
                        $copyedControlData["family"] = $onlyNotChildControl->family;
                        $copyedControlData["parent_id"] = null;
                        $copyedControlTestName = $onlyNotChildControl->FrameworkControlTest->name;
                        $controlId = $this->copyControl($copyedControlData, $copyedControlTestName, $copyedFramework->id);

                        // Reset templte control data
                        $this->resetControl($copyedControlData, $copyedControlTestName);

                        // Set parent for all children
                        $copyedControlData["parent_id"] = $controlId;

                        // Store children of control
                        foreach ($onlyNotChildControl->frameworkControls()->with('FrameworkControlTest:framework_control_id,name')->get() as $childrenFrameworkControl) {
                            $copyedControlData["short_name"] = $childrenFrameworkControl->short_name;
                            $copyedControlData["long_name"] = $childrenFrameworkControl->long_name;
                            $copyedControlData["description"] = $childrenFrameworkControl->description;
                            $copyedControlData["control_number"] = $childrenFrameworkControl->control_number;
                            $copyedControlData["family"] = $childrenFrameworkControl->family;
                            $copyedControlTestName = $childrenFrameworkControl->FrameworkControlTest->name;
                            $this->copyControl($copyedControlData, $copyedControlTestName, $copyedFramework->id);
                        }
                    }
                    // End coping framework data

                    DB::commit();

                    $response = array(
                        'status' => true,
                        'reload' => true,
                        'message' => __('governance.FrameworkControlWasCopyedSuccessfully'),
                    );
                    return response()->json($response, 200);
                } catch (\Throwable $th) {
                    DB::rollBack();

                    $response = array(
                        'status' => false,
                        'errors' => [],
                        'message' => $th->getMessage()
                        //            'message' => __('locale.Error'),
                    );
                    return response()->json($response, 502);
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
     * Copy the specified resource in storage.
     *
     * @param \Array $control
     * @param \String $test_name
     * @return \integer $contol_id
     */
    public function copyControl($control, $test_name, $framework_id)
    {
        //add in control
        $frameControl = new FrameworkControl();
        $frameControl->short_name = $control['short_name'];
        $frameControl->long_name = $control['long_name'];
        $frameControl->description = $control['description'];
        $frameControl->control_number = $control['control_number'];
        $frameControl->family = $control['family'];
        $frameControl->parent_id = $control['parent_id'];

        if (($control['owner'] ?? null) != "") {
            $frameControl->control_owner = $control['owner'];
        } else {
            $frameControl->control_owner = auth()->user()->id;
        }

        $frameControl->save();
        //add in mapp

        $control_id = DB::getPdo()->lastInsertId();
        $frame_map = new FrameworkControlMapping();
        $frame_map->framework_control_id = $control_id;
        $frame_map->framework_id = $framework_id;
        $frame_map->save();
        $control['last_date'] = $control['last_date'] ?? date('Y-m-d');

        //add test*
        // calc  next_date form last date * test_frequency
        $next_date = date('Y-m-d', strtotime($control['last_date']) + ($control['test_frequency'] ?? 0) * 24 * 60 * 60);
        // add new test to database
        $frameworkControlTest = FrameworkControlTest::create([
            'tester' => $control['tester'] ?? null,
            'last_date' => $control['last_date'],
            'next_date' => $next_date,
            'name' => $test_name,
            'test_steps' => $control['test_steps'] ?? null,
            'approximate_time' => $control['approximate_time'] ?? null,
            'framework_control_id' => $control_id,
            'expected_results' => $control['expected_results'] ?? null,
            'test_frequency' => $control['test_frequency'] ?? 0,
            // 'additional_stakeholders' =>implode(",", $control['additional_stakeholders']),
        ]);

        $test_id = DB::getPdo()->lastInsertId();

        $audit = FrameworkControlTestAudit::create([
            'test_id' => $test_id,
            'tester' => $control['tester'] ?? null,
            'name' => $test_name . "(1)",
            'framework_control_id' => $control_id,
            'last_date' => $control['last_date'],
            'next_date' => $next_date,
            'test_frequency' => $control['test_frequency'] ?? 0,
        ]);

        FrameworkControlTestResult::create([
            'test_audit_id' => $audit->id
        ]);

        return $control_id;
    }

    public function resetControl(&$control, &$testName)
    {
        foreach ($control as $key => $value) {
            $control[$key] = null;
        }
        $testName = null;
    }

    protected function getUserHaveAbilityToViewDocument($document, $currentUserId)
    {
        // [1 => Draft],[2=> InReview, [3 => Approved]
        if ($document->document_status == 3 /*Approved*/ && $document->privacy == 2 /*public*/) {
            return true;
        } else if (($document->document_status == 2 /*InReview*/) || ($document->document_status == 3 /*Approved*/ && $document->privacy == 1 /*private*/)) {
            if (
                $currentUserId == $document->document_reviewer // current user is reviewer
            ) {
                return true;
            }

            // Get users from stockholders
            $additionalStakeholders = explode(',', $document->additional_stakeholders);

            if (in_array($currentUserId, $additionalStakeholders)) {
                return true;
            }
            unset($additionalStakeholders);

            // Get users from team
            $usersInTeams = [];
            $teams = Team::with('users:id')->whereIn('id', explode(',', $document->team_ids))->get();
            foreach ($teams as $team) {
                foreach ($team->users as $user) {
                    array_push($usersInTeams, $user->id);
                }
            }
            unset($teams);
            if (in_array($currentUserId, $usersInTeams)) {
                return true;
            }

            return false;
        }
    }

    public function getControlObjectives($id)
    {
        $control = FrameworkControl::with('objectives')->where('id', $id)->with('FrameworkControlTest')->first();
        $allObjectives = $control->objectives;
        $loggedUserId = auth()->id();
        $objectives = [];
        foreach ($allObjectives as &$objective) {
            $objectiveRemoved = false;
            if ($objective->pivot->responsible_type == 'team') {
                $responsible = Team::where('id', $objective->pivot->responsible_team_id)->first(['id', 'name']);
                $loggedUser = User::with('teams')->find($loggedUserId);
                $loggedUserTeams = $loggedUser->teams->pluck('id')->toArray();
                if (in_array($objective->pivot->responsible_team_id, $loggedUserTeams)) {
                    $objective->canAddEvidence = true;
                } else {
                    if (!auth()->user()->hasPermission('control.all')) {
                        if ($control->control_owner != $loggedUserId && $control->FrameworkControlTest->tester != $loggedUserId) {
                            $objectiveRemoved = true;
                        }
                    }
                }
            } else {
                $responsible = User::where('id', $objective->pivot->responsible_id)->first(['id', 'name']);
                if ($objective->pivot->responsible_id == $loggedUserId) {
                    $objective->canAddEvidence = true;
                    if ($objective->pivot->responsible_type == 'manager') {
                        $objective->manager = true;
                    }
                } else {
                    if (!auth()->user()->hasPermission('control.all')) {
                        if ($control->control_owner != $loggedUserId && $control->FrameworkControlTest->tester != $loggedUserId) {
                            $objectiveRemoved = true;
                        }
                        if (isDepartmentManager()) {
                            $departmentId = (Department::where('manager_id', auth()->id())->first())->id;
                            $departmentMembersids = User::where('department_id', $departmentId)->orWhere('id', auth()->id())->pluck('id')->toArray();
                            if (in_array($objective->pivot->responsible_id, $departmentMembersids)) {
                                $objectiveRemoved = false;
                            }
                        }
                    }
                }
            }

            if ($responsible) {
                $objective->responsible = $responsible->name;
            } else {
                $objective->responsible = 'Unset Yet';
            }
            $objective->due_date = $objective->pivot->due_date;

            if (!$objectiveRemoved) {
                $objectives[] = $objective;
            }
        }
        // dd($objectives);
        return [
            'control' => $control,
            'objectives' => $objectives
        ];
    }

    public function getAllObjectives($id)
    {
        $objectives =  ControlObjective::all();
        $control = FrameworkControl::with('objectives')->where('id', $id)->first();
        $controlObjectivesIds = $control->objectives->pluck('id')->toArray();
        // dd($controlObjectivesIds);
        if (!empty($controlObjectivesIds)) {
            $objectives->each(function (&$objective) use ($controlObjectivesIds) {
                $objective->disabled = in_array($objective->id, $controlObjectivesIds);
            });
        }
        $managersIds = Department::with('manager:id,name')->whereNotNull('manager_id')->get()->pluck('manager')->pluck('id')->toArray();
        $users = User::whereNotIn('id', $managersIds)->get(['id', 'name']);
        return [
            'objectives' => $objectives,
            'users' => $users
        ];
    }

    public function getResponsibles(Request $request)
    {
        $managers = Department::with('manager:id,name')->whereNotNull('manager_id')->get()->pluck('manager');
        if ($request->responsible_type == 'user') {
            $managersIds = $managers->pluck('id')->toArray();
            $responsibles = User::whereNotIn('id', $managersIds)->get(['id', 'name']);
        } elseif ($request->responsible_type == 'manager') {
            $responsibles = $managers;
        } elseif ($request->responsible_type == 'team') {
            $responsibles = Team::all();
        }
        return $responsibles;
    }

    public function getDepartmentMembers($controlControlObjectiveId)
    {
        $managerId = (ControlControlObjective::find($controlControlObjectiveId))->responsible_id;
        $departmentId = (Department::where('manager_id', $managerId)->first())->id;
        return User::where('department_id', $departmentId)->where('id', '!=', $managerId)->get();
    }

    public function editObjective($controlControlObjectiveId)
    {
        $objective = ControlControlObjective::find($controlControlObjectiveId);
        $managers = Department::with('manager:id,name')->whereNotNull('manager_id')->get()->pluck('manager');
        if ($objective->responsible_type == 'user' || $objective->responsible_type === null) {
            $managersIds = $managers->pluck('id')->toArray();
            $responsibles = User::whereNotIn('id', $managersIds)->get(['id', 'name']);
        } elseif ($objective->responsible_type == 'manager') {
            $responsibles = $managers;
        } elseif ($objective->responsible_type == 'team') {
            $responsibles = Team::all();
        }
        return [
            'objective' => $objective,
            'responsibles'  => $responsibles ?? null,
        ];
    }

    public function addObjectiveToControl(Request $request)
    {
        $FrameId = FrameworkControlMapping::where('framework_control_id', $request->control_id)
            ->latest()->first()->framework_id ?? null;
        $lastDate = AuditResponsible::where('framework_id', $FrameId)
            ->orderBy('id', 'desc')->first()->due_date ?? null;

        if ($request->objective_adding_type == 'new') {
            $rules = [
                'control_id' => ['required', 'exists:framework_controls,id'],
                'objective_name' => ['required', 'max:100', 'unique:control_objectives,name'],
                'objective_description' => ['required', 'max:500'],
                'due_date' => ['required', 'date_format:Y-m-d', function ($attribute, $value, $fail) use ($lastDate) {
                    if ($lastDate !== null && $value !== $lastDate) {
                        $fail(__('The due date must be equal to the last due date of the aduit: ') . $lastDate);
                    }
                }],
            ];
        } else {
            $rules = [
                'control_id' => ['required', 'exists:framework_controls,id'],
                'objective_id' => [
                    'required',
                    'exists:control_objectives,id',
                    Rule::unique('controls_control_objectives')->where(function ($query) use ($request) {
                        return $query->where('control_id', $request->control_id);
                    })
                ],
                'due_date' => ['required', 'date_format:Y-m-d', function ($attribute, $value, $fail) use ($lastDate) {
                    if ($lastDate !== null && $value !== $lastDate) {
                        $fail(__('The due date must be equal to the last due date of the aduit: ') . $lastDate);
                    }
                }],
            ];
        }

        if ($request->responsible_type == 'team') {
            $rules['responsible_id'] = ['nullable', 'exists:teams,id'];
        } else {
            $rules['responsible_id'] = ['nullable', 'exists:users,id'];
        }

        $customAttributes = [
            'control_id' => 'control',
            'objective_id' => 'objective',
            'responsible_id' => 'responsible'
        ];

        $validator = Validator::make($request->all(), $rules);
        $validator->setAttributeNames($customAttributes);


        // Check if there is any validation errors
        if ($validator->fails()) {
            $errorMessages = implode('<br>', $validator->errors()->all());
            $response = array(
                'status' => false,
                'message' =>   __('locale.Validation error') . "<br>" . $errorMessages,
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();

            try {
                if ($request->objective_adding_type == 'new') {
                    $objective = ControlObjective::create([
                        'name' => $request->objective_name,
                        'description' => $request->objective_description,
                    ]);
                    $objectiveId = $objective->id;
                } else {
                    $objectiveId = $request->objective_id;
                }

                if ($request->responsible_id) {
                    $responsibleType = $request->responsible_type;
                    if ($responsibleType == 'team') {
                        $resposibleId = null;
                        $responsibleTeamId = $request->responsible_id;
                    } else {
                        $resposibleId = $request->responsible_id;
                        $responsibleTeamId = null;
                    }
                } else {
                    $responsibleType = 'user';
                    $control = FrameworkControl::where('id', $request->control_id)->first(['control_owner']);
                    $resposibleId = $control->control_owner;
                    $responsibleTeamId = null;
                }



                // Start adding data
                $ControlControlObjective = ControlControlObjective::create([
                    "control_id" => $request->control_id,
                    "objective_id" => $objectiveId,
                    "responsible_type" => $responsibleType,
                    "responsible_id" => $resposibleId,
                    "responsible_team_id" => $responsibleTeamId,
                    'due_date' => $request->due_date
                ]); // End adding data

                $lastControlOpenAudit = FrameworkControlTestAudit::where('framework_control_id', $request->control_id)
                    ->where(function ($query) {
                        $query->where('status', '!=', 2)
                            ->orWhereNull('status');
                    })
                    ->latest()
                    ->first();

                // Store related objectives and evidences
                $objectivesIds = ControlControlObjective::where('control_id', $request->control_id)->pluck('id')->toArray(); // Get objectives related to control
                $lastDate = AuditResponsible::orderBy('id', 'desc')->first()->due_date ?? null;
                // update all requirment to make the due_date of it == to due date in the audti reponsible intiate
                if (!empty($objectivesIds) && $lastDate !== null) {
                    ControlControlObjective::whereIn('id', $objectivesIds)
                        ->update(['due_date' => $lastDate]);
                }
                if ($lastControlOpenAudit) {

                    ControlAuditObjective::create([
                        'control_control_objective_id' => $ControlControlObjective->id,
                        'framework_control_test_audit_id' => $lastControlOpenAudit->id
                    ]);
                    $objectiveName = ControlObjective::findOrFail($ControlControlObjective->objective_id)->name;
                    $message = "Objective with name " . $objectiveName . " added for Control.";
                    write_log($lastControlOpenAudit->id, auth()->id(), $message, 'audit');
                }
                $control = FrameworkControl::with('objectives')->where('id', $request->control_id)->first();

                DB::commit();
                event(new ControlObjectiveCreated($ControlControlObjective, $control));

                $objectives =  ($this->getControlObjectives($request->control_id))['objectives'];
                $newObjective = $ControlControlObjective->controlAuditObjectives1->first();
                // dd($newObjective);
                $response = array(
                    'status' => true,
                    'data'  => $objectives,
                    'newObjective' => $ControlControlObjective,
                    'newrelatedEvidenceObjective' => $newObjective,
                    'message' => __('governance.RequirementWasAddedToControlSuccessfully'),
                );
                $message = __('governance.A Control that name is') . ' "' . ($control->short_name ??  __('locale.[No Name]')) . '". '
                    . __('governance.Add Requirement to it') . ' "' . ($ControlControlObjective->objective->name ??  __('locale.[No Requirement Name]')) . '". '
                    . __('locale.CreatedBy') . ' "' . auth()->user()->name . '".';
                write_log($ControlControlObjective->id, auth()->id(), $message, 'Creating Requirement');
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                    // 'message' => $th->getMessage() . "\n" . 'Line: ' . $th->getLine() . "\n" . 'File: ' . $th->getFile()
                );
                return response()->json($response, 502);
            }
        }
    }

    public function updateObjective(Request $request)
    {

        $rules = [
            'control_control_objective_id' => ['required', 'exists:controls_control_objectives,id'],
            'edited_due_date' => ['required', 'date_format:Y-m-d'],
        ];

        if ($request->responsible_type == 'team') {
            $rules['responsible_id'] = ['nullable', 'exists:teams,id'];
        } else {
            $rules['responsible_id'] = ['nullable', 'exists:users,id'];
        }
        $customAttributes = [
            'control_control_objective_id' => 'control objective',
            'edited_responsible_id' => 'responsible',
            'edited_due_date'  => 'due date'
        ];


        $validator = Validator::make($request->all(), $rules);
        $validator->setAttributeNames($customAttributes);
        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('locale.ThereWasAProblemUpdatingTheRequirement') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();

            try {


                $controlControlObjective = ControlControlObjective::find($request->control_control_objective_id);
                $control = FrameworkControl::where('id', $controlControlObjective->control_id)->first();

                if ($request->edited_responsible_id) {
                    $responsibleType = $request->edited_responsible_type;
                    if ($responsibleType == 'team') {
                        $resposibleId = null;
                        $responsibleTeamId = $request->edited_responsible_id;
                    } else {
                        $resposibleId = $request->edited_responsible_id;
                        $responsibleTeamId = null;
                    }
                } else {
                    $responsibleType = 'user';
                    $resposibleId = $control->control_owner;
                    $responsibleTeamId = null;
                }
                // Start adding data
                $controlControlObjective->update([
                    "responsible_type" => $responsibleType,
                    "responsible_id" => $resposibleId,
                    "responsible_team_id" => $responsibleTeamId,
                    'due_date' => $request->edited_due_date
                ]); // End adding data

                event(new ControlObjectiveEditCreated($controlControlObjective));
                $message = __('governance.A Control that name is') . ' "' . ($control->short_name ??  __('locale.[No Name]')) . '". '
                    . __('governance.Update Requirement to it') . ' "' . ($controlControlObjective->objective->name ??  __('locale.[No Objective Name]')) . '". '
                    . __('locale.UpdatedBy') . ' "' . auth()->user()->name . '".';
                write_log($controlControlObjective->id, auth()->id(), $message, 'Updating requirement');
                DB::commit();
                $controlId = $controlControlObjective->control_id;
                $objectives =  ($this->getControlObjectives($controlId))['objectives'];


                $response = array(
                    'status' => true,
                    'data'  => $objectives,
                    'message' => __('governance.RequirementWasUpdatedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    // 'message' => __('locale.Error'),
                    'message' => $th->getMessage()
                );
                return response()->json($response, 502);
            }
        }
    }

    public function getControlGuide($controlId)
    {
        $control = FrameworkControl::where('id', $controlId)->first();
        $controlGuide =   $control->supplemental_guidance;
        return $controlGuide;
    }

    public function storeEvidence(Request $request)
    {
        $rules = [
            'control_control_objective_id' => ['required', 'exists:controls_control_objectives,id'],
            'evidence_description' => ['required', 'max:500'],
            'evidence_file' => ['nullable', 'file', 'max:5000'],
        ];

        $customAttributes = [
            'control_control_objective_id' => 'Control Objective',
        ];

        $validator = Validator::make($request->all(), $rules);
        $validator->setAttributeNames($customAttributes);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('governance.ThereWasAProblemAddingTheEvidence') . "<br>" . __('locale.Validation error'),
            );
            dd($response);

            return response()->json($response, 422);
        } else {
            try {
                DB::beginTransaction();



                if ($request->hasFile('evidence_file')) {
                    if ($request->file('evidence_file')->isValid()) {
                        $fileName = $request->file('evidence_file')->getClientOriginalName();
                        $fileUniqueName = $request->file('evidence_file')->store('evidences/' . $request->control_control_objective_id);
                    } else {
                        $fileName = null;
                        $fileUniqueName = null;
                        $response = array(
                            'status'  => false,
                            'errors'  => ['evidence_file' => ['There were problems uploading the files']],
                            'message' => __('governance.ThereWasAProblemAddingTheEvidence')
                                . "<br>" . __('locale.Validation error'),
                        );
                    }
                } else {
                    $fileName = null;
                    $fileUniqueName = null;
                }

                //Start adding data
                $controlControlObjective = ControlControlObjective::where('id', $request->control_control_objective_id)->with('control', 'objective')->first();
                $Evidence = Evidence::create([
                    "control_control_objective_id" => $request->control_control_objective_id,
                    "description"                  => $request->evidence_description,
                    "creator_id"                   => auth()->id(),
                    'file_name'                    => $fileName,
                    'file_unique_name'             => $fileUniqueName,
                ]);
                // End adding data

                $lastControlOpenAudit = FrameworkControlTestAudit::where('framework_control_id', $controlControlObjective->control_id)
                    ->where(function ($query) {
                        $query->where('status', '!=', 2)
                            ->orWhereNull('status');
                    })
                    ->latest()
                    ->first();

                if ($lastControlOpenAudit) {
                    ControlAuditEvidence::create([
                        'evidence_id' => $Evidence->id,
                        'framework_control_test_audit_id' => $lastControlOpenAudit->id
                    ]);
                    $objectiveName = ControlObjective::findOrFail($controlControlObjective->objective_id)->name;

                    $message = "Evidence with the description '" . $Evidence->description . "' has been added to the objective '" . $objectiveName . "' for the control.";
                    write_log($lastControlOpenAudit->id, auth()->id(), $message, 'audit');
                }

                DB::commit();
                event(new ControlEvidenceCreated($Evidence));

                $message = __('governance.AnEvidenceWithDescription') . ' "'
                    . ($Evidence->description ?? __('locale.[No Name]')) . '". '
                    . (isset($controlControlObjective->objective)
                        ? __('governance.HasBeenAddedToRequirement') . ' "' . $controlControlObjective->objective->name . '". '
                        : __('locale.[No Requirement Name]') . '. ')
                    . __('governance.OnControl') . ' "'
                    . ($controlControlObjective->control->short_name ?? __('locale.[No Control Name]')) . '". '
                    . __('locale.By') . ' "' . auth()->user()->name . '".';


                write_log($Evidence->id, auth()->id(), $message, 'adding evidence');
                $response = array(
                    'status' => true,
                    'message' => __('governance.EvidenceWasAddedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {

                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    // 'message' => __('locale.Error'),
                    'message' => $th->getMessage()
                );
                return response()->json($response, 502);
            }
        }
    }

    public function getEvidences($id)
    {
        $controlControlObjective = ControlControlObjective::with('evidences')->where('id', $id)->first();
        $controlName = $controlControlObjective->control->short_name;
        $objectiveName = $controlControlObjective->objective->name;
        $canEditEvidences = false;
        $loggedUserId = auth()->id();
        if ($controlControlObjective->responsible_type == 'team') {
            $loggedUser = User::with('teams')->find($loggedUserId);
            $loggedUserTeams = $loggedUser->teams->pluck('id')->toArray();
            if (in_array($controlControlObjective->responsible_team_id, $loggedUserTeams)) {
                $canEditEvidences = true;
            }
        } else {
            if ($controlControlObjective->responsible_id == $loggedUserId) {
                $canEditEvidences = true;
            }
        }

        $evidences = $controlControlObjective->evidences;
        foreach ($evidences as &$evidence) {
            $evidence->created_by =   $evidence->creator->name;
        }

        return [
            'control_name' => $controlName,
            'objective_name' => $objectiveName,
            'can_edit_evidences' => $canEditEvidences,
            'evidences' => $evidences
        ];
    }

    public function getEvidence($evidenceId)
    {
        $evidence = Evidence::where('id', $evidenceId)->first();
        $evidence->created_by =   $evidence->creator->name;
        return $evidence;
    }

    public function updateEvidence(Request $request)
    {
        $rules = [
            'evidence_id' => ['required', 'exists:evidences,id'],
            'edited_evidence_description' => ['required', 'max:500'],
            'edited_evidence_file' => ['nullable', 'file', 'max:5000'],
        ];
        $customAttributes = [
            'evidence_id' => 'Evidence',
        ];


        $validator = Validator::make($request->all(), $rules);
        $validator->setAttributeNames($customAttributes);
        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('governance.ThereWasAProblemUpdatingTheEvidence') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            try {
                DB::beginTransaction();

                $evidence = Evidence::where('id', $request->evidence_id)->first();
                $existingFileName = $evidence->file_name;
                $existingFileUniqueName = $evidence->file_unique_name;
                if ($request->hasFile('edited_evidence_file')) {
                    if ($request->file('edited_evidence_file')->isValid()) {
                        $fileName = $request->file('edited_evidence_file')->getClientOriginalName();
                        $fileUniqueName = $request->file('edited_evidence_file')->store('evidences/' . $evidence->control_control_objective_id);
                        if ($existingFileUniqueName) {
                            Storage::delete($existingFileUniqueName);
                        }
                    } else {
                        $fileName = $existingFileName;
                        $fileUniqueName = $existingFileUniqueName;
                        $response = array(
                            'status'  => false,
                            'errors'  => ['edited_evidence_file' => ['There were problems uploading the files']],
                            'message' => __('governance.ThereWasAProblemAddingTheEvidence')
                                . "<br>" . __('locale.Validation error'),
                        );
                    }
                } else {
                    $fileName = $existingFileName;
                    $fileUniqueName = $existingFileUniqueName;
                }
                //Start addin data
                $evidence->update([
                    "description"                  => $request->edited_evidence_description,
                    'file_name'                    => $fileName,
                    'file_unique_name'             => $fileUniqueName,
                ]);
                // End adding data
                DB::commit();
                event(new ControlEvidenceUpdated($evidence));
                $controlControlObjective = ControlControlObjective::where('id', $evidence->control_control_objective_id)->with('control', 'objective')->first();
                $message = __('governance.AnEvidenceWithDescription') . ' "' . ($evidence->description ??  __('locale.[No Name]')) . '". '
                    . __('governance.HasBeenUpdatedOnRequirement') . ' "' . ($controlControlObjective->objective->name ??  __('locale.[No Requirement Name]')) . '". '
                    . '". ' . __('governance.OnControl') . ' "' . ($controlControlObjective->control->short_name ??  __('locale.[No Control Name]'))  .  __('locale.By') . ' "' . auth()->user()->name . '".';
                write_log($evidence->id, auth()->id(), $message, 'adding evidence');
                $response = array(
                    'status' => true,
                    'message' => __('governance.EvidenceWasUpdatedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {

                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                    // 'message' => $th->getMessage()
                );
                return response()->json($response, 502);
            }
        }
    }

    public function downloadEvidenceFile($evidenceId)
    {
        try {
            $evidence = Evidence::where('id', $evidenceId)->first();
            $exists = Storage::disk('local')->exists($evidence->file_unique_name);
            if ($evidence->file_unique_name && $exists) {
                $filePath = storage_path('app/' . $evidence->file_unique_name);
                $fileName = $evidence->file_name;
                return response()->download($filePath, $fileName);
            } else {
                return response()->json([
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.ErrorFileNotFound'),
                ], 502);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'errors' => [],
                // 'message' => __('locale.Error'),
                'message' => $th->getMessage(),

            ], 502);
        }
    }

    //Start Objective Comment

    public function showObjectiveComments($controlControlObjectiveId)
    {
        $comments = ObjectiveComment::where('control_control_objective_id', $controlControlObjectiveId)->get();
        $comments = $comments->map(function ($comment) {
            return [
                'id' => $comment->id,
                'comment' => $comment->comment,
                'file_display_name' => $comment->file_display_name,
                'user_id' => $comment->user_id,
                'user_name' => $comment->user->name,
                'custom_user_name' => getFirstChartacterOfEachWord($comment->user->name, 2),
                'created_at' => $comment->created_at->format('Y-m-d H:i:s'),
            ];
        });
        $response = array(
            'status' => true,
            // 'data' => $data,
            'data' => $comments,
        );
        return response()->json($response, 200);
    }
    //comment
    public function sendObjectiveComment(Request $request)
    {
        $rules = [
            'control_control_objective_id' => ['required', 'exists:controls_control_objectives,id'],
            'comment' => ['nullable', 'string'],
            'comment_file' => ['nullable', 'file']
        ];

        // Validation rules
        $validator = Validator::make($request->all(), $rules);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('governance.ThereWasAProblemAddingTheComment') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {

            DB::beginTransaction();
            try {
                $fileName = '';
                $path = '';
                // File upload Start

                if ($request->hasFile('comment_file')) {
                    $comment_file = $request->file('comment_file');
                    $path = '';
                    if ($comment_file->isValid()) {
                        $path = $comment_file->store('/objectives_comments');
                        $fileName = pathinfo($comment_file->getClientOriginalName(), PATHINFO_FILENAME);
                        $fileName .= pathinfo($path, PATHINFO_EXTENSION) ? '.' . pathinfo($path, PATHINFO_EXTENSION) : '';
                    } else {
                        if ($path)
                            Storage::delete($path);
                        $response = array(
                            'status' => false,
                            'errors' => ['comment_file' => ['There were problems uploading the files']],
                            'message' => __('governance.ThereWasAProblemAddingTheComment') . "<br>" . __('locale.Validation error'),
                        );

                        return response()->json($response, 422);
                    }
                }
                $comment = ObjectiveComment::create([
                    'user_id' => auth()->id(),
                    'control_control_objective_id' => $request->control_control_objective_id,
                    'comment' => $request->comment,
                    'file_display_name' => $fileName,
                    'file_unique_name' => $path,
                ]);


                $comment->formatted_created_at = $comment->created_at->format('Y-m-d H:i:s');

                // $comment = DocumentNote::find($note->id);
                $controlControlObjective = ControlControlObjective::where('id', $request->control_control_objective_id)->with('objective')->first();

                DB::commit();
                $message = __('governance.A Conmment') . ' "' . ($comment->comment ??  __('locale.[No Comment Text]')) .  '" ' . __('governance.OnRequirement') . ' "' . ($controlControlObjective->objective->name ??  __('governance.[No Requirement Name]')) . '" ' . __('locale.AddedBy') . ' "' . auth()->user()->name . '".';
                write_log($comment->id, auth()->id(), $message, 'Adding comments');
                $response = array(
                    'status' => true,
                    'message' => __('governance.CommentWasAddedSuccessfully'),
                    'data' => [
                        'comment' => $comment,
                    ],
                    'reload' => false,
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    // 'message' => $th->getMessage(),
                    'message' => __('governance.ThereAreUnexpectedProblems')
                );
                return response()->json($response, 502);
            }
        }
    }

    public function downloadObjectiveCommentFile($comment_id)
    {
        try {
            $comment = ObjectiveComment::where('id', $comment_id)->first() ?? null;
            $fileExists = Storage::disk('local')->exists($comment->file_unique_name);
            if ($comment && $fileExists) {
                $filePath = storage_path('app/' . $comment->file_unique_name);
                $fileName = $comment->file_display_name;
                return response()->download($filePath, $fileName);
            } else {
                return response()->json([
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.ErrorFileNotFound'),
                ], 502);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'errors' => [],
                // 'message' => __('locale.Error'),
                'message' => $th->getMessage(),

            ], 502);
        }
    }


    //End Objective Comment

    public function notificationsSettingsFramework()
    {
        // defining the breadcrumbs that will be shown in page

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Regulators')],
            ['link' => route('admin.governance.regulator.index'), 'name' => __('locale.Frameworks')],
            ['name' => __('locale.NotificationsSettings')]
        ];

        $users = User::select('id', 'name')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [31, 32, 33];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            31 => ['name', 'description', 'regulator'],
            32 => ['name', 'description', 'regulator'],
            33 => ['name', 'description', 'regulator'],
        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [];
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


        $actionsWithSettingsAuto = [];
        return view('admin.notifications-settings.index', compact('breadcrumbs', 'users', 'actionsWithSettings', 'actionsVariables', 'actionsRoles', 'moduleActionsIdsAutoNotify', 'actionsWithSettingsAuto'));
    }


    public function notificationsSettingsRegulator()
    {
        // defining the breadcrumbs that will be shown in page

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Regulators')],
            ['link' => route('admin.governance.regulator.index'), 'name' => __('locale.Framework')],
            ['name' => __('locale.NotificationsSettings')]
        ];

        $users = User::select('id', 'name')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [96, 97];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            96 => ['name'],
            97 => ['name'],
        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [];
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


        $actionsWithSettingsAuto = [];
        return view('admin.notifications-settings.index', compact('breadcrumbs', 'users', 'actionsWithSettings', 'actionsVariables', 'actionsRoles', 'moduleActionsIdsAutoNotify', 'actionsWithSettingsAuto'));
    }


    public function notificationsSettingscontrol()
    {
        // defining the breadcrumbs that will be shown in page

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Regulators')],
            ['link' => route('admin.governance.control.list'), 'name' => __('locale.Control')],
            ['name' => __('locale.NotificationsSettings')]
        ];

        $users = User::select('id', 'name')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [34, 35, 36, 37, 38, 39, 40, 85, 86];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [87];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            34 => ['short_name', 'long_name', 'description', 'control_number', 'Control_Owner', 'Desired_Maturity', 'Control_Priority', 'Control_class', 'Control_Maturity', 'Control_Phase', 'Control_Type', 'Tester', 'Test_Frequency', 'Test_Name', 'Test_Steps', 'Approximate_Time', 'Expected_Results'],
            35 => ['short_name', 'long_name', 'description', 'control_number', 'Control_Owner', 'Desired_Maturity', 'Control_Priority', 'Control_class', 'Control_Maturity', 'Control_Phase', 'Control_Type', 'Tester', 'Test_Frequency', 'Test_Name', 'Test_Steps', 'Approximate_Time', 'Expected_Results'],
            36 => ['name', 'description'],
            37 => ['Control_Owner', 'Control_Name', 'Control_Description', 'Objective', 'Responsible', 'Due_Date'],
            38 => ['Control_Owner', 'Control_Tester', 'Evidence_Creator', 'Control_Objective', 'Control_Objective_Responsible', 'description', 'Control_Name'],
            39 => ['Control_Owner', 'Control_Tester', 'Evidence_Creator', 'Control_Objective', 'Control_Objective_Responsible', 'description', 'Control_Name'],
            40 => ['short_name', 'long_name', 'description', 'control_number', 'Control_Owner', 'Desired_Maturity', 'Control_Priority', 'Control_class', 'Control_Maturity', 'Control_Phase', 'Control_Type', 'Tester', 'Test_Frequency', 'Test_Name', 'Test_Steps', 'Approximate_Time', 'Expected_Results'],
            85 => ['Control_Owner', 'Control_Name', 'Control_Description', 'Objective', 'Responsible'],
            86 => ['Control_Owner', 'Control_Name', 'Control_Description', 'Objective', 'Responsible', 'Due_Date'],
            87 => ['Control_Owner', 'Control_Name', 'Control_Description', 'Objective', 'Responsible', 'Due_Date'],

        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [
            34 => ['Control-Owner' => __('locale.ControlOwner'), 'Control-Tester' => __('locale.ControlTester')],
            35 => ['Control-Owner' => __('locale.ControlOwner'), 'Control-Tester' => __('locale.ControlTester')],
            36 => ['Control-Owner' => __('locale.ControlOwner'), 'Control-Tester' => __('locale.ControlTester')],
            37 => ['Control-Owner' => __('locale.ControlOwner'), 'Responsible_Person' => __('locale.Responsible_Person'), 'Control-Tester' => __('locale.ControlTester'), 'Auditer' => __('locale.Auditer')],
            38 => ['Control-Owner' => __('locale.ControlOwner'), 'Responsible_Person' => __('locale.Responsible_Person'), 'Control-Tester' => __('locale.ControlTester'), 'Evidence-Creator' => __('locale.EvidenceCreator'), 'Auditer' => __('locale.Auditer')],
            39 => ['Control-Owner' => __('locale.ControlOwner'), 'Responsible_Person' => __('locale.Responsible_Person'), 'Control-Tester' => __('locale.ControlTester'), 'Evidence-Creator' => __('locale.EvidenceCreator'), 'Auditer' => __('locale.Auditer')],
            40 => ['Control-Owner' => __('locale.ControlOwner'), 'Control-Tester' => __('locale.ControlTester')],
            85 => ['Control-Owner' => __('locale.ControlOwner'), 'Responsible_Person' => __('locale.Responsible_Person'), 'Control-Tester' => __('locale.ControlTester'), 'Auditer' => __('locale.Auditer')],
            86 => ['Control-Owner' => __('locale.ControlOwner'), 'Responsible_Person' => __('locale.Responsible_Person'), 'Control-Tester' => __('locale.ControlTester')],
            87 => ['Control-Owner' => __('locale.ControlOwner'), 'Responsible_Person' => __('locale.Responsible_Person'), 'Control-Tester' => __('locale.ControlTester'), 'Auditer' => __('locale.Auditer')],
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

    public function notificationsSettingsDocumentation()
    {
        // defining the breadcrumbs that will be shown in page
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.governance.category'), 'name' => __('locale.Documents')],
            ['name' => __('locale.NotificationsSettings')]
        ];

        $users = User::select('id', 'name')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [53, 54, 55, 56, 57, 58, 114, 115];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [76];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            53 => ['Name'],
            54 => ['Name'],
            55 => ['Name'],
            56 => ['Document_Type', 'Status', 'Document_Name', 'Last_Review_Date', 'Next_Review_Date', 'Controls', 'Teams', 'Stakeholders', 'Frameworks', 'Created_By'],
            57 => ['Document_Type', 'Status', 'Document_Name', 'Last_Review_Date', 'Next_Review_Date', 'Approval_Date', 'Controls', 'Teams', 'Stakeholders', 'Frameworks', 'Reviewer', 'Created_By'],
            58 => ['Document_Type', 'Status', 'Document_Name', 'Last_Review_Date', 'Next_Review_Date', 'Approval_Date', 'Controls', 'Teams', 'Stakeholders', 'Frameworks', 'Reviewer', 'Created_By'],
            114 => ['Document_Name', 'Policy_clause', 'Document_Owner'],
            115 => ['Document_Name', 'Policy_clause', 'Document_Owner'],
            76 => ['Document_Type', 'Status', 'Document_Name', 'Last_Review_Date', 'Next_Review_Date', 'Approval_Date', 'Controls', 'Teams', 'Stakeholders', 'Frameworks', 'Reviewer', 'Created_By'],
        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [
            56 => ['Document-Owner' => __('governance.DocumentOwner'), 'Team-teams' => __('governance.TeamsOfDocument'), 'Stakeholder-teams' => __('governance.StakeholderOfDocument'), 'Document-Creator' => __('governance.DocumentCreator'), 'Control-Owner' => __('governance.ControlOwner')],
            57 => ['Document-Owner' => __('governance.DocumentOwner'), 'Team-teams' => __('governance.TeamsOfDocument'), 'Stakeholder-teams' => __('governance.StakeholderOfDocument'), 'Document-Creator' => __('governance.DocumentCreator'), 'reviewers-teams' => __('governance.ReviewersOfDocument'), 'Control-Owner' => __('governance.ControlOwner')],
            58 => ['Document-Owner' => __('governance.DocumentOwner'), 'Team-teams' => __('governance.TeamsOfDocument'), 'Stakeholder-teams' => __('governance.StakeholderOfDocument'), 'Document-Creator' => __('governance.DocumentCreator'), 'reviewers-teams' => __('governance.ReviewersOfDocument'), 'Control-Owner' => __('governance.ControlOwner')],
            76 => ['Document-Owner' => __('governance.DocumentOwner'), 'Team-teams' => __('governance.TeamsOfDocument'), 'Stakeholder-teams' => __('governance.StakeholderOfDocument'), 'Document-Creator' => __('governance.DocumentCreator'), 'reviewers-teams' => __('governance.ReviewersOfDocument'), 'Control-Owner' => __('governance.ControlOwner')],
            114 => ['Document-Owner' => __('governance.DocumentOwner')],
            115 => ['Document-Owner' => __('governance.DocumentOwner')],
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

    public function notificationsSettingsAduitSchedule()
    {
        // defining the breadcrumbs that will be shown in page

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.governance.regulator.index'), 'name' => __('locale.FrameAduit')],
            ['name' => __('locale.NotificationsSettings')]
        ];

        $users = User::select('id', 'name')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [93, 94];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [95];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            93 => ['Regulator', 'Framework', 'Auditor', 'AssistantType', 'Assistant', 'StartDate', 'Duedate', 'periodicalTime', 'NextIntiateDate'],
            94 => ['Regulator', 'Framework', 'Auditor', 'AssistantType', 'Assistant', 'StartDate', 'Duedate', 'periodicalTime', 'NextIntiateDate'],
            95 => ['Regulator', 'Framework', 'Auditor', 'AssistantType', 'Assistant', 'StartDate', 'Duedate', 'periodicalTime', 'NextIntiateDate'],
        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [
            93 => ['auditor' => __('governance.Auditor'), 'assistants' => __('governance.Assistants')],
            94 => ['auditor' => __('governance.Auditor'), 'assistants' => __('governance.Assistants')],
            95 => ['auditor' => __('governance.Auditor'), 'assistants' => __('governance.Assistants')],
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteObjective($id)
    {
        // Retrieve the ControlControlObjective with its evidences
        $controlControlObjective = ControlControlObjective::with('evidences', 'objective')->find($id);
        if ($controlControlObjective) {
            DB::beginTransaction();
            try {
                $objectiveEvidences = $controlControlObjective->evidences;

                // Check if the objective has attached evidences
                if (!$objectiveEvidences->isEmpty()) {
                    // Return error response if there are attached evidences
                    $response = array(
                        'status' => false,
                        'message' => __('locale.YouCantDeleteTheObjectiveAsItHasEvidencesAttachedToIt '),
                    );
                    return response()->json($response, 404);
                }
                $controlId = $controlControlObjective->control_id;
                // Retrieve related audit objectives and delete them
                $auditObjectives = ControlAuditObjective::where('control_control_objective_id', $id)->get();
                foreach ($auditObjectives as $auditObjective) {
                    $auditObjective->delete();
                }

                // Delete the control objective
                $controlControlObjective->delete();
                // Retrieve updated objectives after deletion
                $objectives = $this->getControlObjectives($controlId)['objectives'];
                DB::commit();
                // Log evidence deletion
                $message = __('locale.A Requirement that name is') . ' "' . $controlControlObjective->objective->name .  __('locale.DeletedBy') . ' "' . auth()->user()->name . '".';
                write_log($controlControlObjective->id, auth()->id(), $message, 'Deleting Objective');
                event(new ControlObjectiveDeleted($controlControlObjective));

                $response = array(
                    'status' => true,
                    'objectives' => $objectives,
                    'message' => __('locale.ObjectiveWasDeletedSuccessfully '),
                );
                // Return success response
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                // Handle errors and rollback transaction
                DB::rollBack();

                // Check for specific error types
                if ($th->errorInfo[0] == 23000) {
                    $errorMessage = __('locale.ThereWasAProblemDeletingTheObjective')
                        . "<br>" . __('locale.CannotDeleteRecordRelationError');
                } else {
                    $errorMessage = __('locale.ThereWasAProblemDeletingTheObjective');
                }
                $response = array(
                    'status' => false,
                    'message ' => $errorMessage,
                );
                // Return error response
                return response()->json($response, 404);
            }
        } else {
            // Return error response for invalid resource
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404 '),
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
    public function deleteEvidence($id)
    {
        // Retrieve the evidence by its ID
        $evidence = Evidence::find($id);
        if ($evidence) {
            DB::beginTransaction();
            try {
                $controlControlObjectiveId = $evidence->control_control_objective_id;
                $existingFileUniqueName = $evidence->file_unique_name;
                // Retrieve related audit evidences and delete them
                $auditEvidences = ControlAuditEvidence::where('evidence_id', $id)->get();
                foreach ($auditEvidences as $auditEvidence) {
                    $auditEvidence->delete();
                }
                // Delete the evidence
                $evidence->delete();
                // Delete associated file from storage if it exists
                if ($existingFileUniqueName) {
                    Storage::delete($existingFileUniqueName);
                }
                // Retrieve updated evidences after deletion
                $gettingEvidences = $this->getEvidences($controlControlObjectiveId);
                $evidences = $gettingEvidences['evidences'];
                $canEditEvidences = $gettingEvidences['can_edit_evidences'];
                DB::commit();

                $response = array(
                    'status' => true,
                    'evidences' => $evidences,
                    'can_edit_evidences' => $canEditEvidences,
                    'message' => __('locale.EvidenceWasDeletedSuccessfully '),
                );
                // Log evidence deletion
                $message = __('locale.An evidence that name is') . ' "' . $evidence->name .  __('locale.DeletedBy') . ' "' . auth()->user()->name . '".';
                write_log($evidence->id, auth()->id(), $message, 'Deleting Evidence');
                // Return success response
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                // Handle errors and rollback transaction
                DB::rollBack();

                // Check for specific error types
                if ($th->errorInfo[0] == 23000) {
                    $errorMessage = __('locale.ThereWasAProblemDeletingTheEvidence')
                        . "<br>" . __('locale.CannotDeleteRecordRelationError');
                } else {
                    $errorMessage = __('locale.ThereWasAProblemDeletingTheEvidence');
                }
                $response = array(
                    'status' => false,
                    'message' => $errorMessage,
                );
                // Return error response
                return response()->json($response, 404);
            }
        } else {
            // Return error response for invalid resource
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404'),
            );
            return response()->json($response, 404);
        }
    }

    public function clearComments($controlControlObjectiveId)
    {
        try {
            DB::beginTransaction();
            $comments = ObjectiveComment::where('control_control_objective_id', $controlControlObjectiveId)->get();
            foreach ($comments as $comment) {
                $existingFileUniqueName = $comment->file_unique_name;
                if ($existingFileUniqueName) {
                    Storage::delete($existingFileUniqueName);
                }
                $comment->delete();
            }
            DB::commit();
            $controlControlObjective = ControlControlObjective::where('id', $controlControlObjectiveId)->with('objective')->first();
            $message = __('governance.Comments') . ' ' . __('governance.OnRequirement') . ' "' . ($controlControlObjective->objective->name ??  __('governance.[No Requirement Name]')) . '" ' . __('locale.HasBeenClearedBy') . ' "' . auth()->user()->name . '".';
            write_log($comment->id, auth()->id(), $message, 'Clearing comments');
            $response = array(
                'status' => true,
                'message' => __('locale.CommentsWasDeletedSuccessfully '),
            );
            // Return success response
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            // Handle errors and rollback transaction
            DB::rollBack();

            // Check for specific error types
            if ($th->errorInfo[0] == 23000) {
                $errorMessage = __('locale.ThereWasAProblemDeletingTheComments')
                    . "<br>" . __('locale.CannotDeleteRecordRelationError');
            } else {
                $errorMessage = __('locale.ThereWasAProblemDeletingTheComments');
            }
            $response = array(
                'status' => false,
                'message' => $errorMessage,
            );
            // Return error response
            return response()->json($response, 404);
        }
    }


    public function domainDetails(Request $request)
    {
        if ($request->domain_id) {
            $framework = Framework::find($request->frame_id);
            $domain = Family::find($request->domain_id);
            $subdomains = [];

            foreach ($framework->only_sub_families as $subDomain) {
                if ($domain->id == $subDomain->parent_id) {
                    $controls = $subDomain->frameworkControls()
                        ->whereHas('frameworks', function ($query) use ($framework) {
                            $query->where('frameworks.id', $framework->id);
                        })
                        ->pluck('short_name')
                        ->toArray();

                    // $controls = $subDomain->frameworkControls->where('',$framework->id)->pluck('short_name')->toArray();
                    $subdomains[] = [
                        'name' => $subDomain->name,
                        'children' => array_map(function ($control) {
                            return ['name' => $control];
                        }, $controls)
                    ];
                }
            }

            $treeData = [
                'name' => $domain->name,
                'children' => $subdomains
            ];

            return response()->json($treeData);
        }

        return response()->json(['error' => 'Domain ID is required'], 400);
    }





    public function fetchTeams(Request $request)
    {
        // Retrieve inputs from the request
        $testControlNumber = $request->input('testControlNumber');
        $frameworkId = $request->input('frameworkId');
        $assignType = $request->input('assignType');
        $familyIds = $request->input('familyIds', []);

        $response = []; // Initialize the response array

        foreach ($familyIds as $familyId) {
            // Get control IDs for the current family ID
            $familyControlIds = \DB::table('framework_controls')
                ->where('family', $familyId)
                ->pluck('id')
                ->toArray();

            // Get test control IDs related to the current family
            $familyTestControlIds = \DB::table('framework_control_test_audits')
                ->whereIn('framework_control_id', $familyControlIds) // Filter by control IDs
                ->whereRaw('JSON_EXTRACT(test_number, "$[0]") = ?', [$testControlNumber]) // Compare the first index of JSON array
                ->pluck('id') // Get the test IDs
                ->toArray();

            if ($assignType === "users") {
                // Get user IDs assigned to the test control IDs
                $familyTeamsExist = ItemsToUser::whereIn('item_id', $familyTestControlIds)
                    ->pluck('user_id')
                    ->toArray();

                // Get user names for the retrieved user IDs
                $familyTeams = User::whereIn('id', $familyTeamsExist)
                    ->pluck('name', 'id')
                    ->toArray();
            } else {
                // Get team IDs assigned to the test control IDs
                $familyTeamsExist = ItemsToTeam::whereIn('item_id', $familyTestControlIds)
                    ->pluck('team_id')
                    ->toArray();

                // Get team names for the retrieved team IDs
                $familyTeams = Team::whereIn('id', $familyTeamsExist)
                    ->pluck('name', 'id')
                    ->toArray();
            }

            // Add the results to the response array, keyed by family ID
            $response[$familyId] = $familyTeams;
        }

        // Return the response as JSON
        return response()->json([
            'teamsByFamily' => $response, // Include the teams by family in the response
        ]);
    }



    public function fetchControlsClosed($frameworkId)
    {
        // Fetch controls related to the given framework ID
        $controls = FrameworkControlMapping::where('framework_id', $frameworkId)
            ->select('framework_control_id')
            ->groupBy('framework_control_id')
            ->pluck('framework_control_id');
        // Subquery to get the latest status of each control
        $latestControls = FrameworkControlTestAudit::select('framework_control_id', 'status')
            ->whereIn('framework_control_id', $controls)
            ->whereIn('id', function ($query) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('framework_control_test_audits')
                    ->groupBy('framework_control_id');
            })
            ->get();

        // Get controls that are not closed
        $controlsNotClosed = $latestControls->where('action_status', '!=', 1);

        // Fetch mapped controls
        $mappedControls = FrameworkControlExtension::whereIn('control_id', $controls)
            ->pluck('extend_control_id')
            ->toArray();

        // Check if mapped controls exist in FrameworkControlTestAudit
        $existingMappedControlsCount = FrameworkControlTestAudit::whereIn('framework_control_id', $mappedControls)
            ->distinct()
            ->count('framework_control_id');

        // Compare counts
        $allMappedControlsExist = count($mappedControls) === $existingMappedControlsCount;

        // Join to get the short_name for each control
        $controlsNotClosedDetails = FrameworkControlTestAudit::select('framework_control_test_audits.framework_control_id', 'framework_control_test_audits.status', 'framework_control_test_audits.name')
            ->join('framework_controls', 'framework_controls.id', '=', 'framework_control_test_audits.framework_control_id')
            ->whereIn('framework_control_test_audits.framework_control_id', $controls)
            ->where('framework_control_test_audits.status', '!=', 5)
            ->whereIn('framework_control_test_audits.id', function ($query) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('framework_control_test_audits')
                    ->groupBy('framework_control_id');
            })
            ->get();


        return response()->json([
            'notClosedCount' => $controlsNotClosed->count(),
            'controlsNotClosed' => $controlsNotClosedDetails,
            'mappedCount' => $existingMappedControlsCount,
            'allMappedControlsExist' => $allMappedControlsExist
        ]);
    }

    // public function getDomainReqAndEveDetails(Request $request)
    // {
    //     // Get the framework and domain IDs from the request
    //     $domainId = $request->input('domain_id');

    //     $frameworkId = $request->input('framework_id');
    //     // Find family IDs that match the criteria
    //     $familyIds = DB::table('framework_families')
    //         ->where('framework_id', $frameworkId)
    //         ->where('parent_family_id', $domainId)
    //         ->pluck('family_id');

    //     $familyNames = DB::table('families')
    //         ->whereIn('id', $familyIds)
    //         ->pluck('name');

    //     // Fetch control mappings for the given framework ID
    //     $controlMappings = DB::table('framework_control_mappings')
    //         ->where('framework_id', $frameworkId)
    //         ->pluck('framework_control_id');

    //     // Retrieve controls that have corresponding audit entries
    //     $controls = FrameworkControl::with('Family')
    //         ->whereIn('id', $controlMappings)
    //         ->whereIn('family', $familyIds)
    //         ->pluck('id', 'short_name')
    //         ->toArray();

    //     // Optimize: Use subquery to get the latest framework control test audit ID for each control
    //     $latestControls = FrameworkControlTestAudit::select('framework_control_id', DB::raw('MAX(id) as latest_id'), 'test_number')
    //         ->whereIn('framework_control_id', $controls)
    //         ->groupBy('framework_control_id');



    //     $controlsFromFrame = FrameworkControlMapping::where('framework_id', $frameworkId)->pluck('framework_control_id')->toArray();

    //     dd($domainId,$frameworkId,$familyIds,$familyNames,$controlMappings,$controls,);

    //     // Merge the family IDs with the domain ID
    //     $domainFamilyAndSub = collect([$domainId])->merge($familyIds)->unique(); // Wrap $domainId in a collection

    //     // Optionally, if you want the result as an array instead of a collection
    //     $domainFamilyAndSubArray = $domainFamilyAndSub->toArray();
    //     $statusResult = $this->staticsStatusForDomain(FrameworkControl::whereIn('id', $controlsFromFrame)->WhereIn('family', $domainFamilyAndSubArray)->WhereNull('parent_id')->pluck('id'));
    //     // Get the latest control status data with related models
    //     $frameworkControlTestAudits = FrameworkControlTestAudit::with([
    //         'ControlAuditObjectives.controlControlObjective:id,due_date',
    //         'ControlAuditEvidences.evidence',
    //         'ControlAuditPolicies'
    //     ])
    //         ->whereIn('id', $latestControls->pluck('latest_id')->toArray()) // Convert to array here
    //         ->get();

    //     // Initialize counts
    //     $approvedCountEvidence = 0;
    //     $rejectedCountEvidence = 0;
    //     $noActionCountEvidence = 0;
    //     $approvedCountAttachEvidence = 0;
    //     $rejectedCountAttachEvidence = 0;
    //     $notRelevantCountAttachEvidence = 0;
    //     $notActionCountAttachEvidence = 0;

    //     // Initialize counts for documents audit statuses
    //     $documentApprovedCount = 0;
    //     $documentRejectedCount = 0;
    //     $documentNoActionCount = 0;

    //     // Initialize counts for Open and Closed controls
    //     $openControlCount = 0;
    //     $closedControlCount = 0;

    //     // Initialize counts for controls with and without evidence, requirements, and documents
    //     $controlsWithEvidence = 0;
    //     $controlsWithoutEvidence = 0;
    //     $controlsWithRequirements = 0;
    //     $controlsWithoutRequirements = 0;
    //     $controlsWithDocuments = 0;
    //     $controlsWithoutDocuments = 0;
    //     // Count ControlAuditObjectives and others
    //     foreach ($frameworkControlTestAudits as $frameworkControlTestAudit) {

    //         // Count document audit statuses
    //         foreach ($frameworkControlTestAudit->ControlAuditPolicies as $policy) {
    //             if ($policy->document_audit_status == 'approved') {
    //                 $documentApprovedCount++;
    //             } elseif ($policy->document_audit_status == 'rejected') {
    //                 $documentRejectedCount++;
    //             } elseif ($policy->document_audit_status == 'no_action') {
    //                 $documentNoActionCount++;
    //             }
    //         }

    //         // Count control audit statuses (Open/Closed)
    //         if ($frameworkControlTestAudit->status == 1) { // Assuming '1' means Open
    //             $openControlCount++;
    //         } else {
    //             $closedControlCount++;
    //         }

    //         // Check for evidence
    //         if ($frameworkControlTestAudit->ControlAuditEvidences->isNotEmpty()) {
    //             $controlsWithEvidence++;
    //         } else {
    //             $controlsWithoutEvidence++;
    //         }

    //         // Check for requirements
    //         if (count($frameworkControlTestAudit->ControlAuditObjectives) > 0) {
    //             $controlsWithRequirements++;
    //         } else {
    //             $controlsWithoutRequirements++;
    //         }

    //         // Check for documents
    //         if ($frameworkControlTestAudit->ControlAuditPolicies->isNotEmpty()) {
    //             $controlsWithDocuments++;
    //         } else {
    //             $controlsWithoutDocuments++;
    //         }

    //         // ControlAuditObjectives handling
    //         if (count($frameworkControlTestAudit->ControlAuditObjectives)) {
    //             foreach ($frameworkControlTestAudit->ControlAuditObjectives as $controlAuditObjective) {
    //                 // Count ControlAuditObjectives statuses
    //                 if ($controlAuditObjective->objective_audit_status == 'approved') {
    //                     $approvedCountEvidence++;
    //                 } elseif ($controlAuditObjective->objective_audit_status == 'rejected') {
    //                     $rejectedCountEvidence++;
    //                 } elseif ($controlAuditObjective->objective_audit_status == 'no_action') {
    //                     $noActionCountEvidence++;
    //                 }
    //             }
    //         }

    //         // Count controlAuditEvidences statuses
    //         foreach ($frameworkControlTestAudit->ControlAuditEvidences as $controlAuditEvidence) {
    //             if ($controlAuditEvidence->evidence_audit_status == 'approved') {
    //                 $approvedCountAttachEvidence++;
    //             } elseif ($controlAuditEvidence->evidence_audit_status == 'rejected') {
    //                 $rejectedCountAttachEvidence++;
    //             } elseif ($controlAuditEvidence->evidence_audit_status == 'not_relevant') {
    //                 $notRelevantCountAttachEvidence++;
    //             } elseif ($controlAuditEvidence->evidence_audit_status == 'no_action') {
    //                 $notActionCountAttachEvidence++;
    //             }
    //         }
    //     }

    //     // Calculate total counts
    //     $totalControls = count($frameworkControlTestAudits);
    //     $totalRequirements = $approvedCountEvidence + $rejectedCountEvidence + $noActionCountEvidence;
    //     $totalDocuments = $documentApprovedCount + $documentRejectedCount + $documentNoActionCount;
    //     $totalEvidences = $approvedCountAttachEvidence + $rejectedCountAttachEvidence + $notRelevantCountAttachEvidence + $notActionCountAttachEvidence;
    //     // Calculate percentage of open controls\
    //     $percentageOpenControls = $totalControls > 0 ? ($openControlCount / $totalControls) * 100 : 0;
    //     $percentageCloseControls = $totalControls > 0 ? ($closedControlCount / $totalControls) * 100 : 0;

    //     // Prepare response
    //     return response()->json([
    //         'open_control_count' => $openControlCount,
    //         'closed_control_count' => $closedControlCount,
    //         'percentage_open_controls' => number_format($percentageOpenControls, 2),
    //         'percentage_close_controls' => number_format($percentageCloseControls, 2),
    //         'total_documents' => $totalDocuments,
    //         'total_requirements' => $totalRequirements,
    //         'total_evidences' => $totalEvidences,
    //         'controls_without_evidence' => $controlsWithoutEvidence,
    //         'controls_with_evidence' => $controlsWithEvidence,
    //         'controls_without_requirements' => $controlsWithoutRequirements,
    //         'controls_with_requirements' => $controlsWithRequirements,
    //         'controls_without_documents' => $controlsWithoutDocuments,
    //         'controls_with_documents' => $controlsWithDocuments,
    //         'countsByTestNumber' => $statusResult->getData()->countsByTestNumber,
    //         'familyNames' => $familyNames,
    //         'controls' => $controls,
    //     ]);
    // }


    public function getDomainReqAndEveDetails(Request $request)
    {
        // Get the framework and domain IDs from the request
        $domainId = $request->input('domain_id');
        $frameworkId = $request->input('framework_id');

        // Find family IDs that match the criteria
        $familyIds = DB::table('framework_families')
            ->where('framework_id', $frameworkId)
            ->where('parent_family_id', $domainId)
            ->pluck('family_id');

        $domainFamilyAndSub = collect([$domainId])->merge($familyIds)->unique();

        $familyNames = DB::table('families')
            ->whereIn('id', $familyIds)
            ->pluck('name');

        // Fetch control mappings for the given framework ID
        $controlMappings = DB::table('framework_control_mappings')
            ->where('framework_id', $frameworkId)
            ->pluck('framework_control_id');

            $controls = FrameworkControl::select('id', 'short_name', 'parent_id')
            ->whereIn('family', $domainFamilyAndSub)
            ->whereIn('id', $controlMappings)
            ->get();
        
        // Find all parent controls that have children
        $parentIdsWithChildren = $controls->whereNotNull('parent_id')->pluck('parent_id')->unique();
        
        // Get only child controls and main controls that do not have children
        $filteredControls = $controls->reject(function ($control) use ($parentIdsWithChildren) {
            return is_null($control->parent_id) && $parentIdsWithChildren->contains($control->id);
        });
        
        // Convert to collections if needed
        $controlsCollection = collect($controls);
        $filteredControlsCollection = collect($filteredControls);

        // Filter controls where 'parent_id' is null and pluck their 'id'
        $statusResult = $this->staticsStatusForDomain(
            $controlsCollection->whereNull('parent_id')->pluck('id')
        );

        // Get the latest controls in audit, ensuring uniqueness by framework_control_id
        $latestControlsObjective = ControlControlObjective::select('id', 'control_id')
            ->whereIn('control_id', $filteredControlsCollection->pluck('id')) // Extract IDs from the collection
            ->get();

        // Get all evidence for the latest control objectives
        $latestControlsEvidence = Evidence::select('id', 'control_control_objective_id')
            ->whereIn('control_control_objective_id',$latestControlsObjective->pluck('id')) // Extract IDs from the collection
            ->get();

        // Calculate total counts
        $totalControls = $filteredControls->count() ;

        $totalRequirements =  $latestControlsObjective->count();
        $controlsWithRequirements =  $latestControlsObjective->unique('control_id')->count();
        $controlsWithoutRequirements = $totalControls - $controlsWithRequirements;
        $totalEvidences =  $latestControlsEvidence->count();
        $controlsWithEvidence = ControlControlObjective::whereIn('id', $latestControlsEvidence->pluck('control_control_objective_id')) // Correct pluck usage
        ->get()
        ->unique('control_id')
        ->count();
        $controlsWithoutEvidence=$totalControls-$controlsWithEvidence;


        // Prepare response
        return response()->json([
            'total_requirements' => $totalRequirements,
            'total_evidences' => $totalEvidences,
            'controls_without_evidence' => $controlsWithoutEvidence,
            'controls_with_evidence' => $controlsWithEvidence,
            'controls_without_requirements' => $controlsWithoutRequirements,
            'controls_with_requirements' => $controlsWithRequirements,
            'countsByTestNumber' => $statusResult->getData()->countsByTestNumber,
            'familyNames' => $familyNames,
            'controls' => $controls,
        ]);
    }

    private function staticsStatusForFrameAudit($latestControls)
    {
        // Define the statuses you want to include in the result
        $statuses = ["Implemented", "Partially Implemented", "Not Implemented", "Not Applicable"];

        $countsByTestNumber = []; // Initialize array for results

        // Initialize a count array for each status
        $statusCounts = array_fill_keys($statuses, 0);
        $totalControls = count($latestControls); // Total controls for percentage calculation

        // Loop through the latest controls to count each status
        foreach ($latestControls as $control) {
            $testNumbers = json_decode($control->test_number, true); // Decode the JSON string

            // Assuming the test_number structure is an array where you check for the status at index 1
            if (isset($testNumbers[1]) && in_array($testNumbers[1], $statuses)) {
                $statusCounts[$testNumbers[1]]++;
            }
        }

        // Prepare results for each status
        foreach ($statuses as $status) {
            $count = $statusCounts[$status];
            $percentage = $totalControls > 0 ? number_format(($count * 100) / $totalControls, 2) : 0;

            // Add the result to the countsByTestNumber array
            $countsByTestNumber[] = [
                'status_name' => $status,
                'count' => $count,
                'percentage' => $percentage,
                'total_controls' => $totalControls
            ];
        }
        // Encode the results into JSON and return them
        return response()->json(['countsByTestNumber' => $countsByTestNumber]);
    }

    private function staticsStatusForDomain($allControls)
    {
        // Initialize the status labels and counts
        $statuses = ["Implemented", "Partially Implemented", "Not Implemented", "Not Applicable"];
        $statusCounts = array_fill_keys($statuses, 0); // Initialize counts to 0 for each status

        // Fetch controls for the given IDs and their statuses
        $controlStatus = FrameworkControl::whereIn('id', $allControls)
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


    public function summaryOfResultsForEvaluationAndCompliancedetailsToFramework(Request $request)
    {
        // Get the framework and domain IDs from the request
        $testNumber = $request->input('test_number_initiated');
        $frameworkId = $request->input('framework_id');

        $familyNames = DB::table('families')->pluck('name');
        // Fetch control mappings for the given framework ID
        $controlMappings = DB::table('framework_control_mappings')
            ->where('framework_id', $frameworkId)
            ->pluck('framework_control_id');

        // Retrieve controls that have corresponding audit entries
        $controls = FrameworkControl::with('Family')
            ->whereIn('id', $controlMappings)
            ->pluck('id', 'short_name')
            ->toArray();
        // Optimize: Use subquery to get the latest framework control test audit ID for each control
        $latestControls = FrameworkControlTestAudit::select('framework_control_id', 'id as latest_id', 'test_number')
            ->whereIn('framework_control_id', $controls)
            ->where(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(test_number, "$[0]"))'), $testNumber) // Check the first index of test_number
            ->groupBy('framework_control_id');

        $statusResult = $this->staticsStatusForFrameAudit($latestControls->get()); // Execute the query

        // Get the latest control status data with related models
        $frameworkControlTestAudits = FrameworkControlTestAudit::whereIn('id', $latestControls->pluck('latest_id')->toArray())->get();

        // Initialize counts
        // Requirements counts
        $approvedCountEvidence = 0;
        $rejectedCountEvidence = 0;
        $noActionCountEvidence = 0;

        // Evidence counts
        $approvedCountAttachEvidence = 0;
        $rejectedCountAttachEvidence = 0;
        $notRelevantCountAttachEvidence = 0;
        $notActionCountAttachEvidence = 0;

        // Initialize counts for Open and Closed controls
        $openControlCount = 0;
        $closedControlCount = 0;

        // Initialize counts for controls with and without evidence, requirements, and documents
        $controlsWithEvidence = 0;
        $controlsWithoutEvidence = 0;
        $controlsWithRequirements = 0;
        $controlsWithoutRequirements = 0;
        $controlsWithDocuments = 0;
        $controlsWithoutDocuments = 0;

        foreach ($frameworkControlTestAudits as $frameworkControlTestAudit) {
            // Count control audit statuses (Open/Closed)
            if ($frameworkControlTestAudit->action_status == 0) { // Assuming '1' means Open
                $openControlCount++;
            } else {
                $closedControlCount++;
            }

            // Check for evidence
            if ($frameworkControlTestAudit->ControlAuditEvidences->isNotEmpty()) {
                $controlsWithEvidence++;
            } else {
                $controlsWithoutEvidence++;
            }

            // Check for requirements
            if (count($frameworkControlTestAudit->ControlAuditObjectives) > 0) {
                $controlsWithRequirements++;
                foreach ($frameworkControlTestAudit->ControlAuditObjectives as $controlAuditObjective) {
                    // Count ControlAuditObjectives statuses
                    if ($controlAuditObjective->objective_audit_status == 'approved') {
                        $approvedCountEvidence++;
                    } elseif ($controlAuditObjective->objective_audit_status == 'rejected') {
                        $rejectedCountEvidence++;
                    } elseif ($controlAuditObjective->objective_audit_status == 'no_action') {
                        $noActionCountEvidence++;
                    }
                }
            } else {
                $controlsWithoutRequirements++;
            }

            // Check for documents
            if ($frameworkControlTestAudit->ControlAuditPolicies->isNotEmpty()) {
                $controlsWithDocuments++;
            } else {
                $controlsWithoutDocuments++;
            }

            // Count controlAuditEvidences statuses
            foreach ($frameworkControlTestAudit->ControlAuditEvidences as $controlAuditEvidence) {
                if ($controlAuditEvidence->evidence_audit_status == 'approved') {
                    $approvedCountAttachEvidence++;
                } elseif ($controlAuditEvidence->evidence_audit_status == 'rejected') {
                    $rejectedCountAttachEvidence++;
                } elseif ($controlAuditEvidence->evidence_audit_status == 'not_relevant') {
                    $notRelevantCountAttachEvidence++;
                } elseif ($controlAuditEvidence->evidence_audit_status == 'no_action') {
                    $notActionCountAttachEvidence++;
                }
            }
        }

        // Calculate total counts
        $totalControls = count($frameworkControlTestAudits);
        $totalRequirements = $approvedCountEvidence + $rejectedCountEvidence + $noActionCountEvidence;
        $totalEvidences = $approvedCountAttachEvidence + $rejectedCountAttachEvidence + $notRelevantCountAttachEvidence + $notActionCountAttachEvidence;

        // Calculate percentage of open controls
        $percentageOpenControls = $totalControls > 0 ? ($openControlCount / $totalControls) * 100 : 0;
        $percentageCloseControls = $totalControls > 0 ? ($closedControlCount / $totalControls) * 100 : 0;

        // Prepare response
        return response()->json([
            'open_control_count' => $openControlCount,
            'closed_control_count' => $closedControlCount,
            'percentage_open_controls' => number_format($percentageOpenControls, 2),
            'percentage_close_controls' => number_format($percentageCloseControls, 2),
            'total_documents' => count($frameworkControlTestAudits), // Update to the correct count if necessary
            'total_requirements' => $totalRequirements,
            'total_evidences' => $totalEvidences,
            'approved_requirements' => $approvedCountEvidence,
            'rejected_requirements' => $rejectedCountEvidence,
            'no_action_requirements' => $noActionCountEvidence,
            'approved_evidences' => $approvedCountAttachEvidence,
            'rejected_evidences' => $rejectedCountAttachEvidence,
            'not_relevant_evidences' => $notRelevantCountAttachEvidence,
            'not_action_evidences' => $notActionCountAttachEvidence,
            'controls_without_evidence' => $controlsWithoutEvidence,
            'controls_with_evidence' => $controlsWithEvidence,
            'controls_without_requirements' => $controlsWithoutRequirements,
            'controls_with_requirements' => $controlsWithRequirements,
            'controls_without_documents' => $controlsWithoutDocuments,
            'controls_with_documents' => $controlsWithDocuments,
            'countsByTestNumber' => $statusResult->getData()->countsByTestNumber,
            'familyNames' => $familyNames,
            'controls' => $controls,
        ]);
    }




    // public function getFilteredDomainDetails(Request $request)
    // {
    //     // Get the framework and domain IDs from the request
    //     $domainId = $request->input('domain_id');
    //     $frameworkId = $request->input('framework_id');
    //     $departmentId = $request->input('department_id');

    //     // Convert user IDs to an array
    //     $userIds = User::where('department_id', $departmentId)->pluck('id')->toArray();

    //     // Find family IDs that match the criteria
    //     $familyIds = DB::table('framework_families')
    //         ->where('framework_id', $frameworkId)
    //         ->where('parent_family_id', $domainId)
    //         ->pluck('family_id');

    //     // Fetch control mappings for the given framework ID
    //     $controlMappings = DB::table('framework_control_mappings')
    //         ->where('framework_id', $frameworkId)
    //         ->pluck('framework_control_id');

    //     // Retrieve controls that have corresponding audit entries
    //     $controls = FrameworkControl::with('Family')
    //         ->whereIn('id', $controlMappings)
    //         ->whereIn('family', $familyIds)
    //         ->pluck('id')
    //         ->toArray();

    //     // Optimize: Use subquery to get the latest framework control test audit ID for each control
    //     $latestControls = FrameworkControlTestAudit::select('framework_control_id', DB::raw('MAX(id) as latest_id'))
    //         ->whereIn('framework_control_id', $controls)
    //         ->groupBy('framework_control_id');

    //     // Get the latest control status data
    //     $frameworkControlTestAudits = FrameworkControlTestAudit::with([
    //         'ControlAuditObjectives.controlControlObjective:id,due_date,responsible_id',
    //         'ControlAuditEvidences.evidence',
    //         'ControlAuditPolicies'
    //     ])
    //         ->whereIn('id', $latestControls->pluck('latest_id')->toArray())
    //         ->get();

    //     // Initialize counts
    //     $approvedCountEvidence = 0;
    //     $rejectedCountEvidence = 0;
    //     $noActionCountEvidence = 0;
    //     $controlsWithEvidence = 0;
    //     $controlsWithoutEvidence = 0;
    //     $openControlCount = 0;
    //     $closedControlCount = 0;
    //     $controlsWithRequirements = 0;
    //     $controlsWithoutRequirements = 0;
    //     $controlsWithDocuments = 0;
    //     $controlsWithoutDocuments = 0; // Make sure this variable is defined

    //     // Count ControlAuditObjectives and other metrics
    //     foreach ($frameworkControlTestAudits as $frameworkControlTestAudit) {
    //         // Count control audit statuses (Open/Closed)
    //         if ($frameworkControlTestAudit->status == 1) { // Assuming '1' means Open
    //             $openControlCount++;
    //         } else {
    //             $closedControlCount++;
    //         }

    //         // Filter ControlAuditObjectives based on user IDs
    //         $filteredObjectives = $frameworkControlTestAudit->ControlAuditObjectives->filter(function ($objective) use ($userIds) {
    //             return in_array($objective->controlControlObjective->responsible_id, $userIds);
    //         });

    //         if ($filteredObjectives->count()) {
    //             foreach ($filteredObjectives as $objective) {
    //                 // Count ControlAuditObjectives statuses
    //                 if ($objective->objective_audit_status == 'approved') {
    //                     $approvedCountEvidence++;
    //                 } elseif ($objective->objective_audit_status == 'rejected') {
    //                     $rejectedCountEvidence++;
    //                 } elseif ($objective->objective_audit_status == 'no_action') {
    //                     $noActionCountEvidence++;
    //                 }
    //             }
    //             $controlsWithEvidence++;
    //         } else {
    //             $controlsWithoutEvidence++;
    //         }

    //         // Check for requirements and documents directly
    //         if ($frameworkControlTestAudit->ControlAuditObjectives->count() > 0) {
    //             $controlsWithRequirements++;
    //         } else {
    //             $controlsWithoutRequirements++;
    //         }

    //         if ($frameworkControlTestAudit->ControlAuditEvidences->count() > 0) {
    //             $controlsWithDocuments++;
    //         } else {
    //             $controlsWithoutDocuments++;
    //         }
    //     }

    //     // Calculate totals
    //     $totalControls = count($frameworkControlTestAudits);
    //     $totalRequirements = $approvedCountEvidence + $rejectedCountEvidence + $noActionCountEvidence;
    //     $totalDocuments = $controlsWithDocuments + $controlsWithoutDocuments; // Use variable correctly

    //     // Calculate percentage of open controls
    //     $percentageOpenControls = $totalControls > 0 ? ($openControlCount / $totalControls) * 100 : 0;
    //     $percentageCloseControls = $totalControls > 0 ? ($closedControlCount / $totalControls) * 100 : 0;

    //     // Prepare response
    //     return response()->json([
    //         'open_control_count' => $openControlCount,
    //         'closed_control_count' => $closedControlCount,
    //         'percentage_open_controls' => number_format($percentageOpenControls, 2),
    //         'percentage_close_controls' => number_format($percentageCloseControls, 2),
    //         'total_documents' => $totalDocuments,
    //         'total_requirements' => $totalRequirements,
    //         'controls_without_evidence' => $controlsWithoutEvidence,
    //         'controls_with_evidence' => $controlsWithEvidence,
    //         'controls_without_requirements' => $controlsWithoutRequirements,
    //         'controls_with_requirements' => $controlsWithRequirements,
    //         'controls_without_documents' => $controlsWithoutDocuments,
    //         'controls_with_documents' => $controlsWithDocuments,
    //         'countsByTestNumber' => $this->staticsStatusForDomain($latestControls->get())->getData()->countsByTestNumber,
    //     ]);
    // }





    public function domainStatus(Request $request)
    {
        if ($request->ajax()) {
            // Get the framework and domain IDs from the request
            $frameworkId = $request->frame_id;
            $domainId = $request->domain_id;
            // Find family IDs that match the criteria
            $familyIds = DB::table('framework_families')
                ->where('framework_id', $frameworkId)
                ->where('parent_family_id', $domainId)
                ->pluck('family_id')
                ->toArray(); // Ensure it's an array

            // Fetch control mappings for the given framework ID
            $controlMappings = DB::table('framework_control_mappings')
                ->where('framework_id', $frameworkId)
                ->pluck('framework_control_id')
                ->toArray(); // Ensure it's an array

            // Merge the family IDs with the domain ID
            $domainFamilyAndSub = collect([$domainId])->merge($familyIds)->unique(); // Wrap $domainId in a collection

            // Optionally, if you want the result as an array instead of a collection
            $domainFamilyAndSubArray = $domainFamilyAndSub->toArray();

            // Retrieve controls that have corresponding audit entries
            $controls = FrameworkControl::with('Family')
                ->whereIn('id', $controlMappings)
                ->whereIn('family', $domainFamilyAndSubArray)
                ->get();
            // Prepare the data for DataTables
            $data = $controls->map(function ($control) {
                // Count total requirements
                $totalRequirements = $control->objectives()->count();

                // Count total evidence through objectives
                $totalEvidence = $control->objectives->flatMap(function ($objective) {
                    return $objective->evidences; // Fetch all related evidences
                })->count();

                return [
                    'control_name' => $control->short_name ?? 'N/A',
                    'sub_domain' => $control->Family->name ?? 'N/A',
                    'status' => $control->control_status ?? 'No Action',
                    'total_requirements' => $totalRequirements ?? 'No Action', // Add requirements count
                    'total_evidence' => $totalEvidence ?? 'No Action', // Add evidence count
                ];
            });

            return DataTables::of($data)->make(true);
        }

        // Handle non-AJAX requests (optional)
        return response()->json(['error' => 'Invalid request'], 400);
    }



    public function frameworkControlStatus(Request $request)
    {
        if ($request->ajax()) {
            $frameworkId = $request->frame_id;
            $testNumber = $request->test_number;

            $controlMappings = DB::table('framework_control_mappings')
                ->where('framework_id', $frameworkId)
                ->pluck('framework_control_id');

            $controls = FrameworkControl::with('Family')
                ->whereIn('id', $controlMappings)
                ->whereHas('frameworkControlTestAudits')
                ->get();

            $data = $controls->map(function ($control) use ($testNumber, $frameworkId) {
                $latestAudit = FrameworkControlTestAudit::where('framework_control_id', $control->id)
                    ->where(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(test_number, "$[0]"))'), $testNumber)
                    ->first();
                $totalRequirements = 0;
                $totalApprovedRequirements = 0;
                $totalEvidence = 0;
                $totalApprovedEvidence = 0;

                if ($latestAudit) {
                    $totalRequirements = $latestAudit->ControlAuditObjectives->count();
                    $totalApprovedRequirements = $latestAudit->ControlAuditObjectives
                        ->where('objective_audit_status', 'approved')
                        ->count();

                    $totalEvidence = $latestAudit->ControlAuditEvidences->count();
                    $totalApprovedEvidence = $latestAudit->ControlAuditEvidences
                        ->where('evidence_audit_status', 'approved')
                        ->count();

                    $testNumberArray = json_decode($latestAudit->test_number, true);
                    $status = $testNumberArray[1] ?? 'No Action';
                } else {
                    $status = 'No Action';
                }

                return [
                    'control_name' => $control->short_name ?? 'N/A',
                    'sub_domain' => $control->Family->name ?? 'N/A',
                    'status' => $status,
                    'tester' => $latestAudit->UserTester->name ?? 'N/A',
                    'total_requirements' => $totalRequirements,
                    'total_approved_requirements' => $totalApprovedRequirements,
                    'total_evidence' => $totalEvidence,
                    'total_approved_evidence' => $totalApprovedEvidence,
                    'frameworkId' => $frameworkId,
                    'testNumber' => $testNumber,
                    'control_id' => $control->id,
                ];
            });

            return DataTables::of($data)->make(true);
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }

    public function showDetailsRequirement(Request $request)
    {
        $frameworkId = $request->framework_id;
        $auditId = AuditResponsible::where('framework_id', $frameworkId)
            ->where('test_number_initiated', $request->test_number)
            ->first()
            ->id;

        $controlId = $request->control_id;

        $requirementDetails = FrameworkControlTestAudit::with('controlAuditEvidences.evidence.creator')
            ->where('framework_control_id', $controlId)
            ->where('audit_id', $auditId)
            ->first();
        if (!$requirementDetails) {
            return response()->json([
                'message' => 'No matching requirement details found'
            ], 404);
        }

        // Map evidence details
        $details = $requirementDetails->controlAuditEvidences->map(function ($evidence) {
            return [
                'attach_name' => $evidence->evidence->description ?? 'N/A',
                'created_by' => $evidence->evidence->creator->name ?? 'N/A',
                'evidence_file' => $evidence->evidence->file_name ?? 'N/A',
                'compliance_created_at' => $evidence->created_at ? $evidence->created_at->format('d/m/Y') : 'N/A',
                'compliance_updated_at' => $evidence->updated_at ? $evidence->updated_at->format('d/m/Y') : 'N/A',
                'evidence_id' => $evidence->evidence_id,
                'status' => $evidence->evidence_audit_status ?? 'N/A',
            ];
        });


        return response()->json([
            'frameworkId' => $frameworkId,
            'auditId' => $auditId,
            'controlId' => $controlId,
            'details' => $details
        ]);
    }

    public function viewEvidenceFile($id)
    {
        $evidence = Evidence::find($id);
        if (!$evidence) {
            abort(404);
        }

        $filePath = storage_path('app/' . $evidence->file_unique_name);

        if (!file_exists($filePath)) {
            abort(404);
        }

        $fileMimeType = mime_content_type($filePath);
        $convertedImages = [];

        if (
            str_starts_with($fileMimeType, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') ||
            str_starts_with($fileMimeType, 'application/msword')
        ) {

            // Convert Word to PDF
            $phpWord = IOFactory::load($filePath);
            $pdf = new Dompdf();
            $pdf->loadHtml($phpWord->save('php://output', 'PDF'));
            $pdf->render();

            $pdfOutputPath = storage_path('app/public/word_to_pdf.pdf');
            file_put_contents($pdfOutputPath, $pdf->output());

            // Convert PDF to Images
            $outputFolder = storage_path('app/public/pdf_images');
            if (!is_dir($outputFolder)) {
                mkdir($outputFolder, 0777, true);
            }

            $pdf = new Pdf($pdfOutputPath);
            $pages = $pdf->getNumberOfPages();

            for ($pageNumber = 1; $pageNumber <= $pages; $pageNumber++) {
                $imagePath = $outputFolder . "/page_$pageNumber.jpg";
                $pdf->setPage($pageNumber)->saveImage($imagePath);
                $convertedImages[] = asset('storage/pdf_images/page_' . $pageNumber . '.jpg');
            }
        } elseif ($fileMimeType === 'application/pdf') {
            // Handle PDF files
            $outputFolder = storage_path('app/public/pdf_images');
            if (!is_dir($outputFolder)) {
                mkdir($outputFolder, 0777, true);
            }

            $pdf = new Pdf($filePath);
            $pages = $pdf->getNumberOfPages();

            for ($pageNumber = 1; $pageNumber <= $pages; $pageNumber++) {
                $imagePath = $outputFolder . "/page_$pageNumber.jpg";
                $pdf->setPage($pageNumber)->saveImage($imagePath);
                $convertedImages[] = asset('storage/pdf_images/page_' . $pageNumber . '.jpg');
            }
        }

        return view('admin.content.governance.view-evidence-file', [
            'converted_images' => $convertedImages,
            'file_path' => $filePath,
            'file_mime_type' => $fileMimeType ?? null
        ]);
    }

    public function getDomainInframework(Request $request)
    {
        $frameId = (array) $request->input('frameworkId'); // Ensure it's an array
        // Fetch parent family IDs
        $DomainParentId = DB::table('framework_families')
                            ->whereIn('framework_id', $frameId)
                            ->pluck('parent_family_id')
                            ->toArray();
    
        // Fetch families along with their subdomains (families)
        $families = Family::whereIn('id', $DomainParentId)
                          ->whereNull('parent_id') // Get only top-level families
                          ->with('families') // Include subdomains (families)
                          ->get();
 
        return response()->json($families);
    }
    
    
}
