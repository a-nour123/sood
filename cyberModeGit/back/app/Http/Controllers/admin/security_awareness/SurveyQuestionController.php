<?php

namespace App\Http\Controllers\admin\security_awareness;
use App\Models\SurveyQuestion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
use App\Models\Comment;
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
use App\Traits\AssetTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;


class SurveyQuestionController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request)
    {
                // validation of insert survey
                $rules = [
                    'questions' => ['required', 'array'],
                    'questions.*.question' => ['required', 'string'],
                    'questions.*.option_A' => ['required', 'string'],
                    // 'questions.*.answer_type' => ['required', 'string'],
                    'questions.*.option_B' => ['required', 'string'],
                    'questions.*.option_C' => ['required', 'string'],
                    // 'questions.*.answer' => ['required', 'array'],
                    // 'questions.*.answer.*' => ['required', 'string'],
                ];
                
                $validator = Validator::make($request->all(), $rules);

                // Check if there is any validation errors
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
                            $List_Classes = $request->questions;
                            foreach ($List_Classes as $List_Class) {
                            $My_Classes = new SurveyQuestion();
                            $My_Classes->question = $List_Class['question'];
                            $My_Classes->answer_type = $List_Class['answer_type'] ?? 1;
                            // $answerType = $request->filled('answer_type') ? $request->answer_type : 1;

                            $My_Classes->option_A = $List_Class['option_A'];
                            $My_Classes->option_B = $List_Class['option_B'];
                            $My_Classes->option_C = $List_Class['option_C'];
                            $My_Classes->option_D = $List_Class['option_D'];
                            $My_Classes->option_E = $List_Class['option_E'];
                            // $My_Classes->answer = implode(',', $List_Class['answer'] ?? []);
                            $My_Classes->survey_id = $request->survey_id;
                            $My_Classes->save();
                    $survey = AwarenessSurvey::find($request->survey_id);
                    $message = __('survey.NewQuestionsAddedToSurvey') . ' "' . ($survey->name ?? __('locale.[No Name]')) . '" ' .  __('locale.By') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
                    write_log($survey->id, auth()->id(), $message, 'Survey Adding Question');
                }
                        } catch (\Throwable $th) {
                        DB::rollBack();
        
                        $response = array(
                            'status' => false,
                            'errors' => [],
                    'message' => $th->getMessage(),
                            // 'message' => __('locale.Error'),
                        );
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
        // 
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request , $id)
    {
        $questionSurvey = SurveyQuestion::findorFail($id);
        // return $questionSurvey;
        //         // validation of insert survey
                $rules = [
                    'question' => ['required', 'string'],
                    'option_A' => ['required', 'string'],
                    // 'answer_type' => ['required', 'string'],
                    'option_B' => ['required', 'string'],
                    'option_C' => ['required', 'string'],
                    // 'questions.*.answer' => ['required', 'array'],
                    // 'questions.*.answer.*' => ['required', 'string'],
                ];
                
                $validator = Validator::make($request->all(), $rules);
                

        
                // Check if there is any validation errors
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

                                    // update data
                                        $questionSurvey->update([
                                        'question' => $request->question,
                                        'answer_type' =>$request->answer_type,
                                        'option_A' => $request->option_A,
                                        'option_B' =>$request->option_B,
                                        'option_C' => $request->option_C,
                                        'option_D' => $request->option_D,
                                        'option_E' => $request->option_E,
                                        // 'answer' => implode(',', $request->answer ?? []),
                                        // 'answer' => $request->answer
                                        ]);
                $survey = AwarenessSurvey::find($questionSurvey->survey_id);
                $message = __('survey.QuestionsUpdatedOnSurvey') . ' "' . ($survey->name ?? __('locale.[No Name]')) . '" ' .  __('locale.By') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
                write_log($survey->id, auth()->id(), $message, 'Survey Updating Question');
                                    } catch (\Throwable $th) {
                                    DB::rollBack();
                    
                                    $response = array(
                                        'status' => false,
                                        'errors' => [],
                                        // 'message' => $th->getMessage(),
                                        'message' => __('locale.Error'),
                                    );
                                    return response()->json($response, 502);
                                }
                            }
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
    public function questionDelete($id){
        $questionSurvey = SurveyQuestion::findorFail($id);
        $survey = AwarenessSurvey::find($questionSurvey->survey_id);
        $questionSurvey->delete();
        $message = __('survey.QuestionsDeletedOnSurvey') . ' "' . ($survey->name ?? __('locale.[No Name]')) . '" ' .  __('locale.By') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
        write_log($survey->id, auth()->id(), $message, 'Survey Deleting Question');
        $response = array(
            'status' => false,
            'errors' => [],
            // 'message' => $th->getMessage(),
            'message' => '',
        );
    }
    public function questionEdit($id){
       
        $questionSurvey = SurveyQuestion::findorFail($id);
        return Response()->json($questionSurvey);

        return view('admin.content.awareness_survey.edit_question_survey',compact('questionSurvey'));
        return response()->json(array('success' => true, 'html'=>$returnHTML));
    }
   
    public function GetDataSurveyQuestion(Request $request,$id)
    {
        if ($request->ajax()) {
            $results = SurveyQuestion::where('survey_id', $id)
                ->with('answers') // Ensure answers is loaded
                ->get();
        
            return datatables()->of($results)
                ->addColumn('action', function ($row) {
                    // Check if answers exists and is not empty
                    if (!$row->answers || $row->answers->isEmpty()) { 
                        $buttons = '';
        
                        if (auth()->user()->hasPermission('awareness-survey.delete_questions')) {
                            $buttons .= '<a href="javascript:void(0);" id="delete-compnay" 
                                onClick="deleteFunc(' . $row->id . ')" data-toggle="tooltip" 
                                data-original-title="Delete" 
                                class="btn btn-sm delete btn btn-danger">'. __('locale.Delete') .'</a> ';
                        }
        
                        if (auth()->user()->hasPermission('awareness-survey.edit_questions')) {
                            $buttons .= '<a href="javascript:void(0)" class="btn btn-sm btn-warning edit_question_btn"
                                data-url="' . route('admin.awarness_survey.questionEdit', $row->id) . '" data-id="' . $row->id . '" 
                                data-bs-toggle="modal" data-bs-target="#edit_question' . $row->id . '">'. __('locale.Edit') .'</a>';
                        }
        
                        return $buttons;
                    } else {
                        return '------';
                    }
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        
    
        $question = SurveyQuestion::where('survey_id', $id)->get();
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.awarness_survey.GetDataSurvey'), 'name' => __('locale.Survey')],
            ['name' => __('locale.QuestionSurvey')]
        ];
        if (auth()->user()->hasPermission('awareness-survey.list_questions')) {
            return view('admin.content.awareness_survey.survey_question', compact('breadcrumbs', 'question'));
        }else{
            abort(403, 'Unauthorized action.');
        }
    }

}
