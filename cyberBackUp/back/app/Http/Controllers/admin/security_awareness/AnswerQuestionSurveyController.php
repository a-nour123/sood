<?php

namespace App\Http\Controllers\admin\security_awareness;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SurveyQuestion;
use App\Http\Requests\surveyQuestionRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Exports\RisksExport;
use App\Models\Asset;
use App\Models\Privacy;
use App\Models\AssetGroup;
use App\Models\AssetValue;
use App\Models\Category;
use App\Mail\SurveySendEmailTest;
use App\Models\CloseReason;
use App\Models\File;
use App\Models\Framework;
use App\Models\FrameworkControl;
use App\Models\FrameworkControlMapping;
use App\Models\Impact;
use App\Models\Likelihood;
use App\Models\Location;
use App\Models\MgmtReview;
use App\Models\Mitigation;
use App\Models\MitigationAcceptUser;
use App\Models\MitigationEffort;
use App\Models\NextStep;
use App\Models\PlanningStrategy;
use App\Models\Project;
use App\Models\ResidualRiskScoringHistory;
use App\Models\Review;
use App\Models\AnswerQuestionSurvey;
use App\Models\AwarenessSurvey;
use App\Models\ScoringMethod;
use App\Models\Setting;
use App\Models\Source;
use App\Models\Status;
use App\Models\DocumentStatus;
use App\Models\Tag;
use App\Models\Taggable;
use App\Models\Team;
use App\Models\Technology;
use App\Models\ThreatGrouping;
use App\Models\User;
use App\Models\UserOutSideCyber;
use App\Traits\AssetTrait;
use App\Rules\TotalPercentage;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class AnswerQuestionSurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $questions = SurveyQuestion::all();
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.awarness_survey.GetDataSurvey'), 'name' => __('locale.Survey')],
            ['name' => __('locale.QuestionSurvey')]
        ];
        return view('admin.content.awareness_survey.answer_question_survey', compact('breadcrumbs', 'questions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // the function of bar that depends on increase the bar when the user check the answer
    public function checkboxSubmit(Request $request)
    {


        $answer_percentage = SurveyQuestion::join('awareness_surveys', 'survey_questions.survey_id', '=', 'awareness_surveys.id')
            ->where('survey_questions.id', $request->question_id)
            ->pluck('answer_percentage')
            ->first();


        $answers_count = count($request->answer);
        $questions_count = count($request->question_id);
        $answer_percentage = ($answers_count / $questions_count) * 100;
        $response = [
            'status' => false,
            'errors' => "err_percentage",
            'message' => __('survey.AnsweredPercentageError')  . $answer_percentage . '%'
        ];
        return response()->json($answer_percentage, 200);
    }


    public function store(Request $request)
    {
        $survey_id = $request->survey_id;

        // Delete existing answers for the survey
        DB::table('answer_question_surveys')
            ->whereIn('question_id', function ($query) use ($survey_id) {
                $query->select('id')
                    ->from('survey_questions')
                    ->where('survey_id', $survey_id);
            })
            ->where('user_id', Auth::user()->id) // Add this condition
            ->delete();

        // Get the percentage number and answer percentage of the survey
        $percentage_number = SurveyQuestion::join('awareness_surveys', 'survey_questions.survey_id', '=', 'awareness_surveys.id')
            ->where('survey_questions.id', $request->question_id)
            ->pluck('percentage_number')
            ->first();

        $answer_percentage = SurveyQuestion::join('awareness_surveys', 'survey_questions.survey_id', '=', 'awareness_surveys.id')
            ->where('survey_questions.id', $request->question_id)
            ->pluck('answer_percentage')
            ->first();

        $answer_percentage = SurveyQuestion::join('awareness_surveys', 'survey_questions.survey_id', '=', 'awareness_surveys.id')
            ->where('survey_questions.id', $request->question_id)
            ->pluck('answer_percentage')
            ->first();
        $all_questions_mandatory = SurveyQuestion::join('awareness_surveys', 'survey_questions.survey_id', '=', 'awareness_surveys.id')
            ->where('survey_questions.id', $request->question_id)
            ->pluck('all_questions_mandatory')
            ->first();

        $rules = [];

        $val_empty = $request->answer;
        if (empty($val_empty) && $request->draft == 1) {
            $response = [
                'status' => false,
                'errors' => "err_answerEmpty",
                'message' => __('survey.YouAreNotChooseAnyAnswerBeforeSubmit')
            ];
            return response()->json($response, 200);
        }


        if ($request->draft != 1 && $all_questions_mandatory === 0) {
            $answer_val = $request->answer;
            $answers_man_count = count($answer_val);
            $questions_count = count($request->question_id);
            if ($answers_man_count < $questions_count) {
                $response = [
                    'status' => false,
                    'errors' => "err_AnswerlessThanQuestios",
                    'message' => __('survey.SorryAllQuestionAreMandatoryBeforeSubmit')
                ];
                return response()->json($response, 200);
            }
        }
        $validator = Validator::make($request->all(), $rules);

        //  Checkif there is any validation errors

        if ($request->draft != 1 && $answer_percentage == 1) {
            $answers_count = count($request->answer);
            $questions_count = count($request->question_id);
            $answer_percentage = ($answers_count / $questions_count) * 100;
            if ($answer_percentage < $percentage_number) {
                $response = [
                    'status' => false,
                    'errors' => "err_percentage",
                    'message' => __('survey.AnsweredPercentageError')  . $percentage_number . '%'
                ];
                return response()->json($response, 200);
            }
        }

        if ($all_questions_mandatory === 0) {
            $rules['answer'] = ['required'];
        }
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('survey.ThereWasAProblemAddingSurvey')
                    . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {



            try {
                // Save the answers
                foreach ($request->answer as $questionId => $answer) {
                    if (is_array($answer)) {
                        $answerString = implode(',', $answer);
                    } else {
                        $answerString = $answer;
                    }

                    AnswerQuestionSurvey::updateOrCreate(
                        [
                            'question_id' => $questionId,
                            'user_id' => Auth::user()->id,
                        ],
                        [
                            'survey_id'=>$survey_id,
                            'answer' => $answerString,
                            'draft' => $request->draft,
                        ]
                    );
                }

                $response = [
                    'status' => true,
                    'message' => __('survey.SurveyAddedSuccessfully'),
                ];
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = [
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                ];
                return response()->json($response, 502);
            }
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $user_survey = SurveyQuestion::where('survey_id', $id)->get();
        $draftorsend = AnswerQuestionSurvey::whereIn('question_id', $user_survey->pluck('id'))
            ->pluck('draft')
            ->map(function ($value) {
                return (int) $value;
            })
            ->where(auth()->user()->id === 'user_id')
            ->implode('');
        $survey = AwarenessSurvey::find($id);
        $survey = AwarenessSurvey::all();

        $questions = SurveyQuestion::where('survey_id', $id)->get();

        $answers = AnswerQuestionSurvey::whereIn('question_id', $questions->pluck('id')->toArray())
            ->where('user_id', auth()->user()->id)->get();

        $survey_id = $id;
        $answer = [];

        foreach ($questions as $question) {
            $questionAnswers = $answers->where('question_id', $question->id)->pluck('answer');
            $answer[$question->id] = $questionAnswers->toArray();
        }

        foreach ($answer as $questionId => $answersArray) {
            $answer[$questionId] = explode(',', implode(',', $answersArray));
        }

        $percentage = AwarenessSurvey::pluck('answer_percentage');

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Survey')],
            ['name' => __('locale.QuestionSurvey')]
        ];

        return view(
            'admin.content.awareness_survey.answer_question_survey',
            compact('breadcrumbs', 'questions', 'answer', 'percentage', 'survey_id', 'draftorsend')
        );
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    // this function return the user from online to site with hash id 
    public function GetExam($id)
    {
        $decodedId = base64_decode($id);
        $user_survey = SurveyQuestion::where('survey_id', $decodedId)->get();
        $draftorsend = AnswerQuestionSurvey::whereIn('question_id', $user_survey->pluck('id'))
        ->where('user_id', auth()->user()->id)
        ->pluck('draft')
        ->map(function ($value) {
            return (int) $value;
        })
        ->whenEmpty(function ($collection) {
            return collect(['1']);
        })
        ->implode('');
    

        $drafttosend = $draftorsend ?? 'default value';
        // dd($draftorsend);

        $survey = AwarenessSurvey::find($decodedId);
        $survey = AwarenessSurvey::all();

        $questions = SurveyQuestion::where('survey_id', $decodedId)->get();

        $answers = AnswerQuestionSurvey::whereIn('question_id', $questions->pluck('id')->toArray())
            ->where('user_id', auth()->user()->id)->get();

        $survey_id = $decodedId;
        $answer = [];

        foreach ($questions as $question) {
            $questionAnswers = $answers->where('question_id', $question->id)->pluck('answer');
            $answer[$question->id] = $questionAnswers->toArray();
        }

        foreach ($answer as $questionId => $answersArray) {
            $answer[$questionId] = explode(',', implode(',', $answersArray));
        }

        $percentage = AwarenessSurvey::pluck('answer_percentage');

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.awarness_survey.GetDataSurvey'), 'name' => __('locale.Survey')],
            ['name' => __('locale.QuestionSurvey')]
        ];

        return view(
            'admin.content.awareness_survey.answer_question_survey',
            compact('breadcrumbs', 'questions', 'answer', 'percentage', 'survey_id', 'draftorsend')
        );
    }

    // this function return the user from gmail or system with id not hash
    public function GetSurveyFromMail($id)
    {
        // $decodedId = base64_decode($id);
        $user_survey = SurveyQuestion::where('survey_id', $id)->get();
        $draftorsend = AnswerQuestionSurvey::whereIn('question_id', $user_survey->pluck('id'))
        ->where('user_id', auth()->user()->id)
        ->pluck('draft')
        ->map(function ($value) {
            return (int) $value;
        })
        ->whenEmpty(function ($collection) {
            return collect(['1']);
        })
        ->implode('');
    

        $drafttosend = $draftorsend ?? 'default value';
        // dd($draftorsend);

        $survey = AwarenessSurvey::find($id);
        $survey = AwarenessSurvey::all();

        $questions = SurveyQuestion::where('survey_id', $id)->get();

        $answers = AnswerQuestionSurvey::whereIn('question_id', $questions->pluck('id')->toArray())
            ->where('user_id', auth()->user()->id)->get();

        $survey_id = $id;
        $answer = [];

        foreach ($questions as $question) {
            $questionAnswers = $answers->where('question_id', $question->id)->pluck('answer');
            $answer[$question->id] = $questionAnswers->toArray();
        }

        foreach ($answer as $questionId => $answersArray) {
            $answer[$questionId] = explode(',', implode(',', $answersArray));
        }

        $percentage = AwarenessSurvey::pluck('answer_percentage');

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.awarness_survey.GetDataSurvey'), 'name' => __('locale.Survey')],
            ['name' => __('locale.QuestionSurvey')]
        ];

        return view(
            'admin.content.awareness_survey.answer_question_survey',
            compact('breadcrumbs', 'questions', 'answer', 'percentage', 'survey_id', 'draftorsend')
        );
    }
    public function SaveOutSideAnswer(Request $request)
    {


        // Get the percentage number and answer percentage of the survey
        $percentage_number = SurveyQuestion::join('awareness_surveys', 'survey_questions.survey_id', '=', 'awareness_surveys.id')
            ->where('survey_questions.id', $request->question_id)
            ->pluck('percentage_number')
            ->first();

        $answer_percentage = SurveyQuestion::join('awareness_surveys', 'survey_questions.survey_id', '=', 'awareness_surveys.id')
            ->where('survey_questions.id', $request->question_id)
            ->pluck('answer_percentage')
            ->first();

        $answer_percentage = SurveyQuestion::join('awareness_surveys', 'survey_questions.survey_id', '=', 'awareness_surveys.id')
            ->where('survey_questions.id', $request->question_id)
            ->pluck('answer_percentage')
            ->first();
        $all_questions_mandatory = SurveyQuestion::join('awareness_surveys', 'survey_questions.survey_id', '=', 'awareness_surveys.id')
            ->where('survey_questions.id', $request->question_id)
            ->pluck('all_questions_mandatory')
            ->first();

        $rules = [];

        $val_empty = $request->answer;
        if (empty($val_empty) && $request->draft == 1) {
            $response = [
                'status' => false,
                'errors' => "err_answerEmpty",
                'message' => __('survey.YouAreNotChooseAnyAnswerBeforeSubmit')
            ];
            return response()->json($response, 200);
        }


        if ($request->draft != 1 && $all_questions_mandatory === 0) {
            $answer_val = $request->answer;
            $answers_man_count = count($answer_val);
            $questions_count = count($request->question_id);
            if ($answers_man_count < $questions_count) {
                $response = [
                    'status' => false,
                    'errors' => "err_AnswerlessThanQuestios",
                    'message' => __('survey.SorryAllQuestionAreMandatoryBeforeSubmit')
                ];
                return response()->json($response, 200);
            }
        }
        $validator = Validator::make($request->all(), $rules);

        //  Checkif there is any validation errors

        if ($request->draft != 1 && $answer_percentage == 1) {
            $answers_count = count($request->answer);
            $questions_count = count($request->question_id);
            $answer_percentage = ($answers_count / $questions_count) * 100;
            if ($answer_percentage < $percentage_number) {
                $response = [
                    'status' => false,
                    'errors' => "err_percentage",
                    'message' => __('survey.AnsweredPercentageError')  . $percentage_number . '%'
                ];
                return response()->json($response, 200);
            }
        }

        if ($all_questions_mandatory === 0) {
            $rules['answer'] = ['required'];
        }
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('survey.ThereWasAProblemAddingSurvey')
                    . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {

            $userOutSideCyber = UserOutSideCyber::firstOrCreate(
                ['email' => $request->email],
                ['username' => $request->username]
            );
            
            $survey_id = $request->survey_id;
 
            try {
                // Save the answers
                foreach ($request->answer as $questionId => $answer) {
                    if (is_array($answer)) {
                        $answerString = implode(',', $answer);
                    } else {
                        $answerString = $answer;
                    }

                    // Create a new user record in UserOutSideCyber table
                   

                    $data = [
                        'question_id' => $questionId,
                        'answer' => $answerString,
                        'user_id' => null,
                        'user_idOut' => $userOutSideCyber->id,
                        'survey_id'=>$survey_id 
                    ];
                    AnswerQuestionSurvey::create($data);
                }

                $response = [
                    'status' => true,
                    // 'message' => __('survey.SurveyAddedSuccessfully'),
                    'popup_message' => __('survey.AnswersSentSuccessfully'),
                ];
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $errorMessage = $th->getMessage();
                $errorLine = $th->getLine();

                $response = [
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error') . ' - Line ' . $errorLine . ': ' . $errorMessage,
                ];
                return response()->json($response, 502);
            }
        }
    }
    public function Examoutside($id)
    {

        $decodedId = base64_decode($id);
         $user_survey = SurveyQuestion::where('survey_id', $decodedId)->get();
        // Check if $questions collection is empty
        if ($user_survey->isEmpty()) {
            // Security Awareness not found, handle the error
            abort(403, 'The Questions of this awareness survey still do not exist.');
        }
        $draftorsend = AnswerQuestionSurvey::whereIn('question_id', $user_survey->pluck('id'))
            // ->where('user_id', auth()->user()->id) // Add this condition to filter by the authenticated user
            ->pluck('draft')
            ->map(function ($value) {
                return (int) $value;
            })
            ->implode('');

        $drafttosend = $draftorsend ?? 'default value';
        // dd($draftorsend);

        $survey = AwarenessSurvey::find($decodedId);
 
        $questions = SurveyQuestion::where('survey_id', $decodedId)->get();

        $answers = AnswerQuestionSurvey::whereIn('question_id', $questions->pluck('id')->toArray())
            ->get();

        $survey_id = $decodedId;
        $answer = [];

        foreach ($questions as $question) {
            $questionAnswers = $answers->where('question_id', $question->id)->pluck('answer');
            $answer[$question->id] = $questionAnswers->toArray();
        }

        foreach ($answer as $questionId => $answersArray) {
            $answer[$questionId] = explode(',', implode(',', $answersArray));
        }

        $percentage = AwarenessSurvey::pluck('answer_percentage');

        $emails = User::select('email')->get();
        $emailExistWithAnswer = UserOutSideCyber::join('answer_question_surveys', 'user_out_side_cybers.id', '=', 'answer_question_surveys.user_idOut')
        ->where('answer_question_surveys.survey_id', $decodedId)
        ->whereColumn('answer_question_surveys.user_idOut', 'user_out_side_cybers.id')
        ->select('user_out_side_cybers.email')
        ->get();

 

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.awarness_survey.GetDataSurvey'), 'name' => __('locale.Survey')],
            ['name' => __('locale.QuestionSurvey')]
        ];

        return view(
            'admin.content.awareness_survey.examoutside',
            compact('breadcrumbs', 'questions', 'answer', 'percentage', 'survey_id', 'draftorsend','emails','emailExistWithAnswer','survey')
        );
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
