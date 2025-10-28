<?php

namespace App\Http\Controllers\admin\incident;

use App\Http\Controllers\Controller;
use App\Models\Containment;
use App\Models\Eradication;
use App\Models\IncidentClassify;
use App\Models\IncidentCriteria;
use App\Models\IncidentImpact;
use App\Models\IncidentIra;
use App\Models\IncidentLevel;
use App\Models\PlayBook;
use App\Models\PlayBookAction;
use App\Models\PlayBookActionPlayBook;
use App\Models\Recovery;
use App\Models\RiskFunction;
use App\Models\RiskGrouping;
use App\Models\Team;
use App\Models\ThreatGrouping;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class IncidentConfigureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],

        ['link' => route('admin.incident.index'), 'name' => __('incident.incident')],
         ['name' => __('incident.configure')]];

        $risk_groupings = RiskGrouping::all();
        $risk_functions = RiskFunction::all();
        $threat_groupings = ThreatGrouping::all();

        $levels = IncidentLevel::orderBy('level', 'asc')->get();
        $impacts = IncidentImpact::all();
        $likelihoods = IncidentImpact::orderBy('id')->get();
        $eradications = Eradication::all();
        $recoveries = Recovery::all();
        $containments = Containment::all();
        $users = User::select('id', 'name')->orderBy('id')->get();
        $teams = Team::select('id', 'name')->orderBy('id')->get();


        $customrRiskScringsData = [];
        foreach ($impacts as $impact) {
            $customrRiskScringsData[$impact->id] = [
                array('id' => $impact->id, 'name' => $impact->impact)
            ];

            foreach ($likelihoods as $likelihood) {
                array_push($customrRiskScringsData[$impact->id], $this->calculateRisk($impact->id, $likelihood->id));
            }
        }
        $ira = IncidentIra::first();


        $addValueTables = [
            'occurrences' => 'Occurrences',
            'directions' => 'Directions',
            'attacks' => 'Attacks',
            'detecteds' => 'DetectedBy',
            'locations' => 'SiteLocation',
            'graph' => 'IncidentScore',
            'play_book_category' => 'PlayBookCategory',
            'play_book' => 'PlayBook',
            'ira' =>'IRA'

        ];
        $criterias = IncidentCriteria::all();


        return view('admin.content.incident.config', compact('breadcrumbs', 'users','ira', 'teams', 'eradications', 'recoveries', 'containments', 'criterias', 'risk_groupings', 'risk_functions', 'threat_groupings', 'addValueTables', 'levels', 'customrRiskScringsData', 'likelihoods'));
    }

    public function store_criteria(Request $request)
    {
        $criterias = $request->input('criterias', []);
        $existingIds = IncidentCriteria::pluck('id')->toArray();
        $requestIds = collect($criterias)->pluck('id')->filter()->toArray();

        foreach ($criterias as $criteria) {
            if (isset($criteria['id'])) {
                // If ID exists, update the record
                IncidentCriteria::where('id', $criteria['id'])
                    ->update([
                        'name' => $criteria['name'],
                        'description' => $criteria['description']
                    ]);
            } else {
                // If no ID, create a new record
                IncidentCriteria::create([
                    'name' => $criteria['name'],
                    'description' => $criteria['description']
                ]);
            }
        }
        $idsToDelete = array_diff($existingIds, $requestIds);
        IncidentCriteria::whereIn('id', $idsToDelete)->delete();

        $criterias = IncidentCriteria::with('IncidentScores')->get();

        return response()->json(['success' => true, 'criterias' => $criterias]);
    }

    public function store_score(Request $request)
    {
        $criterias = $request->input('criterias', []);


        foreach ($criterias as $criteria) {
            // Retrieve or create the IncidentCriteria record
            $incidentCriteria = IncidentCriteria::updateOrCreate(
                ['id' => $criteria['id']],
                ['id' => $criteria['id']]
            );
            // Process each point for this criterion
            $points = $criteria['points'];
            $requestPointIds = collect($points)->pluck('id')->filter()->toArray();
            $existingPointIds = $incidentCriteria->IncidentScores()->pluck('id')->toArray();

            // Determine IDs to delete from `incident_scores` for this criteria
            $pointIdsToDelete = array_diff($existingPointIds, $requestPointIds);
            $incidentCriteria->IncidentScores()->whereIn('id', $pointIdsToDelete)->delete();

            foreach ($points as $index => $point) {
                // Insert or update each point in `incident_scores`
                $incidentCriteria->IncidentScores()->updateOrCreate(
                    ['id' => $point['id'] ?? null],
                    [
                        'title' => $point['title'],
                        'point' => $point['point'],
                        'incident_criteria_id' => $incidentCriteria->id
                    ]
                );
            }
        }

        $incidentCriterias = IncidentCriteria::with('IncidentScores')->get();

        $criteriaScores = [];
        $totalMaxScore = 0;

        foreach ($incidentCriterias as $criteria) {
            $maxScore = $criteria->IncidentScores->max('point') ?? 0;
            $criteriaScores[] = [
                'name' => $criteria->name,
                'max_score' => $maxScore,
            ];
            $totalMaxScore += $maxScore;
        }

        $classifies = IncidentClassify::all();
        return response()->json(['success' => true, 'classifies' => $classifies, 'criteriaScores' => $criteriaScores, 'totalMaxScore' => $totalMaxScore]);
    }

    public function store_classify(Request $request)
    {
        $classifies = $request->input('classifies', []);
        $existingIds = IncidentClassify::pluck('id')->toArray();
        $requestIds = collect($classifies)->pluck('id')->filter()->toArray();

        foreach ($classifies as $classify) {
            if (isset($classify['id'])) {
                // Update existing record
                IncidentClassify::where('id', $classify['id'])
                    ->update([
                        'priority' => $classify['priority'],
                        'value' => $classify['value'],
                        'color' => $classify['color'],
                        'sla' => $classify['sla'],
                        'description' => $classify['description']
                    ]);
            } else {
                // Create new record
                IncidentClassify::create([
                    'priority' => $classify['priority'],
                    'value' => $classify['value'],
                    'color' => $classify['color'],
                    'sla' => $classify['sla'],
                    'description' => $classify['description']
                ]);
            }
        }

        // Handle deletion of records that are no longer in the request
        $idsToDelete = array_diff($existingIds, $requestIds);
        IncidentClassify::whereIn('id', $idsToDelete)->delete();
        return response()->json(['success' => true]);
    }

    public function getScoreData(Request $request)
    {
        if ($request->ajax()) {
            $criteriaScores = IncidentCriteria::with('IncidentScores')->get();
            $data = [];
            foreach ($criteriaScores as $criteria) {
                foreach ($criteria->IncidentScores as $index => $score) {
                    $data[] = [
                        'criteria' => ($index == 0 ? $criteria->name : ""),
                        'score' => $score->title . ' (' . $score->point . ')'
                    ];
                }
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->rawColumns(['criteria', 'score'])
                ->make(true);
        }
    }

    public function store_ira(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string',
            'responsible_type' => 'required|in:user,team',
        ]);

        // Check if the incident_ira record exists
        $incidentIra = IncidentIra::firstOrNew();
        $incidentIra->name = $validatedData['name'];
        $incidentIra->type = $validatedData['responsible_type'];
        $incidentIra->save();


        // Attach users or teams based on responsible_type
        if ($request->responsible_type === 'user') {
            // Sync users
            $incidentIra->users()->sync($request->responsible_ids);
        } elseif ($request->responsible_type === 'team') {
            // Sync teams
            $incidentIra->teams()->sync($request->team_ids);
        }

        $response = array(
            'status' => true,
            'message' => __('incident.IncidentIRAWasUpdatedSuccessfully'),
        );
        return response()->json($response, 200);
    }

    public function getClassifyData(Request $request)
    {
        if ($request->ajax()) {
            $classifies = IncidentClassify::all();
            return DataTables::of($classifies)
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function getPlaybookData(Request $request)
    {
        if ($request->ajax()) {
            $playbooks = PlayBook::all();
            return DataTables::of($playbooks)
                ->addIndexColumn()
                ->addColumn('actions', function ($playbook) {
                    return '<a href="javascript:;" class="m-2" onClick="showPlayBookActionForm(' . $playbook->id . ')" ><i class="fa fa-plus"></i></a>
                <a href="javascript:;" class="mm-2"  onClick="showEditPlaybookForm(' . $playbook->id . ')"><i class="fa fa-edit"></i></a>
                   <a href="javascript:;" class="m-2 text-danger"  onClick="ShowModalDeletePlayBook(' . $playbook->id . ')"><i class="fa fa-trash"></i></a> ';
                })
                ->rawColumns(['actions']) // Render HTML in actions column
                ->make(true);
        }
    }
    public function store_playbook(Request $request)
    {
        $request->validate([
            'playbook_name' => 'required|string|max:255',
            'responsible_type' => 'required|string|in:user,team'
        ]);

        $playbook = PlayBook::create([
            'name' => $request->playbook_name,
            'type' => $request->responsible_type,
        ]);
        if ($request->responsible_type === 'user') {
            $responsibleIds = $request->responsible_ids ?? [];
            $playbook->users()->attach($responsibleIds);
        } elseif ($request->responsible_type === 'team') {
            $teamIds = $request->team_ids ?? [];
            $playbook->teams()->attach($teamIds);
        }

        return response()->json(['success' => true]);
    }

    public function update_playbook(Request $request)
    {
        // dd($request->all());

        // Validate the input data
        $request->validate([
            'playbook_id' => 'required|exists:play_books,id',
            'playbook_name' => 'required|string|max:255',
            'responsible_type' => 'required|string|in:user,team'
        ]);

        // Find the playbook by ID
        $playbook = PlayBook::findOrFail($request->playbook_id);

        // Update the playbook's name and type
        $playbook->update([
            'name' => $request->playbook_name,
            'type' => $request->responsible_type,
        ]);

        if ($request->responsible_type === 'user') {
            $responsibleIds = $request->responsible_ids ?? [];
            $playbook->users()->sync($responsibleIds);
        } elseif ($request->responsible_type === 'team') {
            $teamIds = $request->team_ids ?? [];
            $playbook->teams()->sync($teamIds);
        }


        return response()->json(['success' => true]);
    }

    public function delete_playbook(Request $request, $id)
    {
        $playbook = PlayBook::find($id);
        if ($playbook) {
            $playbook->delete();
        }
        return response()->json(['success' => true]);
    }
    public function edit_playbook(Request $request, $id)
    {
        $playbook = PlayBook::with(['users', 'teams'])->find($id);
        if (!$playbook) {
            return response()->json(['message' => 'Playbook not found'], 404);
        }

        return response()->json(['success' => true, 'playbook' => [
            'name' => $playbook->name,
            'type' => $playbook->type,
            'responsible_ids' => $playbook->users->pluck('id'),
            'team_ids' => $playbook->teams->pluck('id'),
        ]]);
    }

    public function getPlayBookUser(Request $request, $id){
        $playbook = PlayBook::findOrFail($id);

        $responseData = [];

        if ($playbook->type === 'user') {
            $responseData['responsibles'] = $playbook->users()->get(['users.id', 'users.name']);
        } elseif ($playbook->type === 'team') {
            $responseData['responsibles'] = $playbook->teams()->get(['teams.id', 'teams.name']);
        } else {
            return response()->json(['error' => 'Invalid responsible type'], 400);
        }

        // Return the data in a JSON response
        return response()->json([
            'success' => true,
            'playbook' => $playbook->only(['id', 'name', 'type']),
            'responsible_data' => $responseData
        ]);
    }
    public function getPlayBookActionData(Request $request, $id)
    {
        $playbook = PlayBook::with([
            'containmentActions',
            'eradicationActions',
            'recoveryActions'
        ])->findOrFail($id);



        $containments = [];
        $eradications = [];
        $recoveries = [];

        $containments = Containment::all(['id', 'name']);
        $eradications = Eradication::all(['id', 'name']);
        $recoveries = Recovery::all(['id', 'name']);

        return response()->json([
            'success' => true,
            'containments' => $playbook->containmentActions,
            'eradications' => $playbook->eradicationActions,
            'recoveries' => $playbook->recoveryActions,
            'containmentOptions' => $containments,
            'eradicationOptions' => $eradications,
            'recoveryOptions' => $recoveries,
            'playbook_id' => $playbook->id
        ]);
    }

    public function getActionData(Request $request)
    {
        $playBookId = $request->playBookId;
        $category  = $request->category;

        $actions = PlayBookAction::where('category_type', $category)
            ->whereDoesntHave('playBooks', function ($query) use ($playBookId) {
                $query->where('play_book_id', $playBookId);
            })
            ->get();
        // dd($actions);

        return response()->json(['success' => true, 'actions' => $actions]);
    }

    public function store_playbook_action(Request $request)
    {

        try {

            if ($request->action_type === 'exist') {

                PlayBookActionPlayBook::create([
                    'play_book_action_id' => $request->action_id,
                    'play_book_id' => $request->playbook,
                    'category_type' => $request->category
                ]);
            } elseif ($request->action_type === 'new') {
                $new_action =   PlayBookAction::create([
                    'title' => $request->action_name,
                    'category_type' => $request->category
                ]);
                PlayBookActionPlayBook::create([
                    'play_book_action_id' => $new_action->id,
                    'play_book_id' => $request->playbook,
                    'category_type' => $request->category
                ]);
            }

            return response()->json(['success' => true, 'playbook' => $request->playbook]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false]);
        }
    }

    public function delete_playbook_action(Request $request, $action, $playbook)
    {

        $action = PlayBookAction::findOrFail($action);

        $associatedPlaybooksCount = $action->playbooks()->count();

        if ($associatedPlaybooksCount > 1) {
            $action->playbooks()->detach($playbook);
        } else {
            $action->delete();
        }

        return response()->json(['success' => true,'playbook'=> $playbook]);
    }
    public function update_playbook_action(Request $request, $action, $playbook)
    {

        $action = PlayBookActionPlayBook::where('play_book_action_id',$action)->where('play_book_id',$playbook)->first();


        if ($action) {
            $action->update(['category_id'=>$request->category_id]);
        } else {
            $action->delete();
        }

        $response = array(
            'status' => true,
            'playbook'=> $playbook,
            'message' => __('incident.ActionAWasUpdatedSuccessfully'),
        );
        return response()->json($response, 200);
    }


    protected function calculateRisk($CLASSIC_impact, $CLASSIC_likelihood)
    {

        $countOfImpacts = IncidentImpact::count();
        $countOfLikelihoods = $countOfImpacts;
        $max_risk = '';
        $risk = '';
        if ($countOfImpacts > 0 && $countOfLikelihoods > 0 && $CLASSIC_impact && $CLASSIC_likelihood) {  // If the impact or likelihood are passed

            $max_risk = $countOfLikelihoods + $countOfImpacts;
            $risk = $CLASSIC_likelihood + $CLASSIC_impact;
        } else { // If the impact or likelihood are not passed
            $risk = null;
        }

        return $risk ? $risk : 0;
    }

    public function impacts(Request $request)
    {
        if ($request->ajax()) {
            $table_name = $request->table_name;
            $model = 'App\\Models\\' . Str::studly(Str::singular($request->table_name));
            $results = $model::all();
            return $results;
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store_impacts(Request $request)
    {

        $level = IncidentImpact::max('level');
        if ($level) {
            $level = $level + 1;
        } else {
            $level = 1;
        }

        $modelData = IncidentImpact::create([
            'impact' => $request->impact,
            'likelihood' => $request->likelihood,
            'level' => $level
        ]);


        $model = 'App\\Models\\' . Str::studly(Str::singular($request->table_name));
        $modelName = class_basename($model);

        $message = __('locale.A New') . ' ' . ($modelName ?? __('locale.[No Model Name]')) . ' ' . __('locale.Added with impact') . ' "' . ($modelData->impact ?? '[No impact]') . '" ' . __('locale.CreatedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
        write_log($modelData->id, auth()->id(), $message, 'Creating');
        return $modelData;
    }

    public function update_impacts(Request $request)
    {

        if ($request->ajax()) {

            $model = 'App\\Models\\' . Str::studly(Str::singular($request->table_name));

            $data = [
                'impact' => $request->impact,
                'likelihood' => $request->likelihood,
            ];

            $model::where('id', $request->id)->update($data);
            $modelName = class_basename($model);
            $message = __('locale.') . ($modelName ?? __('locale.[No Model Name]')) . ' "' . ($data['name'] ?? '[No Name]') . '" ' . __('locale.UpdatedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
            write_log(1, auth()->id(), $message, 'Updating');
            return "done";
        }
    }

    public function delete_impacts(Request $request)
    {
        if ($request->ajax()) {
            $model = 'App\\Models\\' . Str::studly(Str::singular($request->table_name));
            $model::where('id', $request->id)->delete();

            // Fetch all remaining records ordered by their current 'level'
            $incidentImpacts = IncidentImpact::all();


            $newLevel = 1;
            foreach ($incidentImpacts as $impact) {
                $impact->level = $newLevel++;
                $impact->save();
            }

            $modelName = class_basename($model);
            $message = __('locale.') . ($modelName ?? __('locale.[No Model Name]')) . ' ' . __('locale.Deleted item from it') . ' ' . __('locale.DeletedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
            write_log(1, auth()->id(), $message, 'deleting');
            return "done";
        }
    }

    public function levels(Request $request)
    {
        if ($request->ajax()) {
            $table_name = $request->table_name;
            $model = 'App\\Models\\' . Str::studly(Str::singular($request->table_name));
            $results = $model::all();
            return $results;
        }
    }

    public function store_levels(Request $request)
    {


        $modelData = IncidentLevel::create([
            'level' => $request->level,
            'color' => $request->color,
        ]);


        $model = 'App\\Models\\' . Str::studly(Str::singular($request->table_name));
        $modelName = class_basename($model);

        $message = __('locale.A New') . ' ' . ($modelName ?? __('locale.[No Model Name]')) . ' ' . __('locale.Added with level') . ' "' . ($modelData->impact ?? '[No impact]') . '" ' . __('locale.CreatedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
        write_log($modelData->id, auth()->id(), $message, 'Creating');
        return $modelData;
    }

    public function update_levels(Request $request)
    {

        if ($request->ajax()) {

            $model = 'App\\Models\\' . Str::studly(Str::singular($request->table_name));

            $data = [
                'level' => $request->level,
                'color' => $request->color,
            ];

            $model::where('id', $request->id)->update($data);
            $modelName = class_basename($model);
            $message = __('locale.') . ($modelName ?? __('locale.[No Model Name]')) . ' "' . ($data['name'] ?? '[No Name]') . '" ' . __('locale.UpdatedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
            write_log(1, auth()->id(), $message, 'Updating');
            return "done";
        }
    }

    public function delete_levels(Request $request)
    {
        if ($request->ajax()) {
            $model = 'App\\Models\\' . Str::studly(Str::singular($request->table_name));
            $model::where('id', $request->id)->delete();
            $modelName = class_basename($model);
            $message = __('locale.') . ($modelName ?? __('locale.[No Model Name]')) . ' ' . __('locale.Deleted item from it') . ' ' . __('locale.DeletedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
            write_log(1, auth()->id(), $message, 'deleting');
            return "done";
        }
    }

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
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
