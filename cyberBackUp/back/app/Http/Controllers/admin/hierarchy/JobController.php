<?php

namespace App\Http\Controllers\admin\hierarchy;

use App\Exports\JobsExport;
use App\Http\Controllers\Controller;
use App\Imports\JobsImport;
use App\Models\Job;
use App\Models\User;
use App\Models\Action;
use App\Events\JobCreated;
use App\Events\JobUpdated;
use App\Events\JobDeleted;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;


class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::select('id', 'name')->get();
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
        ['link' => route('admin.hierarchy.index'), 'name' => __('locale.Hierarchy')],
        ['name' => __('locale.Jobs')]];

        return view('admin.content.hierarchy.job.index', compact('breadcrumbs', 'users'));
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
            'name' => ['required', 'max:100', 'unique:jobs,name'],
            'code' => ['nullable', 'max:10', 'unique:jobs,code'],
            'description' => ['required', 'max:500']
        ]);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('hierarchy.ThereWasAProblemAddingTheJob') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();
            try {
                $job = Job::create([
                    'name' => $request->name,
                    'code' => $request->code,
                    'description' => $request->description,
                ]);

                DB::commit();

                event(new JobCreated($job));

                $response = array(
                    'status' => true,
                    'message' => __('hierarchy.JobWasAddedSuccessfully'),
                );
                $message = __('hierarchy.A New Job created with name') . ' "' . ($job->name ?? __('locale.[No Name]')) . '"' . __('locale.And with description is') . ' "' . ($job->description ?? __('locale.[No Description]')) . '". ' . __('locale.CreatedBy') . ' "' . auth()->user()->name . '"';
                write_log($job->id, auth()->id(), $message, 'Creating Job');
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
        $job = Job::find($id);
        if ($job) {

            $data = $job->toArray();

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
        $job = Job::find($id);
        if ($job) {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'max:100', 'unique:jobs,name,' .  $job->id],
                'code' => ['nullable', 'max:10', 'unique:jobs,code,' .  $job->id],
                'description' => ['required', 'max:500']
            ]);

            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('hierarchy.ThereWasAProblemUpdatingTheJob') . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();
                try {
                    // to get the old data of Job to use it in log
                    $jobOldDetAils = Job::find($id);
                    $job->update([
                        'name' => $request->name,
                        'code' => $request->code,
                        'description' => $request->description,
                    ]);

                    DB::commit();

                    event(new JobUpdated($job));

                    $response = array(
                        'status' => true,
                        'message' => __('hierarchy.JobWasUpdatedSuccessfully'),
                    );
                    $message = __('hierarchy.A Job that name is') . ' "' . ($jobOldDetAils->name ?? __('locale.[No Name]')) . '"';

                    if ($jobOldDetAils->name != $job->name) {
                        $message .= ' ' . __('hierarchy.changed to') . ' "' . ($job->name ?? __('locale.[No Name]')) . '"';
                    } else {
                        $message .= ' ' . __('hierarchy.That Description of it is') . ' "' . ($jobOldDetAils->description ?? __('locale.[No Description]')) . '"';
                    }

                    if ($jobOldDetAils->description != $job->description) {
                        $message .= ' ' . __('hierarchy.And the description changed from') . ' "' . ($jobOldDetAils->description ?? __('locale.[No Description]')) . '"';
                    }

                    $message .= ' ' . __('locale.to') . ' "' . ($job->description ?? __('locale.[No Description]')) . '"';
                    $message .= ' ' . __('locale.UpdatedBy') . ' "' . auth()->user()->name . '".';


                    write_log($job->id, auth()->id(), $message, 'Updating Job');

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
        $job = Job::find($id);
        if ($job) {
            DB::beginTransaction();
            try {
                $job->delete();

                DB::commit();
                event(new JobDeleted($job));

                $response = array(
                    'status' => true,
                    'message' => __('locale.JobWasDeletedSuccessfully'),
                );
                $message = __('hierarchy.A Job that name is') . ' "' . ($job->name ?? __('locale.[No Name]')) . '" ' . __('hierarchy.and the Description of it is') . ' "' . ($job->description ?? __('locale.[No Description]')) . '". ' . __('locale.DeletedBy') . ' "' . auth()->user()->name . '".';
                write_log($job->id, auth()->id(), $message, 'Deleting Job');
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                if ($th->errorInfo[0] == 23000) {
                    $errorMessage = __('hierarchy.ThereWasAProblemDeletingTheEmployee') . "<br>" . __('locale.CannotDeleteRecordRelationError');
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
            'normal' => ['name', 'code'],
            'relationships' => ['employees'],
            'other_global_filters' => ['description', 'created_at'],
        ];
        $relationshipsWithColumns = [
            // 'relationshipName:column1,column2,....'
            'employees:job_id,name'
        ];

        prepareDatatableRequestFields($request, $dataTableDetails, $customFilterFields);
        /* End reading datatable data and custom fields for filtering */

        // Getting total records count with and without apply global search
        [$totalRecords, $totalRecordswithFilter] = getDatatableFilterTotalRecordsCount(Job::class, $dataTableDetails, $customFilterFields);

        $mainTableColumns = getTableColumnsSelect(
            'jobs',
            [
                'id',
                'name',
                'description',
                'code',
                'created_at'
            ]
        );

        // Getting records with apply global search */
        $jobs = getDatatableFilterRecords(
            Job::class,
            $dataTableDetails,
            $customFilterFields,
            $relationshipsWithColumns,
            $mainTableColumns
        );

        // Custom jobs response data as needs
        $data_arr = [];
        foreach ($jobs as $job) {
            $data_arr[] = array(
                'id' =>  $job->id,
                'name' => $job->name,
                'code' => $job->code,
                'description' => $job->description,
                'employees' => array_map(function ($element) {
                    return $element['name'];
                }, $job->employees->toArray()),
                'created_at' => $job->created_at->format('Y-m-d H:i:s'),
                'Actions' => $job->id,
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
            return Excel::download(new JobsExport, 'Jobs.xlsx');
        else
            return 'Jobs.pdf';
    }

    /**
     * Download import template.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downloadImportTemplate()
    {
        $exists = Storage::disk('local')->exists('imports/Jobs-template.xlsx');
        if ($exists) {
            return Storage::download('imports/Jobs-template.xlsx', 'Jobs-template.xlsx');
        } else {
            // return redirect()->back();
            return redirect('/');
        }
    }


    public function notificationsSettingsJob()
    {
        // defining the breadcrumbs that will be shown in page


        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.hierarchy.index'), 'name' => __('locale.Hierarchy')],
            ['link' => route('admin.hierarchy.job.index'), 'name' => __('locale.Jobs')],
            ['name' => __('locale.NotificationsSettings')]
        ];

        $users = User::select('id', 'name')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [25, 26, 27];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            25 => ['name', 'description'],
            26 => ['name', 'description'],
            27 => ['name', 'description'],

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
            ['link' => route('admin.hierarchy.index'), 'name' => __('locale.Hierarchy')],
            ['link' => route('admin.hierarchy.job.index'), 'name' => __('locale.Jobs')],
            ['name' => __('locale.Import')]
        ];

        // Defining database columns with rules and examples
        $databaseColumns = [
            // Column: 'name'
            ['name' => 'name', 'rules' => ['required', 'should be unique in jobs table'], 'example' => 'Tester'],

            // Column: 'code'
            ['name' => 'code', 'rules' => ['Can be empty', 'should be unique in jobs table'], 'example' => 'tester_job_code'],

            // Column: 'description'
            ['name' => 'description', 'rules' => ['required'], 'example' => 'Some description'],
        ];

        // Define the path for the import data function
        $importDataFunctionPath = route('admin.hierarchy.job.ajax.importData');

        // Return the view with necessary data
        return view('admin.import.index', compact('breadcrumbs', 'databaseColumns', 'importDataFunctionPath'));
    }


    // This function is used to validate the data coming from mapping column and then
    // sending them to "JobsImport" class to import its data
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
                'message' => __('locale.ThereWasAProblemImportingTheItem', ['item' => __('locale.Jobs')])
                . "<br>" . __('locale.Validation error'),
            ];
            return response()->json($response, 422);
        } else {
            // Start a database transaction
            DB::beginTransaction();
            try {
                // Mapping columns from the request to database columns
                $columnsMapping = array();
                $columns = ['name', 'code', 'description'];

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
                (new JobsImport($columnsMapping))->import(request()->file('import_file'));

                // Commit the transaction
                DB::commit();
                $message = __("locale.New Data Imported At Job") . " \" " . __("locale.CreatedBy") . " \"" . auth()->user()->name . "\".";
                write_log(1, auth()->id(), $message);
                // Prepare success response
                $response = [
                    'status' => true,
                    'reload' => true,
                    'message' => __('locale.ItemWasImportedSuccessfully', ['item' => __('locale.Jobs')]),
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
                    'message' => __('locale.ThereWasAProblemImportingTheItem', ['item' => __('locale.Jobs')]),
                ];
                return response()->json($response, 502);
            }
        }
    }
}
