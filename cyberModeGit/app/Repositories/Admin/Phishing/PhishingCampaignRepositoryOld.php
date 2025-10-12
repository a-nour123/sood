<?php


namespace App\Repositories\Admin\Phishing;

use App\Http\Traits\PhishingMailTrait;
use App\Interfaces\Admin\Phishing\PhishingCampaignInterface;
use App\Mail\PhishingEmail;
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
use Illuminate\Support\Facades\Validator;
use PHPMailer\PHPMailer\PHPMailer;
use Yajra\DataTables\Facades\DataTables;

class PhishingCampaignRepositoryOld implements PhishingCampaignInterface
{
    use PhishingMailTrait;
    public function index()
    {
        session()->forget('campaign');
        $campaignData = session()->get('campaign');
        // dd($campaignData);
        $breadcrumbs = [
            ['link' => route('admin.phishing.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('Campaign')]
        ];
        $campaigns = PhishingCampaign::withoutTrashed()->orderBy('created_at','desc')->get();
        $emailtemplate = PhishingTemplate::withoutTrashed()->orderBy('created_at','desc')->get();
        $employees = PhishingGroup::get();
        return view('admin.content.phishing.campaign.list', get_defined_vars());
    }

    public function PhishingCampaignDatatable()
    {
        $campaigns = PhishingCampaign::withoutTrashed()->orderBy('created_at','desc');
        return DataTables::of($campaigns)->setRowId(function ($row) {
            return $row->id;
        })->addColumn('actions', function ($row) {
                $data = '<div class="regulator-item">';
                $data = $data.' <button class="btn btn-secondary show-frame edit-regulator" type="button" data-bs-toggle="modal"
                                    data-id="'.$row->id.'"
                                    ><i class="fa-solid fa-pen"></i>
                                </button>';

                $data = $data.' <button class="btn btn-secondary show-frame trash-domain" type="button" data-bs-toggle="modal"
                        data-id="'.$row->id.'" onclick="ShowModalDeleteDomain('.$row->id.')" data-name="'.$row->name.'">
                    <i class="fa-solid fa-trash"></i>
                </button>';

                $data = $data.'</div>';

            return $data;
        })->editColumn('created_at', function ($row) {
            $data = $row->created_at;

            return Carbon::parse($data)->format('Y-m-d g:ia');
        })->editColumn('delivery_status', function ($row) {
           return $row->created_at;
        })->rawColumns(['actions'])
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


    public function validateFirstStep(Request $request, PhishingCampaign $campaign = null)
    {
        $campaign = $request->session()->get('campaign', new PhishingCampaign());
        if($request->formStep == 'form-step-one'){
            // Validation for step one
            $validator = Validator::make($request->all(), [
                'campaign_name' => 'required|unique:phishing_campaigns,campaign_name|string|max:255',
                'campaign_type' => 'required|string',
                'training_frequency' => 'required_if:campaign_type,security_awareness',
                'selected_employees' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Merge the current step data with the existing session data
            $campaign->fill($request->only(['campaign_name', 'campaign_type', 'training_frequency', 'selected_employees']));
            $request->session()->put('campaign', $campaign);

            return response()->json(['success' => true, 'sessionCampaign' => $request->session()->get('campaign')], 200);

        } elseif($request->formStep == 'form-step-two'){
            // Validation for step two
            $validator = Validator::make($request->all(), [
                'email_templates' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Merge the current step data with the existing session data
            $campaign->fill($request->only(['email_templates']));
            $request->session()->put('campaign', $campaign);

            return response()->json(['success' => true, 'sessionCampaign' => $request->session()->get('campaign')], 200);

        } elseif($request->formStep == 'form-step-three'){
            // Validation for step three
            $validator = Validator::make($request->all(), [
                'delivery_type' => 'required',
                'schedule_date_from' => 'required_if:delivery_type,setup',
                'schedule_date_to' => 'required_if:delivery_type,setup',
                'schedule_time_from' => 'required_if:delivery_type,setup',
                'schedule_time_to' => 'required_if:delivery_type,setup',
                'campaign_frequency' => 'required',
                'expire_after' => 'required_if:campaign_frequency,weekly,monthly,quarterly',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Merge the current step data with the existing session data
            $campaign->fill($request->only([
                'delivery_type', 'schedule_date_from', 'schedule_date_to',
                'schedule_time_from', 'schedule_time_to', 'campaign_frequency',
                'expire_after'
            ]));
            $request->session()->put('campaign', $campaign);

            return response()->json(['success' => true,'stepThreeNow' =>true, 'sessionCampaign' => $request->session()->get('campaign')], 200);

        } elseif($request->formStep == 'form-step-four'){
            // Final step, saving the campaign
            try {
                // $this->addNewCampaign($campaign);
                $this->addNewCampaign($request->session()->get('campaign'));
                // $request->session()->forget('campaign'); // Clear session after saving
                return response()->json(['success' => true, 'createdSuccessfully' => true, 'message' => 'Campaign completed successfully'], 200);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }
        return response()->json(['success' => false, 'message' => 'Invalid step']);
    }


    public function addNewCampaign($campaign)
    {
       try {
            // return response()->json($campaign);
            Db::beginTransaction();
            $newCampaign = PhishingCampaign::create([
                'campaign_name' => $campaign->campaign_name,
                'campaign_type' => $campaign->campaign_type,
                'training_frequency' => $campaign->training_frequency,
                'expire_after' => $campaign->expire_after,
                'delivery_type' => $campaign->delivery_type,
                'schedule_date_from' => $campaign->schedule_date_from,
                'schedule_date_to' => $campaign->schedule_date_to,
                'schedule_time_from' => $campaign->schedule_time_from,
                'schedule_time_to' => $campaign->schedule_time_to,
                'campaign_frequency' => $campaign->campaign_frequency,
            ]);
            $newCampaign->emailTemplates()->attach($campaign->email_templates ?? []);
            // $newCampaign->employees()->sync($campaign->checkedEmployees ?? []);
            $newCampaign->employees()->attach($campaign->selected_employees ?? []);
            // session()->forget('campaign');

            Db::commit();
       } catch (\Exception $e) {
            DB::rollBack();
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
            $EmailTemplate = PhishingTemplate::with('senderProfile.domain','website')->find($id);
            return response()->json(['EmailTemplate' => $EmailTemplate]);
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        try {
            $campaign = PhishingCampaign::with('employees','emailTemplates')->findOrFail($id);
            return response()->json(['success' => true, 'data' => $campaign]);
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }

    public function update($id,Request $request)
    {
        PhishingCampaign::findOrFail($id);
    }

    public function trash($campaign)
    {
        try {
            $campaign = PhishingCampaign::findOrFail($campaign);
            $campaign->update(['deleted_at' => now()]);
            return response()->json(['status' => true,'message' => __('phishing.CampaignWasDeletedSuccessfully')], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false,'message' => __('locale.Error')], 502);
        }
    }

    public function getArchivedcampaign()
    {
        return view('admin.content.phishing.campaign.archived');
    }

    public function archivedCampaignDatatable()
    {
        $campaigns = PhishingCampaign::onlyTrashed()->orderBy('deleted_at','desc');
        return DataTables::of($campaigns)->setRowId(function ($row) {
            return $row->id;
        })->addColumn('actions', function ($row) {
            $data = '<div class="regulator-item">';
            $data = $data.'<button class="btn btn-secondary show-frame trash-domain" type="button" data-bs-toggle="modal"
                data-id="'.$row->id.'" onclick="ShowModalRestoreDomain('.$row->id.')" data-name="'.$row->name.'">
                                           <i class="fa-solid fa-undo"></i>
            </button>';

            $data = $data.' <button class="btn btn-secondary show-frame trash-domain" type="button" data-bs-toggle="modal"
                data-id="'.$row->id.'" onclick="ShowModalDeleteDomain('.$row->id.')" data-name="'.$row->name.'">
                                            <i class="fa-solid fa-trash"></i>
            </button>';

            $data = $data.'</div>';

            return $data;
        })->editColumn('created_at', function ($row) {
            $data = $row->created_at;

            return Carbon::parse($data)->format('Y-m-d g:ia');
        })->editColumn('delivery_status', function ($row) {
           return $row->created_at;
        })->rawColumns(['actions'])
        ->make(true);
    }

    public function restore($id,Request $request)
    {
        try {
            $campaign = PhishingCampaign::onlyTrashed()->findOrFail($id);
            $campaign->restore();
            return response()->json(['status' => true,'message' => __('phishing.CampaignRestoreSuccessfully')], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false,'message' => __('locale.Error')], 502);
        }
    }
    public function delete($id)
    {
        try {
            $campaign = PhishingCampaign::onlyTrashed()->findOrFail($id);
            $campaign->forceDelete();
            return response()->json(['status' => true,'message' => __('phishing.CampaignWasDeletedSuccessfully')], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false,'message' => __('locale.Error')], 502);
        }
    }

    public function sendTestEmail($campaingId)
    {
        try {
            /* just for test connection */

            $res = $this->sendPhishingMailTest();
            dd($res);





            $mail = PhishingTemplate::find(14);
            $employee = User::find(1);
            $mailObject = new PhishingEmail($mail,$employee,$campaingId);
            $res = $this->sendPhishingMail2("hamam33@sales.com",$mail, 'khaled@pk.com', $mailObject);
            dd($res);


            /* just for test code */
            $campaign = PhishingCampaign::with('emailTemplates', 'employees')->findOrFail($campaingId);
            foreach ($campaign->emailTemplates as $mail) {
                foreach ($campaign->employees as $employee) {
                    $mailObject = new PhishingEmail($mail,$employee,$campaingId);
                    $res = $this->sendPhishingMail2("hamam@pk.com", $mail, 'khaled@pk.com', $mailObject);
                    dd($res);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }

    public function mailOpened(Request $request)
    {
        try {
            // $emailId = $request->query('emailId');
            // $employeeId = $request->query('employeeId');

            $emailId = $request->query('PMTI');
            $employeeId = $request->query('PEI');
            // $websiteId = $request->query('PWPI');
            Log::info('Mail opened', ['emailId' => $emailId, 'employeeId' => $employeeId]);

            if($emailId && $employeeId){
                PhishingMailTracking::updateOrCreate([
                    'email_id' => $emailId,
                    'employee_id' => $employeeId,
                ],[
                    'email_id' => $emailId,
                    'employee_id' => $employeeId,
                    'opened_at' => now(),
                ]);
                return true;
            }

        } catch (\Exception $e) {
            Log::error('Error in mailOpened', ['error' => $e->getMessage()]);
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }

    public function clickOnLink(Request $request,$id)
    {
        try {
            $emailId = $request->query('PMTI');
            $employeeId = $request->query('PEI');
            // $websiteId = $request->query('PWPI');
            Log::info('Click on link', ['emailId' => $emailId, 'employeeId' => $employeeId]);

            if($emailId && $employeeId){
                PhishingMailTracking::updateOrCreate([
                    'email_id' => $emailId,
                    'employee_id' => $employeeId,
                ],[
                    'email_id' => $emailId,
                    'employee_id' => $employeeId,
                    'Page_link_clicked_at' => now(),
                ]);
            }

            $website = PhishingWebsitePage::find($id);
            return view('admin.content.phishing.websites.website', get_defined_vars());
        } catch (\Exception $e) {
            Log::error('Error in click on link', ['error' => $e->getMessage()]);
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }

    public function mailFormSubmited(Request $request)
    {
        try {
            // $emailId = $request->input('emailId');
            // $employeeId = $request->input('employeeId');
            $emailId = $request->query('PMTI');
            $employeeId = $request->query('PEI');

            if($emailId && $employeeId){
                PhishingMailTracking::updateOrCreate([
                    'email_id' => $emailId,
                    'employee_id' => $employeeId,
                ],[
                    'email_id' => $emailId,
                    'employee_id' => $employeeId,
                    'submited_at' => now(),
                ]);
                return 'Form Data is Submited Successfully';
            }

        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }

    public function mailAttachmentDownloaded(Request $request)
    {
        try {
            // $emailId = $request->input('emailId');
            // $employeeId = $request->input('employeeId');

            $emailId = $request->query('PMTI');
            $employeeId = $request->query('PEI');
            $fileName = $request->query('PMTF');

            PhishingMailTracking::updateOrCreate([
                'email_id' => $emailId,
                'employee_id' => $employeeId,
            ],[
                'email_id' => $emailId,
                'employee_id' => $employeeId,
                'downloaded_at' => now(),
            ]);

            $filePath = public_path("{$fileName}");
            return response()->download($filePath);
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }


    // Campaign data;
    public function getCampaignData($id)
    {
        $campaign = PhishingCampaign::with([
            'employees.deliverdCampaigns' => function ($query) use ($id) {
                $query->where('campaign_id', $id)
                      ->with(['deliverdEmailTemplates' => function ($query) {
                        $query->withCount(['openedMails','submitedDataInMails','downloadedFileInMails']);
                    }]);
            }
        ])->findOrFail($id);

        $employees = $campaign->employees;
        return DataTables::of($employees)->setRowId(function ($row) {
            return $row->id;
        })
        ->addColumn('delivered', function ($row){
            return $row->deliverdCampaigns->count() > 0 ? 'Yes' : 'No';
        })
        ->addColumn('count_of_opened', function ($row) use ($id){
            return $this->getEmployeeTrack($id,$row,'opened_at');
        })
        ->addColumn('count_of_submited', function ($row) use ($id){
            return $this->getEmployeeTrack($id,$row,'submited_at');
        })
        ->addColumn('count_of_downloaded', function ($row) use ($id){
            return $this->getEmployeeTrack($id,$row,'downloaded_at');
        })
        ->editColumn('created_at', function ($row) {
            $data = $row->created_at;
            return Carbon::parse($data)->format('Y-m-d g:ia');
        })
        ->addColumn('actions', function ($row) {
            $data = '<div class="regulator-item">';
            $data = $data.'</div>';
            return $data;
        })
        ->rawColumns(['actions'])
        ->make(true);
    }

    public function getEmployeeTrack($id,$row,$columnName)
    {
        return DB::table('phishing_campaigns')
            ->join('phishing_campaign_employee_list', 'phishing_campaign_employee_list.campaign_id', '=', 'phishing_campaigns.id')
            ->join('phishing_campaign_email_template', 'phishing_campaign_email_template.campaign_id', '=', 'phishing_campaigns.id')
            ->join('phishing_mail_trackings', function($join) {
                $join->on('phishing_mail_trackings.employee_id', '=', 'phishing_campaign_employee_list.employee_id')
                     ->on('phishing_mail_trackings.email_id', '=', 'phishing_campaign_email_template.email_template_id');
            })
            ->where('phishing_campaign_employee_list.campaign_id', $id)
            ->where('phishing_mail_trackings.employee_id', $row->id)
            ->whereNotNull('phishing_mail_trackings.'.$columnName)
            ->count();
    }
}
