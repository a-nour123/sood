<?php


namespace App\Repositories\User;

use App\Interfaces\User\LMSQuizInterface;
use App\Models\AwarenessSurvey;
use App\Models\FrameworkControl;
use App\Models\LMSAnswer;
use App\Models\LMSCourse;
use App\Models\LMSLevel;
use App\Models\LMSOption;
use App\Models\LMSQuestion;
use App\Models\LMSTrainingModule;
use App\Models\LMSTrainingModuleCertificate;
use App\Models\PhishingDomains;
use App\Models\Role;
use App\Models\User;
use App\Services\SurveyService;
use App\Services\UserDashboardStatsService;
use App\Traits\CertificateGenerationTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class LMSQuizRepository implements LMSQuizInterface
{
    use CertificateGenerationTrait;

    protected $surveyService;
    protected $dashboardStatsService;
    public function __construct(UserDashboardStatsService $dashboardStatsService, SurveyService $surveyService)
    {
        $this->dashboardStatsService = $dashboardStatsService;
        $this->surveyService = $surveyService;
    }

    public function index()
    {
        $breadcrumbs = [
            ['link' => route('user.lms.training.modules.userDashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('lms.Training_modules')]
        ];

        $user = auth()->user();
        $userId = $user->id;

        // Get user's assigned training modules
        $user_trainings = User::with([
            'trainingModules' => function ($query) {
                $query->wherePivot('is_delivered', 1);
            }
        ])->find($userId);

        $assigned_training_ids = $user_trainings->trainingModules->pluck('id')->toArray();

        // Get all courses with their levels and training modules
        $courses = LMSCourse::with([
            'levels' => function ($query) {
                $query->orderBy('order');
            },
            'levels.training_modules' => function ($query) use ($assigned_training_ids) {
                $query->where(function ($q) use ($assigned_training_ids) {
                    $q->whereIn('id', $assigned_training_ids)
                        ->orWhere('training_type', 'public');
                })
                    ->orderBy('order')
                    ->withCount(['questions', 'statements']);
            }
        ])
            ->whereHas('levels.training_modules', function ($query) use ($assigned_training_ids) {
                $query->where(function ($q) use ($assigned_training_ids) {
                    $q->whereIn('id', $assigned_training_ids)
                        ->orWhere('training_type', 'public');
                });
            })
            ->get();

        // Process each course and its training modules
        foreach ($courses as $course) {
            foreach ($course->levels as $level) {
                $previousLevelCompleted = $this->isPreviousLevelCompleted($course, $level, $userId);
                foreach ($level->training_modules as $index => $module) {
                    $this->processTrainingModule($module, $level, $index, $userId, $previousLevelCompleted);
                }
            }
        }

        return view('user.quiz.list', compact('courses', 'breadcrumbs'));
    }

    /**
     * Process individual training module to set access permissions and status
     */
    private function processTrainingModule($module, $level, $moduleIndex, $userId, $previousLevelCompleted)
    {
        // Get user's pivot data for this module
        $pivot = optional($module->users()->where('user_id', $userId)->first())->pivot;

        if (!$pivot) {
            $module->is_passed = false;
            $module->is_failed = false;
            $module->is_overdue = false;
            $module->remaining_attempts = $module->count_of_entering_exam;
        } else {
            $module->is_passed = $pivot->passed == 1;
            $module->is_failed = $pivot->passed == 0 && $pivot->count_of_entering_exam > 0;
            $module->is_overdue = $module->training_type == 'campaign' &&
                $pivot->passed == 0 &&
                now()->greaterThan($pivot->created_at->addDays($pivot->days_until_due));
            $module->remaining_attempts = $module->count_of_entering_exam - $pivot->count_of_entering_exam;
        }

        // Determine if user can access this module
        $module->can_access = $this->canAccessModule($module, $level, $moduleIndex, $userId, $previousLevelCompleted);

        $surveyResponse = auth()
            ->user()
            ->trainingSurveyResponses->where(
                'respondent_id',
                $module->id,
            )
            ->first();

        // Check if user has failed before (attempted but not passed)
        $hasFailedBefore = $pivot && $pivot->count_of_entering_exam > 0 && $pivot->passed == 0;

        // Check if survey is required and completed
        $surveyConditionMet = true; // Default to true for first attempt
        if ($hasFailedBefore) {
            // If user has failed before, survey must be completed for subsequent attempts
            $surveyConditionMet = $surveyResponse && $surveyResponse->is_completed;
        }

        // Can attempt only if can access and other conditions are met
        $module->can_attempt = $module->can_access &&
            !$module->is_passed &&
            !$module->is_overdue &&
            $surveyConditionMet &&
            $module->remaining_attempts > 0;

        // Set access reason for UI feedback
        $module->access_reason = $this->getAccessReason($module, $level, $moduleIndex, $userId, $previousLevelCompleted);
    }

    /**
     * Check if user can access a specific training module
     */
    private function canAccessModule($module, $level, $moduleIndex, $userId, $previousLevelCompleted)
    {
        // Public modules can always be accessed
        if ($module->training_type == 'public') {
            return true;
        }

        // Campaign modules need sequential completion
        if ($module->training_type == 'campaign') {
            // First, check if previous level is completed
            if (!$previousLevelCompleted) {
                return false;
            }

            // Then check if previous training module in same level is completed
            if ($moduleIndex > 0) {
                $previousModule = $level->training_modules[$moduleIndex - 1];
                $previousModulePivot = optional($previousModule->users()->where('user_id', $userId)->first())->pivot;

                if (!$previousModulePivot || $previousModulePivot->passed != 1) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Get reason why user can/cannot access module
     */
    private function getAccessReason($module, $level, $moduleIndex, $userId, $previousLevelCompleted)
    {
        if ($module->training_type == 'public') {
            return __('lms.Public training - Always accessible');
        }

        if ($module->training_type == 'campaign') {
            if (!$previousLevelCompleted) {
                return __('lms.Complete previous level first');
            }

            if ($moduleIndex > 0) {
                $previousModule = $level->training_modules[$moduleIndex - 1];
                $previousModulePivot = optional($previousModule->users()->where('user_id', $userId)->first())->pivot;

                if (!$previousModulePivot || $previousModulePivot->passed != 1) {
                    return __('lms.Complete previous training module first');
                }
            }
        }

        if ($module->is_passed) {
            return __('lms.Training completed successfully');
        }

        if ($module->is_overdue) {
            return __('lms.Training is overdue');
        }

        if ($module->remaining_attempts <= 0) {
            return __('lms.No remaining attempts');
        }

        return __('lms.Ready to start');
    }

    /**
     * Check if previous level is completed
     */
    private function isPreviousLevelCompleted($course, $currentLevel, $userId)
    {
        // Get all levels for this course ordered by order
        $levels = $course->levels->sortBy('order');
        $currentLevelIndex = $levels->search(function ($level) use ($currentLevel) {
            return $level->id === $currentLevel->id;
        });

        // If this is the first level, it's accessible
        if ($currentLevelIndex === 0) {
            return true;
        }

        // Check if previous level is completed
        $previousLevel = $levels[$currentLevelIndex - 1];

        // Get user's completion status for previous level
        $userLevel = $previousLevel->users()->where('user_id', $userId)->first();

        if (!$userLevel) {
            return false;
        }

        return $userLevel->pivot->completed == 1;
    }


    public function getQuiz($id)
    {
        try {
            $breadcrumbs = [
                ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
                ['link' => route('user.lms.training.modules.index'), 'name' => __('lms.Training_modules')],
                ['name' => __('lms.Quizes')]
            ];

            $train_data = LMSTrainingModule::with('questions.options', 'statements', 'level.course')->find($id);

            if (!$train_data) {
                return redirect()->route('user.lms.training.modules.index')->with('error', 'Training module not found.');
            }

            // Check if user can access this training
            $course = $train_data->level->course;
            $level = $train_data->level;
            $userId = auth()->id();

            // Get module index in level
            $moduleIndex = $level->training_modules()->orderBy('order')->pluck('id')->search($id);
            $previousLevelCompleted = $this->isPreviousLevelCompleted($course, $level, $userId);

            // Create a temporary module object to check access
            $tempModule = clone $train_data;
            $this->processTrainingModule($tempModule, $level, $moduleIndex, $userId, $previousLevelCompleted);

            if (!$tempModule->can_access) {
                return redirect()->route('user.lms.training.modules.index')
                    ->with('error', 'You cannot access this training: ' . $tempModule->access_reason);
            }

            // Check if user has completed the training and needs to do survey
            $userModule = $train_data->users()->where('user_id', $userId)->first();
            if ($userModule && $userModule->pivot->passed == 1 && !$userModule->pivot->survey_completed) {
                $survey = $train_data->survey ? $train_data->survey->load('survyQuestions') : AwarenessSurvey::with('survyQuestions')->first();
                return redirect()->route('user.lms.training.modules.surveys.show', [
                    'survey' => $survey,
                    'type' => 'training_module',
                    'id' => $train_data->id
                ])->with('info', 'Please complete the survey to finish your training.');
            }

            // Check if user has already passed and completed survey - prevent re-entry
            if ($userModule && $userModule->pivot->passed == 1 && $userModule->pivot->survey_completed) {
                return redirect()->route('user.lms.training.modules.index')
                    ->with('info', 'You have already completed this training and survey.');
            }

            // Set exam in progress session
            session()->put(['exam_in_progress' => $userId . '_' . $id]);

            // Get user's previous answers
            $totalQuestions = $train_data->questions->pluck('id')->toArray();
            $userAnswers = LMSAnswer::where('user_id', $userId)
                ->whereIn('question_id', $totalQuestions)
                ->get()
                ->keyBy('question_id');

            // Build pages with user's previous answers
            $pages = [];

            // Add questions to pages
            foreach ($train_data->questions as $question) {
                $userAnswer = $userAnswers->get($question->id);

                $pages[$question->page_number] = [
                    'type' => 'question',
                    'content' => $question,
                    'options' => $question->options,
                    'user_answer' => $userAnswer,
                    'has_previous_answer' => $userAnswer ? true : false,
                    'previous_option_id' => $userAnswer ? $userAnswer->option_id : null,
                    'previous_true_false' => $userAnswer ? $userAnswer->true_or_false : null,
                    'is_previous_correct' => $userAnswer ? $userAnswer->is_correct : null
                ];
            }

            // Add statements to pages
            foreach ($train_data->statements as $statement) {
                if (!isset($pages[$statement->page_number])) {
                    $pages[$statement->page_number] = [
                        'type' => 'statement',
                        'content' => $statement
                    ];
                }
            }

            // Sort pages by page number
            ksort($pages);

            // Calculate last answered index correctly
            $lastAnsweredIndex = 0;
            if ($userAnswers->count() > 0) {
                // Get the last answered question
                $lastAnswered = $userAnswers->sortByDesc('created_at')->first();
                if ($lastAnswered) {
                    $lastQuestion = LMSQuestion::find($lastAnswered->question_id);
                    if ($lastQuestion) {
                        // Find the index in the sorted pages array
                        $pageNumbers = array_keys($pages);
                        $questionPageNumber = $lastQuestion->page_number;

                        // Find the position of this page number in our sorted array
                        $pageIndex = array_search($questionPageNumber, $pageNumbers);

                        if ($pageIndex !== false) {
                            // Start from the next page after the last answered
                            $lastAnsweredIndex = min($pageIndex + 1, count($pages) - 1);
                        }
                    }
                }
            }

            return view('user.quiz.content', get_defined_vars());
        } catch (\Exception $e) {
            \Log::error('Quiz Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    // other functions still not changed
    public function storeAnswer(Request $request)
    {
        try {
            $trainingModule = LMSTrainingModule::find($request->training_module_id);
            if ($request->pageType == 'question') {
                $correct_option = LMSOption::where('question_id', $request->question_id)->where('is_correct', 1)->first();
                $corectQuestionTrueOrFalseAnswer = LMSQuestion::find($request->question_id);
                $is_correct = null;

                if ($request->question_type == 'multi_choise') {
                    if ($correct_option->id == $request->option_id) {
                        $is_correct = true;
                    } else {
                        $is_correct = false;
                    }
                } else {
                    if ($corectQuestionTrueOrFalseAnswer->correct_answer == $request->true_or_false) {
                        $is_correct = true;
                    } else {
                        $is_correct = false;
                    }
                }

                LMSAnswer::updateOrCreate([
                    'question_id' => $request->question_id,
                    'user_id' => auth()->id(),
                ], [
                    'question_id' => $request->question_id,
                    'user_id' => auth()->id(),
                    'option_id' => $request->option_id,
                    'is_correct' => $is_correct,
                    'true_or_false' => $request->true_or_false == 'true' ? 1 : 0,
                ]);
            }

            $this->updateScoreInEachStep($trainingModule);
            if ($request->finish_training === true || $request->finish_training === 'true' || $request->finish_training == 1) {
                return $this->finishTraining($trainingModule);
            }
            return response()->json([
                'success' => true,
                'message' => 'Answer saved successfully'
            ]);


        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Finish training and update level completion if needed
     */
    // private function finishTraining($trainingModule)
    // {
    //     $totalQuestions = LMSQuestion::where('training_module_id', $trainingModule->id)->pluck('id')->toArray();
    //     $totalQuestionsCount = count($totalQuestions);
    //     $userId = auth()->id();

    //     $userAnswers = LMSAnswer::where('user_id', $userId)
    //         ->whereIn('question_id', $totalQuestions)
    //         ->get();

    //     $correctAnswers = $userAnswers->where('is_correct', 1)->count();

    //     if ($totalQuestionsCount === 0) {
    //         session()->flash('quizMessage', __('lms.There are no questions in this training.'));
    //         session()->flash('quizResult', 0);
    //         return response()->json([
    //             'completeTrain' => true,
    //             'redirect' => route('user.lms.training.modules.index')
    //         ]);
    //     }

    //     $result = ($correctAnswers / $totalQuestionsCount) * 100;

    //     $currentUser = $trainingModule->users()->wherePivot('user_id', $userId)->first();
    //     if (!$currentUser) {
    //         $trainingModule->users()->attach($userId, [
    //             'score' => 0,
    //             'passed' => 0,
    //             'count_of_entering_exam' => 0,
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ]);
    //         $currentUser = $trainingModule->users()->wherePivot('user_id', $userId)->first();
    //     }

    //     $currentPivotData = $currentUser->pivot;
    //     $countOfEnteringExam = $currentPivotData->count_of_entering_exam + 1;

    //     if ($result >= $trainingModule->passing_score) {
    //         $message = __('lms.Congratulation ! You Have Success and your certificate is generated successfully. Your Score is');
    //         $trainingModule->users()
    //             ->updateExistingPivot($userId, [
    //                 'score' => $result,
    //                 'passed' => 1,
    //                 'count_of_entering_exam' => $countOfEnteringExam,
    //                 'completed_at' => now(),
    //             ]);
    //         $this->generateSingleCertificate($trainingModule, auth()->user());

    //         // Check if level should be marked as completed
    //         $this->checkAndUpdateLevelCompletion($trainingModule, $userId);

    //     } else {
    //         $message = __('lms.Sorry ! You Have Failed. Your Score is');
    //         $trainingModule->users()
    //             ->updateExistingPivot($userId, [
    //                 'score' => $result,
    //                 'completed_at' => now(),
    //                 'count_of_entering_exam' => $countOfEnteringExam,
    //             ]);
    //     }

    //     session()->forget('exam_in_progress');
    //     session()->flash('quizMessage', $message);
    //     session()->flash('quizResult', $result);

    //     $survey = $trainingModule->survey ? $trainingModule->survey->load('survyQuestions') : AwarenessSurvey::with('survyQuestions')->first();
    //     Log::info('Training completed for user ' . $userId . ' in module ' . $trainingModule->id);
    //     return response()->json([
    //         'completeTrain' => true,
    //         'redirect' => route('user.lms.training.modules.surveys.show', [
    //             'survey' => $survey,
    //             'type' => 'training_module',
    //             'id' => $trainingModule->id
    //         ]),
    //     ]);
    // }


    /**
     * Finish training and update level completion if needed
     */
    private function finishTraining($trainingModule)
    {
        $totalQuestions = LMSQuestion::where('training_module_id', $trainingModule->id)->pluck('id')->toArray();
        $totalQuestionsCount = count($totalQuestions);
        $userId = auth()->id();

        $userAnswers = LMSAnswer::where('user_id', $userId)
            ->whereIn('question_id', $totalQuestions)
            ->get();

        $correctAnswers = $userAnswers->where('is_correct', 1)->count();

        if ($totalQuestionsCount === 0) {
            session()->flash('quizMessage', __('lms.There are no questions in this training.'));
            session()->flash('quizResult', 0);
            return response()->json([
                'completeTrain' => true,
                'redirect' => route('user.lms.training.modules.index')
            ]);
        }

        $result = ($correctAnswers / $totalQuestionsCount) * 100;

        $currentUser = $trainingModule->users()->wherePivot('user_id', $userId)->first();
        if (!$currentUser) {
            $trainingModule->users()->attach($userId, [
                'score' => 0,
                'passed' => 0,
                'count_of_entering_exam' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $currentUser = $trainingModule->users()->wherePivot('user_id', $userId)->first();
        }

        $currentPivotData = $currentUser->pivot;
        $countOfEnteringExam = $currentPivotData->count_of_entering_exam + 1;

        // Check if user has already completed the survey
        $surveyResponse = auth()
            ->user()
            ->trainingSurveyResponses
            ->where('respondent_id', $trainingModule->id)
            ->first();

        $hasSurveyCompleted = $surveyResponse && $surveyResponse->is_completed;

        if ($result >= $trainingModule->passing_score) {
            // User passed
            $message = __('lms.Congratulation ! You Have Success and your certificate is generated successfully. Your Score is');
            $trainingModule->users()
                ->updateExistingPivot($userId, [
                    'score' => $result,
                    'passed' => 1,
                    'count_of_entering_exam' => $countOfEnteringExam,
                    'completed_at' => now(),
                ]);
            $this->generateSingleCertificate($trainingModule, auth()->user());

            // Check if level should be marked as completed
            $this->checkAndUpdateLevelCompletion($trainingModule, $userId);

            session()->forget('exam_in_progress');
            session()->flash('quizMessage', $message);
            session()->flash('quizResult', $result);

            // Check if survey already completed
            if (!$hasSurveyCompleted) {
                // First time passing - redirect to survey
                $survey = $trainingModule->survey ? $trainingModule->survey->load('survyQuestions') : AwarenessSurvey::with('survyQuestions')->first();
                Log::info('Training passed for user ' . $userId . ' in module ' . $trainingModule->id . ' - redirecting to survey');

                return response()->json([
                    'completeTrain' => true,
                    'redirect' => route('user.lms.training.modules.surveys.show', [
                        'survey' => $survey,
                        'type' => 'training_module',
                        'id' => $trainingModule->id
                    ]),
                ]);
            } else {
                // Survey already completed (passed after retry) - redirect to LMS index
                Log::info('Training passed for user ' . $userId . ' in module ' . $trainingModule->id . ' - survey already completed, redirecting to index');

                return response()->json([
                    'completeTrain' => true,
                    'redirect' => route('user.lms.training.modules.index')
                ]);
            }

        } else {
            // User failed
            $message = __('lms.Sorry ! You Have Failed. Your Score is');
            $trainingModule->users()
                ->updateExistingPivot($userId, [
                    'score' => $result,
                    'completed_at' => now(),
                    'count_of_entering_exam' => $countOfEnteringExam,
                ]);

            session()->forget('exam_in_progress');
            session()->flash('quizMessage', $message);
            session()->flash('quizResult', $result);

            // Check if user needs to complete survey
            if (!$hasSurveyCompleted) {
                // First time failing - redirect to survey
                $survey = $trainingModule->survey ? $trainingModule->survey->load('survyQuestions') : AwarenessSurvey::with('survyQuestions')->first();
                Log::info('Training failed for user ' . $userId . ' in module ' . $trainingModule->id . ' - redirecting to survey');

                return response()->json([
                    'completeTrain' => true,
                    'redirect' => route('user.lms.training.modules.surveys.show', [
                        'survey' => $survey,
                        'type' => 'training_module',
                        'id' => $trainingModule->id
                    ]),
                ]);
            } else {
                // Survey already completed - redirect to LMS index
                Log::info('Training failed for user ' . $userId . ' in module ' . $trainingModule->id . ' - survey already completed');

                return response()->json([
                    'completeTrain' => true,
                    'redirect' => route('user.lms.training.modules.index')
                ]);
            }
        }
    }

    /**
     * Check if level should be marked as completed after training completion
     */
    private function checkAndUpdateLevelCompletion($trainingModule, $userId)
    {
        $level = $trainingModule->level;

        // Get all training modules in this level
        $allModulesInLevel = $level->training_modules;

        // Check if all modules are completed by this user
        $allCompleted = true;
        foreach ($allModulesInLevel as $module) {
            $userModule = $module->users()->where('user_id', $userId)->first();
            if (!$userModule || $userModule->pivot->passed != 1) {
                $allCompleted = false;
                break;
            }
        }

        if ($allCompleted) {
            // Mark level as completed
            $level->users()->updateExistingPivot($userId, [
                'completed' => 1,
                'completed_at' => now(),
            ]);
        }
    }

    public function updateScoreInEachStep($trainingModule)
    {
        $currentScore = LMSAnswer::where('user_id', auth()->id())
            ->whereHas('question', function ($query) use ($trainingModule) {
                $query->where('training_module_id', $trainingModule->id);
            })
            ->where('is_correct', 1)
            ->count();

        $totalQuestionsCount = LMSQuestion::where('training_module_id', $trainingModule->id)->count();

        if ($totalQuestionsCount > 0) {
            $score = ($currentScore / $totalQuestionsCount) * 100;

            $pivotExists = $trainingModule->users()->wherePivot('user_id', auth()->id())->exists();
            if (!$pivotExists) {
                $trainingModule->users()->attach(auth()->id(), [
                    'score' => 0,
                    'passed' => 0,
                    'count_of_entering_exam' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $trainingModule->users()->updateExistingPivot(auth()->id(), [
                'score' => $score,
            ]);
        }
    }

    public function calcResultWhenRefresh($trainingModule)
    {
        $totalQuestions = LMSQuestion::where('training_module_id', $trainingModule->id)->pluck('id')->toArray();
        $totalQuestionsCount = count($totalQuestions);

        if ($totalQuestionsCount === 0) {
            session()->flash('quizMessage', __('lms.There are no questions in this training.'));
            session()->flash('quizResult', 0);
            return;
        }


        $userAnswers = LMSAnswer::where('user_id', auth()->id())
            ->whereIn('question_id', $totalQuestions)
            ->get();

        $correctAnswers = $userAnswers->where('is_correct', 1)->count();

        $result = ($correctAnswers / $totalQuestionsCount) * 100;

        $currentUser = $trainingModule->users()->wherePivot('user_id', auth()->id())->first();
        if (!$currentUser) {
            $trainingModule->users()->attach(auth()->id(), [
                'score' => 0,
                'passed' => 0,
                'count_of_entering_exam' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $currentUser = $trainingModule->users()->wherePivot('user_id', auth()->id())->first();
        }

        $pivot = $currentUser->pivot;
        $countOfEnteringExam = $pivot->count_of_entering_exam + 1;

        if ($result >= $trainingModule->passing_score) {
            $message = __('lms.Congratulation ! You Have Success. Your Score is');
            $trainingModule->users()
                ->updateExistingPivot(auth()->id(), [
                    'score' => $result,
                    'passed' => 1,
                    'count_of_entering_exam' => $countOfEnteringExam,
                    'completed_at' => now(),
                ]);
        } else {
            $message = __('lms.Sorry ! You Have Failed. Your Score is');
            $trainingModule->users()
                ->updateExistingPivot(auth()->id(), [
                    'score' => $result,
                    'completed_at' => now(),
                    'count_of_entering_exam' => $countOfEnteringExam,
                ]);
        }

        session()->forget('exam_in_progress');
        session()->flash('quizMessage', $message);
        session()->flash('quizResult', $result);
    }

    public function submitQuiz(Request $request)
    {
        try {
            $totalQuestions = LMSQuestion::where('training_module_id', $request->training_module_id)->pluck('id')->toArray();
            $totalQuestionsCount = count($totalQuestions);

            $userAnswers = LMSAnswer::where('user_id', auth()->id())
                ->whereIn('question_id', $totalQuestions)
                ->get();

            $correctAnswers = $userAnswers->where('is_correct', 1)->count();

            $result = ($correctAnswers / $totalQuestions) * 100;
            return view('result', compact('result'));
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // Certificate Functions
    public function generateSingleCertificate(LMSTrainingModule $lMSTrainingModule, User $user)
    {
        return $this->generateSingleCertificateForTraining($lMSTrainingModule, $user);
    }

    public function myCertificates()
    {
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('user.lms.training.modules.index'), 'name' => __('locale.LMS Training Modules')],
            ['name' => __('physicalCourses.Certificates')]
        ];

        $certificates = LMSTrainingModuleCertificate::with('training')
            ->where('user_id', auth()->id())
            ->orderBy('issued_at', 'desc')
            ->get();


        return view('user.quiz.certiificates', compact('certificates', 'breadcrumbs'));
    }

    public function listCertificatesAjax()
    {
        $certificates = LMSTrainingModuleCertificate::with(['training'])->orderBy('issued_at', 'desc');
        return DataTables::of($certificates)
            ->addIndexColumn()
            ->addColumn('user_name', function ($certificate) {
                return $certificate->user ? $certificate->user->name : 'N/A';
            })
            ->addColumn('train_name', function ($certificate) {
                return $certificate->training ? $certificate->training->name : 'N/A';
            })
            ->addColumn('user_email', function ($certificate) {
                return $certificate->user ? $certificate->user->email : 'N/A';
            })
            ->addColumn('certificate_id', function ($certificate) {
                return $certificate->certificate_id ?? 'N/A';
            })
            ->addColumn('grade_display', function ($certificate) {
                return $certificate->grade . '/' . $certificate->training->passing_score;
            })
            ->addColumn('percentage', function ($certificate) {
                if ($certificate->training->passing_score > 0) {
                    if ($certificate->grade >= $certificate->training->passing_score) {
                        return '100%';
                    }
                    return round(($certificate->grade / $certificate->training->passing_score) * 100, 2) . '%';
                }
                return '0%';
            })
            ->addColumn('issued_date', function ($certificate) {
                return $certificate->issued_at ? $certificate->issued_at : 'N/A';
            })
            ->addColumn('actions', function ($certificate) {
                if (!$certificate->user || !$certificate->training) {
                    return '<span class="text-muted">No actions available</span>';
                }

                $downloadUrl = route(
                    'user.lms.training.modules.download-certificate',
                    [$certificate->training->id, $certificate->user->id]
                );

                $viewUrl = route(
                    'user.lms.training.modules.view-certificate',
                    [$certificate->training->id, $certificate->user->id]
                );

                return '
            <div class="d-flex gap-1">
                <a href="' . $viewUrl . '" class="btn btn-sm btn-info" title="View Certificate" target="_blank">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="' . $downloadUrl . '" class="btn btn-sm btn-primary" title="Download Certificate">
                    <i class="fas fa-download"></i>
                </a>
                <button type="button" class="btn btn-sm btn-danger delete-certificate"
                        data-id="' . $certificate->id . '"
                        data-training-id="' . $certificate->training->id . '"
                        title="Delete Certificate">
                    <i class="fas fa-trash"></i>
                </button>
            </div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function viewCertificate(LMSTrainingModule $training, User $user)
    {
        return $this->viewTrainingCertificateRegenerate($training, $user);
    }

    public function downloadCertificate(LMSTrainingModule $training, User $user)
    {
        try {
            $certificate = LMSTrainingModuleCertificate::where('training_id', $training->id)
                ->where('user_id', $user->id)
                ->first();

            if (!$certificate || !Storage::exists('public/' . $certificate->certificate_file)) {
                return redirect()->back()->with('error', 'Certificate not found');
            }

            // Generate download filename
            $downloadName = $user->name . '_' . $training->name . '_Certificate.pdf';

            // Clean filename from special characters
            $downloadName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $downloadName);

            return Storage::download(
                'public/' . $certificate->certificate_file,
                $downloadName
            );

        } catch (\Exception $e) {
            Log::error('Certificate download failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error downloading certificate: ' . $e->getMessage());
        }
    }

    public function deleteCertificate(Request $request, LMSTrainingModule $training, LMSTrainingModuleCertificate $certificate)
    {
        try {
            if ($certificate->training_id !== $training->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Certificate does not belong to this training'
                ], 400);
            }

            // Delete file if exists
            if ($certificate->certificate_file && Storage::exists('public/' . $certificate->certificate_file)) {
                Storage::delete('public/' . $certificate->certificate_file);
            }

            $certificate->delete();

            return response()->json([
                'success' => true,
                'message' => 'Certificate deleted successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Certificate deletion failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting certificate: ' . $e->getMessage()
            ], 500);
        }
    }

    public function userDashboard()
    {
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.User Dashboard')]
        ];

        $dashboardData = $this->dashboardStatsService->getFormattedDashboardData();
        // dd($dashboardData);
        return view('user.quiz.dashboard', compact('dashboardData', 'breadcrumbs'));
    }

    // training Survey Methods
    public function showTrainingSurvey($surveyId, $type, $id)
    {
        try {
            return $this->surveyService->showSurvey($surveyId, $type, $id);
        } catch (\Exception $e) {
            return back()->with('error', 'Survey not found or access denied.');
        }
    }

    public function submitSurvey(Request $request, $surveyId, $type, $id)
    {
        try {
            $response = $this->surveyService->submitSurvey($request, $surveyId, $type, $id);
            if ($request->expectsJson() || $request->ajax()) {
                if ($response->getStatusCode() === 200) {
                    $responseData = json_decode($response->getContent(), true);

                    return response()->json([
                        'success' => true,
                        'message' => $request->has('save_draft') ?
                            __('physicalCourses.survey_draft_saved') :
                            __('physicalCourses.survey_submitted_successfully'),
                        'response_id' => $responseData['response_id'] ?? null,
                        'is_draft' => $request->has('save_draft'),
                        'redirect_url' => !$request->has('save_draft') ?
                            route('user.lms.training.modules.index') : null
                    ], 200);
                } else {
                    $errors = json_decode($response->getContent(), true);
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to submit survey',
                        'errors' => $errors['errors'] ?? ['error' => 'Failed to submit survey']
                    ], $response->getStatusCode());
                }
            } else {
                // Handle non-AJAX requests (fallback)
                if ($response->getStatusCode() === 200) {
                    if ($request->has('save_draft')) {
                        return back()->with('success', __('physicalCourses.survey_draft_saved'));
                    } else {
                        return redirect()->route('user.lms.training.modules.index')
                            ->with('success', __('physicalCourses.survey_submitted_successfully'));
                    }
                } else {
                    $errors = json_decode($response->getContent(), true);
                    return back()->withErrors($errors['errors'] ?? ['error' => 'Failed to submit survey']);
                }
            }
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to submit survey. Please try again.',
                    'error' => $e->getMessage()
                ], 500);
            } else {
                return back()->with('error', 'Failed to submit survey. Please try again.');
            }
        }
    }

}
