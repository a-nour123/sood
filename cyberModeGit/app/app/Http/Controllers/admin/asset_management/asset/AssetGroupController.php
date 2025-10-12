<?php

namespace App\Http\Controllers\admin\asset_management\asset;

use App\Exports\AssetGroupsExport;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Action;
use App\MOdels\User;
use App\Events\AssetsGroupCreated;
use App\Events\AssetGroupUpdated;
use App\Events\AssetGroupDeleted;
use App\Imports\AssetGroupsImport;
use Illuminate\Support\Str;


class AssetGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assetGroups = AssetGroup::select('id', 'name')->get();
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' => "javascript:void(0)", 'name' => __('locale.Asset Management')], ['name' => __('locale.AssetGroups')]];

        return view('admin.content.asset_management.asset_group.index', compact('breadcrumbs', 'assetGroups'));
    }

    public function getAssets(Request $request)
    {
        $query = $request->get('q', '');

        $assets = Asset::select('id', 'name')
            ->where('name', 'like', '%' . $query . '%')
            ->get();

        return response()->json($assets);
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
            'name' => ['required', 'max:100', 'unique:asset_groups,name'],
            'assets' => ['nullable', 'array'],
            'assets.*' => ['exists:assets,id'], // the asset that asset group belongs to
        ]);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('asset.ThereWasAProblemCreatingTheAssetGroup') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();
            try {
                $assetGroup = AssetGroup::create([
                    'name' => $request->name,
                ]);

                $allAssets = Asset::whereIn('id', $request->assets ?? [])->get();
                $assetGroup->assets()->saveMany($allAssets);

                $assets = Asset::whereIn('id', $request->assets ?? [])->pluck('name')->toArray();

                $message = __('asset.AssetGroupCreateAuditLog', [
                    'user' => auth()->user()->name,
                    'group_name' => $assetGroup->name,
                    'id' => $assetGroup->id + 1000,
                    'assets_to' => implode(', ', $assets)
                ]);
                write_log($assetGroup->id, auth()->id(), $message, 'asset_group');

                DB::commit();
                event(new AssetsGroupCreated($assetGroup, $allAssets));



                $response = array(
                    'status' => true,
                    'message' => __('asset.AssetGroupCreatedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                    // 'message' => $th->getMessage() . __('locale.Error'),
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
        // Find the asset group by ID
        $assetGroup = AssetGroup::with('assets')->find($id);

        // Check if asset group exists
        if (!$assetGroup) {
            return response()->json([
                'status' => false,
                'message' => __('locale.AssetGroupNotFound'),
            ], 404);
        }

        // Prepare the assets data
        $assets = $assetGroup->assets->map(function ($asset) {
            return [
                'id' => $asset->id,
                'name' => $asset->name,
            ];
        });

        // Return the asset group data with associated assets
        return response()->json([
            'status' => true,
            'data' => [
                'id' => $assetGroup->id,
                'name' => $assetGroup->name,
                'assets' => $assets,
            ],
        ]);
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
        $assetGroup = AssetGroup::find($id);
        if ($assetGroup) {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'max:100', 'unique:asset_groups,name,' . $assetGroup->id],
                'assets' => ['nullable', 'array'],
                'assets.*' => ['exists:assets,id'], // the asset that asset group belongs to
            ]);

            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('asset.ThereWasAProblemUpdatingTheAssetGroup') . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();
                try {
                    $assetGroup->update([
                        'name' => $request->name,
                    ]);

                    $currentAssets = $assetGroup->assets()->pluck('id')->toArray();
                    $deletedAssets = array_diff($currentAssets ?? [], $request->assets ?? []);
                    $addedAssets = array_diff($request->assets ?? [], $currentAssets ?? []);

                    // Delete deleted assets
                    $assetGroup->assets()->detach($deletedAssets);

                    $allAssetAssets = Asset::whereIn('id', $addedAssets ?? [])->get();

                    // Add added assets
                    $assetGroup->assets()->saveMany($allAssetAssets);
                    $assets = Asset::whereIn('id', $request->assets ?? [])->pluck('name')->toArray();
                    $allAssets = Asset::whereIn('id', $request->assets ?? [])->pluck('owner_email')->toArray();
                    $assetsCurrent = Asset::whereIn('id', $currentAssets)->pluck('name')->toArray();
                    $addedAssets = Asset::whereIn('id', $addedAssets)->pluck('name')->toArray();
                    $deletedAssets = Asset::whereIn('id', $deletedAssets)->pluck('name')->toArray();
                    $asset_changes = [];
                    if ($addedAssets)
                        $asset_changes[] = __('asset.AssetGroupUpdateAuditLogAdded', ['assets_added' => implode(", ", $addedAssets)]);
                    if ($deletedAssets)
                        $asset_changes[] = __('asset.AssetGroupUpdateAuditLogRemoved', ['assets_removed' => implode(", ", $deletedAssets)]);

                    // Audit log
                    $message = __('asset.AssetGroupUpdateAuditLog', [
                        'user' => auth()->user()->name,
                        'group_name' => $assetGroup->name,
                        'id' => $assetGroup->id + 1000,
                        'assets_from' => implode(', ', $assetsCurrent),
                        'assets_to' => implode(', ', $assets),
                        'asset_changes' => implode(", ", $asset_changes)
                    ]);

                    // write_log($assetGroup->id, auth()->id(), $message, 'asset_group');

                    DB::commit();
                    event(new AssetGroupUpdated($assetGroup, $allAssets));



                    $response = array(
                        'status' => true,
                        'message' => __('asset.JobWasUpdatedSuccessfully'),
                    );
                    return response()->json($response, 200);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    $response = array(
                        'status' => false,
                        'message' => $th->getLine(),
                    );
                    return response()->json($response, 400);
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
        $assetGroup = AssetGroup::find($id);
        $assetGroupName = $assetGroup->name;
        if ($assetGroup) {
            DB::beginTransaction();
            try {
                $assetGroup->delete();

                // Audit log
                $message = __('asset.AssetGroupDeleteAuditLog', [
                    'user' => auth()->user()->name,
                    'group_name' => $assetGroupName,
                    'id' => $id + 1000
                ]);
                write_log($id, auth()->id(), $message, 'asset_group');

                DB::commit();
                event(new AssetGroupDeleted($assetGroup));

                $response = array(
                    'status' => true,
                    'message' => __('asset.AssetGroupDeletedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                if ($th->errorInfo[0] == 23000) {
                    $errorMessage = __('asset.ThereWasAProblemDeletingTheAsset') . "<br>" . __('locale.CannotDeleteRecordRelationError');
                } else {
                    $errorMessage = __('asset.ThereWasAProblemDeletingTheAssetGroup');
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
            'normal' => ['name'],
            'relationships' => ['assets'],
            'other_global_filters' => [],
        ];
        $relationshipsWithColumns = [
            // 'relationshipName:column1,column2,....'
            'assets:id,name'
        ];

        prepareDatatableRequestFields($request, $dataTableDetails, $customFilterFields);
        /* End reading datatable data and custom fields for filtering */

        // Getting total records count with and without apply global search
        [$totalRecords, $totalRecordswithFilter] = getDatatableFilterTotalRecordsCount(
            AssetGroup::class,
            $dataTableDetails,
            $customFilterFields
        );

        $mainTableColumns = getTableColumnsSelect(
            'asset_groups',
            [
                'id',
                'name',
            ]
        );

        // Getting records with apply global search */
        $assetGroups = getDatatableFilterRecords(
            AssetGroup::class,
            $dataTableDetails,
            $customFilterFields,
            $relationshipsWithColumns,
            $mainTableColumns
        );

        // Custom assetGroups response data as needs
        $data_arr = [];
        foreach ($assetGroups as $assetGroup) {
            $data_arr[] = array(
                'id' =>  $assetGroup->id,
                'name' => $assetGroup->name,
                'assets' => $assetGroup->assets,
                'Actions' => $assetGroup->id,
            );
        }

        // Get custom response for datatable ajax request
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
        if ($request->type != 'pdf')
            return Excel::download(new AssetGroupsExport, 'Asset_groups.xlsx');
        else
            return 'Assets.pdf';
    }
    public function notificationsSettingsAssetManagement()
    {
        // defining the breadcrumbs that will be shown in page

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.asset_management.asset_group.index'), 'name' => __('locale.AssetManagement')],
            ['name' => __('locale.NotificationsSettings')]
        ];

        $users = User::select('id', 'name')->where('enabled', true)->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [50, 51, 52];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            50 => ['Name'],
            51 => ['Name'],
            52 => ['Name'],
        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [
            50 => ['Asset-Owner' => __('locale.AssetOwner')],
            51 => ['Asset-Owner' => __('locale.AssetOwner')],
            52 => ['Asset-Owner' => __('locale.AssetOwner')],
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

    // This function is used to open the import form and send the required data for it
    public function openImportForm()
    {
        // Defining breadcrumbs for the page
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => 'javascript:void(0)', 'name' => __('locale.Asset Management')],
            ['link' => route('admin.asset_management.index'), 'name' => __('locale.AssetGroups')],
            ['name' => __('locale.Import')]
        ];

        // Defining database columns with rules and examples
        $databaseColumns = [
            // Column: 'name'
            ['name' => 'name', 'rules' => ['required', 'should be unique in asset_groups table'], 'example' => 'Asset Group1'],
        ];

        // Define the path for the import data function
        $importDataFunctionPath = route('admin.asset_management.ajax.asset_group.importData');

        // Return the view with necessary data
        return view('admin.import.index', compact('breadcrumbs', 'databaseColumns', 'importDataFunctionPath'));
    }


    // This function is used to validate the data coming from mapping column and then
    // sending them to "AssetGroupsImport" class to import its data
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
                'message' => __('locale.ThereWasAProblemImportingTheItem', ['item' => __('locale.AssetGroups')])
                    . "<br>" . __('locale.Validation error'),
            ];
            return response()->json($response, 422);
        } else {
            // Start a database transaction
            DB::beginTransaction();
            try {
                // Mapping columns from the request to database columns
                $columnsMapping = array();
                $columns = ['name'];

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
                (new AssetGroupsImport($columnsMapping))->import(request()->file('import_file'));

                // Commit the transaction
                DB::commit();
                $message = __("locale.New Data Imported In Asset Group") . " \" " . __("locale.CreatedBy") . " \"" . auth()->user()->name . "\".";
                write_log(1, auth()->id(), $message);
                // Prepare success response
                $response = [
                    'status' => true,
                    'reload' => true,
                    'message' => __('locale.ItemWasImportedSuccessfully', ['item' => __('locale.AssetGroups')]),
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
                    'message' => __('locale.ThereWasAProblemImportingTheItem', ['item' => __('locale.AssetGroups')]),
                ];
                return response()->json($response, 502);
            }
        }
    }
}
