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
use App\Models\SurveyResponse;
use App\Services\SurveyService;
use App\Traits\UpoladFileTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class LMSTrainingModuleRepository implements LMSTrainingModuleInterface
{
    use UpoladFileTrait;

    protected $surveyService;
    public function __construct(SurveyService $surveyService)
    {
        $this->surveyService = $surveyService;
    }

    public function index()
    {

    }
    public function store(Request $request)
    {
        try {
            // Helper function to convert string "null" to actual null
            $sanitizeNullValues = function ($data) use (&$sanitizeNullValues) {
                if (is_array($data)) {
                    return array_map($sanitizeNullValues, $data);
                }
                return ($data === 'null' || $data === '') ? null : $data;
            };

            // Clean the request data
            $cleanedData = $sanitizeNullValues($request->all());
            $request->merge($cleanedData);

            $validator = Validator::make($request->all(), [
                'train_level_id' => 'required|integer',
                'training_type' => 'required|in:public,campaign',
                'count_of_entering_exam' => 'required|integer|min:0|max:999',
                'name' => ['required', 'min:5', Rule::unique('l_m_s_training_modules', 'name')->where('level_id', $request->level_id)],
                'passing_score' => 'required|integer|min:0|max:100',
                'module_order' => 'required|integer|min:1',
                'cover_image_url' => 'nullable|string|url',
                'completion_time' => 'required|integer|min:1',
                // 'compliance_mapping' => 'required|array',
                'items' => 'required|array',
                'items.*.video_url' => 'nullable',
                'items.*.video_url_en' => 'nullable',
                'items.*.question_type' => 'required_if:items.*.type,question',
                'items.*.true_or_false_correct_answer' => 'required_if:items.*.question_type,true_or_false',
                'survey_id' => 'required|exists:awareness_surveys,id',

            ]);

            $items = $request->input('items', []);
            foreach ($items as $index => $item) {
                $type = $item['type'] ?? null;

                if ($type === 'statement') {
                    // Statement validation rules
                    $validator->addRules([
                        "items.{$index}.statement_title" => [
                            'required_without:items.' . $index . '.statement_title_ar',
                            'max:255',
                        ],
                        "items.{$index}.statement_title_ar" => [
                            'required_without:items.' . $index . '.statement_title',
                            'max:255',
                        ],
                        "items.{$index}.statement_content" => [
                            'required_without:items.' . $index . '.statement_content_ar',
                        ],
                        "items.{$index}.statement_content_ar" => [
                            'required_without:items.' . $index . '.statement_content',
                        ],
                    ]);

                } elseif ($type === 'question') {
                    // Question validation rules
                    $validator->addRules([
                        "items.{$index}.question" => [
                            'required_without:items.' . $index . '.question_ar',
                        ],
                        "items.{$index}.question_ar" => [
                            'required_without:items.' . $index . '.question',
                        ],
                        "items.{$index}.answer_description" => [
                            'required_without:items.' . $index . '.answer_description_ar',
                        ],
                        "items.{$index}.answer_description_ar" => [
                            'required_without:items.' . $index . '.answer_description',
                        ],

                        // for answers
                        "items.{$index}.correct_answer_ar" => [
                            'required_without:items.' . $index . '.correct_answer',
                        ],

                        "items.{$index}.correct_answer" => [
                            'required_without:items.' . $index . '.correct_answer_ar',
                        ],

                    ]);
                }
            }

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
                return response()->json(['status' => false, 'errors' => $errors, 'message' => __('locale.ThereWasAProblemAddingCourse') . "<br>" . __('locale.Validation error')], 422);
            }

            DB::beginTransaction();

            if ($request->hasFile('cover_image')) {
                $file = $request->file('cover_image');
                $trainPath = $this->storeFileInStorage($file, 'public/LMS/training_modules');
            }

            $trainingModule = LMSTrainingModule::create([
                'name' => $request->name,
                'training_type' => $request->training_type,
                'count_of_entering_exam' => $request->count_of_entering_exam,
                'passing_score' => $request->passing_score,
                'module_language' => $request->module_language,
                'order' => $request->module_order,
                'completion_time' => $request->completion_time,
                'cover_image_url' => $request->cover_image_url ?: null, // Convert empty string to null
                'cover_image' => $trainPath ?? null,
                'level_id' => $request->level_id,
                'survey_id' => $request->survey_id,

            ]);

            // Compliance mapping
            $trainingModule->compliances()->attach($request->compliance_mapping ?? []);

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

                    $trainingModule->statements()->create([
                        'title' => !empty($item['statement_title']) ? $item['statement_title'] : null,
                        'title_ar' => !empty($item['statement_title_ar']) ? $item['statement_title_ar'] : null,
                        'content' => !empty($item['statement_content']) ? $item['statement_content'] : null,
                        'content_ar' => !empty($item['statement_content_ar']) ? $item['statement_content_ar'] : null,
                        'additional_content' => !empty($item['additional_content']) ? $item['additional_content'] : null,
                        'video_or_image_url_en' => !empty($item['video_url_en_path']) ? $item['video_url_en_path'] : null,
                        'video_or_image_url' => !empty($item['video_url_ar_path']) ? $item['video_url_ar_path'] : null,
                        'page_number' => $pageNumber,
                        'image' => $path ?? null,
                        'image_ar' => $path_ar ?? null,
                    ]);

                } elseif ($type === 'question') {
                    $question = $trainingModule->questions()->create([
                        'question' => !empty($item['question']) ? $item['question'] : null,
                        'question_ar' => !empty($item['question_ar']) ? $item['question_ar'] : null,
                        'question_type' => !empty($item['question_type']) ? $item['question_type'] : null,
                        'page_number' => $pageNumber,
                        'answer_description' => !empty($item['answer_description']) ? $item['answer_description'] : null,
                        'answer_description_ar' => !empty($item['answer_description_ar']) ? $item['answer_description_ar'] : null,
                    ]);

                    if ($item['question_type'] == 'multi_choise') {
                        $question->update([
                            'correct_answer' => !empty($item['correct_answer']) ? $item['correct_answer'] : null,
                            'correct_answer_ar' => !empty($item['correct_answer_ar']) ? $item['correct_answer_ar'] : null
                        ]);


                        $question->options()->delete();
                        $maxCount = 0;
                        if (isset($item['options']) && is_array($item['options'])) {
                            $maxCount = max($maxCount, count($item['options']));
                        }
                        if (isset($item['options_ar']) && is_array($item['options_ar'])) {
                            $maxCount = max($maxCount, count($item['options_ar']));
                        }

                        for ($i = 0; $i < $maxCount; $i++) {
                            $optionText = null;
                            $optionTextAr = null;
                            $isCorrect = 0;

                            if (
                                isset($item['options'][$i]) &&
                                !empty($item['options'][$i]) &&
                                $item['options'][$i] !== 'null'
                            ) {
                                $optionText = $item['options'][$i];
                            }

                            if (
                                isset($item['options_ar'][$i]) &&
                                !empty($item['options_ar'][$i]) &&
                                $item['options_ar'][$i] !== 'null'
                            ) {
                                $optionTextAr = $item['options_ar'][$i];
                            }

                            if ($optionText || $optionTextAr) {
                                if (
                                    ($optionText && $optionText == $question->correct_answer) ||
                                    ($optionTextAr && $optionTextAr == $question->correct_answer_ar)
                                ) {
                                    $isCorrect = 1;
                                }

                                $question->options()->create([
                                    'option_text' => $optionText,
                                    'option_text_ar' => $optionTextAr,
                                    'is_correct' => $isCorrect,
                                ]);
                            }
                        }


                        // if (isset($item['options']) && is_array($item['options'])) {
                        //     foreach ($item['options'] as $optionText) {
                        //         if (!empty($optionText) && $optionText !== 'null') {
                        //             $question->options()->create([
                        //                 'option_text' => $optionText,
                        //                 'is_correct' => $optionText == $question->correct_answer ? 1 : 0,
                        //             ]);
                        //         }
                        //     }
                        // }

                        // if (isset($item['options_ar']) && is_array($item['options_ar'])) {
                        //     foreach ($item['options_ar'] as $optionText) {
                        //         if (!empty($optionText) && $optionText !== 'null') {
                        //             $question->options()->create([
                        //                 'option_text_ar' => $optionText,
                        //                 'is_correct' => $optionText == $question->correct_answer_ar ? 1 : 0,
                        //             ]);
                        //         }
                        //     }
                        // }

                    } else {
                        $question->update([
                            'correct_answer' => $item['true_or_false_correct_answer'] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();

            $course = $trainingModule->level->course;
            if ($course) {
                $course = LMSCourse::with('levels.training_modules')->find($course->id);
            }

            return response()->json([
                'status' => true,
                'message' => 'Training Module is Added Successfully',
                'course' => $course
            ], 200);

        } catch (\Exception $ex) {
            DB::rollBack();
            \Log::error('Training Module Creation Error: ' . $ex->getMessage());
            return response()->json([
                'status' => false,
                // 'message' => $ex->getMessage(),
                'message' => __('locale.Error')
            ], 502);
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

    public function preview($id)
    {
        try {
            $breadcrumbs = [
                ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
                ['name' => __('lms.Preview')]
            ];
            $train_data = LMSTrainingModule::with('questions.options', 'statements')->find($id);

            $pages = [];
            foreach ($train_data->questions as $question) {
                $pages[$question->page_number] = ['type' => 'question', 'content' => $question, 'options' => $question->options];
            }
            foreach ($train_data->statements as $statement) {
                if (!isset($pages[$statement->page_number])) {
                    $pages[$statement->page_number] = ['type' => 'statement', 'content' => $statement];
                }
            }
            ksort($pages);
            return view('admin.content.LMS.courses.preview', get_defined_vars());
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function show($id, Request $request)
    {
        try {
            // $level = LMSLevel::find($id);
            $training_module = LMSTrainingModule::with('level.course')->find($id);
            return response()->json(['status' => true, 'training_module' => $training_module]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function edit($id, Request $request)
    {
        try {
            $train_data = LMSTrainingModule::with('questions.options', 'statements')->find($id);
            $pages = [];
            foreach ($train_data->questions as $question) {
                $pages[$question->page_number] = ['type' => 'question', 'content' => $question, 'options' => $question->options];
            }
            foreach ($train_data->statements as $statement) {
                if (!isset($pages[$statement->page_number])) {
                    $pages[$statement->page_number] = ['type' => 'statement', 'content' => $statement];
                }
            }
            ksort($pages);

            return response()->json(['status' => true, 'training_module' => $pages]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // public function update($id, Request $request)
    // {
    //     try {
    //         $sanitizeNullValues = function ($data) use (&$sanitizeNullValues) {
    //             if (is_array($data)) {
    //                 return array_map($sanitizeNullValues, $data);
    //             }
    //             return ($data === 'null' || $data === '') ? null : $data;
    //         };

    //         // Clean the request data
    //         $cleanedData = $sanitizeNullValues($request->all());
    //         $request->merge($cleanedData);

    //         $trainingModule = LMSTrainingModule::findOrFail($id);
    //         $validator = Validator::make($request->all(), [
    //             'name' => ['required', 'min:5', Rule::unique('l_m_s_training_modules', 'name')->where('level_id', $request->level_id)->ignore($trainingModule->id)],
    //             'training_type' => 'required|in:public,campaign',
    //             'count_of_entering_exam' => 'required|integer|min:0|max:10',
    //             'passing_score' => 'required|integer|min:0|max:100',
    //             'module_order' => 'required|integer|min:1',
    //             'cover_image_url' => 'nullable|string|url',
    //             'completion_time' => 'required|integer|min:1',
    //             'compliance_mapping' => 'required|array',
    //             'items' => 'required|array',
    //             'items.*.video_url' => 'nullable',
    //             'items.*.video_url_en' => 'nullable',
    //             // 'items.*.statement_title' => 'required_if:items.*.type,statement|string|max:255|min:5',
    //             // 'items.*.statement_title_ar' => 'required_if:items.*.type,statement|string|max:255|min:5',
    //             // 'items.*.statement_content' => 'required_if:items.*.type,statement|string|min:5',
    //             // 'items.*.statement_content_ar' => 'required_if:items.*.type,statement|string|min:5',
    //             // 'items.*.question' => 'required_if:items.*.type,question|string',
    //             // 'items.*.question_ar' => 'required_if:items.*.type,question|string',
    //             'items.*.question_type' => 'required_if:items.*.type,question',
    //             'items.*.true_or_false_correct_answer' => 'required_if:items.*.question_type,true_or_false',
    //             // 'items.*.answer_description' => 'required_if:items.*.type,question|string',
    //             // 'items.*.answer_description_ar' => 'required_if:items.*.type,question|string',

    //         ]);

    //         $items = $request->input('items', []);
    //         foreach ($items as $index => $item) {
    //             $type = $item['type'] ?? null;

    //             if ($type === 'statement') {
    //                 // Statement validation rules
    //                 $validator->addRules([
    //                     "items.{$index}.statement_title" => [
    //                         'required_without:items.' . $index . '.statement_title_ar',
    //                         'max:255',
    //                     ],
    //                     "items.{$index}.statement_title_ar" => [
    //                         'required_without:items.' . $index . '.statement_title',
    //                         'max:255',
    //                     ],
    //                     "items.{$index}.statement_content" => [
    //                         'required_without:items.' . $index . '.statement_content_ar',
    //                     ],
    //                     "items.{$index}.statement_content_ar" => [
    //                         'required_without:items.' . $index . '.statement_content',
    //                     ],
    //                 ]);

    //             } elseif ($type === 'question') {
    //                 // Question validation rules
    //                 $validator->addRules([
    //                     "items.{$index}.question" => [
    //                         'required_without:items.' . $index . '.question_ar',
    //                     ],
    //                     "items.{$index}.question_ar" => [
    //                         'required_without:items.' . $index . '.question',
    //                     ],
    //                     "items.{$index}.answer_description" => [
    //                         'required_without:items.' . $index . '.answer_description_ar',
    //                     ],
    //                     "items.{$index}.answer_description_ar" => [
    //                         'required_without:items.' . $index . '.answer_description',
    //                     ],
    //                 ]);
    //             }
    //         }

    //         $existingOrder = LMSTrainingModule::where('level_id', $request->level_id)
    //             ->where('order', $request->module_order)
    //             ->where('id', '!=', $trainingModule->id)
    //             ->exists();

    //         if ($existingOrder) {
    //             return response()->json([
    //                 'status' => false,
    //                 'errors' => ['module_order' => ['The specified order already exists for this Level. Please enter a different order.']],
    //                 'message' => __('locale.ThereWasAProblemUpdatingCourse') . "<br>" . __('locale.Validation error'),
    //             ], 422);
    //         }

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => false,
    //                 'errors' => $validator->errors()->toArray(),
    //                 'message' => __('locale.ThereWasAProblemUpdatingCourse') . "<br>" . __('locale.Validation error'),
    //             ], 422);
    //         }

    //         DB::beginTransaction();

    //         if ($request->hasFile('cover_image')) {
    //             $file = $request->file('cover_image');
    //             // $trainPath = $this->storeFileInStorage($file, 'public/training_modules');
    //             $trainPath = $this->storeFileInStorage($file, 'public/LMS/training_modules');
    //             if ($trainingModule->cover_image) {
    //                 Storage::delete($trainingModule->cover_image);
    //             }
    //         }

    //         $trainingModule->update([
    //             'name' => $request->name,
    //             'training_type' => $request->training_type,
    //             'count_of_entering_exam' => $request->count_of_entering_exam,
    //             'passing_score' => $request->passing_score,
    //             'module_language' => $request->module_language,
    //             'order' => $request->module_order,
    //             'completion_time' => $request->completion_time,
    //             'cover_image_url' => $request->cover_image_url,
    //             'cover_image' => $trainPath ?? $trainingModule->cover_image,
    //             'level_id' => $request->level_id,
    //         ]);

    //         // Update compliance mapping
    //         $trainingModule->compliances()->sync($request->compliance_mapping ?? []);

    //         $existingStatementIds = $trainingModule->statements()->pluck('id')->toArray();
    //         $existingQuestionIds = $trainingModule->questions()->pluck('id')->toArray();
    //         $updatedStatementIds = [];
    //         $updatedQuestionIds = [];

    //         // Handle statements and questions
    //         // $items = $request->items;
    //         foreach ($items as $key => $item) {
    //             $type = $item['type'];
    //             $pageNumber = $item['page_number'] ?? null;

    //             if ($type === 'statement') {
    //                 // Check if the statement exists
    //                 $statement = $trainingModule->statements()->find($item['statement_id'] ?? null);

    //                 if (isset($item['image'])) {
    //                     $file = $item['image'];
    //                     $path = $this->storeFileInStorage($file, 'public/statement');
    //                 }

    //                 if (isset($item['image_ar'])) {
    //                     $file = $item['image_ar'];
    //                     $path_ar = $this->storeFileInStorage($file, 'public/statement');
    //                 }

    //                 // if (isset($item['video_url'])) {
    //                 //     $file = $item['video_url'];
    //                 //     $videoPath = $this->storeFileInStorage($file, 'public/statement');
    //                 // }

    //                 // if (isset($item['video_url_en'])) {
    //                 //     $file = $item['video_url_en'];
    //                 //     $videoEnPath = $this->storeFileInStorage($file, 'public/statement');
    //                 // }

    //                 if ($statement) {
    //                     $statement->update([
    //                         'title' => $item['statement_title'] ?? null,
    //                         'title_ar' => $item['statement_title_ar'] ?? null,
    //                         'content' => $item['statement_content'] ?? null,
    //                         'content_ar' => $item['statement_content_ar'] ?? null,
    //                         'additional_content' => $item['additional_content'] ?? null,
    //                         'page_number' => $pageNumber,
    //                         'video_or_image_url_en' => $item['video_url_en_path'] ?? $statement->video_url_en_path,
    //                         'video_or_image_url' => $item['video_url_ar_path'] ?? $statement->video_url_ar_path,
    //                         'image' => $path ?? $statement->image,
    //                         'image_ar' => $path_ar ?? $statement->image_ar,
    //                     ]);
    //                     $updatedStatementIds[] = $statement->id;

    //                 } else {
    //                     // Create a new statement
    //                     $statement = $trainingModule->statements()->create([
    //                         'title' => $item['statement_title'] ?? null,
    //                         'title_ar' => $item['statement_title_ar'] ?? null,
    //                         'content' => $item['statement_content'] ?? null,
    //                         'content_ar' => $item['statement_content_ar'] ?? null,
    //                         'additional_content' => $item['additional_content'] ?? null,
    //                         'page_number' => $pageNumber,
    //                         'video_or_image_url' => $videoPath ?? null,
    //                         'video_or_image_url_en' => $videoEnPath ?? null,
    //                         'image' => $path ?? null,
    //                         'image_ar' => $path_ar ?? null,
    //                     ]);
    //                     $updatedStatementIds[] = $statement->id;
    //                 }
    //             } elseif ($type === 'question') {
    //                 // Check if the question exists
    //                 $question = $trainingModule->questions()->find($item['question_id'] ?? null);

    //                 if ($question) {
    //                     $question->update([
    //                         'question' => $item['question'] ?? null,
    //                         'question_ar' => $item['question_ar'] ?? null,
    //                         'question_type' => $item['question_type'] ?? null,
    //                         'page_number' => $pageNumber,
    //                         'answer_description' => $item['answer_description'] ?? null,
    //                         'answer_description_ar' => $item['answer_description_ar'] ?? null,
    //                     ]);
    //                     $updatedQuestionIds[] = $question->id;
    //                 } else {
    //                     // Create a new question
    //                     $question = $trainingModule->questions()->create([
    //                         'question' => $item['question'] ?? null,
    //                         'question_ar' => $item['question_ar'] ?? null,
    //                         'question_type' => $item['question_type'] ?? null,
    //                         'page_number' => $pageNumber,
    //                         'answer_description' => $item['answer_description'] ?? null,
    //                         'answer_description_ar' => $item['answer_description_ar'] ?? null,
    //                     ]);
    //                     $updatedQuestionIds[] = $question->id;
    //                 }

    //                 if ($item['question_type'] == 'multi_choise') {
    //                     $question->options()->delete();
    //                     $question->update(['correct_answer' => $item['correct_answer']]);

    //                     $maxCount = 0;
    //                     if (isset($item['options']) && is_array($item['options'])) {
    //                         $maxCount = max($maxCount, count($item['options']));
    //                     }
    //                     if (isset($item['options_ar']) && is_array($item['options_ar'])) {
    //                         $maxCount = max($maxCount, count($item['options_ar']));
    //                     }

    //                     for ($i = 0; $i < $maxCount; $i++) {
    //                         $optionText = null;
    //                         $optionTextAr = null;
    //                         $isCorrect = 0;

    //                         if (
    //                             isset($item['options'][$i]) &&
    //                             !empty($item['options'][$i]) &&
    //                             $item['options'][$i] !== 'null'
    //                         ) {
    //                             $optionText = $item['options'][$i];
    //                         }

    //                         if (
    //                             isset($item['options_ar'][$i]) &&
    //                             !empty($item['options_ar'][$i]) &&
    //                             $item['options_ar'][$i] !== 'null'
    //                         ) {
    //                             $optionTextAr = $item['options_ar'][$i];
    //                         }

    //                         if ($optionText || $optionTextAr) {
    //                             if (
    //                                 ($optionText && $optionText == $question->correct_answer) ||
    //                                 ($optionTextAr && $optionTextAr == $question->correct_answer_ar)
    //                             ) {
    //                                 $isCorrect = 1;
    //                             }

    //                             $question->options()->create([
    //                                 'option_text' => $optionText,
    //                                 'option_text_ar' => $optionTextAr,
    //                                 'is_correct' => $isCorrect,
    //                             ]);
    //                         }
    //                     }

    //                     // if (isset($item['options']) && is_array($item['options'])) {
    //                     //     foreach ($item['options'] as $optionText) {
    //                     //         if (!empty($optionText)) {
    //                     //             $question->options()->create([
    //                     //                 'option_text' => $optionText,
    //                     //                 'is_correct' => $optionText == $question->correct_answer ? 1 : 0,
    //                     //             ]);
    //                     //         }
    //                     //     }
    //                     // }


    //                     // if (isset($item['options_ar']) && is_array($item['options_ar'])) {
    //                     //     foreach ($item['options_ar'] as $optionText) {
    //                     //         if (!empty($optionText) && $optionText !== 'null') {
    //                     //             $question->options()->create([
    //                     //                 'option_text_ar' => $optionText,
    //                     //                 'is_correct' => $optionText == $question->correct_answer_ar ? 1 : 0,
    //                     //             ]);
    //                     //         }
    //                     //     }
    //                     // }


    //                 } else {
    //                     $question->update(['correct_answer' => $item['true_or_false_correct_answer']]);
    //                 }
    //             }
    //         }

    //         // Delete statements and questions that were removed
    //         $statementsToDelete = array_diff($existingStatementIds, $updatedStatementIds);
    //         $questionsToDelete = array_diff($existingQuestionIds, $updatedQuestionIds);

    //         // dd($updatedQuestionIds, $existingQuestionIds, $questionsToDelete);

    //         $trainingModule->statements()->whereIn('id', $statementsToDelete)->delete();
    //         $trainingModule->questions()->whereIn('id', $questionsToDelete)->delete();

    //         DB::commit();

    //         $course = $trainingModule->level->course;
    //         if ($course) {
    //             $course = LMSCourse::with('levels.training_modules')->find($course->id);
    //         }

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Training Module updated successfully',
    //             'course' => $course,
    //         ], 200);
    //     } catch (\Exception $ex) {
    //         DB::rollBack();
    //         return response()->json(['status' => false, 'message' => $ex->getMessage()], 502);
    //         return response()->json(['status' => false, 'message' => __('locale.Error')], 502);
    //     }
    // }



    public function update($id, Request $request)
    {
        try {
            $sanitizeNullValues = function ($data) use (&$sanitizeNullValues) {
                if (is_array($data)) {
                    return array_map($sanitizeNullValues, $data);
                }
                return ($data === 'null' || $data === '') ? null : $data;
            };

            $cleanedData = $sanitizeNullValues($request->all());
            $request->merge($cleanedData);

            $trainingModule = LMSTrainingModule::findOrFail($id);
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'min:5', Rule::unique('l_m_s_training_modules', 'name')->where('level_id', $request->level_id)->ignore($trainingModule->id)],
                'training_type' => 'required|in:public,campaign',
                'count_of_entering_exam' => 'required|integer|min:0|max:999',
                'passing_score' => 'required|integer|min:0|max:100',
                'module_order' => 'required|integer|min:1',
                'cover_image_url' => 'nullable|string|url',
                'completion_time' => 'required|integer|min:1',
                // 'compliance_mapping' => 'required|array',
                'items' => 'required|array',
                'items.*.video_url' => 'nullable',
                'items.*.video_url_en' => 'nullable',
                'items.*.question_type' => 'required_if:items.*.type,question',
                'items.*.true_or_false_correct_answer' => 'required_if:items.*.question_type,true_or_false',
                'survey_id' => 'required|exists:awareness_surveys,id',

            ]);

            $items = $request->input('items', []);
            foreach ($items as $index => $item) {
                $type = $item['type'] ?? null;

                if ($type === 'statement') {
                    // Statement validation rules
                    $validator->addRules([
                        "items.{$index}.statement_title" => [
                            'required_without:items.' . $index . '.statement_title_ar',
                            'max:255',
                        ],
                        "items.{$index}.statement_title_ar" => [
                            'required_without:items.' . $index . '.statement_title',
                            'max:255',
                        ],
                        "items.{$index}.statement_content" => [
                            'required_without:items.' . $index . '.statement_content_ar',
                        ],
                        "items.{$index}.statement_content_ar" => [
                            'required_without:items.' . $index . '.statement_content',
                        ],
                    ]);

                } elseif ($type === 'question') {
                    // Question validation rules
                    $validator->addRules([
                        "items.{$index}.question" => [
                            'required_without:items.' . $index . '.question_ar',
                        ],
                        "items.{$index}.question_ar" => [
                            'required_without:items.' . $index . '.question',
                        ],
                        "items.{$index}.answer_description" => [
                            'required_without:items.' . $index . '.answer_description_ar',
                        ],
                        "items.{$index}.answer_description_ar" => [
                            'required_without:items.' . $index . '.answer_description',
                        ],

                        // for answers
                        "items.{$index}.correct_answer_ar" => [
                            'required_without:items.' . $index . '.correct_answer',
                        ],

                        "items.{$index}.correct_answer" => [
                            'required_without:items.' . $index . '.correct_answer_ar',
                        ],
                    ]);
                }
            }

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

            // Handle cover image upload
            $trainPath = $trainingModule->cover_image; // Keep existing image by default
            if ($request->hasFile('cover_image')) {
                $file = $request->file('cover_image');
                $trainPath = $this->storeFileInStorage($file, 'public/LMS/training_modules');
                if ($trainingModule->cover_image) {
                    Storage::delete($trainingModule->cover_image);
                }
            }

            $trainingModule->update([
                'name' => $request->name,
                'training_type' => $request->training_type,
                'count_of_entering_exam' => $request->count_of_entering_exam,
                'passing_score' => $request->passing_score,
                'module_language' => $request->module_language,
                'order' => $request->module_order,
                'completion_time' => $request->completion_time,
                'cover_image_url' => $request->cover_image_url,
                'cover_image' => $trainPath,
                'level_id' => $request->level_id,
                'survey_id' => $request->survey_id,
            ]);

            // Update compliance mapping
            $trainingModule->compliances()->sync($request->compliance_mapping ?? []);

            $existingStatementIds = $trainingModule->statements()->pluck('id')->toArray();
            $existingQuestionIds = $trainingModule->questions()->pluck('id')->toArray();
            $updatedStatementIds = [];
            $updatedQuestionIds = [];

            // Handle statements and questions
            foreach ($items as $key => $item) {
                $type = $item['type'];
                $pageNumber = $item['page_number'] ?? null;

                if ($type === 'statement') {
                    // Check if the statement exists
                    $statement = $trainingModule->statements()->find($item['statement_id'] ?? null);

                    // Handle image uploads - keep existing if no new upload
                    $imagePath = $statement ? $statement->image : null;
                    $imagePathAr = $statement ? $statement->image_ar : null;
                    $videoEnPath = $statement ? $statement->video_or_image_url_en : null;
                    $videoArPath = $statement ? $statement->video_or_image_url : null;

                    if (isset($item['image']) && $item['image']) {
                        $file = $item['image'];
                        $imagePath = $this->storeFileInStorage($file, 'public/statement');
                        // Delete old image if exists
                        if ($statement && $statement->image) {
                            Storage::delete($statement->image);
                        }
                    }

                    if (isset($item['image_ar']) && $item['image_ar']) {
                        $file = $item['image_ar'];
                        $imagePathAr = $this->storeFileInStorage($file, 'public/statement');
                        // Delete old image if exists
                        if ($statement && $statement->image_ar) {
                            Storage::delete($statement->image_ar);
                        }
                    }

                    // Handle video uploads - keep existing if no new upload
                    if (isset($item['video_url_en']) && $item['video_url_en']) {
                        $file = $item['video_url_en'];
                        $videoEnPath = $this->storeFileInStorage($file, 'public/statement');
                        // Delete old video if exists
                        if ($statement && $statement->video_or_image_url_en) {
                            Storage::delete($statement->video_or_image_url_en);
                        }
                    }

                    if (isset($item['video_url']) && $item['video_url']) {
                        $file = $item['video_url'];
                        $videoArPath = $this->storeFileInStorage($file, 'public/statement');
                        // Delete old video if exists
                        if ($statement && $statement->video_or_image_url) {
                            Storage::delete($statement->video_or_image_url);
                        }
                    }

                    // Handle video URL paths from request
                    if (isset($item['video_url_en_path']) && !empty($item['video_url_en_path'])) {
                        $videoEnPath = $item['video_url_en_path'];
                    }

                    if (isset($item['video_url_ar_path']) && !empty($item['video_url_ar_path'])) {
                        $videoArPath = $item['video_url_ar_path'];
                    }

                    if ($statement) {
                        $statement->update([
                            'title' => $item['statement_title'] ?? null,
                            'title_ar' => $item['statement_title_ar'] ?? null,
                            'content' => $item['statement_content'] ?? null,
                            'content_ar' => $item['statement_content_ar'] ?? null,
                            'additional_content' => $item['additional_content'] ?? null,
                            'page_number' => $pageNumber,
                            'video_or_image_url_en' => $videoEnPath,
                            'video_or_image_url' => $videoArPath,
                            'image' => $imagePath,
                            'image_ar' => $imagePathAr,
                        ]);
                        $updatedStatementIds[] = $statement->id;

                    } else {
                        // Create a new statement
                        $statement = $trainingModule->statements()->create([
                            'title' => $item['statement_title'] ?? null,
                            'title_ar' => $item['statement_title_ar'] ?? null,
                            'content' => $item['statement_content'] ?? null,
                            'content_ar' => $item['statement_content_ar'] ?? null,
                            'additional_content' => $item['additional_content'] ?? null,
                            'page_number' => $pageNumber,
                            'video_or_image_url' => $videoArPath,
                            'video_or_image_url_en' => $videoEnPath,
                            'image' => $imagePath,
                            'image_ar' => $imagePathAr,
                        ]);
                        $updatedStatementIds[] = $statement->id;
                    }
                } elseif ($type === 'question') {
                    // Check if the question exists
                    $question = $trainingModule->questions()->find($item['question_id'] ?? null);

                    if ($question) {
                        $question->update([
                            'question' => $item['question'] ?? null,
                            'question_ar' => $item['question_ar'] ?? null,
                            'question_type' => $item['question_type'] ?? null,
                            'page_number' => $pageNumber,
                            'answer_description' => $item['answer_description'] ?? null,
                            'answer_description_ar' => $item['answer_description_ar'] ?? null,
                        ]);
                        $updatedQuestionIds[] = $question->id;
                    } else {
                        // Create a new question
                        $question = $trainingModule->questions()->create([
                            'question' => $item['question'] ?? null,
                            'question_ar' => $item['question_ar'] ?? null,
                            'question_type' => $item['question_type'] ?? null,
                            'page_number' => $pageNumber,
                            'answer_description' => $item['answer_description'] ?? null,
                            'answer_description_ar' => $item['answer_description_ar'] ?? null,
                        ]);
                        $updatedQuestionIds[] = $question->id;
                    }

                    if ($item['question_type'] == 'multi_choise') {
                        $question->options()->delete();
                        // $question->update(['correct_answer' => $item['correct_answer']]);
                        $question->update([
                            'correct_answer' => isset($item['correct_answer']) && !empty($item['correct_answer']) ? $item['correct_answer'] : null,
                            'correct_answer_ar' => isset($item['correct_answer_ar']) && !empty($item['correct_answer_ar']) ? $item['correct_answer_ar'] : null,
                        ]);

                        $maxCount = 0;
                        if (isset($item['options']) && is_array($item['options'])) {
                            $maxCount = max($maxCount, count($item['options']));
                        }
                        if (isset($item['options_ar']) && is_array($item['options_ar'])) {
                            $maxCount = max($maxCount, count($item['options_ar']));
                        }

                        for ($i = 0; $i < $maxCount; $i++) {
                            $optionText = null;
                            $optionTextAr = null;
                            $isCorrect = 0;

                            if (
                                isset($item['options'][$i]) &&
                                !empty($item['options'][$i]) &&
                                $item['options'][$i] !== 'null'
                            ) {
                                $optionText = $item['options'][$i];
                            }

                            if (
                                isset($item['options_ar'][$i]) &&
                                !empty($item['options_ar'][$i]) &&
                                $item['options_ar'][$i] !== 'null'
                            ) {
                                $optionTextAr = $item['options_ar'][$i];
                            }

                            if ($optionText || $optionTextAr) {
                                if (
                                    ($optionText && $optionText == $question->correct_answer) ||
                                    ($optionTextAr && $optionTextAr == $question->correct_answer_ar)
                                ) {
                                    $isCorrect = 1;
                                }

                                $question->options()->create([
                                    'option_text' => $optionText,
                                    'option_text_ar' => $optionTextAr,
                                    'is_correct' => $isCorrect,
                                ]);
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
        }
    }

    public function trash($train_id)
    {
        try {
            $trainingModule = LMSTrainingModule::findOrFail($train_id);
            $trainingModule->update(['deleted_at' => now()]);

            $course = $trainingModule->level->course;
            if ($course) {
                $course = LMSCourse::with('levels.training_modules')->find($course->id);
            }
            return response()->json(['status' => true, 'message' => __('phishing.LevelWasDeletedSuccessfully'), 'course' => $course], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => __('locale.Error')], 502);
        }
    }

    public function restore($id, Request $request)
    {
        try {
            $domain = PhishingDomains::onlyTrashed()->findOrFail($id);
            $domain->restore();
            return response()->json(['status' => true, 'message' => __('phishing.domainRestoreSuccessfully')], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => __('locale.Error')], 502);
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
            return response()->json(['status' => true, 'message' => __('lms.TrainnigModuleWasDeletedSuccessfully'), 'course' => $course], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => __('locale.Error')], 502);
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
            $data = $data . '<button class="btn btn-secondary show-frame trash-domain" type="button" data-bs-toggle="modal"
                    data-id="' . $row->id . '" onclick="ShowModalRestoreDomain(' . $row->id . ')" data-name="' . $row->name . '">
                                               <i class="fa-solid fa-undo"></i>
                </button>';

            $data = $data . ' <button class="btn btn-secondary show-frame trash-domain" type="button" data-bs-toggle="modal"
                    data-id="' . $row->id . '" onclick="ShowModalDeleteDomain(' . $row->id . ')" data-name="' . $row->name . '">
                                                <i class="fa-solid fa-trash"></i>
                </button>';

            $data = $data . '</div>';

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
            return response()->json(['status' => true, 'compliances' => $compliances], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => __('locale.Error')], 502);
        }
    }



    // ================ Survey Management ==================
    /**
     * Show course survey Results
     */
    public function showCourseSurvey($type, $id)
    {
        try {
            return $this->surveyService->showResults($type, $id);
        } catch (\Exception $e) {
            return back()->with('error', 'Survey not found or access denied.');
        }
    }

    /**
     * *survy ajax
     *
     *  */

    public function surveyAjax($type, $id)
    {
        try {
            return $this->surveyService->getSurveyAjax($type, $id);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Survey not found or access denied.'], 404);
        }
    }

    /**
     * showSurveyResponseDetails
     */
    public function showSurveyResponseDetails($responseId, $type, $id)
    {
        try {
            return $this->surveyService->showSurveyResponseDetails($responseId, $type, $id);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Survey response not found'
            ], 404);
        }
    }

    /**
     * Delete survey response (optional - for admin users)
     */
    public function deleteSurveyResponse($responseId)
    {
        try {
            $response = SurveyResponse::findOrFail($responseId);
            $response->questionAnswers()->delete();
            $response->delete();
            return response()->json([
                'success' => true,
                'message' => 'Survey response deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to delete survey response: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete survey response'
            ], 500);
        }
    }
}
