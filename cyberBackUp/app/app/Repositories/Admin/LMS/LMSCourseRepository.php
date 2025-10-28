<?php


namespace App\Repositories\Admin\LMS;

use App\Helpers\Helper;
use App\Interfaces\Admin\LMS\LMSCourseInterface;
use App\Interfaces\Admin\Phishing\PhishingDomainsInterface;
use App\Models\Action;
use App\Models\FrameworkControl;
use App\Models\LMSCourse;
use App\Models\LMSLevel;
use App\Models\LMSTrainingModule;
use App\Models\PhishingDomains;
use App\Models\Role;
use App\Models\User;
use App\Traits\UpoladFileTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class LMSCourseRepository implements LMSCourseInterface
{
    use UpoladFileTrait;
    public function index()
    {
        if (!auth()->user()->hasPermission('courses.list')) {
            abort(403, 'Unauthorized action.');
        }

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('lms.lms_managment')],
            ['name' => __('lms.Courses')]
        ];

        $compliances = FrameworkControl::all();
        $courses = LMSCourse::withoutTrashed()
            ->orderBy('created_at','desc')
            ->withCount('levels','training_modules')
            ->paginate(10);
        return view('admin.content.LMS.courses.list', get_defined_vars());
    }
    public function store(Request $request)
    {
        try {
            // dd($request->all());

            $validator = Validator::make($request->all(), [
                'title' => 'required|unique:l_m_s_courses,title',
                'description' => 'required',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return response()->json(['status' => false,'errors' => $errors, 'message' => __('locale.ThereWasAProblemAddingCourse') . "<br>" . __('locale.Validation error')], 422);
            }

            $path = null;
            if($request->hasFile('image')) {
                $file = $request->file('image');
                // $path = $this->storeFile($file, 'LMS/Courses');
                $path = $this->storeFileInStorage($file, 'public/LMS/Courses');
            }
            LMSCourse::create([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $path ?? 'no path !',
            ]);
            return response()->json(['status' => true,'message' => 'Course is Added Successfully'], 200);
        } catch (\Exception $ex) {
            return response()->json($ex->getMessage());
            return response()->json(['status' => false,'message' => __('locale.Error')], 502);
        }
    }

    public function show($id,Request $request)
    {
        try {
            $course = LMSCourse::with('levels.training_modules')->find($id);
            // $course = LMSCourse::with('levels.training_modules','questions','statements','training_modules')->find($id);
            $course->image =  asset('storage/'.$course->image);
            return response()->json(['course' => $course]);
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $Course = LMSCourse::find($id);
            $validator = Validator::make($request->all(), [
                'title' => ['required',Rule::unique('l_m_s_courses','title')->ignore($id),'min:5'],
                'description' => 'required|min:5',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return response()->json(['status' => false,'errors' => $errors, 'message' => __('locale.ThereWasAProblemAddingCourse') . "<br>" . __('locale.Validation error')], 422);
            }

            $path =  $Course->image;
            if($request->hasFile('image')) {
                $file = $request->file('image');
                // $path = $this->storeFile($file, 'LMS/Courses');
                $path = $this->storeFileInStorage($file, 'public/LMS/Courses');
            }
            $Course->update([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $path,
            ]);
            return response()->json(['status' => true,'message' => 'Course is Updated Successfully'], 200);
        } catch (\Exception $ex) {
            // return response()->json($ex->getMessage());
            return response()->json(['status' => false,'message' => __('locale.Error')], 502);
        }
    }
    public function trash($course)
    {
        try {

            $course = LMSCourse::findOrFail($course);
            $course->update(['deleted_at' => now()]);
            return response()->json(['status' => true,'message' => __('phishing.CourseWasDeletedSuccessfully')], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false,'message' => __('locale.Error')], 502);
        }
    }

    public function restore($id,Request $request)
    {
        try {
            $domain = PhishingDomains::onlyTrashed()->findOrFail($id);
            $domain->restore();
            return response()->json(['status' => true,'message' => __('phishing.domainRestoreSuccessfully')], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false,'message' => __('locale.Error')], 502);
        }
    }
    public function delete($id)
    {
        try {
            $course = LMSCourse::findOrFail($id);
            if($course->levels()->exists()){
                return response()->json(['status' => false,'message' => __('lms.CourseCantBeDeletedItContainLevels')], 200);
            }
            $course->forceDelete();
            return response()->json(['status' => true,'message' => __('lms.CourseWasDeletedSuccessfully')], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false,'message' => __('locale.Error')], 502);
        }
    }
    public function getProfiles($id)
    {
        $domain = PhishingDomains::with('profiles')->findOrFail($id);
        $senderProfiles = $domain->profiles;
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('Sender Profiles')]
        ];
        return view('admin.content.phishing.senderProfile.domain-profiles', get_defined_vars());
        // return view('admin.content.phishing.senderProfile.list', get_defined_vars());
    }

    public function getProfilesDataTable($id)
    {
        $domain = PhishingDomains::with('profiles')->findOrFail($id);
        $senderProfiles = $domain->profiles;
        return DataTables::of($senderProfiles)->setRowId(function ($row) {
            return $row->id;
        })->addColumn('actions', function ($row) {
                $data = '<div class="regulator-item">';
                $data = $data.'<button class="btn btn-secondary show-frame trash-domain" type="button" data-bs-toggle="modal"
                    data-id="'.$row->id.'" onclick="ShowModalRestoreDomain('.$row->id.')" data-name="'.$row->name.'">
                                               <i class="fa-solid fa-undo"></i>
                </button>';

                $data = $data.' <button class="btn btn-secondary show-frame trash-domain" type="button" data-bs-toggle="modal"
                    data-id="'.$row->id.'" onclick="ShowModalDeleteDomain('.$row->id.')" data-name="'.$row->name.'">
                                                <i class="fa-solid fa-trash"></i>
                </button>';

                $data = $data.'</div>';

            return $data;
        })->editColumn('created_at', function ($row) {
            $data = $row->created_at;

            return Carbon::parse($data)->format('Y-m-d g:ia');
        })->rawColumns(['actions'])
        ->make(true);
    }

    public function getArchivedDomains()
    {
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('lms.lms_managment')],
            ['name' => __('lms.Courses_archive')]
        ];



        $archived_domains = PhishingDomains::onlyTrashed()->get();
        return view('admin.content.LMS.courses.archived', get_defined_vars());
    }

    public function getCourseLevels(Request $request)
    {
        try {

            if($request->course_id){
                $Levels = LMSLevel::where('course_id',$request->course_id)->get();
            }else{
                $Levels = LMSLevel::get();
            }
            return response()->json(['status' => true,'Levels' => $Levels], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false,'message' =>$e->getMessage()], 502);
        }
    }

    public function courseNotificationsSettings()
    {
        // defining the breadcrumbs that will be shown in page
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.lms.courses.index'), 'name' => __('lms.Courses')], // give it your own route
            ['name' => __('locale.NotificationsSettings')]
        ];
        $users = User::where('enabled', true)->with('manager:id,name,manager_id')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [125,126,127,128];   // defining ids of actions modules in ActionSeeder (system notification part)
        $moduleActionsIdsAutoNotify = [129];  // defining ids of actions modules (auto notify part)

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            125 => ['Title', 'Description'], // add new course
            126 => ['Title', 'Description'], // update existing course
            127 => ['Name', 'Score', 'Order', 'Completion_time','Course_name','Course_level'], // add new training module
            128 => ['Name', 'Score', 'Order', 'Completion_time','Course_name','Course_level'], // edit existing training module
        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [
            125 => [
                'Title' => __('lms.Course Title'),
                'Description' => __('lms.Course Description'),
            ],
            126 => [
                'Title' => __('lms.Course Title'),
                'Description' => __('lms.Course Description'),
            ],
            127 => [
                'Name' => __('lms.Training Name'),
                'Score' => __('lms.Passing Score'),
                'Order' => __('lms.Module Order'),
                'Completion_time' => __('lms.Completion Time'),
                'Course_name' => __('lms.Course Name'),
                'Course_level' => __('lms.Course Level'),
            ],

            128 => [
                'Name' => __('lms.Training Name'),
                'Score' => __('lms.Passing Score'),
                'Order' => __('lms.Module Order'),
                'Completion_time' => __('lms.Completion Time'),
                'Course_name' => __('lms.Course Name'),
                'Course_level' => __('lms.Course Level'),
            ],
        ];


        /* static part below you will change nothing in it  */

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
        return view('admin.content.LMS.courses.notifications-settings.index', compact('breadcrumbs', 'users', 'actionsWithSettings', 'actionsVariables', 'actionsRoles', 'moduleActionsIdsAutoNotify', 'actionsWithSettingsAuto'));
    }
}
