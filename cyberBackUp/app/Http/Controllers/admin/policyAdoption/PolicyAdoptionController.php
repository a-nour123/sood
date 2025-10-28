<?php

namespace App\Http\Controllers\admin\policyAdoption;

use App\Events\PolicyAdoptionCreated;
use App\Events\PolicyAdoptionDeleted;
use App\Events\PolicyAdoptionStatusChanged;
use App\Events\PolicyAdoptionUpdated;
use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Document;
use App\Models\DocumentContentChange;
use App\Models\PolicyAdoption;
use App\Models\PolicyAdoptionConfig;
use App\Models\PolicySignature;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Twilio\Jwt\TaskRouter\Policy;
use Twilio\Rest\Preview;
use Yajra\DataTables\Facades\DataTables;

class PolicyAdoptionController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasPermission('policy_adoptions.list')) {
            abort(403, 'Unauthorized action.');
        }

        $users = User::select('name', 'id')->get();
        $config = PolicyAdoptionConfig::first(); // one record only

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Governance')],
            ['name' => __('locale.AdoptionPolicies')]
        ];

        return view('admin.content.adoption_policy.index', compact('breadcrumbs', 'users', 'config'));
    }


    public function GetData(Request $request)
    {
        if ($request->ajax()) {
            $policiesQuery = PolicyAdoption::with('user', 'signature');

            // If the user is NOT admin (role_id != 1), filter policies assigned to them
            if (auth()->user()->role_id != 1) {
                $userId = auth()->id();
                $policiesQuery->whereHas('signature', function ($query) use ($userId) {
                    $query->whereRaw("FIND_IN_SET(?, reviewer_id) OR FIND_IN_SET(?, owner_id) OR FIND_IN_SET(?, authorized_person_id)", [
                        $userId,
                        $userId,
                        $userId
                    ]);
                });
            }

            $policies = $policiesQuery->get();

            return DataTables::of($policies)
                ->addColumn('title', function ($policy) {
                    return $policy->name;
                })
                ->addColumn('created_by', function ($policy) {
                    return $policy->user->name;
                })
                ->addColumn('created_at', function ($policy) {
                    return $policy->created_at->format('Y-m-d');
                })
                ->addColumn('category', function ($policy) {
                    return $policy->category->name;
                })
                ->addColumn('action', function ($policy) {
                    $actions = '';

                    if (
                        auth()->user()->hasPermission('policy_adoptions.update') ||
                        auth()->user()->hasPermission('policy_adoptions.delete') ||
                        auth()->user()->hasPermission('policy_adoptions.preview_result')
                    ) {

                        $dropdown = '<div class="dropdown">
                        <a class="pe-1 dropdown-toggle hide-arrow text-primary" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-small-4">
                                <circle cx="12" cy="12" r="1"></circle>
                                <circle cx="12" cy="5" r="1"></circle>
                                <circle cx="12" cy="19" r="1"></circle>
                            </svg>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">';

                        if (auth()->user()->hasPermission('policy_adoptions.update') && $policy->end_adoption == 0) {
                            $dropdown .= '<li><a class="dropdown-item edit-adotionPolicy" href="#" data-id="' . $policy->id . '">Edit</a></li>';
                        }

                        if (auth()->user()->hasPermission('policy_adoptions.delete')) {
                            $dropdown .= '<li><a class="dropdown-item delete-adotionPolicy" href="#" data-id="' . $policy->id . '">Delete</a></li>';
                        }

                        if (auth()->user()->hasPermission('policy_adoptions.preview_result') && $policy->signature) {
                            $userId = auth()->id();
                            $reviewers = explode(',', $policy->signature->reviewer_id);
                            $owners = explode(',', $policy->signature->owner_id);
                            $authorizeds = explode(',', $policy->signature->authorized_person_id);

                            if (in_array($userId, $reviewers) || in_array($userId, $owners) || in_array($userId, $authorizeds)) {
                                $dropdown .= '<li><a class="dropdown-item" href="' . route('admin.adoption_policies.getPolicyAdoptionPreview', [$policy->id, 'preview']) . '">Preview</a></li>';
                            }
                        }

                        if (auth()->user()->hasPermission('policy_adoptions.print')) {
                            $dropdown .= '<li><a class="dropdown-item" href="'
                                . route('admin.adoption_policies.getPolicyAdoptionPreview', [$policy->id, 'print'])
                                . '">Print</a></li>';
                        }

                        $dropdown .= '</ul></div>';
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




    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $content = [
                'en' => $request->introduction_content_en,
                'ar' => $request->introduction_content_ar
            ];

            $documentsIds = Document::where('document_type', $request->category_id)
                ->pluck('id')
                ->toArray();

            // Create new adoption policy
            $adoptionPolicy = PolicyAdoption::create([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'introduction_content' => $content,
                'documents_ids' => implode(',', $documentsIds),
                'created_by' => auth()->id(),
            ]);

            // Set end_adoption = 1 for previous policies in the same category
            PolicyAdoption::where('category_id', $request->category_id)
                ->where('id', '!=', $adoptionPolicy->id) // don't update the newly created
                ->update(['end_adoption' => 1]);

            // Get latest config
            $config = PolicyAdoptionConfig::latest()->first();

            // Create policy signature
            $policySignature = PolicySignature::create([
                'policy_id' => $adoptionPolicy->id,
                'reviewer_id' => $config->reviewer_id,
                'owner_id' => $config->owner_id,
                'authorized_person_id' => $config->authorized_person_id,
            ]);

            DB::commit();
            event(new PolicyAdoptionCreated($adoptionPolicy, $policySignature));

            return response()->json([
                'status' => true,
                'message' => 'Policy adopted successfully!',
                'data' => $adoptionPolicy,
                'reload' => true
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong while saving policy.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(PolicyAdoption $policyAdoption)
    {
        DB::beginTransaction();
        try {
            event(new PolicyAdoptionDeleted($policyAdoption, $policyAdoption->signature));

            // Delete related policy signature(s)
            $policyAdoption->signature()->delete(); // use signature() if relation is hasOne/hasMany

            // Delete the policy adoption itself
            $policyAdoption->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Policy Adoption and related signatures deleted successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete Policy Adoption: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function saveConfig(Request $request)
    {
        $request->validate([
            'reviewer_id' => 'required|array',
            'owner_id' => 'required|array',
            'authorized_person_id' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            PolicyAdoptionConfig::updateOrCreate(
                ['id' => $request->id],
                [
                    'reviewer_id' => implode(',', $request->reviewer_id),
                    'owner_id' => implode(',', $request->owner_id),
                    'authorized_person_id' => implode(',', $request->authorized_person_id),
                ]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Configuration saved successfully!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to save configuration: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function show($id)
    {
        $policy = PolicyAdoption::findOrFail($id);
        // Get the raw question column (JSON string)
        $rawContent = $policy->getRawOriginal('introduction_content');
        // Optionally, decode it for frontend use
        $content['content_edit'] = json_decode($rawContent, true);
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $policy->id,
                'category_id' => $policy->category_id,
                'name' => $policy->name,
                'introduction_content_en' => $content['content_edit']['en'],
                'introduction_content_ar' => $content['content_edit']['ar'],
            ]
        ]);
    }


    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $policy = PolicyAdoption::findOrFail($request->id);
            $content = [
                'en' => $request->introduction_content_en,
                'ar' => $request->introduction_content_ar,
            ];

            $policy->update([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'introduction_content' => $content,
            ]);

            DB::commit();
            event(new PolicyAdoptionUpdated($policy, $policy->signature));

            return response()->json([
                'success' => true,
                'message' => 'Policy Adoption updated successfully!',
                'data' => $policy,
                'reload' => true,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update Policy Adoption: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        DB::beginTransaction();
        try {
            $policy = PolicyAdoption::findOrFail($request->policy_id);

            // Determine the JSON field based on type
            $jsonField = match ($request->type) {
                'reviewer' => 'reviewer_status',
                'owner' => 'owner_status',
                'authorized' => 'authorized_person_status',
                default => null
            };

            if (!$jsonField) {
                return response()->json(['success' => false, 'message' => 'Invalid type'], 400);
            }

            // Get existing JSON or empty array
            $current = $policy->{$jsonField} ? json_decode($policy->{$jsonField}, true) : [];

            // Update with current user
            $current[auth()->id()] = [
                'status' => $request->status,
                'updated_at' => now()->toDateTimeString()
            ];

            // Save as JSON
            $policy->{$jsonField} = json_encode($current, JSON_UNESCAPED_UNICODE);
            $policy->save();
            event(new PolicyAdoptionStatusChanged($policy, $policy->signature, $current[auth()->id()]));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Policy adopted status updated successfully!',
                'updated_by' => auth()->user()->name,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function getPolicyAdoptionPreview($id, $type)
    {
        $policy = PolicyAdoption::findOrFail($id);

        $documentIds = $policy->documents_ids
            ? explode(',', $policy->documents_ids)
            : [];

        // Get documents with reviewer relation
        $documents = Document::whereIn('id', $documentIds)
            ->with('reviewer')
            ->get();

        // Get all content changes for those docs BEFORE policy creation
        $contentChanges = DocumentContentChange::query()
            ->whereIn('document_id', $documentIds)
            ->where('created_at', '<=', $policy->created_at)
            ->select([
                'id',
                'document_id',
                DB::raw("REPLACE(REPLACE(old_content, '&nbsp;', ' '), '<[^>]+>', '') as old_content"),
                DB::raw("REPLACE(REPLACE(new_content, '&nbsp;', ' '), '<[^>]+>', '') as new_content"),
                'changed_by',
                'created_at',
            ])
            ->with('changedByUser')
            ->orderBy('created_at', 'asc') // optional: sort chronologically
            ->get()
            ->groupBy('document_id');


        // 🔥 Merge changes into the documents
        foreach ($documents as $doc) {
            if (isset($contentChanges[$doc->id]) && $contentChanges[$doc->id]->isNotEmpty()) {
                // If document has changes → attach them
                $doc->changes = $contentChanges[$doc->id];
            } else {
                // If no changes → fake a "no change" record
                $doc->changes = collect([
                    (object) [
                        'old_content' => $doc->content,
                        'new_content' => '',
                        'changedByUser' => null,
                        'created_at' => null,
                    ]
                ]);
            }
        }
        $config = PolicySignature::where('policy_id', $policy->id)->latest()->first();

        $reviewerIds   = $config?->reviewer_id ? explode(',', $config->reviewer_id) : [];
        $ownerIds      = $config?->owner_id ? explode(',', $config->owner_id) : [];
        $authorizedIds = $config?->authorized_person_id ? explode(',', $config->authorized_person_id) : [];

        // Fetch users with job/position
        $reviewers   = User::whereIn('id', $reviewerIds)->select('id', 'name', 'job_id')->with('job')->get();
        $owners      = User::whereIn('id', $ownerIds)->select('id', 'name', 'job_id')->with('job')->get();
        $authorizeds = User::whereIn('id', $authorizedIds)->select('id', 'name', 'job_id')->with('job')->get();
        if ($type === "preview") {
            return view('admin.content.adoption_policy.policyPerview', compact(
                'policy',
                'documents',
                'reviewers',
                'owners',
                'authorizeds'
            ));
        } else {
            return view('admin.content.adoption_policy.policyExport', compact(
                'policy',
                'documents',
                'reviewers',
                'owners',
                'authorizeds'
            ));
        }
    }



    public function notificationsSettingsPolicyAdoption()
    {
        // defining the breadcrumbs that will be shown in page

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Regulators')],
            ['link' => route('admin.governance.control.list'), 'name' => __('locale.Control')],
            ['name' => __('locale.NotificationsSettings')]
        ];

        $users = User::select('id', 'name')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [145, 146, 147, 148];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            145 => ['name', 'category', 'created_by', 'owner', 'reviewer', 'authorized_person'],
            146 => ['name', 'category', 'created_by', 'owner', 'reviewer', 'authorized_person'],
            147 => ['name', 'category', 'created_by', 'owner', 'reviewer', 'authorized_person'],
            148 => ['name', 'category', 'created_by', 'owner', 'reviewer', 'authorized_person', 'status', 'status_by'],


        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [
            145 => ['owner' => __('locale.Owner'), 'creator' => __('locale.creator'), 'reviewer' => __('locale.reviewer'), 'authorized_person' => __('locale.authorized_person')],
            146 => ['owner' => __('locale.Owner'), 'creator' => __('locale.creator'), 'reviewer' => __('locale.reviewer'), 'authorized_person' => __('locale.authorized_person')],
            147 =>  ['owner' => __('locale.Owner'), 'creator' => __('locale.creator'), 'reviewer' => __('locale.reviewer'), 'authorized_person' => __('locale.authorized_person')],
            148 =>  ['owner' => __('locale.Owner'), 'creator' => __('locale.creator'), 'reviewer' => __('locale.reviewer'), 'authorized_person' => __('locale.authorized_person')],

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
}