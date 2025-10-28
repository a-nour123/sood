<?php


namespace App\Repositories\Admin\LMS;

use App\Interfaces\Admin\LMS\LMSLevelInterface;
use App\Models\LMSCourse;
use App\Models\LMSLevel;
use App\Models\LMSTrainingModule;
use App\Models\PhishingDomains;
use App\Traits\UpoladFileTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class LMSLevelRepository implements LMSLevelInterface
{
    use UpoladFileTrait;
    public function index()
    {

    }
    public function store(Request $request,$id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => ['required','min:5',Rule::unique('l_m_s_levels', 'title')->where('course_id', $id)],
                // 'title' => 'required|min:5|unique:l_m_s_levels,title,except,id',
                'order' => 'required|integer|min:1',
            ]);

            $existingOrder = LmsLevel::where('course_id', $id)
                             ->where('order', $request->order)
                             ->exists();

            if ($existingOrder) {
                return response()->json([
                    'status' => false,
                    'errors' => ['order' => ['The specified order already exists for this course. Please enter a different order.']],
                    'message' => __('locale.ThereWasAProblemAddingCourse') . "<br>" . __('locale.Validation error')
                ], 422);
            }

            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return response()->json(['status' => false,'errors' => $errors, 'message' => __('locale.ThereWasAProblemAddingCourse') . "<br>" . __('locale.Validation error')], 422);
            }

            LMSLevel::create([
                'title' => $request->title,
                'order' => $request->order,
                'course_id' => $id,
            ]);

            $course = LMSCourse::with('levels.training_modules')->find($id);
            return response()->json(['status' => true,'message' => 'Level is Added Successfully','course' => $course], 200);
        } catch (\Exception $ex) {
            return response()->json(['status' => false,'message' => __('locale.Error')], 502);
        }
    }

    public function show($id,Request $request)
    {
        try {
            $level = LMSLevel::find($id);
            return response()->json(['status' => true,'level' => $level]);
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $level = LMSLevel::find($id);
            $validator = Validator::make($request->all(), [
                'title' => ['required',Rule::unique('l_m_s_levels','title')->ignore($id),'min:5'],
            ]);

            $existingOrder = LmsLevel::where('course_id', $level->course_id)
                    ->where('order', $request->order)
                    ->where('id', '!=', $level->id)
                    ->exists();

            if ($existingOrder) {
                return response()->json([
                'status' => false,
                'errors' => ['order' => ['The specified order already exists for this course. Please enter a different order.']],
                'message' => __('locale.ThereWasAProblemAddingCourse') . "<br>" . __('locale.Validation error')
                ], 422);
            }

            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return response()->json(['status' => false,'errors' => $errors, 'message' => __('locale.ThereWasAProblemAddingCourse') . "<br>" . __('locale.Validation error')], 422);
            }

            $level->update([
                'title' => $request->title,
                'order' => $request->order,
            ]);

            $course = LMSCourse::with('levels.training_modules')->find($level->course_id);
            return response()->json(['status' => true,'message' => 'Course is Updated Successfully','course' => $course], 200);
        } catch (\Exception $ex) {
            return response()->json(['status' => false,'message' => __('locale.Error')], 502);
        }
    }
    public function trash($level)
    {
        try {
            $level = LMSLevel::findOrFail($level);
            $level->update(['deleted_at' => now()]);
            $course = LMSCourse::with('levels.training_modules')->find($level->course_id);
            return response()->json(['status' => true,'message' => __('phishing.LevelWasDeletedSuccessfully'),'course' => $course], 200);
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

            $level = LMSLevel::findOrFail($id);
            if($level->training_modules()->exists()){
                return response()->json(['status' => false,'message' => __('lms.LevelCantBeDeletedItContainTrainingModules')], 200);
            }
            $level->forceDelete();
            $course = LMSCourse::with('levels.training_modules')->find($level->course_id);

            return response()->json(['status' => true,'message' => __('lms.LevelWasDeletedSuccessfully'),'course' => $course], 200);
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
        $archived_domains = PhishingDomains::onlyTrashed()->get();
        return view('admin.content.LMS.courses.archived', get_defined_vars());
    }

    public function getLevelTrainingModules(Request $request)
    {
        try {
            if($request->level_id && $request->level_id != null){
                $training_modules = LMSTrainingModule::with('level')->where('level_id',$request->level_id)->get();
            }else{
                $training_modules = LMSTrainingModule::with('level')->get();
            }
            return response()->json(['status' => true,'trainingModules' => $training_modules], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false,'message' =>$e->getMessage()], 502);
        }
    }
}
