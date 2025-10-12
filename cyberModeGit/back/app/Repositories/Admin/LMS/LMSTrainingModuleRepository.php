<?php


namespace App\Repositories\Admin\LMS;

use App\Interfaces\Admin\LMS\LMSLevelInterface;
use App\Interfaces\Admin\LMS\LMSTrainingModuleInterface;
use App\Models\LMSCourse;
use App\Models\LMSLevel;
use App\Models\LMSOption;
use App\Models\LMSQuestion;
use App\Models\LMSTrainingModule;
use App\Models\PhishingDomains;
use App\Traits\UpoladFileTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class LMSTrainingModuleRepository implements LMSTrainingModuleInterface
{
    use UpoladFileTrait;
    public function index()
    {

    }
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'train_level_id' => 'required|integer',
                'name' => ['required','min:5',Rule::unique('l_m_s_training_modules', 'name')->where('level_id', $request->level_id)],
                'passing_score' => 'required|integer|min:0|max:100',
                'module_order' => 'required|integer|min:1',
                'cover_image_url' => 'nullable|string|url',
                'completion_time' => 'required|integer|min:1',
                'compliance_mapping' => 'required|array',
                'items' => 'required|array',
                'items.*.video_url' => 'nullable|max:102400',
                'items.*.video_url_en' => 'nullable|max:102400',
                'items.*.statement_title' => 'required_if:items.*.type,statement|string|max:255|min:5',
                'items.*.statement_title_ar' => 'required_if:items.*.type,statement|string|max:255|min:5',
                'items.*.statement_content' => 'required_if:items.*.type,statement|string|min:5',
                'items.*.statement_content_ar' => 'required_if:items.*.type,statement|string|min:5',
                'items.*.question' => 'required_if:items.*.type,question|string',
                'items.*.question_ar' => 'required_if:items.*.type,question|string',
                'items.*.question_type' => 'required_if:items.*.type,question',
                'items.*.true_or_false_correct_answer' => 'required_if:items.*.question_type,true_or_false',
                'items.*.answer_description' => 'required_if:items.*.type,question|string',
                'items.*.answer_description_ar' => 'required_if:items.*.type,question|string',
            ]);

            $existingOrder = LMSTrainingModule::where('level_id', $request->level_id)
            ->where('order', $request->module_order)
            ->exists();

            if ($existingOrder) {
                return response()->json([
                'status' => false,
                'errors' => ['module_order' => ['The specified order already exists for this Level. Please enter a different order.']],
                'message' => __('locale.ThereWasAProblemAddingCourse') . "<br>" . __('locale.Validation error')
                ], 422);
            }


            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return response()->json(['status' => false,'errors' => $errors, 'message' => __('locale.ThereWasAProblemAddingCourse') . "<br>" . __('locale.Validation error')], 422);
            }

            DB::beginTransaction();
            if($request->hasFile('cover_image')) {
                $file = $request->file('cover_image');
                $trainPath = $this->storeFileInStorage($file, 'public/LMS/training_modules');
            }

            $trainingModule = LMSTrainingModule::create([
                'name' => $request->name,
                'passing_score' => $request->passing_score,
                'module_language' => $request->module_language,
                'order' => $request->module_order,
                'completion_time' => $request->completion_time,
                'cover_image_url' => $request->cover_image_url,
                'cover_image' => $trainPath ?? null,
                'level_id' => $request->level_id,
            ]);

            // Compliance mappaing
            $trainingModule->compliances()->attach($request->compliance_mapping ?? []);

            $items = $request->items;
            foreach ($items as $key => $item) {
                $type = $item['type'];
                $pageNumber = $item['page_number'] ?? null;

                if ($type === 'statement') {

                    if (isset($item['image'])) {
                        $file = $item['image'];
                        $path = $this->storeFileInStorage($file, 'public/statement');
                    }

                    if (isset($item['image_ar'])) {
                        $file = $item['image_ar'];
                        $path_ar = $this->storeFileInStorage($file, 'public/statement');
                    }

                    // if (isset($item['video_url'])) {
                    //     $file = $item['video_url'];
                    //     $videoPath = $this->storeFileInStorage($file, 'public/statement');
                    // }

                    // if (isset($item['video_url_en'])) {
                    //     $file = $item['video_url_en'];
                    //     $videoEnPath = $this->storeFileInStorage($file, 'public/statement');
                    // }

                    $trainingModule->statements()->create([
                        'title' => $item['statement_title'],
                        'title_ar' => $item['statement_title_ar'],
                        'content' => $item['statement_content'],
                        'content_ar' => $item['statement_content_ar'],
                        'additional_content' => $item['additional_content'],

                        'video_or_image_url_en' => $item['video_url_en_path'],
                        'video_or_image_url' => $item['video_url_ar_path'],

                        // 'video_or_image_url' => $videoPath ?? null,
                        // 'video_or_image_url_en' => $videoEnPath ?? null,
                        'page_number' => $pageNumber,
                        'image' => $path ?? null,
                        'image_ar' => $path_ar ?? null,
                    ]);


                } elseif ($type === 'question') {
                    $question = $trainingModule->questions()->create([
                        'question' => $item['question'],
                        'question_ar' => $item['question_ar'],
                        'question_type' => $item['question_type'],
                        'page_number' => $pageNumber,
                        'answer_description' => $item['answer_description'],
                        'answer_description_ar' => $item['answer_description_ar'],
                    ]);

                    if($item['question_type'] == 'multi_choise'){
                        $question->update([
                            'correct_answer' => $item['correct_answer'],
                            'correct_answer_ar' => $item['correct_answer_ar'] ?? null
                        ]);

                        foreach ($item['options'] as $optionText) {
                            if(!empty($optionText)){
                                $question->options()->create([
                                    'option_text' => $optionText,
                                    'is_correct' => $optionText == $question->correct_answer ? 1 : 0,
                                ]);
                            }
                        }

                        foreach ($question->options as $index => $option) {
                            if (isset($item['options_ar'][$index])) {
                                $optionTextAr = $item['options_ar'][$index];
                                if (!empty($optionTextAr)) {
                                    $option->update([
                                        'option_text_ar' => $optionTextAr,
                                    ]);
                                }
                            }
                        }

                    }else{
                        $question->update([
                            'correct_answer' => $item['true_or_false_correct_answer'],
                        ]);
                    }
                }
            }

            DB::commit();

            $course = $trainingModule->level->course;
            if($course){
                $course = LMSCourse::with('levels.training_modules')->find($course->id);
            }
            return response()->json(['status' => true,'message' => 'Training Module is Added Successfully','course' => $course],200);
        } catch (\Exception $ex) {
            return response()->json($ex->getMessage(), 502);
            return response()->json(['status' => false,'message' => __('locale.Error')], 502);
        }
    }

    public function uploadSingleVideo(Request $request)
    {
        if ($request->hasFile('video')) {
            $file = $request->video;
            $videoEnPath = $this->storeFileInStorage($file, 'public/statement');
            return response()->json(['video_url' => $videoEnPath]);
        }
        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function show($id,Request $request)
    {
        try {
            // $level = LMSLevel::find($id);
            $training_module = LMSTrainingModule::with('level.course')->find($id);
            return response()->json(['status' => true,'training_module' => $training_module]);
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }

    public function edit($id,Request $request)
    {
        try {
            $train_data = LMSTrainingModule::with('questions.options','statements')->find($id);
            $pages = [];
            foreach ($train_data->questions as $question) {
                $pages[$question->page_number] = ['type' => 'question', 'content' => $question , 'options' => $question->options];
            }
            foreach ($train_data->statements as $statement) {
                if (!isset($pages[$statement->page_number])) {
                    $pages[$statement->page_number] = ['type' => 'statement', 'content' => $statement];
                }
            }
            ksort($pages);

            return response()->json(['status' => true,'training_module' => $pages]);
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }

    public function update($id,Request $request)
    {
        try {
            $trainingModule = LMSTrainingModule::findOrFail($id);
            $validator = Validator::make($request->all(), [
                'name' => ['required','min:5',Rule::unique('l_m_s_training_modules', 'name')->where('level_id', $request->level_id)->ignore($trainingModule->id)],
                'passing_score' => 'required|integer|min:0|max:100',
                'module_order' => 'required|integer|min:1',
                'cover_image_url' => 'nullable|string|url',
                'completion_time' => 'required|integer|min:1',
                'compliance_mapping' => 'required|array',
                'items' => 'required|array',
                'items.*.video_url' => 'nullable|max:102400',
                'items.*.video_url_en' => 'nullable|max:102400',
                'items.*.statement_title' => 'required_if:items.*.type,statement|string|max:255|min:5',
                'items.*.statement_title_ar' => 'required_if:items.*.type,statement|string|max:255|min:5',
                'items.*.statement_content' => 'required_if:items.*.type,statement|string|min:5',
                'items.*.statement_content_ar' => 'required_if:items.*.type,statement|string|min:5',
                'items.*.question' => 'required_if:items.*.type,question|string',
                'items.*.question_ar' => 'required_if:items.*.type,question|string',
                'items.*.question_type' => 'required_if:items.*.type,question',
                'items.*.true_or_false_correct_answer' => 'required_if:items.*.question_type,true_or_false',
                'items.*.answer_description' => 'required_if:items.*.type,question|string',
                'items.*.answer_description_ar' => 'required_if:items.*.type,question|string',

            ]);

            $existingOrder = LMSTrainingModule::where('level_id', $request->level_id)
                ->where('order', $request->module_order)
                ->where('id', '!=', $trainingModule->id)
                ->exists();

            if ($existingOrder) {
                return response()->json([
                    'status' => false,
                    'errors' => ['module_order' => ['The specified order already exists for this Level. Please enter a different order.']],
                    'message' => __('locale.ThereWasAProblemUpdatingCourse') . "<br>" . __('locale.Validation error'),
                ], 422);
            }

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->toArray(),
                    'message' => __('locale.ThereWasAProblemUpdatingCourse') . "<br>" . __('locale.Validation error'),
                ], 422);
            }

            DB::beginTransaction();

            if ($request->hasFile('cover_image')) {
                $file = $request->file('cover_image');
                // $trainPath = $this->storeFileInStorage($file, 'public/training_modules');
                $trainPath = $this->storeFileInStorage($file, 'public/LMS/training_modules');
                if ($trainingModule->cover_image) {
                    Storage::delete($trainingModule->cover_image);
                }
            }

            $trainingModule->update([
                'name' => $request->name,
                'passing_score' => $request->passing_score,
                'module_language' => $request->module_language,
                'order' => $request->module_order,
                'completion_time' => $request->completion_time,
                'cover_image_url' => $request->cover_image_url,
                'cover_image' => $trainPath ?? $trainingModule->cover_image,
                'level_id' => $request->level_id,
            ]);

            // Update compliance mapping
            $trainingModule->compliances()->sync($request->compliance_mapping ?? []);

            $existingStatementIds = $trainingModule->statements()->pluck('id')->toArray();
            $existingQuestionIds = $trainingModule->questions()->pluck('id')->toArray();
            $updatedStatementIds = [];
            $updatedQuestionIds = [];

            // Handle statements and questions
            $items = $request->items;
            foreach ($items as $key => $item) {
                $type = $item['type'];
                $pageNumber = $item['page_number'] ?? null;

                if ($type === 'statement') {
                    // Check if the statement exists
                    $statement = $trainingModule->statements()->find($item['statement_id'] ?? null);

                    if (isset($item['image'])) {
                        $file = $item['image'];
                        $path = $this->storeFileInStorage($file, 'public/statement');
                    }

                    if (isset($item['image_ar'])) {
                        $file = $item['image_ar'];
                        $path_ar = $this->storeFileInStorage($file, 'public/statement');
                    }

                    // if (isset($item['video_url'])) {
                    //     $file = $item['video_url'];
                    //     $videoPath = $this->storeFileInStorage($file, 'public/statement');
                    // }

                    // if (isset($item['video_url_en'])) {
                    //     $file = $item['video_url_en'];
                    //     $videoEnPath = $this->storeFileInStorage($file, 'public/statement');
                    // }

                    if ($statement) {
                        $statement->update([
                            'title' => $item['statement_title'],
                            'title_ar' => $item['statement_title_ar'],
                            'content' => $item['statement_content'],
                            'content_ar' => $item['statement_content_ar'],
                            'additional_content' => $item['additional_content'],
                            'page_number' => $pageNumber,

                            'video_or_image_url_en' => $item['video_url_en_path'] ?? $statement->video_or_image_url_en,
                            'video_or_image_url' => $item['video_url_ar_path'] ?? $statement->video_or_image_url,


                            // 'video_or_image_url' => $videoPath ?? $statement->video_or_image_url,
                            // 'video_or_image_url_en' => $videoEnPath ?? $statement->video_or_image_url_en,
                            'image' => $path ?? $statement->image,
                            'image_ar' => $path_ar ?? $statement->image_ar,
                        ]);
                        $updatedStatementIds[] = $statement->id;

                    } else {
                        // Create a new statement
                        $statement = $trainingModule->statements()->create([
                            'title' => $item['statement_title'],
                            'title_ar' => $item['statement_title_ar'],
                            'content' => $item['statement_content'],
                            'content_ar' => $item['statement_content_ar'],
                            'additional_content' => $item['additional_content'],
                            'page_number' => $pageNumber,
                            'video_or_image_url' => $videoPath ?? null,
                            'video_or_image_url_en' => $videoEnPath ?? null,
                            'image' => $path ?? null,
                            'image_ar' => $path_ar ?? null,
                        ]);
                        $updatedStatementIds[] = $statement->id;
                    }
                } elseif ($type === 'question') {
                    // Check if the question exists
                    $question = $trainingModule->questions()->find($item['question_id'] ?? null);

                    if ($question) {
                        $question->update([
                            'question' => $item['question'],
                            'question_ar' => $item['question_ar'],
                            'question_type' => $item['question_type'],
                            'page_number' => $pageNumber,
                            'answer_description' => $item['answer_description'],
                            'answer_description_ar' => $item['answer_description_ar'],
                        ]);
                        $updatedQuestionIds[] = $question->id;
                    } else {
                        // Create a new question
                        $question = $trainingModule->questions()->create([
                            'question' => $item['question'],
                            'question_ar' => $item['question_ar'],
                            'question_type' => $item['question_type'],
                            'page_number' => $pageNumber,
                            'answer_description' => $item['answer_description'],
                            'answer_description_ar' => $item['answer_description_ar'],
                        ]);
                        $updatedQuestionIds[] = $question->id;
                    }

                    if ($item['question_type'] == 'multi_choise') {
                        $question->options()->delete();
                        $question->update(['correct_answer' => $item['correct_answer']]);
                        foreach ($item['options'] as $optionText) {
                            if (!empty($optionText)) {
                                $question->options()->create([
                                    'option_text' => $optionText,
                                    'is_correct' => $optionText == $question->correct_answer ? 1 : 0,
                                ]);
                            }
                        }

                        foreach ($question->options as $index => $option) {
                            if (isset($item['options_ar'][$index])) {
                                $optionTextAr = $item['options_ar'][$index];
                                if (!empty($optionTextAr)) {
                                    $option->update([
                                        'option_text_ar' => $optionTextAr,
                                    ]);
                                }
                            }
                        }

                    } else {
                        $question->update(['correct_answer' => $item['true_or_false_correct_answer']]);
                    }
                }
            }

            // Delete statements and questions that were removed
            $statementsToDelete = array_diff($existingStatementIds, $updatedStatementIds);
            $questionsToDelete = array_diff($existingQuestionIds, $updatedQuestionIds);

            // dd($updatedQuestionIds, $existingQuestionIds, $questionsToDelete);

            $trainingModule->statements()->whereIn('id', $statementsToDelete)->delete();
            $trainingModule->questions()->whereIn('id', $questionsToDelete)->delete();

            DB::commit();

            $course = $trainingModule->level->course;
            if ($course) {
                $course = LMSCourse::with('levels.training_modules')->find($course->id);
            }

            return response()->json([
                'status' => true,
                'message' => 'Training Module updated successfully',
                'course' => $course,
            ], 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $ex->getMessage()], 502);
            return response()->json(['status' => false, 'message' => __('locale.Error')], 502);
        }
    }

    public function trash($train_id)
    {
        try {
            $trainingModule = LMSTrainingModule::findOrFail($train_id);
            $trainingModule->update(['deleted_at' => now()]);

            $course = $trainingModule->level->course;
            if($course){
                $course = LMSCourse::with('levels.training_modules')->find($course->id);
            }
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
            $trainigModule = LMSTrainingModule::findOrFail($id);
            if ($trainigModule->campaigns()->exists()) {
                return response()->json([
                    'status' => false,
                    'message' => __('asset.TrainingCannotBeDeletedDueToCampaignsRelation'),
                ], 422);
            }
            $courseId = $trainigModule->level->course->id ?? null;
            $trainigModule->forceDelete();
            $course = $courseId ? LMSCourse::with('levels.training_modules')->find($courseId) : null;
            return response()->json(['status' => true,'message' => __('lms.TrainnigModuleWasDeletedSuccessfully'),'course' => $course], 200);
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

    public function getCompliances($id)
    {
        try {
            $trainigModule = LMSTrainingModule::with('compliances')->findOrFail($id);
            $compliances = $trainigModule->compliances->pluck('id')->toArray();
            return response()->json(['status' => true,'compliances' => $compliances], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false,'message' => __('locale.Error')], 502);
        }
    }
}
