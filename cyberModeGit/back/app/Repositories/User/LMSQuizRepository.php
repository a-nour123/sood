<?php


namespace App\Repositories\User;

use App\Interfaces\User\LMSQuizInterface;
use App\Models\FrameworkControl;
use App\Models\LMSAnswer;
use App\Models\LMSCourse;
use App\Models\LMSLevel;
use App\Models\LMSOption;
use App\Models\LMSQuestion;
use App\Models\LMSTrainingModule;
use App\Models\PhishingDomains;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class LMSQuizRepository implements LMSQuizInterface
{
    public function index()
    {
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('lms.Training_modules')]
        ];

        $user_trainings = User::with(['trainingModules' => function ($query) {
            $query->wherePivot('is_delivered', 1);
        }])->find(auth()->id());

        // $user_trainings = User::with('trainingModules')->find(auth()->id());
        $trainings_ids = $user_trainings->trainingModules->pluck('id')->toArray();
        $training_modules = LMSTrainingModule::with('level.course')
                ->withCount('questions','statements')
                ->whereIn('id',$trainings_ids)
                ->orderBy('created_at','desc')
                ->paginate(10);

        // return view('user.quiz.list', get_defined_vars());

        foreach ($training_modules as $module) {
            $pivot = $module->users()->where('user_id', auth()->id())->first()->pivot;
            $module->is_passed = $pivot->passed == 1;
            $module->is_failed = $pivot->passed == 0 && $pivot->count_of_entering_exam > 0;
            $module->is_overdue = $pivot->passed == 0 && now()->greaterThan($pivot->created_at->addDays($pivot->days_until_due));
        }

        return view('user.quiz.list', get_defined_vars());
    }

    public function getQuiz($id)
    {
        try {
            $breadcrumbs = [
                ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
                ['link' => route('user.lms.training.modules.index'), 'name' => __('lms.Training_modules')],
                ['name' => __('lms.Quizes')]

            ];
            $train_data = LMSTrainingModule::with('questions.options','statements')->find($id);
            if (session()->has('exam_in_progress') && session()->get('exam_in_progress') == auth()->id().'_'.$id){
               $this->calcResultWhenRefresh($train_data);
               return redirect()->route('user.lms.training.modules.index')->with('error', 'You cannot re-enter the exam.');
            }
            session()->put(['exam_in_progress' => auth()->id().'_'.$id]);


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
            return view('user.quiz.content', get_defined_vars());
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }

    public function storeAnswer(Request $request)
    {
        try {
            $trainingModule = LMSTrainingModule::find($request->training_module_id);
            if($request->pageType == 'question'){
                $correct_option = LMSOption::where('question_id',$request->question_id)->where('is_correct',1)->first();
                $corectQuestionTrueOrFalseAnswer = LMSQuestion::find($request->question_id);
                $is_correct = null;

                if($request->question_type == 'multi_choise'){
                    if($correct_option->id == $request->option_id){
                        $is_correct = true;
                    }else{
                        $is_correct = false;
                    }
                }else{
                    if($corectQuestionTrueOrFalseAnswer->correct_answer == $request->true_or_false){
                        $is_correct =true;
                    }else{
                        $is_correct =false;
                    }
                }

                LMSAnswer::updateOrCreate([
                    'question_id' => $request->question_id,
                    'user_id' => auth()->id(),
                ],[
                    'question_id' => $request->question_id,
                    'user_id' => auth()->id(),
                    'option_id' => $request->option_id,
                    'is_correct' => $is_correct,
                    'true_or_false' => $request->true_or_false == 'true' ? 1:0,
                ]);
            }

            $this->updateScoreInEachStep($trainingModule);

            if($request->finsih_training == 'true'){
                $totalQuestions = LMSQuestion::where('training_module_id',$request->training_module_id)->pluck('id')->toArray();
                $totalQuestionsCount = count($totalQuestions);

                $userAnswers = LMSAnswer::where('user_id', auth()->id())
                                        ->whereIn('question_id',$totalQuestions)
                                        ->get();

                $correctAnswers = $userAnswers->where('is_correct', 1)->count();

                $result = ($correctAnswers / $totalQuestionsCount) * 100;

                $currentPivotData = $trainingModule->users()
                    ->wherePivot('user_id', auth()->id())
                    ->first()
                    ->pivot;
                $countOfEnteringExam = $currentPivotData->count_of_entering_exam + 1;

                if($result >= $trainingModule->passing_score){
                    $message = __('lms.Congratulation ! You Have Success. Your Score is');
                    $trainingModule->users()
                        ->updateExistingPivot(auth()->id(), [
                            'score' => $result,
                            'passed' => 1,
                            'count_of_entering_exam' => $countOfEnteringExam,
                            'completed_at' => now(),
                        ]);
                }else{
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
                return response()->json([
                    'completeTrain' => true,
                    'redirect' => route('user.lms.training.modules.index')
                ]);
            }

        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }

    public function updateScoreInEachStep($trainingModule)
    {
        $currentScore = LMSAnswer::where('user_id', auth()->id())
        ->whereHas('question', function($query) use ($trainingModule) {
            $query->where('training_module_id', $trainingModule->id);
        })
        ->where('is_correct', 1)
        ->count();

        $totalQuestionsCount = LMSQuestion::where('training_module_id', $trainingModule->id)->count();

        if ($totalQuestionsCount > 0) {
            $score = ($currentScore / $totalQuestionsCount) * 100;

            $trainingModule->users()->updateExistingPivot(auth()->id(), [
                'score' => $score,
            ]);
        }
    }

    public function calcResultWhenRefresh($trainingModule)
    {
        $totalQuestions = LMSQuestion::where('training_module_id',$trainingModule->id)->pluck('id')->toArray();
        $totalQuestionsCount = count($totalQuestions);

        $userAnswers = LMSAnswer::where('user_id', auth()->id())
                                ->whereIn('question_id',$totalQuestions)
                                ->get();

        $correctAnswers = $userAnswers->where('is_correct', 1)->count();

        $result = ($correctAnswers / $totalQuestionsCount) * 100;

        $currentPivotData = $trainingModule->users()
            ->wherePivot('user_id', auth()->id())
            ->first()
            ->pivot;
        $countOfEnteringExam = $currentPivotData->count_of_entering_exam + 1;

        if($result >= $trainingModule->passing_score){
            $message = __('lms.Congratulation ! You Have Success. Your Score is');
            $trainingModule->users()
                ->updateExistingPivot(auth()->id(), [
                    'score' => $result,
                    'passed' => 1,
                    'count_of_entering_exam' => $countOfEnteringExam,
                    'completed_at' => now(),
                ]);
        }else{
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
            $totalQuestions = LMSQuestion::where('training_module_id',$request->training_module_id)->pluck('id')->toArray();
            $totalQuestionsCount = count($totalQuestions);

            $userAnswers = LMSAnswer::where('user_id', auth()->id())
                                    ->whereIn('question_id',$totalQuestions)
                                    ->get();

            $correctAnswers = $userAnswers->where('is_correct', 1)->count();

            $result = ($correctAnswers / $totalQuestions) * 100;
            return view('result', compact('result'));
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }
}
