<?php

namespace App\Http\Controllers\admin\governance;

use App\Events\ExceptionCreated;
use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Department;
use App\Models\Document;
use App\Models\Exception as ModelsException;
use App\Models\ExceptionSetting;
use App\Models\Family;
use App\Models\Framework;
use App\Models\FrameworkControl;
use App\Models\Regulator;
use App\Models\User;
use App\Models\Exception;
use App\Models\ResidualRiskScoringHistory;
use App\Models\Risk;
use App\Traits\UpoladFileTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class ExceptionController extends Controller
{
    use UpoladFileTrait;

    public function index()
    {
        // Fetch all necessary data
        $regulators = Regulator::all();
        $documents = Document::all();
        $risks = Risk::all();
        $approvedRiskExceptions = Exception::where('request_status', '=', '1')->where('type', 'risk')->get();
        $rejectedRiskExceptions = Exception::where('request_status', '=', '2')->where('type', 'risk')->get();
        $pendingRiskExceptions = Exception::where('request_status', '=', '0')->where('type', 'risk')->get();
        $approvedControlExceptions = Exception::where('request_status', '=', '1')->where('type', 'control')->get();
        $rejectedControlExceptions = Exception::where('request_status', '=', '2')->where('type', 'control')->get();
        $pendingControlExceptions = Exception::where('request_status', '=', '0')->where('type', 'control')->get();
        $approvedPolicyExceptions = Exception::where('request_status', '=', '1')->where('type', 'policy')->get();
        $rejectedPolicyExceptions = Exception::where('request_status', '=', '2')->where('type', 'policy')->get();
        $pendingPolicyExceptions = Exception::where('request_status', '=', '0')->where('type', 'policy')->get();
        $exceptionSettings = ExceptionSetting::all();
        $controls = FrameworkControl::all();
        $exceptions = Exception::all();
        // dd($exceptions);
        $policyExceptions = Exception::where('type', 'policy')->get();
        $controlExceptions = Exception::where('type', 'control')->get();
        $riskExceptions = Exception::where('type', 'risk')->get();
        $unapprovedExceptions = Exception::where('request_status', '!=', '1')->get();
        $users = User::where('enabled', true)->with('manager:id,name,manager_id')->get();
        $departmentsManagers = User::where('enabled', true)->with('manager:id,name,manager_id')->get();
        // $departmentsManagers = User::where('job_id', 2)->with('manager:id,name,manager_id')->get();
        $families = Family::whereNull('parent_id')->select('id', 'name')->with('custom_families_framework:id,name,parent_id')->get();

        //Frameworks
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.exceptions')]

        ];

        // Return the view with the necessary data
        return view('admin.content.governance.exception_list', compact(
            'breadcrumbs',
            'regulators',
            'risks',
            'approvedRiskExceptions',
            'rejectedRiskExceptions',
            'pendingRiskExceptions',
            'approvedControlExceptions',
            'rejectedControlExceptions',
            'pendingControlExceptions',
            'approvedPolicyExceptions',
            'rejectedPolicyExceptions',
            'pendingPolicyExceptions',
            'riskExceptions',
            'families',
            'documents',
            'users',
            'exceptionSettings',
            'controls',
            'exceptions',
            'policyExceptions',
            'controlExceptions',
            'unapprovedExceptions',
            'departmentsManagers'
        ));
    }


    public function graphViewException()
    {
        $allExceptions = Exception::all();
        $riskExceptions = Exception::where('type', 'risk')->get();
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.governance.exception.index'), 'name' => __('locale.exceptions')],
            ['name' => __('locale.Statistics')],

        ];
        $exceptionsCountByDepartment = Exception::selectRaw('departments.name as department_name, COUNT(exceptions.id) as exception_count')
            ->join('users', 'exceptions.exception_creator', '=', 'users.id')
            ->join('departments', 'users.department_id', '=', 'departments.id')
            ->groupBy('departments.id')
            ->orderBy('exception_count', 'desc')
            ->get();

        $departmentExceptionsCount = Exception::selectRaw('departments.name as department_name, COUNT(exceptions.id) as exception_count')
            ->join('users', 'exceptions.exception_creator', '=', 'users.id')
            ->join('departments', 'users.department_id', '=', 'departments.id')
            ->groupBy('departments.id')
            ->get();

        // Calculate end_date, get top 5 exceptions based on end_date, and include department name
        $exceptionsWithEndDate = Exception::select(
            'exceptions.*',
            DB::raw('DATE_ADD(approval_date, INTERVAL request_duration DAY) as end_date'),
            'departments.name as department_name'
        )
            ->join('users', 'exceptions.exception_creator', '=', 'users.id')
            ->join('departments', 'users.department_id', '=', 'departments.id')
            ->orderBy('end_date', 'desc')
            ->where('approval_date', '!=', null)
            ->take(4)
            ->get();

        // Sort the collection by end_date in ascending order
        $exceptionsWithEndDate = $exceptionsWithEndDate->sortBy('end_date');

        // dd($exceptionsWithEndDate);

        // Prepare data for donut chart
        $departmentNames = $exceptionsCountByDepartment->pluck('department_name')->toArray();
        $exceptionCounts = $exceptionsCountByDepartment->pluck('exception_count')->toArray();

        $openExceptions = Exception::where('exception_status', '=', '1')->get();
        $closedExceptions = Exception::where('exception_status', '=', '0')->get();



        $lowRisks = Exception::where('risk_severity', '=', 'low')->get();
        $mediumRisks = Exception::where('risk_severity', '=', 'medium')->get();
        $highRisks = Exception::where('risk_severity', '=', 'high')->get();
        $veryHighRisks = Exception::where('risk_severity', '=', 'very high')->get();

        $severityCounts = [
            'low' => Exception::where('risk_severity', 'low')->count(),
            'medium' => Exception::where('risk_severity', 'medium')->count(),
            'high' => Exception::where('risk_severity', 'high')->count(),
            'very_high' => Exception::where('risk_severity', 'very high')->count(),
        ];

        // dd($lowRisks);

        // In your graphViewFramework method
        return view('admin.content.governance.ExceptionStatistics', array_merge([
            'breadcrumbs' => $breadcrumbs,
            'exceptionsCountByDepartment' => $exceptionsCountByDepartment,
            'departmentExceptionsCount' => $departmentExceptionsCount,
            'exceptionsWithEndDate' => $exceptionsWithEndDate,
            'departmentNames' => $departmentNames,
            'exceptionCounts' => $exceptionCounts,
            'severityCounts' => $severityCounts,
            'lowRisks' => $lowRisks,
            'mediumRisks' => $mediumRisks,
            'highRisks' => $highRisks,
            'veryHighRisks' => $veryHighRisks,
            'openExceptions' => $openExceptions,
            'closedExceptions' => $closedExceptions,
            'allExceptions' => $allExceptions,
            'riskExceptions' => $riskExceptions,
        ])); // This might be redundant

    }


    /**
     * This function retrieves frameworks from the database based on a given regulator_id
     * @param mixed $regulator_id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function getFrameworks($regulator_id)
    {
        $frameworks = Framework::where('regulator_id', $regulator_id)->get();
        return response()->json($frameworks);
    }

    /**
     * This function retrieves the controls associated with a specific framework, identified by its framework_id
     * @param mixed $framework_id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function getControlsByFramework($framework_id)
    {
        // Find the framework by its ID or throw a 404 error if not found
        $controls = Framework::findOrFail($framework_id)
            ->FrameworkControls() // Access the related controls using the FrameworkControls relationship
            ->select('framework_controls.id', 'framework_controls.short_name')
            ->get();

        return response()->json($controls);
    }


    private function getRiskSeverity($severity)
    {
        if ($severity < 4) {
            return 'low';
        } elseif ($severity < 7) {
            return 'medium';
        } elseif ($severity < 10) {
            return 'high';
        } else {
            return 'very high';
        }
    }

    /**
     * This function handles the creation of an exception in the system, which could be associated with a policy, control, or risk.
     * It validates the input, stores the exception data in the database, and associates it with the relevant tables.
     * If a file is uploaded, it stores the file and updates the exception record.
     * Finally, it triggers an event upon successful creation or handles errors with a rollback.
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // dd($request);

        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'name' => ['required'], // Name cannot be only numbers
            // 'status' => ['required'],
            'policy' => ['required_without_all:control,risk'], // Required if control is not present
            'control' => ['required_without_all:policy,risk'], // Required if policy is not present
            'risk' => ['required_without_all:policy,control'], // Required if policy is not present
            'stakeholder' => ['required'],
            'request_duration' => ['required'],
            'description' => ['required', 'regex:/^[^\d]*[^\d]$/'],
            'justification' => ['required'],
        ]);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('Exceptions') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();
            try {
                $exceptionSettings = ExceptionSetting::all();
                if ($request->policy != null) {
                    $type = 'policy';
                    $policyOwnerId = Document::where('id', $request->policy)->value('document_owner');

                    if ($exceptionSettings[0]['policy_approver'] == '0') {
                        $exception = Exception::create([
                            'name' => $request->name,
                            // 'exception_status' => $request->status,
                            'exception_creator' => auth()->user()->id,
                            'type' => $type,
                            'stakeholder' => json_encode($request->stakeholder),
                            // 'review_frequency' => $request->review_frequency,
                            'request_duration' => $request->request_duration,
                            // 'next_review_date' => $request->next_review_date,
                            'description' => $request->description,
                            'justification' => $request->justification,
                            'policy_owner_id' => $policyOwnerId,
                            'policy_approver_id' => $policyOwnerId,
                        ]);
                    } else {
                        $exception = Exception::create([
                            'name' => $request->name,
                            // 'exception_status' => $request->status,
                            'exception_creator' => auth()->user()->id,
                            'type' => $type,
                            'stakeholder' => json_encode($request->stakeholder),
                            // 'review_frequency' => $request->review_frequency,
                            'request_duration' => $request->request_duration,
                            // 'next_review_date' => $request->next_review_date,
                            'description' => $request->description,
                            'justification' => $request->justification,
                            'policy_owner_id' => $policyOwnerId,
                            'policy_approver_id' => $exceptionSettings[0]['policy_approver_id'],
                        ]);
                    }
                } elseif ($request->risk) {
                    $type = 'risk';
                    $riskOwnerId = Risk::where('id', $request->risk)->value('owner_id');

                    // Retrieve the latest severity score from residual_risk_scoring_histories for the given risk_id
                    $latestSeverity = ResidualRiskScoringHistory::where('risk_id', $request->risk)
                        ->orderBy('last_update', 'desc')
                        ->value('residual_risk');

                    $severityLevel = $this->getRiskSeverity($latestSeverity);

                    // dd($severityLevel);

                    if ($exceptionSettings[0]['risk_approver'] == '0') {
                        $exception = Exception::create([
                            'name' => $request->name,
                            // 'exception_status' => $request->status,
                            'exception_creator' => auth()->user()->id,
                            'type' => $type,
                            'stakeholder' => json_encode($request->stakeholder),
                            // 'review_frequency' => $request->review_frequency,
                            'request_duration' => $request->request_duration,
                            // 'next_review_date' => $request->next_review_date,
                            'description' => $request->description,
                            'justification' => $request->justification,
                            'risk_severity' => $severityLevel,
                            'risk_owner_id' => $riskOwnerId,
                            'risk_approver_id' => $riskOwnerId,
                        ]);
                    } else {
                        $exception = Exception::create([
                            'name' => $request->name,
                            // 'exception_status' => $request->status,
                            'exception_creator' => auth()->user()->id,
                            'type' => $type,
                            'stakeholder' => json_encode($request->stakeholder),
                            // 'review_frequency' => $request->review_frequency,
                            'request_duration' => $request->request_duration,
                            // 'next_review_date' => $request->next_review_date,
                            'description' => $request->description,
                            'justification' => $request->justification,
                            'risk_severity' => $severityLevel,
                            'risk_owner_id' => $riskOwnerId,
                            'risk_approver_id' => $exceptionSettings[0]['risk_approver_id'],
                        ]);
                    }
                } else {
                    $type = 'control';
                    $controlOwnerId = FrameworkControl::where('id', $request->control)->value('control_owner');

                    if ($exceptionSettings[0]['control_approver'] == '0') {
                        $exception = Exception::create([
                            'name' => $request->name,
                            // 'exception_status' => $request->status,
                            'exception_creator' => auth()->user()->id,
                            'type' => $type,
                            'stakeholder' => json_encode($request->stakeholder),
                            // 'review_frequency' => $request->review_frequency,
                            'request_duration' => $request->request_duration,
                            // 'next_review_date' => $request->next_review_date,
                            'description' => $request->description,
                            'justification' => $request->justification,
                            'control_owner_id' => $controlOwnerId,
                            'control_approver_id' => $controlOwnerId,
                        ]);
                    } else {
                        $exception = Exception::create([
                            'name' => $request->name,
                            // 'exception_status' => $request->status,
                            'exception_creator' => auth()->user()->id,
                            'type' => $type,
                            'stakeholder' => json_encode($request->stakeholder),
                            // 'review_frequency' => $request->review_frequency,
                            'request_duration' => $request->request_duration,
                            // 'next_review_date' => $request->next_review_date,
                            'description' => $request->description,
                            'justification' => $request->justification,
                            'control_owner_id' => $controlOwnerId,
                            'control_approver_id' => $exceptionSettings[0]['control_approver_id'],
                        ]);
                    }
                }

                // Insert into the control_exception table if control is present in the request
                if ($request->control != NULL) {
                    DB::table('control_exception')->insert([
                        'exception_id' => $exception->id,
                        'control_id' => $request->control,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()

                    ]);
                }

                // Insert into the  exception_policy table if policy is present in the request
                if ($request->policy != NULL) {
                    DB::table('exception_policy')->insert([
                        'exception_id' => $exception->id,
                        'policy_id' => $request->policy,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()

                    ]);
                }

                // Insert into the  exception_risk table if risk is present in the request
                if ($request->risk != NULL) {
                    DB::table('exception_risk')->insert([
                        'exception_id' => $exception->id,
                        'risk_id' => $request->risk,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()

                    ]);
                }

                if ($request->hasFile('exception_file')) {
                    $file = $request->file('exception_file');
                    // $path = $this->storeFile($file, 'LMS/Courses');
                    $path = $this->storeFileInStorage($file, 'public/exception_file');
                    $exception->update(
                        ['exception_file' => $path]
                    );
                }

                DB::commit();
                event(new ExceptionCreated($exception));

                $response = array(
                    'status' => true,
                    'message' => __('locale.ExceptionWasAddedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                dd($th);
                DB::rollBack();
                $response = array(
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                );
                return response()->json($response, 502);
            }
        }
    }


    /**
     * Summary of show
     * @param mixed $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $exception = Exception::findOrFail($id);
        // dd($exception);
        $control_name = null; // Initialize the variable
        $policy_name = null; // Initialize the variable
        $risk_name = null; // Initialize the variable
        // dd()
        if ($exception->type == 'control') {
            $control_id = DB::table('control_exception')->select('control_id')->where('exception_id', $id)->get()->toArray()[0]->control_id;
            $control_name = DB::table('framework_controls')->select('long_name')->where('id', $control_id)->get()->toArray()[0]->long_name;
        }

        if ($exception->type == 'policy') {
            $control_id = DB::table('exception_policy')->select('policy_id')->where('exception_id', $id)->get()->toArray()[0]->policy_id;
            $policy_name = DB::table('documents')->select('document_name')->where('id', $control_id)->get()->toArray()[0]->document_name;
        }

        if ($exception->type == 'risk') {
            $risk_id = DB::table('exception_risk')->select('risk_id')->where('exception_id', $id)->get()->toArray()[0]->risk_id;
            $risk_name = DB::table('risks')->select('subject')->where('id', $risk_id)->get()->toArray()[0]->subject;
            // dd($risk_name);
        }

        $exception_creator = DB::table('exceptions')->select('exception_creator')->where('id', $id)->get()->toArray()[0]->exception_creator;
        $exception_creator_name = DB::table('users')->select('name')->where('id', $exception_creator)->get()->toArray()[0]->name;
        $submission_date = $exception->created_at;


        $stakeholders = $exception->stakeholder;
        $stakeholdersArray = json_decode($stakeholders, true); // Convert JSON array to PHP array
        $stakeholdersCollection = collect($stakeholdersArray);
        $users = User::whereIn('id', $stakeholdersCollection)->get();
        $usersNames = $users->pluck('name');
        // dd(format_date($submission_date, 'N/A'));


        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.governance.exception.index'), 'name' => __('locale.Exceptions')],
            ['name' => __('locale.ViewException')]
        ];
        return view('admin.content.governance.show-exception', compact(
            'breadcrumbs',
            'exception',
            'control_name',
            'policy_name',
            'risk_name',
            'submission_date',
            'exception_creator_name',
            'usersNames'
        ));
    }

    public function getExceptionData($id, $type = null)
    {
        $data['exception'] = Exception::findOrFail($id);
        if ($type == 'policy') {
            $data['policy_id'] = $data['exception']->policies->first()->id;
        } elseif ($type == 'control') {
            $data['control_id'] = $data['exception']->controls->first()->id;
        } else {
            $data['risk_id'] = $data['exception']->risks->first()->id;
        }
        return response()->json($data);
    }


    public function update(Request $request, $id)
    {
        // dd($request);
        $exception = Exception::find($id);

        if ($exception) {
            if (auth()->user()->id == $exception->exception_creator) {
                $validator = Validator::make($request->all(), [
                    // 'request_status' => ['required'],
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    'request_status' => ['required'],
                ]);
            }
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('locale.ThereWasAProblemUpdatingTheException') . "<br>" . $errors['request_status'][0],
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();
                try {
                    $exceptionSettings = ExceptionSetting::all();
                    // Array to hold the fields to update
                    $dataToUpdate = [];

                    // Check if request_status is 1 (Approve)
                    if ($request->has('request_status') && $request->request_status == 1) {
                        $approvalDate = now(); // Set the approval_date to the current date and time
                        $dataToUpdate['approval_date'] = $approvalDate;

                        // if ($request->has('review_frequency')) {
                        //     $reviewFrequency = $request->review_frequency;
                        //     $nextReviewDate = $approvalDate->copy()->addDays($reviewFrequency);
                        //     $dataToUpdate['next_review_date'] = $nextReviewDate;
                        // }
                    } elseif ($request->has('request_status') && $request->request_status == 2) {
                        $dataToUpdate['exception_status'] = 0; // Set status to 0 if request_status is 2 (Reject)
                    } else {
                        // Add status to the array if it exists and is not null in the request
                        if ($request->has('status')) {
                            $dataToUpdate['exception_status'] = $request->status;
                        }
                    }

                    // Add the fields to the array if they exist and are not null in the request
                    if ($request->has('name')) {
                        $dataToUpdate['name'] = $request->name;
                    }

                    if ($request->has('request_duration')) {
                        $dataToUpdate['request_duration'] = $request->request_duration;
                    }

                    // if ($request->has('reviewer')) {
                    //     $dataToUpdate['reviewer'] = $request->reviewer;
                    // }

                    if ($request->has('request_status')) {
                        $dataToUpdate['request_status'] = $request->request_status;
                    }

                    if ($request->has('stakeholder')) {
                        $dataToUpdate['stakeholder'] = json_encode($request->stakeholder);
                    }

                    // if ($request->has('review_frequency')) {
                    //     $dataToUpdate['review_frequency'] = $request->review_frequency;
                    // }

                    if ($request->has('comment')) {
                        $dataToUpdate['comment'] = $request->comment;
                    }

                    if ($request->has('description') && $request->description != null) {
                        $dataToUpdate['description'] = $request->description;
                    }

                    if ($request->has('justification') && $request->html_code != null) {
                        $dataToUpdate['justification'] = $request->html_code;
                    }

                    if ($request->has('exception_creator')) {
                        $dataToUpdate['exception_creator'] = $request->exception_creator;
                    }

                    // Handle the policy and control relationship
                    if ($request->has('policy')) {
                        // Update the type to 'policy'
                        $dataToUpdate['type'] = 'policy';
                        $policyOwnerId = Document::where('id', $request->policy)->value('document_owner');
                        // dd($policyOwnerId);


                        DB::table('exceptions')
                            ->where('id', $exception->id)
                            ->update(['policy_owner_id' => $policyOwnerId]);

                        if ($exceptionSettings[0]['policy_approver'] == '0') {
                            DB::table('exceptions')
                                ->where('id', $exception->id)
                                ->update(['policy_approver_id' => $policyOwnerId]);
                        } else {
                            DB::table('exceptions')
                                ->where('id', $exception->id)
                                ->update(['policy_approver_id' => $exceptionSettings[0]['policy_approver_id']]);
                        }

                        // If a policy is selected, ensure the related control is removed
                        DB::table('exception_policy')->updateOrInsert(
                            ['exception_id' => $exception->id],
                            ['policy_id' => $request->policy, 'updated_at' => Carbon::now()]
                        );
                        // If a control was previously selected, remove it
                        DB::table('control_exception')->where('exception_id', $exception->id)->delete();
                        DB::table('exception_risk')->where('exception_id', $exception->id)->delete();
                    }

                    if ($request->has('control')) {
                        // Update the type to 'controls'
                        $dataToUpdate['type'] = 'control';

                        $controlOwnerId = FrameworkControl::where('id', $request->control)->value('control_owner');

                        DB::table('exceptions')
                            ->where('id', $exception->id)
                            ->update(['control_owner_id' => $controlOwnerId]);

                        if ($exceptionSettings[0]['control_approver'] == '0') {
                            DB::table('exceptions')
                                ->where('id', $exception->id)
                                ->update(['control_approver_id' => $controlOwnerId]);
                        } else {
                            DB::table('exceptions')
                                ->where('id', $exception->id)
                                ->update(['control_approver_id' => $exceptionSettings[0]['control_approver_id']]);
                        }

                        // If a control is selected, ensure the related policy is removed
                        DB::table('control_exception')->updateOrInsert(
                            ['exception_id' => $exception->id],
                            ['control_id' => $request->control, 'updated_at' => Carbon::now()]
                        );

                        // If a policy was previously selected, remove it
                        DB::table('exception_policy')->where('exception_id', $exception->id)->delete();
                        DB::table('exception_risk')->where('exception_id', $exception->id)->delete();
                    }

                    if ($request->has('risk')) {
                        // Update the type to 'risk'
                        $dataToUpdate['type'] = 'risk';

                        $riskOwnerId = Risk::where('id', $request->risk)->value('owner_id');

                        // Retrieve the latest severity score from residual_risk_scoring_histories for the given risk_id
                        $latestSeverity = ResidualRiskScoringHistory::where('risk_id', $request->risk)
                            ->orderBy('last_update', 'desc')
                            ->value('residual_risk');

                        $severityLevel = $this->getRiskSeverity($latestSeverity);

                        DB::table('exceptions')
                            ->where('id', $exception->id)
                            ->update(
                                ['risk_owner_id' => $riskOwnerId],
                                ['risk_severity' => $severityLevel],
                            );

                        if ($exceptionSettings[0]['risk_approver'] == '0') {
                            DB::table('exceptions')
                                ->where('id', $exception->id)
                                ->update(['risk_approver_id' => $riskOwnerId]);
                        } else {
                            DB::table('exceptions')
                                ->where('id', $exception->id)
                                ->update(['risk_approver_id' => $exceptionSettings[0]['risk_approver_id']]);
                        }

                        // If a risk is selected, ensure the related policy is removed
                        DB::table('exception_risk')->updateOrInsert(
                            ['exception_id' => $exception->id],
                            ['risk_id' => $request->risk, 'updated_at' => Carbon::now()]
                        );

                        // If a policy was previously selected, remove it
                        DB::table('exception_policy')->where('exception_id', $exception->id)->delete();
                        DB::table('control_exception')->where('exception_id', $exception->id)->delete();
                    }

                    // Update the exception with the prepared data
                    $exception->update($dataToUpdate);

                    DB::commit();

                    $response = array(
                        'status' => true,
                        'message' => __('locale.ExceptionWasUpdatedSuccessfully'),
                    );
                    return response()->json($response, 200);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return $th->getMessage();
                }
            }
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404'),
            );
            return response()->json($response, 404);
        }
    }

    public function notificationsSettingsExceptions()
    {
        // defining the breadcrumbs that will be shown in page
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.governance.exception.index'), 'name' => __('locale.exceptions')], // give it your own route
            ['name' => __('locale.NotificationsSettings')]
        ];
        $users = User::where('enabled', true)->with('manager:id,name,manager_id')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [98, 99];   // defining ids of actions modules in ActionSeeder (system notification part)
        $moduleActionsIdsAutoNotify = [101];  // defining ids of actions modules (auto notify part)

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            98 => ['Name', 'Creator', 'type'],
            99 => [],
            100 => ['Name', 'Privacy', 'Created_By', 'Description', 'Additional_Stakeholder', 'Status', 'Teams', 'Reviewer'],
            101 => ['Name', 'Privacy', 'Created_By', 'Description', 'Additional_Stakeholder', 'Status', 'Teams', 'Reviewer', 'Next_Review_Date'], // for auto notify
        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [
            98 => [
                'Stakeholder' => __('locale.StakeholderOfException'),
                'policy_approver' => __('locale.policy_approver'),
                'control_approver' => __('locale.control_approver'),
                'risk_approver' => __('locale.risk_approver'),
            ],
            // 99 => ['creator' => __('locale.exception_creator'),  'Stakeholder-teams' => __('locale.StakeholderOfSurvey'), 'reviewers-teams' => __('locale.ReviewersOfSurvey')],
            // 100 => ['creator' => __('locale.exception_creator'),  'Stakeholder-teams' => __('locale.StakeholderOfSurvey'), 'reviewers-teams' => __('locale.ReviewersOfSurvey')],
            // 101 => ['creator' => __('locale.exception_creator'),  'Stakeholder-teams' => __('locale.StakeholderOfSurvey'), 'reviewers-teams' => __('locale.ReviewersOfSurvey')],
        ];


        /* static part below you will change nothing in it  */

        // getting actions with their system notifications settings, sms settings and mail settings to list them in tables
        $actionsWithSettings = Action::whereIn('actions.id', $moduleActionsIds)
            ->leftJoin('system_notifications_settings', 'actions.id', '=', 'system_notifications_settings.action_id')
            ->leftJoin('mail_settings', 'actions.id', '=', 'mail_settings.action_id')
            ->leftJoin('sms_settings', 'actions.id', '=', 'sms_settings.action_id')
            ->leftJoin('auto_notifies', 'actions.id', '=', 'auto_notifies.action_id')
            ->get([
                'actions.id as action_id',
                'actions.name as action_name',
                'system_notifications_settings.id as system_notification_setting_id',
                'system_notifications_settings.status as system_notification_setting_status',
                'mail_settings.id as mail_setting_id',
                'mail_settings.status as mail_setting_status',
                'sms_settings.id as sms_setting_id',
                'sms_settings.status as sms_setting_status',
                'auto_notifies.id as auto_notifies_id',
                'auto_notifies.status as auto_notifies_status',
            ]);
        $actionsWithSettingsAuto = Action::whereIn('actions.id', $moduleActionsIdsAutoNotify)
            ->leftJoin('auto_notifies', 'actions.id', '=', 'auto_notifies.action_id')
            ->get([
                'actions.id as action_id',
                'actions.name as action_name',
                'auto_notifies.id as auto_notifies_id',
                'auto_notifies.status as auto_notifies_status',
            ]);
        return view('admin.notifications-settings.index', compact('breadcrumbs', 'users', 'actionsWithSettings', 'actionsVariables', 'actionsRoles', 'moduleActionsIdsAutoNotify', 'actionsWithSettingsAuto'));
    }

    public function downloadException($filename)
    {
        $filePath = storage_path('app/public/' . $filename);

        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->download($filePath);
    }
}