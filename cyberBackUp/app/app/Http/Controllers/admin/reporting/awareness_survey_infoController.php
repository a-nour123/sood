<?php

namespace App\Http\Controllers\admin\reporting;

use Carbon\Carbon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SurveyQuestion;
use App\Models\AwarenessSurvey;
use App\Models\AnswerQuestionSurvey;
use Illuminate\Support\Facades\DB;


class awareness_survey_infoController extends Controller
{
    public function AwarenessSurveyInfo()
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
         ['link' => "javascript:void(0)", 'name' => __('locale.Reporting')],
          ['name' => __('locale.AwarenessSurvey')]];
        $surveys = AwarenessSurvey::all();
        return view(
            'admin.content.reporting.awareness-survey',
            compact('breadcrumbs', 'surveys')
        );
    }

    public function AwarenessSurveyDetail(Request $request, $id)
    {
        $questions = SurveyQuestion::where('survey_id', $id)->get();
        $sumQuestions = SurveyQuestion::where('survey_id', $id)->count();
        $questionIds = $questions->pluck('id');
        $countAnswersIsDraftOrNot1 = AnswerQuestionSurvey::whereIn('question_id', $questionIds)
            ->whereIn('draft', [0, 1])
            ->distinct()
            ->count('user_id');
        $countAnswersIsDraftOrNot2 = AnswerQuestionSurvey::whereIn('question_id', $questionIds)
            ->whereIn('draft', [0, 1])
            ->distinct()
            ->count('user_idOut');
        $AnswersIsDraftOrNot = $countAnswersIsDraftOrNot1 + $countAnswersIsDraftOrNot2;

        $countAnswersNotDraft1 = AnswerQuestionSurvey::whereIn('question_id', $questionIds)
            ->where('draft', 0)
            ->distinct()
            ->count('user_id');
        $countAnswersNotDraft2 = AnswerQuestionSurvey::whereIn('question_id', $questionIds)
            ->where('draft', 0)
            ->distinct()
            ->count('user_idOut');

        $AnswersNotDraft = $countAnswersNotDraft1 + $countAnswersNotDraft2;

        $countAnswersIsDraft1 = AnswerQuestionSurvey::whereIn('question_id', $questionIds)
            ->where('draft', 1)
            ->distinct()
            ->count('user_id');
        $countAnswersIsDraft2 = AnswerQuestionSurvey::whereIn('question_id', $questionIds)
            ->where('draft', 1)
            ->distinct()
            ->count('user_idOut');

        $AnswersIsDraft =  $countAnswersIsDraft1 + $countAnswersIsDraft2;

        $totalquestionofsurvey = SurveyQuestion::where('survey_id', $id)->count('id');

        $userID1 = DB::table('users')
            ->join('answer_question_surveys', 'users.id', '=', 'answer_question_surveys.user_id')
            ->join('survey_questions', 'survey_questions.id', '=', 'answer_question_surveys.question_id')
            ->where('survey_questions.survey_id', $id)
            ->pluck('users.id');

        $userID2 = DB::table('user_out_side_cybers')
            ->join('answer_question_surveys', 'user_out_side_cybers.id', '=', 'answer_question_surveys.user_idOut')
            ->join('survey_questions', 'survey_questions.id', '=', 'answer_question_surveys.question_id')
            ->where('survey_questions.survey_id', $id)
            ->pluck('user_out_side_cybers.id');

        $data = [
            'AnswersIsDraftOrNot' => $AnswersIsDraftOrNot,
            'AnswersNotDraft' => $AnswersNotDraft,
            'AnswersIsDraft' => $AnswersIsDraft,
        ];

        $userResponses = [];
        $existingUserNames = [];

        foreach ($userID1 as $userID) {
            $sumQuestions = SurveyQuestion::where('survey_id', $id)->count();
            $answered = AnswerQuestionSurvey::whereIn('question_id', $questionIds)
                ->where('user_id', $userID)
                ->where('draft', 0)
                ->count('question_id');

            $remaining = $totalquestionofsurvey - $answered;
            $response = AnswerQuestionSurvey::whereIn('question_id', $questionIds)
                ->select('created_at')
                ->where('user_id', $userID)
                ->where('draft', 0)
                ->distinct()
                ->get()
                ->pluck('created_at')
                ->last();

            $responseDate = Carbon::parse($response)->format('Y-m-d H:i:s');
            $response = $responseDate;
            $userName = DB::table('users')->where('id', $userID)->pluck('name');

            if (!in_array($userName, $existingUserNames)) {
                $userResponses[] = [
                    'userID' => $userID,
                    'userName' => $userName,
                    'type'=>'Inside cyber Mode',
                    'sumQuestions' => $sumQuestions,
                    'answered' => $answered,
                    'remaining' => $remaining,
                    'response' => $response,
                ];
                $existingUserNames[] = $userName;
            }
        }

        foreach ($userID2 as $userID) {
            $sumQuestions = SurveyQuestion::where('survey_id', $id)->count();
            $answered = AnswerQuestionSurvey::whereIn('question_id', $questionIds)
                ->where('user_idOut', $userID)
                ->where('draft', 0)
                ->count('question_id');

            $remaining = $totalquestionofsurvey - $answered;
            $response = AnswerQuestionSurvey::whereIn('question_id', $questionIds)
                ->select('created_at')
                ->where('user_idOut', $userID)
                ->where('draft', 0)
                ->distinct()
                ->get()
                ->pluck('created_at')
                ->last();

            $responseDate = Carbon::parse($response)->format('Y-m-d H:i:s');
            $response = $responseDate;

            $userNames = DB::table('user_out_side_cybers')->where('id', $userID)->pluck('username');

            foreach ($userNames as $userName) {
                $existingUserNames[] = $userName;
                $userResponses[] = [
                    'userID' => $userID,
                    'userName' => $userName,
                    'type'=>'Outside cyber Mode',
                    'sumQuestions' => $sumQuestions,
                    'answered' => $answered,
                    'remaining' => $remaining,
                    'response' => $response,
                ];
            }
        }

        $userResponses = array_map('unserialize', array_unique(array_map('serialize', $userResponses)));

        $data['userResponses'] = $userResponses;
        if ($request->ajax()) {
            return response()->json($data);
        }

        return view('admin.content.reporting.awareness-survey')->with('data', $data);
    }
}
