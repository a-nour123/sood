<?php

namespace App\Http\Controllers\admin\assessment;

use App\Enums\QuestionTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\assessment\QuestionRequest;
use App\Http\Requests\ImportQuestionRequest;
use App\Models\Assessment;
use App\Models\AssessmentQuestion;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Action;
use App\Models\User;
use App\Events\QuestionCreated;
use App\Events\QuestionUpdated;
use App\Events\QuestionDeleted;

class QuestionController extends Controller
{
    public function data(Request $request)
    {
        $questions = Question::query()->whereHas('assessments', function ($q) use ($request) {
            return $q->where('assessment_id', $request['assessment_id']);
        })->select('id', 'question', 'answer_type', 'file_attachment', 'question_logic', 'risk_assessment', 'compliance_assessment', 'maturity_assessment','nda_assessment')->withCount('answers')->latest('id');
        return DataTables::eloquent($questions)
            ->addIndexColumn()
            ->addColumn('actions', 'admin.content.assessment.questions.includes.actions')
            ->addColumn('answer_type', function ($raw) {
                // return QuestionTypeEnum::getQuestionStatus($raw->answer_type);
                if ($raw->answer_type == 1) {
                    return 'Single Select';
                } elseif ($raw->answer_type == 2) {
                    return 'Multi Select';
                } else {
                    return 'Fill in the Blank';
                }
            })
            ->rawColumns(['actions'])
            ->skipTotalRecords()
            ->toJson();
    }

    public function fetch_questions_from_assessment(Request $request)
    {
        if ($request->assessment_id) {

            $data =  Assessment::find($request->assessment_id)->questions;
        } else {
            $data = Question::all();
        }
        return $data;
    }

    public function store(QuestionRequest $request)
    {

        $basicData = $request->safe()->except('assessment_id', 'question_en', 'question_ar');
        // Handle multilingual question field
        $basicData['question'] = [
            'en' => $request->question_en,
            'ar' => $request->question_ar
        ];

        DB::beginTransaction();
        try {
            $assessment = Assessment::query()->find($request->safe()->assessment_id);
            $question = Question::query()->create($basicData);
            $assessment->questions()->attach($question);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), $e->getCode());
        }
        DB::commit();
        event(new QuestionCreated($question));
        $message = __('assessment.A New Question of Assessment Added : The question is') . ' "' . ($question->question ?? __('locale.[No Question]')) . '" ' . __('locale.CreatedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
        write_log(1, auth()->id(), $message, 'Creating Questions');
        return response()->json(__('assessment.Question Added Successfully'));
    }

    public function edit($id)
    {
        $question = Question::with('control')->findOrFail($id);
        // Get the raw question column (JSON string)
        $rawQuestion = $question->getRawOriginal('question');
        // Optionally, decode it for frontend use
        $question['question_edit'] = json_decode($rawQuestion, true);
        return response()->json($question);
    }

    public function update(QuestionRequest $request, Question $question)
    {
        $basicData = $request->safe()->except('assessment_id', 'question_en', 'question_ar');
        // Handle multilingual question field
        $basicData['question'] = [
            'en' => $request->question_en,
            'ar' => $request->question_ar
        ];
        

        DB::beginTransaction();
        try {
            $question->update($basicData);
            if (!$question->question_logic) {
                $question->answers()->each(function ($raw) {
                    $raw->sub_questions()->detach();
                });
                $question->answers()->update(['sub_question_assessment_id' => null]);
            }
            if (!$question->maturity_assessment) {
                $question->answers()->update(['maturity_control_id' => null]);
            }
            if (!$question->compliance_assessment) {
                $question->answers()->update(['fail_control' => null]);
            }
            if (!$question->risk_assessment) {
                $question->answers()->update([
                    'submit_risk' => 0,
                    'risk_subject' => null,
                    'risk_scoring_method_id' => null,
                    'likelihood_id' => null,
                    'impact_id' => null,
                    'owner_id' => null,
                    'assets_ids' => null,
                    'framework_controls_ids' => null,
                    'tags_ids' => null,
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), $e->getCode());
        }
        DB::commit();
        event(new QuestionUpdated($question));
        $message = __('assessment.A Question of Assessment updated : The question is') . ' "' . ($question->question ?? __('locale.[No Question]')) . '" ' . __('locale.UpdatedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
        write_log(1, auth()->id(), $message, 'Updating Questions');
        return response()->json('Question Updated Successfully');
    }

    public function destroy(Request $request, Question $question)
    {
        $question->assessments()->detach($request->assessment_id);
        $related_asset =  AssessmentQuestion::where('question_id', $question->id)->count();
        if (!$related_asset) {
            $question->delete();
            event(new QuestionDeleted($question));
            $message = __('assessment.A Question of Assessment : The question is') . ' "' . ($question->question ?? __('locale.[No Question]')) . '" ' . __('locale.DeletedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
            write_log(1, auth()->id(), $message, 'deleting Questions');
        }
    }

    public function importQuestions(ImportQuestionRequest $request)
    {
        $assessment = Assessment::query()->find($request->safe()->assessment_id);
        $assessmentQuestions = $assessment->questions->pluck('id')->toArray();
        foreach ($request->safe()->question_ids as $question_id) {
            if (!in_array($question_id, $assessmentQuestions)) {
                $assessment->questions()->attach($question_id);
            }
        }
    }
    public function notificationsSettingsQuestions()
    {

        //defining the breadcrumbs that will be shown in page
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.assessment.index'), 'name' => __('locale.Questions')],
            ['name' => __('locale.NotificationsSettings')]
        ];
        $users = User::select('id', 'name')->where('enabled', true)->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [59, 60, 61, 62, 63, 64];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            59 => ['Name'],
            60 => ['Name'],
            61 => ['Name'],
            62 => ['Question', 'Control'],
            63 => ['Question', 'Control'],
            64 => ['Question', 'Control'],
        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [
            62 => ['Control-Owner' => __('assessment.ControlOwner')],
            63 => ['Control-Owner' => __('assessment.ControlOwner')],
            64 => ['Control-Owner' => __('assessment.ControlOwner')],

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