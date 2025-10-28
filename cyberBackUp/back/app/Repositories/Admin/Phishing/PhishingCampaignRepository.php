<?php


namespace App\Repositories\Admin\Phishing;

use App\Http\Traits\PhishingMailTrait;
use App\Interfaces\Admin\Phishing\PhishingCampaignInterface;
use App\Jobs\SendCampaignEmails;
use App\Jobs\SendCampaignEmailsJob;
use App\Mail\PhishingEmail;
use App\Models\Action;
use App\Models\LMSCourse;
use App\Models\LMSLevel;
use App\Models\LMSTrainingModule;
use App\Models\LMSUserTrainingModule;
use App\Models\PhishingCampaign;
use App\Models\PhishingGroup;
use App\Models\PhishingMailTracking;
use App\Models\PhishingTemplate;
use App\Models\PhishingWebsitePage;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PHPMailer\PHPMailer\PHPMailer;
use Yajra\DataTables\Facades\DataTables;

class PhishingCampaignRepository implements PhishingCampaignInterface
{
    use PhishingMailTrait;
    public function index()
    {
        if (!auth()->user()->hasPermission('campaign.list')) {
            abort(403, 'Unauthorized action.');
        }

        session()->forget('campaign');
        $campaignData = session()->get('campaign');
        // dd($campaignData);
        $breadcrumbs = [
            ['link' => route('admin.phishing.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Campaign')]
        ];
        $campaigns = PhishingCampaign::withoutTrashed()->orderBy('created_at', 'desc')->get();
        $emailtemplate = PhishingTemplate::withoutTrashed()->orderBy('created_at', 'desc')->get();
        $employees = PhishingGroup::get();

        $courses = LMSCourse::withoutTrashed()->orderBy('created_at', 'desc')->get();
        $levels = LMSLevel::withoutTrashed()->orderBy('created_at', 'desc')->get();
        // $trainingModules = LMSTrainingModule::withoutTrashed()->orderBy('created_at', 'desc')->get();
        $trainingModules = LMSTrainingModule::with('level.course')->withoutTrashed()->orderBy('created_at', 'desc')->get();




        $campaigns_count = PhishingCampaign::withoutTrashed()->count();
        $campaigns_approve = PhishingCampaign::withoutTrashed()->whereIn('campaign_type',['simulated_phishing','security_awareness'])->where('approve',1)->count();
        $campaigns_pending = PhishingCampaign::withoutTrashed()->whereIn('campaign_type',['simulated_phishing','security_awareness'])->where('approve',0)->count();
        $campaigns_complete = PhishingCampaign::withoutTrashed()->whereIn('campaign_type',['simulated_phishing','security_awareness'])->where('delivery_status',1)->count();
        $campaigns_later = PhishingCampaign::withoutTrashed()->where('campaign_type','simulated_phishing')->where('delivery_type','later')->where('approve',0)->count();

        $now = Carbon::now();
        $campaigns_soon = PhishingCampaign::withoutTrashed()
        ->where('campaign_type','simulated_phishing')
        ->where('delivery_type', 'setup')
        ->where(function ($query) use ($now) {
            $query->where('schedule_date_from', '>', $now->toDateString())
                ->orWhere(function ($query) use ($now) {
                    $query->where('schedule_date_from', '=', $now->toDateString())
                          ->where('schedule_time_from', '>', $now->toTimeString());
                });
        })
        ->count();

        return view('admin.content.phishing.campaign.list', get_defined_vars());
    }

    public function PhishingCampaignDatatable1()
    {
        $campaigns = PhishingCampaign::withoutTrashed()->orderBy('created_at', 'desc');
        return DataTables::of($campaigns)->setRowId(function ($row) {
            static $index = 0;
            return $index++;
            // return $row->id;
        })->addColumn('actions', function ($row) {
            $data = '<div class="regulator-item">';
            if (!$row->approve) {
                if (auth()->user()->hasPermission('campaign.campaign_approve')) {
                $data .= ' <button class="btn btn-secondary show-frame trash-domain" type="button" data-bs-toggle="modal"
                                    data-id="' . $row->id . '" onclick="ShowModalApproveCampaign(' . $row->id . ')" data-name="' . $row->name . '">
                                    <i class="fas fa-check-circle"></i>
                                </button>';
                }
            }

            if ($row->delivery_type == 'later' && $row->approve) {
                // if (auth()->user()->hasPermission('campaign.campaign_approve')) {
                $data .= ' <button class="btn btn-secondary show-frame trash-domain" type="button" data-bs-toggle="modal"
                                    data-id="' . $row->id . '" onclick="ShowModalSendMails(' . $row->id . ')" data-name="' . $row->name . '">
                                    <i class="fa-solid fa-envelope"></i>
                                </button>';
                // }
            }

            if (auth()->user()->hasPermission('campaign.update')) {
                $data .= ' <button class="btn btn-secondary show-frame edit-regulator" type="button" data-bs-toggle="modal"
                                    data-id="' . $row->id . '">
                                    <i class="fa-solid fa-pen"></i>
                                </button>';
            }


            if (auth()->user()->hasPermission('campaign.trash')) {
                $data .= ' <button class="btn btn-secondary show-frame trash-domain" type="button" data-bs-toggle="modal"
                                    data-id="' . $row->id . '" onclick="ShowModalDeleteDomain(' . $row->id . ')" data-name="' . $row->name . '">
                                    <i class="fa-solid fa-trash"></i>
                                </button>';
            }

            $data .= '</div>';
            return $data;
        })->editColumn('created_at', function ($row) {
            $data = $row->created_at;

            return Carbon::parse($data)->format('Y-m-d g:ia');
        })->editColumn('status', function ($row) {
            return $row->approve ? ' <span class="badge rounded-pill badge-light-success">'.trans('locale.Approve').'  </span>' : '---';
        })->editColumn('delivery_status', function ($row) {
            return $row->created_at;
        })
        ->addIndexColumn()
        ->rawColumns(['actions', 'status'])
        ->make(true);
    }
    public function PhishingCampaignDatatable($type)
    {
        // Fetch campaigns excluding trashed ones, ordered by creation date (latest first)
        $campaigns = PhishingCampaign::withoutTrashed()->where('campaign_type', $type)->orderBy('created_at', 'desc');

        return DataTables::of($campaigns)
            // Set the row ID based on campaign ID
            ->setRowId(function ($row) {
                static $index = 0;
                return $index++;
                // return $row->id;
            })
            // Add actions column with a dropdown menu based on campaign status and user permissions
            ->addColumn('actions', function ($row) {
                $data = '<div class="dropdown">' .
                    '<a class="pe-1 dropdown-toggle hide-arrow text-primary" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">' .
                    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-small-4">' .
                    '<circle cx="12" cy="12" r="1"></circle>' .
                    '<circle cx="12" cy="5" r="1"></circle>' .
                    '<circle cx="12" cy="19" r="1"></circle>' .
                    '</svg>' .
                    '</a>' .
                    '<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">';

                // Add "Approve" button if the campaign is not approved and user has the necessary permission
                if (
                    !$row->approve &&
                    auth()->user()->hasPermission('campaign.campaign_approve')
                    // !empty($row->schedule_date_from) &&
                    // !empty($row->schedule_time_from) &&
                    // !empty($row->schedule_date_to) &&
                    // !empty($row->schedule_time_to)
                ) {
                    // دمج التاريخ والوقت
                    $startDateTime = Carbon::parse($row->schedule_date_from . ' ' . $row->schedule_time_from);
                    $endDateTime = Carbon::parse($row->schedule_date_to . ' ' . $row->schedule_time_to);
                    $now = now();

                    // التحقق من أن الوقت الحالي لم يتجاوز وقت النهاية
                    if ((($row->delivery_type == 'setup' && $now->lte($endDateTime)) || $row->delivery_type != 'setup') && !$row->approve) { // lte = أقل أو يساوي
                        $data .= '<li><a class="dropdown-item item-approve" href="javascript:;" onclick="ShowModalApproveCampaign(' . $row->id . ')">' .
                            '<i class="fas fa-check-circle me-50 font-small-4"></i>' .
                            'Approve</a></li>';
                    }
                }



                // Add "Send Mails" button if the campaign is scheduled for later and approved, and user has permission
                if ($row->delivery_type == 'later' && $row->approve && auth()->user()->hasPermission('campaign.campaign_approve') && $row->delivery_status != 1) {
                    $data .= '<li><a class="dropdown-item item-send-mails" href="javascript:;" onclick="ShowModalSendMails(' . $row->id . ')">' .
                        '<i class="fa-solid fa-envelope me-50 font-small-4"></i>' .
                        'Send Mails</a></li>';
                }
                // Add "Edit" button if user has permission to edit
                if (!$row->approve && auth()->user()->hasPermission('campaign.update')) {
                    $data .= '<li><a class="dropdown-item item-edit show-frame edit-regulator" data-bs-toggle="modal" data-id="' . $row->id . '">' .
                        '<i class="fa-solid fa-edit me-50 font-small-4"></i>' .
                        'Edit</a></li>';
                }

                // Add "Delete" button if user has permission to delete
                if (!$row->approve && auth()->user()->hasPermission('campaign.trash')) {
                    $data .= '<li><a class="dropdown-item item-delete" href="javascript:;" onclick="ShowModalDeleteDomain(' . $row->id . ')">' .
                        '<i class="fa-solid fa-trash me-50 font-small-4"></i>' .
                        'Delete</a></li>';
                }

                $data .= '</ul></div>';
                return $data;
            })
            // Format the creation date column
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('Y-m-d g:ia');
            })
            // Display status as a badge
            ->editColumn('status', function ($row) {
                return $row->approve
                    ? '<span class="badge rounded-pill badge-light-success">'.trans('locale.Approve').'</span>'
                    : '<span class="badge rounded-pill badge-light-warning">'.trans('locale.Pending').'</span>';
            })
            // Display delivery status (currently set to creation date, can be modified)
            ->editColumn('delivery_status', function ($row) {
                if ($row->campaign_type == 'simulated_phishing') {
                    $updateEmployee = DB::table('phishing_campaign_employee_list')
                        ->where('campaign_id', $row->id)
                        ->count();
                    $totalDeliveredEmployeeCount = DB::table('phishing_campaign_employee_list')
                        ->where('campaign_id', $row->id)
                        ->where('is_delivered', 1)
                        ->count();
                } else {
                    $updateEmployee = DB::table('phising_campaign_training_module')
                        ->where('campaign_id', $row->id)
                        ->count();
                    $totalDeliveredEmployeeCount = DB::table('phising_campaign_training_module')
                        ->where('campaign_id', $row->id)
                        ->where('is_delivered', 1)
                        ->count();
                }

                $assignedTrainings = $updateEmployee; // Replace with the actual count of assigned trainings
                $totalDeliveredEmployee = $totalDeliveredEmployeeCount; // Replace with the total number of trainings
                $percentage = ($assignedTrainings > 0) ? round(($totalDeliveredEmployee / $assignedTrainings) * 100) : 0;

                return '
                <div class="d-flex no-block align-items-center">
                    <div>
                        <h6 class="card-subtitle" style="color:dimgray; text-align:center;line-height: 17px">
                            ' . $totalDeliveredEmployee . ' of ' . $assignedTrainings . ' trainings assigned (' . $percentage . '%)
                        </h6>
            <div class="progress" style="width: 100%; height: 10px;
    margin-top: 9px;">
                <div class="progress-bar" role="progressbar" style="width: ' . $percentage . '%;" aria-valuenow="' . $percentage . '" aria-valuemin="0" aria-valuemax="100">
                    ' . $percentage . '%
                </div>
        </div>
                    </div>
                    <div class="ml-auto">
                    </div>
                </div>
            ';
            })

            // Render 'actions' and 'status' columns as raw HTML
            ->rawColumns(['actions', 'status', 'delivery_status'])
            ->addIndexColumn()

            // Return the DataTable response
            ->make(true);
    }



    // public function validateFirstStep(Request $request,PhishingCampaign $campaign = null)
    // {
    //     $campaign = $request->session()->get('campaign', new PhishingCampaign());
    //     if($request->formStep == 'form-step-one'){
    //         $validator = Validator::make($request->all(), [
    //             'campaign_name' => 'required|unique:phishing_campaigns,campaign_name|string|max:255',
    //             'campaign_type' => 'required|string',
    //             'training_frequency' => 'required_if:campaign_type,security_awareness',
    //             'selected_employees' => 'required',
    //         ]);

    //         if ($validator->fails()) {
    //             return response()->json(['errors' => $validator->errors()], 422);
    //         }
    //         $campaign->fill($request->all());
    //         $request->session()->put('campaign', $campaign);
    //         return response()->json(['success' => true,'sessionCampaign' =>  $request->session()->get('campaign')], 200);

    //     }elseif($request->formStep == 'form-step-two'){
    //         $validator = Validator::make($request->all(), [
    //             'email_templates' => 'required',
    //         ]);

    //         if ($validator->fails()) {
    //             return response()->json(['errors' => $validator->errors()], 422);
    //         }

    //         $campaign->fill($request->all());
    //         $request->session()->put('campaign', $campaign);
    //         return response()->json(['success' => true,'sessionCampaign' =>  $request->session()->get('campaign')], 200);
    //     }elseif($request->formStep == 'form-step-three'){
    //         $validator = Validator::make($request->all(), [
    //             'delivery_type' => 'required',
    //             'schedule_date_from' => 'required_if:delivery_type,setup',
    //             'schedule_date_to' => 'required_if:delivery_type,setup',
    //             'schedule_time_from' => 'required_if:delivery_type,setup',
    //             'schedule_time_to' => 'required_if:delivery_type,setup',

    //             'campaign_frequency' => 'required',
    //             'expire_after' => 'required_if:campaign_frequency,weekly,monthly,quarterly',
    //         ]);


    //         if ($validator->fails()) {
    //             return response()->json(['errors' => $validator->errors()], 422);
    //         }

    //         $campaign->fill($request->all());
    //         $request->session()->put('campaign', $campaign);
    //         \Log::info('Campaign Data Step 3:', $campaign->toArray());

    //         return response()->json(['success' => true, 'sessionCampaign' =>  $request->session()->get('campaign')], 200);

    //     }elseif($request->formStep == 'form-step-four'){
    //         try {
    //             $this->addNewCampaign($campaign);
    //             $request->session()->forget('campaign');
    //             return response()->json(['success' => true,'createdSuccessfully' => true, 'message' => 'Campaign completed successfully'], 200);
    //         } catch (\Exception $e) {
    //             return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    //         }
    //     }
    //     return response()->json(['success' => false, 'message' => 'Invalid step']);
    // }






    // public function validateFirstStep(Request $request, PhishingCampaign $campaign = null)
    // {
    //     $campaign = $request->session()->get('campaign', new PhishingCampaign());
    //     if($request->formStep == 'form-step-one'){
    //         // Validation for step one
    //         $validator = Validator::make($request->all(), [
    //             'campaign_name' => 'required|unique:phishing_campaigns,campaign_name|string|max:255',
    //             'campaign_type' => 'required|string',
    //             'training_frequency' => 'required_if:campaign_type,security_awareness',
    //             'selected_employees' => 'required',
    //         ]);

    //         if ($validator->fails()) {
    //             return response()->json(['errors' => $validator->errors()], 422);
    //         }

    //         // Merge the current step data with the existing session data
    //         $campaign->fill($request->only(['campaign_name', 'campaign_type', 'training_frequency', 'selected_employees']));
    //         $request->session()->put('campaign', $campaign);

    //         return response()->json(['success' => true, 'sessionCampaign' => $request->session()->get('campaign')], 200);

    //     } elseif($request->formStep == 'form-step-two'){
    //         // Validation for step two
    //         $validator = Validator::make($request->all(), [
    //             'email_templates' => 'required',
    //         ]);

    //         if ($validator->fails()) {
    //             return response()->json(['errors' => $validator->errors()], 422);
    //         }

    //         // Merge the current step data with the existing session data
    //         $campaign->fill($request->only(['email_templates']));
    //         $request->session()->put('campaign', $campaign);

    //         return response()->json(['success' => true, 'sessionCampaign' => $request->session()->get('campaign')], 200);

    //     } elseif($request->formStep == 'form-step-three'){
    //         // Validation for step three
    //         $validator = Validator::make($request->all(), [
    //             'delivery_type' => 'required',
    //             'schedule_date_from' => 'required_if:delivery_type,setup',
    //             'schedule_date_to' => 'required_if:delivery_type,setup',
    //             'schedule_time_from' => 'required_if:delivery_type,setup',
    //             'schedule_time_to' => 'required_if:delivery_type,setup',
    //             'campaign_frequency' => 'required',
    //             'expire_after' => 'required_if:campaign_frequency,weekly,monthly,quarterly',
    //         ]);

    //         if ($validator->fails()) {
    //             return response()->json(['errors' => $validator->errors()], 422);
    //         }

    //         // Merge the current step data with the existing session data
    //         $campaign->fill($request->only([
    //             'delivery_type', 'schedule_date_from', 'schedule_date_to',
    //             'schedule_time_from', 'schedule_time_to', 'campaign_frequency',
    //             'expire_after'
    //         ]));
    //         $request->session()->put('campaign', $campaign);

    //         return response()->json(['success' => true,'stepThreeNow' =>true, 'sessionCampaign' => $request->session()->get('campaign')], 200);

    //     } elseif($request->formStep == 'form-step-four'){
    //         // Final step, saving the campaign
    //         try {
    //             // $this->addNewCampaign($campaign);
    //             $this->addNewCampaign($request->session()->get('campaign'));
    //             // $request->session()->forget('campaign'); // Clear session after saving
    //             return response()->json(['success' => true, 'createdSuccessfully' => true, 'message' => 'Campaign completed successfully'], 200);
    //         } catch (\Exception $e) {
    //             return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    //         }
    //     }
    //     return response()->json(['success' => false, 'message' => 'Invalid step']);
    // }

    public function validateFirstStep(Request $request, PhishingCampaign $campaign = null)
    {
        $campaign = $request->session()->get('campaign', new PhishingCampaign());
        switch ($request->formStep) {
            case 'form-step-one':
                return $this->validateStepOne($request, $campaign);

            case 'form-step-two':
                return $this->validateStepTwo($request, $campaign);

            case 'form-step-three':
                return $this->validateStepThree($request, $campaign);

            case 'form-step-four':
                return $this->validateStepFour($request);

            case 'form-step-five':
                return $this->validateStepFive($request, $campaign);

            default:
                return response()->json(['success' => false, 'message' => 'Invalid step'], 400);
        }
    }



    protected function validateStepOne(Request $request, PhishingCampaign $campaign)
    {
        $validator = Validator::make($request->all(), [
            'campaign_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('phishing_campaigns', 'campaign_name')->where(function ($query) use($request) {
                    return $query->where('campaign_type', $request->campaign_type);
                }),
            ],
            // 'campaign_name' => 'required|unique:phishing_campaigns,campaign_name|string|max:255',
            'campaign_type' => 'required',
            // 'training_frequency' => 'required_if:campaign_type,security_awareness',
            'checkedEmployees' => 'required',
            // 'selected_employees' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $campaign->fill($request->only(['campaign_name', 'campaign_type', 'training_frequency', 'selected_employees', 'checkedEmployees']));
        $request->session()->put('campaign', $campaign);

        return response()->json(['success' => true, 'sessionCampaign' => $request->session()->get('campaign')], 200);
    }

    protected function validateStepTwo(Request $request, PhishingCampaign $campaign)
    {
        $validator = Validator::make($request->all(), [
            'email_templates' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $campaign->fill($request->only(['email_templates']));
        $request->session()->put('campaign', $campaign);

        return response()->json(['success' => true, 'sessionCampaign' => $request->session()->get('campaign')], 200);
    }

    protected function validateStepThree(Request $request, PhishingCampaign $campaign)
    {
        $rules = [
            'delivery_type' => 'required',
            'schedule_date_from' => 'required_if:delivery_type,setup',
            'schedule_date_to' => 'required_if:delivery_type,setup',
            'schedule_time_from' => 'required_if:delivery_type,setup',
            'schedule_time_to' => 'required_if:delivery_type,setup',
        ];

        if ($request->delivery_type == 'setup') {
            $rules = array_merge($rules,[
                'schedule_date_from' => 'before_or_equal:schedule_date_to',
                'schedule_date_to' => 'after_or_equal:schedule_date_from|after_or_equal:today',
                'schedule_time_from' => 'before_or_equal:schedule_time_to',
                'schedule_time_to' => 'after_or_equal:schedule_time_from',
            ]);
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $campaign->fill($request->only([
            'delivery_type',
            'schedule_date_from',
            'schedule_date_to',
            'schedule_time_from',
            'schedule_time_to',
            // 'campaign_frequency',
            // 'expire_after'
        ]));
        $request->session()->put('campaign', $campaign);
        return response()->json(['success' => true, 'stepThreeNow' => true, 'sessionCampaign' => $request->session()->get('campaign')], 200);
    }

    protected function validateStepFour(Request $request)
    {
        try {
            $newCampaign = $this->addNewCampaign($request->session()->get('campaign'));
            $request->session()->forget('campaign');
            return response()->json(['success' => true, 'createdSuccessfully' => true, 'message' => 'Campaign completed successfully','newCampaign' => $newCampaign], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    protected function validateStepFive(Request $request, PhishingCampaign $campaign)
    {
        $validator = Validator::make($request->all(), [
            'days_until_due' => 'required',
            'training_modules' => 'required',
            // 'selected_course_levels' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $campaign->fill($request->only([
            'days_until_due',
            'training_modules',
            'selected_course_levels'
        ]));
        $request->session()->put('campaign', $campaign);
        return response()->json(['success' => true, 'stepThreeNow' => true, 'sessionCampaign' => $request->session()->get('campaign')], 200);
    }

    public function validateEditFirstStep(Request $request,  $campaign_id , PhishingCampaign $campaign = null)
    {
        $campaign_id = PhishingCampaign::find($campaign_id);
        $campaign = $request->session()->get('campaign', new PhishingCampaign());
        switch ($request->formStep) {
            case 'form-step-one':
                return $this->validateStepEditOne($request, $campaign,$campaign_id);

            case 'form-step-two':
                return $this->validateStepEditTwo($request, $campaign);

            case 'form-step-three':
                return $this->validateStepEditThree($request, $campaign);

            case 'form-step-four':
                return $this->validateStepEditFour($request,$campaign_id);

            case 'form-step-five':
                return $this->validateStepEditFive($request, $campaign);

            default:
                return response()->json(['success' => false, 'message' => 'Invalid step'], 400);
        }
    }


    protected function validateStepEditOne(Request $request, PhishingCampaign $campaign,$campaign_id)
    {

        $validator = Validator::make($request->all(), [
            'campaign_name' => ['required', 'string', 'max:255', Rule::unique('phishing_campaigns', 'campaign_name')->ignore($campaign_id->id)],

            'campaign_type' => 'required',
            // 'training_frequency' => 'required_if:campaign_type,security_awareness',
            'selected_employees' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $campaign->fill($request->only(['campaign_name', 'campaign_type', 'training_frequency', 'selected_employees', 'checkedEmployees']));
        $request->session()->put('campaign', $campaign);

        return response()->json(['success' => true, 'sessionCampaign' => $request->session()->get('campaign')], 200);
    }

    protected function validateStepEditTwo(Request $request, PhishingCampaign $campaign)
    {
        $validator = Validator::make($request->all(), [
            'email_templates' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $campaign->fill($request->only(['email_templates']));
        $request->session()->put('campaign', $campaign);

        return response()->json(['success' => true, 'sessionCampaign' => $request->session()->get('campaign')], 200);
    }

    protected function validateStepEditThree(Request $request, PhishingCampaign $campaign)
    {
        $rules = [
            'delivery_type' => 'required',
            'schedule_date_from' => 'required_if:delivery_type,setup',
            'schedule_date_to' => [
                'nullable', // Allows null values
                'required_if:delivery_type,setup',
                'date',
            ],
            'schedule_time_from' => 'required_if:delivery_type,setup',
            'schedule_time_to' => 'required_if:delivery_type,setup',
        ];

        if ($request->input('delivery_type') === 'setup') {
            $rules['schedule_date_to'][] = 'after_or_equal:schedule_date_from';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $campaign->fill($request->only([
            'delivery_type',
            'schedule_date_from',
            'schedule_date_to',
            'schedule_time_from',
            'schedule_time_to',
        ]));

        $request->session()->put('campaign', $campaign);
        return response()->json([
            'success' => true,
            'stepThreeNow' => true,
            'sessionCampaign' => $request->session()->get('campaign')
        ], 200);
    }

    protected function validateStepEditFour(Request $request,$exit_campaign)
    {
        try {
            $this->EditCampaign($request->session()->get('campaign'),$exit_campaign);
            $request->session()->forget('campaign');
            return response()->json(['success' => true, 'createdSuccessfully' => true, 'message' => 'Campaign completed successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    protected function validateStepEditFive(Request $request, PhishingCampaign $campaign)
    {
        $validator = Validator::make($request->all(), [
            'days_until_due' => 'required',
            'training_modules' => 'required',
            // 'selected_course_levels' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $campaign->fill($request->only([
            'days_until_due',
            'training_modules',
            'selected_course_levels'
        ]));
        $request->session()->put('campaign', $campaign);
        return response()->json(['success' => true, 'stepThreeNow' => true, 'sessionCampaign' => $request->session()->get('campaign')], 200);
    }




    public function addNewCampaign($campaign)
    {
        try {
            DB::beginTransaction();
            $newCampaign = PhishingCampaign::create([
                'campaign_name' => $campaign->campaign_name,
                'campaign_type' => $campaign->campaign_type,
                // 'training_frequency' => $campaign->training_frequency,
                // 'expire_after' => $campaign->expire_after,
                'delivery_type' => $campaign->delivery_type,
                'schedule_date_from' => $campaign->schedule_date_from,
                'schedule_date_to' => $campaign->schedule_date_to,
                'schedule_time_from' => $campaign->schedule_time_from,
                'schedule_time_to' => $campaign->schedule_time_to,
                // 'campaign_frequency' => $campaign->campaign_frequency,
            ]);

            if (!empty($campaign->checkedEmployees)) {
                $newCampaign->employees()->attach($campaign->checkedEmployees);
            }

            $this->attachCampaignContent($newCampaign, $campaign);


            $levels = [];
            if (!empty($campaign->training_modules)) {
                foreach ($campaign->training_modules as $training) {
                    $train = LMSTrainingModule::find($training);
                    if ($train) {
                        $level = $train->level;
                        if ($level) {
                            array_push($levels, $level->id);
                        }
                    }
                }
            }

            if (!empty($campaign->checkedEmployees) && !empty($campaign->training_modules)) {
                foreach ($campaign->checkedEmployees as $employeeId) {
                    // User::find($employeeId)->trainingModules()->attach($campaign->training_modules,['days_until_due' => $campaign->days_until_due]);
                    // User::find($employeeId)->levels()->attach($levels);

                    $user = User::find($employeeId);
                    $user->trainingModules()->attach($campaign->training_modules, [
                        'days_until_due' => $campaign->days_until_due,
                        'campaign_id' => $newCampaign->id,
                    ]);
                    $user->levels()->syncWithoutDetaching($levels);
                }
            }

            DB::commit();
            return $newCampaign;
        } catch (\Exception $e) {
            // dd($e->getMessage());
            DB::rollBack();
        }
    }

    public function EditCampaign($campaign,$exit_campaign)
    {

        try {
            DB::beginTransaction();
            $exit_campaign->update([
                'campaign_name' => $campaign->campaign_name,
                'campaign_type' => $campaign->campaign_type,
                // 'training_frequency' => $campaign->training_frequency,
                // 'expire_after' => $campaign->expire_after,
                'delivery_type' => $campaign->delivery_type,
                'schedule_date_from' => $campaign->schedule_date_from,
                'schedule_date_to' => $campaign->schedule_date_to,
                'schedule_time_from' => $campaign->schedule_time_from,
                'schedule_time_to' => $campaign->schedule_time_to,
                // 'campaign_frequency' => $campaign->campaign_frequency,
            ]);

            if (!empty($campaign->checkedEmployees)) {
                $exit_campaign->employees()->sync($campaign->checkedEmployees);
            }

            $this->syncCampaignContent($exit_campaign, $campaign);


            $levels = [];
            if (!empty($campaign->training_modules)) {
                foreach ($campaign->training_modules as $training) {
                    $train = LMSTrainingModule::find($training);
                    if ($train) {
                        $level = $train->level;
                        if ($level) {
                            array_push($levels, $level->id);
                        }
                    }
                }
            }

            if (!empty($campaign->checkedEmployees) && !empty($campaign->training_modules)) {
                foreach ($campaign->checkedEmployees as $employeeId) {
                    // User::find($employeeId)->trainingModules()->attach($campaign->training_modules,['days_until_due' => $campaign->days_until_due]);
                    // User::find($employeeId)->levels()->attach($levels);

                    $user = User::find($employeeId);
                    $user->trainingModules()->attach($campaign->training_modules, ['days_until_due' => $campaign->days_until_due]);
                    $user->levels()->syncWithoutDetaching($levels);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            // dd($e->getMessage());
            DB::rollBack();
        }
    }

    protected function attachCampaignContent($newCampaign, $campaign)
    {
        switch ($campaign->campaign_type) {
            case 'simulated_phishing':
                if (!empty($campaign->email_templates)) {
                    $newCampaign->emailTemplates()->attach($campaign->email_templates);
                }
                break;

            case 'security_awareness':
                if (!empty($campaign->training_modules)) {
                    $newCampaign->trainingModules()->attach($campaign->training_modules);
                }
                break;

            default:
                if (!empty($campaign->email_templates)) {
                    $newCampaign->emailTemplates()->attach($campaign->email_templates);
                }
                if (!empty($campaign->training_modules)) {
                    $newCampaign->trainingModules()->attach($campaign->training_modules);
                }
                break;
        }
    }

    protected function syncCampaignContent($newCampaign, $campaign)
    {
        switch ($campaign->campaign_type) {
            case 'simulated_phishing':
                if (!empty($campaign->email_templates)) {
                    $newCampaign->emailTemplates()->sync($campaign->email_templates);
                }
                break;

            case 'security_awareness':
                if (!empty($campaign->training_modules)) {
                    $newCampaign->trainingModules()->sync($campaign->training_modules);
                }
                break;

            default:
                if (!empty($campaign->email_templates)) {
                    $newCampaign->emailTemplates()->sync($campaign->email_templates);
                }
                if (!empty($campaign->training_modules)) {
                    $newCampaign->trainingModules()->sync($campaign->training_modules);
                }
                break;
        }
    }

    public function getCampaignEmployees(Request $request)
    {
        $users = [];
        $groups = PhishingGroup::findMany($request->selectedEmployees);
        foreach ($groups as $group) {
            $users = array_merge($users, $group->users->pluck('id')->toArray());
        }
        $uniqUsers = array_unique($users);
        $employees = User::whereIn('id', $uniqUsers)->get();
        return response()->json(['employees' => $employees]);
    }

    public function getEmailTemplateData($id)
    {
        try {
            $EmailTemplate = PhishingTemplate::with('senderProfile.domain', 'website')->find($id);
            return response()->json(['EmailTemplate' => $EmailTemplate]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        try {
            $campaign = PhishingCampaign::with('employees', 'emailTemplates')->findOrFail($id);

            return response()->json(['success' => true, 'data' => $campaign]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function update($id, Request $request)
    {
        PhishingCampaign::findOrFail($id);
    }

    public function trash($campaign)
    {
        try {
            $campaign = PhishingCampaign::findOrFail($campaign);
            $campaign->update(['deleted_at' => now()]);

            $campaigns_data = $this->getCampaignsData();
            return response()->json(['status' => true, 'message' => __('phishing.CampaignWasDeletedSuccessfully'),'campaigns_data' => $campaigns_data], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => __('locale.Error')], 502);
        }
    }

    public function approve($campaign)
    {
        try {
            $campaign = PhishingCampaign::with(['employees', 'emailTemplates.website'])->findOrFail($campaign);
            $campaign->update(['approve' => 1]);
            if ($campaign->campaign_type === "simulated_phishing") {
                if ($campaign->delivery_type === 'immediatly') {
                    // SendCampaignEmailsJob::dispatch($campaign, $campaign->employees, $campaign->emailTemplates);
                    foreach ( $campaign->emailTemplates as $mail) {
                        foreach ($campaign->employees as $employee) {
                            $mailObject = new PhishingEmail($mail, $employee,$campaign->id);
                            $isSent = $this->sendPhishingMail2("hamam@pk.com", $mail, $employee->email, $mailObject);
                            // Update database based on email status
                            if ($isSent) {
                                $this->updateCampaignStatus($campaign,$mail, $employee);
                            }
                        }
                    }
                }
            } elseif ($campaign->campaign_type === "simulated_phishing_and_security_awareness") {
                if ($campaign->delivery_type === 'immediatly') {
                    SendCampaignEmailsJob::dispatch($campaign, $campaign->employees, $campaign->emailTemplates);
                }
            } else {
                $this->updateSecurityAwareness($campaign);
            }

            $campaigns_data = $this->getCampaignsData();
            return response()->json(['status' => true, 'message' => __('phishing.CampaignWasApproveSuccessfully'),'campaigns_data' => $campaigns_data], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => __('locale.Error')], 502);
        }
    }

    public function getCampaignsData()
    {

        $now = Carbon::now();
        $data['campaigns_count'] = PhishingCampaign::withoutTrashed()->count();
        $data['campaigns_approve'] = PhishingCampaign::withoutTrashed()->whereIn('campaign_type',['simulated_phishing','security_awareness'])->where('approve',1)->count();
        $data['campaigns_pending'] = PhishingCampaign::withoutTrashed()->whereIn('campaign_type',['simulated_phishing','security_awareness'])->where('approve',0)->count();
        $data['campaigns_complete'] = PhishingCampaign::withoutTrashed()->whereIn('campaign_type',['simulated_phishing','security_awareness'])->where('delivery_status',1)->count();
        $data['campaigns_later'] = PhishingCampaign::withoutTrashed()->where('campaign_type','simulated_phishing')->where('delivery_type','later')->where('approve',0)->count();
        $data['campaigns_soon'] = PhishingCampaign::withoutTrashed()
        ->where('campaign_type','simulated_phishing')
        ->where('delivery_type', 'setup')
        ->where(function ($query) use ($now) {
            $query->where('schedule_date_from', '>', $now->toDateString())
                ->orWhere(function ($query) use ($now) {
                    $query->where('schedule_date_from', '=', $now->toDateString())
                          ->where('schedule_time_from', '>', $now->toTimeString());
                });
        })
        ->count();
        return $data;
    }

    public function updateCampaignStatus($campaign,$mail, $employee)
    {
        try {
            switch ($campaign->campaign_type) {
                case "simulated_phishing":
                    $this->updateSimulatedPhishing($campaign,$mail, $employee);
                    break;

                case "simulated_phishing_and_security_awareness":
                    $this->updateSimulatedPhishingAndAwareness($campaign,$mail, $employee);
                    break;
                default:
                    dump("Failed to update PhishingEmployeeList records: Invalid campaign type.");
            }
        } catch (\Exception $e) {
            dump("Failed to update records: " . $e->getMessage());
        }
    }

    public function updateSimulatedPhishing($campaign,$mail, $employee)
    {
        DB::beginTransaction(); // Start a transaction

        try {
            // Update the phishing_campaign_employee_list table
            $updateEmployee = DB::table('phishing_campaign_employee_list')
                ->where('campaign_id', $campaign->id)
                ->where('employee_id', $employee->id)
                ->update(['is_delivered' => 1]);

            // Check if the first query was successful
            if ($updateEmployee === false) {
                throw new \Exception('Failed to update phishing_campaign_employee_list');
            }

            // Update the phishing_campaign_email_template table
            $updateTemplate = DB::table('phishing_campaign_email_template')
                ->where('campaign_id', $campaign->id)
                ->where('email_template_id', $mail->id)
                ->update(['is_delivered' => 1]);

            // Check if the second query was successful
            if ($updateTemplate === false) {
                throw new \Exception('Failed to update phishing_campaign_email_template');
            }

            // Update the phishing_campaigns table
            $updateCampaign = DB::table('phishing_campaigns')
                ->where('id', $campaign->id)
                ->update(['delivery_status' => 1]);

            // Check if the third query was successful
            if ($updateCampaign === false) {
                throw new \Exception('Failed to update phishing_campaigns');
            }

            // Commit the transaction if all queries are successful
            DB::commit();
            return true; // All queries were successful

        } catch (\Exception $e) {
            // Rollback the transaction if any query fails
            DB::rollBack();

            // Log the error for debugging
            dd('Error in updateSimulatedPhishing: ' . $e->getMessage());

            return false; // Indicate failure
        }
    }

    public function updateSimulatedPhishingAndAwareness($campaign,$mail, $employee)
    {
        DB::table('phishing_campaign_employee_list')
            ->where('campaign_id', $campaign->id)
            ->where('employee_id', $employee->id)
            ->update(['is_delivered' => 1]);

        DB::table('phishing_campaign_email_template')
            ->where('campaign_id', $campaign->id)
            ->where('email_template_id', $mail->id)
            ->update(['is_delivered' => 1]);

        DB::table('phising_campaign_training_module')
            ->where('campaign_id', $campaign->id)
            ->update(['is_delivered' => 1]);
    }
    public function updateSecurityAwareness($campaign)
    {
        $trainings = DB::table('phising_campaign_training_module')
            ->where('campaign_id', $campaign->id)
            ->pluck('training_module_id');

        $employees = DB::table('phishing_campaign_employee_list')
            ->where('campaign_id', $campaign->id)
            ->pluck('employee_id');

        DB::table('l_m_s_user_training_modules')
            ->whereIn('user_id', $employees)
            ->whereIn('training_module_id', $trainings)
            ->update(['is_delivered' => 1]);

        DB::table('phising_campaign_training_module')
            ->where('campaign_id', $campaign->id)
            ->update(['is_delivered' => 1]);

        // Update the phishing_campaigns table
        $updateCampaign = DB::table('phishing_campaigns')
            ->where('id', $campaign->id)
            ->update(['delivery_status' => 1]);
    }
    public function sendMail($campaign, $employees)
    {


        $response = [
            'status' => false,
            'errors' => [],
            'message' => '',
        ];

        // Send an email to each employee associated with the campaign
        foreach ($employees as $employee) {
            try {
                //   $test=  Mail::to($employee->email)->queue(new PhishingEmail($campaign, $employee));
                Mail::to($employee->email)->send(new PhishingEmail($campaign, $employee)); // Passing the model instance
                $response['status'] = true;
                $response['message'] = __('Emails sent successfully.');
            } catch (\Exception $e) {
                $response['errors'][] = $e->getMessage();
                $response['message'] = __('Failed to send some emails.');
            }
        }

        return $response;
    }
    public function sendLaterMail($campaign)
    {
        $campaign = PhishingCampaign::with(['employees', 'emailTemplates.website'])->findOrFail($campaign);

        if ($campaign->campaign_type === "simulated_phishing") {
            if ($campaign->delivery_type === 'later') {
                // SendCampaignEmailsJob::dispatch($campaign, $campaign->employees, $campaign->emailTemplates);
                foreach ( $campaign->emailTemplates as $mail) {
                    foreach ($campaign->employees as $employee) {
                        $mailObject = new PhishingEmail($mail, $employee,$campaign->id);
                        $isSent = $this->sendPhishingMail2("hamam@pk.com", $mail, $employee->email, $mailObject);
                        // Update database based on email status
                        if ($isSent) {
                            $this->updateCampaignStatus($campaign,$mail, $employee);
                        }
                    }
                }
            }
        } elseif ($campaign->campaign_type === "simulated_phishing_and_security_awareness") {
            if ($campaign->delivery_type === 'later') {
                SendCampaignEmailsJob::dispatch($campaign, $campaign->employees, $campaign->emailTemplates);
            }
        } else {
            $this->updateSecurityAwareness($campaign);
        }
    }



    public function getArchivedcampaign()
    {
        return view('admin.content.phishing.campaign.archived');
    }

    public function archivedCampaignDatatable()
    {
        $campaigns = PhishingCampaign::onlyTrashed()->orderBy('deleted_at', 'desc');
        return DataTables::of($campaigns)->setRowId(function ($row) {
            return $row->id;
        })->addColumn('actions', function ($row) {
            $data = '<div class="regulator-item">';
            if (auth()->user()->hasPermission('campaign.restore')) {
                $data = $data . '<button class="btn btn-secondary show-frame trash-domain" type="button" data-bs-toggle="modal"
                data-id="' . $row->id . '" onclick="ShowModalRestoreDomain(' . $row->id . ')" data-name="' . $row->name . '">
                                           <i class="fa-solid fa-undo"></i>
            </button>';
            }
            if (auth()->user()->hasPermission('campaign.delete')) {
                $data = $data . ' <button class="btn btn-secondary show-frame trash-domain" type="button" data-bs-toggle="modal"
                data-id="' . $row->id . '" onclick="ShowModalDeleteDomain(' . $row->id . ')" data-name="' . $row->name . '">
                                            <i class="fa-solid fa-trash"></i>
            </button>';
            }
            $data = $data . '</div>';
            return $data;
        })->editColumn('created_at', function ($row) {
            $data = $row->created_at;

            return Carbon::parse($data)->format('Y-m-d g:ia');
        })->editColumn('delivery_status', function ($row) {
            $updateEmployee = DB::table('phishing_campaign_employee_list')
                ->where('campaign_id', $row->id)
                ->count();
            return $updateEmployee;
        })->rawColumns(['actions'])
            ->make(true);
    }

    public function restore($id, Request $request)
    {
        try {
            $campaign = PhishingCampaign::onlyTrashed()->findOrFail($id);
            $campaign->restore();
            return response()->json(['status' => true, 'message' => __('phishing.CampaignRestoreSuccessfully')], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => __('locale.Error')], 502);
        }
    }
    public function delete($id)
    {
        try {
            $campaign = PhishingCampaign::onlyTrashed()->findOrFail($id);
            $campaign->forceDelete();
            $campaigns_data = $this->getCampaignsData();
            return response()->json(['status' => true, 'message' => __('phishing.CampaignWasDeletedSuccessfully'),'campaigns_data' => $campaigns_data], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => __('locale.Error')], 502);
        }
    }

    public function sendTestEmail($campaingId)
    {
        try {
            /* just for test connection */

            // $res = $this->sendPhishingMailTest();
            // dd($res);





            $mail = PhishingTemplate::find(10);
            $employee = User::find(1);
            $mailObject = new PhishingEmail($mail, $employee,$campaingId);
            $res = $this->sendPhishingMail2("hamam33@sales.com", $mail, 'khaled@pk.com', $mailObject);



            /* just for test code */
            $campaign = PhishingCampaign::with('emailTemplates', 'employees')->findOrFail($campaingId);
            foreach ($campaign->emailTemplates as $mail) {
                foreach ($campaign->employees as $employee) {
                    $mailObject = new PhishingEmail($mail, $employee,$campaingId);
                    $res = $this->sendPhishingMail2("hamam@pk.com", $mail, 'khaled@pk.com', $mailObject);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function mailOpened(Request $request)
    {
        try {
            $emailId = $request->query('PMTI');
            $employeeId = $request->query('PEI');
            $campaignId = $request->query('PCI');

            Log::info('Mail opened', ['emailId' => $emailId, 'employeeId' => $employeeId,'campaignId' => $campaignId]);

            if ($emailId && $employeeId) {
                PhishingMailTracking::updateOrCreate([
                    'campaign_id' => $campaignId,
                    'email_id' => $emailId,
                    'employee_id' => $employeeId,
                ], [
                    'opened_at' => now(),
                ]);
                return true;
            }
        } catch (\Exception $e) {
            Log::error('Error in mailOpened', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function clickOnLink(Request $request, $id)
    {
        try {
            $emailId = $request->query('PMTI');
            $employeeId = $request->query('PEI');
            $campaignId = $request->query('PCI');

            Log::info('Click on link', ['emailId' => $emailId, 'employeeId' => $employeeId]);

            if ($emailId && $employeeId) {
                PhishingMailTracking::updateOrCreate([
                    'campaign_id' => $campaignId,
                    'email_id' => $emailId,
                    'employee_id' => $employeeId,
                ], [
                    'campaign_id' => $campaignId,
                    'email_id' => $emailId,
                    'employee_id' => $employeeId,
                    'Page_link_clicked_at' => now(),
                ]);
            }

            $website = PhishingWebsitePage::find($id);
            return view('admin.content.phishing.websites.website', get_defined_vars());
        } catch (\Exception $e) {
            Log::error('Error in click on link', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function mailFormSubmited(Request $request)
    {
        try {
            $emailId = $request->query('PMTI');
            $employeeId = $request->query('PEI');
            $campaignId = $request->query('PCI');

            if ($emailId && $employeeId) {
                PhishingMailTracking::updateOrCreate([
                    'campaign_id' => $campaignId,
                    'email_id' => $emailId,
                    'employee_id' => $employeeId,
                ], [
                    'campaign_id' => $campaignId,
                    'email_id' => $emailId,
                    'employee_id' => $employeeId,
                    'submited_at' => now(),
                ]);
                return 'Form Data is Submited Successfully';
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function mailAttachmentDownloaded(Request $request)
    {
        try {
            $emailId = $request->query('PMTI');
            $employeeId = $request->query('PEI');
            $fileName = $request->query('PMTF');
            $campaignId = $request->query('PCI');

            PhishingMailTracking::updateOrCreate([
                'campaign_id' => $campaignId,
                'email_id' => $emailId,
                'employee_id' => $employeeId,
            ], [
                'campaign_id' => $campaignId,
                'email_id' => $emailId,
                'employee_id' => $employeeId,
                'downloaded_at' => now(),
            ]);

            $filePath = public_path("{$fileName}");
            return response()->download($filePath);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    // Campaign data;
    public function getCampaignData($id)
    {
        $campaign = PhishingCampaign::withTrashed()->with([
            'employees.deliverdCampaigns' => function ($query) use ($id) {
                $query->where('campaign_id', $id)
                    ->with(['deliverdEmailTemplates' => function ($query) {
                        $query->withCount(['openedMails', 'clickedOnLink', 'submitedDataInMails', 'downloadedFileInMails']);
                    }]);
            }
        ])->findOrFail($id);

        $employees = $campaign->employees;
        return DataTables::of($employees)->setRowId(function ($row) {
            return $row->id;
        })
            ->addColumn('delivered', function ($row) {
                return $row->deliverdCampaigns->count() > 0 ? 'Yes' : 'No';
            })
            ->addColumn('count_of_opened', function ($row) use ($id) {
                return $this->getEmployeeTrack($id, $row, 'opened_at');
            })
            ->addColumn('count_of_clik', function ($row) use ($id) {
                return $this->getEmployeeTrack($id, $row, 'Page_link_clicked_at');
            })
            ->addColumn('count_of_submited', function ($row) use ($id) {
                return $this->getEmployeeTrack($id, $row, 'submited_at');
            })
            ->addColumn('count_of_downloaded', function ($row) use ($id) {
                return $this->getEmployeeTrack($id, $row, 'downloaded_at');
            })
            ->editColumn('created_at', function ($row) {
                $data = $row->created_at;
                return Carbon::parse($data)->format('Y-m-d g:ia');
            })
            ->addColumn('actions', function ($row) {
                $data = '<div class="regulator-item">';
                $data = $data . '</div>';
                return $data;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function getEmployeeTrack($id, $row, $columnName)
    {
        return DB::table('phishing_campaigns')
            ->join('phishing_campaign_employee_list', 'phishing_campaign_employee_list.campaign_id', '=', 'phishing_campaigns.id')
            ->join('phishing_campaign_email_template', 'phishing_campaign_email_template.campaign_id', '=', 'phishing_campaigns.id')
            ->join('phishing_mail_trackings', function ($join) {
                $join->on('phishing_mail_trackings.employee_id', '=', 'phishing_campaign_employee_list.employee_id')
                    ->on('phishing_mail_trackings.email_id', '=', 'phishing_campaign_email_template.email_template_id');
            })
            ->where('phishing_campaign_employee_list.campaign_id', $id)
            ->where('phishing_mail_trackings.employee_id', $row->id)
            ->whereNotNull('phishing_mail_trackings.' . $columnName)
            ->count();
    }

    // Training Data Table
    public function getActiveTrainingCampaignData(Request $request)
    {
        $activeTrainingCampaign = PhishingCampaign::withoutTrashed()
            ->withCount(['userTraining'])
            ->whereIn('campaign_type', ['security_awareness', 'simulated_phishing_and_security_awareness'])
            ->orderBy('created_at', 'desc');
        return $this->getTrainDataTable($activeTrainingCampaign);
    }
    public function getArchivedTrainingCampaignData(Request $request)
    {
        $archivedTrainingCampaign = PhishingCampaign::onlyTrashed()
            ->withCount(['userTraining'])
            ->whereIn('campaign_type', ['security_awareness', 'simulated_phishing_and_security_awareness'])
            ->orderBy('created_at', 'desc');
        return $this->getTrainDataTable($archivedTrainingCampaign);
    }

    public function getTrainDataTable($data)
    {
        return DataTables::of($data)->setRowId(function ($row) {
            return $row->id;
        })
            ->addColumn('employee_count', function ($row) {
                return $row->user_training_count;
                // return $row->trainingModules->sum(function ($trainingModule) {
                //     return $trainingModule->users()->count();
                // });
            })
            ->editColumn('campaign_type', function ($row) {
                return $row->campaign_type == 'security_awareness' ? 'Training' : 'Phishing + Training';
            })
            ->addColumn('schedule_date', function ($row) {
                return Carbon::parse($row->created_at)->format('Y-m-d g:ia');
            })
            ->addColumn('completed', function ($row) {
                return $row->trainingModules->flatMap(function ($trainingModule) {
                    return $trainingModule->users()->wherePivot('passed', 1)->get();
                })->unique('id')->count();
            })
            ->addColumn('assigned', function ($row) {
                return $row->trainingModules->flatMap->users->unique('id')->count();
            })
            ->addColumn('overdue', function ($row) {
                $today = Carbon::today();
                return $row->trainingModules->sum(function ($trainingModule) use ($today) {
                    return $trainingModule->users()
                        ->wherePivot('passed', 0)
                        ->whereRaw("DATE_ADD( l_m_s_user_training_modules.created_at, INTERVAL  l_m_s_user_training_modules.days_until_due DAY) < ?", [$today])
                        ->count();
                });
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('Y-m-d g:ia');
            })
            ->rawColumns(['employee_count', 'schedule_date', 'completed', 'assigned', 'overdue'])
            ->make(true);
    }

    public function getEmployeeOfTrainingCampaign($id)
    {
        $activeTrainingCampaign = PhishingCampaign::withTrashed()
            // ->with(['trainingModules.users' => function ($query) {
            ->with(['userTraining' => function ($query) {
                $query->withPivot('score', 'passed', 'created_at', 'completed_at', 'days_until_due','training_module_id');
            }])
            ->findOrFail($id);

            return DataTables::of($activeTrainingCampaign->userTraining->map(function ($userTraining) {
                return [
                    'training_name' => LMSTrainingModule::find($userTraining->pivot->training_module_id)->name ?? '-',
                    'user_name' => $userTraining->name,
                    'user_email' => $userTraining->email,
                    'score' => $userTraining->pivot->score,
                    'passed' => $userTraining->pivot->passed,
                    'date_assigned' => $userTraining->pivot->created_at,
                    'completed_at' => $userTraining->pivot->completed_at,
                    'days_until_due' => $userTraining->pivot->days_until_due,
                ];
            }))

        // return DataTables::of($activeTrainingCampaign->trainingModules->flatMap(function ($trainingModule) {
        //     return $trainingModule->users->map(function ($user) use ($trainingModule) {
        //         return [
        //             'training_name' => $trainingModule->name,
        //             'user_name' => $user->name,
        //             'user_email' => $user->email,
        //             'score' => $user->pivot->score,
        //             'passed' => $user->pivot->passed,
        //             'date_assigned' => $user->pivot->created_at,
        //             'completed_at' => $user->pivot->completed_at,
        //             'days_until_due' => $user->pivot->days_until_due,
        //         ];
        //     });
        // }))
            ->setRowId(function ($row) {
                return $row['user_email'];
            })
            ->addColumn('training_name', function ($row) {
                return $row['training_name'];
            })
            ->addColumn('user_email', function ($row) {
                return $row['user_email'];
            })
            ->addColumn('date_assigned', function ($row) {
                return $row['date_assigned'];
            })
            ->addColumn('user_name', function ($row) {
                return $row['user_name'];
            })
            ->addColumn('score', function ($row) {
                return $row['score'] . '%';
            })
            ->addColumn('completed', function ($row) {
                return $row['completed_at'] != null ? true : false;
            })
            ->addColumn('overdue', function ($row) {
                $today = Carbon::today();
                $assignedDate = Carbon::parse($row['date_assigned']);
                $dueDate = $assignedDate->addDays($row['days_until_due']);
                return ($today->gt($dueDate) && $row['passed'] == 0) ? 'Overdue' : 'Not Overdue';
            })
            ->editColumn('passed', function ($row) {
                return $row['passed'] ? 'Passed' : 'Not Passed';
            })
            ->rawColumns(['training_name', 'user_email', 'score', 'passed'])
            ->make(true);
    }

    // Phishing Data Table
    public function getActivePhishingDataTable(Request $request)
    {
        // Fetch all active campaigns and filter only those with `campaign_type` == 'simulated_phishing'
        $activeCampaigns = $this->getActiveCampaignMailStatistic()->filter(function ($campaign) {
            return $campaign->campaign_type == 'simulated_phishing';
        });

        return DataTables::of($activeCampaigns)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->editColumn('campaign_type', function ($row) {
                return $row->campaign_type == 'simulated_phishing' ? 'Phishing' : '';
            })
            ->addColumn('schedule_date', function ($row) {
                return Carbon::parse($row->created_at)->format('Y-m-d g:ia');
            })
            ->editColumn('approve', function ($row) {
                return $row->approve == 1
                    ? '<span class="badge badge-success">'.trans('locale.Approve').'</span>'
                    : '<span class="badge badge-warning">'.trans('locale.Pending').'</span>';
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('Y-m-d g:ia');
            })
            ->rawColumns(['approve'])
            ->make(true);
    }


    public function getActiveCampaignMailStatistic()
    {
        return PhishingCampaign::withoutTrashed()
            ->whereIn('campaign_type', ['simulated_phishing'])
            ->withCount('deliverdEmailTemplates')
            ->get()
            ->map(function ($campaign) {
                $opend_count = 0;
                $submited_count = 0;
                $downloaded_count = 0;

                $campaign->emailTemplates->each(function ($emailTemplate) use (&$opend_count, &$downloaded_count, &$submited_count) {
                    $opend_count += $emailTemplate->openedMails()->count();
                    $submited_count += $emailTemplate->submitedDataInMails()->count();
                    $downloaded_count += $emailTemplate->downloadedFileInMails()->count();
                });

                $campaign->opend_count = $opend_count;
                $campaign->submited_count = $submited_count;
                $campaign->downloaded_count = $downloaded_count;

                return $campaign;
            });
    }

    public function getArchivedPhishingDataTable(Request $request)
    {
        $archivedCampaigns =  $this->getArchivedCampaignMailStatistic();
        return DataTables::of($archivedCampaigns)->setRowId(function ($row) {
            return $row->id;
        })
            ->editColumn('campaign_type', function ($row) {
                return $row->campaign_type == 'simulated_phishing' ? 'Phishing' : 'Phishing + Training';
            })
            ->addColumn('schedule_date', function ($row) {
                return Carbon::parse($row->created_at)->format('Y-m-d g:ia');
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('Y-m-d g:ia');
            })
            ->make(true);
    }
    public function getArchivedCampaignMailStatistic()
    {
        return PhishingCampaign::onlyTrashed()
            ->whereIn('campaign_type', ['simulated_phishing', 'simulated_phishing_and_security_awareness'])
            ->withCount('deliverdEmailTemplates')
            ->get()
            ->map(function ($campaign) {
                $opend_count = 0;
                $submited_count = 0;
                $downloaded_count = 0;

                $campaign->emailTemplates->each(function ($emailTemplate) use (&$opend_count, &$downloaded_count, &$submited_count) {
                    $opend_count += $emailTemplate->openedMails()->count();
                    $submited_count += $emailTemplate->submitedDataInMails()->count();
                    $downloaded_count += $emailTemplate->downloadedFileInMails()->count();
                });

                $campaign->opend_count = $opend_count;
                $campaign->submited_count = $submited_count;
                $campaign->downloaded_count = $downloaded_count;
                return $campaign;
            });
    }

    // Employee Statistic Data Table
    public function getPhisedEmployeeDataTable()
    {
        $data = $this->getPhisedEmployee();
        return DataTables::of($data)->setRowId(function ($row) {
            return $row->employee_id;
        })
            ->editColumn('name', function ($row) {
                return $row->name;
            })
            ->editColumn('email', function ($row) {
                return $row->email;
            })
            ->editColumn('average_percentage', function ($row) {
                return $row->average_percentage;
            })
            ->make(true);
    }

    public function getTrainingEmployeeDataTable()
    {
        $data = $this->getTrainingEmployee();
        return DataTables::of($data)->setRowId(function ($row) {
            return $row->user_id;
        })
            ->editColumn('name', function ($row) {
                return $row->name;
            })
            ->editColumn('email', function ($row) {
                return $row->email;
            })
            ->make(true);
    }
    public function getPhisedEmployee()
    {
        return DB::table('phishing_mail_trackings')
            ->join('users', 'phishing_mail_trackings.employee_id', '=', 'users.id')
            ->select(
                'phishing_mail_trackings.employee_id',
                'users.name',
                'users.email',
                DB::raw('
                    COUNT(*) as total_rows,
                    SUM(
                        CASE
                            WHEN opened_at IS NOT NULL AND submited_at IS NOT NULL AND downloaded_at IS NOT NULL AND Page_link_clicked_at IS NOT NULL THEN 100
                            ELSE
                                (CASE WHEN opened_at IS NOT NULL THEN 25 ELSE 0 END) +
                                (CASE WHEN submited_at IS NOT NULL THEN 25 ELSE 0 END) +
                                (CASE WHEN Page_link_clicked_at IS NOT NULL THEN 25 ELSE 0 END) +
                                (CASE WHEN downloaded_at IS NOT NULL THEN 25 ELSE 0 END)
                        END
                    ) AS total_points
                ')
            )
            ->groupBy('phishing_mail_trackings.employee_id')
            ->orderByDesc('total_points')
            ->get()
            ->map(function ($employee) {
                $maxPossiblePoints = $employee->total_rows * 100;
                $employee->average_percentage = number_format(($employee->total_points / $maxPossiblePoints) * 100, 2);
                return $employee;
            })
            ->sortByDesc('average_percentage')
            ->values();
    }

    public function getTrainingEmployee()
    {
        return DB::table('l_m_s_user_training_modules')
            ->join('users', 'l_m_s_user_training_modules.user_id', '=', 'users.id')
            ->select(
                'l_m_s_user_training_modules.user_id',
                'users.name','users.email',
            )
            ->groupBy('l_m_s_user_training_modules.user_id')
            ->get()
            ->values();
    }

    public function getEmployeePhishingDataTable($id)
    {
        $user = User::with('campaigns.emailTemplates')->find($id);
        return DataTables::of($user->campaigns->flatMap(function ($campaign) use ($id) {
            return $campaign->emailTemplates->map(function ($emailTemplate) use ($campaign, $id) {
                $tracking = $emailTemplate->mailTracking()
                    ->where('employee_id', $id)
                    ->first();

                return [
                    'campaign_name' => $campaign->campaign_name,
                    'template_name' => $emailTemplate->name,
                    'is_opened' => !is_null($tracking) && !is_null($tracking->opened_at),
                    'is_data_submitted' => !is_null($tracking) && !is_null($tracking->submited_at),
                    'is_file_downloaded' => !is_null($tracking) && !is_null($tracking->downloaded_at),
                    'is_link_clicked' => !is_null($tracking) && !is_null($tracking->Page_link_clicked_at),
                ];
            });
        }))
            ->make(true);
    }
    public function getEmployeeTrainingCampaignData($id)
    {
        $user = User::with(['campaigns.trainingModules' => function ($query) use ($id) {
            $query->whereHas('users', function ($subQuery) use ($id) {
                $subQuery->where('user_id', $id);
            });
        }])->findOrFail($id);

        // dump($id);
        // dd($user);

        return DataTables::of($user->campaigns->flatMap(function ($campaign) use ($id) {
            return $campaign->trainingModules->map(function ($trainingModule) use ($id, $campaign) {
                $pivotData = $trainingModule->users->firstWhere('id', $id)->pivot;
                return [
                    'campaign_name' => $campaign->campaign_name,
                    'training_name' => $trainingModule->name,
                    'score' => $pivotData->score,
                    'passed' => $pivotData->passed,
                    'date_assigned' => $pivotData->created_at,
                    'completed_at' => $pivotData->completed_at,
                    'days_until_due' => $pivotData->days_until_due,
                ];
            });
        }))
            ->addColumn('campaign_name', function ($row) {
                return $row['campaign_name'];
            })
            ->addColumn('training_name', function ($row) {
                return $row['training_name'];
            })

            ->addColumn('date_assigned', function ($row) {
                return $row['date_assigned']->format('Y-m-d');
            })
            ->addColumn('score', function ($row) {
                return $row['score'] . '%';
            })
            ->addColumn('completed', function ($row) {
                return $row['completed_at'] ? 'Yes' : 'No';
            })
            ->addColumn('overdue', function ($row) {
                $today = Carbon::today();
                $assignedDate = Carbon::parse($row['date_assigned']);
                $dueDate = $assignedDate->addDays($row['days_until_due']);
                return ($today->gt($dueDate) && !$row['passed']) ? 'Overdue' : 'Not Overdue';
            })
            ->editColumn('passed', function ($row) {
                return $row['passed'] ? 'Passed' : 'Not Passed';
            })
            ->rawColumns(['campaign_name', 'training_name', 'score', 'passed'])
            ->make(true);
    }


    public function phishingNotification(Request $request)
    {
        try {
            // defining the breadcrumbs that will be shown in page
            $breadcrumbs = [
                ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
                ['link' => route('admin.phishing.campaign.index'), 'name' => __('local.Campaign')], // give it your own route
                ['name' => __('locale.NotificationsSettings')]
            ];
            $users = User::where('enabled', true)->with('manager:id,name,manager_id')->get();  // getting all users to list them in select input of users
            $moduleActionsIds = [130,131,132];   // defining ids of actions modules in ActionSeeder (system notification part)
            $moduleActionsIdsAutoNotify = [133];  // defining ids of actions modules (auto notify part)

            // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
            $actionsVariables = [
                130 => ['Name', 'Type'], // add new campaign
                131 => ['Name', 'Type'], // apaprove existing campaign
                132 => ['Name', 'Type'], // send campaign
                133 => ['Name', 'Type'], // send campaign
            ];
            // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
            $actionsRoles = [
                130 => [
                    'Name' => __('local.Campaign Name'),
                    'Type' => __('Campaign type'),
                ],
                131 => [
                    'Name' => __('local.Campaign Name'),
                    'Type' => __('Campaign type'),
                ],
                132 => [
                    'Name' => __('local.Campaign Name'),
                    'Type' => __('Campaign type'),
                ],

                133 => [
                    'Name' => __('local.Campaign Name'),
                    'Type' => __('Campaign type'),
                ],
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
            return view('admin.content.phishing.campaign.notifications-settings.index', get_defined_vars());
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

}

