<?php

namespace App\Http\Controllers\admin\third_party;

use App\Http\Controllers\Controller;
use App\Models\ThirdPartyRequestRecipient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Department;

class ThirdPartyConfigrationController extends Controller
{
    // dispalying content of configration based on third_party partitions (Profiles, Requests, etc....)
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $requestRecipients = ThirdPartyRequestRecipient::join('users', 'users.id', '=', 'third_party_request_recipients.user_id')
                ->select(
                    'third_party_request_recipients.type as type',
                    'users.name as user_name',
                    'users.id as user_id',
                )
                ->first();

            $partition = $request->partition;

            switch ($partition) {
                case 'profiles':
                    $addValueTables = [
                        // TableName => Language key
                        'third_party_classifications' => 'ThirdPartyClassifications',
                    ];
                    $breadcrumbName = __('locale.ThirdPartyProfiles');
                    break;

                case 'requests':
                    $addValueTables = [
                        // TableName => Language key
                        'third_party_services' => 'ThirdPartyServices',
                        'third_party_evaluations' => 'ThirdPartyEvaluation',
                        'third_party_request_recipients' => "ThirdPartyRequestRecipients"
                    ];
                    $breadcrumbName = __('locale.ThirdPartyRequests');
                    break;

                default:
                    $addValueTables = [
                        // TableName => Language key
                    ];
            }

            // dd($addValueTables);
            // return view('admin.content.third_party.configrations', compact('addValueTables', 'requestRecipients'));


            $breadcrumbs = [
                ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
                ['name' => __('locale.ThirdPartyManagment')],
                ['name' => $breadcrumbName],
                ['name' => __('third_party.Configration')],
            ];
            // Render and return the full HTML view
            return response(view('admin.content.third_party.configrations', compact('breadcrumbs', 'addValueTables', 'requestRecipients')));
        } else {
            abort(403);
        }
    }

    public function fetchRecordsByTable(Request $request)
    {
        if ($request->ajax()) {

            // dd($request->all());
            if ($request->table_name == 'third_party_request_recipients') {

                if ($request->type_of_users == 'department_manager') {
                    $users = Department::query()->with('manager:id,name')->get()->pluck('manager.name', 'manager.id');
                } else {
                    $allUsers = User::query()->pluck('name', 'id')->toArray();
                    $departmentManagers = Department::query()
                        ->with('manager:id,name')
                        ->get()
                        ->pluck('manager.name', 'manager.id')
                        ->toArray();

                    $users = array_diff_key($allUsers, $departmentManagers);
                }
                $model = 'App\\Models\\' . Str::studly(Str::singular($request->table_name));

                $results = $model::all();

                return response()->json(['users' => $users, 'request_recipients' => $results]);
            } else {
                // Dynamically determine the model class name from the table name
                // 1. Convert the table name to singular (e.g., 'users' to 'user')
                // 2. Convert the singular name to StudlyCase (e.g., 'user' to 'User')
                // 3. Prefix with the full namespace (e.g., 'App\Models\User')
                $model = 'App\\Models\\' . Str::studly(Str::singular($request->table_name));

                // Retrieve all records from the specified model
                $results = $model::all();
                // Return the results as a JSON response (automatic in AJAX requests)
                return $results;
            }
        } else {
            // If the request is not AJAX, return a 404 error
            abort(404);
        }
    }

    public function saveRecordsByTable(Request $request)
    {
        if ($request->ajax()) {
            $tableName = $request->table_name;
            $value = $request->record_value;

            // Dynamically determine the model class name from the table name
            // 1. Convert the table name to singular (e.g., 'users' to 'user')
            // 2. Convert the singular name to StudlyCase (e.g., 'user' to 'User')
            // 3. Prefix with the full namespace (e.g., 'App\Models\User')
            $model = 'App\\Models\\' . Str::studly(Str::singular($tableName));

            if ($request->table_name == 'third_party_request_recipients') {
                $model::truncate();

                $userType = $request->type_of_users;
                $data = [
                    'user_id' => $value,
                    'type' => $userType
                ];

                $model::create($data);
            } else {
                $data = [
                    'name' => $value
                ];
                $model::create($data);
            }

            return response()->json(['message' => 'Record created successfully'], 200);
        }
    }

    public function updateRecordsByTable(Request $request)
    {
        if ($request->ajax()) {

            $tableName = $request->table_name;
            $recordId = $request->record_id;
            $recordValue = $request->record_value;

            // Dynamically determine the model class name from the table name
            // 1. Convert the table name to singular (e.g., 'users' to 'user')
            // 2. Convert the singular name to StudlyCase (e.g., 'user' to 'User')
            // 3. Prefix with the full namespace (e.g., 'App\Models\User')
            $model = 'App\\Models\\' . Str::studly(Str::singular($tableName));

            $data = [
                'name' => $recordValue
            ];

            // dd($data);

            $model::where('id', $recordId)->update($data);

            return response()->json(['message' => 'Selected value updated successfully'], 200);
        }
    }

    public function deleteRecordsByTable(Request $request)
    {
        if ($request->ajax()) {

            $tableName = $request->table_name;
            $recordId = $request->record_id;

            // Dynamically determine the model class name from the table name
            // 1. Convert the table name to singular (e.g., 'users' to 'user')
            // 2. Convert the singular name to StudlyCase (e.g., 'user' to 'User')
            // 3. Prefix with the full namespace (e.g., 'App\Models\User')
            $model = 'App\\Models\\' . Str::studly(Str::singular($tableName));

            $model::where('id', $recordId)->delete();

            return response()->json(['message' => 'Selected value deleted successfully'], 200);
        }
    }
}
