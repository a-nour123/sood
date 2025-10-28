<?php

namespace App\Http\Controllers\admin\assessment;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\assessment\AssessmentRequest;
use App\Models\Assessment;
use App\Models\FrameworkControl;
use App\Models\Question;
use App\Repositories\Assessment\Assessment\AssessmentRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\AssessmentCreated;
use App\Events\AssessmentUpdated;
use App\Events\AssessmentDeleted;
use App\Models\Action;
use App\Models\User;

class AssessmentController extends Controller
{
    protected AssessmentRepo $repo;
    protected int $paginator = 4;


    /**
     * @param AssessmentRepo $repo
     */
    public function __construct(AssessmentRepo $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Index Page
     * Display a dump message for testing
     * @return String
     */
    public function index()
    {
        if (!auth()->user()->hasPermission('templateAssessment.list')) {
            abort(403, 'Unauthorized action.');
        }

        $assessments = $this->repo->get_all(['id', 'name'])->latest('id')->paginate($this->paginator);
        $all_assessments = $this->repo->get_all(['id', 'name'])->latest('id')->get();
        $questions = Question::query()->latest('id')->get(['id', 'question']);

        $controls = FrameworkControl::query()->get(['id', 'short_name as name']);
 
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            [ 'name' => __('locale.Assessments')],
            ['name' => __('locale.Template')]
        ];
        return view('admin.content.assessment.index', compact('breadcrumbs', 'assessments', 'controls', 'all_assessments', 'questions'));
    }

    /**
     * @param Request $request
     * @return string
     */
    public function paginatedData(Request $request): string
    {
        $assessments = $this->repo->get_all(['id', 'name'])->latest('id')->paginate($this->paginator);
        return view('admin.content.assessment.paginated_data', compact('assessments'))->render();
    }

    /**
     * Store Assessment
     * @throws \Exception
     */
    public function store(AssessmentRequest $request)
    {

        $data = $request->safe()->toArray();

        $this->repo->store($data);
        $assessment = new Assessment($data);
        DB::commit();
        event(new AssessmentCreated($assessment));
        $message = __('assessment.A New Templete of Assessment Added with name') . ' "' . ($assessment->name ?? __('locale.[No Assessment Name]')) . '" ' . __('CreatedBy') . ' "' . auth()->user()->name . '".';
        write_log(1, auth()->id(), $message, 'Creating assessment');
    }

    /**
     * Update Assessment
     * @throws \Exception
     */
    public function update(AssessmentRequest $request, Assessment $assessment)
    {
        $data = $request->safe()->toArray();
        $this->repo->update($data, $assessment);
        $assessment = new Assessment($data);
 
        DB::commit();
        event(new AssessmentUpdated($assessment));
        $message = __('assessment.A Templete of Assessment with name') . " \"" . ($assessment->name ?? __('locale.[No Assessment Name]')) . "\" " . __('locale.UpdatedBy') . " \"" . (auth()->user()->name ?? '[No User Name]') . "\".";
        write_log(1, auth()->id(), $message, 'updating assessment');
    }

    public function destroy($id)
    {
        $assessment = Assessment::find($id);
        $assessmentName = $assessment->name;
        if ($assessmentName) {
            DB::beginTransaction();
            try {
                // Manually check if there are any related questionnaires
                $relatedQuestionnaires = DB::table('questionnaires') // Replace this with the actual pivot table name
                    ->where('assessment_id', $id)
                    ->exists(); // Check if any related questionnaire exists

                // If there are related questionnaires, return an error message
                if ($relatedQuestionnaires) {
                    return response()->json([
                        'status' => false,
                        'message' => 'This assessment cannot be deleted because it is linked to existing questionnaires.'
                    ], 400);
                }
                $assessment->delete();

                // Audit log
                $message = __('assessment.AssessmentDeleteAuditLog', [
                    'user' => auth()->user()->name,
                    'assessment_name' => $assessmentName,
                    'id' => $id + 1000
                ]);
                // write_log($id, auth()->id(), $message, 'assessment');

                DB::commit();
                event(new AssessmentDeleted($assessment));

                $response = array(
                    'status' => true,
                    'message' => __('assessment.AssessmentDeletedSuccessfully'),
                );
                $message = __('assessment.A Templete of Assessment with name') . ' "' . ($assessment->name ?? __('locale.[No Assessment Name]')) . '" ' . __('locale.DeletedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
                write_log(1, auth()->id(), $message, 'Deleting assessment');
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'message' => $th->getMessage(),
                    // 'message' => $th->getMessage(),
                );
                return response()->json($response, 404);
            }
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404'),
            );
            return response()->json($response, 404);
        }
    }
    public function notificationsSettingsassessments()
    {

        //defining the breadcrumbs that will be shown in page
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.assessment.index'), 'name' => __('locale.Assessments')],
            ['name' => __('locale.NotificationsSettings')]
        ];
        $users = User::select('id', 'name')->where('enabled', true)->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [59, 60, 61];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            59 => ['Name'],
            60 => ['Name'],
            61 => ['Name'],
        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [];
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
