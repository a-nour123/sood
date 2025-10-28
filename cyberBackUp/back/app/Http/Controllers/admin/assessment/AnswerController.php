<?php

namespace App\Http\Controllers\admin\assessment;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\assessment\AnswerRequest;
use App\Models\Assessment;
use App\Models\AssessmentAnswer;
use App\Models\AssessmentQuestion;
use App\Models\Asset;
use App\Models\AssetGroup;
use App\Models\ControlMaturity;
use App\Models\FrameworkControl;
use App\Models\Impact;
use App\Models\Likelihood;
use App\Models\Question;
use App\Models\ScoringMethod;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use function GuzzleHttp\json_encode;

class AnswerController extends Controller
{
    public function index(Question $question)
    {

        $data = [];
        if ($question->question_logic) {
            $data['assessments'] = Assessment::query()->with('questions:id,question')->select(['id', 'name'])->get();
            $data['questions'] = Question::query()->select('id', 'question')->where('id', '!=', $question->id)->get();
        }
        if ($question->maturity_assessment) {
            $data['maturity_controls'] = ControlMaturity::query()->select(['id', 'name'])->get();
        }
        if ($question->risk_assessment) {
            $data['likelihoods'] = Likelihood::query()->select(['id', 'name'])->get();
            $data['impacts'] = Impact::query()->select(['id', 'name'])->get();
            $data['enabledUsers'] = User::query()->where('enabled', true)->get();
            $data['assetGroups'] = AssetGroup::all();
            $data['assets'] = Asset::select('id', 'name')->orderBy('id')->get();
            $data['tags'] = Tag::all();
            $data['migration_controls'] = FrameworkControl::query()->get(['id', 'short_name as name']);
            $data['riskScoringMethods'] = ScoringMethod::all();
        }

        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' => route('admin.assessment.index'), 'name' => __('locale.Assessments')], ['name' => __('locale.QuestionAnswers')]];
        return view('admin.content.assessment.answers.index', compact('breadcrumbs', 'question', 'data'));
    }


    public function data(Request $request, Question $question)
    {
        $answers = AssessmentAnswer::query()->with(['maturity_control:id,name', 'question:id,question'])->where('question_id', $question->id)->latest('id');
        $dataTable = DataTables::eloquent($answers)
            ->addIndexColumn()
            ->addColumn('actions', 'admin.content.assessment.answers.actions')
            ->rawColumns(['actions'])
            ->skipTotalRecords();
        if ($request->answer != '') {
            $dataTable = $dataTable->filter(function ($raw) use ($request) {
                if ($request->answer != '') {
                    $raw->where('answer', 'like', '%' . $request->answer . '%');
                }
            });
        }
        return $dataTable->toJson();
    }

    public function create(Question $question)
    {
        return view('admin.content.assessment.answers.create', compact('question'));
    }

    public function store(AnswerRequest $request, Question $question)
    {
        $basic_data = $request->safe()->except(['sub_questions']);
        $basic_data['assessment_id'] = $question->assessment_id;
        $sub_questions = $request->sub_questions ? $request->safe()->sub_questions : "";

        if (isset($basic_data['assets_ids'])) {
            $basic_data['assets_ids'] = json_encode($basic_data['assets_ids']);
        }
        if (isset($basic_data['tags_ids'])) {
            $basic_data['tags_ids'] = json_encode($basic_data['tags_ids']);
        }

       /* if (isset($basic_data['framework_controls_ids'])) {
            $basic_data['framework_controls_ids'] = json_encode($basic_data['framework_controls_ids'], true);
        }*/

        DB::beginTransaction();
        try {
            $answer = AssessmentAnswer::query()->create($basic_data);
            if ($sub_questions)
                $answer->sub_questions()->attach($sub_questions);
        } catch (\Throwable $exception) {
            DB::rollBack();

            return response()->json($exception->getMessage(), $exception->getCode());
        }
        DB::commit();
        return response()->json(__('assessment.answer Added Successfully'));

    }

    public function edit(Question $question, AssessmentAnswer $answer)
    {

        if ($question->risk_assessment)
            $answer->load(['scoring_method:id', 'likelihood:id', 'impact:id', 'owner:id']);
        if ($question->question_logic)
            $answer->load('sub_questions');
        if ($question->maturity_assessment)
            $answer->load('maturity_control');

        return response()->json($answer);
    }

    public function update(AnswerRequest $request, Question $question, AssessmentAnswer $answer)
    {

        $basic_data = $request->safe()->except(['sub_questions']);
        $basic_data['assessment_id'] = $question->assessment_id;

        $sub_questions = $request->sub_questions ? $request->safe()->sub_questions : "";

        if (isset($basic_data['assets_ids'])) {
            $basic_data['assets_ids'] = json_encode($basic_data['assets_ids']);
        }
        if (isset($basic_data['tags_ids'])) {
            $basic_data['tags_ids'] = json_encode($basic_data['tags_ids']);
        }

      /*  if (isset($basic_data['framework_controls_ids'])) {
            $basic_data['framework_controls_ids'] = json_encode($basic_data['framework_controls_ids'], true);
        }*/

        DB::beginTransaction();
        try {
            $answer->update($basic_data);
            if ($sub_questions)
                $answer->sub_questions()->sync($sub_questions);
        } catch (\Throwable $exception) {
            DB::rollBack();
            return response()->json($exception->getMessage(), $exception->getCode());
        }
        DB::commit();
        return response()->json(__('assessment.answer Updated Successfully'));

     }

    public function destroy($question_id, AssessmentAnswer $answer)
    {

        try {
            $answer->sub_questions()->detach();
            $answer->delete();
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
        return response()->json(__('assessment.Answer Deleted Successfully'));
    }
}
