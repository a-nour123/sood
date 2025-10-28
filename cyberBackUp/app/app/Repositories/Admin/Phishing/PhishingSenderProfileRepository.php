<?php


namespace App\Repositories\Admin\Phishing;

use App\Helpers\Helper;
use App\Http\Requests\admin\phishing\PhishingSenderProfileRequest;
use App\Interfaces\Admin\Phishing\PhishingSenderProfileInterface;
use App\Models\PhishingDomains;
use App\Models\PhishingSenderProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class PhishingSenderProfileRepository implements PhishingSenderProfileInterface
{
    public function index()
    {
        if (!auth()->user()->hasPermission('sender_profile.list')) {
            abort(403, 'Unauthorized action.');
        }

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('phishing.phishing')],
            ['name' => __('phishing.Sender_Profiles')]
        ];
        $senderProfiles = PhishingSenderProfile::withoutTrashed()
        ->orderBy('created_at', 'desc')
        ->get();
            return view('admin.content.phishing.senderProfile.list2', get_defined_vars());
        // return view('admin.content.phishing.senderProfile.list', get_defined_vars());
    }


    public function PhishingSenderProfileDatatable(Request $request)
    {
        $senderProfiles = PhishingSenderProfile::withoutTrashed()->orderBy('created_at','desc');
        return DataTables::of($senderProfiles)->setRowId(function ($row) {
            static $index = 0;
            return $index++;
            // return $row->id;
        })->addColumn('actions', function ($row) {
            $dropdown = '<div class="dropdown">' .
                        '<a class="pe-1 dropdown-toggle hide-arrow text-primary" href="#" role="button" id="actionsDropdown' . $row->id . '" data-bs-toggle="dropdown" aria-expanded="false">' .
                        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-small-4">' .
                        '<circle cx="12" cy="12" r="1"></circle>' .
                        '<circle cx="12" cy="5" r="1"></circle>' .
                        '<circle cx="12" cy="19" r="1"></circle>' .
                        '</svg>' .
                        '</a>' .
                        '<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionsDropdown' . $row->id . '">';

            // "Edit"
            if (auth()->user()->hasPermission('sender_profile.update')) {

            $dropdown .= '<li><a class="dropdown-item show-frame edit-regulator" href="javascript:;" data-id="' . $row->id . '" data-name="' . $row->name . '" data-from_display_name="' . $row->from_display_name . '" data-type="' . $row->type . '" data-from_address_name="' . $row->from_address_name . '" data-website_domain_id="' . $row->website_domain_id . '">' .
                         '<i class="fa-solid fa-pen me-50 font-small-4"></i> Edit</a></li>';
            }

            // "Delete"
            if (auth()->user()->hasPermission('sender_profile.delete')) {

            $dropdown .= '<li><a class="dropdown-item show-frame trash-domain" href="javascript:;" data-id="' . $row->id . '" data-name="' . $row->name . '" onclick="ShowModalDeleteDomain(' . $row->id . ')">' .
                         '<i class="fa-solid fa-trash me-50 font-small-4"></i> Delete</a></li>';
            }

            $dropdown .= '</ul></div>';

            return $dropdown;
        })
        ->editColumn('created_at', function ($row) {
            return Carbon::parse($row->created_at)->format('Y-m-d g:ia');
        })->rawColumns(['actions'])
        ->addIndexColumn()
        ->make(true);
    }


    public function store(PhishingSenderProfileRequest $request)
    {
        try {
            $website_domain_id = null;
            if($request->type == 'managed'){
                $website_domain_id = $request->website_domain_id;
            }
            $newSenderProfile = PhishingSenderProfile::create([
                'name' => $request->name,
                'from_display_name' => $request->from_display_name,
                'type' => $request->type,
                'from_address_name' => $request->from_address_name,
                'website_domain_id' => $website_domain_id,
            ]);

            $newSenderProfileTemplate = $this->appendNewSenderProfile($newSenderProfile);
            return response()->json(['status' => true,'newSenderProfileTemplate' => $newSenderProfileTemplate,'message' => 'Sender Profile is Added Successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false,'message' => __('locale.Error')], 502);
        }
    }

    public function appendNewSenderProfile($newSenderProfile)
    {
        $newSenderProfileTemplate = '<div class="col-4">
                <div class="regulator-item p-3">
                    <div class="card" style="background-image: url(\'' . asset('images/widget-bg.png') . '\');">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 ">
                                    <div class="chart-progress me-3" data-color=""
                                        data-series="' . Helper::ImplementedStatistic($newSenderProfile->id) . '" data-progress_variant="true"></div>
                                </div>
                                <div class="col-md-9 py-1">
                                    <h4>' . $newSenderProfile->name . '</h4>
                                     <button class="btn btn-secondary show-frame edit-regulator" type="button" data-bs-toggle="modal"
                                        data-id="' . $newSenderProfile->id . '" data-name="' . $newSenderProfile->name . '">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <a class="btn btn-secondary show-frame" href="' . route('admin.phishing.domain.profiles', $newSenderProfile->id) . '" title="Profiles">
                                        <i class="fa-solid fa-users"></i>
                                    </a>
                                    <button class="btn btn-secondary show-frame trash-domain" type="button" data-bs-toggle="modal"
                                        data-id="' . $newSenderProfile->id . '" onclick="ShowModalDeleteDomain(' . $newSenderProfile->id . ')" data-name="' . $newSenderProfile->name . '">
                                        <i class="fa-solid fa-trash"></i>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        return $newSenderProfileTemplate;
    }
    public function update($id, PhishingSenderProfileRequest $request)
    {
        try {
            $senderProfile = PhishingSenderProfile::findOrFail($id);
            $website_domain_id = null;
            if($request->type == 'managed'){
                $website_domain_id = $request->website_domain_id;
            }
            $senderProfile->update([
                'name' => $request->name,
                'from_display_name' => $request->from_display_name,
                'type' => $request->type,
                'from_address_name' => $request->from_address_name,
                'website_domain_id' => $website_domain_id,
            ]);
            return response()->json(['status' => true,'message' =>__('locale.RegulatorWasUpdatedSuccessfully')], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => false,'message' => __('locale.Error')], 502);
        }
    }
    public function trash($senderProfile)
    {
        try {
            $senderProfile = PhishingSenderProfile::findOrFail($senderProfile);

            // if ($senderProfile->domain) {
            //     return response()->json([
            //         'status' => false,
            //         'message' => __('phishing.CannotDeleteSenderProfileWithDomain')
            //     ], 400); // You can return a different HTTP status if needed
            // }

            if ($senderProfile->mailTemplates()->exists()) {
                return response()->json([
                    'status' => false,
                    'message' => __('asset.senderProfileCannotBeDeletedDueTomailTemplatesRelation'),
                ], 422);
            }

            // Proceed with deletion if not related to a domain
            $senderProfile->update(['deleted_at' => now()]);

            return response()->json([
                'status' => true,
                'message' => __('phishing.SenderProfileWasDeletedSuccessfully')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('locale.Error')
            ], 502);
        }
    }


    public function restore($id,Request $request)
    {
        try {
            $senderProfile = PhishingSenderProfile::onlyTrashed()->findOrFail($id);
            $senderProfile->restore();
            return response()->json(['status' => true,'message' =>__('phishing.SenderProfileRestoreSuccessfully')], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false,'message' => __('locale.Error')], 502);
        }
    }
    public function delete($id)
    {
        try {
            $senderProfile = PhishingSenderProfile::onlyTrashed()->findOrFail($id);
            $senderProfile->forceDelete();
            return response()->json(['status' => true,'message' =>__('phishing.SenderProfileWasDeletedSuccessfully')], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false,'message' => __('locale.Error')], 502);
        }
    }
    public function getArchivedSenderProfile()
    {
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('Archivec Sender Profiles')]
        ];
        $archived_sender_profiles = PhishingSenderProfile::onlyTrashed()->get();
        return view('admin.content.phishing.senderProfile.archived2', get_defined_vars());
        // return view('admin.content.phishing.senderProfile.archived', get_defined_vars());
    }

    public function archivedSenderProfileDatatable(Request $request)
    {
        $senderProfiles = PhishingSenderProfile::onlyTrashed()->orderBy('created_at','desc');
        return DataTables::of($senderProfiles)->setRowId(function ($row) {
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
        })->rawColumns(['actions'])
        ->make(true);
    }

}
