<?php

namespace App\Http\Controllers\admin\Nda;

use App\Http\Controllers\Controller;
use App\Jobs\SendNdaEmailsJob;
use App\Models\ControlMailContent;
use App\Models\Nda;
use App\Models\NdaReceiver;
use App\Models\NdaResult;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class NdaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->hasPermission('nda.list')) {
            abort(403, 'Unauthorized action.');
        }

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Governance')],
            ['name' => __('locale.Nda')]
        ];

        // ====== SINGLE QUERY FOR STATISTICS ======
        $stats = Nda::selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN DATE(created_at) = ? THEN 1 ELSE 0 END) as today,
            SUM(CASE WHEN MONTH(created_at) = ? AND YEAR(created_at) = ? THEN 1 ELSE 0 END) as this_month,
            MAX(updated_at) as last_updated
        ", [
            now()->toDateString(),  // for today
            now()->month,           // for month
            now()->year             // for year
        ])
            ->first();

        $statistics = [
            'total'       => $stats->total,
            'today'       => $stats->today,
            'this_month'  => $stats->this_month,
            'last_updated' => $stats->last_updated ? \Carbon\Carbon::parse($stats->last_updated)->format('Y-m-d H:i') : null,
        ];

        return view('admin.content.nda.index', compact('breadcrumbs', 'statistics'));
    }


    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $nda = Nda::with('creator')->get();
            return DataTables::of($nda)
                ->addColumn('created_by', function ($nda) {
                    return $nda->creator->name;
                })
                ->addColumn('created_at', function ($nda) {
                    return $nda->created_at->format('Y-m-d'); // Output: 2023-10-15
                })
                ->addColumn('action', function ($nda) {
                    $actions = '';

                    // Check if the user has permission to update or delete
                    if (auth()->user()->hasPermission('nda.update') || auth()->user()->hasPermission('nda.delete') || auth()->user()->hasPermission('nda.send')) {
                        // Start the dropdown structure
                        $dropdown = '
                        <div class="dropdown">
                            <a class="pe-1 dropdown-toggle hide-arrow text-primary" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-small-4">
                                    <circle cx="12" cy="12" r="1"></circle>
                                    <circle cx="12" cy="5" r="1"></circle>
                                    <circle cx="12" cy="19" r="1"></circle>
                                </svg>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">';

                        // Check if the user has the required permission to update
                        if (auth()->user()->hasPermission('nda.update')) {
                            $dropdown .= '<li><a class="dropdown-item edit-nda" href="#" data-id="' . $nda->id . '">Edit</a></li>';
                        }

                        // Check if the user has the required permission to delete
                        if (auth()->user()->hasPermission('nda.delete')) {
                            $dropdown .= '<li><a class="dropdown-item delete-nda" href="#" data-id="' . $nda->id . '">Delete</a></li>';
                        }
                        if (auth()->user()->hasPermission('nda.send')) {
                            $dropdown .= '<li><a class="dropdown-item send-nda" href="#" data-id="' . $nda->id . '">Send Nda</a></li>';
                        }
                        if (auth()->user()->hasPermission('nda.list')) {
                            $dropdown .= '<li><a class="dropdown-item" href="'
                                . route('admin.nda.receiver.getNdaPreview', $nda->id)
                                . '">PreView</a></li>';
                        }

                        $dropdown .= '
                            </ul>
                        </div>';

                        $actions = $dropdown;
                    } else {
                        // Display alternative text if the user has no permissions
                        $actions = '---';
                    }

                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
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
        $validator = Validator::make($request->all(), [
            'nda.name_en'       => 'required|string|max:400',
            'nda.name_ar'       => 'required|string|max:400',
            'nda.description'   => 'nullable|string',

            'sections'          => 'required|array|min:1',
            'sections.*.order'  => 'required|integer',
            // 'sections.*.header_en' => 'nullable|string|max:400',
            // 'sections.*.header_ar' => 'nullable|string|max:400',
            'sections.*.en'     => 'required|string',
            'sections.*.ar'     => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors'  => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Prepare content JSON
            $content = [];
            foreach ($request->input('sections') as $section) {
                $content[] = [
                    'order'  => $section['order'],
                    'header_en' => $section['header_en'] ?? null,
                    'header_ar' => $section['header_ar'] ?? null,
                    'en'     => $section['en'], // could sanitize HTML here
                    'ar'     => $section['ar'],
                ];
            }

            // Create NDA with JSON content
            $nda = Nda::create([
                'name_en'    => $request->input('nda.name_en'),
                'name_ar'    => $request->input('nda.name_ar'),
                'description' => $request->input('nda.description'),
                'content'    => $content,
                'created_by' => auth()->id(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'NDA created successfully',
                'data'    => $nda
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create NDA: ' . $e->getMessage()
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
        $nda = Nda::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => [
                'nda' => $nda,
                'content' => $nda->content // Assuming content is stored as JSON
            ]
        ]);
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nda $nda)
    {
        $validator = Validator::make($request->all(), [
            'nda.name_en'    => 'required|string|max:400',
            'nda.name_ar'    => 'required|string|max:400',
            'nda.description' => 'nullable|string',
            'sections'       => 'required|array|min:1',

            'sections.*.header_ar' => 'nullable|string|max:400',
            'sections.*.header_en' => 'nullable|string|max:400',
            'sections.*.en'     => 'required|string',
            'sections.*.ar'     => 'required|string',
            'sections.*.order'  => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors'  => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Build structured content JSON
            $content = [];
            foreach ($request->input('sections') as $section) {
                $content[] = [
                    'order'  => $section['order'],
                    'header_en' => $section['header_en'] ?? null,
                    'header_ar' => $section['header_ar'] ?? null,
                    'en'     => $section['en'], // optional sanitize
                    'ar'     => $section['ar'],
                ];
            }

            // Update NDA
            $nda->update([
                'name_en'     => $request->input('nda.name_en'),
                'name_ar'     => $request->input('nda.name_ar'),
                'description' => $request->input('nda.description'),
                'content'     => $content,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'NDA updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update NDA: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nda $nda)
    {
        try {
            // Check if NDA is related to any receivers
            if ($nda->results()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'NDA cannot be deleted because it is assigned to one or more receivers.'
                ], 400);
            }
            $nda->delete();

            return response()->json([
                'success' => true,
                'message' => 'NDA deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete NDA: ' . $e->getMessage()
            ], 500);
        }
    }

    public function listUsers(Request $request)
    {
        $ndaReceivers = NdaReceiver::where('nda_id', $request->ndaId)->get();
        $foundUsers = $ndaReceivers->flatMap(function ($receiver) {
            return explode(',', $receiver->user_ids);
        })->toArray();
        $users = User::whereNotIn('id', $foundUsers)->select('id', 'name')->get();
        return response()->json($users);
    }
    public function send(Request $request)
    {

        $request->validate([
            'nda_id' => 'required|exists:ndas,id',
            'user_ids' => 'required|array',
        ]);

        $nda = Nda::findOrFail($request->nda_id);

        NdaReceiver::create([
            'nda_id' => $request->nda_id,
            'user_ids' => implode(',', $request->user_ids ?? [])
        ]);
        $userId = User::whereIn('id', $request->user_ids)->pluck('email');
        $type = "nda_type";
        // Get the email body content
        $bodyContent = $this->BodyHandiling($type, $nda);
        $subject = ControlMailContent::where('type', $type)->value('subject');
        // Dispatch the job with the email content
        SendNdaEmailsJob::dispatch($userId, $bodyContent, $nda, $subject);

        return response()->json([
            'status' => true,
            'message' => __('locale.Email sent successfully'),
        ]);
    }
    public function BodyHandiling($type, $nda)
    {
        // Retrieve the content from the database
        $mailContent = ControlMailContent::where('type', $type)->first();

        if ($mailContent) {
            // Get the content from the retrieved record
            $content = $mailContent->content;

            // Replace {name} with the actual name
            $content = str_replace('{name}', $nda->name, $content);
            $encryptedId = Crypt::encryptString($nda->id);

            // Create the button HTML
            $buttonHtml = '
            <div style="text-align: center; margin-top: 20px; margin-bottom: 20px;">
                <a style="
                    display: inline-block;
                    padding: 10px 20px;
                    font-size: 16px;
                    font-weight: bold;
                    text-decoration: none;
                    background-color: #0097a7;
                    color: #fff;
                    border: 2px solid #0097a7;
                    border-radius: 5px;"
                    href="' . route('admin.nda.getEmailNdaData',  $encryptedId) . '">Show Nda</a>
            </div>';
            // Replace {link} with the button HTML
            $content = str_replace('{link}', $buttonHtml, $content);

            // Return the final content
            return $content;
        } else {
            // Handle case where no content is found for the given type
            return 'No content found for this type.';
        }
    }

    public function getEmailNdaData($encryptedId)
    {
        try {
            $id = Crypt::decryptString($encryptedId);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(404, 'Invalid link.');
        }
        $nda = Nda::findOrFail($id);
        $ndaReceivers = NdaReceiver::where('nda_id', $nda->id)->get();

        $found = $ndaReceivers->contains(function ($receiver) {
            $userIds = explode(',', $receiver->user_ids); // convert string to array
            return in_array(auth()->id(), $userIds);
        });
        if (!$found) {
            abort(403, "You are not assigned to this NDA.");
        }
        $userTakeAction = NdaResult::where('user_id', auth()->id())->where('nda_id', $id)->first();

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Governance')],
            ['name' => __('locale.Nda')],
            ['name' => $nda->name]
        ];

        return view('admin.content.nda.receivers.ndaExample', compact('breadcrumbs', 'nda', 'userTakeAction'));
    }

    public function receiverIndex()
    {
        if (!auth()->user()->hasPermission('nda.list')) {
            abort(403, 'Unauthorized action.');
        }

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Governance')],
            ['name' => __('locale.NdaReceivers')]
        ];


        return view('admin.content.nda.receivers.index', compact('breadcrumbs'));
    }
    public function reviewStore(Request $request)
    {
        try {
            NdaResult::create([
                'nda_id' => $request->nda_id,
                'action' => $request->action,
                // 'comments' => $request->comments,
                'user_id' => auth()->id(),
            ]);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'NDA Result Send successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to Send NDA Result: ' . $e->getMessage()
            ], 500);
        }
    }

    public function receiverGetData(Request $request)
    {
        if ($request->ajax()) {
            $user = auth()->user();

            if ($user->role_id == 1 || $user->hasPermission('nda.all_result')) {
                // Admin → get all data
                $nda = NdaReceiver::with('nda')->get();
            } else {
                // Other users → filter by user_ids containing auth id
                $nda = NdaReceiver::with('nda')
                    ->whereRaw("FIND_IN_SET(?, user_ids)", [$user->id])
                    ->get();
            }

            return DataTables::of($nda)
                ->addColumn('name', function ($nda) use ($user) {
                    $locale = app()->getLocale(); // 'en' or 'ar'
                    $name = $locale === 'ar'
                        ? ($nda->nda->name_ar ?? '---')
                        : ($nda->nda->name_en ?? '---');

                    // Check if user has permission AND is assigned in user_ids
                    $userAssigned = $nda->user_ids
                        ? in_array($user->id, explode(',', $nda->user_ids))
                        : false;

                    return [
                        'text' => $name,
                        'encrypted_id' => ($user->hasPermission('nda.view_result') && $userAssigned)
                            ? Crypt::encryptString($nda->nda_id)
                            : null,
                    ];
                })


                ->addColumn('encrypted_id', function ($nda) {
                    return Crypt::encryptString($nda->nda_id);
                })


                ->addColumn('assigne', function ($nda) {
                    if (!$nda->user_ids) {
                        return '---';
                    }
                    $userIds = explode(',', $nda->user_ids);
                    $userNames = User::whereIn('id', $userIds)->pluck('name')->toArray();
                    return implode(', ', $userNames) ?: '---';
                })

                ->addColumn('created_by', function ($nda) {
                    return $nda->nda->creator->name ?? '---';
                })
                ->addColumn('created_at', function ($nda) {
                    return  $nda->nda->created_at->format('Y-m-d');
                })
                ->addColumn('action', function ($nda) use ($user) {
                    $actions = '';

                    if ($user->hasPermission('nda.all_result') || $user->hasPermission('nda.view_result')) {
                        $dropdown = '
                    <div class="dropdown">
                        <a class="pe-1 dropdown-toggle hide-arrow text-primary" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-small-4">
                                <circle cx="12" cy="12" r="1"></circle>
                                <circle cx="12" cy="5" r="1"></circle>
                                <circle cx="12" cy="19" r="1"></circle>
                            </svg>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">';

                        if ($user->hasPermission('nda.all_result')) {
                            $dropdown .= '<li><a class="dropdown-item all-result-nda" href="#" data-id="' . $nda->id . '">All Result</a></li>';
                        }

                        $dropdown .= '
                        </ul>
                    </div>';

                        $actions = $dropdown;
                    } else {
                        $actions = '---';
                    }

                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function getNdaResults($ndaId)
    {
        $receivers = NdaReceiver::where('id', $ndaId)->get();
        $nda = Nda::where('id', $receivers[0]['nda_id'])->first();
        $results = [];
        foreach ($receivers as $receiver) {
            $userIds = explode(',', $receiver->user_ids);
            $users = \App\Models\User::whereIn('id', $userIds)->get();
            foreach ($users as $user) {
                $review = NdaResult::where('nda_id', $nda->id)
                    ->where('user_id', $user->id)
                    ->with('nda')
                    ->first();

                $results[] = [
                    'id'         => $user->id ?? null,
                    'nda_name_en'   => $nda->name_en ?? '---',   // if nda or review is null
                    'nda_name_ar'   => $nda->name_ar ?? '---',   // if nda or review is null
                    'name'       => $user->name ?? '---',           // fallback if name is null
                    'status'     => $review
                        ? ($review->action == 1
                            ? 'Approved'
                            : 'Rejected')
                        : 'No Action Yet',
                    'department' => $user->department->name ?? '---', // fallback if no department
                    'created_at' => $review?->created_at
                        ? $review->created_at->format('Y-m-d')
                        : '---',
                ];
            }
        }

        return response()->json(['data' => $results]);
    }

    public function exportPdf($id)
    {

        $nda = Nda::findOrFail($id);
        return view('admin.content.nda.receivers.ndaExport', compact('nda'));
    }

    public function getNdaPreview($id)
    {
        $nda = Nda::findOrFail($id);

        return view('admin.content.nda.receivers.ndaPerview', compact('nda'));
    }
}