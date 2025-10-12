<?php

namespace App\Http\Controllers\admin\third_party;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Department;
use App\Models\EvaluationRequest;
use App\Models\Questionnaire;
use App\Models\RiskFunction;
use App\Models\RiskGrouping;
use App\Models\ThirdPartyEvaluation;
use App\Models\ThirdPartyProfile;
use App\Models\ThirdPartyRequest;
use App\Models\ThirdPartyRequestRecipient;
use App\Models\ThirdPartyService;
use App\Models\ThreatGrouping;
use App\Models\User;
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ThirdPartyRequestController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasPermission('third_party_request.list')) {
            if ($request->ajax()) {
                $thirdPartyRequests = ThirdPartyRequest::with(['department', 'job', 'uploader', 'profile', 'service']) // Assuming you have relationships for department and job
                    ->select(
                        'id',
                        'requested_by',
                        'department_id',
                        'job_id',
                        'status',
                        'third_party_service_id',
                        'third_party_profile_id',
                        'business_info',
                        'created_at'
                    )
                    ->orderBy('created_at', 'desc');

                return DataTables::of($thirdPartyRequests)
                    ->addColumn('department', function ($thirdPartyRequests) {
                        return $thirdPartyRequests->department->name;
                    })
                    ->addColumn('job', function ($thirdPartyRequests) {
                        return $thirdPartyRequests->job->name;
                    })
                    ->addColumn('uploader', function ($thirdPartyRequests) {
                        return $thirdPartyRequests->uploader->name;
                    })
                    ->addColumn('profile', function ($thirdPartyRequests) {
                        return $thirdPartyRequests->profile->third_party_name;
                    })
                    ->addColumn('service', function ($thirdPartyRequests) {
                        return $thirdPartyRequests->service->name;
                    })
                    ->addColumn('actions', function ($thirdPartyRequests) {

                        // Initialize an empty string to hold the dropdown menu items
                        $dropdownItems = '';

                        // View button
                        $dropdownItems .= '<a href="javascript:void(0)" class="dropdown-item  view-request"
                                            data-id="' . $thirdPartyRequests->id . '">
                                            <i class="fas fa-eye me-2"></i>' . __('locale.View') . '
                                        </a>';

                        // display them when user is who requestedBy and the status pending, check on permission
                        if (
                            $thirdPartyRequests->status == 1 &&
                            (auth()->user()->id == $thirdPartyRequests->requested_by || auth()->user()->hasPermission('third_party_request.update'))
                        ) {
                            // Edit button
                            $dropdownItems .= '<a href="javascript:void(0)" class="dropdown-item  edit-request"
                                                data-id="' . $thirdPartyRequests->id . '">
                                                <i class="fas fa-edit me-2"></i>' . __('locale.Edit') . '
                                            </a>';
                        }
                        if (
                            $thirdPartyRequests->status == 1 &&
                            (auth()->user()->id == $thirdPartyRequests->requested_by || auth()->user()->hasPermission('third_party_request.delete'))
                        ) {
                            // Delete button
                            $dropdownItems .= '<a href="javascript:void(0)" class="dropdown-item delete-request"
                                            data-id="' . $thirdPartyRequests->id . '">
                                            <i class="fas fa-trash me-2"></i>' . __('locale.Delete') . '
                                        </a>';
                        }


                        // Return the HTML content for the dropdown menu with `dropup` class
                        return '<div class="d-inline-flex dropup">
                                <a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown" aria-expanded="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                         class="feather feather-more-vertical font-small-4">
                                        <circle cx="12" cy="12" r="1"></circle>
                                        <circle cx="12" cy="5" r="1"></circle>
                                        <circle cx="12" cy="19" r="1"></circle>
                                    </svg>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded" aria-labelledby="dropdownMenuButton">
                                    ' . $dropdownItems . '
                                </div>
                            </div>';
                    })
                    ->editColumn('created_at', function ($model) {
                        return Carbon::parse($model->created_at)->format('d/m/Y h:i A'); // 12-hour format with AM/PM
                    })
                    ->rawColumns(['actions'])
                    ->make(true);
            }
            // dd("requests");
            $breadcrumbs = [
                ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
                ['name' => __('locale.ThirdPartyManagment')],
                ['name' => __('locale.ThirdPartyRequests')]
            ];
            $thirdPartyProfiles = ThirdPartyProfile::get();
            $services = ThirdPartyService::get();
            $evaluations = ThirdPartyEvaluation::get();
            $requestsReciver = ThirdPartyRequestRecipient::first();
            // $assessments = Assessment::query()->with('questions:id,question')->select('name', 'id')->latest('id')->get();

            $data = [
                // 'breadcrumbs' => $breadcrumbs,
                'thirdPartyProfiles' => $thirdPartyProfiles,
                'services' => $services,
                'evaluations' => $evaluations,
                'requests_reciver' => $requestsReciver
            ];

            return view('admin.content.third_party.requests.index', compact('breadcrumbs', 'data'));
        } else {
            abort(403);
        }
    }
    public function getRequest($request_id)
    {
        $requestData = ThirdPartyRequest::findOrFail($request_id);

        return response()->json(['data' => $requestData]);
    }

    public function create(Request $request)
    {
        try {

            // Define validation rules for the evaluation array
            $request->validate([
                'requested_by' => ['required'],
                'department_id' => ['required'],
                'job_id' => ['required'],
                'third_party_profile_id' => ['required'],
                'third_party_service_id' => ['required'],
                'business_info' => ['required', 'max:255', 'string'],
                'evaluation.*.answer' => ['required'],
                'evaluation.*.comment' => ['max:255'],
            ], [
                // Custom error messages
                'requested_by.required' => __('third_party.Requested by') . " " . __('third_party.required validation'),
                'department_id.required' => __('third_party.Department') . " " . __('third_party.required validation'),
                'job_id.required' => __('third_party.Job title') . " " . __('third_party.required validation'),

                'third_party_profile_id.required' => __('third_party.ThirdPartyProfile') . " " . __('third_party.required validation'),
                'third_party_service_id.required' => __('third_party.Service') . " " . __('third_party.required validation'),

                'business_info.required' => __('third_party.business_info') . " " . __('third_party.required validation'),
                'business_info.max' => __('third_party.business_info') . " " . __('third_party.max validation') . " 255 " . __("third_party.character"),
                'business_info.string' => __('third_party.business_info') . " " . __('third_party.string validation'),

                'evaluation.*.answer.required' => __('third_party.Please answer all questions'),
                'evaluation.*.comment.max' => __('third_party.Explanations') . " " . __('third_party.max validation') . " 255 " . __("third_party.character"),
            ]);

            DB::beginTransaction(); // Start the transaction

            $insertdRequest = ThirdPartyRequest::create([
                'requested_by' => $request->requested_by,
                'department_id' => $request->department_id,
                'job_id' => $request->job_id,
                'third_party_profile_id' => $request->third_party_profile_id,
                'business_info' => $request->business_info,
                'third_party_service_id' => $request->third_party_service_id,
            ]);

            foreach ($request->evaluation as $evaluation) {
                EvaluationRequest::create([
                    'request_id' => $insertdRequest->id,
                    'evaluation_id' => $evaluation['evaluation_id'],
                    'answer' => $evaluation['answer'],
                    'comment' => $evaluation['comment'],
                ]);
            }

            DB::commit(); // Commit the transaction if all went well

            return response()->json([
                'message' => 'Request created successfully',
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function delete($request_id)
    {
        try {
            // dd($request_id);
            ThirdPartyRequest::findOrFail($request_id)->delete();

            return response()->json([
                'message' => 'Request deleted successfully',
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function update(Request $request, $request_id)
    {
        try {
            DB::beginTransaction(); // Start the transaction

            // Define validation rules for the evaluation array
            $rules = [
                'business_info' => 'required|max:255',
                'third_party_profile_id' => 'required',
                'third_party_service_id' => 'required',
                'evaluation.*.answer' => 'required|in:0,1',
            ];

            // Define custom messages for each field
            $messages = [
                'evaluation.*.answer.required' => 'Please answer all questions',
            ];

            // Validate the request
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                // Handle the validation failure
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $requestData = ThirdPartyRequest::findOrFail($request_id);

            // dd($requestData->toArray(), EvaluationRequest::where('request_id', $request_id)->get()->toArray());

            EvaluationRequest::where('request_id', $request_id)->delete(); // delete old evaluations

            $requestData->update([
                'business_info' => $request->business_info,
                'third_party_profile_id' => $request->third_party_profile_id,
                'third_party_service_id' => $request->third_party_service_id,
            ]);

            foreach ($request->evaluation as $evaluation) {
                EvaluationRequest::create([
                    'request_id' => $request_id,
                    'evaluation_id' => $evaluation['evaluation_id'],
                    'answer' => $evaluation['answer'],
                    'comment' => $evaluation['comment'],
                ]);
            }

            DB::commit(); // Commit the transaction if all went well

            return response()->json([
                'message' => 'Request updated successfully',
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            DB::rollback(); // Rollback on error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    // public function configure(){
    //     $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' => "javascript:void(0)", 'name' => __('locale.Configure')], ['name' => __('locale.Preparatorydata')]];
    //     $risk_groupings = RiskGrouping::all();
    //     $risk_functions = RiskFunction::all();
    //     $threat_groupings = ThreatGrouping::all();

    //     $addValueTables = [
    //         // TableName => Language key
    //        'third_party_services' => 'ThirdPartyServices',
    //         'third_party_evaluations' => 'ThirdPartyEvaluation',
    //         'third_party_request_recipients' => "ThirdPartyRequestRecipients"

    //     ];

    //     return view('admin.content.configure.Add_Values', compact('breadcrumbs', 'risk_groupings', 'risk_functions', 'threat_groupings', 'addValueTables'));
    // }
    // this function return view create or update form
    public function getForm(Request $request, $type, $request_id = null)
    {
        // dd($request_id);
        if ($request->ajax()) {

            $thirdPartyProfiles = ThirdPartyProfile::get();
            $services = ThirdPartyService::get();
            // $departmentManagers = User::where('job_id', 2)->get(); //
            $departmentManagers = Department::query()->with('manager:id,name')->get()->pluck('manager.name', 'manager.id');

            if ($type == 'create') {
                $evaluations = ThirdPartyEvaluation::get();
                $data = [
                    'thirdPartyProfiles' => $thirdPartyProfiles,
                    'services' => $services,
                    'evaluations' => $evaluations,
                    'department_managers' => $departmentManagers
                ];

                return view('admin.content.third_party.requests.create', compact('data'));
            } elseif ($type == 'edit') {
                $thirdPartyRequest = ThirdPartyRequest::findOrFail($request_id);
                $evaluations = EvaluationRequest::where('evaluation_request.request_id', $request_id)
                    ->join('third_party_evaluations', 'third_party_evaluations.id', '=', 'evaluation_request.evaluation_id')
                    ->select(
                        'third_party_evaluations.name as name',
                        'third_party_evaluations.id as id',
                        'evaluation_request.answer as answer',
                        'evaluation_request.comment as comment',
                    )
                    ->get();
                // dd($evaluations);

                $data = [
                    'request' => $thirdPartyRequest,
                    'thirdPartyProfiles' => $thirdPartyProfiles,
                    'services' => $services,
                    'evaluations' => $evaluations,
                    'department_managers' => $departmentManagers
                ];

                // dd($data);
                return view('admin.content.third_party.requests.edit', compact('data'));
            } else {
                return response()->json(['message' => 'Error: unkown type function'], 404);
            }
        } else {
            abort('403');
        }
    }

    public function view(Request $request, $request_id)
    {
        if ($request->ajax()) {

            $thirdPartyRequest = ThirdPartyRequest::findOrFail($request_id);
            $evaluations = EvaluationRequest::where('evaluation_request.request_id', $request_id)
                ->join('third_party_evaluations', 'third_party_evaluations.id', '=', 'evaluation_request.evaluation_id')
                ->select(
                    'third_party_evaluations.name as name',
                    'evaluation_request.id as id',
                    'evaluation_request.answer as answer',
                    'evaluation_request.comment as comment',
                )
                ->get();
            $requestsReciver = ThirdPartyRequestRecipient::first();

            $data = [
                'request' => $thirdPartyRequest,
                'evaluations' => $evaluations,
                'requests_reciver' => $requestsReciver
            ];

            // dd($data);
            return view('admin.content.third_party.requests.view', compact('data'));
        } else {
            abort('403');
        }
    }

    public function getUserDetailsFromId($userId)
    {
        $user = User::with(['job:id,name', 'department:id,name'])->findOrFail($userId);
        // dd($user->toArray()['job']['name']);
        return $user;
    }

    public function rejectRequest(Request $request, $request_id)
    {
        $thirdPartyRequest = ThirdPartyRequest::findOrFail($request_id);

        $thirdPartyRequest->update([
            'status' => 3, // rejected
            'reject_reason' => $request->reason,
        ]);

        return response()->json(['message' => __('third_party.Request rejected successfully')], 200);
    }
}
