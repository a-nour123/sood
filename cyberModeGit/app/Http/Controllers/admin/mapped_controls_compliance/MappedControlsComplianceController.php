<?php

namespace App\Http\Controllers\admin\mapped_controls_compliance;

use App\Events\ControlDocumentComplianceActionStatus;
use App\Events\ControlDocumentComplianceCreated;
use App\Events\ControlDocumentComplianceDeleted;
use App\Exports\ControlDocumentAuditResultsExport;
use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\ControlComplianceDocument;
use App\Models\Document;
use App\Models\Framework;
use App\Models\FrameworkControl;
use App\Models\FrameworkControlMapping;
use App\Models\MappedControlsCompliance;
use App\Models\Regulator;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class MappedControlsComplianceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->hasPermission('mapped_control_compliance.list')) {
            abort(403, 'Unauthorized action.');
        }

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Compliance Framework')],
            ['name' => __('locale.MappingControlCompliance')]
        ];
        $frameworks = Framework::all();
        $regulators = Regulator::select('id', 'name')->get();
        $enabledUsers = User::where('enabled', true)
            ->select('id', 'name')
            ->get();
        return view('admin.content.mapped_controls_compliance.index', compact('breadcrumbs', 'frameworks', 'regulators', 'enabledUsers'));
    }

    public function getControlsByFramework($frameworkId)
    {
        $controlIds = FrameworkControlMapping::where('framework_id', $frameworkId)->pluck('framework_control_id')->toArray();
        $controls = FrameworkControl::whereIn('id', $controlIds)->select('id', 'short_name')->get();
        return response()->json($controls);
    }

    public function getPoliciesByControls(Request $request)
    {
        $controlIds = $request->input('control_ids', []);

        $results = [];

        foreach ($controlIds as $controlId) {
            $control = FrameworkControl::find($controlId);

            if (!$control) continue;

            $policies = Document::whereRaw("FIND_IN_SET(?, control_ids)", [$controlId])->get();

            $results[] = [
                'control'  => $control,
                'policies' => $policies
            ];
        }

        return response()->json($results);
    }


    public function ajaxTable(Request $request)
    {
        if ($request->ajax()) {
            $user = auth()->user();

            $query = MappedControlsCompliance::with(['regulator:id,name', 'framework:id,name'])
                ->select('mapped_controls_compliances.*');

            // 🔹 If not admin role, restrict to reviewer_id
            if ($user->role_id != 1) {
                $query->whereRaw("FIND_IN_SET(?, reviewer_id)", [$user->id]);
            }

            return DataTables::of($query)
                ->addColumn('auto_increment', function () {
                    static $count = 1;
                    return $count++;
                })
                ->addColumn('audit_name', function ($row) {
                    return $row->name;
                })
                ->addColumn('reviewer', function ($row) {
                    if (!$row->reviewer_id) {
                        return '---';
                    }
                    $userIds = explode(',', $row->reviewer_id);
                    $userNames = User::whereIn('id', $userIds)->pluck('name')->toArray();
                    return implode(', ', $userNames) ?: '---';
                })
                ->addColumn('regulator_name', function ($row) {
                    return $row->regulator->name ?? '--';
                })
                ->addColumn('framework_name', function ($row) {
                    return $row->framework->name ?? '--';
                })
                ->addColumn('periodical_time', function ($row) {
                    return $row->periodical_date ?? '--';
                })
                ->addColumn('actions', function ($row) use ($user) {
                    $buttons = '';

                    // ✅ Edit button (only before the start date)
                    if (
                        $user->hasPermission('mapped_control_compliance.update') &&
                        $row->enable_edit == 0 &&
                        $row->start_date > now()->toDateString()
                    ) {
                        $buttons .= '<a href="javascript:void(0);" 
                                        class="dropdown-item editCompliance" 
                                        data-id="' . $row->id . '">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>';
                    }

                    // ✅ Delete button (always allowed if permission exists)
                    if ($user->hasPermission('mapped_control_compliance.delete')) {
                        $buttons .= '<a href="javascript:void(0)" 
                                        class="dropdown-item deleteCompliance" 
                                        data-id="' . $row->id . '">
                                        <i class="fa fa-trash text-danger"></i> Delete
                                    </a>';
                    }

                    // ✅ Preview (auditing) button — only after or on start_date
                    if (
                        $user->hasPermission('mapped_control_compliance.auditing') &&
                        $row->start_date <= now()->toDateString() &&
                        $row->enable_edit == 0
                    ) {
                        $buttons .= '<a href="#" class="dropdown-item preview-audit" data-compliance-id="' . $row->id . '">
                                        <i class="fa fa-eye text-info me-1"></i> Preview
                                    </a>';
                    }

                    // ✅ Export button — only after or on start_date
                    if (
                        $user->hasPermission('mapped_control_compliance.export') &&
                        $row->start_date <= now()->toDateString()
                    ) {
                        $buttons .= '<a data-audit-id="' . $row->id . '" 
                                        class="dropdown-item export-audit-result-btn">
                                        <i class="fa fa-file-export text-success me-1"></i> Export
                                    </a>';
                    }

                    if ($buttons == '') {
                        return '---';
                    }

                    return '
                        <div class="d-inline-flex">
                            <a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <ul class="dropdown-menu">
                                ' . $buttons . '
                            </ul>
                        </div>
                    ';
                })

                ->rawColumns(['actions'])
                ->make(true);
        }
    }



    public function edit($id)
    {
        $compliance = MappedControlsCompliance::with('controlDocuments')->findOrFail($id);

        return response()->json($compliance);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'regulator_id'    => 'required|exists:regulators,id',
            'framework_id'    => 'required|exists:frameworks,id',
            'reviewer_id'     => 'required|array|min:1',
            'reviewer_id.*'   => 'exists:users,id',
            'start_date'      => 'required|date|after_or_equal:today',
            'due_date'        => 'required|date|after:start_date',
            'periodical_date' => 'integer',
            'next_initiate_date' => 'nullable|date',
            'description' => 'nullable',
            'control_ids'     => 'required|array|min:1',
            'control_ids.*'   => 'exists:framework_controls,id',
        ]);

        DB::beginTransaction();

        try {
            // Create or Update Compliance record
            $compliance = MappedControlsCompliance::updateOrCreate(
                ['id' => $request->compliance_id],
                [
                    'name'               => $validated['name'],
                    'description'        => $validated['description'],
                    'regulator_id'       => $validated['regulator_id'],
                    'framework_id'       => $validated['framework_id'],
                    'reviewer_id'        => implode(',', $validated['reviewer_id']),
                    'start_date'         => $validated['start_date'],
                    'due_date'           => $validated['due_date'],
                    'periodical_date'    => $validated['periodical_date'] ?? null,
                    'next_initiate_date' => $validated['next_initiate_date'] ?? null,
                ]
            );

            // 🔹 Reset all previous records of this framework to enable_edit = 1
            MappedControlsCompliance::where('framework_id', $validated['framework_id'])
                ->where('id', '!=', $compliance->id)
                ->update(['enable_edit' => 1]);

            // 🔹 Ensure the current one is editable (enable_edit = 0)
            $compliance->update(['enable_edit' => 0]);

            // Delete old control mappings for this compliance
            ControlComplianceDocument::where('mapped_controls_compliance_id', $compliance->id)->delete();

            // Save new control-document mappings
            foreach ($validated['control_ids'] as $controlId) {
                $policies = $request->control_policies[$controlId] ?? [];

                if (!empty($policies)) {
                    ControlComplianceDocument::create([
                        'mapped_controls_compliance_id' => $compliance->id,
                        'control_id'                    => $controlId,
                        'document_actions'              => [
                            'policies' => $policies,
                        ],
                    ]);
                }
            }

            DB::commit();

            event(new ControlDocumentComplianceCreated($compliance));

            return response()->json([
                'success' => true,
                'message' => 'Compliance saved successfully!',
                'id'      => $compliance->id,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function destroy(MappedControlsCompliance $mappedControlsCompliance)
    {
        try {
            $mappedControlsCompliance->delete();
            event(new ControlDocumentComplianceDeleted($mappedControlsCompliance));

            return response()->json([
                'success' => true,
                'message' => 'Compliance deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }



    public function fetchDataPreview($id)
    {
        $compliance = MappedControlsCompliance::with([
            'regulator:id,name',
            'framework:id,name',
            'controlDocuments.controls:id,short_name',
        ])->findOrFail($id);

        $reviewerIds = explode(',', $compliance->reviewer_id);
        $reviewers = User::whereIn('id', $reviewerIds)->get(['id', 'name']);


        $filteredComplianceData = [
            'id'        => $compliance->id,
            'name'      => $compliance->name,
            'regulator' => $compliance->regulator ? $compliance->regulator->only(['id', 'name']) : null,
            'framework' => $compliance->framework ? $compliance->framework->only(['id', 'name']) : null,
            'reviewers' => $reviewers->map->only(['id', 'name']),
            'start_date'        => $compliance->start_date,
            'due_date'          => $compliance->due_date,
            'periodical_date'   => $compliance->periodical_date,
            'next_initiate_date' => $compliance->next_initiate_date,
            'created_at'        => $compliance->created_at,

        ];

        return view('admin.content.mapped_controls_compliance.preview', compact('filteredComplianceData'));
    }



    public function previewajaxTable(Request $request)
    {
        if ($request->ajax()) {
            $compliance = MappedControlsCompliance::with([
                'controlDocuments.controls:id,short_name',
            ])->findOrFail($request->id);

            $query = collect();

            foreach ($compliance->controlDocuments as $doc) {
                $policies = $doc->document_actions['policies'] ?? [];

                // Normalize policies into array of objects
                $normalizedPolicies = collect($policies)->map(function ($p) {
                    return is_array($p)
                        ? $p
                        : ['id' => (int) $p]; // wrap raw ID into object
                });

                $policyIds = $normalizedPolicies->pluck('id')->toArray();

                // Get policy details from Document model
                $policyModels = Document::whereIn('id', $policyIds)
                    ->get(['id', 'document_name']);

                foreach ($policyModels as $policy) {
                    // find its metadata from JSON (status, note, etc.)
                    $policyMeta = $normalizedPolicies->firstWhere('id', $policy->id);

                    $query->push([
                        'row_id'       => $doc->id,
                        'control_id'   => $doc->controls?->id,
                        'control_name' => $doc->controls?->short_name ?? '—',
                        'policy_id'    => $policy->id,
                        'policy_name'  => $policy->document_name,
                        'policy_key'   => $doc->id . '_' . $policy->id,
                        'status'       => $policyMeta['status'] ?? null,
                        'note'         => $policyMeta['note'] ?? null,
                        'updated_by'   => $policyMeta['updated_by'] ?? null,
                        'updated_at'   => $policyMeta['updated_at'] ?? null,
                    ]);
                }
            }

            return DataTables::of($query)
                ->addColumn('action', function ($row) {
                    return view('admin.content.mapped_controls_compliance.actions.action-buttons', compact('row'))->render();
                })
                ->rawColumns(['action', 'note', 'submit'])
                ->make(true);
        }
    }


    public function submitPolicyResult(Request $request)
    {
        try {
            $request->validate([
                'row_id'     => 'required|integer',
                'control_id' => 'required|integer',
                'policy_id'  => 'required|integer',
                'action'     => 'required|in:approved,rejected',
                'note'       => 'nullable|string'
            ]);

            DB::transaction(function () use ($request) {
                $doc = ControlComplianceDocument::lockForUpdate()->findOrFail($request->row_id);
                $compliance = $request->all();
                // Decode existing JSON actions
                $actions = $doc->document_actions ?? [];

                if (!isset($actions['policies']) || !is_array($actions['policies'])) {
                    $actions['policies'] = [];
                }

                // Normalize policies
                $policies = collect($actions['policies'])->mapWithKeys(function ($p) {
                    if (is_array($p)) {
                        return [$p['id'] => $p];
                    }
                    return [$p => ['id' => (int) $p]];
                })->toArray();

                // Update / create entry
                $policies[$request->policy_id] = array_merge($policies[$request->policy_id] ?? [
                    'id' => (int) $request->policy_id,
                ], [
                    'status'     => $request->action,
                    'note'       => $request->note,
                    'updated_by' => auth()->id(),
                    'updated_at' => now()->toDateTimeString(),
                ]);

                $actions['policies'] = array_values($policies);

                $doc->document_actions = $actions;
                $doc->save();
                event(new ControlDocumentComplianceActionStatus($compliance));
            });

            return response()->json([
                'success' => true,
                'message' => 'Policy status updated successfully!'
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors'  => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred.',
                'error'   => $e->getMessage(), // 👈 remove this in production if you don’t want to expose details
            ], 500);
        }
    }

    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'note'   => 'nullable|string',
            'rows'   => 'required|array',
            'rows.*.row_id'    => 'required|integer',
            'rows.*.control_id' => 'required|integer',
            'rows.*.policy_id' => 'required|integer',
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->rows as $row) {
                $doc = ControlComplianceDocument::findOrFail($row['row_id']);

                $actions = ['policies' => []];

                $found = false;
                foreach ($actions['policies'] as &$policy) {
                    if ($policy['id'] == $row['policy_id']) {
                        $policy['status']     = $request->status;
                        $policy['note']       = $request->status === 'rejected' ? $request->note : null;
                        $policy['updated_by'] = auth()->id();
                        $policy['updated_at'] = now()->toDateTimeString();
                        $found = true;
                        break;
                    }
                }

                if (! $found) {
                    $actions['policies'][] = [
                        'id'         => (int) $row['policy_id'],
                        'status'     => $request->status,
                        'note'       => $request->status === 'rejected' ? $request->note : null,
                        'updated_by' => auth()->id(),
                        'updated_at' => now()->toDateTimeString(),
                    ];
                }

                // save back
                $doc->document_actions = $actions;
                $doc->save();
            }
        });

        return response()->json(['success' => true, 'message' => 'Policies updated successfully.']);
    }



    public function exportResult(Request $request)
    {
        $auditId = $request->input('audit_id');
        // Validate the audit_id exists
        if (!MappedControlsCompliance::where('id', $auditId)->exists()) {
            abort(404, 'Audit not found');
        }

        // You can pass any additional data you need here
        $data = []; // Your additional data if needed

        return Excel::download(
            new ControlDocumentAuditResultsExport($auditId, $data), // Pass both parameters
            'audit_results_' . $auditId . '.xlsx'
        );
    }

    public function notification()
    {
        // defining the breadcrumbs that will be shown in page

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Audit')],
            ['name' => __('locale.NotificationsSettings')]
        ];

        $users = User::select('id', 'name')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [149, 150, 151];
        $moduleActionsIdsAutoNotify = [];

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            149 => ['name', 'description', 'framework', 'regulator', 'reviewer', 'StartDate', 'Duedate', 'periodicalTime', 'NextIntiateDate'],
            150 => ['name', 'description', 'framework', 'regulator', 'reviewer', 'StartDate', 'Duedate', 'periodicalTime', 'NextIntiateDate'],
            151 => ['name', 'description', 'framework', 'regulator', 'reviewer', 'StartDate', 'Duedate', 'periodicalTime', 'NextIntiateDate', 'status', 'notes', 'control', 'document'],

        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [
            149 => ['reviewer' => __('locale.Reviewer')],
            150 => ['reviewer' => __('locale.Reviewer')],
            151 =>  ['reviewer' => __('locale.Reviewer'), 'Control-Owner' => __('locale.ControlOwner'), 'document-Owner' => __('locale.DocumentOwner')],
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