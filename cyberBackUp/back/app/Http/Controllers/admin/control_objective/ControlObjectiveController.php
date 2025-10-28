<?php

namespace App\Http\Controllers\admin\control_objective;

use App\Exports\ControlObjectivesExport;
use App\Http\Controllers\Controller;
use App\Imports\ControlObjectivesImport;
use App\Models\ControlObjective;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Models\Action;
use App\Events\ControlObjectivesMainCreated;
use App\Events\ControlObjectivesMainUpdated;
use App\Events\ControlObjectivesMainDeleted;
use App\Models\ControlControlObjective;
use App\Models\Framework;
use App\Models\FrameworkControl;
use App\Models\FrameworkControlMapping;
use Illuminate\Support\Str;




class ControlObjectiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $controlObjectives = ControlObjective::select('id', 'name')->get();
        $frameworks = Framework::select('id', 'name')->get();
        $breadcrumbs = [
            [
                'link' => route('admin.dashboard'),
                'name' => __('locale.Dashboard')
            ],
            ['name' => __('locale.Regulators')],
            [
                'name' => __('locale.ControlRequirement')
            ]
        ];

        return view('admin.content.control_objective.index', compact('breadcrumbs', 'controlObjectives', 'frameworks'));
    }

    public function getFrameworkControls(Request $request)
    {
        $frameworkIds = $request->get('framework_ids');

        // Retrieve framework control mappings for the given framework IDs
        $controls = FrameworkControlMapping::whereIn('framework_id', $frameworkIds)
            ->join('framework_controls', 'framework_control_mappings.framework_control_id', '=', 'framework_controls.id')
            ->whereIn('framework_control_mappings.framework_id', $frameworkIds)
            ->select('framework_controls.id', 'framework_controls.short_name')
            ->orderByRaw('FIELD(framework_control_mappings.framework_id, ?)', [$frameworkIds])
            ->distinct()
            ->get();

        return response()->json(['controls' => $controls]);
    }

    public function getControls(Request $request)
    {
        $controlIds = $request->get('controls');

        // Retrieve controls for the given control IDs
        $controls = FrameworkControl::whereIn('id', $controlIds)->get();

        return response()->json(['controls' => $controls]);
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
            'name' => ['required', 'unique:control_objectives,name'],
            'description' => ['required', 'max:500'],
            'control_id' => ['required', 'array'],
            'framework_id' => ['required', 'array']
        ]);

        // Check if there are any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('locale.ThereWasAProblemAddingTheControlRequirement')
                    . "<br>" . __('locale.ValidationError'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();
            try {
                // Create the ControlObjective
                $ControlObjective = ControlObjective::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'framework_id' => implode(',', $request->framework_id),
                    'control_id' => implode(',', $request->control_id),
                ]);

                // Iterate over each control ID and create the corresponding ControlControlObjective
                foreach ($request->control_id as $controlId) {
                    ControlControlObjective::create([
                        'control_id' => $controlId,
                        'objective_id' => $ControlObjective->id,
                    ]);
                }
                DB::commit();

                event(new ControlObjectivesMainCreated($ControlObjective));

                $response = array(
                    'status' => true,
                    'message' => __('locale.ControlRequirementWasAddedSuccessfully'),
                );
                $message = __('locale.ANewRequirementCreatedWithName') . ' "' . ($ControlObjective->name ?? __('locale.[NoRequirementName]')) . '". '
                    . __('locale.AndWithDescriptionIs') . ' "' . ($ControlObjective->description ?? __('locale.[NoDescription]')) . '". '
                    . __('CreatedBy') . ' "' . (auth()->user()->name ?? '[NoUserName]') . '".';
                write_log($ControlObjective->id, auth()->id(), $message, 'CreatingControlObjective');

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

        $controlObjective = ControlObjective::find($id);
        if ($controlObjective) {

            $data = $controlObjective->toArray();

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
        $controlObjectiveOldDetails = ControlObjective::find($id);
        // Find the existing ControlObjective
        $controlObjective = ControlObjective::find($id);

        if ($controlObjective) {
            // Validate request data
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'unique:control_objectives,name,' . $controlObjective->id],
                'description' => ['required', 'max:500'],
                'framework_id' => ['required', 'array'],
                'control_id' => ['required', 'array'],
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                $response = [
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('locale.ThereWasAProblemUpdatingTheControlRequirement') . "<br>" . __('locale.Validation error'),
                ];
                return response()->json($response, 422);
            }

            // Start transaction
            DB::beginTransaction();

            try {
                // Update ControlObjective
                $controlObjective->update([
                    'name' => $request->name,
                    'description' => $request->description,
                    'framework_id' => implode(',', $request->framework_id),
                    'control_id' => implode(',', $request->control_id), // Store as a comma-separated string
                ]);

                // Get current control_ids
                $currentControlIds = $controlObjective->controls()->pluck('control_id')->toArray();

                // Determine which control_ids to remove
                $controlIdsToRemove = array_diff($currentControlIds, $request->control_id);

                // Determine which control_ids to add
                $controlIdsToAdd = array_diff($request->control_id, $currentControlIds);

                // Remove old ControlControlObjective entries
                foreach ($controlIdsToRemove as $controlId) {
                    try {
                        ControlControlObjective::where('objective_id', $controlObjective->id)
                            ->where('control_id', $controlId)
                            ->delete();
                    } catch (\Illuminate\Database\QueryException $ex) {
                        // Rollback transaction on error
                        DB::rollBack();

                        // Fetch control name or other relevant data to include in the message
                        $controlName = FrameworkControl::find($controlId)->short_name ?? 'Unknown Control';

                        // Return a user-friendly error message
                        return response()->json([
                            'status' => false,
                            'message' => __('locale.CannotDeleteRequirementForControl') . ": $controlName. " . __('locale.HasEvidence'),
                        ], 400);
                    }
                }

                // Add new ControlControlObjective entries
                foreach ($controlIdsToAdd as $controlId) {
                    ControlControlObjective::create([
                        'control_id' => $controlId,
                        'objective_id' => $controlObjective->id,
                    ]);
                }

                // Commit transaction
                DB::commit();

                // Fire event
                event(new ControlObjectivesMainUpdated($controlObjective));

                // Prepare response
                $response = [
                    'status' => true,
                    'message' => __('locale.ControlRequirementWasUpdatedSuccessfully'),
                ];

                // Log the changes
                $message = $this->generateUpdateMessage($controlObjectiveOldDetails, $controlObjective);
                write_log($controlObjective->id, auth()->id(), $message, 'Updating controlObjective');

                return response()->json($response, 200);
            } catch (\Throwable $th) {
                // Rollback transaction on error
                DB::rollBack();
                return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
            }
        } else {
            $response = [
                'status' => false,
                'message' => __('locale.Error 404'),
            ];
            return response()->json($response, 404);
        }
    }

    private function generateUpdateMessage($oldDetails, $newDetails)
    {
        $message = '';
        if ($oldDetails->name != $newDetails->name) {
            $message .= __('locale.A Requirement that name is') . ' "' . ($oldDetails->name ?? __('locale.[No Name]')) . '" '
                . __('locale.changed to') . ' "' . ($newDetails->name ?? __('locale.[No Name]')) . '". ';
        }
        if ($oldDetails->description != $newDetails->description) {
            $message .= __('locale.The Description Changed from') . ' "' . ($oldDetails->description ?? __('locale.[No Description]')) . '" '
                . __('locale.to') . ' "' . ($newDetails->description ?? __('locale.[No Description]')) . '". ';
        }
        $message .= __('locale.UpdatedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
        return $message;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $controlObjective = ControlObjective::find($id);
        if ($controlObjective) {
            DB::beginTransaction();
            try {
                // Check for related data
                $relatedData = $controlObjective->hasRelations();

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

                $controlObjective->delete();

                DB::commit();
                event(new ControlObjectivesMainDeleted($controlObjective));

                $response = array(
                    'status' => true,
                    'message' => __('locale.ControlRequirementWasDeletedSuccessfully'),
                );
                $message = __('locale.A Requirement that name is') . ' "' . $controlObjective->name . '". ' . __('locale.and the Description of it is') . ' "' . $controlObjective->description . '". ' . __('locale.DeletedBy') . ' "' . auth()->user()->name . '".';
                write_log($controlObjective->id, auth()->id(), $message, 'Deleting controlObjective');
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                if ($th->errorInfo[0] == 23000) {
                    $errorMessage = __('locale.ThereWasAProblemDeletingTheEmployee')
                        . "<br>" . __('locale.CannotDeleteRecordRelationError');
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
            'normal' => ['name'],
            'relationships' => [],
            'other_global_filters' => ['description', 'created_at'],
        ];
        $relationshipsWithColumns = [];

        prepareDatatableRequestFields($request, $dataTableDetails, $customFilterFields);
        /* End reading datatable data and custom fields for filtering */

        // Getting total records count with and without apply global search
        [$totalRecords, $totalRecordswithFilter] = getDatatableFilterTotalRecordsCount(
            ControlObjective::class,
            $dataTableDetails,
            $customFilterFields
        );

        $mainTableColumns = getTableColumnsSelect(
            'control_objectives',
            [
                'id',
                'name',
                'description',
                'control_id',
                'framework_id',
                'created_at'
            ]
        );

        // Getting records with apply global search */
        $controlObjectives = getDatatableFilterRecords(
            ControlObjective::class,
            $dataTableDetails,
            $customFilterFields,
            $relationshipsWithColumns,
            $mainTableColumns
        );

        // Custom control_objectives response data as needs
        $dataArr = [];
        foreach ($controlObjectives as $controlObjective) {
            // Explode the comma-separated string into arrays
            $frameworkIds = explode(',', $controlObjective->framework_id);
            $controlIds = explode(',', $controlObjective->control_id);

            // Query the frameworks and controls
            $frameworks = Framework::whereIn('id', $frameworkIds)->pluck('name')->toArray();
            $controls = FrameworkControl::whereIn('id', $controlIds)->pluck('short_name')->toArray();

            $dataArr[] = array(
                'id' =>  $controlObjective->id,
                'name' => $controlObjective->name,
                'description' => $controlObjective->description,
                'framework_id' => implode(', ', $frameworks),
                'control_id' => implode(', ', $controls),
                'created_at' => $controlObjective->created_at->format('Y-m-d H:i:s'),
                'Actions' => $controlObjective->id,
            );
        }

        // Get custom response for datatable ajax request
        $response = getDatatableAjaxResponse(
            intval($dataTableDetails['draw']),
            $totalRecords,
            $totalRecordswithFilter,
            $dataArr
        );

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
        if ($request->type != 'pdf') {
            return Excel::download(new ControlObjectivesExport, 'ControlObjectives.xlsx');
        } else {
            return 'ControlObjectives.pdf';
        }
    }

    /**
     * Download import template.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downloadImportTemplate()
    {
        $exists = Storage::disk('local')->exists('imports/ControlObjective-template.xlsx');
        if ($exists) {
            return Storage::download('imports/ControlObjective-template.xlsx', 'ControlObjective-template.xlsx');
        } else {
            return redirect('/');
        }
    }


    public function notificationsSettingsobjective()
    {
        // defining the breadcrumbs that will be shown in page

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Regulators')],
            ['link' => route('admin.control_objectives.index'), 'name' => __('locale.ControlRequirement')],
            ['name' => __('locale.NotificationsSettings')]
        ];

        $users = User::select('id', 'name')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [41, 42, 43];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            41 => ['Name', 'Description'],
            42 => ['Name', 'Description'],
            43 => ['Name', 'Description'],
        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [];
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
            ['name' => __('locale.Regulators')],
            ['link' => route('admin.control_objectives.index'), 'name' => __('locale.ControlRequirement')],
            ['name' => __('locale.Import')]
        ];

        // Defining database columns with rules and examples
        $databaseColumns = [
            // Column: 'name'
            ['name' => 'name', 'rules' => ['required'], 'example' => 'Control Objective1'],

            // Column: 'description'
            ['name' => 'description', 'rules' => ['required'], 'example' => 'Some description'],

            ['name' => 'framework_id', 'rules' => ['required'], 'example' => 'NCA-ECC – 1: 2018 ,.....'],
            // 
            ['name' => 'control_id', 'rules' => ['required'], 'example' => 'ECC 1-1-1 , .......'],

        ];

        // Define the path for the import data function
        $importDataFunctionPath = route('admin.control_objectives.ajax.importData');

        // Return the view with necessary data
        return view('admin.import.index', compact('breadcrumbs', 'databaseColumns', 'importDataFunctionPath'));
    }


    // This function is used to validate the data coming from mapping column and then
    // sending them to "ControlObjectivesImport" class to import its data
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
                'message' => __('locale.ThereWasAProblemImportingTheItem', ['item' => __('locale.ControlRequirement')])
                    . "<br>" . __('locale.Validation error'),
            ];
            return response()->json($response, 422);
        } else {
            // Start a database transaction
            DB::beginTransaction();
            try {
                // Mapping columns from the request to database columns
                $columnsMapping = array();
                $columns = ['name', 'description', 'framework_id', 'control_id'];
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
                (new ControlObjectivesImport($columnsMapping))->import(request()->file('import_file'));

                // Commit the transaction
                DB::commit();
                $message = __("locale.New Data Imported In Control Objective") . " \" " . __("locale.CreatedBy") . " \"" . auth()->user()->name . "\".";
                write_log(1, auth()->id(), $message);
                // Prepare success response
                $response = [
                    'status' => true,
                    'reload' => true,
                    'message' => __('locale.ItemWasImportedSuccessfully', ['item' => __('locale.ControlRequirement')]),
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
                    'message' => __('locale.ThereWasAProblemImportingTheItem', ['item' => __('locale.ControlRequirement')]),
                ];
                return response()->json($response, 502);
            }
        }
    }
}
