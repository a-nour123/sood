<?php

namespace App\Http\Controllers\admin\incident;

use App\Events\IncidentCreated;
use App\Events\IncidentIraCreated;
use App\Exports\RisksExport;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\IncidentClassify;
use App\Models\Risk;
use App\Models\IncidentEvidence;
use App\Models\User;
use App\Models\Action;
use App\Models\Detected;
use App\Models\Attack;
use App\Models\Containment;
use App\Models\Direction;
use App\Models\Eradication;
use App\Models\Incident;
use App\Models\IncidentCriteria;
use App\Models\IncidentCriteriaScore;
use App\Models\IncidentImpact;
use App\Models\IncidentIra;
use App\Models\IncidentLevel;
use App\Models\IncidentPlayBookAction;
use App\Models\Occurrence;
use App\Models\PlayBook;
use App\Models\PlayBookAction;
use App\Models\PlayBookActionPlayBook;
use App\Models\Recovery;
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
use Spatie\PdfToImage\Pdf;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;

class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],  

        ['name' => __('incident.incident')],
    ];
        $events = Occurrence::all();
        $users = User::all();
        $play_books = PlayBook::all();
        $active_user = auth()->user()->id;
        $directions = Direction::all();
        $attacks = Attack::all();
        $detects = Detected::all();
        $incidents = Incident::all();
        $risks = Risk::all();
        $assets = Asset::all();
        $criteriaScores = IncidentCriteria::with('IncidentScores')->get();

        return view('admin.content.incident.index', compact('breadcrumbs', 'play_books', 'users', 'active_user', 'incidents', 'criteriaScores', 'risks', 'assets', 'events', 'directions', 'attacks', 'detects'));
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {

            $incidents = Incident::all();
            return DataTables::of($incidents)
                ->addIndexColumn()
                ->addColumn('occurrence_name', function ($incident) {
                    return $incident->occurrence ? $incident->occurrence->name : 'N/A';
                })
                ->addColumn('direction_name', function ($incident) {
                    return $incident->direction ? $incident->direction->name : 'N/A';
                })
                ->addColumn('attack_name', function ($incident) {
                    return $incident->attack ? $incident->attack->name : 'N/A';
                })
                ->addColumn('detected_name', function ($incident) {
                    return $incident->detected ? $incident->detected->name : 'N/A';
                })
                ->addColumn('actions', function ($incidents) {
                    $authUser = Auth::user();

                    $isUserInvolved = $incidents->incidentUsers()->where('user_id', $authUser->id)->exists();

                    $isUserInTeam = $incidents->incidentTeams()->whereHas('users', function ($query) use ($authUser) {
                        $query->where('id', $authUser->id);
                    })->exists();

                    $playbookUsers = $incidents->playbookUsers()->where('user_id', $authUser->id)->exists();

                    $playbookTeams = $incidents->playbookTeams()->whereHas('users', function ($query) use ($authUser) {
                        $query->where('id', $authUser->id);
                    })->exists();


                    $btns = '';
                    if ($isUserInvolved || $isUserInTeam) {
                        $btns .= '<a href="javascript:;" class="m-2"  onClick="showEditIncidentForm(' . $incidents->id . ')"><i class="fa fa-edit"></i></a>';
                    }
                    if ($playbookUsers || $playbookTeams) {
                        $btns .=  '<a href="javascript:;" class="m-2"  onClick="showEditCsritIncidentForm(' . $incidents->id . ')"><i class="fa fa-eye"></i></a>';
                    }
                    return $btns;
                    dd($btns);
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    }


    public function statistics()
    {

        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], 
        
        ['link' => route('admin.incident.index'), 'name' => __('incident.incident')], ['name' => __('incident.statistics')]];
        $incident_count = Incident::count();
        $open_incident_count = Incident::where('status', 'open')->count();
        $progress_incident_count = Incident::where('status', 'progress')->count();
        $closed_incident_count = Incident::where('status', 'closed')->count();

        $priorityData = [];

        // Fetch all incidents
        $incidents = Incident::all();
        
        foreach ($incidents as $incident) {
            // Calculate the total score for the incident
            $totalScore = $this->calculateTotalScore($incident);
        
            // Find the matching classification based on the total score
            $classify = IncidentClassify::where('value', '>=', $totalScore)
                ->orderBy('value', 'asc')
                ->first();
        
            if ($classify) {
                // Initialize the classification if it doesn't exist
                if (!isset($priorityData[$classify->id])) {
                    $priorityData[$classify->id] = [
                        'open' => 0,
                        'progress' => 0,
                        'closed' => 0,
                        'colors' => [
                            'open' => $classify->color,     // Color for Open status
                            'progress' => $classify->color, // Color for Progress status
                            'closed' => $classify->color,   // Color for Closed status
                        ],
                    ];
                }
        
                // Increment the status count for the classification
                $priorityData[$classify->id][$incident->status]++;
            }
        }
        
        $chartData = [
            'categories' => ['Open', 'Progress', 'Closed'],  // Categories are the statuses
            'series' => []
        ];
        

        foreach ($priorityData as $priority => $counts) {
            $classify = IncidentClassify::find($priority);  // Fetch the classification by ID
            if ($classify) {
                $chartData['series'][] = [
                    'name' =>  $classify->priority,  // Add classification name to series
                    'color' => $classify->color, 
                    'data' => [
                        [
                            'y' => $counts['open'],      // 'y' for "Open" status
                            'color' => $counts['open'] > 0 ? $classify->color : '#808080', // Color for "Open" status
                        ],
                        [
                            'y' => $counts['progress'],  // 'y' for "Progress" status
                            'color' => $counts['progress'] > 0 ? $classify->color : '#808080', // Color for "Progress" status
                        ],
                        [
                            'y' => $counts['closed'],    // 'y' for "Closed" status
                            'color' => $counts['closed'] > 0 ? $classify->color : '#808080', // Color for "Closed" status
                        ],
                    ],
                ];
            } else {
             
                $chartData['series'][] = [
                    'name' => $priority . ' (Unknown)',
                    'data' => [
                        [
                            'y' => $counts['open'],      // 'y' for "Open" status
                            'color' => '#808080',        // Default color for unknown classifications
                        ],
                        [
                            'y' => $counts['progress'],  // 'y' for "Progress" status
                            'color' => '#808080',        // Default color for unknown classifications
                        ],
                        [
                            'y' => $counts['closed'],    // 'y' for "Closed" status
                            'color' => '#808080',        // Default color for unknown classifications
                        ],
                    ],
                   
                ];
            }
        }


        return view('admin.content.incident.graph', compact(
            'breadcrumbs',
            'incident_count',
            'open_incident_count',
            'progress_incident_count',
            'closed_incident_count',
            'chartData'
        ));
    }

    private function calculateTotalScore($incident)
    {
        // Fetch data directly from the `incident_criteria_scores` and `incident_scores` tables
        $criteriaScores = DB::table('incident_criteria_scores as ics')
            ->join('incident_scores as is', 'ics.incident_score_id', '=', 'is.id')
            ->where('ics.incident_id', $incident->id)
            ->sum('is.point');


        return $criteriaScores;
    }

    public function editIraIncident(Request $request, $id)
    {
        $incident = Incident::findOrFail($id);
        $criteria_scores = $incident->criteriaScores->pluck('pivot.incident_score_id', 'pivot.incident_criteria_id')->toArray();
        $playBook = PlayBook::find($incident->play_book_id);

        $incidentId = $incident->id;

        $response = [
            'incident' => [
                'related_incidents' => $incident->relatedIncidents ? $incident->relatedIncidents->pluck('id')->toArray() : [],
                'related_risks' => $incident->relatedRisks ? $incident->relatedRisks->pluck('id')->toArray() : [],
                'affected_assets' => $incident->affectedAssets ? $incident->affectedAssets->pluck('id')->toArray() : [],
                'source' => $incident->source,
                'destination' => $incident->destination,
                'criteria_scores' => $incident->criteriaScores->pluck('pivot.incident_score_id', 'pivot.incident_criteria_id')->toArray() ?? [],
                'incident' => $incident
            ]
        ];



        return response()->json($response);
    }

    public function editCsritIncident(Request $request, $id)
    {

        $incident = Incident::findOrFail($id);
        $criteria_scores = $incident->criteriaScores->pluck('pivot.incident_score_id', 'pivot.incident_criteria_id')->toArray();
        $playBook = PlayBook::find($incident->play_book_id);

        $incidentId = $incident->id;
        $groupedActions = PlayBookActionPlayBook::where('play_book_id', $playBook->id)
            ->get()
            ->groupBy('category_type')
            ->map(function ($actions, $categoryType) use ($incidentId) {
                return $actions->groupBy('category_id')->map(function ($grouped) use ($categoryType, $incidentId) {
                    $categoryName = '';

                    // Fetch category name based on category type
                    foreach ($grouped as $item) {
                        switch ($categoryType) {
                            case 'containments':
                                $categoryName = Containment::find($item->category_id)->name ?? 'Unknown Category';
                                break;
                            case 'eradications':
                                $categoryName = Eradication::find($item->category_id)->name ?? 'Unknown Category';
                                break;
                            case 'recoveries':
                                $categoryName = Recovery::find($item->category_id)->name ?? 'Unknown Category';
                                break;
                        }
                        break; // Get the category name from the first item (assuming all have the same category)
                    }

                    // Return grouped actions by category, including `action_id`, `status`, and evidence
                    return [
                        'category' => $categoryName,
                        'actions' => $grouped->map(function ($item) use ($incidentId) {
                            // Fetch the status of the action for the specific incident
                            $incidentAction = IncidentPlayBookAction::where('play_book_action_id', $item->id)
                                ->where('playbook_id', $item->play_book_id)
                                ->where('incident_id', $incidentId)
                                ->first();

                            // Check if there are any evidence records for this action
                            $hasEvidences = false;
                            $evidenceCount = 0;
                            if ($incidentAction) {
                                $hasEvidences = $incidentAction->evidences()->exists();
                                $evidenceCount = $incidentAction->evidences()->count();
                            }

                            return [
                                'id' => $item->id, // Action ID
                                'title' => $item->playBookAction->title, // Action Title
                                'link' => $item->playBookAction->link ?? '#', // Optional link if available
                                'status' => $incidentAction->status ?? 0, // Status, defaulting to 0 if not found
                                'has_evidences' => $hasEvidences, // Boolean if evidence exists
                                'evidence_count' => $evidenceCount, // Number of evidences if any
                            ];
                        })->toArray(),
                    ];
                });
            });

        $response = [
            'incident' => [
                'groupedActions' => $groupedActions,
                'related_incidents' => $incident->relatedIncidents ? $incident->relatedIncidents->pluck('id')->toArray() : [],
                'related_risks' => $incident->relatedRisks ? $incident->relatedRisks->pluck('id')->toArray() : [],
                'affected_assets' => $incident->affectedAssets ? $incident->affectedAssets->pluck('id')->toArray() : [],
                'source' => $incident->source,
                'destination' => $incident->destination,
                'criteria_scores' => $incident->criteriaScores->pluck('pivot.incident_score_id', 'pivot.incident_criteria_id')->toArray() ?? [],
                'incident' => $incident
            ]
        ];


        return response()->json($response);
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
        $validator =  Validator::make($request->all(), [
            'summary' => 'required|string',
            'occurrence_id' => 'required|integer',
            'direction_id' => 'required|integer',
            'attack_id' => 'required|integer',
            'detected_id' => 'required|integer',
            'detected_on' => 'required|date',
        ]);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('locale.ThereWasAProblemAddingTheIncident') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            try {
                $ira = IncidentIra::first();
                $type = null;
                if ($ira) {
                    $type = $ira->type;
                }
                $incident = Incident::create([
                    'summary' => $request->summary,
                    'details' => $request->details,
                    'occurrence_id' => $request->occurrence_id,
                    'direction_id' => $request->direction_id,
                    'attack_id' => $request->attack_id,
                    'detected_id' => $request->detected_id,
                    'detected_on' => $request->detected_on,
                    'type' => $type,
                    'status' => $request->status,
                    'created_by' => Auth::id(),
                ]);


                if ($ira) {
                    if ($ira->type == 'user') {
                        $userIds = $ira->users()->pluck('user_id')->toArray();


                        // Attach users to the incident
                        $incident->incidentUsers()->attach($userIds);
                    } else {
                        // Get the associated teams
                        $teamIds = $ira->teams()->pluck('team_id')->toArray();


                        // Attach teams to the incident
                        $incident->incidentTeams()->attach($teamIds);
                    }
                } else {
                    // Log an error if no IncidentIra was found
                    \Log::error('No IncidentIra found.');
                }

                event(new IncidentCreated($incident));

                $response = array(
                    'status' => true,
                    'message' => __('incident.IncidentWasAddedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {

                dd($th);
                $response = array(
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                );
                return response()->json($response, 502);
            }
        }
    }

    public function iraStore(Request $request)
    {

        DB::beginTransaction();
        try {

            $incident = Incident::findOrFail($request->incident_id);

            $incident->status = $request->status;
            $incident->detected_on = $request->detected_on;
            $incident->source = $request->source;
            $incident->destination = $request->destination;
            $incident->occurrence_id = $request->occurrence_id;
            $incident->reported_id = $request->reported_id;
            $incident->play_book_id = $request->play_book_id;


            $playbook = Playbook::findOrFail($request->play_book_id);


            $playbook_type = $playbook->type;
            $incident->playbook_type = $playbook_type;

            $users_team = [];
            if ($playbook_type === 'user') {
                $incident->playbookUsers()->sync($playbook->users()->pluck('user_id')->toArray());
                $users_team = $playbook->users()->pluck('user_id')->toArray();
                // Sync the related users from the playbook
            } elseif ($playbook_type === 'team') {
                $incident->playbookTeams()->sync($playbook->teams()->pluck('team_id')->toArray());
                $users_team = $playbook->teams()->pluck('team_id');
                // Sync the related teams from the playbook
            }


            $incident->save();



            // Sync related incidents (many-to-many relationship)
            if ($request->has('related_incidents')) {
                $incident->relatedIncidents()->sync($request->related_incidents);
            }

            // Sync related risks (many-to-many relationship)
            if ($request->has('related_risks')) {
                $incident->relatedRisks()->sync($request->related_risks);
            }

            // Sync affected assets (many-to-many relationship)
            if ($request->has('affected_assets')) {
                $incident->affectedAssets()->sync($request->affected_assets);
            }


            // Sync incident criteria scores (one-to-many relationship)
            if ($request->has('criteria_scores')) {


                foreach ($request->criteria_scores as $key => $scoreData) {
                    IncidentCriteriaScore::updateOrCreate(
                        [
                            'incident_id' => $incident->id,
                            'incident_criteria_id' => $key
                        ],
                        [
                            'incident_score_id' => $scoreData ?? null,
                        ]
                    );
                }
            }

            DB::commit();

            event(new IncidentIraCreated($incident, $playbook_type, $users_team));

            $response = array(
                'status' => true,
                'message' => __('incident.IncidentWasAddedSuccessfully'),
            );
            return response()->json($response, 200);
        } catch (\Throwable $th) {


            DB::rollBack();
            \Log::error("Error in iraStore: " . $th->getMessage());

            return response()->json(['error' => 'Something went wrong, please try again later.'], 500);
        }
    }

    public function csritStore(Request $request)
    {


        // Validate incoming data
        $request->validate([
            'action_ids' => 'required|array',
            'action_status' => 'required|array',
            'incident_ids' => 'required|array',
            'playbook_ids' => 'required|array'
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->action_ids as $actionId) {
                $status = $request->input('action_status.' . $actionId);
                $incidentId = $request->input('incident_ids.' . $actionId);
                $playbookId = $request->input('playbook_ids.' . $actionId);

                IncidentPlayBookAction::updateOrCreate(
                    [
                        // Conditions to find the existing record
                        'play_book_action_id' => $actionId,
                        'playbook_id' => $playbookId,
                        'incident_id' => $incidentId,
                    ],
                    [
                        // Fields to update or set if creating a new record
                        'status' => $status,
                    ]
                );
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => __('locale.All statuses updated successfully.')
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => __('locale.Failed to update statuses.')
            ], 500);
        }
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


    public function storeEvidence(Request $request)
    {
        $rules = [
            'evidence_play_book_id' => ['required', 'exists:play_books,id'],
            'evidence_incident_id' => ['required', 'integer', 'exists:incidents,id'],
            'evidence_action_id' => ['required', 'integer', 'exists:play_book_actions,id'],
            'evidence_description' => ['required', 'max:500'],
            'evidence_file' => ['nullable', 'file', 'max:5000'],
        ];

        $customAttributes = [
            'evidence_play_book_id' => 'Play Book',
            'evidence_incident_id' => 'Incident',
            'evidence_action_id' => 'Action',
            'evidence_description' => 'Description',
            'evidence_file' => 'File',
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


                $fileName = null;
                $uniqueFileName = null;
                if ($request->hasFile('evidence_file')) {
                    if ($request->file('evidence_file')->isValid()) {
                        $fileName = $request->file('evidence_file')->getClientOriginalName();
                        $uniqueFileName = $request->file('evidence_file')->store('incident_evidences/' . $request->control_control_objective_id);
                    } else {
                        $fileName = null;
                        $uniqueFileName = null;
                        $response = array(
                            'status'  => false,
                            'errors'  => ['evidence_file' => ['There were problems uploading the files']],
                            'message' => __('governance.ThereWasAProblemAddingTheEvidence')
                                . "<br>" . __('locale.Validation error'),
                        );
                    }
                } else {
                    $fileName = null;
                    $uniqueFileName = null;
                }


                $playbookId = $request->input('evidence_play_book_id');
                $incidentId = $request->input('evidence_incident_id');
                $actionId = $request->input('evidence_action_id');
                $description = $request->input('evidence_description');
                $file = $request->file('evidence_file');

                $incidentPlayBookAction = IncidentPlayBookAction::firstOrCreate(
                    [
                        'playbook_id' => $playbookId,
                        'incident_id' => $incidentId,
                        'play_book_action_id' => $actionId,
                    ],
                    [
                        'status' => 2, // Default values if it doesn't exist
                        'active' => 0,
                    ]
                );


                $evidence = new IncidentEvidence();
                $evidence->incident_play_book_action_id = $incidentPlayBookAction->id;
                $evidence->creator_id = Auth::id();
                $evidence->description = $description;
                $evidence->file_name = $fileName;
                $evidence->file_unique_name = $uniqueFileName;
                $evidence->save();

                $data = [
                    'playbookId' => $request->input('evidence_play_book_id'),
                    'incidentId' => $request->input('evidence_incident_id'),
                    'actionId' => $request->input('evidence_action_id')
                ];


                DB::commit();
                $message = __('governance.AnEvidenceWithDescription') . ' "'
                    . ($evidence->description ?? __('locale.[No Name]')) . '". '
                    . (isset($controlControlObjective->objective)
                        ? __('governance.HasBeenAddedToRequirement') . ' "' . $controlControlObjective->objective->name . '". '
                        : __('locale.[No Requirement Name]') . '. ')
                    . __('governance.OnControl') . ' "'
                    . ($controlControlObjective->control->short_name ?? __('locale.[No Control Name]')) . '". '
                    . __('locale.By') . ' "' . auth()->user()->name . '".';


                write_log($evidence->id, auth()->id(), $message, 'adding evidence');
                $response = array(
                    'status' => true,
                    'data' => $data,
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

    public function getEvidences($action_id, $incident_id, $play_book_id)
    {
        // Retrieve the IncidentPlayBookAction based on the given parameters
        $incidentPlayBookAction = IncidentPlayBookAction::where('playbook_id', $play_book_id)
            ->where('incident_id', $incident_id)
            ->where('play_book_action_id', $action_id)
            ->first();

        // If no IncidentPlayBookAction is found, return an error response
        if (!$incidentPlayBookAction) {
            return response()->json([
                'status' => false,
                'message' => 'No incident playbook action found for the given IDs.',
            ], 404);
        }

        // Retrieve the evidences associated with the IncidentPlayBookAction
        $evidences = $incidentPlayBookAction->evidences;

        // Ensure $evidences is an iterable collection
        if (!is_iterable($evidences)) {
            return response()->json([
                'status' => false,
                'message' => 'No evidences found for this action.',
            ], 404);
        }

        // Add creator name to each evidence
        foreach ($evidences as &$evidence) {
            $evidence->created_by = $evidence->creator->name;
        }

        $incident = Incident::find($incident_id)->summary;
        $playBook =  PlayBook::find($play_book_id)->name;
        $action =  PlayBookAction::find($action_id)->title;
        // Prepare additional data for the response


        return response()->json([
            'status' => true,
            'data' => [
                'playbookId' => $play_book_id,
                'incidentId' => $incident_id,
                'actionId' => $action_id,
                'incident' => $incident,
                'playBook' => $playBook,
                'action' => $action,
                'evidences' => $evidences,
            ],
        ]);
    }

    public function getEvidence($evidenceId)
    {
        $evidence = IncidentEvidence::where('id', $evidenceId)->first();
        $evidence->created_by =   $evidence->creator->name;
        return $evidence;
    }

    public function updateEvidence(Request $request)
    {

        $rules = [
            'evidence_id' => ['required', 'exists:incident_evidence,id'],
            'edited_evidence_description' => ['required', 'max:500'],
            'edited_evidence_file' => ['nullable', 'file', 'max:5000'],
        ];
        $customAttributes = [
            'evidence_id' => 'Evidence',
        ];


        $validator = Validator::make($request->all(), $rules);
        $validator->setAttributeNames($customAttributes);

        // Retrieve the evidence record by ID
        $evidence = IncidentEvidence::find($request->evidence_id);

        if (!$evidence) {
            // If evidence is not found, handle the error
            return response()->json([
                'status'  => false,
                'message' => __('Evidence not found.'),
            ], 404);
        }


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


                $existingFileName = $evidence->file_name;
                $existingFileUniqueName = $evidence->file_unique_name;
                if ($request->hasFile('edited_evidence_file')) {
                    if ($request->file('edited_evidence_file')->isValid()) {
                        $fileName = $request->file('edited_evidence_file')->getClientOriginalName();
                        $fileUniqueName = $request->file('edited_evidence_file')->store('incident_evidences/' . $evidence->control_control_objective_id);
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


                $message = __('governance.AnEvidenceWithDescription') . ' "' . ($evidence->description ??  __('locale.[No Name]')) . ' "'  .  __('locale.By') . ' "' . auth()->user()->name . '".';
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
            $evidence = IncidentEvidence::where('id', $evidenceId)->first();
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

    public function viewEvidenceFile($id)
    {

        $evidence = IncidentEvidence::find($id);
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

    public function deleteEvidence($id)
    {
        // Retrieve the evidence by its ID
        $evidence = IncidentEvidence::find($id);
        if ($evidence) {
            $actionId = $evidence->playBookAction->play_book_action_id ?? null;
            $playbookId = $evidence->playBookAction->playbook_id ?? null;
            $incidentId = $evidence->playBookAction->incident_id ?? null;
            DB::beginTransaction();
            try {



                $existingFileUniqueName = $evidence->file_unique_name;

                $evidence->delete();
                // Delete associated file from storage if it exists
                if ($existingFileUniqueName) {
                    Storage::delete($existingFileUniqueName);
                }
                // Retrieve updated evidences after deletion

                DB::commit();

                $response = array(
                    'status' => true,
                    'actionId' => $actionId,
                    'playbookId' => $playbookId,
                    'incidentId' => $incidentId,
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


    public function notificationsSettingsIncident()
    {
        // defining the breadcrumbs that will be shown in page
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.incident.index'), 'name' => __('incident.incident')],
            ['name' => __('locale.NotificationsSettings')]
        ];

        $users = User::select('id', 'name')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [112, 113];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            112 => [],
            113 => [],
        ];


        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [
            112 => ['Responsible-Person' => __('locale.ResponsiblePerson'), 'Team-teams' => __('locale.Teams')],
            113 => ['Responsible-Person' => __('locale.ResponsiblePerson'), 'Team-teams' => __('locale.Teams')],
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
        $actionsWithSettingsAuto = [];

        return view('admin.notifications-settings.index', compact('breadcrumbs', 'users', 'actionsWithSettings', 'actionsVariables', 'actionsRoles', 'moduleActionsIdsAutoNotify', 'actionsWithSettingsAuto'));
    }
}
