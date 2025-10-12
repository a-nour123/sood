<?php


namespace App\Repositories\Admin\Phishing;

use App\Helpers\Helper;
use App\Interfaces\Admin\Phishing\PhishingWebsiteInterface;
use App\Models\PhishingCategory;
use App\Models\PhishingDomains;
use App\Models\PhishingWebsitePage;
use App\Traits\UpoladFileTrait;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PhishingWebsiteRepository implements PhishingWebsiteInterface
{
    use UpoladFileTrait;


    public function getAll()
    {

        if (!auth()->user()->hasPermission('website.list')) {
            // enter here but didnt abort and return white page
            abort(403, 'Unauthorized action.');
        }

        $websites = PhishingWebsitePage::withoutTrashed()->with('category')->orderBy('created_at','desc')->get();
        $categories  = PhishingCategory::all();
        $domains = PhishingDomains::withoutTrashed()->get();

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('phishing.phishing')],
            ['name' => __('phishing.websites')]
        ];

        return view('admin.content.phishing.websites.index', compact('breadcrumbs','domains', 'websites', 'categories'));

    }
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'cover' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'phishing_category_id' => ['required'],
            'html_code' => 'required',
            'type' => 'required',
            'from_address_name' => 'required|string|max:100',
            'domain_id' => 'required_if:type,managed',
        ]);

        if($request->type == 'own'){
            $request->validate([
                'name' => ['required', 'max:200', 'unique:phishing_website_pages,name'],
                'from_address_name' => 'email'
            ]);
        }else{

            // $request->validate([
            //     'from_address_name' => 'regex:/^[^@]+$/'
            // ]);
            // $validator->after(function ($validator) use ($request) {
                $request->validate([
                    'from_address_name' => [
                        'regex:/^[^@]+$/'
                    ],
                    'name' => [
                        'required',
                        'max:200',
                        Rule::unique('phishing_website_pages', 'name')->where(function ($query) use ($request) {
                            return $query->where('domain_id', $request->domain_id);
                        }),
                    ],
                ]);
            // });
        }


        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return response()->json([
                'status' => false,
                'errors' => $errors,
                'message' => __('locale.ThereWasAProblemAddingcategory') . "<br>" . __('locale.Validation error'),
            ], 422);
        }

        DB::beginTransaction();
        try {

            // if ($request->hasFile('cover')) {
            //     $filePath = $this->storeFile(
            //         $request->file('cover'),
            //         'uploads'
            //     );
            // }
            if($request->hasFile('cover')) {
                $file = $request->file('cover');
                // $path = $this->storeFile($file, 'attachments');
                $path = $this->storeFileInStorage($file, 'public/attachments');

            }


            $domain_id = null;
            if($request->type == 'managed'){
                $domain_id = $request->domain_id;
            }

            $newWebsite = PhishingWebsitePage::create([
                'name' => $request->name,
                'cover' => $path ?? null,
                'phishing_category_id' => $request->phishing_category_id,
                'html_code' => html_entity_decode($request->html_code), // Save the Quill content

                'type' => $request->type,
                'website_url' => $request->website_url,
                'from_address_name' => $request->from_address_name,
                'domain_id' => $domain_id,
            ]);

            // Helper::appendDataToHostAndSiteEnabled($newWebsite);

            // Audit log
            $message = __('Website.An phishing Website name') . ' "' . ($newWebsite->name ?? __('locale.[No Name]')) . '" ' . __('phishing.was added by username') . ' "' . (auth()->user()->name ?? __('locale.[No User Name]')) . '".';

            $newWebsiteTemplate = '
            <div class="col-xl-3 col-sm-6 xl-4 website-card" data-id="' . $newWebsite->id . '">
                <div class="card">
                    <div class="product-box">
                        <div class="product-img">
                            <img class="img-fluid" src="' . asset($newWebsite->cover) . '" alt="">
                            <div class="product-hover">
                                <ul>';
                                if (auth()->user()->hasPermission('website.trash')){
                                    $newWebsiteTemplate .= '
                                    <li>
                                        <a class="show-frame trash-website" data-bs-toggle="modal"
                                           data-id="' . $newWebsite->id . '"
                                           onclick="ShowModalDeleteWebsite(' . $newWebsite->id . ')"
                                           data-name="' . e($newWebsite->name) . '">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </li>';
                                }
                                    // if (auth()->user()->hasPermission('website.update')){
                                    $newWebsiteTemplate .= '
                                    <li>
                                        <a class="edit-website" data-bs-toggle="modal"
                                           data-id="' . $newWebsite->id . '"
                                           data-name="' . e($newWebsite->name) . '"
                                           data-html_code="' . e($newWebsite->html_code) . '"
                                           data-phishing_category_id="' . $newWebsite->phishing_category_id . '">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    </li>';
                                    // }
                                    // if (auth()->user()->hasPermission('website.view')){
                                $newWebsiteTemplate .= '<li>
                                        <a href="' . route('website.show',['name' => urlencode($newWebsite->name), 'id' => $newWebsite->id]) . '"  target="_blank">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </li>';
                                    // }
                                    $newWebsiteTemplate .='
                                </ul>
                            </div>
                        </div>

                        <div class="product-details">
                            <h4>' . e($newWebsite->name) . '</h4>
                            <p>' . e($newWebsite->category->name ?? '') . '</p>
                        </div>
                    </div>
                </div>
            </div>';


            DB::commit();
            $response = [
                'status' => true,
                'message' => __('phishing.WebsiteWasAddedSuccessfully'),
                'newWebsiteTemplate' => $newWebsiteTemplate, // Include the new Website in the response
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

        // dd($request->all());
        $website = PhishingWebsitePage::find($id);
        if ($website) {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'max:200',  Rule::unique('phishing_website_pages', 'name')->ignore($id)],
                'phishing_category_id' => ['required'],
                'updated_html_code' => 'required',
                'type' => 'required',
                'from_address_name' => 'required|string|max:100',
                'domain_id' => 'required_if:type,managed',
            ]);

            if($request->type == 'own'){
                $request->validate([
                    'from_address_name' => 'email'
                ]);
            }else{
                $request->validate([
                    'from_address_name' => 'regex:/^[^@]+$/'
                ]);
            }

            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return response()->json([
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('locale.ThereWasAProblemUpdatingThewebsite') . "<br>" . __('locale.Validation error'),
                ], 422);
            } else {
                try {

            // if ($request->hasFile('cover')) {
            //     // Remove the old cover image if exists
            //     if ($website->cover) {
            //         Storage::delete($website->cover);
            //     }

            //     // Store the new cover image
            //     $filePath = $this->storeFile(
            //         $request->file('cover'),
            //         'uploads'
            //     );

            //     // Update the website with the new cover image
            //     $website->cover = $filePath;
            // }

            if($request->hasFile('cover')) {
                $file = $request->file('cover');
                // $path = $this->storeFile($file, 'attachments');
                $path = $this->storeFileInStorage($file, 'public/attachments');
                $website->cover = $path;

            }


            $domain_id = null;
            if($request->type == 'managed'){
                $domain_id = $request->domain_id;
            }

                    // Perform the update
                    $website->update([
                        'name' => $request->name,
                        'html_code' => $request->updated_html_code, // Update Quill content
                        'phishing_category_id' => $request->phishing_category_id,

                        'type' => $request->type,
                        'website_url' => $request->website_url,
                        'from_address_name' => $request->from_address_name,
                        'domain_id' => $domain_id,

                    ]);

                    // Generate the updated website template
                    $updatedWebsiteTemplate = '
                    <div class="col-xl-3 col-sm-6 xl-4 website-card" data-id="' . $website->id . '">
                        <div class="card">
                            <div class="product-box">
                                <div class="product-img">
                                    <img class="img-fluid" src="' . asset($website->cover) . '" alt="">
                                    <div class="product-hover">
                                        <ul>
                                            <li>
                                                <a class="show-frame trash-website" data-bs-toggle="modal"
                                                   data-id="' . $website->id . '"
                                                   onclick="ShowModalDeleteWebsite(' . $website->id . ')"
                                                   data-name="' . e($website->name) . '">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="edit-website" data-bs-toggle="modal"
                                                   data-id="' . $website->id . '"
                                                   data-name="' . e($website->name) . '"
                                                   data-html_code="' . e($website->html_code) . '"
                                                   data-phishing_category_id="' . $website->phishing_category_id . '">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="product-details">
                                    <h4>' . e($website->name) . '</h4>
                                    <p>' . e($website->category->name ?? '') . '</p>
                                </div>
                            </div>
                        </div>
                    </div>';

                    return response()->json([
                        'status' => true,
                        'message' => __('locale.websiteWasUpdatedSuccessfully'),
                        'website' => $website, // Include the website object in the response
                        'updatedWebsiteTemplate' => $updatedWebsiteTemplate,
                    ], 200);
                } catch (\Throwable $th) {
                    return response()->json([
                        'status' => false,
                        'message' =>$th->getMessage(),
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


    public function trash($website)
    {
        try {
            $website = PhishingWebsitePage::findOrFail($website);

            // Check if the website is related to a domain
            // if ($website->domain()->exists()) {
            //     return response()->json([
            //         'status' => false,
            //         'message' => __('asset.WebsiteCannotBeTrashedDueToDomainRelation'),
            //     ], 422);
            // }


            if ($website->mailTemplates()->exists()) {
                return response()->json([
                    'status' => false,
                    'message' => __('asset.WebsiteCannotBeDeletedDueTomailTemplatesRelation'),
                ], 422);
            }

            // Proceed with trashing the website
            $website->update([
                'deleted_at' => now(),
            ]);

            return response()->json([
                'status' => true,
                'message' => __('asset.WebsiteWasTrashedSuccessfully'),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function restore($id, Request $request)
    {
        try {
            // Use withTrashed() to include soft-deleted records
            $website = PhishingWebsitePage::withTrashed()->findOrFail($id);
            // Restore the soft-deleted record
            $website->restore();

            $response = [
                'status' => true,
                'message' => __('phishing.WebsiteRestoreSuccessfully'),
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
        $Website = PhishingWebsitePage::withTrashed()->findOrFail($id);
        if ($Website) {

            if ($Website->mailTemplates()->exists()) {
                return response()->json([
                    'status' => false,
                    'message' => __('asset.WebsiteCannotBeDeletedDueTomailTemplatesRelation'),
                ], 422);
            }

            $Website->forceDelete();
            $response = array(
                'status' => true,
                'message' => __('phishing.WebsiteWasDeletedSuccessfully'),
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

    public function getArchivedWebsites()
    {
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('phishing.websites')]
        ];
        $categories  = PhishingCategory::all();

        $archived_websites = PhishingWebsitePage::onlyTrashed()->get();
        return view('admin.content.phishing.websites.archived', get_defined_vars());
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $param = 1;
        // Fetch data directly from the database without caching
        $websites = PhishingWebsitePage::withoutTrashed()
        ->where(function ($q) use ($query) {
                // Search within PhishingWebsitePage name
                $q->where('name', 'like', '%' . $query . '%')
                    // Search within related Category name
                    ->orWhereHas('category', function ($q) use ($query) {
                        $q->where('name', 'like', '%' . $query . '%');
                    });
                })
                ->get();

        // Return a view with the filtered results
        return view('admin.content.phishing.websites.search', ['websites' => $websites, 'param' => $param])->render();
    }
    public function searchTrash(Request $request)
    {
        $query = $request->input('query');
        $param = 2;

        // Fetch data directly from the database without caching
        $websites = PhishingWebsitePage::onlyTrashed()
            ->where(function ($q) use ($query) {
                // Search within PhishingWebsitePage name
                $q->where('name', 'like', '%' . $query . '%')
                    // Search within related Category name
                    ->orWhereHas('category', function ($q) use ($query) {
                        $q->where('name', 'like', '%' . $query . '%');
                    });
            })
            ->get();

        // Return a view with the filtered results
        return view('admin.content.phishing.websites.search', ['websites' => $websites, 'param' => $param])->render();
    }

    public function show($name,$id)
    {
        $website = PhishingWebsitePage::with('domain')->find($id);
        $decodedName = str_replace('+', ' ', $name); // Replace '+' with space
        // if($website->domain()->exists()){
        //     $subdomain = $website->from_address_name;
        //     $domain = ltrim($website->domain->name, '@');
        //     $dynamicUrl = "http://{$subdomain}.{$domain}/PWPI/{$website->id}?employee=15&&mail=10";
        // }else{
        //     $domain = $website->from_address_name;
        //     $dynamicUrl = "http://{$domain}/PWPI/{$website->id}?employee=15&&mail=10";
        // }

        // return redirect()->away($dynamicUrl);
        return view('admin.content.phishing.websites.show_website',compact('website','decodedName'));
    }

    public function testAction()
    {
        dd('Hello From Post ');
    }


}
