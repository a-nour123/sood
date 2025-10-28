<?php


namespace App\Repositories\Admin\Phishing;

use App\Helpers\Helper;
use App\Http\Requests\admin\phishing\PhishingDomainsRequest;
use App\Interfaces\Admin\Phishing\PhishingDomainsInterface;
use App\Models\PhishingDomains;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PhishingDomainsRepository implements PhishingDomainsInterface
{
    public function index()
    {
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.phishing.campaign.index'), 'name' => __('phishing.campaign')],
            ['name' => __('phishing.Domains')]
        ];
        $domains = PhishingDomains::withoutTrashed()->orderBy('created_at','desc')->get();
        return view('admin.content.phishing.domains.list', get_defined_vars());
    }
    public function store(PhishingDomainsRequest $request)
    {
        try {
            $name = '@' . $request->name;

            // Check for uniqueness, including soft-deleted records
            $existingDomain = PhishingDomains::withTrashed()->where('name', $name)->first();

            if ($existingDomain) {
                // If the domain exists and is trashed, restore it
                if ($existingDomain->trashed()) {
                    $existingDomain->restore();
                    $newDomainTemplate = $this->appendNewDomain($existingDomain);
                    return response()->json(['status' => true, 'newDomainTemplate' => $newDomainTemplate, 'message' => 'Domain has been restored successfully'], 200);
                }

                // If the domain exists and is not trashed, return an error
                return response()->json([
                    'status' => false,
                    'errors' => ['name' => [__('locale.DomainAlreadyExists')]],
                    'message' => __('locale.ThereWasAProblemAddingDomain') . "<br>" . __('locale.Validation error')
                ], 422);
            }

            // If the domain does not exist, create it
            $newDomain = PhishingDomains::create([
                'name' => $name
            ]);
            $newDomainTemplate = $this->appendNewDomain($newDomain);
            return response()->json(['status' => true, 'newDomainTemplate' => $newDomainTemplate, 'message' => 'Domain is added successfully'], 200);
        } catch (\Exception $ex) {
            return response()->json(['status' => false, 'message' => __('locale.Error')], 502);
        }
    }


    public function appendNewDomain($newDomain)
    {
        $newDomainTemplate = '<div class="col-4">
                <div class="regulator-item p-3">
                    <div class="card" style="background-image: url(\'' . asset('images/widget-bg.png') . '\');">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 ">
                                    <div class="chart-progress me-3" data-color=""
                                        data-series="' . Helper::ImplementedStatistic($newDomain->id) . '" data-progress_variant="true"></div>
                                </div>
                                <div class="col-md-9 py-1">
                                    <h4>' . $newDomain->name . '</h4>
                                    <button class="btn btn-secondary show-frame edit-regulator" type="button" data-bs-toggle="modal"
                                        data-id="' . $newDomain->id . '" data-name="' . $newDomain->name . '">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <a class="btn btn-secondary show-frame" href="' . route('admin.phishing.domain.profiles', $newDomain->id) . '" title="Profiles">
                                        <i class="fa-solid fa-users"></i>
                                    </a>
                                    <button class="btn btn-secondary show-frame trash-domain" type="button" data-bs-toggle="modal"
                                        data-id="' . $newDomain->id . '" onclick="ShowModalDeleteDomain(' . $newDomain->id . ')" data-name="' . $newDomain->name . '">
                                        <i class="fa-solid fa-trash"></i>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        return $newDomainTemplate;
    }
    public function update($id, PhishingDomainsRequest $request)
    {
        try {
            $domain = PhishingDomains::findOrFail($id);
            $name = '@' . $request->name;
            $validator = Validator::make(['name' => $name], [
                'name' => 'unique:phishing_domains,name,'.$domain->id
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return response()->json(['status' => false,'errors' => $errors, 'message' => __('locale.ThereWasAProblemUpdatingDomain') . "<br>" . __('locale.Validation error')], 422);
            }

            $domain->update([
                'name' => $name,
            ]);
            return response()->json(['status' => true,'message' =>__('locale.DomainWasUpdatedSuccessfully')], 200);
        } catch (\Exception $e) {
            // return response()->json($e->getMessage());
            return response()->json(['status' => false,'message' => __('locale.Error')], 502);
        }
    }
    public function trash($domain)
    {
        try {
            $Domain = PhishingDomains::findOrFail($domain);
            $Domain->update(['deleted_at' => now()]);
            return response()->json(['status' => true,'message' => __('phishing.DomainWasDeletedSuccessfully')], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false,'message' => __('locale.Error')], 502);
        }
    }

    public function restore($id,Request $request)
    {
        try {
            $domain = PhishingDomains::onlyTrashed()->findOrFail($id);
            $domain->restore();
            return response()->json(['status' => true,'message' => __('phishing.domainRestoreSuccessfully')], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false,'message' => __('locale.Error')], 502);
        }
    }
    public function delete($id)
    {
        try {
            $domain = PhishingDomains::onlyTrashed()->findOrFail($id);
            $domain->forceDelete();
            return response()->json(['status' => true,'message' => __('phishing.DomainWasDeletedSuccessfully')], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false,'message' => __('locale.Error')], 502);
        }
    }
    public function getProfiles($id)
    {
        $domain = PhishingDomains::with('profiles')->findOrFail($id);
        $senderProfiles = $domain->profiles;
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('Sender Profiles')]
        ];
        return view('admin.content.phishing.senderProfile.domain-profiles', get_defined_vars());
        // return view('admin.content.phishing.senderProfile.list', get_defined_vars());
    }

    public function getProfilesDataTable($id)
    {
        $domain = PhishingDomains::with('profiles')->findOrFail($id);
        $senderProfiles = $domain->profiles;
        return DataTables::of($senderProfiles)->setRowId(function ($row) {
            return $row->id;
        })->editColumn('created_at', function ($row) {
            $data = $row->created_at;

            return Carbon::parse($data)->format('Y-m-d g:ia');
        })
        ->make(true);
    }

    public function getArchivedDomains()
    {
        $archived_domains = PhishingDomains::onlyTrashed()->get();
        return view('admin.content.phishing.domains.archived', get_defined_vars());
    }
}
