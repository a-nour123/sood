<?php

namespace App\Http\Controllers\admin\hierarchy;

use App\Exports\DepartmentsExport;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\DepartmentColor;
use App\Models\RiskFunction;
use App\Models\RiskGrouping;
use App\Models\ThreatGrouping;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Events\DepartmentCreated;
use App\Events\DepartmentUpdated;
use App\Events\DepartementDeleted;
use App\Imports\DepartmentsImport;
use App\Models\Action;
use Illuminate\Support\Str;
use App\Http\Traits\LdapTrait;

use LdapRecord\Container;
use LdapRecord\Connection;
use LdapRecord\Models\Entry;


class DepartmentController extends Controller
{
    public $connection;
    public $container;
    public $CheckConnection = true;
    public $MessageConnection = '';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::with('manager:id,name')->get();
        $users = User::select('id', 'name')->get();
        $departmentColors = DepartmentColor::all();
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
         ['link' => route('admin.hierarchy.index'), 'name' => __('locale.Hierarchy')],
          ['name' => __('locale.Departments')]];

        return view('admin.content.hierarchy.department.index', compact('breadcrumbs', 'users', 'departments', 'departmentColors'));
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
            'name' => ['required', 'max:100', 'unique:departments,name'],
            'code' => ['nullable', 'max:10', 'unique:departments,code'],
            'parent_id' => ['nullable', 'exists:departments,id'], // the parent department for this department
            'manager_id' => ['nullable', 'exists:users,id'], // the manager for department
            'color_id' => ['required', 'exists:department_colors,id'], // the color for department
            'required_num_emplyees' => ['nullable', 'integer'],
            'vision' => ['nullable', 'string'],
            'message' => ['nullable', 'string'],
            'mission' => ['nullable', 'string'],
            'objectives' => ['nullable', 'string'],
            'responsibilities' => ['nullable', 'string']
        ]);


        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('hierarchy.ThereWasAProblemAddingTheDepartment') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();
            try {
                $department = Department::create([
                    'name' => $request->name,
                    'code' => $request->code,
                    'parent_id' => $request->parent_id,
                    'manager_id' => $request->manager_id,
                    'required_num_emplyees' => $request->required_num_emplyees,
                    'color_id' => $request->color_id,
                    'vision' => $request->vision,
                    'message' => $request->message,
                    'mission' => $request->mission,
                    'objectives' => $request->objectives,
                    'responsibilities' => $request->responsibilities,
                ]);

                if (User::whereDoesntHave('department')->where('id', $request->manager_id)->exists()) {
                    User::where('id', $request->manager_id)->update([
                        'department_id' => $department->id
                    ]);
                }

                DB::commit();
                event(new DepartmentCreated($department));
                // dd("feofeffe");

                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('hierarchy.DepartmentWasAddedSuccessfully'),
                );
                $message = __('hierarchy.New Department') . ' "' . ($department->name ??  __('locale.[No Name]')) . '" ' . __('hierarchy.and the manager of the department is') . ' "' . ($department->manager->name ??  __('locale.[No Name]')) . '". ' . __('locale.CreatedBy') . ' "' . auth()->user()->name . '"';
                write_log($department->id, auth()->id(), $message, 'Creating Department ');

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
    public function configure(){

        if (!auth()->user()->hasPermission('department.configuration')) {
            abort(403, 'Unauthorized action.');
        }
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
        ['link' => route('admin.hierarchy.index'), 'name' => __('locale.Hierarchy')],
        ['link' => route('admin.hierarchy.department.index'),'name' => __('locale.Departments')],
        [ 'name' => __('locale.Configure')]
      ];
        $risk_groupings = RiskGrouping::all();
        $risk_functions = RiskFunction::all();
        $threat_groupings = ThreatGrouping::all();

        $addValueTables = [
            // TableName => Language key
            'department_colors' => 'DepartmentColor',
            'locations' => 'SiteLocation',
            'teams' => 'Team',

        ];

        return view('admin.content.configure.Add_Values', compact('breadcrumbs', 'risk_groupings', 'risk_functions', 'threat_groupings', 'addValueTables'));
    }
    public function ajaxGet($id)
    {
        $department = Department::with('color')->find($id);
        if ($department) {

            $data = $department->toArray();
            $data['created_at'] = $department->created_at->format('Y-m-d H:i');
            $data['manager'] = $department->manager->name ?? '';
            $data['parent'] = $department->parentDepartment->name ?? '';
            $data['departments'] = $department->departments()->pluck('name');
            $data['actual_num_emplyees'] = $department->employees()->count();

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
        $department = Department::find($id);
        if ($department) {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'max:100', 'unique:departments,name,' .  $department->id],
                'code' => ['nullable', 'max:10', 'unique:departments,code,' .  $department->id],
                'parent_id' => ['nullable', 'exists:departments,id', 'not_in:' . $id], // the parent department for this department
                'manager_id' => ['nullable', 'exists:users,id'], // the manager for department
                'color_id' => ['required', 'exists:department_colors,id'], // the color for department
                'required_num_emplyees' => ['nullable', 'integer'],
                'vision' => ['nullable', 'string'],
                'message' => ['nullable', 'string'],
                'mission' => ['nullable', 'string'],
                'objectives' => ['nullable', 'string'],
                'responsibilities' => ['nullable', 'string']
            ]);

            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('hierarchy.ThereWasAProblemUpdatingTheDepartment') . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();
                try {
                    // to get the old data of department to use it in log
                    $departmentOldDetAils = Department::find($id);

                    $department->update([
                        'name' => $request->name,
                        'code' => $request->code,
                        'parent_id' => $request->parent_id,
                        'manager_id' => $request->manager_id,
                        'required_num_emplyees' => $request->required_num_emplyees,
                        'color_id' => $request->color_id,
                        'vision' => $request->vision,
                        'message' => $request->message,
                        'mission' => $request->mission,
                        'objectives' => $request->objectives,
                        'responsibilities' => $request->responsibilities,
                    ]);

                    if (User::whereDoesntHave('department')->where('id', $request->manager_id)->exists()) {
                        User::where('id', $request->manager_id)->update([
                            'department_id' => $department->id
                        ]);
                    }

                    DB::commit();
                    event(new DepartmentUpdated($department));

                    $response = array(
                        'status' => true,
                        'reload' => true,
                        'message' => __('hierarchy.DepartmentWasUpdatedSuccessfully'),
                    );
                    $message = __('hierarchy.A Department that name is') . ' "' . ($departmentOldDetAils->name ??  __('locale.[No Name]')) . '"';

                    if ($departmentOldDetAils->name != $department->name) {
                        $message .= ' ' . __('hierarchy.changed to') . ' "' . ($department->name ?? __('locale.[No Name]')) . '"';
                    } else {
                        $message .= ' ' . __('hierarchy.That manager of This department is') . ' "' . ($departmentOldDetAils->manager->name ?? __('locale.[No Name]')) . '"';
                    }

                    if ($departmentOldDetAils->manager_id != $department->manager_id) {
                        $message .= ' ' . __('hierarchy.The manager Changed from') . ' "'  . ($departmentOldDetAils->manager->name ?? __('locale.[No Name]')) . '"';
                    }

                    $message .= ' ' . __('locale.to') . ' "' . ($department->manager->name ?? __('locale.[No Name]')) . '"';
                    $message .= ' ' . __('locale.UpdatedBy') . ' "' . auth()->user()->name . '"';

                    write_log($department->id, auth()->id(), $message, 'Updating Department');

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
        $department = Department::find($id);
        if ($department) {
            DB::beginTransaction();
            try {
                // Check for related data
                $relatedData = $department->hasRelations();

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

                $department->delete();

                DB::commit();
                event(new DepartementDeleted($department));
                $response = array(
                    'status' => true,
                    'message' => __('hierarchy.DepartmentWasDeletedSuccessfully'),
                );
                $message = __('hierarchy.A Department That Name is') . ' "' . ($department->name ?? __('locale.[No Name]')) . '"' . __('hierarchy.and the manager of the department is') . ' "' . ($department->manager->name ?? __('locale.[No Name]')) . '". ' . __('locale.DeletedBy') . ' "' . auth()->user()->name . '"';
                write_log($department->id, auth()->id(), $message, 'Deleting Department');
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                if ($th->errorInfo[0] == 23000) {
                    $errorMessage = __('locale.ThereWasAProblemDeletingTheDepartment') . "<br>" . __('locale.CannotDeleteRecordRelationError');
                } else {
                    $errorMessage = __('locale.ThereWasAProblemDeletingTheDepartment');
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
            'relationships' => ['manager', 'parentDepartment', 'departments'],
            'other_global_filters' => ['required_num_emplyees', 'created_at'],
        ];
        $relationshipsWithColumns = [
            // 'relationshipName:column1,column2,....'
            'manager:id,name',
            'parentDepartment:id,name',
            'departmentsWithoutChilddren:id,parent_id,name'
        ];

        prepareDatatableRequestFields($request, $dataTableDetails, $customFilterFields);
        /* End reading datatable data and custom fields for filtering */

        // Getting total records count with and without apply global search
        [$totalRecords, $totalRecordswithFilter] = getDatatableFilterTotalRecordsCount(Department::class, $dataTableDetails, $customFilterFields);

        $mainTableColumns = getTableColumnsSelect(
            'departments',
            [
                'id',
                'name',
                'code',
                'required_num_emplyees',
                'created_at',
                'parent_id',
                'manager_id'
            ]
        );

        // Getting records with apply global search */
        $departments = getDatatableFilterRecords(
            Department::class,
            $dataTableDetails,
            $customFilterFields,
            $relationshipsWithColumns,
            $mainTableColumns
        );

        // Custom departments response data as needs
        $data_arr = [];
        foreach ($departments as $department) {
            $departmentEmployeesCount = $department->employees()->count();
            $data_arr[] = array(
                'id' =>  $department->id,
                'name' => $department->name,
                'code' => $department->code,
                'parentDepartment' => ($department->parentDepartment) ? ($department->parentDepartment)->name : '',
                'departments' => array_map(function ($element) {
                    return $element['name'];
                }, $department->departmentsWithoutChilddren->toArray()),
                'required_num_emplyees' => $department->required_num_emplyees,
                'actual_num_emplyees' => $departmentEmployeesCount ? $departmentEmployeesCount : '',
                'manager' => ($department->manager) ? $department->manager->name : '',
                'created_at' => $department->created_at->format('Y-m-d H:i'),
                'Actions' => $department->id,
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
            return Excel::download(new DepartmentsExport, 'Departments.xlsx');
        else
            return 'Departments.pdf';
    }

    public function notificationsSettingsDepartement()
    {
        // defining the breadcrumbs that will be shown in page
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
        ['link' => route('admin.hierarchy.index'), 'name' => __('locale.Hierarchy')],
        ['link' => route('admin.hierarchy.department.index'),'name' => __('locale.Departments')],
        ['name' => __('locale.NotificationsSettings')]];

        $users = User::select('id', 'name')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [22, 23, 24, 68, 69,92];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            22 => ['name', 'Manager', 'Parent_Departement'],
            23 => ['name', 'Manager', 'Parent_Departement'],
            24 => ['name', 'Manager', 'Parent_Departement'],
            68 => ['New_Manager', 'Parent_Manager', 'Name_Departement', 'Name_Departement_Belongs', 'Main_Manager'],
            69 => ['New_Manager', 'Parent_Manager', 'Name_Departement', 'Name_Departement_Belongs', 'Main_Manager', 'Employee_Name', 'New_Parent_Manager'],
            92 => ['Departement_Name','Departement_Manager'],
        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [
            22 => ['manager' => __('hierarchy.DepartementManager'), 'parent' => __('hierarchy.DepartementParent')],
            23 => ['manager' => __('hierarchy.DepartementManager'), 'parent' => __('hierarchy.DepartementParent')],
            24 => ['manager' => __('hierarchy.DepartementManager'), 'parent' => __('hierarchy.DepartementParent')],
            68 => ['MainManager' => __('locale.MainManagerDepartement'), 'NewManager' => __('locale.NewManagerDepartement'), 'ParentManager' => __('locale.ParentManagerDepartement')],
            69 => ['MainManager' => __('locale.MainManagerDepartement'), 'NewManager' => __('locale.NewManagerDepartement'), 'ParentManager' => __('locale.ParentManagerDepartement'), 'NewParentManager' => __('locale.NewParentManagerDepartement'), 'Employee' => __('locale.Employee')],
            92 => ['Departement-Owner' => __('locale.DepartementOwner')]
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
            ['link' => route('admin.hierarchy.index'), 'name' => __('locale.Hierarchy')],
            ['link' => route('admin.hierarchy.department.index'), 'name' => __('locale.Departments')],
            ['name' => __('locale.Import')]
        ];

        // Defining database columns with rules and examples
        $databaseColumns = [
            // Column: 'name'
            ['name' => 'name', 'rules' => ['required', 'should be unique in departments table'], 'example' => 'Security Department'],

            // Column: 'code'
            ['name' => 'code', 'rules' => ['Can be empty', 'should be unique in departments table'], 'example' => 'security_department_code'],

            // Column: 'color_id'
            ['name' => 'color_id', 'rules' => ['required', 'string containing color name', 'must exist in department_colors table'], 'example' => 'red'],

            // Column: 'required_num_emplyees'
            ['name' => 'required_num_emplyees', 'rules' => ['Can be empty', 'must be number'], 'example' => '3'],

            // Column: 'parent_id'
            ['name' => 'parent_id', 'rules' => ['can be empty', 'string containing name of parent department', 'must exist in departments table'], 'example' => 'Supervisory Department'],

            // Column: 'manager_id'
            ['name' => 'manager_id', 'rules' => ['can be empty', 'string containing name of department manager', 'must exist in users table'], 'example' => 'Ahmed Muhammed'],

            // Column: 'vision'
            ['name' => 'vision', 'rules' => ['can be empty'], 'example' => 'Department vision'],

            // Column: 'message'
            ['name' => 'message', 'rules' => ['can be empty'], 'example' => 'Department message'],

            // Column: 'mission'
            ['name' => 'mission', 'rules' => ['can be empty'], 'example' => 'Department mission'],

            // Column: 'objectives'
            ['name' => 'objectives', 'rules' => ['can be empty'], 'example' => 'Department objectives'],

            // Column: 'responsibilities'
            ['name' => 'responsibilities', 'rules' => ['can be empty'], 'example' => 'Department responsibilities'],

        ];


        // Define the path for the import data function
        $importDataFunctionPath = route('admin.hierarchy.department.ajax.importData');

        // Return the view with necessary data
        return view('admin.import.index', compact('breadcrumbs', 'databaseColumns', 'importDataFunctionPath'));
    }


    // This function is used to validate the data coming from mapping column and then
    // sending them to "DepartmentsImport" class to import its data
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
                'message' => __('locale.ThereWasAProblemImportingTheItem', ['item' => __('locale.Departments')])
                . "<br>" . __('locale.Validation error'),
            ];
            return response()->json($response, 422);
        } else {
            // Start a database transaction
            DB::beginTransaction();
            try {
                // Mapping columns from the request to database columns
                $columnsMapping = array();
                $columns = ['name', 'code','color_id','parent_id','manager_id','required_num_emplyees','vision','message','mission','objectives','responsibilities'];

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
                (new DepartmentsImport($columnsMapping))->import(request()->file('import_file'));

                // Commit the transaction
                DB::commit();
                $message = __("locale.New Data Imported In Departement") . " \" " . __("locale.CreatedBy") . " \"" . auth()->user()->name . "\".";
                write_log(1, auth()->id(), $message);
                // Prepare success response
                $response = [
                    'status' => true,
                    'reload' => true,
                    'message' => __('locale.ItemWasImportedSuccessfully', ['item' => __('locale.Departments')]),
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
                    'message' => __('locale.ThereWasAProblemImportingTheItem', ['item' => __('locale.Departments')]),
                ];
                return response()->json($response, 502);
            }
        }
    }


    public function openImportLdap()
    {

        // Defining breadcrumbs for the page
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => 'javascript:void(0)', 'name' => __('locale.Hierarchy')],
            ['link' => route('admin.hierarchy.department.index'), 'name' => __('locale.Departments')],
            ['name' => __('department.ldap_import')]
        ];

        try {
            //code...

            $this->LdapConnection();


            $excludedOUs = ['Domain Controllers', 'Microsoft Exchange Security Groups'];

            // Initialize an empty array to store the hierarchical tree
            $tree = [];

            // Query all OUs
            $ous = $this->connection->query()->where('objectClass', '=', 'organizationalUnit')->get();

            // Iterate through OUs and organize them into a tree structure
            foreach ($ous as $ou) {
                $dn = $ou['dn'];

                // Extract the OUs from the DN
                preg_match_all('/OU=([^,]+)/', $dn, $matches);

                if (!empty($matches[1])) {
                    // Reverse to maintain hierarchy from root to leaf
                    $hierarchicalOUs = array_reverse($matches[1]);

                    // Filter out the excluded OUs
                    $hierarchicalOUs = array_filter($hierarchicalOUs, function ($ouName) use ($excludedOUs) {
                        return !in_array($ouName, $excludedOUs);
                    });

                    // Add the OUs to the tree structure only if there are OUs remaining after filtering
                    if (!empty($hierarchicalOUs)) {
                        $currentNode = &$tree;
                        foreach ($hierarchicalOUs as $ouName) {
                            if (!isset($currentNode[$ouName])) {
                                $currentNode[$ouName] = [];
                            }
                            $currentNode = &$currentNode[$ouName];
                        }
                    }
                }
            }
        } catch (\Throwable $th) {
            $ldapMessage = 'Can\'t contact LDAP server';
            return view('admin.content.hierarchy.department.ldap_import', compact('breadcrumbs', 'ldapMessage'));
        }

        return view('admin.content.hierarchy.department.ldap_import', compact('breadcrumbs', 'tree'));
    }

    public function saveImportLdap(Request $request)
    {
        try {
            DB::beginTransaction();

            // First, check if any colors exist in the colors table
            $defaultColor = DepartmentColor::first();

            if (!$defaultColor) {
                return response()->json([
                    'success' => false,
                    'message' => __('locale.NoColorAvailable')
                ], 422);
            }

            $departments = $request->input('departments', []);
            $departmentMap = []; // To track Name to Department ID mapping
            $createdDepartments = []; // Track only newly created departments

            // First pass: Create departments that don't exist yet
            foreach ($departments as $dept) {
                // Check if department already exists
                $existingDepartment = Department::where('name', $dept['name'])->first();

                if (!$existingDepartment) {
                    // Only create if it doesn't exist
                    $department = Department::create([
                        'name' => $dept['name'],
                        'parent_id' => null, // Initialize with null parent
                        'color_id' => $defaultColor->id // Set default color
                    ]);

                    $departmentMap[$dept['name']] = $department->id;
                    $createdDepartments[] = $dept['name']; // Track this as a new department
                } else {
                    // Still track existing departments for hierarchy
                    $departmentMap[$dept['name']] = $existingDepartment->id;
                }
            }

            // Second pass: Set parent relationships ONLY for newly created departments
            foreach ($departments as $dept) {
                // Only process if this is a department we just created
                if (in_array($dept['name'], $createdDepartments)) {
                    // Only set parent_id if parent exists AND is different from the department itself
                    if (!empty($dept['parent']) &&
                        isset($departmentMap[$dept['parent']]) &&
                        $dept['name'] !== $dept['parent']) {

                        Department::where('id', $departmentMap[$dept['name']])
                            ->update(['parent_id' => $departmentMap[$dept['parent']]]);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => __('locale.DepartmentsImportedSuccessfully'),
                'redirect' => route('admin.hierarchy.department.index')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function LdapConnection()
    {
        // Split the DN string by commas
        $base_dn = explode(",", getLdapValue('LDAP_DEFAULT_BASE_DN'));
        $firstDcValue = null;
        foreach ($base_dn as $component) {
            if (strpos($component, "DC=") === 0) {
                // Extract the value of the first "DC" component
                $firstDcValue = substr($component, 3);
                break;
            }
        }

        $connection = new Connection([
            'hosts' => explode(',', getLdapValue('LDAP_DEFAULT_HOSTS')),
            'port' => getLdapValue('LDAP_DEFAULT_PORT'),
            'base_dn' => getLdapValue('LDAP_DEFAULT_BASE_DN'),
            // 'username' =>  getLdapValue('LDAP_DEFAULT_USERNAME'),
            'username' => $firstDcValue . '\\' . getLdapValue('LDAP_DEFAULT_USERNAME'),
            'password' =>  base64_decode(getLdapValue('LDAP_DEFAULT_PASSWORD')),
            // Optional Configuration Options
            'use_ssl'          => (getLdapValue('LDAP_DEFAULT_SSL') == 'true') ? true : false,
            'use_tls'          => (getLdapValue('LDAP_DEFAULT_TLS') == 'true') ? true : false,
            'version'          => (int)getLdapValue('LDAP_DEFAULT_VSERSION'),
            'timeout'          => (int)getLdapValue('LDAP_DEFAULT_TIMEOUT'),
            'follow_referrals' => (getLdapValue('LDAP_DEFAULT_Follow') == 'true') ? true : false,
        ]);

        try {
            $connection->connect();
            $container = Container::addConnection($connection);
            $this->connection = $connection;
            $this->container = $container;
        } catch (\LdapRecord\Auth\BindException $e) {
        }
    }

}
