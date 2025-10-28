<?php

namespace App\Http\Controllers\admin\risk_management;

use App\Exports\RisksExport;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetGroup;
use App\Models\AssetValue;
use App\Models\Category;
use App\Models\CloseReason;
use App\Models\Comment;
use App\Models\Department;
use App\Models\File;
use App\Models\Framework;
use App\Models\FrameworkControl;
use App\Models\FrameworkControlMapping;
use App\Models\Impact;
use App\Models\Likelihood;
use App\Models\Location;
use App\Models\MgmtReview;
use App\Models\Mitigation;
use App\Models\MitigationAcceptUser;
use App\Models\MitigationEffort;
use App\Models\NextStep;
use App\Models\PlanningStrategy;
use App\Models\Project;
use App\Models\ResidualRiskScoringHistory;
use App\Models\Review;
use App\Models\Risk;
use App\Models\RiskFunction;
use App\Models\RiskGrouping;
use App\Models\RiskLevel;
use App\Models\RiskModel;
use App\Models\RiskScoringHistory;
use App\Models\RisksToAsset;
use App\Models\RisksToAssetGroup;
use App\Models\RiskToAdditionalStakeholder;
use App\Models\RiskToLocation;
use App\Models\RiskToTeam;
use App\Models\RiskToTechnology;
use App\Models\ScoringMethod;
use App\Models\Setting;
use App\Models\Source;
use App\Models\Status;
use App\Models\Tag;
use App\Models\Taggable;
use App\Models\Team;
use App\Models\Technology;
use App\Models\ThreatGrouping;
use App\Models\User;
use App\Models\Action;
use App\Events\RiskCreated;
use App\Events\RiskUpdated;
use App\Events\RiskStatus;
use App\Events\RiskClose;
use App\Events\MgmtreviewCreated;
use App\Events\MitigationAcceptUserCreated;
use App\Events\RiskMitigationCreated;
use App\Events\RiskDelete;
use App\Events\RiskMitigationUpdated;
use App\Events\RiskReopen;
use App\Events\RiskResetReviews;
use App\Events\RiskResetMitigation;
use App\Events\RiskUpdateSubject;
use App\Imports\RisksImport;
use App\Models\ContactQuestionnaire;
use App\Models\ContactQuestionnaireAnswer;
use App\Models\ContactQuestionnaireAnswerResult;
use App\Traits\AssetTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Log;

class RiskManagementController extends Controller
{
    use AssetTrait;
    /**
     * Display a dump message for testing
     *
     * @return String
     */
    public function index()
    {
        $riskGroupings = RiskGrouping::with('RiskCatalogs:id,number,name,risk_grouping_id')->get();
        $threatGroupings = ThreatGrouping::with('ThreatCatalogs:id,number,name,threat_grouping_id')->get();
        $categories = Category::all();
        $locations = Location::all();
        $frameworks = Framework::with('FrameworkControls:id,short_name')->get();
        $assets = Asset::select('id', 'name')->orderBy('id')->get();
        $assetGroups = AssetGroup::all();
        $technologies = Technology::all();
        $teams = Team::all();
        $enabledUsers = User::where('enabled', true)->with('manager:id,name,manager_id')->get();
        $departmentManagersIds = Department::pluck('manager_id')->toArray();
        $owners = User::whereIn('id', $departmentManagersIds)->get();
        $reviewers = User::all();
        $tags = Tag::all();
        $riskSources = Source::all();
        $riskScoringMethods = ScoringMethod::all();
        $riskLikelihoods = Likelihood::all();
        $impacts = Impact::all();
        $riskInfo = $this->GetStaticsRisk();
        $statuses = Status::all();
        $planningStrategies = PlanningStrategy::all();
        $projects = Project::all();
        $mitigationEfforts = MitigationEffort::all();
        $mitigationCosts = AssetValue::all();
        $reviews = Review::all();
        $nextSteps = NextStep::all();
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Risk Management')]
        ];

        return view('admin.content.risk_management.index', compact(
            'breadcrumbs',
            'statuses',
            'riskInfo',
            'riskGroupings',
            'threatGroupings',
            'locations',
            'frameworks',
            'assets',
            'assetGroups',
            'categories',
            'technologies',
            'teams',
            'enabledUsers',
            'riskSources',
            'riskScoringMethods',
            'riskLikelihoods',
            'impacts',
            'tags',
            'owners',
            'reviewers',
            'projects',
            'mitigationEfforts',
            'mitigationCosts',
            'assetGroups',
            'planningStrategies',
            'reviews',
            'nextSteps',
        ));
    }


    private function GetStaticsRisk()
    {
        // Retrieve the risk counts for each status
        $risk = Risk::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get()
            ->keyBy('status');  // Key by 'status' so you can access them by status directly

        // Total count of all risks
        $totalRisks = Risk::count();

        // Prepare the risk information array with percentages
        $openRisk = ($risk->get('Reopened')->count ?? 0) + ($risk->get('New')->count ?? 0);
        $closedRisk = $risk->get('Closed')->count ?? 0;
        $mitigatedRisk = $risk->get('Mitigation Planned')->count ?? 0;

        return [
            'openRisk' => [
                'count' => $openRisk,
                'percentage' => $totalRisks > 0 ? round(($openRisk / $totalRisks) * 100, 2) : 0,
            ],
            'closedRisk' => [
                'count' => $closedRisk,
                'percentage' => $totalRisks > 0 ? round(($closedRisk / $totalRisks) * 100, 2) : 0,
            ],
            'MitigatedRisk' => [
                'count' => $mitigatedRisk,
                'percentage' => $totalRisks > 0 ? round(($mitigatedRisk / $totalRisks) * 100, 2) : 0,
            ],
            'overview' => $totalRisks,
        ];
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function configure()
    {
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.risk_management.index'), 'name' => __('locale.Risk Management')],
            ['name' => __('locale.Configure')]
        ];

        $risk_groupings = RiskGrouping::all();
        $risk_functions = RiskFunction::all();
        $threat_groupings = ThreatGrouping::all();

        $addValueTables = [
            // TableName => Language key
            'risk_levels' => 'RiskLevels',
            'reviews' => 'Review',
            'categories' => 'RiskCategory',
            'technologies' => 'Technology',
            'planning_strategies' => 'RiskPlanningStrategy',
            'close_reason' => 'CloseReason',
            'mitigation_efforts' => 'MitigationEffort',
            'risk_groupings' => 'RiskGrouping',
            'risk_functions' => 'RiskFunctions',
            'sources' => 'RiskSource',
            'threat_groupings' => 'ThreatGroupings',
            'risk_catalogs' => 'RiskCatalog',
            'threat_catalogs' => 'ThreatCatalog',

        ];

        return view('admin.content.configure.Add_Values', compact('breadcrumbs', 'risk_groupings', 'risk_functions', 'threat_groupings', 'addValueTables'));
    }
    public function store(Request $request)
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
            'risk_description' => ['nullable', 'string'],
            'supporting_documentation' => ['nullable', 'array'],
            'supporting_documentation.*' => ['nullable', 'file'],
        ]);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('risk.ThereWasAProblemAddingTheRisk') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {

            // Limit the subject's length
            $alert = false;
            $maxlength = Setting::where('name', 'maximum_risk_subject_length')->first()['value'];
            if (strlen($request->subject) > $maxlength) {
                $alert = __('risk.RiskSubjectTruncated', ['limit' => $maxlength]);
                $request->subject = substr($request->subject, 0, $maxlength);
            }

            DB::beginTransaction();

            try {
                $additionalNotes = $request->additional_notes;
                $risk = Risk::create([
                    'status' => $request->has('status') ? $request->input('status') : 'New',
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
                    'submitted_by' => $request->has('submitted_by') ? $request->input('submitted_by') : auth()->id() ?? 1,
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
                                'message' => __('risk.ThereWasAProblemAddingTheRisk') . "<br>" . __('locale.Validation error'),
                            );

                            return response()->json($response, 422);
                        }
                    }
                }
                // File upload End
                if ($request->mitigation_option == "PlanAMitigation") {
                    $this->updateRiskMitigation($request, $risk);
                }
                if ($request->review_option == "PerformAReview") {
                    $this->addRiskReview($request, $risk);
                }
                DB::commit();
                event(new RiskCreated($risk));

                $message = __('risk.A New Risk Added with name') . ' "' . ($risk->subject ?? __('locale.[No Risk Name]')) . '" ' . __('CreatedBy') . ' "' . auth()->user()->name . '".';
                write_log($risk->id, auth()->id(), $message);
                $response = array(
                    'status' => true,
                    'alert' => $alert,
                    // 'message' => __('locale.RiskWasAddedSuccessfully'),
                    'redirect_to' => route('admin.risk_management.show', $risk->id),
                    'message' => __('risk.RiskSubmitSuccess', ["subject" => $request->subject]),

                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                dd($th);
                DB::rollBack();
                Storage::deleteDirectory('risk/' . $risk->id);

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        $risk = Risk::with(['tags', 'riskScoring', 'locations', 'teams', 'technologies', 'additionalStakeholders', 'category', 'control', 'framework', 'risksToAsset', 'risksToAssetGroup', 'source', 'submittedBy:id,name'])->findOrFail($id);
        if (!auth()->user()->hasPermission('riskmanagement.all')) {
            $riskTeams = $risk->teams->pluck('team_id')->toArray();
            $riskStakeholders = $risk->additionalStakeholders->pluck('user_id')->toArray();
            if (isDepartmentManager()) {
                $departmentId = (Department::where('manager_id', auth()->id())->first())->id;
                $departmentMembers =  User::with('teams')->where('department_id', $departmentId)->orWhere('id', auth()->id())->get();
                $departmentMembersIds =  $departmentMembers->pluck('id')->toArray();
                $departmentTeams = [];
                foreach ($departmentMembers as $departmentMember) {
                    $departmentTeams = array_merge($departmentTeams, $departmentMember->teams->pluck('id')->toArray());
                }
                if (!in_array($risk['owner_id'], $departmentMembersIds) && !in_array($risk['submitted_by'], $departmentMembersIds) && !array_intersect($departmentMembersIds, $riskStakeholders) && !array_intersect($departmentTeams, $riskTeams)) {
                    abort(403, 'Unauthorized');
                }
            } else {
                $loggedUserTeams = User::with('teams')->find(auth()->id())->teams->pluck('id')->toArray();
                if ($risk['owner_id'] != auth()->id() && $risk['submitted_by'] != auth()->id() && !in_array(auth()->id(), $riskStakeholders) && !array_intersect($loggedUserTeams, $riskTeams)) {
                    abort(403, 'Unauthorized');
                }
            }
        }
        $planningStrategies = PlanningStrategy::all();
        $projects = Project::all();
        $mitigationEfforts = MitigationEffort::all();
        $mitigationCosts = AssetValue::all();
        $riskGroupings = RiskGrouping::with('RiskCatalogs:id,number,name,risk_grouping_id')->get();
        $threatGroupings = ThreatGrouping::with('ThreatCatalogs:id,number,name,threat_grouping_id')->get();
        $categories = Category::all();
        $locations = Location::all();
        $frameworks = Framework::with('FrameworkControls:id,short_name,control_number')->get();
        $assets = Asset::select('id', 'name')->orderBy('id')->get();
        $assetGroups = AssetGroup::all();
        $technologies = Technology::all();
        $teams = Team::all();
        $enabledUsers = User::where('enabled', true)->with('manager:id,name,manager_id')->get();
        if (isDepartmentManager()) {
            $departmentId = (Department::where('manager_id', auth()->id())->first())->id;
            $owners = User::where('department_id', $departmentId)->orWhere('id', auth()->id())->get();
        } else {
            $departmentManagersIds = Department::pluck('manager_id')->toArray();
            $owners = User::whereIn('id', $departmentManagersIds)->get();
        }
        $tags = Tag::all();
        $riskSources = Source::all();
        $riskScoringMethods = ScoringMethod::all();
        $riskLikelihoods = Likelihood::all();
        $impacts = Impact::all();
        $reviews = Review::all();
        $nextSteps = NextStep::all();
        $closeReasons = CloseReason::all();
        $statuses = Status::all();

        // Get risk framework Controls
        $frameworkControls = [];


        if ($risk->framework)
            $frameworkControls = $risk->framework->FrameworkControls->toArray() ?? [];
        $frameworkControls = array_map(function ($frameworkControl) {
            return [
                "id" => $frameworkControl['id'],
                "short_name" => $frameworkControl['short_name'],
                "control_number" => $frameworkControl['control_number'],
            ];
        }, $frameworkControls);
        $data = $risk->toArray();

        $data['files'] = File::where('risk_id', $id)->where('view_type', '=', 1)->get()->toArray();

        $data['framework_controls'] = $frameworkControls;
        unset($frameworkControls);

        // Get tags
        $tagIds = array_map(function ($tag) {
            return $tag['id'];
        }, $data['tags']);
        $data['tag_ids'] = $tagIds;
        $data['riskCatalogs'] = $risk->riskCatalogs();
        $data['threatCatalogs'] = $risk->threatCatalog();
        if (isset($data['control']))
            $data['control'] = ['id' => $data['control']['id'], 'short_name' => $data['control']['short_name']];
        if (isset($data['framework']))
            $data['framework'] = ['id' => $data['framework']['id'], 'name' => $data['framework']['name']];

        // Get locations
        $locationIds = array_map(function ($location) {
            return $location['location_id'];
        }, $data['locations']);
        $data['locations'] = Location::whereIn('id', $locationIds)->select('id', 'name')->get()->toArray();
        $data['location_ids'] = $locationIds;
        // Get technologies
        $technologyIds = array_map(function ($technology) {
            return $technology['technology_id'];
        }, $data['technologies']);
        $data['technologies'] = Technology::whereIn('id', $technologyIds)->select('id', 'name')->get()->toArray();
        $data['technology_ids'] = $technologyIds;

        // Get teams
        $teamIds = array_map(function ($team) {
            return $team['team_id'];
        }, $data['teams']);
        $data['teams'] = Team::whereIn('id', $teamIds)->select('id', 'name')->get()->toArray();
        $data['team_ids'] = $teamIds;

        // Get additional_stakeholders
        $additionalStakeholderIds = array_map(function ($additionalStakeholder) {
            return $additionalStakeholder['user_id'];
        }, $data['additional_stakeholders']);
        $data['additional_stakeholders'] = User::whereIn('id', $additionalStakeholderIds)->select('id', 'name')->get()->toArray();
        $data['additionalStakeholder_ids'] = $additionalStakeholderIds;

        // Get owner
        $owner = User::where('id', $risk->owner_id)->select('id', 'name', 'manager_id')->first();
        if ($owner) {
            $data['owner'] = $owner->toArray();
            if ($owner->manager && $risk->manager_id)
                $data['owner_manager'] = $owner->manager()->select('id', 'name')->first()->toArray() ?? [];
            else
                $data['owner_manager'] = [];
        } else
            $data['owner'] = $data['owner_manager'] = '';

        $risksToAsset = RisksToAsset::where('risk_id', $risk->id)->pluck('asset_id')->toArray();
        $risksToAssetGroup = RisksToAssetGroup::where('risk_id', $risk->id)->pluck('asset_group_id')->toArray();
        $data['assets'] = Asset::whereIn('id', $risksToAsset)->select('id', 'name')->get()->toArray();
        $data['assetGroups'] = AssetGroup::whereIn('id', $risksToAssetGroup)->select('id', 'name')->get()->toArray();
        $data['asset_ids'] = array_map(function ($asset) {
            return $asset['id'];
        }, $data['assets']);
        $data['assetGroup_ids'] = array_map(function ($assetGroup) {
            return $assetGroup['id'];
        }, $data['assetGroups']);


        $data['submitted_by'] = $risk->submittedBy->toArray();
        $data['likelihood'] = Likelihood::where('id', $data['risk_scoring']['CLASSIC_likelihood'])->first()->toArray();
        $data['impact'] = Impact::where('id', $data['risk_scoring']['CLASSIC_impact'])->first()->toArray();
        $data['calculated_risk'] = $data['risk_scoring']['calculated_risk'];
        $data['risk_scoring'] = ScoringMethod::where('id', $data['risk_scoring']['scoring_method'])->first()->toArray();
        $data['calculated_risk_data'] = $this->getRiskValueData($data['calculated_risk']);

        // Residual Risk
        $data['residual_risk'] = "0.0";
        if ($data['calculated_risk'] && $data['calculated_risk'] != "0.0")
            $data['residual_risk'] = get_residual_risk($risk->id);
        $data['residual_risk_data'] = $this->getRiskValueData($data['residual_risk']);
        $data['comments'] = Comment::where('risk_id', $risk->id)->with('user:id,name')->orderBy('date', 'desc')->get()->toArray();
        $data['currentRiskModel'] = RiskModel::where('id', get_setting('risk_model'))->first()->name ?? '';
        $data['logs'] = get_audit_trail($id, 36500, ['risk', 'jira']);

        // Get the mitigation for the risk
        $mitigation = get_mitigation_by_id($id);

        $data['_mitigation'] = json_decode(json_encode($mitigation[0] ?? []), true);

        // // If a mitigation exists for the risk
        if ($mitigation == true) {
            // Set the mitigation values
            $data['mitigation']['planning_strategy_id'] = $data['_mitigation']['planning_strategy'];
            $data['mitigation']['mitigation_effort_id'] = $data['_mitigation']['mitigation_effort'];
            $data['mitigation']['mitigation_cost_id'] = $data['_mitigation']['mitigation_cost'];
            $data['mitigation']['mitigation_owner_id'] = $data['_mitigation']['mitigation_owner'];
            $data['mitigation']['team_ids'] = explode(',', $data['_mitigation']['mitigation_team']);
            $data['mitigation']['mitigation_control_ids'] = explode(',', $data['_mitigation']['mitigation_controls']);

            $data['mitigation']['mitigation_id'] = $data['_mitigation']['mitigation_id'];
            $data['mitigation']['mitigation_date'] = format_date($data['_mitigation']['submission_date']);
            $data['mitigation']['planning_strategy'] = $data['_mitigation']['planning_strategy_name'];
            $data['mitigation']['mitigation_effort'] = $data['_mitigation']['mitigation_effort_name'];
            $data['mitigation']['mitigation_cost'] = get_asset_value_by_id($data['_mitigation']['mitigation_cost']);
            $data['mitigation']['mitigation_owner'] = $data['_mitigation']['mitigation_owner_name'];
            $data['mitigation']['mitigation_team'] = json_decode(json_encode(get_names_by_multi_values("teams", $data['_mitigation']['mitigation_team']) ?? []), true);;
            $data['mitigation']['current_solution'] = $data['_mitigation']['current_solution'];
            $data['mitigation']['security_requirements'] = $data['_mitigation']['security_requirements'];
            $data['mitigation']['security_recommendations'] = $data['_mitigation']['security_recommendations'];
            $data['mitigation']['planning_date'] = format_date($data['_mitigation']['planning_date']);
            $data['mitigation']['mitigation_percent'] = $data['_mitigation']['mitigation_percent'];
            $data['mitigation']['mitigation_controls'] = isset($data['_mitigation']['mitigation_controls']) ? $data['_mitigation']['mitigation_controls'] : "";

            $data['mitigation']['accepted_mitigations'] = get_accepted_mitigations($id);

            // Get accepted mitigation by login user
            $data['mitigation']['user_accepted_mitigations'] = get_accepted_mitigations($id, true);

            $data['mitigation']['files'] = File::where('risk_id', $id)->where('view_type', '=', 2)->get()->toArray();
        }
        // Otherwise
        else {
            // Set the values to empty
            $data['mitigation']['mitigation_id'] = "";
            $data['mitigation']['mitigation_date'] = "N/A";
            $data['mitigation']['planning_strategy'] = "";
            $data['mitigation']['mitigation_effort'] = "";
            $data['mitigation']['mitigation_cost'] = "";
            $data['mitigation']['mitigation_owner'] = $data['owner_id'];;
            $data['mitigation']['mitigation_team'] = $data['teams'];
            $data['mitigation']['current_solution'] = "";
            $data['mitigation']['security_requirements'] = "";
            $data['mitigation']['security_recommendations'] = "";
            $data['mitigation']['planning_date'] = "";
            $data['mitigation']['mitigation_percent'] = 0;
            $data['mitigation']['mitigation_percent'] = "";

            $data['mitigation']['accepted_mitigations'] = [];
            $data['mitigation']['files'] = [];
        }
        unset($data['_mitigation']);

        // Get the management last review for the risk
        $data['_lastMgmtReviews'] = get_review_by_id($id);

        // If a review exists for this risk
        if ($data['_lastMgmtReviews']) {
            // Set the review values
            $data['lastMgmtReviews']['review_date'] = $data['_lastMgmtReviews']['submission_date'];
            $data['lastMgmtReviews']['review_date'] = date(get_default_datetime_format("g:i A T"), strtotime($data['lastMgmtReviews']['review_date']));

            $data['lastMgmtReviews']['review'] = Review::where('id', $data['_lastMgmtReviews']['review'])->pluck('name')->first();
            $data['lastMgmtReviews']['review_id'] = $data['_lastMgmtReviews']['id'];
            $data['lastMgmtReviews']['next_step'] = NextStep::where('id', $data['_lastMgmtReviews']['next_step_id'])->pluck('name')->first();
            $data['lastMgmtReviews']['next_step_id'] = $data['_lastMgmtReviews']['next_step_id'];
            $data['lastMgmtReviews']['next_review'] = $data['_lastMgmtReviews']['next_review'];

            // If next_review_date_uses setting is Residual Risk.
            $riskLevel = get_risk_level_name($data['calculated_risk']);
            $residualRiskLevel = get_risk_level_name($data['residual_risk']);
            if (get_setting('next_review_date_uses') == "ResidualRisk") {
                $data['lastMgmtReviews']['next_review'] = next_review($residualRiskLevel, $id, $data['lastMgmtReviews']['next_review'], false);
            }
            // If next_review_date_uses setting is Inherent Risk.
            else {
                $data['lastMgmtReviews']['next_review'] = next_review($riskLevel, $id, $data['lastMgmtReviews']['next_review'], false);
            }

            $data['lastMgmtReviews']['reviewer'] = User::where('id', $data['_lastMgmtReviews']['reviewer'])->pluck('name')->first();
            $data['lastMgmtReviews']['comments'] = $data['_lastMgmtReviews']['comments'];

            $data['lastMgmtReviews']['project'] = '';
            if ($data['lastMgmtReviews']['next_step_id'] == 2) { // Consider for Project
                $project = get_project_by_risk_id($id);
                $project_name = $project ? $project['name'] : __('risk.UnassignedRisks');
                if ($project_name) {
                    $data['lastMgmtReviews']['project'] = $project_name;
                }
            }
        } else
        // Otherwise
        {
            // Set the values to empty
            $data['lastMgmtReviews']['review_date'] = "N/A";
            $data['lastMgmtReviews']['review'] = "";
            $data['lastMgmtReviews']['review_id'] = "";
            $data['lastMgmtReviews']['next_step'] = "";
            $data['lastMgmtReviews']['next_step_id'] = "";
            $data['lastMgmtReviews']['next_review'] = "";
            $data['lastMgmtReviews']['reviewer'] = "";
            $data['lastMgmtReviews']['comments'] = "";
            $data['lastMgmtReviews']['project'] = '';
        }
        unset($data['_lastMgmtReviews']);

        // Get the management reviews for the risk
        $data['_mgmtReviews'] = get_reviews($id);
        $data['mgmtReviews'] = [];

        foreach ($data['_mgmtReviews'] as $key => $mgmtReview) {
            // Set the review values
            $data['mgmtReviews'][$key]['review_date'] = $mgmtReview['submission_date'];
            $data['mgmtReviews'][$key]['review_date'] = date(get_default_datetime_format("g:i A T"), strtotime($data['mgmtReviews'][$key]['review_date']));

            $data['mgmtReviews'][$key]['review'] = Review::where('id', $mgmtReview['review'])->pluck('name')->first();
            $data['mgmtReviews'][$key]['review_id'] = $mgmtReview['id'];
            $data['mgmtReviews'][$key]['next_step'] = NextStep::where('id', $mgmtReview['next_step_id'])->pluck('name')->first();
            $data['mgmtReviews'][$key]['next_step_id'] = $mgmtReview['next_step_id'];
            $data['mgmtReviews'][$key]['next_review'] = $mgmtReview['next_review'];

            // If next_review_date_uses setting is Residual Risk.
            $riskLevel = get_risk_level_name($data['calculated_risk']);
            $residualRiskLevel = get_risk_level_name($data['residual_risk']);
            if (get_setting('next_review_date_uses') == "ResidualRisk") {
                $data['mgmtReviews'][$key]['next_review'] = next_review($residualRiskLevel, $id, $data['mgmtReviews'][$key]['next_review'], false);
            }
            // If next_review_date_uses setting is Inherent Risk.
            else {
                $data['mgmtReviews'][$key]['next_review'] = next_review($riskLevel, $id, $data['mgmtReviews'][$key]['next_review'], false);
            }

            $data['mgmtReviews'][$key]['reviewer'] = User::where('id', $mgmtReview['reviewer'])->pluck('name')->first();
            $data['mgmtReviews'][$key]['comments'] = $mgmtReview['comments'];

            $data['mgmtReviews'][$key]['project'] = '';
            if ($mgmtReview['next_step_id'] == 2) { // Consider for Project
                $project = get_project_by_risk_id($id);
                $project_name = $project ? $project['name'] : __('risk.UnassignedRisks');
                if ($project_name) {
                    $data['mgmtReviews'][$key]['project'] = $project_name;
                }
            }
        }

        unset($data['_mgmtReviews']);

        $data['get_next_review_default'] = get_next_review_default($id);

        // dd($data);

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.risk_management.index'), 'name' => __('locale.Risk Management')],
            ['name' =>  $risk->subject]
        ];
        return view('admin.content.risk_management.show', compact('breadcrumbs', 'riskGroupings', 'threatGroupings', 'locations', 'frameworks', 'assets', 'assetGroups', 'categories', 'technologies', 'teams', 'enabledUsers', 'riskSources', 'riskScoringMethods', 'riskLikelihoods', 'impacts', 'tags', 'planningStrategies', 'mitigationEfforts', 'mitigationCosts', 'projects', 'reviews', 'nextSteps', 'closeReasons', 'statuses', 'data', 'owners'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $risk = Risk::find($request->id);
        $responseReload = false;

        if ($risk) {
            // Validation rules
            $validator = Validator::make($request->all(), [
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
                'risk_description' => ['nullable', 'string'],
                'supporting_documentation' => ['nullable', 'array'],
                'supporting_documentation.*' => ['nullable', 'file'],
            ]);

            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('risk.ThereWasAProblemUpdatingTheRisk') . "<br>" . __('locale.Validation error'),
                    'reload' => $responseReload,
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();
                $uploadfilePaths = [];
                try {
                    // Get current datetime for last_update
                    $current_datetime = date('Y-m-d H:i:s');

                    $submissionDate = $request->submission_date;

                    if ($submissionDate) {
                        $submissionDate = get_standard_date_from_default_format($submissionDate);
                        if ($risk) {
                            $existing_submission_date = date('Y-m-d', strtotime($risk->submission_date));
                            if ($existing_submission_date == $submissionDate) $submissionDate = $risk->submission_date;
                        }
                    } elseif ($submissionDate == "") {
                        $submissionDate = $current_datetime;
                    }
                    $fields = [
                        'reference_id' => 'reference_id',
                        'framework_id' => 'regulation',
                        'control_id' => 'control_id',
                        'risk_source_id' => 'source_id',
                        'category_id' => 'category_id',
                        'owner_id' => 'owner_id',
                        'owner_manager_id' => 'manager_id',
                        'risk_assessment' => 'assessment', // try_encrypt customization_extra
                        'additional_notes' => 'notes', // try_encrypt customization_extra
                        'risk_description' => 'risk_description',
                        'risk_catalog_mapping_id' => 'risk_catalog_mapping',
                        'threat_catalog_mapping_id' => 'threat_catalog_mapping',
                        'template_group_id' => 'template_group_id'
                    ];

                    // Loop through the fields to populate $basicData if they exist in the request
                    foreach ($fields as $requestKey => $basicDataKey) {
                        if ($request->has($requestKey)) {
                            // If the key requires special handling (like array imploding), handle it here
                            if (in_array($requestKey, ['risk_catalog_mapping_id', 'threat_catalog_mapping_id'])) {
                                $basicData[$basicDataKey] = implode(",", $request->$requestKey);
                            } else {
                                $basicData[$basicDataKey] = $request->$requestKey;
                            }
                        }
                    }

                    // Handle additional cases like submission_date (where it's not part of the request, but still may need to be set)
                    if (isset($submissionDate)) {
                        $basicData['submission_date'] = $submissionDate;
                    }
                    // If the request does NOT have `risk_catalog_mapping_id` or `threat_catalog_mapping_id`, set them to null
                    if (isset($request->first_edit) && $request->first_edit == 1) {
                        if (!$request->has('threat_catalog_mapping_id')) {
                            $basicData['threat_catalog_mapping'] = null; 
                        }
                        if (!$request->has('risk_catalog_mapping_id')) {
                            $basicData['risk_catalog_mapping'] = null; 
                        }
                    
                       
                    }
 
                    $updated_fields = [];

                    // Log array for changes
                    foreach ($basicData as $key => $value) {
                        
                        // find updated field
                        if ($key == "assessment" || $key == "notes") {
                            if ($value != $risk[$key]) {
                                $updated_fields[$key]["original"] = $risk[$key];
                                $updated_fields[$key]["updated"] = $value;
                            }
                        } else if ($value != $risk[$key] && $key != "last_update") {
                            switch ($key) {
                                default:
                                    $original_value = $risk[$key];
                                    $updated_value = $value;
                                    break;
                                case "source_id":
                                    $original_value = $risk->source->name ?? '';
                                    $updated_value = Source::where('id', $request->risk_source_id)->pluck('name')->first();
                                    break;
                                case "category_id":
                                    $original_value = $risk->category->name ?? '';
                                    $updated_value = Category::where('id', $request->category_id)->pluck('name')->first();
                                    break;
                                case "regulation":
                                    $original_value = $risk->framework->name ?? '';
                                    $updated_value = Framework::where('id', $request->framework_id)->pluck('name')->first();
                                    break;
                                case "control_id":
                                    $original_value = ($risk->control->short_name ?? '') . ' (' . ($risk->control->control_number ?? '') . ')';
                                    $frameworkControl = FrameworkControl::where('id', $request->control_id)->select('short_name', 'control_number')->first();
                                    $updated_value = ($frameworkControl->short_name ?? '') . ' (' . ($frameworkControl->control_number ?? '') . ')';
                                    break;
                                case "owner_id":
                                    $original_value = $risk->owner->name ?? '';
                                    $updated_value = User::where('id', $request->owner_id)->pluck('name')->first();
                                    break;
                                case "manager_id":
                                    $original_value = $risk->framework->name ?? '';
                                    $updated_value = User::where('id', $request->owner_manager_id)->pluck('name')->first();
                                    break;
                            }
                            
                            $updated_fields[$key]["original"] = $original_value;
                            $updated_fields[$key]["updated"] = $updated_value;
                        }
                    }

                    // Start updating basic risk data
                    Risk::where('id', $request->id)->update($basicData);

                    // Start saving locations
                    if ($request->has('location_id')) {
                        $currentLocations = $risk->locations()->pluck('location_id')->toArray();

                        // Delete locations that are not in the request
                        $risk->locations()->whereNotIn('location_id', $request->location_id)->delete();

                        // Get new locations that are not in the database
                        $newLocations = array_diff($request->location_id, $currentLocations);

                        // Insert new locations in bulk
                        $risk->locations()->insert(
                            array_map(fn($id) => ['location_id' => $id, 'risk_id' => $risk->id], $newLocations)
                        );
                    } elseif ($request->first_edit == 1 && !$request->has('location_id')) {
                        $risk->locations()->delete();
                    }

                    // End saving locations

                    // Start saving teams
                    if ($request->has('team_id')) {
                        $currentTeams = $risk->teams()->pluck('team_id')->toArray();

                        // Delete teams that are not in the request
                        $risk->teams()->whereNotIn('team_id', $request->team_id)->delete();

                        // Get new teams that are not in the database
                        $newTeams = array_diff($request->team_id, $currentTeams);

                        // Insert new teams in bulk
                        $risk->teams()->insert(
                            array_map(fn($id) => ['team_id' => $id, 'risk_id' => $risk->id], $newTeams)
                        );
                    } elseif ($request->first_edit == 1 && !$request->has('team_id')) {
                        $risk->teams()->delete();
                    }
                    // End saving teams

                    // Start saving technologies
                    if ($request->has('technology_id')) {
                        $currenttechnologies = $risk->technologies()->pluck('technology_id')->toArray();
                        $deletedtechnologies = array_diff($currenttechnologies ?? [], $request->technology_id ?? []);
                        $addedtechnologies = array_diff($request->technology_id ?? [], $currenttechnologies ?? []);

                        // Delete deleted location
                        $risk->technologies()->whereIn('technology_id', $deletedtechnologies)->delete();

                        // Add added technologies
                        foreach ($addedtechnologies ?? [] as $technology_id) {
                            $risk->technologies()->create([
                                'technology_id' => $technology_id,
                            ]);
                        }
                    } elseif ($request->second_edit == 2 && !$request->has('technology_id')) {
                        $risk->technologies()->delete();
                    }
                    // End saving technologies
                    // Start saving additionalStakeholders
                    if ($request->has('additional_stakeholder_id')) {
                        $currentadditionalStakeholders = $risk->additionalStakeholders()->pluck('user_id')->toArray();
                        $deletedadditionalStakeholders = array_diff($currentadditionalStakeholders ?? [], $request->additional_stakeholder_id ?? []);
                        $addedadditionalStakeholders = array_diff($request->additional_stakeholder_id ?? [], $currentadditionalStakeholders ?? []);

                        // Delete deleted location
                        $risk->additionalStakeholders()->whereIn('user_id', $deletedadditionalStakeholders)->delete();

                        // Add added additionalStakeholders
                        foreach ($addedadditionalStakeholders ?? [] as $user_id) {
                            $risk->additionalStakeholders()->create([
                                'user_id' => $user_id,
                            ]);
                        }
                    } elseif ($request->first_edit == 1 && !$request->has('additional_stakeholder_id')) {
                        $risk->additionalStakeholders()->delete();
                    }
                    // End saving additionalStakeholders

                    // Start saving tags
                    if ($request->has('tags')) {
                        $currentTags = $risk->tags()->pluck('id')->toArray();
                        $deletedTags = array_diff($currentTags ?? [], $request->tags ?? []);
                        $addedTags = array_diff($request->tags ?? [], $currentTags ?? []);

                        // Delete deleted tags
                        $risk->tags()->detach($deletedTags);

                        $allAssetTags = Tag::whereIn('id', $addedTags ?? [])->get();

                        // Logic for getting tags that aren't referenced by the junction table
                        $tagsFoundedForOtherRecords = Taggable::whereIn('tag_id', $currentTags)->pluck('tag_id')->toArray();
                        $deletedAssetTagIds = array_diff($currentTags, $tagsFoundedForOtherRecords);

                        // Clean up every tags that aren't referenced by the junction table
                        Tag::whereIn('id', $deletedAssetTagIds)->delete();

                        // Add added tags
                        $risk->tags()->saveMany($allAssetTags);

                        $tag_changes = [];
                        if ($addedTags || $deletedTags) {
                            if ($addedTags)
                                $tag_changes[] = __(
                                    'risk.TagUpdateAuditLogAdded',
                                    ['tags_added' => '[' . implode(", ", $addedTags) . ']']
                                );
                            if ($deletedTags)
                                $tag_changes[] = __(
                                    'risk.TagUpdateAuditLogRemoved',
                                    ['tags_removed' => '[' . implode(", ", $deletedTags) . ']']
                                );

                            $message =  __(
                                'risk.TagUpdateAuditLog',
                                [
                                    'user' => auth()->user()->name,
                                    'type' => __('locale.TagType_risk'),
                                    'id' => ($risk->id + 1000),
                                    'tags_from' => implode(", ", $currentTags),
                                    'tags_to' => implode(", ", $request->tags ?? []),
                                    'tag_changes' => implode(", ", $tag_changes)
                                ]
                            );
                            write_log($risk->id, auth()->id(), $message);
                        }
                    } elseif ($request->first_edit == 1 && !$request->has('tags')) {
                        $risk->tags()->delete();
                    }
                    // End saving tags
                    // Start Process the data from the Affected Assets widget
                    if ($request->has('affected_asset_id')) {
                        $this->processSelectedAssetsAssetGroupsOfType($risk->id, $request->affected_asset_id, 'risk');
                    } elseif ($request->second_edit == 2 && !$request->has('affected_asset_id')) {
                        // Delete related records in RisksToAsset and RisksToAssetGroup tables
                        RisksToAsset::where('risk_id', $risk->id)->delete();
                        RisksToAssetGroup::where('risk_id', $risk->id)->delete();
                    }
                    // End Process the data from the Affected Assets widget


                    // Audit log
                    if (count($updated_fields)) {
                        $detail_updated = [];
                        foreach ($updated_fields as $key => $value) {
                            if (!in_array($key, ['reference_id']) && preg_match('{(\w+)_id}', $key, $matches)) {
                                $key = $matches[1];
                            }
                            $detail_updated[] = "Field name : `" . $key . "` (`" . $value["original"] . "`=>`" . $value["updated"] . "`)";
                        }
                        $updated_string = implode(", ", $detail_updated);
                    } else {
                        $updated_string = "";
                    }
                    $message = __("risk.Risk details were updated for risk ID") . " \"" . ($risk->id + 1000) . "\" " . __("locale.CreatedBy") . " \"" . auth()->user()->name . "\".\n" . $updated_string;
                    write_log($risk->id, auth()->id(), $message);

                    // File upload Start
                    if ($request->hasFile('supporting_documentation')) {
                        foreach ($request->file('supporting_documentation') as $supporting_documentation) {
                            if ($supporting_documentation->isValid()) {
                                $path = $supporting_documentation->store('risk/' . $risk->id);
                                $uploadfilePaths[] = $path;
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
                                foreach ($uploadfilePaths as $uploadfilePath) {
                                    Storage::delete($uploadfilePath);
                                }
                                $response = array(
                                    'status' => false,
                                    'errors' => ['supporting_documentation' => ['There were problems uploading the files']],
                                    'message' => __('risk.ThereWasAProblemAddingTheRisk') . "<br>" . __('locale.Validation error'),
                                );

                                return response()->json($response, 422);
                            }
                        }
                    }
                    // File upload End

                    // End updating basic risk data

                    // Start Submit risk scoring

                    // Get old calculated risk
                    $oldCalculatedRisk = get_calculated_risk_by_id($risk->id);
                    $calculatedRisk = null;
                    if ($request->filled(['current_impact_id', 'current_likelihood_id'])) {
                        $calculatedRisk = calculate_risk($request->current_impact_id, $request->current_likelihood_id);

                        $risk->riskScoring()->update([
                            'calculated_risk' => $calculatedRisk,
                            'CLASSIC_likelihood' => $request->current_likelihood_id,
                            'CLASSIC_impact' => $request->current_impact_id,
                        ]);
                    }

                    $responseMessage = __('risk.Risk scoring has no change');
                    $responseReload = false;

                    // If risk score was changed
                    if ($oldCalculatedRisk !== $calculatedRisk && $calculatedRisk !== null) {
                        // Add risk scoring history
                        add_risk_scoring_history($risk->id, $calculatedRisk);

                        // Add residual risk scoring history
                        $residual_risk = get_residual_risk($risk->id);
                        if ($residual_risk !== null) {
                            add_residual_risk_scoring_history($risk->id, $residual_risk);
                        }

                        // Audit log
                        $message = __("risk.Risk score has been updated for risk ID") . " \"" . ($risk->id + 1000) . "\" " . __("locale.CreatedBy") . " \"" . auth()->user()->name . "\".";
                        write_log($risk->id, auth()->id(), $message);

                        $responseMessage = __('risk.Risk score updated successfully');
                        $responseReload = true;
                    }
                    // End Submit risk scoring
                    // throw new Exception("Error Processing Request", 1);

                    $responseReload = true;

                    DB::commit();
                    event(new RiskUpdated($risk));


                    $response = array(
                        'status' => true,
                        'message' => __('risk.RiskWasUpdatedSuccessfully'),
                        'reload' => $responseReload,
                    );
                    return response()->json($response, 200);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    foreach ($uploadfilePaths as $uploadfilePath) {
                        Storage::delete($uploadfilePath);
                    }
                    $response = array(
                        'status' => false,
                        'errors' => [],
                        // 'message' => $th->getLine(),
                        'message' => __('locale.Error'),
                        'reload' => $responseReload
                    );
                    return response()->json($response, 502);
                }
            }
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404'),
                'reload' => $responseReload,
            );
            return response()->json($response, 404);
        }
    }

    /**
     * Update the subject specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRiskSubject(Request $request)
    {
        $risk = Risk::find($request->id);
        if ($risk) {
            $validator = Validator::make($request->all(), [
                'subject' => ['required'],
            ]);

            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('risk.ThereWasAProblemUpdatingTheRisk') . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                // Limit the subject's length
                $alert = false;
                $maxlength = Setting::where('name', 'maximum_risk_subject_length')->first()['value'];
                if (strlen($request->subject) > $maxlength) {
                    $alert = __('risk.RiskSubjectTruncated', ['limit' => $maxlength]);
                    $request->subject = substr($request->subject, 0, $maxlength);
                }
                DB::beginTransaction();
                try {
                    $risk = Risk::where('id', $request->id)->first();
                    $risk->update(['subject' => $request->subject,]);
                    // Audit log
                    $message = __("risk.Risk subject was updated for risk ID") . " \"" . ($risk->id + 1000) . "\" " . __("locale.CreatedBy") . " \"" . auth()->user()->name . "\".";

                    write_log($risk->id, auth()->id(), $message);

                    DB::commit();
                    event(new RiskUpdateSubject($risk));


                    $response = array(
                        'status' => true,
                        'reload' => true,
                        'alert' => $alert,
                        'data' => ['subject' => $request->subject],
                        'message' => __('risk.The mitigation has been successfully modified'),
                    );
                    return response()->json($response, 200);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    $response = array(
                        'status' => false,
                        'errors' => [],
                        // 'message' => $th->getMessage(),
                        'message' => __('locale.ThereAreUnexpectedProblems')
                    );
                    return response()->json($response, 502);
                }
            }
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404')
            );
            return response()->json($response, 404);
        }
    }

    /**
     * Update the risk score specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRiskScoring(Request $request)
    {
        $risk = Risk::find($request->id);
        if ($risk) {
            $validator = Validator::make($request->all(), [
                'current_likelihood_id' => ['required', 'exists:likelihoods,id'],
                'current_impact_id' => ['required', 'exists:impacts,id'],
            ]);

            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('risk.ThereWasAProblemUpdatingTheRisk') . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();
                try {
                    // Get old calculated risk
                    $oldCalculatedRisk = get_calculated_risk_by_id($risk->id);

                    $calculatedRisk = calculate_risk($request->current_impact_id, $request->current_likelihood_id);

                    $risk->riskScoring()->update([
                        'calculated_risk' => $calculatedRisk,
                        'CLASSIC_likelihood' => $request->current_likelihood_id,
                        'CLASSIC_impact' => $request->current_impact_id,
                    ]);

                    $responseMessage = __('risk.Risk scoring has no change');
                    $responseReload = false;

                    // If risk score was changed
                    if ($oldCalculatedRisk != $calculatedRisk) {
                        // Add risk scoring history
                        add_risk_scoring_history($risk->id, $calculatedRisk);

                        // Add residual risk scoring history
                        $residual_risk = get_residual_risk($risk->id);

                        add_residual_risk_scoring_history($risk->id, $residual_risk);

                        // Audit log
                        $message = __("risk.Risk score has been updated for risk ID") . " \"" . ($risk->id + 1000) . "\" " . __("locale.CreatedBy") . " \"" . auth()->user()->name . "\".";

                        write_log($risk->id, auth()->id(), $message);

                        $responseMessage = __('risk.The mitigation has been successfully modified');
                        $responseReload = true;
                    }

                    DB::commit();

                    $response = array(
                        'status' => true,
                        'data' => [],
                        'reload' => $responseReload,
                        'message' => $responseMessage,
                    );
                    return response()->json($response, 200);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    $response = array(
                        'status' => false,
                        'errors' => [],
                        // 'message' => $th->getMessage(),
                        'message' => __('locale.ThereAreUnexpectedProblems')
                    );
                    return response()->json($response, 502);
                }
            }
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404')
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
        $risk = Risk::find($id);
        if ($risk) {
            DB::beginTransaction();
            $risk_id = $risk->id;
            try {
                // Remove the risk
                $risk->delete(); // risks

                // Audit log
                $message = __("risk.Risk ID") . " \"" . ($risk->id + 1000) . "\" " . __("locale.DeletedBy") . " \"" . auth()->user()->name . "\".";

                write_log($risk->id, auth()->id(), $message);

                Storage::deleteDirectory('risk/' . $risk_id);
                DB::commit();
                event(new RiskDelete($risk));

                $response = array(
                    'status' => true,
                    'message' => __('locale.RiskWasDeletedSuccessfully'),
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
            'normal' => ['status', 'subject', 'submission_date'],
            'relationships' => [
                [
                    // Column => 'relationshipName'
                    'calculated_risk' => 'riskScoring'
                ]
            ],
            'other_global_filters' => [],
        ];
        $relationshipsWithColumns = [
            // 'relationshipName:column1,column2,....'
            'riskScoring:id,calculated_risk'
        ];

        prepareDatatableRequestFields($request, $dataTableDetails, $customFilterFields);
        /* End reading datatable data and custom fields for filtering */
        $customConditions = [];
        if (!auth()->user()->hasPermission('riskmanagement.all')) {
            if (isDepartmentManager()) {
                $departmentId = (Department::where('manager_id', auth()->id())->first())->id;
                $departmentMembers =  User::with('teams')->where('department_id', $departmentId)->orWhere('id', auth()->id())->get();
                $departmentMembersIds =  $departmentMembers->pluck('id')->toArray();
                $departmentTeams = [];
                foreach ($departmentMembers as $departmentMember) {
                    $departmentTeams = array_merge($departmentTeams, $departmentMember->teams->pluck('id')->toArray());
                }
                $ownedRisksIds = Risk::whereIn('owner_id', $departmentMembersIds)->orWhereIn('submitted_by', $departmentMembersIds)->pluck('id')->toArray();
                $stakeholdersRisksIds =  RiskToAdditionalStakeholder::WhereIn('user_id', $departmentMembersIds)->pluck('risk_id')->toarray();
                $teamsRisksIds =  RiskToTeam::WhereIn('team_id', $departmentTeams)->pluck('risk_id')->toarray();
                $risksIds = array_unique(array_merge($ownedRisksIds, $stakeholdersRisksIds, $teamsRisksIds));
            } else {
                $ownedRisksIds = Risk::where('owner_id', auth()->id())->orWhere('submitted_by', auth()->id())->pluck('id')->toArray();
                $loggedUserTeams = User::with('teams')->find(auth()->id())->teams->pluck('id')->toArray();
                $stakeholdersRisksIds =  RiskToAdditionalStakeholder::Where('user_id', auth()->id())->pluck('risk_id')->toarray();
                $teamsRisksIds =  RiskToTeam::WhereIn('team_id', $loggedUserTeams)->pluck('risk_id')->toarray();
                $risksIds = array_unique(array_merge($ownedRisksIds, $stakeholdersRisksIds, $teamsRisksIds));
            }
            $customConditions['whereIn']['id'] =  $risksIds;
        }
        // Getting total records count with and without apply global search
        [$totalRecords, $totalRecordswithFilter] = getDatatableFilterTotalRecordsCount(
            Risk::class,
            $dataTableDetails,
            $customFilterFields,
            $customConditions
        );

        $mainTableColumns = getTableColumnsSelect(
            'risks',
            [
                'id',
                'status',
                'subject',
                'category_id',
                'questionnaire_id',
                'assessment',
                'risk_description',
                'submission_date',
            ],
            // Add the 'category' relationship
            ['category']
        );

        // Getting records with apply global search */
        $risks = getDatatableFilterRecords(
            Risk::class,
            $dataTableDetails,
            $customFilterFields,
            $relationshipsWithColumns,
            $mainTableColumns,
            $customConditions
        );

        // Custom risks response data as needs
        $data_arr = [];
        foreach ($risks as $risk) {
            $calculatedRisk = $risk->riskScoring()->select('calculated_risk')->first()->calculated_risk;

            $assessment = ContactQuestionnaireAnswerResult::where('contact_questionnaire_answer_id', $risk->questionnaire_id)
                ->latest()
                ->first();
            $assessmentName = optional(optional(optional($assessment)->contactQuestionnaireAnswer)->questionnaire)->name;



            $data_arr[] = array(
                'id' =>  $risk->id,
                'subject' => $risk->subject,
                'risk_description' => $risk->risk_description,
                'category_id' => optional($risk->category)->name, // Access the category name through the relationship if it null we use optional
                'questionnaire' => $assessmentName ?? '',
                'status' => $risk->status,
                'riskScoring' => [$calculatedRisk, $this->riskScoringColor($calculatedRisk)],
                'assessment' => $risk->assessment,
                // 'mitigation_planned' => 'No',
                // 'management_review' => 'No',
                'submission_date' => $risk->submission_date,
                'Actions' => $risk->id
            );
        }

        // Get custom response for datatable ajax request
        $response = getDatatableAjaxResponse(intval($dataTableDetails['draw']), $totalRecords, $totalRecordswithFilter, $data_arr);

        return response()->json($response, 200);
    }

    protected function riskScoringColor($riskScoring)
    {
        return RiskLevel::orderBy('value', 'desc')->where('value', '<=', $riskScoring)->first()->color;
    }

    /**
     * Return a risk level data.
     *
     * @return \Illuminate\Http\Response
     */
    protected function getRiskValueData($calculated_risk)
    {
        $riskLevel = RiskLevel::orderBy('value', 'desc')->where('value', '<=', $calculated_risk)->first();
        $data = [];

        if ($riskLevel->display_name != '')
            $data['name'] = $riskLevel->display_name;
        else if ($riskLevel->name != '')
            $data['name'] = $riskLevel->name;
        else
            $data['name'] = "Insignificant";

        if (!$riskLevel)
            $data['color'] = "white";
        else
            $data['color'] = $riskLevel['color'];

        return $data;
    }

    /**
     * Get risk levels resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function getRiskLevels()
    {
        return getRiskLevels();
    }

    /**
     * Get Residual Scoring History.
     *
     * @return \Illuminate\Http\Response
     */
    public function residualScoringHistory($risk_id = null)
    {
        // If the risk id is sent
        if ($risk_id) {
            $residual_histories = $this->getResidualScoringHistories($risk_id);
            $current_history = end($residual_histories);
            $current_history['last_update'] = date('Y-m-d H:i:s');
            array_push($residual_histories, $current_history);

            $response = array(
                'status' => true,
                'data' =>  $residual_histories,
            );
            return response()->json($response, 200);
        }
        // If the risk id was not sent
        else {
            // Return history for all risks
            $residual_histories = $this->getResidualScoringHistories();
            $response = array(
                'status' => true,
                'alert' => __('locale.Alert'),
                'data' =>  $residual_histories,
            );

            return response()->json($response, 200);
        }
    }


    /********************************************
     * FUNCTION: GET RESIDUAL SCORING HISTORIES *
     ********************************************/
    /**
     * Return a  Residual Scoring History.
     *
     * @return \Illuminate\Http\Response
     */
    protected function getResidualScoringHistories($riskId = null)
    {
        // If the risk id is not null
        if ($riskId != null) {
            // Get risk scoring histories by risk id
            $histories = ResidualRiskScoringHistory::where('risk_id', $riskId)->select('risk_id', 'residual_risk', 'last_update')->orderBy('last_update')->get()->toArray();
        }
        // If the risk id is null
        else {
            // Get risk scoring histories for all risks
            $histories = ResidualRiskScoringHistory::select('risk_id', 'residual_risk', 'last_update')->orderBy('last_update')->get()->toArray();
        }

        // Return the scoring history
        return $histories;
    }

    /**
     * Get Scoring History.
     *
     * @return \Illuminate\Http\Response
     */
    function scoringHistory($riskId = null)
    {
        // If the risk id is sent
        if ($riskId) {

            $histories = $this->getScoringHistories($riskId);
            $current_history = end($histories);
            $current_history['last_update'] = date('Y-m-d H:i:s');
            array_push($histories, $current_history);

            $response = array(
                'status' => true,
                'data' =>  $histories,
            );
            return response()->json($response, 200);
        }
        // If the risk id was not sent
        else {
            // Return history for all risks
            $histories = $this->getScoringHistories();
            $response = array(
                'status' => true,
                'alert' => __('locale.Alert'),
                'data' =>  $histories,
            );

            return response()->json($response, 200);
        }
    }

    /***********************************
     * FUNCTION: GET SCORING HISTORIES *
     ***********************************/
    function getScoringHistories($riskId = null)
    {
        // If the risk id is not null
        if ($riskId != null) {

            // Get risk scoring histories by risk id
            $histories = RiskScoringHistory::where('risk_id', $riskId)->select('risk_id', 'calculated_risk', 'last_update')->orderBy('last_update')->get()->toArray();
        }
        // If the risk id is null
        else {
            // Get risk scoring histories for all risks
            $histories = RiskScoringHistory::select('risk_id', 'calculated_risk', 'last_update')->orderBy('last_update')->get()->toArray();
        }

        // Return the scoring history
        return $histories;
    }


    /**
     * Add commentto specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addRiskComment(Request $request)
    {
        $risk = Risk::find($request->id);
        if ($risk) {
            $validator = Validator::make($request->all(), [
                'comment' => ['required'],
            ]);
            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('risk.CommentRiskRequired') . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();
                try {
                    $comment = Comment::create([
                        'risk_id' => $request->id,
                        'user' => auth()->id(),
                        'date' => date('Y-m-d H:i:s'),
                        'comment' => $request->comment
                    ]);

                    // Audit log
                    $message = __("risk.A comment was added to risk ID") . " \"" . ($risk->id + 1000) . "\" " . __("locale.CreatedBy") . " \"" . auth()->user()->name . "\".";
                    write_log($risk->id, auth()->id(), $message);

                    DB::commit();

                    $response = array(
                        'status' => true,
                        'reload' => true,
                        'data' => [
                            'content' => "<b>" . date(get_default_datetime_format("g:i A T"), strtotime($comment->date)) . ' by ' . auth()->user()->name . "</b><br>" . $comment->comment
                        ],
                        'message' => __('risk.The risk comment has been successfully added'),
                    );
                    return response()->json($response, 200);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    $response = array(
                        'status' => false,
                        'errors' => [],
                        // 'message' => $th->getMessage(),
                        'message' => __('locale.ThereAreUnexpectedProblems')
                    );
                    return response()->json($response, 502);
                }
            }
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404')
            );
            return response()->json($response, 404);
        }
    }

    /**
     * Download the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downloadFile(Request $request)
    {
        $file = Risk::where('id', $request->risk_id)->first()->files()->where('id', $request->id)->first() ?? null;
        $exists = Storage::disk('local')->exists($file->unique_name);
        if ($file && $exists) {
            return Storage::download($file->unique_name, $file->name);
        } else {
            $file->delete();
            return redirect()->route('admin.risk_management.show', $request->risk_id);
            // $response = array(
            //     'status' => false,
            //     'message' => __('locale.Error 404'),
            // );
            // return response()->json($response, 404);
        }
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteFile(Request $request)
    {
        $file = Risk::where('id', $request->risk_id)->first()->files()->where('id', $request->id)->first() ?? null;
        if ($file) {
            Storage::delete($file->unique_name);
            $file->delete();

            if ($request->mitigation == 1) {
                // Audit log
                $message = "File [" . $file->name . "] in mitigation of Risk ID \"" . ($request->risk_id + 1000) . "\" __(locale.DeletedBy) \"" . (auth()->user()->name) . "\".";
                $auditLog = write_log($request->risk_id, auth()->id(), $message);
            } else {
                // Audit log
                $message = "File [" . $file->name . "] in Risk ID \"" . ($request->risk_id + 1000) . "\" was DELETED by username \"" . (auth()->user()->name) . "\".";
                $auditLog = write_log($request->risk_id, auth()->id(), $message);
            }

            $response = array(
                'status' => true,
                'data' => [
                    'log' => date(get_default_datetime_format('g:i A T'), strtotime($auditLog->timestamp)) . '>' . $auditLog->message
                ],
                'message' => __('locale.FileDeletedSuccessfully'),
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
     * Accept or reject mitigation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function acceptOrRejectMitigation(Request $request)
    {
        $risk = Risk::where('id', $request->risk_id)->first();
        if ($risk) {
            $message = '';
            if (in_array($request->accept, [0, 1])) {
                if ($request->accept == 1) {
                    $MitigationAcceptUser = MitigationAcceptUser::create([
                        'risk_id' => $request->risk_id,
                        'user_id' => auth()->id(),
                        'created_at' => now(), // Use now() instead of date("Y-m-d H:i:s")
                    ]);
                    event(new MitigationAcceptUserCreated($MitigationAcceptUser));

                    $message = __("risk.Mitigation for risk ID") . " \"" . ($request->risk_id + 1000) . "\" " . __("risk.accepted by") . " \"" . auth()->user()->name . "\" user.";
                    write_log($request->risk_id, auth()->id(), $message);
                } else if ($request->accept == 0) {
                    // Retrieve the model instance before deleting
                    $MitigationAcceptUser = MitigationAcceptUser::where([
                        'risk_id' => $request->risk_id,
                        'user_id' => auth()->id(),
                    ])->first();

                    if ($MitigationAcceptUser) {
                        $MitigationAcceptUser->delete();
                        event(new MitigationAcceptUserCreated($MitigationAcceptUser));

                        $message = __("risk.Mitigation for risk ID") . " \"" . ($request->risk_id + 1000) . "\"";
                        write_log($request->risk_id, auth()->id(), $message);
                    } else {
                        // Handle the case where the record doesn't exist
                        $message = __("risk.Mitigation record not found for risk ID") . " \"" . ($request->risk_id + 1000) . "\"";
                    }
                }

                $response = [
                    'status' => true,
                    'reload' => true,
                    'message' => $message,
                ];
                return response()->json($response, 200);
            } else {
                $response = [
                    'status' => false,
                    'message' => __('locale.Error'),
                ];
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
     * Update the risk mitigation specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRiskMitigation(Request $request, $risk = null)
    {
        // If $risk is not passed, fetch the risk from the database

        $risk = Risk::where('id', $request->risk_id ?? ($risk->id ?? null))
            ->first(); // Assuming you pass 'risk_id' in the request
        $mitigation = [];
        if ($risk) {

            $validator = Validator::make($request->all(), [
                'planning_strategy' => ['nullable', 'exists:planning_strategies,id'],
                'mitigation_effort' => ['nullable', 'exists:mitigation_efforts,id'],
                'mitigation_cost' => ['nullable', 'exists:asset_values,id'],
                'mitigation_owner' => ['nullable', 'exists:users,id'],
                'submission_date' => ['nullable', 'date'],
                'planned_mitigation_date' => ['nullable', 'string'],
                'security_requirements' => ['nullable', 'string'],
                'security_recommendations' => ['nullable', 'string'],
                'mitigation_control_id' => ['nullable', 'array'],
                'mitigation_control_id.*' => ['exists:framework_controls,id'],
                'mitigation_team_id' => ['nullable', 'array'],
                'mitigation_team_id.*' => ['exists:teams,id'],
            ]);
            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('risk.ThereWasAProblemUpdatingTheRiskMitigation') . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();
                try {

                    // If we don't yet have a mitigation
                    if (!$risk->mitigation_id) {

                        // Submit mitigation and get the mitigation
                        $mitigation_date = isset($request->mitigation_date) ? $request->mitigation_date : date(get_default_datetime_format());

                         $planning_date = isset($request->planned_mitigation_date) ? $request->planned_mitigation_date : "";

                        if (!validate_date($planning_date, get_default_date_format())) {
                            $planning_date = "0000-00-00";
                        }
                        // Otherwise, set the proper format for submitting to the database
                        else {
                            $planning_date = get_standard_date_from_default_format($planning_date);
                        }

                        // Convert to standard date
                        $mitigation_date = get_standard_date_from_default_format($mitigation_date, true);

                        $currecntSolution = $request->current_solution ?? $request->additional_notes;

                        $mitigation = Mitigation::create([
                            'risk_id' => $request->risk_id ?? $risk->id,
                            'submission_date' => $mitigation_date,
                            'last_update' => '',
                            'planning_strategy' => $request->planning_strategy,
                            'mitigation_effort' => $request->mitigation_effort,
                            'mitigation_cost' => $request->mitigation_cost,
                            'mitigation_owner' => $request->mitigation_owner_id,
                            'current_solution' => $currecntSolution,
                            'security_requirements' => $request->security_requirements,
                            'security_recommendations' => $request->security_recommendations,
                            'submitted_by' => auth()->id(),
                            'planning_date' => $planning_date,
                            'mitigation_percent' => (isset($request->mitigation_percent) && $request->mitigation_percent >= 0 && $request->mitigation_percent <= 100) ? $request->mitigation_percent : 0,
                        ]);

                        // Save mitigation controls
                        // foreach ($request->mitigation_control_id ?? [] as $mitigation_control_id) {
                        //     $mitigation->controls()->attach(
                        //         $mitigation_control_id,
                        //         [
                        //             'validation_details' => 'Validation details text added automatically',
                        //             'validation_owner' => 1,
                        //             'validation_mitigation_percent' => 25,
                        //         ]
                        //     );
                        // }
                        $mitigation->controls()->sync($request->mitigation_control_id ?? []);
                        // TODO : Recieve ['validation_details', 'validation_owner', 'validation_mitigation_percent'] from front-end

                        // Save mitigation teams
                        // foreach ($request->mitigation_team_id ?? [] as $mitigation_team_id) {
                        //     $mitigation->teams()->attach($mitigation_team_id);
                        // }
                        $mitigation->teams()->sync($request->mitigation_team_id ?? []);

                        // Update the risk status and last_update
                        $risk->update([
                            'status' => 'Mitigation Planned',
                            'mitigation_id' => $mitigation->id
                        ]);

                        // Audit log
                        $message = __("risk.A mitigation was submitted for risk ID") . " \"" . ($risk->id + 1000) . "\" " . __("locale.CreatedBy") . " \"" . auth()->user()->name . "\".";

                        write_log($risk->id, auth()->id(), $message);

                        // File upload Start
                        if ($request->hasFile('supporting_documentation')) {
                            foreach ($request->file('supporting_documentation') as $supporting_documentation) {
                                if ($supporting_documentation->isValid()) {
                                    $path = $supporting_documentation->store('risk_mitigation/' . $mitigation->id);
                                    $fileName = pathinfo($supporting_documentation->getClientOriginalName(), PATHINFO_FILENAME);
                                    $fileName .= pathinfo($path, PATHINFO_EXTENSION) ? '.' . pathinfo($path, PATHINFO_EXTENSION) : '';
                                    File::create([
                                        'risk_id' => $risk->id,
                                        'view_type' => 2,
                                        'name' => $fileName,
                                        'unique_name' => $path,
                                        'type' => $supporting_documentation->getClientMimeType(),
                                        'size' => $supporting_documentation->getSize(),
                                        'user' => auth()->id()
                                    ]);
                                } else {
                                    DB::rollBack();
                                    Storage::deleteDirectory('risk_mitigation/' . $mitigation->id);
                                    $response = array(
                                        'status' => false,
                                        'errors' => ['supporting_documentation' => ['There were problems uploading the files']],
                                        'message' => __('risk.ThereWasAProblemAddingTheRisk') . "<br>" . __('locale.Validation error'),
                                    );

                                    return response()->json($response, 422);
                                }
                            }
                        }
                        // File upload End

                        // Add residual risk score
                        $residual_risk = get_residual_risk($risk->id);
                        add_residual_risk_scoring_history($risk->id, $residual_risk);
                    } else {

                        $mitigation = $risk->mitigation;
                        // Update mitigation and get the mitigation date back
                        $submission_date = isset($request->mitigation_date) && validate_date($request->mitigation_date, get_default_datetime_format()) ? get_standard_date_from_default_format($request->mitigation_date, true) : false;

                        $planning_date = isset($request->planned_mitigation_date) ? $request->planned_mitigation_date : "";

                        if (!validate_date($planning_date, get_default_date_format())) {
                            $planning_date = "0000-00-00";
                        }
                        // Otherwise, set the proper format for submitting to the database
                        else {
                            $planning_date = get_standard_date_from_default_format($planning_date);
                        }

                        $currecntSolution = $request->current_solution;

                        $data = array(
                            "planning_strategy" => $request->planning_strategy,
                            "mitigation_effort" => $request->mitigation_effort,
                            "mitigation_cost" => $request->mitigation_cost,
                            "mitigation_owner" => $request->mitigation_owner_id,
                            "current_solution" => $currecntSolution,
                            "security_requirements" => $request->security_requirements,
                            "security_recommendations" => $request->security_recommendations,
                            "planning_date" => $planning_date,
                            "mitigation_percent" => (isset($request->mitigation_percent) && $request->mitigation_percent >= 0 && $request->mitigation_percent <= 100) ? $request->mitigation_percent : 0
                        );



                        $updated_fields = [];
                        foreach ($data as $key => $value) {
                            if ($key == "current_solution" || $key == "security_requirements" || $key == "security_recommendations") {
                                if ($value != $mitigation[$key]) {
                                    $updated_fields[$key]["original"] = $mitigation[$key];
                                    $updated_fields[$key]["updated"] = $value;
                                }
                            } else if ($value != $mitigation[$key]) {
                                switch ($key) {
                                    default:
                                        $original_value = $mitigation[$key];
                                        $updated_value = $value;
                                        break;
                                    case "planning_strategy":
                                        $original_value = PlanningStrategy::where('id', $mitigation[$key])->pluck('name')->first();
                                        $updated_value = PlanningStrategy::where('id', $value)->pluck('name')->first();
                                        break;
                                    case "mitigation_effort":
                                        $original_value = MitigationEffort::where('id', $mitigation[$key])->pluck('name')->first();
                                        $updated_value = MitigationEffort::where('id', $value)->pluck('name')->first();
                                        break;
                                    case "mitigation_cost":
                                        $original_value = $mitigation[$key] ? get_asset_value_by_id($mitigation[$key]) : '';
                                        $updated_value = get_asset_value_by_id($value);
                                        break;
                                    case "mitigation_owner":
                                        $original_value = User::where('id', $mitigation[$key])->pluck('name')->first();
                                        $updated_value = User::where('id', $value)->pluck('name')->first();
                                        break;
                                }
                                $updated_fields[$key]["original"] = $original_value;
                                $updated_fields[$key]["updated"] = $updated_value;
                            }
                        }
                        $data['last_update'] = date("Y-m-d H:i:s");
                        if ($submission_date)
                            $data['submission_date'] = $submission_date;

                        $mit = $mitigation->update($data);
                        // dd($mit);

                        // Save mitigation controls
                        // foreach ($request->mitigation_control_id ?? [] as $mitigation_control_id) {
                        //     // $mitigation->controls()->create([]);
                        //     $currentMitigationControls = $mitigation->controls()->pluck('control_id')->toArray();
                        //     $deletedMitigationControls = array_diff($currentMitigationControls ?? [], $request->mitigation_control_id ?? []);
                        //     $addedMitigationControls = array_diff($request->mitigation_control_id ?? [], $currentMitigationControls ?? []);

                        //     // Delete deleted mitigation controls
                        //     $mitigation->controls()->detach($deletedMitigationControls);

                        //     // Add added mitigation controls
                        //     $mitigation->controls()->attach(
                        //         $addedMitigationControls,
                        //         [
                        //             'validation_details' => 'Validation details text added automatically',
                        //             'validation_owner' => 1,
                        //             'validation_mitigation_percent' => 25,
                        //         ]
                        //     );
                        // }
                        $mitigation->controls()->sync($request->mitigation_control_id ?? []);
                        // TODO : Recieve ['validation_details', 'validation_owner', 'validation_mitigation_percent'] from front-end
                        // Save mitigation teams
                        // Save mitigation teams
                        // foreach ($request->mitigation_team_id ?? [] as $mitigation_team_id) {
                        //     $currentMitigationTeams = $mitigation->teams()->pluck('team_id')->toArray();
                        //     $deletedMitigationTeams = array_diff($currentMitigationTeams ?? [], $request->mitigation_team_id ?? []);
                        //     $addedMitigationTeams = array_diff($request->mitigation_team_id ?? [], $currentMitigationTeams ?? []);

                        //     // Delete deleted mitigation teams
                        //     $mitigation->teams()->detach($deletedMitigationTeams);

                        //     // Add added mitigation teams
                        //     $mitigation->teams()->attach($addedMitigationTeams);
                        // }
                        $mitigation->teams()->sync($request->mitigation_team_id ?? []);


                        // Audit log
                        if (count($updated_fields)) {
                            $detail_updated = [];
                            foreach ($updated_fields as $key => $value) {
                                $detail_updated[] = "Field name : `" . $key . "` (`" . $value["original"] . "`=>`" . $value["updated"] . "`)";
                            }
                            $updated_string = implode(", ", $detail_updated);
                        } else {
                            $updated_string = "";
                        }

                        $message = __("risk.Risk mitigation details were updated for risk ID") . " \"" . ($risk->id + 1000) . "\" " . __("locale.CreatedBy") . " \"" . auth()->user()->name . "\".\n" . $updated_string;
                        write_log($risk->id, auth()->id(), $message);

                        // File upload Start
                        $uploadfilePaths = [];
                        if ($request->hasFile('supporting_documentation')) {
                            foreach ($request->file('supporting_documentation') as $supporting_documentation) {
                                if ($supporting_documentation->isValid()) {
                                    $path = $supporting_documentation->store('risk_mitigation/' . $risk->id);
                                    $uploadfilePaths[] = $path;
                                    $fileName = pathinfo($supporting_documentation->getClientOriginalName(), PATHINFO_FILENAME);
                                    $fileName .= pathinfo($path, PATHINFO_EXTENSION) ? '.' . pathinfo($path, PATHINFO_EXTENSION) : '';
                                    File::create([
                                        'risk_id' => $risk->id,
                                        'view_type' => 2,
                                        'name' => $fileName,
                                        'unique_name' => $path,
                                        'type' => $supporting_documentation->getClientMimeType(),
                                        'size' => $supporting_documentation->getSize(),
                                        'user' => auth()->id()
                                    ]);
                                } else {
                                    DB::rollBack();
                                    foreach ($uploadfilePaths as $uploadfilePath) {
                                        Storage::delete($uploadfilePath);
                                    }
                                    $response = array(
                                        'status' => false,
                                        'errors' => ['supporting_documentation' => ['There were problems uploading the files']],
                                        'message' => __('risk.ThereWasAProblemAddingTheRisk') . "<br>" . __('locale.Validation error'),
                                    );

                                    return response()->json($response, 422);
                                }
                            }
                        }
                        // File upload End

                        // Add residual risk score
                        $residual_risk = get_residual_risk($risk->id);
                        add_residual_risk_scoring_history($risk->id, $residual_risk);
                    }
                    DB::commit();
                    event(new RiskMitigationCreated($risk, $mitigation));
                    // event(new RiskMitigationUpdated($risk, $mitigation));

                    $response = array(
                        'status' => true,
                        'reload' => true,
                        'message' => __('risk.The mitigation has been successfully modified'),
                    );

                    return response()->json($response, 200);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    // Storage::deleteDirectory('risk_mitigation/' . $mitigation->id);
                    $response = array(
                        'status' => false,
                        'errors' => [],
                        // 'message' => $th->getMessage(),
                        'message' => __('locale.ThereAreUnexpectedProblems')
                    );
                    return response()->json($response, 502);
                }
            }
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404')
            );
            return response()->json($response, 404);
        }
    }

    /**
     * Add the risk review specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addRiskReview(Request $request, $risk = null)
    {

        $risk = Risk::with('riskScoring')
            ->where('id', $request->risk_id ?? ($risk->id ?? null))
            ->first();
        if ($risk) {
            $validator = Validator::make($request->all(), [
                'review' => ['nullable', 'exists:reviews,id'],
                'project' => ['nullable', 'exists:projects,id'],
                'next_step' => ['nullable', 'exists:next_steps,id'],
                'comments' => ['nullable', 'string'],
                'next_review_date' => ['nullable', 'date'],
            ]);

            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('risk.ThereWasAProblemUpdatingTheRiskMitigation') . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();

                try {
                    $status = "Mgmt Reviewed";
                    $review = $request->review;
                    $next_step = $request->next_step;
                    $reviewer = auth()->id();
                    $comments = $request->comments;
                    $custom_date = $request->next_review_date;

                    if ($custom_date) {
                        $custom_review = $request->next_review_date;

                        // Check the date format
                        if (!validate_date($custom_review, get_default_date_format())) {
                            $custom_review = "0000-00-00";
                        }
                        // Otherwise, set the proper format for submitting to the database
                        else {
                            $custom_review = get_standard_date_from_default_format($custom_review);
                        }
                    } else {
                        $risk_id = $request->risk_id ?? $risk->id;

                        // If next_review_date_uses setting is Residual Risk.
                        if (get_setting('next_review_date_uses') == "ResidualRisk") {
                            $custom_review = next_review_by_score(get_residual_risk($risk_id));
                        }
                        // If next_review_date_uses setting is Inherent Risk.
                        else {
                            $custom_review = next_review_by_score($risk->riskScoring->calculated_risk);
                        }

                        $custom_review = get_standard_date_from_default_format($custom_review);
                    }
                    // dd($custom_date, $custom_review);

                    // Get current datetime for last_update
                    $current_datetime = date('Y-m-d H:i:s');

                    $submission_date = date("Y-m-d H:i:s");

                    $mgmtReview = MgmtReview::create([
                        'risk_id' => $risk->id,
                        'review' => $review,
                        'reviewer' => $reviewer,
                        'next_step_id' => $next_step,
                        'comments' => $comments,
                        'next_review' => $custom_review,
                        'submission_date' => $submission_date,
                    ]);



                    // Update the risk status and last_update
                    $risk->update([
                        'status' => $status,
                        // 'last_update' => $current_datetime,
                        'review_date' => $current_datetime,
                        'mgmt_review' => $mgmtReview->id
                    ]);

                    // Audit log
                    $message = __("risk.A management review was submitted for risk ID") . " \"" . ($risk->id + 1000) . "\" " . __("locale.CreatedBy") . " \"" . auth()->user()->name . "\".";
                    write_log($risk->id, auth()->id(), $message);

                    if ($next_step == 2) { // next step is `Consider for Project`
                        $project = $request->project;
                        if (ctype_digit((string)$project)) {
                            // Update the risk project
                            $risk->update([
                                'project_id' => $request->project
                            ]);
                            // Audit log
                            $message = __('locale.RiskProjectAssociationAuditLog', [
                                'risk_id' => $risk_id,
                                'project_name' => Project::pluck('name')->where('id', $project)->first ?? __('risk.UnassignedRisks'),
                                'user' => auth()->user()->name
                            ]);
                        }
                    }
                    // dd($risk,$mgmtReview);

                    DB::commit();
                    event(new MgmtreviewCreated($mgmtReview, $risk));

                    $response = array(
                        'status' => true,
                        'reload' => true,
                        'message' => __('risk.The review has been successfully added'),
                    );
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
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404')
            );
            return response()->json($response, 404);
        }
    }

    /**
     * Add the risk closure and close specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function riskCloseReason(Request $request)
    {
        $risk = Risk::find($request->id);

        if ($risk) {
            $validator = Validator::make($request->all(), [
                'close_reason' => ['nullable', 'exists:close_reasons,id'],
                'note' => ['nullable', 'string'],
            ]);

            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('risk.ThereWasAProblemUpdatingTheRiskMitigation') . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();

                try {
                    $status = "Closed";
                    $close_reason = $request->close_reason;
                    $note = $request->note;

                    // Get current datetime for last_update
                    $current_datetime = date('Y-m-d H:i:s');

                    $mgmtReview = MgmtReview::create([
                        'risk_id' => $risk->id,
                        'review' => null,
                        'reviewer' => auth()->id(),
                        'next_step_id' => null,
                        'comments' => $note,
                        'next_review' => null,
                        'submission_date' => $current_datetime,
                    ]);

                    // Update the risk status and last_update
                    $risk->update([
                        'status' => $status,
                        // 'last_update' => $current_datetime,
                        'review_date' => $current_datetime,
                        'mgmt_review' => $mgmtReview->id
                    ]);
                    // Submit a review End

                    // Close the risk Start
                    close_risk($risk->id, auth()->id(), $status, $close_reason, $note);
                    // Close the risk End


                    DB::commit();
                    event(new RiskClose($risk, $close_reason, $note));
                    $response = array(
                        'status' => true,
                        'reload' => true,
                        'message' => __('locale.The risk has been closed successfully'),
                    );
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
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404')
            );
            return response()->json($response, 404);
        }
    }

    /**
     * Change risk status specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function riskReopen(Request $request)
    {
        $risk = Risk::find($request->id);

        if ($risk) {
            DB::beginTransaction();

            try {
                // Update the risk status and last_update
                $risk->update([
                    'status' => 'Reopened',
                    // 'last_update' => $current_datetime,
                    'close_id' => null,
                ]);

                // Audit log
                $message = __("risk.Risk ID") . " \"" . ($risk->id + 1000) . "\" " . __("risk.was reopened by username") . " \"" . auth()->user()->name . "\".";
                write_log($risk->id, auth()->id(), $message);

                DB::commit();
                event(new RiskReopen($risk));

                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('risk.The risk has been reopened successfully'),
                );
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
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404')
            );
            return response()->json($response, 404);
        }
    }

    /**
     * Add the risk closure specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function riskChangeStatus(Request $request)
    {
        $risk = Risk::find($request->id);

        if ($risk) {
            $validator = Validator::make($request->all(), [
                'status' => ['nullable', 'exists:statuses,id'],
                'note' => ['nullable', 'string'],
            ]);

            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('risk.ThereWasAProblemUpdatingTheRiskMitigation') . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();

                try {
                    $status = Status::where('id', $request->status)->pluck('name')->first();

                    // Update the status
                    if ($status == "Closed") {
                        // Get current datetime for last_update
                        $current_datetime = date('Y-m-d H:i:s');

                        $mgmtReview = MgmtReview::create([
                            'risk_id' => $risk->id,
                            'review' => null,
                            'reviewer' => auth()->id(),
                            'next_step_id' => null,
                            'comments' => null,
                            'next_review' => null,
                            'submission_date' => $current_datetime,
                        ]);

                        // Update the risk status and last_update
                        $risk->update([
                            'status' => $status,
                            // 'last_update' => $current_datetime,
                            'review_date' => $current_datetime,
                            'mgmt_review' => $mgmtReview->id
                        ]);
                        // Submit a review End

                        $close_reason = 3; // default vaule is 3: System Retired.
                        $note = "--";
                        // Close the risk
                        close_risk($risk->id, auth()->id(), $status, $close_reason, $note);
                    } else {
                        // Update the risk status and last_update
                        $risk->update([
                            'status' => $status,
                            // 'last_update' => $current_datetime,
                        ]);
                        // Submit a review End
                    }

                    // Audit log
                    $message = __("risk.A risk status for subject") . " \"" . ($risk->subject) . "\" " . __("risk.was changed by the") . " \"" . auth()->user()->name . "\" user.";
                    write_log($risk->id, auth()->id(), $message);

                    DB::commit();
                    event(new RiskStatus($risk));


                    $response = array(
                        'status' => true,
                        'reload' => true,
                        'message' => __('risk.The risk status has been changed successfully'),
                    );
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
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404')
            );
            return response()->json($response, 404);
        }
    }

    /**
     * Reset risk mitigation specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function resetRiskMitigations(Request $request)
    {
        $risk = Risk::find($request->id);

        if ($risk) {
            DB::beginTransaction();

            try {

                $mitigation = $risk->mitigation;

                if (!$mitigation) {
                    $response = array(
                        'status' => true,
                        'reload' => true,
                        'message' => __('risk.There is no Mitigation'),
                    );
                    return response()->json($response, 404);
                }

                $current_status = $risk->status;
                if ($current_status == "Mitigation Planned") $status = "New";
                else $status = $current_status;

                // Get current datetime for last_update
                $current_datetime = date('Y-m-d H:i:s');

                // Update the risk status and last_update
                $risk->update([
                    'status' => $status,
                    // 'last_update' => $current_datetime,
                    'review_date' => $current_datetime,
                    'mitigation_id' => null
                ]);

                // Delete existing mitigation by risk ID
                $resetRiskMitigation = Mitigation::where('risk_id', $request->id)->delete();

                // Audit log
                $message = __("risk.A mitigation was deleted for risk ID") . " \"" . ($risk->id + 1000) . "\" " . __("locale.CreatedBy") . " \"" . auth()->user()->name;
                write_log($risk->id, auth()->id(), $message);

                DB::commit();
                event(new RiskResetMitigation($risk, $resetRiskMitigation));

                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('risk.The risk mitigations has been reset successfully'),
                );
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
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404')
            );
            return response()->json($response, 404);
        }
    }

    /**
     * Reset risk reviews specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function resetRiskReviews(Request $request)
    {
        $risk = Risk::find($request->id);

        if ($risk) {
            DB::beginTransaction();

            try {
                // Get current datetime for last_update
                $current_datetime = date('Y-m-d H:i:s');

                // Delete existing reivew by risk ID
                $resetRiskReviews = MgmtReview::where('risk_id', $request->id)->delete();


                $current_status = $risk->status;
                if ($current_status == "Mgmt Reviewed") $status = "New";
                else $status = $current_status;

                // Update the risk status and last_update
                $risk->update([
                    'status' => $status,
                    // 'last_update' => $current_datetime,
                    'review_date' => $current_datetime,
                    'mgmt_review' => null
                ]);

                // Audit log
                $message = __("risk.A management review was deleted for risk ID") . " \"" . ($risk->id + 1000) . "\" " . __("locale.CreatedBy") . " \"" . auth()->user()->name . "\".";
                write_log($risk->id, auth()->id(), $message);

                DB::commit();
                event(new RiskResetReviews($risk, $resetRiskReviews));
                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('risk.The risk reviews has been reset successfully'),
                );
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
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404')
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
            return Excel::download(new RisksExport, 'Risks.xlsx');
        else
            return 'Risks.pdf';
    }

    public function notificationsSettingsRisk()
    {
        // defining the breadcrumbs that will be shown in page

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.risk_management.index'), 'name' => __('locale.Risk Management')],
            ['name' => __('locale.NotificationsSettings')]
        ];

        $users = User::select('id', 'name')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [10, 11, 12, 13, 14, 15, 16, 17, 18, 20, 21, 89];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [82, 90];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            10 => ['subject', 'status', 'team', 'Additional_Stakeholder', 'risk_catalog_mapping', 'threat_catalog_mapping', 'Category', 'Regulation', 'Owner', 'Source'],
            11 => ['subject', 'status', 'team', 'Additional_Stakeholder', 'risk_catalog_mapping', 'threat_catalog_mapping', 'Category', 'Regulation', 'Owner', 'Source'],
            12 => ['Subject', 'Review', 'Reviewer', 'NextStep', 'comments', 'NextReview'],
            13 => ['subject', 'Note'],
            14 => ['status', 'subject'],
            15 => ['Team', 'Plan', 'Effort', 'Current_Solution', 'Mitigation_Coast', 'Security_Requirements', 'Security_Recommendations', 'Planning_Date', 'Mitigation_Percent'],
            16 => ['subject'],
            17 => ['subject'],
            18 => ['subject'],
            // 19 => ['team_id','plan','effort','current_solution','mitigation_cost', 'current_solution', 'security_requirements', 'security_recommendations', 'planning_date', 'mitigation_percent'],
            20 => ['subject'],
            21 => ['subject'],
            82 => ['Team', 'Plan', 'Effort', 'Current_Solution', 'Mitigation_Coast', 'Security_Requirements', 'Security_Recommendations', 'Planning_Date', 'Mitigation_Percent'],
            89 => ['Risk_Name', 'Mitigation_Acceptor'],
            90 => ['Subject', 'Review', 'Reviewer', 'NextStep', 'comments', 'NextReview']
        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [
            10 => ['creator' => __('locale.RiskOwner'), 'Team-teams' => __('locale.TeamsOfRisk'), 'Stakeholder-teams' => __('locale.StakeholdersOfRisk')],
            11 => ['creator' => __('locale.RiskOwner'), 'Team-teams' => __('locale.TeamsOfRisk'), 'Stakeholder-teams' => __('locale.StakeholdersOfRisk')],
            12 => ['reviewer' => __('locale.Reviewer'), 'creator' => __('locale.RiskOwner'), 'Team-teams' => __('locale.TeamsOfRisk'), 'Stakeholder-teams' => __('locale.StakeholdersOfRisk')],
            13 => ['creator' => __('locale.RiskOwner'), 'Team-teams' => __('locale.TeamsOfRisk'), 'Stakeholder-teams' => __('locale.StakeholdersOfRisk')],
            14 => ['creator' => __('locale.RiskOwner'), 'Team-teams' => __('locale.TeamsOfRisk'), 'Stakeholder-teams' => __('locale.StakeholdersOfRisk')],
            15 => ['mit_owner' => __('locale.mit_owner'), 'creator' => __('locale.RiskOwner'), 'Team-teams' => __('locale.TeamsOfRisk'), 'Stakeholder-teams' => __('locale.StakeholdersOfRisk')],
            16 => ['creator' => __('locale.RiskOwner'), 'Team-teams' => __('locale.TeamsOfRisk'), 'Stakeholder-teams' => __('locale.StakeholdersOfRisk')],
            17 => ['creator' => __('locale.RiskOwner'), 'Team-teams' => __('locale.TeamsOfRisk'), 'Stakeholder-teams' => __('locale.StakeholdersOfRisk')],
            18 => ['creator' => __('locale.RiskOwner'), 'Team-teams' => __('locale.TeamsOfRisk'), 'Stakeholder-teams' => __('locale.StakeholdersOfRisk')],
            // 19 => ['creator' => __('locale.RiskOwner'), 'Team-teams' => __('locale.TeamsOfRisk'), 'Stakeholder-teams' => __('locale.StakeholdersOfRisk')],
            20 => ['creator' => __('locale.RiskOwner'), 'Team-teams' => __('locale.TeamsOfRisk'), 'Stakeholder-teams' => __('locale.StakeholdersOfRisk')],
            21 => ['creator' => __('locale.RiskOwner'), 'Team-teams' => __('locale.TeamsOfRisk'), 'Stakeholder-teams' => __('locale.StakeholdersOfRisk')],
            82 => ['mit_owner' => __('locale.mit_owner'), 'creator' => __('locale.RiskOwner'), 'Team-teams' => __('locale.TeamsOfRisk'), 'Stakeholder-teams' => __('locale.StakeholdersOfRisk')],
            89 => ['creator' => __('locale.RiskOwner'), 'Mitigation_Acceptor' => __('locale.MitigationAcceptor')],
            90 => ['reviewer' => __('locale.Reviewer'), 'creator' => __('locale.RiskOwner'), 'Team-teams' => __('locale.TeamsOfRisk'), 'Stakeholder-teams' => __('locale.StakeholdersOfRisk')],
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
    // Open import form
    public function openImportForm()
    {
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.risk_management.index'), 'name' => __('locale.Risk Management')],
            ['name' => __('locale.Import')]
        ];

        $databaseColumns = [
            ['name' => 'subject', 'rules' => ['required'], 'example' => 'Risk1'],
            ['name' => 'status', 'rules' => ['can be empty'], 'example' => 'New'],
            ['name' => 'risk_scoring_method_id', 'rules' => ['can be empty'], 'example' => 'Classic'],
            ['name' => 'current_likelihood_id', 'rules' => ['can be empty'], 'example' => 'Likely'],
            ['name' => 'current_impact_id', 'rules' => ['can be empty'], 'example' => 'Major'],
            ['name' => 'risk_catalog_mapping_id', 'rules' => ['can be empty'], 'example' => 'Unauthorized Access'],
            ['name' => 'threat_catalog_mapping_id', 'rules' => ['can be empty'], 'example' => 'Cyberattacks & Malware'],
            ['name' => 'risk_source_id', 'rules' => ['can be empty'], 'example' => 'User'],
            ['name' => 'submitted_by', 'rules' => ['can be empty'], 'example' => 'John Doe'],
            ['name' => 'submission_date', 'rules' => ['can be empty', 'date'], 'example' => '2024-08-01'],
        ];

        $importDataFunctionPath = route('admin.risk_management.ajax.importData');

        return view('admin.import.index', compact('breadcrumbs', 'databaseColumns', 'importDataFunctionPath'));
    }

    // Import data
    public function importData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'import_file' => ['required', 'file', 'max:5000'],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = [
                'status' => false,
                'errors' => $errors,
                'message' => __('locale.ThereWasAProblemImportingTheItem', ['item' => __('locale.Risks')]) . "<br>" . __('locale.Validation error'),
            ];
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();
            try {
                // Process and clean columns
                $columnsMapping = [];
                $columns = ['subject', 'status', 'risk_scoring_method_id', 'current_likelihood_id', 'current_impact_id', 'risk_catalog_mapping_id', 'threat_catalog_mapping_id', 'risk_source_id', 'submitted_by', 'submission_date'];

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
                        $snakeCaseColumn = Str::snake($cleanedColumn);
                        $columnsMapping[$column] = $snakeCaseColumn;
                    }
                }

                // Import data using the specified columns mapping
                (new RisksImport($columnsMapping))->import(request()->file('import_file'));

                DB::commit();
                $message = __("locale.New Data Imported At Risk") . " \"" . __("locale.CreatedBy") . " \"" . auth()->user()->name . "\".";
                write_log(1, auth()->id(), $message);

                $response = [
                    'status' => true,
                    'reload' => true,
                    'message' => __('locale.ItemWasImportedSuccessfully', ['item' => __('locale.Risks')]),
                ];
                return response()->json($response, 200);
            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                DB::rollBack();

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
                    'message' => __('locale.ThereWasAProblemImportingTheItem', ['item' => __('locale.Risks')]),
                ];
                return response()->json($response, 502);
            }
        }
    }


    // public function exportDataPdf(Request $request)
    // {
    //     try {
    //         // Get the values from the request
    //         $subject = $request->input('filter_subject');
    //         $status = $request->input('filter_status');
    //         $riskScoring = $request->input('filter_riskScoring');
    //         $submissionDate = $request->input('filter_submission_date');
    //         // Start with all risks
    //         $risks = Risk::query();
    //         // Apply filters if values are present
    //         if ($subject !== null) {
    //             $risks->where('subject', $subject);
    //         }
    //         if ($status !== null) {
    //             $risks->where('status', $status);
    //         }
    //         if ($riskScoring !== null) {
    //             // Assuming you have a relationship named 'riskScoring' in your Risk model
    //             $risks->whereHas('riskScoring', function ($query) use ($riskScoring) {
    //                 $query->where('calculated_risk', $riskScoring);
    //             });
    //         }
    //         if ($submissionDate !== null) {
    //             // Assuming 'submission_date' is the column in your Risk model
    //             $risks->whereRaw("DATE(submission_date) = ?", [$submissionDate]);
    //         }
    //         // Fetch risks based on the applied filters
    //         $risks = $risks->get();
    //         // return view('admin.content.risk_management.exportPdf', compact('risks'));

    //         // Get the HTML content of the specific table from the view
    //         $html = View::make('admin.content.risk_management.exportPdf', compact('risks'));
    //         // Initialize dompdf
    //         $options = new Options();
    //         $options->set('isHtml5ParserEnabled', true);
    //         $options->set('isPhpEnabled', true);
    //         $options->set('tempDir', storage_path('temp')); // Set the temp directory

    //         $dompdf = new Dompdf($options);
    //         $dompdf->loadHtml($html);

    //         // Set paper size (optional)
    //         $dompdf->setPaper('A4', 'landscape');

    //         // Render PDF
    //         $dompdf->render();

    //         // Output the PDF using dompdf's output buffer
    //         // Output the generated PDF to the browser
    //         return $dompdf->stream('exported_file.pdf', ['Attachment' => 0]);
    //     } catch (\Exception $e) {
    //         // Log the exception
    //         \Log::error($e->getMessage());
    //         \Log::error($e->getTraceAsString());

    //         // Return an error response or perform other actions
    //         return response()->json(['error' => 'Internal Server Error'], 500);
    //     }
    // }

    public function exportDataPdf(Request $request)
    {
        try {
            // Get the values from the request
            $subject = $request->input('filter_subject');
            $status = $request->input('filter_status');
            $riskScoring = $request->input('filter_riskScoring');
            $submissionDate = $request->input('filter_submission_date');
            // Start with all risks
            $risks = Risk::query();
            // Apply filters if values are present
            if ($subject !== null) {
                $risks->where('subject', $subject);
            }
            if ($status !== null) {
                $risks->where('status', $status);
            }
            if ($riskScoring !== null) {
                // Assuming you have a relationship named 'riskScoring' in your Risk model
                $risks->whereHas('riskScoring', function ($query) use ($riskScoring) {
                    $query->where('calculated_risk', $riskScoring);
                });
            }
            if ($submissionDate !== null) {
                // Assuming 'submission_date' is the column in your Risk model
                $risks->whereRaw("DATE(submission_date) = ?", [$submissionDate]);
            }
            // Fetch risks based on the applied filters
            $risks = $risks->get();

            // Get the HTML content of the specific table from the view
            return view('admin.content.risk_management.exportPdf', compact('risks'));
        } catch (\Exception $e) {
            // Log the exception
            \Log::error($e->getMessage());
            \Log::error($e->getTraceAsString());

            // Return an error response or perform other actions
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
