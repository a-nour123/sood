<?php

namespace App\Http\Controllers\admin\incident;

use App\Events\EvidenceIncidentCreated;
use App\Events\EvidenceIncidentDeleted;
use App\Events\EvidenceIncidentUpdated;
use App\Events\IncidentCommentCreated;
use App\Events\IncidentCreated;
use App\Events\IncidentDeleted;
use App\Events\IncidentIraCreated;
use App\Events\playBookCategoryIncidentAction;
use App\Exports\IncidentExport;
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
use App\Models\IncidentComment;
use App\Models\IncidentCriteria;
use App\Models\IncidentCriteriaScore;
use App\Models\IncidentFile;
use App\Models\IncidentImpact;
use App\Models\IncidentIra;
use App\Models\IncidentLevel;
use App\Models\IncidentLog;
use App\Models\IncidentPlayBookAction;
use App\Models\Occurrence;
use App\Models\PapLevel;
use App\Models\PlayBook;
use App\Models\PlayBookAction;
use App\Models\PlayBookActionPlayBook;
use App\Models\Recovery;
use App\Models\TlpLevel;
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
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],

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
        $pap = PapLevel::all();
        $tlp = TlpLevel::all();
        // $assets = Asset::all();
        $criteriaScores = IncidentCriteria::with('IncidentScores')->get();

        return view('admin.content.incident.index', compact('breadcrumbs', 'play_books', 'users', 'active_user', 'incidents', 'criteriaScores', 'risks', 'events', 'directions', 'attacks', 'detects', 'pap', 'tlp'));
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {

            $query = Incident::query();

            // 🔹 Apply filters
            if ($request->filled('direction_id')) {
                $query->where('direction_id', $request->direction_id);
            }
            if ($request->filled('attack_id')) {
                $query->where('attack_id', $request->attack_id);
            }
            if ($request->filled('detected_id')) {
                $query->where('detected_id', $request->detected_id);
            }
            if ($request->filled('play_book_id')) {
                $query->where('play_book_id', $request->play_book_id);
            }
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }
            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            // 🔹 Load relationships
            $incidents = $query->with(['occurrence', 'direction', 'attack', 'detected', 'tlpLevel', 'papLevel'])->get();

            return DataTables::of($incidents)
                ->addIndexColumn()
                ->addColumn('occurrence_name', fn($i) => $i->occurrence->name ?? 'N/A')
                ->addColumn('direction_name', fn($i) => $i->direction->name ?? 'N/A')
                ->addColumn('attack_name', fn($i) => $i->attack->name ?? 'N/A')
                ->addColumn('detected_name', fn($i) => $i->detected->name ?? 'N/A')
                ->addColumn('tlp_data', fn($i) => $i->tlpLevel ? ['name' => $i->tlpLevel->name, 'color' => $i->tlpLevel->color] : null)
                ->addColumn('pap_data', fn($i) => $i->papLevel ? ['name' => $i->papLevel->name, 'color' => $i->papLevel->color] : null)
                ->addColumn('total_score', function ($i) {
                    $totalScore = $this->calculateTotalScore($i);
                    $classify = IncidentClassify::where('value', '>=', $totalScore)->orderBy('value', 'asc')->first();
                    return [
                        'score' => $totalScore,
                        'color' => $classify?->color ?? '#000',
                        'priority' => $classify?->priority ?? 'N/A',
                    ];
                })
                ->addColumn('actions', function ($i) {
                    $authUser = Auth::user();
                    $btns = '';
                    $isUserInvolved = $i->incidentUsers()->where('user_id', $authUser->id)->exists();
                    $isUserInTeam = $i->incidentTeams()->whereHas('users', fn($q) => $q->where('id', $authUser->id))->exists();
                    $playbookUsers = $i->playbookUsers()->where('user_id', $authUser->id)->exists();
                    $playbookTeams = $i->playbookTeams()->whereHas('users', fn($q) => $q->where('id', $authUser->id))->exists();

                    if ($isUserInvolved || $isUserInTeam) {
                        $btns .= '<a href="javascript:;" class="m-2" onClick="showEditIncidentForm(' . $i->id . ')"><i class="fa fa-edit"></i></a>';
                    }
                    if ($authUser->id == $i->created_by && (!$playbookUsers || !$playbookTeams)) {
                        $btns .= '<a href="javascript:;" class="m-2 text-danger" onclick="deleteIncident(' . $i->id . ')"><i class="fa fa-trash"></i></a>';
                    }
                    if ($playbookUsers || $playbookTeams || (($isUserInvolved || $isUserInTeam) && isset($i->play_book_id))) {
                        $btns .= '<a href="javascript:;" class="m-2" onClick="showEditCsritIncidentForm(' . $i->id . ')"><i class="fa fa-eye"></i></a>';
                        $btns .= '<a href="javascript:;" class="m-2" data-bs-toggle="modal" data-bs-target="#incidentStatisticsModal" data-incident-id="' . $i->id . '"><i class="fa fa-chart-bar"></i></a>';
                    }
                    return $btns;
                })
                ->editColumn('created_at', function ($i) {
                    return $i->created_at ? $i->created_at->format('Y-m-d H:i') : 'N/A';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    }


    public function export(Request $request)
    {
        $filters = $request->only([
            'direction_id',
            'attack_id',
            'detected_id',
            'play_book_id',
            'status',
            'date_from',
            'date_to'
        ]);

        return Excel::download(new IncidentExport($filters), 'incidents.xlsx');
    }

    public function showLogs($incidentId, $playbookId, $actionId)
    {
        $logs = IncidentLog::with('user')
            ->where('incident_id', $incidentId)
            ->where('playbook_id', $playbookId)
            ->where('action_id', $actionId)
            ->get();

        return response()->json(['logs' => $logs]);
    }
    public function showIncidentComments($incidentId, $playbookId, $actionId)
    {
        $comments = IncidentComment::where('incident_id', $incidentId)
            ->where('playbook_id', $playbookId)
            ->where('action_id', $actionId)
            ->with('user')
            ->get();

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

        return response()->json([
            'status' => true,
            'data' => $comments,
        ]);
    }

    public function sendIncidentComment(Request $request)
    {
        $rules = [
            'incident_id' => ['required', 'exists:incidents,id'],
            'playbook_id' => ['nullable'],
            'action_id' => ['nullable', 'integer'],
            'comment' => ['nullable', 'string'],
            'comment_file' => ['nullable', 'file']
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->toArray(),
                'message' => __('incident.ThereWasAProblemAddingTheComment') . "<br>" . __('locale.Validation error'),
            ], 422);
        }

        DB::beginTransaction();
        try {
            $fileName = '';
            $path = '';
            // File upload Start

            if ($request->hasFile('comment_file')) {
                $comment_file = $request->file('comment_file');
                $path = '';
                if ($comment_file->isValid()) {
                    $path = $comment_file->store('/incident_comments');
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

            $comment = IncidentComment::create([
                'user_id' => auth()->id(),
                'incident_id' => $request->incident_id,
                'playbook_id' => $request->playbook_id,
                'action_id' => $request->action_id,
                'comment' => $request->comment,
                'file_display_name' => $fileName,
                'file_unique_name' => $path,
            ]);


            $comment->formatted_created_at = $comment->created_at->format('Y-m-d H:i:s');


            event(new IncidentCommentCreated($comment));

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => __('incident.CommentWasAddedSuccessfully'),
                'data' => [
                    'comment' => $comment->load('user'),
                ]
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'errors' => [],
                'message' => __('incident.ThereAreUnexpectedProblems'),
                'debug' => $th->getMessage(), // remove in production
            ], 502);
        }
    }
    public function clearComments($incidentId, $playBookId, $actionId)
    {
        try {
            DB::beginTransaction();

            $comments = IncidentComment::where('incident_id', $incidentId)
                ->where('playbook_id', $playBookId)
                ->where('action_id', $actionId)
                ->get();

            foreach ($comments as $comment) {
                if ($comment->file_unique_name) {
                    Storage::delete($comment->file_unique_name);
                }
                $comment->delete();
            }

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => __('locale.CommentsWasDeletedSuccessfully'),
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => __('locale.ThereWasAProblemDeletingTheComments'),
            ], 500);
        }
    }



    public function downloadIncidentCommentFile($comment_id)
    {
        try {
            $comment = IncidentComment::where('id', $comment_id)->first() ?? null;
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

    public function statistics()
    {
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.incident.index'), 'name' => __('incident.incident')],
            ['name' => __('incident.statistics')]
        ];

        // Get all incidents for default view
        $incidents = Incident::with(['occurrence', 'direction', 'attack', 'detected', 'tlpLevel', 'papLevel', 'playBook'])->get();

        // Get counts and chart data
        $data = $this->getStatisticsData($incidents);

        return view('admin.content.incident.graph', array_merge([
            'breadcrumbs' => $breadcrumbs,
        ], $data));
    }

    public function filterStatistics(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $query = Incident::with(['occurrence', 'direction', 'attack', 'detected', 'tlpLevel', 'papLevel', 'playBook']);

        if ($from && $to) {
            // Use whereDate for date range (more reliable for date comparisons)
            $query->whereDate('created_at', '>=', $from)
                ->whereDate('created_at', '<=', $to);
        } elseif ($from) {
            // Only from date provided
            $query->whereDate('created_at', '>=', $from);
        } elseif ($to) {
            // Only to date provided
            $query->whereDate('created_at', '<=', $to);
        }

        $incidents = $query->get();

        return response()->json($this->getStatisticsData($incidents));
    }

    private function getStatisticsData($incidents)
    {
        // Basic counts
        $incident_count = $incidents->count();
        $open_incident_count = $incidents->where('status', 'open')->count();
        $progress_incident_count = $incidents->where('status', 'progress')->count();
        $closed_incident_count = $incidents->where('status', 'closed')->count();

        // Chart 1: Classification by Status
        $classificationData = $this->getClassificationChartData($incidents);

        // Chart 2: Attack Type Distribution
        $attackData = $this->getAttackTypeChartData($incidents);

        // Chart 3: Direction Distribution
        $directionData = $this->getDirectionChartData($incidents);

        // Chart 4: Status Over Time (Monthly)
        $statusOverTimeData = $this->getStatusOverTimeChartData($incidents);

        // Chart 5: TLP Level Distribution
        $tlpData = $this->getTLPChartData($incidents);

        // Chart 6: PAP Level Distribution
        $papData = $this->getPAPChartData($incidents);

        // Chart 7: Detection Method Distribution
        $detectionData = $this->getDetectionChartData($incidents);

        // Chart 8: Occurrence Type Distribution
        $occurrenceData = $this->getOccurrenceChartData($incidents);

        // Chart 9: PlayBook Distribution
        $playBookData = $this->getPlayBookChartData($incidents);

        return [
            'incident_count' => $incident_count,
            'open_incident_count' => $open_incident_count,
            'progress_incident_count' => $progress_incident_count,
            'closed_incident_count' => $closed_incident_count,
            'classificationData' => $classificationData,
            'attackData' => $attackData,
            'directionData' => $directionData,
            'statusOverTimeData' => $statusOverTimeData,
            'tlpData' => $tlpData,
            'papData' => $papData,
            'detectionData' => $detectionData,
            'occurrenceData' => $occurrenceData,
            'playBookData' => $playBookData // Fixed variable name (lowercase 'p')
        ];
    }


    private function getClassificationChartData($incidents)
    {
        $priorityData = [];

        foreach ($incidents as $incident) {
            $totalScore = $this->calculateTotalScore($incident);
            $classify = IncidentClassify::where('value', '>=', $totalScore)
                ->orderBy('value', 'asc')
                ->first();

            if ($classify) {
                // Use a unique key combining name and color to avoid duplicates
                $key = $classify->id . '_' . $classify->priority;

                if (!isset($priorityData[$key])) {
                    $priorityData[$key] = [
                        'open' => 0,
                        'progress' => 0,
                        'closed' => 0,
                        'color' => $classify->color,
                        'name' => $classify->priority,
                        'id' => $classify->id
                    ];
                }

                $priorityData[$key][$incident->status]++;
            }
        }

        // Sort by classification ID to maintain consistent order
        ksort($priorityData);

        $chartData = [
            'categories' => ['Open', 'In Progress', 'Closed'], // Improved labels
            'series' => []
        ];

        foreach ($priorityData as $key => $counts) {
            $chartData['series'][] = [
                'name' => $counts['name'],
                'color' => $counts['color'],
                'data' => [
                    $counts['open'],
                    $counts['progress'],
                    $counts['closed']
                ]
            ];
        }

        return $chartData;
    }

    private function getAttackTypeChartData($incidents)
    {
        return $incidents->groupBy(function ($incident) {
            return optional($incident->attack)->name ?? 'Unknown';
        })
            ->map(function ($group, $name) {
                return [
                    'name' => $name,
                    'y' => $group->count(),
                    'statusBreakdown' => [
                        'open' => $group->where('status', 'open')->count(),
                        'progress' => $group->where('status', 'progress')->count(),
                        'closed' => $group->where('status', 'closed')->count()
                    ]
                ];
            })
            ->values();
    }

    private function getDirectionChartData($incidents)
    {
        return $incidents->groupBy(function ($incident) {
            return optional($incident->direction)->name ?? 'Unknown';
        })
            ->map(function ($group, $name) {
                return [
                    'name' => $name,
                    'y' => $group->count()
                ];
            })
            ->values();
    }

    private function getStatusOverTimeChartData($incidents)
    {
        // Group by month and status
        $grouped = $incidents->groupBy(function ($incident) {
            return $incident->created_at->format('Y-m');
        });

        $months = $grouped->keys()->sort()->values();

        $statuses = ['open', 'progress', 'closed'];
        $series = [];

        foreach ($statuses as $status) {
            $data = [];
            foreach ($months as $month) {
                $data[] = $grouped->get($month, collect())->where('status', $status)->count();
            }

            $series[] = [
                'name' => ucfirst($status),
                'data' => $data
            ];
        }

        return [
            'categories' => $months->map(function ($month) {
                return \Carbon\Carbon::createFromFormat('Y-m', $month)->format('M Y');
            })->values(),
            'series' => $series
        ];
    }

    private function getTLPChartData($incidents)
    {
        return $incidents->groupBy(function ($incident) {
            return optional($incident->tlpLevel)->name ?? 'Unknown';
        })
            ->map(function ($group, $name) {
                return [
                    'name' => $name,
                    'y' => $group->count()
                ];
            })
            ->values();
    }
    private function getPlayBookChartData($incidents)
    {
        $playBookData = $incidents->groupBy(function ($incident) {
            return optional($incident->playBook)->name ?? 'No PlayBook';
        })
            ->map(function ($group, $name) {
                return [
                    'name' => $name,
                    'y' => $group->count(),
                    'statusBreakdown' => [
                        'open' => $group->where('status', 'open')->count(),
                        'progress' => $group->where('status', 'progress')->count(),
                        'closed' => $group->where('status', 'closed')->count()
                    ]
                ];
            })
            ->sortByDesc('y')
            ->values();

        return $playBookData;
    }

    private function getPAPChartData($incidents)
    {
        $papData = $incidents->groupBy(function ($incident) {
            return optional($incident->papLevel)->name ?? 'Unknown';
        })
            ->map(function ($group, $name) {
                return [
                    'name' => $name,
                    'y' => $group->count()
                ];
            })
            ->sortByDesc('y') // Sort for pyramid chart
            ->values();

        return $papData;
    }

    private function getDetectionChartData($incidents)
    {
        $detectionData = $incidents->groupBy(function ($incident) {
            return optional($incident->detected)->name ?? 'Unknown';
        })
            ->map(function ($group, $name) {
                return [
                    'name' => $name,
                    'y' => $group->count()
                ];
            })
            ->values();

        // For polar chart, we need both the data and categories
        return [
            'data' => $detectionData,
            'categories' => $detectionData->pluck('name')->toArray()
        ];
    }


    private function getOccurrenceChartData($incidents)
    {
        $occurrenceData = $incidents->groupBy(function ($incident) {
            return optional($incident->occurrence)->name ?? 'Unknown';
        })
            ->map(function ($group, $name) {
                return [
                    'name' => $name,
                    'value' => $group->count(), // packedbubble uses 'value' instead of 'y'
                    'y' => $group->count() // keep both for compatibility
                ];
            })
            ->values();

        return $occurrenceData;
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
        $incident = Incident::with('files')->findOrFail($id);
        // $criteria_scores = $incident->criteriaScores->pluck('pivot.incident_score_id', 'pivot.incident_criteria_id')->toArray();
        // $playBook = PlayBook::find($incident->play_book_id);

        // $incidentId = $incident->id;
        $response = [
            'incident' => [
                'related_incidents' => $incident->relatedIncidents ? $incident->relatedIncidents->pluck('id')->toArray() : [],
                'related_risks' => $incident->relatedRisks ? $incident->relatedRisks->pluck('id')->toArray() : [],
                'affected_assets' => $incident->affectedAssets->map(function ($asset) {
                    return [
                        'id' => $asset->id,
                        'name' => $asset->name
                    ];
                }),
                'source' => $incident->source,
                'destination' => $incident->destination,
                'other_assets' => $incident->other_assets,
                'affected_users' => !empty($incident->affected_users) ? explode(',', $incident->affected_users) : [],
                'criteria_scores' => $incident->criteriaScores->pluck('pivot.incident_score_id', 'pivot.incident_criteria_id')->toArray() ?? [],
                'incident' => $incident,
                'files' => $incident->files->map(function ($file) {
                    return [
                        'id' => $file->id,
                        'display_name' => $file->display_name,
                        'unique_name' => $file->unique_name
                    ];
                })->values(),
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
                            $incidentAction = IncidentPlayBookAction::where('play_book_action_id', $item->play_book_action_id)
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
                                'id' => $item->play_book_action_id, // Action ID
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
                'other_assets' => $incident->other_assets,
                'affected_users' => !empty($incident->affected_users) ? explode(',', $incident->affected_users) : [],
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
                    'tlp_level_id' => $request->tlp_id,
                    'pap_level_id' => $request->pap_id,
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
                $fileName = '';
                $path = '';
                // File upload Start
                // File upload handling for multiple files
                if ($request->hasFile('file')) {
                    $note_files = $request->file('file');
                    foreach ($note_files as $note_file) {
                        if ($note_file->isValid()) {
                            $path = $note_file->store('incident/' . $incident->id . '/notes');
                            $fileName = pathinfo($note_file->getClientOriginalName(), PATHINFO_FILENAME);
                            $extension = pathinfo($note_file->getClientOriginalName(), PATHINFO_EXTENSION);
                            $fileName .= $extension ? '.' . $extension : '';

                            // Create file record only if file is valid and stored
                            IncidentFile::create([
                                'user_id' => auth()->id(),
                                'incident_id' => $incident->id,
                                'display_name' => $fileName,
                                'unique_name' => $path
                            ]);
                        } else {
                            $response = [
                                'status' => false,
                                'errors' => ['note_file' => ['There were problems uploading one of the files']],
                                'message' => __('governance.ThereWasAProblemAddingTheIncidentFile') . "<br>" . __('locale.Validation error'),
                            ];
                            return response()->json($response, 422);
                        }
                    }
                }
                // File upload End
                event(new IncidentCreated($incident));

                $response = array(
                    'status' => true,
                    'message' => __('incident.IncidentWasAddedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                $response = array(
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                );
                dd($th);
                return response()->json($response, 502);
            }
        }
    }

    public function iraStore(Request $request)
    {
        if (empty($request->all())) {
            return;
        }
        DB::beginTransaction();
        try {
            $incident = Incident::findOrFail($request->incident_id);

            // Update only the fields that are present in the request
            $updatableFields = [
                'status',
                'detected_on',
                'source',
                'destination',
                'occurrence_id',
                'reported_id',
                'play_book_id',
                'tlp_id',
                'pap_id'
            ];

            foreach ($updatableFields as $field) {
                if ($request->has($field)) {
                    // Handle special field mappings
                    if ($field === 'tlp_id') {
                        $incident->tlp_level_id = $request->tlp_id;
                    } elseif ($field === 'pap_id') {
                        $incident->pap_level_id = $request->pap_id;
                    } else {
                        $incident->$field = $request->$field;
                    }
                }
            }

            // Handle affected_users separately
            if ($request->has('affected_users')) {
                $incident->affected_users = is_array($request->affected_users)
                    ? implode(',', $request->affected_users)
                    : $request->affected_users;
            }

            // Handle other_assets separately
            if ($request->has('other_assets')) {
                $incident->other_assets = $request->other_assets;
            }

            // Handle playbook logic only if play_book_id is provided
            if ($request->has('play_book_id')) {
                $playbook = Playbook::findOrFail($request->play_book_id);
                $playbook_type = $playbook->type;
                $incident->playbook_type = $playbook_type;

                $users_team = [];
                if ($playbook_type === 'user') {
                    $incident->playbookUsers()->sync($playbook->users()->pluck('user_id')->toArray());
                    $users_team = $playbook->users()->pluck('user_id')->toArray();
                } elseif ($playbook_type === 'team') {
                    $incident->playbookTeams()->sync($playbook->teams()->pluck('team_id')->toArray());
                    $users_team = $playbook->teams()->pluck('team_id');
                }
            }

            // Handle file deletions
            if ($request->filled('remove_file_ids')) {
                $removeFileIds = explode(',', $request->input('remove_file_ids'));
                foreach ($removeFileIds as $fileId) {
                    $file = IncidentFile::find($fileId);
                    if ($file) {
                        // Delete the file from storage
                        if ($file->unique_name && \Storage::exists($file->unique_name)) {
                            \Storage::delete($file->unique_name);
                        }
                        $file->delete();
                    }
                }
            }

            // File upload handling for multiple files
            if ($request->hasFile('file')) {
                $note_files = $request->file('file');
                foreach ($note_files as $note_file) {
                    if ($note_file->isValid()) {
                        $path = $note_file->store('incident/' . $incident->id . '/notes');
                        $fileName = pathinfo($note_file->getClientOriginalName(), PATHINFO_FILENAME);
                        $extension = pathinfo($note_file->getClientOriginalName(), PATHINFO_EXTENSION);
                        $fileName .= $extension ? '.' . $extension : '';

                        IncidentFile::create([
                            'user_id' => auth()->id(),
                            'incident_id' => $incident->id,
                            'display_name' => $fileName,
                            'unique_name' => $path
                        ]);
                    } else {
                        $response = [
                            'status' => false,
                            'errors' => ['note_file' => ['There were problems uploading one of the files']],
                            'message' => __('governance.ThereWasAProblemAddingTheIncidentFile') . "<br>" . __('locale.Validation error'),
                        ];
                        return response()->json($response, 422);
                    }
                }
            }

            $incident->save();

            // Sync related incidents only if provided
            if ($request->has('related_incidents')) {
                $incident->relatedIncidents()->sync($request->related_incidents);
            }

            // Sync related risks only if provided
            if ($request->has('related_risks')) {
                $incident->relatedRisks()->sync($request->related_risks);
            }

            // Sync affected assets only if provided
            if ($request->has('affected_assets')) {
                $incident->affectedAssets()->sync($request->affected_assets);
            }

            // Sync incident criteria scores only if provided
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

            // Trigger event only if playbook was updated
            if ($request->has('play_book_id')) {
                event(new IncidentIraCreated($incident, $playbook_type, $users_team));
            }

            $response = array(
                'status' => true,
                'message' => __('incident.IncidentWasUpdatedSuccessfully'),
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
        if (empty($request->all())) {
            return;
        }
        // Validate incoming data
        $request->validate([
            'action_ids' => 'required|array',
            'action_status' => 'required|array',
            'incident_ids' => 'required|array',
            'playbook_ids' => 'required|array'
        ]);

        DB::beginTransaction();
        try {
            $changedActions = [];

            foreach ($request->action_ids as $actionId) {
                $newStatus = $request->action_status[$actionId] ?? null;
                $incidentId = $request->incident_ids[$actionId] ?? null;
                $playbookId = $request->playbook_ids[$actionId] ?? null;

                if (is_null($newStatus) || is_null($incidentId) || is_null($playbookId)) {
                    continue; // skip invalid entries
                }

                // Find existing record
                $existingRecord = IncidentPlayBookAction::where([
                    'play_book_action_id' => $actionId,
                    'playbook_id' => $playbookId,
                    'incident_id' => $incidentId,
                ])->first();

                $oldStatus = $existingRecord ? $existingRecord->status : null;

                if ($existingRecord) {
                    // Only update and log if status changed
                    if ($oldStatus != $newStatus) {
                        $existingRecord->update(['status' => $newStatus]);

                        $changedActions[] = [
                            'action_id' => $actionId,
                            'incident_id' => $incidentId,
                            'playbook_id' => $playbookId,
                            'old_status' => $oldStatus,
                            'new_status' => $newStatus,
                        ];
                    }
                } else {
                    // Create new record but do NOT log, because there’s no change
                    IncidentPlayBookAction::create([
                        'play_book_action_id' => $actionId,
                        'playbook_id' => $playbookId,
                        'incident_id' => $incidentId,
                        'status' => $newStatus,
                    ]);
                }
            }

            // ✅ Log only changed actions
            foreach ($changedActions as $changedAction) {
                $this->createActionStatusLog(
                    $changedAction['action_id'],
                    $changedAction['incident_id'],
                    $changedAction['playbook_id'],
                    $changedAction['old_status'],
                    $changedAction['new_status']
                );
            }

            event(new playBookCategoryIncidentAction($changedActions));
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => count($changedActions) > 0
                    ? __('locale.Statuses updated and logs created for changed actions only.')
                    : __('locale.No status changes detected.'),
                'changed_count' => count($changedActions),
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('CSIRT Store Error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => __('locale.Failed to update statuses.'),
            ], 500);
        }
    }

    /**
     * Create log for action status change
     */
    private function createActionStatusLog($actionId, $incidentId, $playbookId, $oldStatus, $newStatus)
    {
        try {
            // Get action details for the log description
            $playbookAction = \App\Models\PlayBookAction::find($actionId);
            $actionName = $playbookAction ? $playbookAction->title : "Action #{$actionId}";

            // Convert status values to readable format
            $oldStatusText = $this->getStatusText($oldStatus);
            $newStatusText = $this->getStatusText($newStatus);

            $description = "Action '{$actionName}' status changed from '{$oldStatusText}' to '{$newStatusText}'";

            // Create the log entry
            IncidentLog::create([
                'incident_id' => $incidentId,
                'playbook_id' => $playbookId,
                'action_id' => $actionId,
                'user_id' => auth()->id(),
                'action_type' => 'updated',
                'description' => $description,
                'old_value' => $oldStatusText,
                'new_value' => $newStatusText,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to create action status log: ' . $e->getMessage());
        }
    }

    /**
     * Convert status code to readable text
     */
    private function getStatusText($status)
    {
        if ($status === null) {
            return 'Not Set';
        }

        $statusMap = [
            '0' => 'None',
            '1' => 'Progress',
            '2' => 'Done',
        ];

        return $statusMap[$status] ?? 'Unknown';
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
        $incident = Incident::findOrFail($id);
        $incident->delete();
        event(new IncidentDeleted($incident));

        return response()->json(['success' => true]);
    }


    public function storeEvidence(Request $request)
    {
        $rules = [
            'evidence_play_book_id' => ['required', 'exists:play_books,id'],
            'evidence_incident_id' => ['required', 'exists:incidents,id'],
            'evidence_action_id' => ['required', 'exists:play_book_actions,id'],
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

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('governance.ThereWasAProblemAddingTheEvidence') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        }

        try {
            DB::beginTransaction();

            $fileName = null;
            $uniqueFileName = null;

            if ($request->hasFile('evidence_file')) {
                if ($request->file('evidence_file')->isValid()) {
                    $fileName = $request->file('evidence_file')->getClientOriginalName();
                    $uniqueFileName = $request->file('evidence_file')->store('incident_evidences/' . $request->evidence_incident_id);
                } else {
                    $response = array(
                        'status' => false,
                        'errors' => ['evidence_file' => ['There were problems uploading the files']],
                        'message' => __('governance.ThereWasAProblemAddingTheEvidence') . "<br>" . __('locale.Validation error'),
                    );
                    return response()->json($response, 422);
                }
            }

            $playbookId = $request->input('evidence_play_book_id');
            $incidentId = $request->input('evidence_incident_id');
            $actionId = $request->input('evidence_action_id');
            $description = $request->input('evidence_description');

            // Fix: Check your actual database column names for IncidentPlayBookAction
            $incidentPlayBookAction = IncidentPlayBookAction::firstOrCreate(
                [
                    'playbook_id' => $playbookId, // or 'playbook_id' depending on your migration
                    'incident_id' => $incidentId,
                    'play_book_action_id' => $actionId, // or 'action_id' depending on your migration
                ],
                [
                    'status' => 2,
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
                'playbookId' => $playbookId,
                'incidentId' => $incidentId,
                'actionId' => $actionId
            ];

            DB::commit();

            event(new EvidenceIncidentCreated($evidence));

            // Fix: Updated the log message to use correct variables
            $message = __('governance.AnEvidenceWithDescription') . ' "' . ($evidence->description ?? __('locale.[No Name]')) . '". ' . __('governance.HasBeenAddedToIncident') . ' "' . $incidentId . '". ' . __('locale.By') . ' "' . auth()->user()->name . '".';

            write_log($evidence->id, auth()->id(), $message, 'adding evidence');

            $response = array(
                'status' => true,
                'data' => $data,
                'message' => __('governance.EvidenceWasAddedSuccessfully'),
            );
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            // Log the error for debugging
            \Log::error('Evidence Store Error: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString(),
                'request' => $request->all()
            ]);

            $response = array(
                'status' => false,
                'errors' => [],
                'message' => __('governance.ThereWasAProblemAddingTheEvidence'),
                // Remove detailed error in production: 'debug' => $th->getMessage()
            );
            return response()->json($response, 502);
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

        $fetchIncident = Incident::find($incident_id);
        $incident = $fetchIncident->summary;
        $incidentStatus = $fetchIncident->status;
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
                'incident_status' => $incidentStatus
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

                event(new EvidenceIncidentUpdated($evidence));

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
                dd($th);
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
    public function downloadAttachment($id)
    {
        $file = IncidentFile::findOrFail($id);

        if (!Storage::exists($file->unique_name)) {
            abort(404);
        }

        return Storage::download($file->unique_name, $file->display_name);
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
                event(new EvidenceIncidentDeleted($evidence));

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
        $moduleActionsIds = [112, 113, 152, 153, 154, 155, 156, 157, 158];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            112 => ['summary', 'status', 'details', 'type'],
            113 => ['summary', 'status', 'details', 'type', 'other_assets'],
            152 => ['Name', 'comment', 'created_by', 'play_book_category', 'play_book_title'],
            153 => ['summary', 'status', 'category_title', 'category_type'],
            154 => ['summary', 'status', 'category_title', 'category_type'],
            155 => ['summary', 'status', 'category_title', 'category_type'],
            156 => ['summary', 'status', 'category_title', 'category_type'],
            157 => ['summary', 'status', 'details', 'type'],
            158 => ['summary', 'status', 'details', 'type'],
        ];


        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [
            112 => ['Responsible-Person' => __('locale.ResponsiblePerson'), 'Team-teams' => __('locale.Teams')],
            113 => ['Responsible-Person' => __('locale.ResponsiblePerson'), 'Team-teams' => __('locale.Teams')],
            152 => ['incident_creator' => __('incident.IncdentCreator'), 'play_book_user' => __('incident.PlayBookUsers'), 'Team-teams' => __('incident.teamsPlaybook'), 'ira_users' => __('incident.ira_users'), 'Team-ira' => __('incident.teamsIra')],
            153 => ['incident_creator' => __('incident.IncdentCreator'), 'play_book_user' => __('incident.PlayBookUsers'), 'Team-teams' => __('incident.teamsPlaybook'), 'ira_users' => __('incident.ira_users'), 'Team-ira' => __('incident.teamsIra')],
            154 => ['incident_creator' => __('incident.IncdentCreator'), 'play_book_user' => __('incident.PlayBookUsers'), 'Team-teams' => __('incident.teamsPlaybook'), 'ira_users' => __('incident.ira_users'), 'Team-ira' => __('incident.teamsIra')],
            155 => ['incident_creator' => __('incident.IncdentCreator'), 'play_book_user' => __('incident.PlayBookUsers'), 'Team-teams' => __('incident.teamsPlaybook'), 'ira_users' => __('incident.ira_users'), 'Team-ira' => __('incident.teamsIra')],
            156 => ['incident_creator' => __('incident.IncdentCreator'), 'play_book_user' => __('incident.PlayBookUsers'), 'Team-teams' => __('incident.teamsPlaybook'), 'ira_users' => __('incident.ira_users'), 'Team-ira' => __('incident.teamsIra')],
            157 => ['incident_creator' => __('incident.IncdentCreator'), 'play_book_user' => __('incident.PlayBookUsers'), 'Team-teams' => __('incident.teamsPlaybook'), 'ira_users' => __('incident.ira_users'), 'Team-ira' => __('incident.teamsIra')],
            158 => ['incident_creator' => __('incident.IncdentCreator'), 'play_book_user' => __('incident.PlayBookUsers'), 'Team-teams' => __('incident.teamsPlaybook'), 'ira_users' => __('incident.ira_users'), 'Team-ira' => __('incident.teamsIra')],
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

    public function getStatistics($incidentId)
    {
        $statusMap = [
            0 => 'none',
            1 => 'progress',
            2 => 'done',
        ];

        $data = IncidentPlayBookAction::where('incident_play_book_actions.incident_id', $incidentId)
            ->join('play_book_actions', 'incident_play_book_actions.play_book_action_id', '=', 'play_book_actions.id')
            ->select(
                'play_book_actions.category_type',
                'incident_play_book_actions.status'
            )
            ->get();

        $stats = $data->groupBy('category_type')->map(function ($rows) use ($statusMap) {
            return [
                'total' => $rows->count(),
                'status_counts' => $rows->groupBy('status')->mapWithKeys(function ($group, $status) use ($statusMap) {
                    $label = $statusMap[$status] ?? $status;
                    return [$label => $group->count()];
                }),
            ];
        });

        return response()->json($stats);
    }
}