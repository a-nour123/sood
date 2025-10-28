<?php

namespace App\Http\Controllers\admin\hierarchy;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Events\DepartementMovingToAnother;
use App\Events\DepartementMovingEmployee;
use App\Models\Action;

class HierarchyController extends Controller
{
    /**
     * Display a tree chart of departments.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Hierarchy')],
            ['name' => __('locale.Organization Tree')]
        ];
        $departments = Department::with('manager')->with('employees')->with('color')->select('id', 'parent_id AS pid', 'name AS ' . __('locale.Name'), 'color_id', 'manager_id', 'required_num_emplyees', 'vision', 'message', 'mission', 'objectives', 'responsibilities')->get()->toArray();
        // dd($departments);
        // $departments = $this->generateDepartmentTree($departments);
        // dd($departments);
        foreach ($departments as $index => $department) {
            // remove charcters more than 25 (ellipsis)
            $department['ellipsizedName'] = $department[__('locale.Name')];
            mb_strlen($department['ellipsizedName']) > 25 ? $department['ellipsizedName'] = mb_substr($department['ellipsizedName'], 0, 25, 'utf-8') . '...' : '';
            $department[__('locale.Manager')] = $department['manager']['name'] ?? '';
            $department['ellipsizedManager'] = $department[__('locale.Manager')];

            // remove charcters more than 30 (ellipsis)
            mb_strlen($department['ellipsizedManager']) > 30 ? $department['ellipsizedManager'] = mb_substr($department['ellipsizedManager'], 0, 30, 'utf-8') . '...' : '';

            $department[__('locale.RequiredNumberOfEmplyees')] = $department['required_num_emplyees'];
            $department[__('locale.ActualNumberOfEmplyees')] = count($department['employees']) ? count($department['employees']) : '';
            if (isset($department['color']['value']) && !is_null($department['color']['value'])) {
                $department['tags'] = ['color_' . substr($department['color']['value'], 1)];
            } else {
                $department['tags'] = ['color_default'];  // Or set a default value
            }
            // $department[__('locale.vision')] = $this->formatQuillEditor($department['vision']);
            // $department[__('locale.message')] = $this->formatQuillEditor($department['message']);
            // $department[__('locale.mission')] = $this->formatQuillEditor($department['mission']);
            // $department[__('locale.objectives')] = $this->formatQuillEditor($department['objectives']);
            // $department[__('locale.responsibilities')] = $this->formatQuillEditor($department['responsibilities']);

            if (isset($department['color']['value']) && !is_null($department['color']['value'])) {
                $department['department_color'] = $department['color']['value'];
            } else {
                $department['department_color'] = '#000000'; // Default color, or handle the case as needed
            }

            unset($department['color_id']);
            unset($department['manager_id']);
            unset($department['manager']);
            unset($department['employees']);
            unset($department['required_num_emplyees']);
            unset($department['color']);
            unset($department['vision']);
            unset($department['message']);
            unset($department['mission']);
            unset($department['objectives']);
            unset($department['responsibilities']);
            // dd($department['ellipsizedName']);
            $departments[$index] = $department;
        }

        // return ($departments);

        $data = json_encode($departments);
        return view('admin.content.hierarchy.index', compact('breadcrumbs', 'departments', 'data'));
    }

    /**
     * Return a listing of the resource after some manipulation.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxGetList()
    {
        $structuredDepartments = [];

        $departments = Department::with('manager')->with('color')->where('parent_id', null)->select('id', 'name', 'color_id', 'manager_id')->get();
        foreach ($departments as $department) {
            $departmentEmployees = $this->getDepartmentEmployees($department);
            $childDepartments = $this->getChildDepartmentData($department);

            $children = $departmentEmployees;
            $children = array_merge($children, $childDepartments);
            array_push(
                $structuredDepartments,
                (object)[
                    'id' =>  'D' . ($department->id),
                    'text' => $department->name,
                    'type' => 'main',
                    'state' => (object) ["opened" => true],
                    "li_attr" =>  (object)["style" => "color: " . $department->color->value . " !important"],
                    "a_attr" =>  (object)["style" => "color: " . $department->color->value . " !important"],
                    'children' => $children,
                ]
            );
        }

        return ($structuredDepartments);
    }

    public function getChildDepartmentData($_department)
    {
        $structuredDepartments = [];

        if ($_department)
            $_childDepartments = $_department->departments()->select('id', 'name', 'color_id', 'manager_id')->get();
        foreach ($_childDepartments as $department) {
            $structuredDepartment = [];

            $departmentEmployees = $this->getDepartmentEmployees($department);

            $childDepartments = $this->getChildDepartmentData($department);

            $structuredDepartment['id'] =  'D' . ($department->id);
            $structuredDepartment['text'] = $department->name;
            $structuredDepartment['type'] = $childDepartments ? 'sector' : 'department';
            $structuredDepartment['state'] = (object) ["opened" => false];
            $structuredDepartment['li_attr'] = (object)["style" => "color: " . $department?->color?->value . " !important"];
            $structuredDepartment['a_attr'] = (object)["style" => "color: " . $department?->color?->value . " !important"];

            $children = $departmentEmployees;
            $children = array_merge($children, $childDepartments);
            $structuredDepartment['children'] =  $children;

            array_push(
                $structuredDepartments,
                $structuredDepartment
            );
        }

        return $structuredDepartments;
    }

    public function getDepartmentEmployees($department)
    {
        $departmentEmployees = $department->manager()->select('id', 'name')->get();
        $departmentEmployees = $departmentEmployees->merge($departmentEmployees = $department->employees()->select('id', 'name')->get()); // Add manager if department_id is not this department_id
        $departmentEmployees = $departmentEmployees->unique();

        $_structuredDepartmentEmployees = [];
        foreach ($departmentEmployees as $departmentEmployee) {
            if ($department->manager_id == $departmentEmployee->id) {
                $addedText = ' (' . __('hierarchy.DepartmentManager') . ')';
                $status = (object) ["opened" => true, "disabled" => true];
                $type = 'manager';
            } else if ($departmentEmployee->managees()->count()) {
                $addedText = ' (' . __('hierarchy.Manager') . ')';
                $status = (object) ["opened" => true, "disabled" => true];
                $type = 'manager';
            } else {
                $addedText = ' (' . __('locale.employee') . ')';
                $status = (object) ["opened" => true];
                $type = 'employee';
            }

            $departmentrEmployee = null;
            if ($departmentEmployee) {
                $id = ($type == 'manager') ? uniqid() : $departmentEmployee->id; // for repeated manager id
                $departmentrEmployee = [
                    'id' => 'E' . ($id),
                    'text' => $departmentEmployee->name . $addedText,
                    'type' => $type,
                    'state' => $status,
                ];
            }

            array_push($_structuredDepartmentEmployees, $departmentrEmployee);
        }
        // Log::debug(json_encode($_structuredDepartmentEmployees, JSON_PRETTY_PRINT));
        // die();
        //
        return $_structuredDepartmentEmployees;
    }

    public function dragAndDrop(Request $request)
    {
        $requestValid = true;
        $data = array(
            'id' => '',
            'type' => '',
            'oldParentId' => '',
            'oldParentType' => '',
            'newParentId' => '',
            'newParentType' => '',
        );


        // dd(
        //     $request->all(),
        //     !is_null($request->newParentId),
        //     !is_null($request->oldParentId)
        // );

        // Get main record item data
        if (preg_match('{(D|E)(\d+)}', $request->id, $matches)) {
            $data['type'] = $matches[1];
            $data['id'] = $matches[2];
        } else {
            $requestValid = false;
        }

        // Get old parent record item data
        if (preg_match('{(D|E)(\d+)}', $request->oldParentId, $matches)) {
            $data['oldParentType'] = $matches[1];
            $data['oldParentId'] = $matches[2];
        } else if (!is_null($request->oldParentId)) {
            $requestValid = false;
        }

        // Get new parent record item data
        if (preg_match('{(D|E)(\d+)}', $request->newParentId, $matches)) {
            $data['newParentType'] = $matches[1];
            $data['newParentId'] = $matches[2];
        } else if (!is_null($request->newParentId)) {
            $requestValid = false;
        }

        if (!$requestValid) {
            $response = array(
                'status' => false,
                'message' => __('locale.InvalidData'),
            );
            return response()->json($response, 422);
        }
        /** Probabilities
         * [Drag department]
         * 1. Move to same department (Alert Not allowed)
         * 2. Move to another department (Alert Success)
         *
         * [Drag employee]
         * 1. Move to same department (Alert Not allowed)
         * 2. Move to another department (Alert Success)
         *
         *  */

        //  Move to same department [either department or employee]
        if ($data['oldParentType'] == $data['newParentType'] && $data['oldParentId'] == $data['newParentId']) {
            if ($data['type'] == 'D') {
                $errorMessage = __('hierarchy.DepartmentParenIsSameDepartment');
            } else if ($data['type'] == 'E') {
                $errorMessage = __('hierarchy.EmployeeAlreadyInSameDepartment');
            }

            $response = array(
                'status' => false,
                'message' => $errorMessage,
            );
            return response()->json($response, 422);
        } else { // Move to another type

            // Move to to be under another employee
            if ($data['newParentType'] == 'E') {
                $response = array(
                    'status' => false,
                    'message' => __('hierarchy.MovingOnlyEmployeeUnderDepartment'),
                );
                return response()->json($response, 422);
            }

            // Move to another department
            if ($data['type'] == 'D') { // Move department to another department (Alert Success)
                $requestDataToValid = [
                    'parent department' =>  $data['newParentId'],
                    'department' =>  $data['id'],
                ];

                $validator = Validator::make($requestDataToValid, [
                    'parent department' =>  ['exists:departments,id'],
                    'department' =>  ['exists:departments,id'],
                ]);

                // Check if there is any validation errors
                if ($validator->fails()) {
                    $errors = $validator->errors()->toArray();

                    $response = array(
                        'status' => false,
                        'errors' => $errors,
                        'message' => '<b>' . __('locale.ThereWasAProblemUpdatingTheDepartment') . "</b><br>" . (implode("<br>", $validator->messages()->all())),
                    );
                    return response()->json($response, 422);
                } else {
                    DB::beginTransaction();
                    try {
                        $newDepartment = Department::find($data['newParentId']);
                        // to get the data of already departement
                        $department = Department::find($data['id']);

                        $department->update([
                            'parent_id' => $newDepartment->id ?? null
                        ]);

                        $newDepartmentName = $newDepartment->name ?? __('locale.Root');

                        event(new DepartementMovingToAnother($newDepartment, $department));

                        DB::commit();

                        $response = array(
                            'status' => true,
                            'message' => __('hierarchy.DepartmentParentChanged', ['departmentName' => $department->name, 'parentDepartmentName' => $newDepartmentName]),
                        );
                        $message = trans('hierarchy.A Department') . ' "' . ($department->name ?? '[No Department]') . '" ' . trans('hierarchy.Moved To Another Department') . ' "' . ($newDepartment->name ?? '[No New Department]') . '" by "' . (auth()->user()->name) . '".';
                        write_log($department->id, auth()->id(), $message, 'Moving Departement');
                        return response()->json($response, 200);
                    } catch (\Throwable $th) {
                        DB::rollBack();
                        return $th->getMessage();
                    }
                }
            } else if ($data['type'] == 'E') { // Move employee to another department (Alert Success)
                $requestDataToValid = [
                    'department' =>  $data['newParentId'],
                    'user' =>  $data['id'],
                ];


                $validator = Validator::make($requestDataToValid, [
                    'department' =>  ['required', 'exists:departments,id'],
                    'user' =>  ['required', 'exists:users,id'],
                ]);
                // dd($validator->errors());

                // Check if there is any validation errors
                if ($validator->fails()) {
                    $errors = $validator->errors()->toArray();

                    $response = array(
                        'status' => false,
                        'errors' => $errors,
                        'message' => '<b>' . __('locale.ThereWasAProblemUpdatingTheEmployee') . "</b><br>" . (implode("<br>", $validator->messages()->all())),
                    );
                    return response()->json($response, 422);
                } else {
                    DB::beginTransaction();
                    try {
                        $department = Department::find($data['newParentId']);
                        $userbeforeUpdate = User::find($data['id']);
                        $user = User::find($data['id']);

                        $user->update([
                            'department_id' => $department->id
                        ]);

                        DB::commit();
                        event(new DepartementMovingEmployee($department, $userbeforeUpdate, $user));

                        $response = array(
                            'status' => true,
                            'message' => __('locale.EmployeeDepartmentChanged', ['employeeDepartmentName' => $department->name, 'employeeName' => $user->name]),
                        );
                        $message = __('hierarchy.An Employee') . ' "' . ($user->name ?? __('locale.[No Name]')) . '" ' . __("hierarchy.Moved To Another Department") . ' "' . ($department->name ?? __('locale.[No Name]')) . '" by "' . (auth()->user()->name) . '".';
                        write_log($user->id, auth()->id(), $message, 'Moving Employee');
                        return response()->json($response, 200);
                    } catch (\Throwable $th) {
                        DB::rollBack();
                        return $th->getMessage();
                    }
                }
            }
        }
    }

    public function getOrgChart()
    {
        $departments = Department::with('manager')->with('employees')->with('color')->select('id', 'parent_id AS pid', 'name AS ' . __('locale.Name'), 'color_id', 'manager_id', 'required_num_emplyees', 'vision', 'message', 'mission', 'objectives', 'responsibilities')->get()->toArray();
        // $departments = $this->generateDepartmentTree($departments);
        foreach ($departments as $index => $department) {
            // remove charcters more than 25 (ellipsis)
            $department['Name'] = $department[__('locale.Name')];
            mb_strlen($department['Name']) > 25 ? $department['Name'] = mb_substr($department['Name'], 0, 25, 'utf-8') . '...' : '';
            $department[__('locale.Manager')] = $department['manager']['name'] ?? '';
            $department['Manager'] = $department[__('locale.Manager')];

            // remove charcters more than 30 (ellipsis)
            mb_strlen($department['Manager']) > 30 ? $department['Manager'] = mb_substr($department['Manager'], 0, 30, 'utf-8') . '...' : '';

            $department['RequiredNumber'] = $department['required_num_emplyees'];
            $department['ActualNumber'] = count($department['employees']) ? count($department['employees']) : '';
            if (isset($department['color']['value']) && !is_null($department['color']['value'])) {
                $department['tags'] = ['color_' . substr($department['color']['value'], 1)];
            } else {
                $department['tags'] = ['color_default'];  // Or set a default value
            }
            // $department[__('locale.vision')] = $this->formatQuillEditor($department['vision']);
            // $department[__('locale.message')] = $this->formatQuillEditor($department['message']);
            // $department[__('locale.mission')] = $this->formatQuillEditor($department['mission']);
            // $department[__('locale.objectives')] = $this->formatQuillEditor($department['objectives']);
            // $department[__('locale.responsibilities')] = $this->formatQuillEditor($department['responsibilities']);

            $department[__('locale.DepartmentColor')] = $department['color']['value'] ?? null;

            unset($department['color_id']);
            unset($department['manager_id']);
            unset($department['manager']);
            unset($department['employees']);
            unset($department['required_num_emplyees']);
            unset($department['color']);
            unset($department['vision']);
            unset($department['message']);
            unset($department['mission']);
            unset($department['objectives']);
            unset($department['responsibilities']);
            // dump($department);
            $departments[$index] = $department;
        }

        // dd($departments);

        return ($departments);
    }
    public function orgChart()
    {
        $departments = Department::with('manager')->with('employees')->with('color')->select('id', 'parent_id AS pid', 'name AS ' . __('locale.Name'), 'color_id', 'manager_id', 'required_num_emplyees', 'vision', 'message', 'mission', 'objectives', 'responsibilities')->get()->toArray();
        // dd($departments);
        // $departments = $this->generateDepartmentTree($departments);
        // dd($departments);
        foreach ($departments as $index => $department) {
            // remove charcters more than 25 (ellipsis)
            $department['ellipsizedName'] = $department[__('locale.Name')];
            mb_strlen($department['ellipsizedName']) > 25 ? $department['ellipsizedName'] = mb_substr($department['ellipsizedName'], 0, 25, 'utf-8') . '...' : '';
            $department[__('locale.Manager')] = $department['manager']['name'] ?? '';
            $department['ellipsizedManager'] = $department[__('locale.Manager')];

            // remove charcters more than 30 (ellipsis)
            mb_strlen($department['ellipsizedManager']) > 30 ? $department['ellipsizedManager'] = mb_substr($department['ellipsizedManager'], 0, 30, 'utf-8') . '...' : '';

            $department[__('locale.RequiredNumberOfEmplyees')] = $department['required_num_emplyees'];
            $department[__('locale.ActualNumberOfEmplyees')] = count($department['employees']) ? count($department['employees']) : '';
            if (isset($department['color']['value']) && !is_null($department['color']['value'])) {
                $department['tags'] = ['color_' . substr($department['color']['value'], 1)];
            } else {
                $department['tags'] = ['color_default'];  // Or set a default value
            }

            // $department[__('locale.vision')] = $this->formatQuillEditor($department['vision']);
            // $department[__('locale.message')] = $this->formatQuillEditor($department['message']);
            // $department[__('locale.mission')] = $this->formatQuillEditor($department['mission']);
            // $department[__('locale.objectives')] = $this->formatQuillEditor($department['objectives']);
            // $department[__('locale.responsibilities')] = $this->formatQuillEditor($department['responsibilities']);

            $department['department_color'] = $department['color']['value'];

            unset($department['color_id']);
            unset($department['manager_id']);
            unset($department['manager']);
            unset($department['employees']);
            unset($department['required_num_emplyees']);
            unset($department['color']);
            unset($department['vision']);
            unset($department['message']);
            unset($department['mission']);
            unset($department['objectives']);
            unset($department['responsibilities']);
            // dd($department['ellipsizedName']);
            $departments[$index] = $department;
        }

        // return ($departments);

        $data = json_encode($departments);


        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['name' => __('locale.Organization Chart')]];

        return view('admin.content.hierarchy.org_chart', compact('departments', 'breadcrumbs', 'data'));
    }

    function formatQuillEditor($text)
    {
        $formattedText = '';
        $text = json_decode($text, true);
        foreach ($text['ops'] as $key => $element) {
            if (empty($element['insert']['image'])) {
                $result = $element['insert'];
                if (!empty($element['attributes'])) {
                    foreach ($element['attributes'] as $key => $attribute) {
                        $result = $this->operate($result, $key, $attribute);
                    }
                }
            }
            $formattedText = $formattedText . $result . '\n';
        }
        return nl2br($formattedText);
    }

    function operate($text, $ops, $attribute)
    {
        $operatedText = null;
        switch ($ops) {
            case 'bold':
                $operatedText = '<strong>' . $text . '</strong>';
                break;
            case 'italic':
                $operatedText = '<i>' . $text . '</i>';
                break;
            case 'strike':
                $operatedText = '<s>' . $text . '</s>';
                break;
            case 'underline':
                $operatedText = '<u>' . $text . '</u>';
                break;
            case 'link':
                $operatedText = '<a href="' . $attribute . '" target="blank">' . $text . '</a>';
                break;
            default:
                $operatedText = $text;
        }
        return $operatedText;
    }
    public function notificationsSettingsMovingDepartement()
    {
        // defining the breadcrumbs that will be shown in page

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.hierarchy.index'), 'name' => __('locale.Hierarchy')],
            ['name' => __('locale.NotificationsSettings')]
        ];

        $users = User::select('id', 'name')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [68, 69];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            68 => ['New_Manager', 'Parent_Manager', 'Name_Departement', 'Name_Departement_Belongs', 'Main_Manager'],
            69 => ['New_Manager', 'Parent_Manager', 'Name_Departement', 'Name_Departement_Belongs', 'Main_Manager', 'Employee_Name', 'New_Parent_Manager'],
        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [
            68 => ['MainManager' => __('locale.MainManagerDepartement'), 'NewManager' => __('locale.NewManagerDepartement'), 'ParentManager' => __('locale.ParentManagerDepartement')],
            69 => ['MainManager' => __('locale.MainManagerDepartement'), 'NewManager' => __('locale.NewManagerDepartement'), 'ParentManager' => __('locale.ParentManagerDepartement'), 'NewParentManager' => __('locale.NewParentManagerDepartement'), 'Employee' => __('locale.Employee')],
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