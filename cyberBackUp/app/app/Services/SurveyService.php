<?php

namespace App\Services;

use App\Models\Course;
use App\Models\CourseRequest;
use App\Models\CourseCertificate;
use App\Models\CourseGrade;
use App\Models\LMSTrainingModule;
use App\Models\LMSTrainingModuleCertificate;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\AwarenessSurvey;
use App\Models\SurveyResponse;
use App\Models\SurveyQuestionAnswer;
use App\Models\SurveyQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SurveyService
{
    /**
     * Show the survey to user for a specific course or training module.
     *
     * @param int $surveyId
     * @param string $type
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function showSurvey($surveyId, $type, $id)
    {
        $survey = AwarenessSurvey::with('survyQuestions')->findOrFail($surveyId);
        if ($type === 'course') {
            $respondent = Course::findOrFail($id);
        } elseif ($type === 'training_module') {
            $respondent = LMSTrainingModule::findOrFail($id);
        } else {
            return response()->json(['error' => 'Invalid respondent type'], 400);
        }

        $existingResponse = SurveyResponse::where([
            'survey_id' => $surveyId,
            'user_id' => Auth::id(),
            'respondent_type' => $type,
            'respondent_id' => $id
        ])->first();

        $previousAnswers = [];
        if ($existingResponse) {
            $previousAnswers = $existingResponse->questionAnswers()
                ->pluck('answer_text', 'question_id')
                ->toArray();
        }

        if ($type === 'course') {
            $breadcrumbs = [
                ['link' => route('admin.physical-courses.courses.index'), 'name' => __('locale.Dashboard')],
                ['name' => __('physicalCourses.Survy')],
            ];

            return view('physicalCourses.student.survy', compact('survey', 'existingResponse', 'respondent', 'type', 'id', 'previousAnswers', 'breadcrumbs'));
        } else {
            $breadcrumbs = [
                ['link' => route('user.lms.training.modules.userDashboard'), 'name' => __('locale.Dashboard')],
                ['name' => __('lms.Survy')],
            ];

            return view('user.quiz.survy', compact('survey', 'existingResponse', 'respondent', 'type', 'id', 'previousAnswers', 'breadcrumbs'));
        }
    }

    /**
     * Submit the survey answers.
     *
     * @param Request $request
     * @param int $surveyId
     * @param string $type
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitSurvey(Request $request, $surveyId, $type, $id)
    {
        $survey = AwarenessSurvey::with('survyQuestions')->findOrFail($surveyId);
        $rules = [
            'answers' => 'required|array',
        ];

        if (!$request->has('save_draft')) {
            $questionIds = $survey->survyQuestions->pluck('id')->toArray();
            foreach ($questionIds as $questionId) {
                $rules["answers.{$questionId}"] = 'required|string';
            }

            $rules['answers'] = [
                'required',
                'array',
                function ($attribute, $value, $fail) use ($questionIds) {
                    $answeredQuestions = array_keys($value);
                    $missingQuestions = array_diff($questionIds, $answeredQuestions);

                    if (!empty($missingQuestions)) {
                        $fail('All questions must be answered before submitting the survey.');
                    }
                },
            ];
        } else {
            $rules['answers.*'] = 'nullable|string';
        }

        $validator = Validator::make($request->all(), $rules, [
            'answers.*.required' => 'This question is required.',
            'answers.required' => 'Please answer all questions before submitting.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $response = SurveyResponse::updateOrCreate(
                [
                    'survey_id' => $surveyId,
                    'user_id' => Auth::id(),
                    'respondent_type' => $type,
                    'respondent_id' => $id
                ],
                [
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'is_completed' => !$request->has('save_draft')
                ]
            );

            foreach ($request->answers as $questionId => $answer) {
                $question = SurveyQuestion::find($questionId);
                if (!$question)
                    continue;

                $answerData = [
                    'response_id' => $response->id,
                    'question_id' => $questionId,
                    'is_draft' => $request->has('save_draft')
                ];

                if ($question->answer_type === 'multiple_choice') {
                    $answerData['selected_option'] = $answer;
                } else {
                    $answerData['answer_text'] = $answer;
                }

                SurveyQuestionAnswer::updateOrCreate(
                    [
                        'response_id' => $response->id,
                        'question_id' => $questionId
                    ],
                    $answerData
                );
            }

            if (!$request->has('save_draft')) {
                $response->markAsCompleted();
                if ($type === 'training_module') {
                    $trainingModule = LMSTrainingModule::findOrFail($id);
                    // Mark survey as completed
                    $trainingModule->users()->updateExistingPivot(auth()->id(), [
                        'survey_completed' => 1,
                    ]);

                    $userModule = $trainingModule->users()->where('user_id', auth()->id())->first();
                    if ($userModule && $userModule->pivot->passed == 1) {
                        // Get user's training result to show success message
                        $message = __('lms.Congratulation ! You Have Success and your certificate is generated successfully. Your Score is');
                        session()->flash('quizMessage', $message);
                        session()->flash('quizResult', $userModule->pivot->score);
                    }elseif($userModule && $userModule->pivot->passed == 0) {
                        // User did not pass, show message accordingly
                        $message = __('lms.You did not pass the training module. Please try again.');
                        session()->flash('quizMessage', $message);
                        session()->flash('quizResult', $userModule->pivot->score);
                    } else {
                        // No specific result, just a general success message
                        session()->flash('quizMessage', __('lms.Survey submitted successfully'));
                    }
                    DB::commit();
                    // Redirect to training modules index with success message
                    return response()->json([
                        'message' => $request->has('save_draft') ? 'Draft saved successfully' : 'Survey submitted successfully',
                        'response_id' => $response->id,
                        'redirect_url' => route('user.lms.training.modules.index'),
                    ]);

                }
            }

            DB::commit();

            return response()->json([
                'message' => $request->has('save_draft') ? 'Draft saved successfully' : 'Survey submitted successfully',
                'response_id' => $response->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Survey submission failed: ' . $e->getMessage(), [
                'survey_id' => $surveyId,
                'user_id' => Auth::id(),
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Failed to save survey',
                'message' => 'An unexpected error occurred while saving the survey'
            ], 500);
        }
    }

    /**
     * Show the survey results for a specific course or training module.
     *
     * @param string|null $type
     * @param int|null $id
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function showResults($type = null, $id = null)
    {
        $survey = null;
        $course = null;
        $trainingModule = null;

        if ($type === 'course' && $id) {
            $course = Course::with('survey.survyQuestions')->findOrFail($id);
            $survey = $course->survey;
        } elseif ($type === 'training_module' && $id) {
            $trainingModule = LMSTrainingModule::with('survey.survyQuestions')->findOrFail($id);
            $survey = $trainingModule->survey;
        }

        if (!$survey) {
            $survey = AwarenessSurvey::with('survyQuestions')->first();
        }

        $query = SurveyResponse::where('survey_id', $survey->id)
            // ->where('is_completed', true)
            ->with(['questionAnswers.question', 'user']);

        if ($type && $id) {
            $query->where('respondent_type', $type)
                ->where('respondent_id', $id);
        }

        $responses = $query->get();
        $statistics = $this->analyzeResponses($responses, $survey, $type, $id);

        $questionChartData = $this->prepareQuestionChartData($statistics);

        // dd($statistics);
        if ($type === 'course') {
            $breadcrumbs = [
                ['link' => route('admin.physical-courses.courses.index'), 'name' => __('locale.Dashboard')],
                ['name' => __('physicalCourses.Survy')],
            ];
            return view('physicalCourses.survey-results', compact('survey', 'questionChartData', 'course', 'responses', 'statistics', 'type', 'id', 'breadcrumbs'));
        } elseif ($type === 'training_module') {
            $breadcrumbs = [
                ['link' => route('admin.lms.courses.index'), 'name' => __('locale.Courses')],
                ['name' => __('lms.Courses')],
            ];
            return view('user.quiz.survey-results', compact('survey', 'questionChartData', 'trainingModule', 'responses', 'statistics', 'type', 'id', 'breadcrumbs'));
        } else {
            return response()->json(['error' => 'Invalid respondent type'], 400);
        }
    }

    /**
     * Analyze survey responses and generate statistics.
     *
     * @param \Illuminate\Support\Collection $responses
     * @param AwarenessSurvey|null $survey
     * @param string|null $type
     * @param int|null $id
     * @return array
     */
    private function analyzeResponses($responses, $survey = null, $type = null, $id = null)
    {
        $statistics = [];
        $questions = $survey->survyQuestions ?? collect([]);
        foreach ($questions as $question) {
            $questionStats = [
                'question' => $question->question,
                'question_type' => $question->answer_type ?? 'multiple_choice',
                'total_responses' => 0,
                'answers' => []
            ];

            $answers = $responses->flatMap(function ($response) use ($question) {
                return $response->questionAnswers->where('question_id', $question->id);
            });

            $questionStats['total_responses'] = $answers->count();
            // $optionCounts = $answers->groupBy('selected_option')->map->count();
            $optionCounts = $answers->groupBy('answer_text')->map->count();
            foreach (['A', 'B', 'C', 'D', 'E'] as $option) {
                $optionField = "option_" . strtoupper($option);
                if (!empty($question->$optionField)) {
                    $count = $optionCounts->get($option, 0);
                    $percentage = $questionStats['total_responses'] > 0
                        ? round(($count / $questionStats['total_responses']) * 100, 2)
                        : 0;

                    $questionStats['answers'][$option] = [
                        'text' => $question->$optionField,
                        'count' => $count,
                        'percentage' => $percentage
                    ];
                }
            }
            $statistics[] = $questionStats;
        }

        $query = SurveyResponse::where('survey_id', $survey->id);
        if ($type && $id) {
            $query->where('respondent_type', $type)->where('respondent_id', $id);
        }
        $totalResponses = (clone $query)->count();
        $completedResponses = (clone $query)->where('is_completed', true)->count();
        $draftResponses = (clone $query)->where('is_completed', false)->count();

        $statistics['total_responses'] = $totalResponses;
        $statistics['completed_responses'] = $completedResponses;
        $statistics['draft_responses'] = $draftResponses;
        $statistics['completion_rate'] = $totalResponses > 0
            ? round(($completedResponses / $totalResponses) * 100, 2)
            : 0;
        return $statistics;
    }

    /**
     * Show the survey response details for a specific course or training module.
     *
     * @param int $responseId
     * @param string|null $type
     * @param int|null $id
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function showSurveyResponseDetails($responseId, $type = null, $id = null)
    {
        $response = SurveyResponse::with(['questionAnswers.question', 'user'])
            ->where('id', $responseId)
            ->where('respondent_type', $type)
            ->where('respondent_id', $id)
            ->firstOrFail();

        if ($type === 'course') {
            $breadcrumbs = [
                ['link' => route('admin.physical-courses.courses.index'), 'name' => __('locale.Dashboard')],
                ['name' => __('physicalCourses.Survy details')],
            ];
            return view('physicalCourses.survey-response-details', compact('response', 'type', 'id', 'breadcrumbs'));
        } elseif ($type === 'training_module') {
            $breadcrumbs = [
                ['link' => route('admin.physical-courses.courses.index'), 'name' => __('locale.Dashboard')],
                ['name' => __('physicalCourses.Survy')],
            ];
            return view('user.quiz.survey-response-details', compact('response', 'type', 'id','breadcrumbs'));
        } else {
            return response()->json(['error' => 'Invalid respondent type'], 400);
        }
    }

    /**
     * Prepare data for question answers charts.
     *
     * @param array $statistics
     * @return array
     */
    private function prepareQuestionChartData($statistics)
    {
        $questionChartData = [];

        foreach ($statistics as $key => $stat) {
            if (is_string($key))
                continue;

            if (is_array($stat) && isset($stat['answers']) && isset($stat['question'])) {
                $labels = [];
                $data = [];
                $colors = [];

                $colorPalette = [
                    '#667eea',
                    '#764ba2',
                    '#4ecdc4',
                    '#44a08d',
                    '#ffa500',
                    '#ff6b6b',
                    '#45b7d1',
                    '#96c93d',
                    '#f093fb',
                    '#f5576c'
                ];

                $colorIndex = 0;
                foreach ($stat['answers'] as $option => $details) {
                    $labels[] = $details['text'];
                    $data[] = $details['count'];
                    $colors[] = $colorPalette[$colorIndex % count($colorPalette)];
                    $colorIndex++;
                }

                $questionChartData[] = [
                    'question' => $stat['question'],
                    'total_responses' => $stat['total_responses'],
                    'labels' => $labels,
                    'data' => $data,
                    'colors' => $colors,
                ];
            }
        }

        return $questionChartData;
    }


    /**
     * Get survey responses for AJAX requests.
     *
     * @param string|null $type
     * @param int|null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSurveyAjax($type = null, $id = null)
    {
        $query = SurveyResponse::with(['survey', 'user'])
            ->when($type, function ($query) use ($type) {
                return $query->where('respondent_type', $type);
            })
            ->when($id, function ($query) use ($id) {
                return $query->where('respondent_id', $id);
            })
            ->orderBy('created_at', 'desc');

        return datatables()->eloquent($query)
            ->addIndexColumn()
            ->addColumn('user', function ($response) {
                if ($response->user) {
                    return [
                        'name' => $response->user->name,
                        'email' => $response->user->email,
                        'id' => $response->user->id
                    ];
                }
                return [
                    'name' => 'N/A',
                    'email' => 'N/A',
                    'id' => null
                ];
            })
            ->addColumn('survey', function ($response) {
                return $response->survey ? $response->survey->title : 'N/A';
            })
            ->addColumn('status', function ($response) {
                return $response->is_completed ? 'Completed' : 'Draft';
            })
            ->addColumn('created_at', function ($response) {
                return $response->created_at ? $response->created_at->format('Y-m-d H:i:s') : null;
            })
            ->addColumn('updated_at', function ($response) {
                return $response->updated_at ? $response->updated_at->format('Y-m-d H:i:s') : null;
            })
            ->addColumn('completion_rate', function ($response) {
                // Calculate completion rate based on answered questions
                $totalQuestions = $response->survey ? $response->survey->survyQuestions->count() : 0;
                $answeredQuestions = $response->questionAnswers->count();

                if ($totalQuestions > 0) {
                    return round(($answeredQuestions / $totalQuestions) * 100, 2);
                }
                return 0;
            })
            ->addColumn('actions', function ($response) {
                $actions = '';
                if ($response->respondent_type && $response->respondent_id) {

                    if($response->respondent_type === 'course') {
                        $viewUrl = route('admin.physical-courses.courses.survey.response.details', [
                            'responseId' => $response->id,
                            'type' => $response->respondent_type,
                            'id' => $response->respondent_id
                        ]);
                    } elseif ($response->respondent_type === 'training_module') {
                        $viewUrl = route('admin.lms.survey.response.details', [
                            'responseId' => $response->id,
                            'type' => $response->respondent_type,
                            'id' => $response->respondent_id
                        ]);
                    } else {
                        return '<span class="text-muted">No actions</span>';
                    }

                    $actions .= '<a href="' . $viewUrl . '" class="btn btn-primary btn-sm  mx-1" data-bs-toggle="tooltip" title="View Response Details">
                                <i class="fas fa-eye"></i>
                            </a>';
                }
                $actions .= '<button type="button" class="btn btn-danger btn-sm" onclick="deleteSurveyResponse(' . $response->id . ')" data-bs-toggle="tooltip" title="Delete Response">
                                <i class="fas fa-trash"></i>
                            </button>';

                return $actions ?: '<span class="text-muted">No actions</span>';
            })
            ->rawColumns(['actions', 'status'])
            ->make(true);
    }

}
