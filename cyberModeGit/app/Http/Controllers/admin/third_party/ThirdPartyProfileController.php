<?php

namespace App\Http\Controllers\admin\third_party;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\third_party\StoreThirdPartyProfileRequest;
use App\Models\RiskFunction;
use App\Models\RiskGrouping;
use App\Models\ThreatGrouping;
use Illuminate\Http\Request;
use App\Models\{
    ThirdPartyClassification,
    ThirdPartyProfile,
    ThirdPartyProfileContact,
    ThirdPartyProfileEntity,
    ThirdPartyProfileSubsidiary,
};
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ThirdPartyProfileController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasPermission('third_party_profile.list')) {
            if ($request->ajax()) {
                $thirdPartyProfiles = ThirdPartyProfile::with('classification')
                    ->select(
                        'id',
                        'third_party_name',
                        'owner',
                        'third_party_classification_id',
                        'contract_term',
                        'created_at'
                    )
                    ->orderBy('created_at', 'desc');

                return DataTables::of($thirdPartyProfiles)
                    ->addColumn('classification', function ($thirdPartyProfiles) {
                        return $thirdPartyProfiles->classification->name; // Assuming you have a classification relation
                    })
                    ->addColumn('actions', function ($thirdPartyProfiles) {

                        // Initialize an empty string to hold the dropdown menu items
                        $dropdownItems = '';

                        // View button
                        $dropdownItems .= '<a href="javascript:void(0)" class="dropdown-item  view-profile"
                                            data-id="' . $thirdPartyProfiles->id . '">
                                            <i class="fas fa-eye me-2"></i>' . __('locale.View') . '
                                        </a>';

                        // Edit button
                        if (auth()->user()->hasPermission('third_party_profile.update')) {
                            $dropdownItems .= '<a href="javascript:void(0)" class="dropdown-item  edit-profile"
                                            data-id="' . $thirdPartyProfiles->id . '">
                                            <i class="fas fa-edit me-2"></i>' . __('locale.Edit') . '
                                        </a>';
                        }

                        // Delete button
                        if (auth()->user()->hasPermission('third_party_profile.delete')) {
                            $dropdownItems .= '<a href="javascript:void(0)" class="dropdown-item  delete-profile"
                                            data-id="' . $thirdPartyProfiles->id . '">
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

            $breadcrumbs = [
                ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
                ['name' => __('locale.ThirdPartyManagment')],
                ['name' => __('locale.ThirdPartyProfiles')]
            ];
            $data = [
                'breadcrumbs' => $breadcrumbs,
            ];

            return view('admin.content.third_party.profiles.index', compact('data'));
        } else {
            abort(403);
        }
    }

    public function create(StoreThirdPartyProfileRequest $request)
    {
        try {
            DB::beginTransaction();

            $profileGetId = ThirdPartyProfile::insertGetId([
                'third_party_name' => $request->general_info['third_party_name'],
                'owner' => $request->general_info['owner'],
                'agreement' => $request->general_info['agreement'],
                'domain' => $request->general_info['domain'],
                'contract_term' => $request->general_info['contract_term'],
                'third_party_classification_id' => $request->general_info['classification'],
                'date_of_incorporation' => $request->general_info['date_of_incorporation'],
                'place_of_incorporation' => $request->general_info['place_of_incorporation'],
                'head_office_location' => $request->general_info['head_office_location'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // contacts
            if (!empty($request->contact)) {
                foreach ($request->contact as $contact) {
                    if (!empty($contact['name']) || !empty($contact['phone']) || !empty($contact['email'])) {
                        ThirdPartyProfileContact::create([
                            'type' => 1,
                            'third_party_profile_id' => $profileGetId,
                            'name' => $contact['name'] ?? null,
                            'phone' => $contact['phone'] ?? null,
                            'email' => $contact['email'] ?? null,
                        ]);
                    }
                }
            }

            // business contacts
            if (!empty($request->business_contact)) {
                foreach ($request->business_contact as $business_contact) {
                    if (!empty($business_contact['name']) || !empty($business_contact['phone']) || !empty($business_contact['email'])) {
                        ThirdPartyProfileContact::create([
                            'type' => 2,
                            'third_party_profile_id' => $profileGetId,
                            'name' => $business_contact['name'] ?? null,
                            'phone' => $business_contact['phone'] ?? null,
                            'email' => $business_contact['email'] ?? null,
                        ]);
                    }
                }
            }

            // technical contacts
            if (!empty($request->technical_contact)) {
                foreach ($request->technical_contact as $technical_contact) {
                    if (!empty($technical_contact['name']) || !empty($technical_contact['phone']) || !empty($technical_contact['email'])) {
                        ThirdPartyProfileContact::create([
                            'type' => 3,
                            'third_party_profile_id' => $profileGetId,
                            'name' => $technical_contact['name'] ?? null,
                            'phone' => $technical_contact['phone'] ?? null,
                            'email' => $technical_contact['email'] ?? null,
                        ]);
                    }
                }
            }

            // cyber contacts
            if (!empty($request->cyber_contact)) {
                foreach ($request->cyber_contact as $cyber_contact) {
                    if (!empty($cyber_contact['name']) || !empty($cyber_contact['phone']) || !empty($cyber_contact['email'])) {
                        ThirdPartyProfileContact::create([
                            'type' => 4,
                            'third_party_profile_id' => $profileGetId,
                            'name' => $cyber_contact['name'] ?? null,
                            'phone' => $cyber_contact['phone'] ?? null,
                            'email' => $cyber_contact['email'] ?? null,
                        ]);
                    }
                }
            }

            // entities
            if (!empty($request->entities)) {
                foreach ($request->entities as $entity) {
                    if (!empty($entity['entity']) || !empty($entity['date']) || !empty($entity['involvement'])) {
                        ThirdPartyProfileEntity::create([
                            'third_party_profile_id' => $profileGetId,
                            'entity' => $entity['entity'] ?? null,
                            'date' => $entity['date'] ?? null,
                            'involvement' => $entity['involvement'] ?? null,
                        ]);
                    }
                }
            }

            // subsidiaries
            if (!empty($request->subsidiaries)) {
                foreach ($request->subsidiaries as $subsidiary) {
                    if (!empty($subsidiary['affiliation']) || !empty($subsidiary['date']) || !empty($subsidiary['involvement'])) {
                        ThirdPartyProfileSubsidiary::create([
                            'third_party_profile_id' => $profileGetId,
                            'affiliation' => $subsidiary['affiliation'] ?? null,
                            'date' => $subsidiary['date'] ?? null,
                            'involvement' => $subsidiary['involvement'] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();
            return response()->json(['message' => 'Profile created successfully'], 200);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'An error occurred',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    // public function configure(){
    //     $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' => "javascript:void(0)", 'name' => __('locale.Configure')], ['name' => __('locale.Preparatorydata')]];
    //     $risk_groupings = RiskGrouping::all();
    //     $risk_functions = RiskFunction::all();
    //     $threat_groupings = ThreatGrouping::all();

    //     $addValueTables = [
    //         // TableName => Language key
    //         'third_party_classifications' => 'ThirdPartyClassifications'

    //     ];

    //     return view('admin.content.configure.Add_Values', compact('breadcrumbs', 'risk_groupings', 'risk_functions', 'threat_groupings', 'addValueTables'));
    // }

    public function delete($profile_id)
    {
        try {
            // dd($profile_id);
            ThirdPartyProfile::findOrFail($profile_id)->delete();

            ThirdPartyProfileContact::where('third_party_profile_id', $profile_id)->delete();

            ThirdPartyProfileEntity::where('third_party_profile_id', $profile_id)->delete();

            ThirdPartyProfileSubsidiary::where('third_party_profile_id', $profile_id)->delete();

            return response()->json([
                'message' => 'Profile deleted successfully',
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function view(Request $request, $profile_id)
    {
        if ($request->ajax()) {

            $profile = ThirdPartyProfile::findOrFail($profile_id);

            $profileEntities = $profile->entities;

            $profileSubsidiaries = $profile->subsidiaries;

            $profileContacts = $profile->contacts->where('type', 1);
            $profileBusinessContacts = $profile->contacts->where('type', 2);
            $profileTechnicalContacts = $profile->contacts->where('type', 3);
            $profileCyberContacts = $profile->contacts->where('type', 4);

            $data = [
                'profile' => $profile,
                'entities' => $profileEntities,
                'subsidiaries' => $profileSubsidiaries,
                'contacts' => $profileContacts,
                'business contacts' => $profileBusinessContacts,
                'technical contacts' => $profileTechnicalContacts,
                'cyber contacts' => $profileCyberContacts,
            ];

            // dd($data);
            return view('admin.content.third_party.profiles.view', compact('data'));
        } else {
            abort('403');
        }
    }

    // this function return view create or update form
    public function getForm(Request $request, $type, $profile_id = null)
    {
        // dd($profile_id);
        if ($request->ajax()) {

            $classifications = ThirdPartyClassification::get();
            if ($type == 'create') {
                $data = [
                    'classifications' => $classifications
                ];
                return view('admin.content.third_party.profiles.create', compact('data'));
            } elseif ($type == 'edit') {
                $profile = ThirdPartyProfile::findOrFail($profile_id);

                $profileEntities = $profile->entities;

                $profileSubsidiaries = $profile->subsidiaries;

                $profileContacts = ThirdPartyProfileContact::where('third_party_profile_id', $profile_id)
                    ->where('type', 1)->get();
                $profileBusinessContacts = ThirdPartyProfileContact::where('third_party_profile_id', $profile_id)
                    ->where('type', 2)->get();
                $profileTechnicalContacts = ThirdPartyProfileContact::where('third_party_profile_id', $profile_id)
                    ->where('type', 3)->get();
                $profileCyberContacts = ThirdPartyProfileContact::where('third_party_profile_id', $profile_id)
                    ->where('type', 4)->get();

                $data = [
                    'profile' => $profile,
                    'entities' => $profileEntities,
                    'subsidiaries' => $profileSubsidiaries,
                    'contacts' => $profileContacts,
                    'business contacts' => $profileBusinessContacts,
                    'technical contacts' => $profileTechnicalContacts,
                    'cyber contacts' => $profileCyberContacts,
                    'classifications' => $classifications
                ];

                // dd($data);
                return view('admin.content.third_party.profiles.edit', compact('data'));
            } else {
                return response()->json(['message' => 'Error: unkown type function'], 404);
            }
        } else {
            abort('403');
        }
    }


    public function update(Request $request, $profile_id)
    {
        try {
            DB::beginTransaction();

            // Update main profile
            ThirdPartyProfile::where('id', $profile_id)->update([
                'third_party_name' => $request->general_info['third_party_name'],
                'owner' => $request->general_info['owner'],
                'agreement' => $request->general_info['agreement'],
                'domain' => $request->general_info['domain'],
                'third_party_classification_id' => $request->general_info['classification'],
                'contract_term' => $request->general_info['contract_term'],
                'date_of_incorporation' => $request->general_info['date_of_incorporation'],
                'place_of_incorporation' => $request->general_info['place_of_incorporation'],
                'head_office_location' => $request->general_info['head_office_location'],
            ]);

            /* updating contacts */
            ThirdPartyProfileContact::where('third_party_profile_id', $profile_id)->delete();

            if (!empty($request->contact)) {
                foreach ($request->contact as $contact) {
                    if (!empty($contact['name']) || !empty($contact['phone']) || !empty($contact['email'])) {
                        ThirdPartyProfileContact::create([
                            'type' => 1,
                            'third_party_profile_id' => $profile_id,
                            'name' => $contact['name'] ?? null,
                            'phone' => $contact['phone'] ?? null,
                            'email' => $contact['email'] ?? null,
                        ]);
                    }
                }
            }

            if (!empty($request->business_contact)) {
                foreach ($request->business_contact as $business_contact) {
                    if (!empty($business_contact['name']) || !empty($business_contact['phone']) || !empty($business_contact['email'])) {
                        ThirdPartyProfileContact::create([
                            'type' => 2,
                            'third_party_profile_id' => $profile_id,
                            'name' => $business_contact['name'] ?? null,
                            'phone' => $business_contact['phone'] ?? null,
                            'email' => $business_contact['email'] ?? null,
                        ]);
                    }
                }
            }

            if (!empty($request->technical_contact)) {
                foreach ($request->technical_contact as $technical_contact) {
                    if (!empty($technical_contact['name']) || !empty($technical_contact['phone']) || !empty($technical_contact['email'])) {
                        ThirdPartyProfileContact::create([
                            'type' => 3,
                            'third_party_profile_id' => $profile_id,
                            'name' => $technical_contact['name'] ?? null,
                            'phone' => $technical_contact['phone'] ?? null,
                            'email' => $technical_contact['email'] ?? null,
                        ]);
                    }
                }
            }

            if (!empty($request->cyber_contact)) {
                foreach ($request->cyber_contact as $cyber_contact) {
                    if (!empty($cyber_contact['name']) || !empty($cyber_contact['phone']) || !empty($cyber_contact['email'])) {
                        ThirdPartyProfileContact::create([
                            'type' => 4,
                            'third_party_profile_id' => $profile_id,
                            'name' => $cyber_contact['name'] ?? null,
                            'phone' => $cyber_contact['phone'] ?? null,
                            'email' => $cyber_contact['email'] ?? null,
                        ]);
                    }
                }
            }
            /* end updating contacts */

            /* updating entities */
            ThirdPartyProfileEntity::where('third_party_profile_id', $profile_id)->delete();

            if (!empty($request->entities)) {
                foreach ($request->entities as $entity) {
                    if (!empty($entity['entity']) || !empty($entity['date']) || !empty($entity['involvement'])) {
                        ThirdPartyProfileEntity::create([
                            'third_party_profile_id' => $profile_id,
                            'entity' => $entity['entity'] ?? null,
                            'date' => $entity['date'] ?? null,
                            'involvement' => $entity['involvement'] ?? null,
                        ]);
                    }
                }
            }

            /* updating subsidiaries */
            ThirdPartyProfileSubsidiary::where('third_party_profile_id', $profile_id)->delete();

            if (!empty($request->subsidiaries)) {
                foreach ($request->subsidiaries as $subsidiary) {
                    if (!empty($subsidiary['affiliation']) || !empty($subsidiary['date']) || !empty($subsidiary['involvement'])) {
                        ThirdPartyProfileSubsidiary::create([
                            'third_party_profile_id' => $profile_id,
                            'affiliation' => $subsidiary['affiliation'] ?? null,
                            'date' => $subsidiary['date'] ?? null,
                            'involvement' => $subsidiary['involvement'] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();
            return response()->json(['message' => 'Profile updated successfully'], 200);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'An error occurred',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }
}