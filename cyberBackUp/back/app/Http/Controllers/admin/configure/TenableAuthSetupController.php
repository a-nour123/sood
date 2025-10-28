<?php

namespace App\Http\Controllers\admin\configure;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\ScheduledVulnerability;
use App\Models\TenableAsyncHistory;
use Illuminate\Http\Request;
use App\Models\TenableAuth;
use App\Models\TenableHistory;
use App\Models\User;
use App\Services\TenableService;
use App\Services\TenableServiceAssets;
use App\Services\TenableServiceAssetsGroup;
use App\Services\TenableServiceAssetsRegions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TenableAuthSetupController extends Controller
{

    public function index()
    {
        // Check if the user has the required permission
        if (!auth()->user()->hasPermission('tenable_authentication.create')) {
            abort(403, 'Unauthorized action.');
        }

        // Get the TenableAuth record
        $tenableAuth = TenableAuth::first();
        $schedule = ScheduledVulnerability::first();
        $tenableHistory = TenableAsyncHistory::orderBy('created_at', 'desc')->get();

        // Return the view with or without the $tenableAuth variable
        return view("admin.content.configure.tenable_auth.create", compact('tenableAuth', 'schedule','tenableHistory'));
    }

    public function store(Request $request)
    {

        try {
            // Define dynamic validation rules
            $rules = [
                'api_url' => 'required',
                'type_source' => 'required',
            ];

            // Check if the record exists
            $tenableAuth = TenableAuth::find($request->id);

            // If the record doesn't exist or if either key is provided, make them required
            if (!$tenableAuth && ($request->has('access_key') || $request->has('secret_key'))) {
                $rules['access_key'] = 'required';
                $rules['secret_key'] = 'required';
            }

            // Validate input fields
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                // Return validation errors
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                ]);
            }

            // Start a database transaction
            DB::beginTransaction();

            // If the record exists and secret_key and access_key are empty, retrieve existing values
            if ($tenableAuth && empty($request->secret_key) && empty($request->access_key)) {
                $request->merge([
                    'secret_key' => $tenableAuth->secret_key,
                    'access_key' => $tenableAuth->access_key,
                ]);
            }
            // Update or create the record in the database
            $tenableAuth = TenableAuth::updateOrCreate(
                ['id' => $request->id],
                [
                    'secret_key' => $request->secret_key,
                    'access_key' => $request->access_key,
                    'api_url' => $request->api_url,
                    'type_source' => $request->type_source,
                    'offset' => $request->offset,
                    'end' => $request->end,
                    'total' => $request->total,
                    'severity'=>$request->severity,
                    'idsAssetGroup'=>$request->idsAssetGroup
                ]
            );

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'status' => true,
                'message' => __('locale.ConnectionTestSuccess') . ' Connection to SMTP/Exchange server successful.',
            ]);
        } catch (\Throwable $e) {
            // Rollback the transaction in case of error
            DB::rollBack();

            // Return error response
            return response()->json([
                'status' => false,
                'message' => __('locale.ConnectionTestFailed') . ' ' . $e->getMessage(),
            ]);
        }
    }






    public function insertSchedule(Request $request)
    {
        // Define validation rules
        $rules = [
            'time_schedule' => 'required',
        ];

        // Add conditional rules based on the selected radio button value
        if ($request->time_schedule == 'daily') {
            $rules['due_time'] = 'required';
        } elseif ($request->time_schedule == 'weekly') {
            $rules['due_weekly_day'] = 'required';
            $rules['due_weekly_time'] = 'required';
        } elseif ($request->time_schedule == 'monthly') {
            $rules['date_monthly'] = 'required';
        }

        // Validate the request data
        $validator = Validator::make($request->all(), $rules);

        // Check if the validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        try {
            // Start a database transaction
            DB::beginTransaction();

            $va = ScheduledVulnerability::updateOrCreate(
                ['id' => $request->idSchedule],
                [
                    'time_schedule' => $request->time_schedule,
                    'due_time' => $request->due_time,
                    'due_weekly_day' => $request->due_weekly_day,
                    'due_weekly_time' => $request->due_weekly_time,
                    'date_monthly' => $request->date_monthly,
                ]
            );

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'status' => true,
                'message' => __('locale.Success') . '.',
            ]);
        } catch (\Throwable $e) {
            // Rollback the transaction in case of error
            DB::rollBack();

            // Return error response
            return response()->json([
                'status' => false,
                'message' => __('locale.Failed') . ' ' . $e->getMessage(),
            ]);
        }
    }
    public function applySync(Request $request)
    {


        try {
            // Start a database transaction
            DB::beginTransaction();

            $tenableService = new TenableService();
            $tenableService->syncHostsAndVulnerabilities();
            DB::commit();

            // Return success response
            return response()->json([
                'status' => true,
                'message' => __('locale.Success') . '.',
            ]);
        } catch (\Throwable $e) {
            // Rollback the transaction in case of error
            DB::rollBack();

            // Return error response
            return response()->json([
                'status' => false,
                'message' => __('locale.Failed') . ' ' . $e->getMessage(),
            ]);
        }
    }

    public function applySyncAssetsRegion(Request $request)
    {
        try {
            // Start a database transaction
            DB::beginTransaction();

            $tenableService = new TenableServiceAssetsRegions();
            $tenableService->syncHostsWithRegions();
            DB::commit();

            // Return success response
            return response()->json([
                'status' => true,
                'message' => __('locale.Success') . '.',
            ]);
        } catch (\Throwable $e) {
            // Rollback the transaction in case of error
            DB::rollBack();

            // Return error response
            return response()->json([
                'status' => false,
                'message' => __('locale.Failed') . ' ' . $e->getMessage(),
            ]);
        }
    }
    public function applySyncAssetsGroup(Request $request)
    {

        try {
            // Start a database transaction
            DB::beginTransaction();

            $tenableService = new TenableServiceAssetsGroup();

            $tenableService->syncAssetsgroups();
            DB::commit();

            // Return success response
            return response()->json([
                'status' => true,
                'message' => __('locale.Success') . '.',
            ]);
        } catch (\Throwable $e) {
            // Rollback the transaction in case of error
            DB::rollBack();

            // Return error response
            return response()->json([
                'status' => false,
                'message' => __('locale.Failed') . ' ' . $e->getMessage(),
            ]);
        }
    }


    public function tenableNotification()
    {

        // defining the breadcrumbs that will be shown in page
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' => route('admin.configure.auth_tenable'), 'name' => __('locale.TenableAuthentication')], ['name' => __('locale.NotificationsSettings')]];
        $users = User::select('id', 'name')->where('enabled', true)->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [98,113,114];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            98 => [],
            113 => [],
            114 => [],
        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [
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
