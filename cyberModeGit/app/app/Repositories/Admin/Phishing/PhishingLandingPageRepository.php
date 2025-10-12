<?php


namespace App\Repositories\Admin\Phishing;

use App\Helpers\Helper;
use App\Interfaces\Admin\Phishing\PhishingLandingPageInterface;
use App\Models\PhishingCategory;
use App\Models\PhishingLandingPage;
use App\Models\PhishingWebsitePage;
use App\Traits\UpoladFileTrait;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PhishingLandingPageRepository implements PhishingLandingPageInterface
{
    use UpoladFileTrait;


    public function getAll()
    {
        try {

            $websites = PhishingWebsitePage::withoutTrashed()->with('category')->get();
            $landingpages = PhishingLandingPage::withoutTrashed()->with('website')->get();

            $breadcrumbs = [
                ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
                ['name' => __('phishing.LandingPages')]
            ];

            return view('admin.content.phishing.landingpages.index', compact('breadcrumbs', 'websites', 'landingpages'));
        } catch (\Exception $e) {
        }
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:200', 'unique:phishing_landing_pages,name'],
            'description' => ['required', 'string', 'max:400'],
            'type' => ['required'],
            'website_page_id' => ['required'],
            'website_domain_id' => ['required_if:type,managed'],
            'website_domain_name' => ['required_if:type,managed'],
            // 'website_url' => ['required_if:type,own', 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/']
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return response()->json([
                'status' => false,
                'errors' => $errors,
                'message' => __('locale.ThereWasAProblemAddingLandingPage') . "<br>" . __('locale.Validation error'),
            ], 422);
        }

        DB::beginTransaction();
        try {
            $newLandingPage = PhishingLandingPage::create([
                'name' => $request->name,
                'description' => $request->description,
                'website_domain_id' => $request->website_domain_id,
                'website_domain_name' => $request->website_domain_name,
                'website_page_id' => $request->website_page_id,
                'website_url' => $request->website_url,
                'type' => $request->type
            ]);

            // Audit log
            $message = __('Website.An phishing Website name') . ' "' . ($newLandingPage->name ?? __('locale.[No Name]')) . '" ' . __('phishing.was added by username') . ' "' . (auth()->user()->name ?? __('locale.[No User Name]')) . '".';

            $newLandingPageTemplate = '
            <div class="col-xl-3 col-sm-6 xl-4 website-card" data-id="' . $newLandingPage->id . '">
                <div class="card">
                    <div class="product-box">
                        <div class="product-img">
                            <img class="img-fluid" src="' . asset($newLandingPage->website->cover) . '" alt="">
                            <div class="product-hover">
                                <ul>
                                    <li>
                                        <a class="show-frame trash-website" data-bs-toggle="modal"
                                           data-id="' . $newLandingPage->id . '"
                                           onclick="ShowModalDeleteLandingPage(' . $newLandingPage->id . ')"
                                           data-name="' . e($newLandingPage->name) . '">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="edit-landingpage" data-bs-toggle="modal"
                                           data-id="' . $newLandingPage->id . '"
                                           data-name="' . e($newLandingPage->name) . '"
                                           data-website_description="' . e($newLandingPage->website_description) . '"

                                           data-website_domain_id="' . $newLandingPage->website_domain_id . '"
                                           data-website_page_id="' . $newLandingPage->website_page_id . '"
                                            data-type="' . $newLandingPage->type . '">

                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="' . route('admin.phishing.landingpage.show', $newLandingPage->id) . '">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </li>
                            <li><a class="duplicate-landingpage" data-bs-toggle="modal" data-id="'. $newLandingPage->id.'" data-name="'. $newLandingPage->name.'"><i class="fa-solid fa-copy"></i></a></li>

                                </ul>
                            </div>
                        </div>

                        <div class="product-details">
                            <h4>' . e($newLandingPage->name) . '</h4>
                        </div>
                    </div>
                </div>
            </div>';



            DB::commit();
            $response = [
                'status' => true,
                'message' => __('phishing.LandingPageWasAddedSuccessfully'),
                'newLandingPageTemplate' => $newLandingPageTemplate, // Include the new Website in the response
            ];
            return response()->json($response, 200);
        } catch (\Exception $th) {
            return response()->json($th->getMessage());
            DB::rollBack();
            $response = [
                'status' => false,
                'errors' => [],
                'message' => __('locale.Error'),
            ];
            return response()->json($response, 502);
        }
    }


    public function update($id, Request $request)
    {
        $landingpage = PhishingLandingPage::find($id);
        if ($landingpage) {
            $validator = Validator::make($request->all(), [
                'name' => ['required'],
                'description' => ['required', 'string', 'max:400'],
                'type' => ['required']
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return response()->json([
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('locale.ThereWasAProblemUpdatingTheLandingPage') . "<br>" . __('locale.Validation error'),
                ], 422);
            } else {
                try {

                    // Perform the update
                    $landingpage->update([
                        'name' => $request->name,
                        'description' => $request->description,
                        'website_domain_id' => $request->website_domain_id,
                        'website_domain_name' => $request->website_domain_name,
                        'website_page_id' => $request->website_page_id,
                        'website_url' => $request->website_url,
                        'type' => $request->type

                    ]);
                    $updatedLandingPageTemplate = '
                    <div class="col-xl-3 col-sm-6 xl-4 website-card" data-id="' . $landingpage->id . '">
                        <div class="card">
                            <div class="product-box">
                                <div class="product-img">
                                    <img class="img-fluid" src="' . asset($landingpage->website->cover) . '" alt="">
                                    <div class="product-hover">
                                        <ul>
                                            <li>
                                                <a class="show-frame trash-website" data-bs-toggle="modal"
                                                   data-id="' . $landingpage->id . '"
                                                   onclick="ShowModalDeleteLandingPage(' . $landingpage->id . ')"
                                                   data-name="' . e($landingpage->name) . '">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="edit-landingpage" data-bs-toggle="modal"
                                                   data-id="' . $landingpage->id . '"
                                                   data-name="' . e($landingpage->name) . '"
                                                   data-description="' . e($landingpage->description) . '"
                                                   data-phishing_website_id="' . $landingpage->phishing_website_id . '"
                                                   data-website_domain_id="' . $landingpage->website_domain_id . '"
                                                   data-website_domain_name="' . e($landingpage->website_domain_name) . '">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="' . route('admin.phishing.landingpage.show', $landingpage->id) . '">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                            </li>
                                       <li><a class="duplicate-landingpage" data-bs-toggle="modal" data-id="'. $landingpage->id.'" data-name="'. $landingpage->name.'"><i class="fa-solid fa-copy"></i></a></li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="product-details">
                                    <h4>' . e($landingpage->name) . '</h4>
                                </div>
                            </div>
                        </div>
                    </div>';


                    return response()->json([
                        'status' => true,
                        'message' => __('locale.LandingPageWasUpdatedSuccessfully'),
                        'landingpage' => $landingpage, // Include the website object in the response
                        'updatedLandingPageTemplate' => $updatedLandingPageTemplate,
                    ], 200);
                } catch (\Throwable $th) {
                    return response()->json([
                        'status' => false,
                        'message' => __('locale.Error'),
                    ], 502);
                }
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => __('locale.Error 404'),
            ], 404);
        }
    }


    public function trash($page)
    {
        $landingPage = PhishingLandingPage::findOrFail($page);
        $landingPage->update([
            'deleted_at' => now(),
        ]);
        $response = array(
            'status' => true,
            'message' => __('phishing.landingPageWasTrashedSuccessfully'),
        );
        return response()->json($response, 200);
    }
    public function restore($id, Request $request)
    {
        try {
            // Use withTrashed() to include soft-deleted records
            $website = PhishingLandingPage::withTrashed()->findOrFail($id);
            // Restore the soft-deleted record
            $website->restore();

            $response = [
                'status' => true,
                'message' => __('phishing.LandingPageRestoreSuccessfully'),
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = [
                'status' => false,
                'message' => __('locale.Error'),
            ];
            return response()->json($response, 502);
        }
    }
    public function delete($id)
    {
        $landingPage = PhishingLandingPage::withTrashed()->findOrFail($id);
        if ($landingPage) {

            $landingPage->forceDelete();
            $response = array(
                'status' => true,
                'message' => __('phishing.landingPageWasDeletedSuccessfully'),
            );
            return response()->json($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => __('locale.Error'),
            ];
            return response()->json($response, 502);
        }
    }

    public function getArchivedLandingPages()
    {
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('phishing.LandingPages')]
        ];
        $archived_landingpages = PhishingLandingPage::onlyTrashed()->get();
        return view('admin.content.phishing.landingpages.archived', get_defined_vars());
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $param = 1;
        // Fetch data directly from the database without caching
        $landingpages = PhishingLandingPage::withoutTrashed()
            ->where(function ($q) use ($query) {
                // Search within PhishingWebsitePage name
                $q->where('name', 'like', '%' . $query . '%')
                    // Search within related Category name
                    ->orWhereHas('website', function ($q) use ($query) {
                        $q->where('name', 'like', '%' . $query . '%');
                    });
            })
            ->get();

        // Return a view with the filtered results
        return view('admin.content.phishing.landingpages.search', ['landingpages' => $landingpages, 'param' => $param])->render();
    }
    public function searchTrash(Request $request)
    {
        $query = $request->input('query');
        $param = 2;

        // Fetch data directly from the database without caching
        $landingpages = PhishingLandingPage::onlyTrashed()
            ->where(function ($q) use ($query) {
                // Search within PhishingWebsitePage name
                $q->where('name', 'like', '%' . $query . '%')
                    // Search within related Category name
                    ->orWhereHas('website', function ($q) use ($query) {
                        $q->where('name', 'like', '%' . $query . '%');
                    });
            })
            ->get();

        // Return a view with the filtered results
        return view('admin.content.phishing.landingpages.search', ['landingpages' => $landingpages, 'param' => $param])->render();
    }

    public function show($id)
    {
        $landingpage = PhishingLandingPage::withoutTrashed()->with('website')->find($id);
        return view('admin.content.phishing.landingpages.website', get_defined_vars());
    }

    public function testAction()
    {
        dd('Hello From Post ');
    }
    public function duplicate(Request $request, $id)
    {
        $landingpage = PhishingLandingPage::findOrFail($id);
        $landingpages = PhishingLandingPage::withoutTrashed()->with('website')->get();

        $newLandingPage = $landingpage->replicate();
        $newLandingPage->name = $request->name;
        $newLandingPage->save();
        $newLandingPageTemplate = '
        <div class="col-xl-3 col-sm-6 xl-4 website-card" data-id="' . $newLandingPage->id . '">
            <div class="card">
                <div class="product-box">
                    <div class="product-img">
                        <img class="img-fluid" src="' . asset($newLandingPage->website->cover) . '" alt="">
                        <div class="product-hover">
                            <ul>
                                <li>
                                    <a class="show-frame trash-website" data-bs-toggle="modal"
                                       data-id="' . $newLandingPage->id . '"
                                       onclick="ShowModalDeleteLandingPage(' . $newLandingPage->id . ')"
                                       data-name="' . e($newLandingPage->name) . '">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </li>
                                <li>
                                    <a class="edit-landingpage" data-bs-toggle="modal"
                                       data-id="' . $newLandingPage->id . '"
                                       data-name="' . e($newLandingPage->name) . '"
                                       data-website_description="' . e($newLandingPage->website_description) . '"

                                       data-website_domain_id="' . $newLandingPage->website_domain_id . '"
                                       data-website_page_id="' . $newLandingPage->website_page_id . '"
                                        data-type="' . $newLandingPage->type . '">

                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="' . route('admin.phishing.landingpage.show', $newLandingPage->id) . '">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </li>
                             <li><a class="duplicate-landingpage" data-bs-toggle="modal" data-id="'. $landingpage->id.'" data-name="'. $landingpage->name.'"><i class="fa-solid fa-copy"></i></a></li>

                            </ul>
                        </div>
                    </div>

                    <div class="product-details">
                        <h4>' . e($newLandingPage->name) . '</h4>
                    </div>
                </div>
            </div>
        </div>';


        return response()->json([
            'status' => true,
            'message' => __('locale.LandingPageDuplicatedSuccessfully'),
            'newLandingPageTemplate' => $newLandingPageTemplate
        ]);
        return  view('admin.content.phishing.landingpages.index', compact(['landingpage' => $newLandingPage, 'landingpages', $landingpages]));
    }
}
