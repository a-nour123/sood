<?php

namespace App\Http\Controllers\admin\asset_management\asset;

use App\Exports\AssetsExport;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetValue;
use App\Models\Department;
use App\Models\Location;
use App\Models\Tag;
use App\Models\Taggable;
use App\Models\Team;
use App\Models\Action;
use App\Models\User;
use App\Events\AssetCreated;
use App\Events\AssetUpdated;
use App\Events\AssetDeleted;
use App\Models\AssetCategory;
use App\Models\AssetValueCategory;
use App\Models\AssetValueLevel;
use App\Imports\AssetsImport;
use App\Jobs\ExportAssetsJob;
use App\Models\AssetEnvironmentCategory;
use App\Models\AssetGroup;
use App\Models\HostRegion;
use App\Models\OperatingSystem;
use App\Models\Vulnerability;
use App\Services\AssetExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use ZipArchive;

class AssetController extends Controller
{

    protected $assetExportService;

    public function __construct(AssetExportService $assetExportService)
    {
        $this->assetExportService = $assetExportService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $teams = Team::all();
        $locations = Location::all();
        $assetValues = AssetValue::all();
        $assetCategories = AssetCategory::all();
        $assetEnvironmentCategories = AssetEnvironmentCategory::all();
        $assetValueCategories = AssetValueCategory::all();
        $assetValueLevels = AssetValueLevel::all();
        $operatingSystems = OperatingSystem::all();
        $tags = Tag::all();
        $users = User::all();
        $regions = HostRegion::select('id', 'name')->get();
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.asset_management')]
        ];

        $assetInQuery = request()->query('asset');
        $assetStatistic = $this->GetAssetStatistic();

        return view('admin.content.asset_management.asset.index', compact('breadcrumbs', 'assetStatistic', 'regions', 'users', 'teams', 'assetEnvironmentCategories', 'assetValueLevels', 'locations', 'assetValueCategories', 'assetCategories', 'assetValues', 'tags', 'assetInQuery', 'operatingSystems'));
    }


    public function GetAssetStatistic()
    {
        // Get total count of assets
        $assetCount = Asset::count();

        // Get the total count of critical vulnerabilities
        // Assuming the `Vulnerability` model has a 'severity' column that indicates the severity level of the vulnerability
        $criticalVulnsCount = Vulnerability::where('severity', 'critical')
            ->whereHas('assets')  // Ensures that the vulnerability is related to at least one asset
            ->count();

        // Get the total count of assets related to critical vulnerabilities
        $assetsWithCriticalVulnsCount = Asset::whereHas('vulnerabilities', function ($query) {
            $query->where('severity', 'critical');
        })->count();

        // Get total count of AssetGroup model (if relevant)
        $assetGroupCount = AssetGroup::count();

        // Return an array with the statistics
        return [
            'assetCount' => $assetCount,
            'assetsWithCriticalVulnsCount' => $assetsWithCriticalVulnsCount,
            'assetGroupCount' => $assetGroupCount,
        ];
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
            'ip' => ['nullable', 'ip', 'max:15'],
            'asset_value' => ['required'],
            'asset_owner' => ['nullable'],
            'region_id' => ['nullable', 'exists:host_regions,id'], // Validate region_id
            'name' => ['required', 'max:200', 'unique:assets,name'],
            'location_id' => ['nullable', 'exists:locations,id'], // the location that asset belongs to
            // 'asset_value_id' => ['required', 'exists:asset_values,id'], // the asset that asset belongs to
            'asset_category_id' => ['required', 'exists:asset_categories,id'], //the category that asset belongs to
            'teams' => ['nullable', 'array'],
            'teams.*' => ['exists:teams,id'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:tags,id'],
            'details' => ['nullable', 'string', 'max:4000000000'], // Max longtext is 4,294,967,295
            'start_date' => ['nullable', 'date'],
            'expiration_date' => ['nullable', 'date', 'after:start_date'],
        ]);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('locale.ThereWasAProblemAddingTheAsset') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();
            try {
                $asset = Asset::create([
                    'ip' => $request->ip,
                    'name' => $request->name,
                    'asset_value_id' => $request->asset_value_id,
                    'asset_value_level_id' => $request->asset_value,
                    'asset_category_id' => $request->asset_category_id,
                    'location_id' => $request->location_id ?? null,
                    'teams' => $request->teams ? implode(',', $request->teams) : null,
                    'details' => $request->details,
                    'start_date' => $request->start_date,
                    'expiration_date' => $request->expiration_date,
                    'verified' => $request->has('verified') ? true : false,
                    'alert_period' => $request->alert_period,
                    'url' => $request->url,
                    'asset_environment_category_id' => $request->asset_environment_category_id,
                    'os' => $request->os,
                    'os_version' => $request->os_version,
                    'physical_virtual_type' => $request->physical_virtual_type,
                    'asset_owner' => $request->asset_owner,
                    // 'owner_email' => $request->owner_email,
                    // 'owner_manager_email' => $request->owner_manager_email,
                    'project_vlan' => $request->project_vlan,
                    'vlan' => $request->vlan,
                    'vendor_name' => $request->vendor_name,
                    'model' => $request->model,
                    'firmware' => $request->firmware,
                    'city' => $request->city,
                    'rack_location' => $request->rack_location,
                    'mac_address' => $request->mac_address,
                    'subnet_mask' => $request->subnet_mask,
                ]);

                $allAssetTags = Tag::whereIn('id', $request->tags ?? [])->get();
                $asset->tags()->saveMany($allAssetTags);

                // Add the region_id to the pivot table without duplication
                if ($request->region_id) {
                    $asset->hostRegions()->syncWithoutDetaching([$request->region_id]);
                }
                // Audit log
                $message = __('asset.An asset name') . ' "' . ($asset->name ?? __('locale.[No Name]')) . '" ' . __('asset.was added by username') . ' "' . (auth()->user()->name ?? __('locale.[No User Name]')) . '".';
                write_log($asset->id, auth()->id(), $message, 'asset');

                DB::commit();
                event(new AssetCreated($asset));

                $response = array(
                    'status' => true,
                    'message' => __('asset.AssetWasAddedSuccessfully'),
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


    /**
     * Get specified resource data for editing.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxGet($id)
    {
        $asset = Asset::find($id);
        if ($asset) {
            $data = $asset->toArray();
            $data['expiration_date'] = $asset->expiration_date ? $asset->expiration_date->format('Y-m-d') : '';
            $data['tags'] = $asset->tags()->pluck('id')->toArray();
            $data['region_id'] = $asset->hostRegions()->pluck('asset_host_region.host_region_id')->toArray();
            // $data['asset_value_id'] = null;
             $response = array(
                'status' => true,
                'data' => $data,
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
 
        $asset = Asset::find($id);
        if ($asset) {
            $validator = Validator::make($request->all(), [
                'ip' => ['nullable', 'ip', 'max:15'],
                'name' => ['required', 'max:200', 'unique:assets,name,' . $asset->id],
                'location_id' => ['nullable', 'exists:locations,id'], // the location that asset belongs to
                'asset_owner' => ['nullable'],
                'region_id' => ['nullable', 'exists:host_regions,id'], // Validate region_id
                // 'asset_value_id' => ['required', 'exists:asset_values,id'], // the location that asset belongs to
                'asset_value' => ['required'],
                'asset_category_id' => ['required', 'exists:asset_categories,id'], //the category that asset belongs to
                'teams' => ['nullable', 'array'],
                'teams.*' => ['exists:teams,id'],
                'tags' => ['nullable', 'array'],
                'tags.*' => ['exists:tags,id'],
                'details' => ['nullable', 'string', 'max:4000000000'], // Max longtext is 4,294,967,295
                'start_date' => ['nullable', 'date'],
                'expiration_date' => ['nullable', 'date', 'after:start_date'],
                'alert_period' => ['nullable', 'integer'],
            ]);

            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('asset.ThereWasAProblemUpdatingTheAsset') . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();
                try {

                    $currentTags = $asset->tags()->pluck('id')->toArray();
                    $deletedTags = array_diff($currentTags ?? [], $request->tags ?? []);
                    $addedTags = array_diff($request->tags ?? [], $currentTags ?? []);

                    // Delete deleted tags
                    $asset->tags()->detach($deletedTags);

                    $allAssetTags = Tag::whereIn('id', $addedTags ?? [])->get();

                    // Logic for getting tags that aren't referenced by the junction table
                    $tagsFoundedForOtherRecords = Taggable::whereIn('tag_id', $currentTags)->pluck('tag_id')->toArray();
                    $deletedAssetTagIds = array_diff($currentTags, $tagsFoundedForOtherRecords);

                    // Clean up every tags that aren't referenced by the junction table
                    Tag::whereIn('id', $deletedAssetTagIds)->delete();
                    // Add added tags
                    $asset->tags()->saveMany($allAssetTags);
                    if ($request->region_id) {
                        // Update the region_id in the pivot table
                        $asset->hostRegions()->sync([$request->region_id]);
                    }
                    $asset->update([
                        'ip' => $request->ip,
                        'name' => $request->name,
                        'asset_value_id' => $request->asset_value_id,
                        'asset_value_level_id' => $request->asset_value,
                        'asset_category_id' => $request->asset_category_id,
                        'location_id' => $request->location_id ?? null,
                        'teams' => $request->teams ? implode(',', $request->teams) : null,
                        'details' => $request->details,
                        'start_date' => $request->start_date,
                        'expiration_date' => $request->expiration_date,
                        'alert_period' => $request->alert_period,
                        'verified' => $request->has('verified') ? true : false,
                        'url' => $request->url,
                        'asset_environment_category_id' => $request->asset_environment_category_id,
                        'os' => $request->os,
                        'os_version' => $request->os_version,
                        'physical_virtual_type' => $request->physical_virtual_type,
                        'asset_owner' => $request->asset_owner,

                        // 'owner_email' => $request->owner_email,
                        // 'owner_manager_email' => $request->owner_manager_email,
                        'project_vlan' => $request->project_vlan,
                        'vlan' => $request->vlan,
                        'vendor_name' => $request->vendor_name,
                        'model' => $request->model,
                        'firmware' => $request->firmware,
                        'city' => $request->city,
                        'rack_location' => $request->rack_location,
                        'mac_address' => $request->mac_address,
                        'subnet_mask' => $request->subnet_mask,
                        'updated_at'  => now()
                    ]);

                    // Audit log
                    $message = __('asset.An asset name') . ' "' . ($asset->name ?? __('locale.[No Name]')) . '" ' . __('locale.UpdatedBy') . ' "' . (auth()->user()->name ?? __('locale.[No User Name]')) . '".';
                    write_log($asset->id, auth()->id(), $message, 'asset');
                    DB::commit();
                    event(new Assetupdated($asset));
                    $response = array(
                        'status' => true,
                        'message' => __('asset.AssetWasUpdatedSuccessfully'),
                    );
                    return response()->json($response, 200);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return $th->getMessage();
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $asset = Asset::find($id);
        $assetName = $asset->name;
        $assetId = $asset->id;
        if ($asset) {
            DB::beginTransaction();
            try {
                // Check for related data
                $relatedData = $asset->hasRelations();

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

                $assetTagIds = $asset->tags()->pluck('id')->toArray();

                // Remove the entries from the junction table `taggables` that connected to the `tags`
                $asset->tags()->detach();

                // Logic for getting tags that aren't referenced by the junction table
                $tagsFoundedForOtherRecords = Taggable::whereIn('tag_id', $assetTagIds)->pluck('tag_id')->toArray();
                $deletedAssetTagIds = array_diff($assetTagIds, $tagsFoundedForOtherRecords);

                // Clean up every tags that aren't referenced by the junction table
                Tag::whereIn('id', $deletedAssetTagIds)->delete();

                $asset->delete();

                // Audit log
                $message = __('asset.An asset name') . ' "' . ($assetName ?? __('locale.[No Asset Name]')) . '" ' . __('locale.UpdatedBy') . ' "' . (auth()->user()->name ?? __('locale.[No User Name]')) . '".';
                write_log($assetId, auth()->id(), $message, 'asset');

                DB::commit();
                event(new AssetDeleted($asset));

                $response = array(
                    'status' => true,
                    'message' => __('asset.AssetWasDeletedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();
                 if ($th->errorInfo[0] == 23000) {
                    $errorMessage = __('asset.ThereWasAProblemDeletingTheAsset') . "<br>" . __('locale.CannotDeleteRecordRelationError');
                } else {
                    $errorMessage = __('asset.ThereWasAProblemDeletingTheAsset');
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
            'normal' => ['name', 'ip'],
            // 'relationships' => ['location', 'tags'],
            'relationships' => [
                [
                    'name' => 'location'
                ],
                [

                    'name' => 'assetCategory'
                ]
            ],
            'other_global_filters' => ['created'],
        ];

        $relationshipsWithColumns = [
            'assetValueLevel',
            'location',
            'assetCategory',
            'assetEnvironmentCategory',
            'assetOs',
        ];

        prepareDatatableRequestFields($request, $dataTableDetails, $customFilterFields);

        $conditions = [];
        if (!auth()->user()->hasPermission('asset.all')) {
            // If user does not have permission to see all assets, filter by department or teams
            if (isDepartmentManager()) {
                $departmentId = (Department::where('manager_id', auth()->id())->first())->id;
                $departmentMembers = User::with('teams')->where('department_id', $departmentId)
                    ->orWhere('id', auth()->id())->get();
                $departmentTeams = [];
                foreach ($departmentMembers as $departmentMember) {
                    $departmentTeams = array_merge($departmentTeams, $departmentMember->teams->pluck('id')->toArray());
                }

                if (!empty($departmentTeams)) {
                    $teamsAssetsIds = Asset::where(function ($query) use ($departmentTeams) {
                        foreach ($departmentTeams as $teamId) {
                            $query->orWhereRaw("FIND_IN_SET($teamId, teams)");
                        }
                    })
                        ->orWhere('asset_owner', auth()->id()) // Include assets where the user is the owner
                        ->pluck('id')
                        ->toArray();
                } else {
                    $teamsAssetsIds = Asset::where('asset_owner', auth()->id()) // Only assets owned by the user
                        ->pluck('id')
                        ->toArray();
                }
            } else {
                $teamIds = auth()->user()->teams()->pluck('id')->toArray();
                if (!empty($teamIds)) {
                    $teamsAssetsIds = Asset::where(function ($query) use ($teamIds) {
                        foreach ($teamIds as $teamId) {
                            $query->orWhereRaw("FIND_IN_SET($teamId, teams)");
                        }
                    })
                        ->orWhere('asset_owner', auth()->id()) // Include assets where the user is the owner
                        ->pluck('id')
                        ->toArray();
                } else {
                    $teamsAssetsIds = Asset::where('asset_owner', auth()->id()) // Only assets owned by the user
                        ->pluck('id')
                        ->toArray();
                }
            }

            $assetsIds = array_unique($teamsAssetsIds);
            $conditions = [
                'whereIn' => [
                    'id' => $assetsIds
                ]
            ];
        }


        // Filter by region if applicable
        $filterregion = $request->columns[13]['search']['value'] ?? ''; // Assuming column 13 is the region filter

        if ($filterregion) {
            $conditions['whereHas'] = [
                'hostRegions' => function ($query) use ($filterregion) {
                    $query->where('host_regions.id', $filterregion);
                }
            ];
        }

        // Getting total records count with and without global search
        [$totalRecords, $totalRecordswithFilter] = getDatatableFilterTotalRecordsCount(
            Asset::class,
            $dataTableDetails,
            $customFilterFields,
            $conditions
        );

        $mainTableColumns = getTableColumnsSelect(
            'assets',
            [
                'id',
                'ip',
                'name',
                'asset_value_level_id',
                'asset_category_id',
                'location_id',
                'asset_environment_category_id',
                'os',
                'asset_owner',
                'model',
                'created',
                'updated_at',
                'verified'
            ]
        );

        // Getting records with apply global search */
        $assets = getDatatableFilterRecords(
            Asset::class,
            $dataTableDetails,
            $customFilterFields,
            $relationshipsWithColumns,
            $mainTableColumns,
            $conditions
        );

        $assets->load(['hostRegions']); // Load hostRegions relationship for the assets

        // Custom assets response data for datatable
        $data_arr = [];
        foreach ($assets as $asset) {
            $regions = $asset->hostRegions[0]->name ?? null; // Collecting unique region names

            $data_arr[] = [
                'id' =>  $asset->id,
                'ip' => $asset->ip,
                'name' => $asset->name,
                'location' => $asset->location->name ?? '',
                'value' => $asset->assetValueLevel ? $asset->assetValueLevel->name : '',
                'assetCategory' => $asset->assetCategory ? $asset->assetCategory->name : '',
                'assetEnvironmentCategory' => $asset->assetEnvironmentCategory ? $asset->assetEnvironmentCategory->name : '',
                'assetOs' => $asset->assetOs ? $asset->assetOs->name : '',
                'asset_owner' => $asset->Users->name ?? null,
                'model' => $asset->model,
                'created' => $asset->created,
                'updated_at' => $asset->updated_at,
                'verified' => $asset->verified,
                'regions' => $regions,
                'Actions' => $asset->id,
            ];
        }

        // Return custom response for datatable ajax request
        $response = getDatatableAjaxResponse(intval($dataTableDetails['draw']), $totalRecords, $totalRecordswithFilter, $data_arr);

        return response()->json($response, 200);
    }


    /**
     * Return an Export file for listing of the resource after some manipulation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function ajaxExport(Request $request)
    {
        $type = $request->type; // 'xlsx' or 'pdf'
        $region = $request->region;
        $message = $this->assetExportService->exportAssets($type, $region);

        return response()->json(['message' => $message]);
    }


    public function downloadExportedFile($filename)
    {
        $filePath = storage_path('app/exports/assets/' . $filename);

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->download($filePath, $filename);
    }




    public function notificationsSettingsActiveAsset()
    {
        // defining the breadcrumbs that will be shown in page

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.asset_management.index'), 'name' => __('locale.asset_management')],
            ['name' => __('locale.NotificationsSettings')]
        ];

        $users = User::select('id', 'name')->where('enabled', true)->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [47, 48, 49];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [75];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            47 => ['Name', 'Details', 'Start_Date', 'Expiration_Date', 'Alert_Period', 'Ip', 'Location', 'asset_value_level', 'Team'],
            48 => ['Name', 'Details', 'Start_Date', 'Expiration_Date', 'Alert_Period', 'Ip', 'Location', 'asset_value_level', 'Team'],
            49 => ['Name', 'Details', 'Start_Date', 'Expiration_Date', 'Alert_Period', 'Ip', 'Location', 'asset_value_level', 'Team'],
            75 => ['Name', 'Details', 'Start_Date', 'Expiration_Date', 'Alert_Period', 'Ip', 'Location', 'asset_value_level', 'Team'],
        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [
            47 => ['Team-teams' => __('asset.TeamsOfAsset'), 'Asset-Owner' => __('asset.AssetOwner')],
            48 => ['Team-teams' => __('asset.TeamsOfAsset'), 'Asset-Owner' => __('asset.AssetOwner')],
            49 => ['Team-teams' => __('asset.TeamsOfAsset'), 'Asset-Owner' => __('asset.AssetOwner')],
            75 => ['Team-teams' => __('asset.TeamsOfAsset'), 'Asset-Owner' => __('asset.AssetOwner')],
        ];
        $moduleActionsIdsAutoNotify = [75];
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


    // This function is used to open the import form and send the required data for it
    public function openImportForm()
    {
        // Defining breadcrumbs for the page
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => 'javascript:void(0)', 'name' => __('locale.Asset Management')],
            ['link' => route('admin.asset_management.index'), 'name' => __('locale.Assets')],
            ['name' => __('locale.Import')]
        ];

        // Defining database columns with rules and examples
        $databaseColumns = [
            // Column: 'name'
            ['name' => 'name', 'rules' => ['required', 'should be unique in assets table'], 'example' => 'John Doe'],

            // Column: 'ip'
            ['name' => 'ip', 'rules' => ['Can be empty', 'must be in IP form'], 'example' => '192.168.1.1'],

            // Column: 'teams'
            ['name' => 'teams', 'rules' => [
                'Can be empty',
                'should be written as comma-separated text',
                'must exist in teams of the system. Teams not in the system will be removed'
            ], 'example' => 'Team1, Team2'],

            // Column: 'verified'
            ['name' => 'verified', 'rules' => [
                'required',
                'must have value "verified" or "not verified"',
            ], 'example' => "verified"],


            // Column: 'asset_value_level'
            ['name' => 'asset_value', 'rules' => [
                'can be empty',
                'must exist in asset value levels table',
            ], 'example' => "High"],

            // Column: 'location'
            ['name' => 'location', 'rules' => [
                'can be empty',
                'must exist in locations table',
            ], 'example' => "Location 1"],

            // Column: 'asset_category'
            ['name' => 'asset_category', 'rules' => [
                'can be empty',
                'must exist in asset categories table',
            ], 'example' => "asset category 1"],

            // Column: 'asset_environment_category'
            ['name' => 'asset_environment_category', 'rules' => [
                'can be empty',
                'must exist in asset environment categories table',
            ], 'example' => "asset environment category 1"],

            // Column: 'details'
            ['name' => 'details', 'rules' => ['Can be empty'], 'example' => 'Some details'],

            // Column: 'start_date'
            ['name' => 'start_date', 'rules' => [
                'Can be empty',
                'must be date in this form: mm/dd/yy'
            ], 'example' => '12/01/21'],

            // Column: 'expiration_date'
            ['name' => 'expiration_date', 'rules' => [
                'can be empty',
                'must be date in this form: mm/dd/yy'
            ], 'example' => '12/01/21'],
            // Column: 'url'
            ['name' => 'url', 'rules' => [
                'can be empty',

            ], 'example' => 'www.site.com'],
            // Column: 'os'
            ['name' => 'os', 'rules' => [
                'can be empty',
                'must exist in operating systems table',
            ], 'example' => "Windows"],
            // Column: 'os_version'
            ['name' => 'os_version', 'rules' => [
                'can be empty',
            ], 'example' => 'version 1'],
            // Column: 'physical_virtual_type'
            ['name' => 'physical_virtual_type', 'rules' => [
                'can be empty',
                'must have value "physical" or "virtual"',
            ], 'example' => "physical"],

            ['name' => 'asset_owner', 'rules' => [
                'can be empty',
                'should be exist in users table"',
            ], 'example' => 'Admin'],
            // Column: 'owner_email'
            // ['name' => 'owner_email', 'rules' => [
            //     'can be empty',
            //     'must be email'
            // ], 'example' => 'owner@gmail.com'],
            // Column: 'owner_manager_email'
            // ['name' => 'owner_manager_email', 'rules' => [
            //     'can be empty',
            //     'must be email'
            // ], 'example' => 'manager@gmail.com'],
            // Column: 'project_vlan'
            ['name' => 'project_vlan', 'rules' => [
                'can be empty',
            ], 'example' => 'project vlan'],
            // Column: 'vlan'
            ['name' => 'vlan', 'rules' => [
                'can be empty',
            ], 'example' => 'vlan'],
            // Column: 'vendor_name'
            ['name' => 'vendor_name', 'rules' => [
                'can be empty',
            ], 'example' => 'vendor name'],
            // Column: 'model'
            ['name' => 'model', 'rules' => [
                'can be empty',
            ], 'example' => 'model 1'],
            // Column: 'firmware'
            ['name' => 'firmware', 'rules' => [
                'can be empty',
            ], 'example' => 'firmware 1'],
            // Column: 'city'
            ['name' => 'city', 'rules' => [
                'can be empty',
            ], 'example' => 'city 1'],
            // Column: 'rack_location'
            ['name' => 'rack_location', 'rules' => [
                'can be empty',
            ], 'example' => 'rack_location 1'],
            // Column: 'mac_address'
            ['name' => 'mac_address', 'rules' => [
                'can be empty',
            ], 'example' => 'mac_address 1'],
            // Column: 'subnet_mask'
            ['name' => 'subnet_mask', 'rules' => [
                'can be empty',
            ], 'example' => 'subnet_mask 1'],

        ];

        // Define the path for the import data function
        $importDataFunctionPath = route('admin.asset_management.ajax.importData');

        // Return the view with necessary data
        return view('admin.import.index', compact('breadcrumbs', 'databaseColumns', 'importDataFunctionPath'));
    }


    // This function is used to validate the data coming from mapping column and then
    // sending them to "AssetsImport" class to import its data
    public function importData(Request $request)
    {
        // Validate the incoming request for the 'import_file' field
        $validator = Validator::make($request->all(), [
            'import_file' => ['required', 'file', 'max:5000'],
        ]);

        // Check for validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            // Prepare response with validation errors
            $response = [
                'status' => false,
                'errors' => $errors,
                'message' => __('locale.ThereWasAProblemImportingTheItem', ['item' => __('locale.Assets')])
                    . "<br>" . __('locale.Validation error'),
            ];
            return response()->json($response, 422);
        } else {

            // Start a database transaction
            DB::beginTransaction();
            try {
                // Mapping columns from the request to database columns
                $columnsMapping = array();
                $columns = [
                    'name',
                    'ip',
                    'teams',
                    'verified',
                    'asset_value',
                    'location',
                    'asset_category',
                    'asset_environment_category',
                    'details',
                    'start_date',
                    'expiration_date',
                    'url',
                    'os',
                    'os_version',
                    'physical_virtual_type',
                    'asset_owner',
                    'project_vlan',
                    'vlan',
                    'vendor_name',
                    'model',
                    'firmware',
                    'city',
                    'rack_location',
                    'mac_address',
                    'subnet_mask',
                ];

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
                        $cleanedColumn = preg_replace('/(\w+)_\b/', '$1', $cleanedColumn);
                        $snakeCaseColumn = Str::snake($cleanedColumn);
                        $columnsMapping[$column] = $snakeCaseColumn;
                    }
                }


                // Extract values and filter out null values
                $values = array_values(array_filter($columnsMapping, function ($value) {
                    if ($value != null && $value != '') {
                        return $value;
                    }
                }));

                // Check for duplicate values
                if (count($values) !== count(array_unique($values))) {
                    $response = [
                        'status' => false,
                        'message' => __('locale.YouCantUseTheSameFileColumnForMoreThanOneDatabaseColumn'),
                    ];
                    return response()->json($response, 422);
                }

                // Import data using the specified columns mapping
                (new AssetsImport($columnsMapping))->import(request()->file('import_file'));

                // Commit the transaction
                DB::commit();
                $message = __("locale.New Data Imported In Asset") . " \" " . __("locale.CreatedBy") . " \"" . auth()->user()->name . "\".";
                write_log(1, auth()->id(), $message);
                // Prepare success response
                $response = [
                    'status' => true,
                    'reload' => true,
                    'message' => __('locale.ItemWasImportedSuccessfully', ['item' => __('locale.Assets')]),
                ];
                return response()->json($response, 200);
            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                // Rollback the transaction in case of an exception
                DB::rollBack();

                // Handle validation exceptions and prepare error response
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
                    'message' => __('locale.ThereWasAProblemImportingTheItem', ['item' => __('locale.Assets')]),
                ];
                return response()->json($response, 502);
            }
        }
    }
    public function assetStatistics()
    {
        // Get asset count grouped by asset value level
        $assetValue = $this->getAssetValue();

        // Get asset count based on verified status (0 or 1)
        $verifiedAssets = $this->getVerifiedAssetCount();

        // Get assets grouped by department
        $assetsWithDepartment = $this->getAssetsByDepartment();
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],

            ['link' => route('admin.asset_management.index'), 'name' => __('locale.asset_management')],
            ['name' => __('locale.Report')]
        ];

        // Pass all data to the view
        return view('admin.content.asset_management.asset.assetstatistics', compact('assetValue', 'verifiedAssets', 'assetsWithDepartment', 'breadcrumbs'));
    }

    public function getAssetsByDepartment()
    {
        // Initialize an array to hold department counts
        $departmentVulnCount = [];

        // Get all assets with the associated users and departments
        $assets = Asset::get();  // Eager load user and department data

        foreach ($assets as $asset) {
            $user = User::where('id', $asset->owner_id)->first();

            if ($user && $user->department_id) {
                // If the user has a department, get the department name
                $department = Department::find($user->department_id);
                if ($department) {
                    $deptName = $department->name;

                    // Increment the count for this department
                    if (!isset($departmentVulnCount[$deptName])) {
                        $departmentVulnCount[$deptName] = 0;
                    }

                    $departmentVulnCount[$deptName]++;
                }
            } else {
                // If no department is assigned, increment the "No Department" count
                if (!isset($departmentVulnCount['No Department'])) {
                    $departmentVulnCount['No Department'] = 0;
                }

                $departmentVulnCount['No Department']++;
            }
        }

        return $departmentVulnCount;
    }


    private function getAssetValue()
    {
        // Get asset value levels and their associated asset counts
        $assetValue = Asset::selectRaw('asset_value_level_id, count(*) as asset_count')  // Count assets per asset_value_level_id
            ->groupBy('asset_value_level_id')  // Group by the asset value level
            ->get();  // Retrieve the result

        // Get all asset value levels (names and ids)
        $assetValueLevels = AssetValueLevel::all()->pluck('name', 'id');  // Get all names and ids in a key-value pair (id => name)

        // Format the result to include asset value level name, status, and the count
        $assetValue = $assetValue->map(function ($item) use ($assetValueLevels) {
            // Get the name of the asset value level using the asset_value_level_id
            $item->assetValueLevelName = $assetValueLevels[$item->asset_value_level_id] ?? 'No Asset Value';

            // Get the asset count
            $item->assetCount = $item->asset_count;

            return $item;
        });

        return $assetValue;
    }

    private function getVerifiedAssetCount()
    {
        // Get asset count based on verified status (0 or 1)
        $verifiedAssets = Asset::selectRaw('verified, count(*) as asset_count')  // Select verified status and count
            ->groupBy('verified')  // Group by verified status (0 or 1)
            ->get();  // Retrieve the result

        // Format the result
        $verifiedAssets = $verifiedAssets->map(function ($item) {
            $item->verifiedStatus = $item->verified == 1 ? 'Verified' : 'Not Verified';  // Display "Verified" or "Not Verified"
            return $item;
        });

        return $verifiedAssets;
    }
}
