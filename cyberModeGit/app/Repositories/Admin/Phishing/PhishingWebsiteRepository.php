<?php


namespace App\Repositories\Admin\Phishing;

use App\Helpers\Helper;
use App\Interfaces\Admin\Phishing\PhishingWebsiteInterface;
use App\Models\PhishingCategory;
use App\Models\PhishingDomains;
use App\Models\PhishingWebsitePage;
use App\Services\CompleteWebScraperService;
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

        $websites = PhishingWebsitePage::withoutTrashed()->with('category')->orderBy('created_at', 'desc')->get();
        $categories = PhishingCategory::all();
        $domains = PhishingDomains::withoutTrashed()->get();

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('phishing.phishing')],
            ['name' => __('phishing.websites')]
        ];

        return view('admin.content.phishing.websites.index', compact('breadcrumbs', 'domains', 'websites', 'categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cover' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'phishing_category_id' => ['required'],
            'html_code' => 'required_without:website_url',
            'website_url' => 'required_without:html_code',
            'spa_html_code' => 'nullable|string',
            'is_spa' => 'nullable|boolean',
            'type' => 'required',
            'from_address_name' => 'required|string|max:100',
            'domain_id' => 'required_if:type,managed',

            'download_css' => 'nullable|boolean',
            'download_images' => 'nullable|boolean',
            'download_js' => 'nullable|boolean',
            'download_fonts' => 'nullable|boolean',
            'download_json' => 'nullable|boolean',
            'download_other_assets' => 'nullable|boolean',
        ]);

        if ($request->type == 'own') {
            $request->validate([
                'name' => ['required', 'max:200', 'unique:phishing_website_pages,name'],
                'from_address_name' => 'email'
            ]);
        } else {
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
            if ($request->hasFile('cover')) {
                $file = $request->file('cover');
                $path = $this->storeFileInStorage($file, 'public/attachments');
            }

            $htmlCode = '';
            $scrapedAssets = [];
            $isSpaMode = false;

            if ($request->has('website_url') && !empty($request->website_url)) {
                $scraperService = new CompleteWebScraperService();
                $isSpaMode = $request->boolean('is_spa', false);
                $customHtml = $isSpaMode ? $request->input('spa_html_code') : null;

                $downloadOptions = [
                    'css' => $request->boolean('download_css', true),
                    'images' => $request->boolean('download_images', true),
                    'js' => $request->boolean('download_js', true),
                    'fonts' => $request->boolean('download_fonts', true),
                    'json' => $request->boolean('download_json', true),
                    'other_assets' => $request->boolean('download_other_assets', true)
                ];

                $scrapedData = $scraperService->scrapeCompleteWebsite(
                    $request->website_url,
                    $customHtml,
                    $downloadOptions
                );

                if ($scrapedData['status'] === 'success') {
                    $htmlCode = $scrapedData['html'];
                    $scrapedAssets = $scrapedData['assets'];
                    $isSpaMode = $scrapedData['is_spa_mode'];
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => __('locale.Failed to scrape website') . ': ' . $scrapedData['message'],
                        'error' => $scrapedData['message']
                    ], 400);
                }
            } else {
                $htmlCode = html_entity_decode($request->html_code);
            }

            $domain_id = null;
            if ($request->type == 'managed') {
                $domain_id = $request->domain_id;
            }

            $newWebsite = PhishingWebsitePage::create([
                'name' => $request->name,
                'cover' => $path ?? null,
                'phishing_category_id' => $request->phishing_category_id,
                'html_code' => $htmlCode,
                'type' => $request->type,
                'website_url' => $request->website_url,
                'from_address_name' => $request->from_address_name,
                'domain_id' => $domain_id,
                'scraped_assets' => json_encode($scrapedAssets),
                'is_spa' => $isSpaMode,
                'spa_html_code' => $isSpaMode ? $request->spa_html_code : null,

                'download_css' => $request->boolean('download_css', true),
                'download_images' => $request->boolean('download_images', true),
                'download_js' => $request->boolean('download_js', true),
                'download_fonts' => $request->boolean('download_fonts', true),
                'download_json' => $request->boolean('download_json', true),
                'download_other_assets' => $request->boolean('download_other_assets', true),
            ]);

            $message = __('Website.An phishing Website name') . ' "' . ($newWebsite->name ?? __('locale.[No Name]')) . '" ' . __('phishing.was added by username') . ' "' . (auth()->user()->name ?? __('locale.[No User Name]')) . '".';

            $spaIndicator = $isSpaMode ? '<small class="text-info"><i class="fa fa-code"></i> SPA Mode</small><br>' : '';
            $assetsIndicator = '';

            if (!empty($scrapedAssets)) {
                $assetTypes = [];
                foreach ($scrapedAssets as $asset) {
                    $type = $asset['type'] ?? 'unknown';
                    if (!in_array($type, $assetTypes)) {
                        $assetTypes[] = $type;
                    }
                }
                $assetsIndicator = '<small class="text-success"><i class="fa fa-download"></i> ' .
                    count($scrapedAssets) . ' ' . __('locale.Assets') . ' (' .
                    implode(', ', $assetTypes) . ')</small><br>';
            }

            $newWebsiteTemplate = '
    <div class="col-xl-3 col-sm-6 xl-4 website-card" data-id="' . $newWebsite->id . '">
        <div class="card">
            <div class="product-box">
                <div class="product-img">
                    <img class="img-fluid" src="' . asset($newWebsite->cover) . '" alt="">
                    <div class="product-hover">
                        <ul>';

            if (auth()->user()->hasPermission('website.trash')) {
                $newWebsiteTemplate .= '
                            <li>
                                <a class="show-frame trash-website" data-bs-toggle="tooltip" data-bs-placement="top" title="' . __('locale.Delete') . '" data-id="' . $newWebsite->id . '">
                                    <i class="icon-trash"></i>
                                </a>
                            </li>';
            }

            if (auth()->user()->hasPermission('website.edit')) {
                $newWebsiteTemplate .= '
                            <li>
                                <a class="show-frame edit-website" data-bs-toggle="tooltip" data-bs-placement="top" title="' . __('locale.Edit') . '" data-id="' . $newWebsite->id . '">
                                    <i class="icon-pencil-alt"></i>
                                </a>
                            </li>';
            }

            if (auth()->user()->hasPermission('website.view')) {
                $newWebsiteTemplate .= '
                            <li>
                                <a class="show-frame view-website" data-bs-toggle="tooltip" data-bs-placement="top" title="' . __('locale.View') . '" data-id="' . $newWebsite->id . '">
                                    <i class="icon-eye"></i>
                                </a>
                            </li>';
            }

            if (auth()->user()->hasPermission('website.copy')) {
                $newWebsiteTemplate .= '
                            <li>
                                <a class="show-frame copy-website" data-bs-toggle="tooltip" data-bs-placement="top" title="' . __('locale.Copy') . '" data-id="' . $newWebsite->id . '">
                                    <i class="icon-copy"></i>
                                </a>
                            </li>';
            }

            $newWebsiteTemplate .= '
                        </ul>
                    </div>
                </div>
                <div class="product-details">
                    <div class="product-name">
                        <h6>' . $spaIndicator . $newWebsite->name . '</h6>
                    </div>
                    <div class="product-price">
                        <small class="text-muted">' . __('locale.Category') . ': ' . ($newWebsite->phishingCategory->name ?? 'N/A') . '</small><br>
                        <small class="text-muted">' . __('locale.Type') . ': ' . ucfirst($newWebsite->type) . '</small><br>
                        <small class="text-muted">' . __('locale.Created') . ': ' . $newWebsite->created_at->diffForHumans() . '</small><br>' .
                $assetsIndicator;

            if ($isSpaMode) {
                $newWebsiteTemplate .= '<small class="text-primary"><i class="fa fa-magic"></i> ' . __('locale.Single Page Application') . '</small>';
            }

            $newWebsiteTemplate .= '
                    </div>
                </div>
            </div>
        </div>
    </div>';

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => __('Website.Website Added Successfully'),
                'website_template' => $newWebsiteTemplate,
                'website_data' => [
                    'id' => $newWebsite->id,
                    'name' => $newWebsite->name,
                    'is_spa' => $isSpaMode,
                    'assets_count' => count($scrapedAssets),
                    'asset_types' => array_unique(array_column($scrapedAssets, 'type')),
                    'created_at' => $newWebsite->created_at->diffForHumans(),
                    'download_summary' => [
                        'total_assets' => count($scrapedAssets),
                        'asset_breakdown' => array_count_values(array_column($scrapedAssets, 'type'))
                    ]
                ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => __('locale.Something went wrong') . ': ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $website = PhishingWebsitePage::with(['phishingCategory', 'domain'])->find($id);

            if (!$website) {
                return response()->json([
                    'status' => false,
                    'message' => __('locale.Error 404'),
                ], 404);
            }

            $websiteData = [
                'id' => $website->id,
                'name' => $website->name,
                'phishing_category_id' => $website->phishing_category_id,
                'from_address_name' => $website->from_address_name,
                'website_url' => $website->website_url,
                'html_code' => $website->html_code,
                'type' => $website->type,
                'domain_id' => $website->domain_id,
                'cover' => $website->cover ? asset('storage/' . $website->cover) : null,
                'is_spa' => $website->is_spa,
                'spa_html_code' => $website->spa_html_code,
                'scraped_assets' => json_decode($website->scraped_assets, true) ?? [],
                'created_at' => $website->created_at,
                'updated_at' => $website->updated_at,
                'category_name' => $website->category->name ?? null,
                'domain_name' => $website->domain->name ?? null,

                'download_css' => $website->download_css ?? true,
                'download_images' => $website->download_images ?? true,
                'download_js' => $website->download_js ?? true,
                'download_fonts' => $website->download_fonts ?? true,
                'download_json' => $website->download_json ?? true,
                'download_other_assets' => $website->download_other_assets ?? true,
            ];

            return response()->json($websiteData);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => __('locale.Something went wrong') . ': ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update($id, Request $request)
    {
        $website = PhishingWebsitePage::find($id);

        if (!$website) {
            return response()->json([
                'status' => false,
                'message' => __('locale.Error 404'),
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'phishing_category_id' => ['required'],
            'html_code' => 'required_without:website_url',
            'website_url' => 'required_without:html_code',
            'spa_html_code' => 'nullable|string',
            'is_spa' => 'nullable|boolean',
            'type' => 'required',
            'from_address_name' => 'required|string|max:100',
            'domain_id' => 'required_if:type,managed',
            'download_css' => 'nullable|boolean',
            'download_images' => 'nullable|boolean',
            'download_js' => 'nullable|boolean',
            'download_fonts' => 'nullable|boolean',
            'download_json' => 'nullable|boolean',
            'download_other_assets' => 'nullable|boolean',
        ]);

        if ($request->type == 'own') {
            $request->validate([
                'name' => ['required', 'max:200', Rule::unique('phishing_website_pages', 'name')->ignore($id)],
                'from_address_name' => 'email'
            ]);
        } else {
            $request->validate([
                'from_address_name' => [
                    'regex:/^[^@]+$/'
                ],
                'name' => [
                    'required',
                    'max:200',
                    Rule::unique('phishing_website_pages', 'name')->where(function ($query) use ($request) {
                        return $query->where('domain_id', $request->domain_id);
                    })->ignore($id),
                ],
            ]);
        }

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return response()->json([
                'status' => false,
                'errors' => $errors,
                'message' => __('locale.ThereWasAProblemUpdatingThewebsite') . "<br>" . __('locale.Validation error'),
            ], 422);
        }

        DB::beginTransaction();
        try {
            $coverPath = $website->cover;
            if ($request->hasFile('cover')) {
                if ($website->cover && Storage::exists($website->cover)) {
                    Storage::delete($website->cover);
                }

                $file = $request->file('cover');
                $coverPath = $this->storeFileInStorage($file, 'public/attachments');
            }

            $htmlCode = '';
            $scrapedAssets = json_decode($website->scraped_assets, true) ?? [];
            $isSpaMode = false;
            $needsRescraping = false;

            if ($request->has('website_url') && !empty($request->website_url)) {
                $oldUrl = $website->website_url;
                $newUrl = $request->website_url;
                $oldSpaMode = $website->is_spa;
                $newSpaMode = $request->boolean('is_spa', false);
                $oldSpaHtml = $website->spa_html_code;
                $newSpaHtml = $request->input('spa_html_code');

                $oldDownloadOptions = [
                    'css' => $website->download_css,
                    'images' => $website->download_images,
                    'js' => $website->download_js,
                    'fonts' => $website->download_fonts,
                    'json' => $website->download_json,
                    'other_assets' => $website->download_other_assets,
                ];

                $newDownloadOptions = [
                    'css' => $request->boolean('download_css', true),
                    'images' => $request->boolean('download_images', true),
                    'js' => $request->boolean('download_js', true),
                    'fonts' => $request->boolean('download_fonts', true),
                    'json' => $request->boolean('download_json', true),
                    'other_assets' => $request->boolean('download_other_assets', true),
                ];

                $needsRescraping = (
                    $oldUrl !== $newUrl ||
                    $oldSpaMode !== $newSpaMode ||
                    ($newSpaMode && $oldSpaHtml !== $newSpaHtml) ||
                    $oldDownloadOptions !== $newDownloadOptions
                );

                if ($needsRescraping) {
                    $this->deleteOldAssets($scrapedAssets);
                    $scraperService = new CompleteWebScraperService();
                    $isSpaMode = $newSpaMode;
                    $customHtml = $isSpaMode ? $newSpaHtml : null;
                    $scrapedData = $scraperService->scrapeCompleteWebsite(
                        $newUrl,
                        $customHtml,
                        $newDownloadOptions
                    );

                    if ($scrapedData['status'] === 'success') {
                        $htmlCode = $scrapedData['html'];
                        $scrapedAssets = $scrapedData['assets'];
                        $isSpaMode = $scrapedData['is_spa_mode'];
                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => __('locale.Failed to scrape website') . ': ' . $scrapedData['message'],
                            'error' => $scrapedData['message']
                        ], 400);
                    }
                } else {
                    $htmlCode = $website->html_code;
                    $isSpaMode = $website->is_spa;
                }
            } else {
                $htmlCode = html_entity_decode($request->updated_html_code ?? $request->html_code);
                $isSpaMode = $request->boolean('is_spa', false);
                if ($website->html_code !== $htmlCode) {
                    $this->deleteOldAssets($scrapedAssets);
                    $scrapedAssets = [];
                }
            }

            $domain_id = null;
            if ($request->type == 'managed') {
                $domain_id = $request->domain_id;
            }

            $website->update([
                'name' => $request->name,
                'cover' => $coverPath,
                'phishing_category_id' => $request->phishing_category_id,
                'html_code' => $htmlCode,
                'type' => $request->type,
                'website_url' => $request->website_url,
                'from_address_name' => $request->from_address_name,
                'domain_id' => $domain_id,
                'scraped_assets' => json_encode($scrapedAssets),
                'is_spa' => $isSpaMode,
                'spa_html_code' => $isSpaMode ? $request->spa_html_code : null,
                'download_css' => $request->boolean('download_css', true),
                'download_images' => $request->boolean('download_images', true),
                'download_js' => $request->boolean('download_js', true),
                'download_fonts' => $request->boolean('download_fonts', true),
                'download_json' => $request->boolean('download_json', true),
                'download_other_assets' => $request->boolean('download_other_assets', true),
            ]);

            $message = __('Website.Phishing Website') . ' "' . ($website->name ?? __('locale.[No Name]')) . '" ' . __('phishing.was updated by username') . ' "' . (auth()->user()->name ?? __('locale.[No User Name]')) . '".';

            $updatedWebsiteTemplate = $this->generateWebsiteTemplate($website, $isSpaMode, $scrapedAssets);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => __('locale.websiteWasUpdatedSuccessfully'),
                'website' => $website->fresh(),
                'updatedWebsiteTemplate' => $updatedWebsiteTemplate,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => __('locale.Something went wrong') . ': ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }


    private function deleteOldAssets($assets)
    {
        if (empty($assets) || !is_array($assets)) {
            return;
        }

        foreach ($assets as $asset) {
            try {
                if (isset($asset['local_path'])) {
                    $storagePath = str_replace('public/', '', $asset['local_path']);

                    if (Storage::disk('public')->exists($storagePath)) {
                        Storage::disk('public')->delete($storagePath);
                        \Log::info('Deleted old asset: ' . $storagePath);
                    }
                }
            } catch (\Exception $e) {
                \Log::warning('Failed to delete old asset: ' . $e->getMessage(), [
                    'asset' => $asset
                ]);
            }
        }
    }


    private function generateWebsiteTemplate($website, $isSpaMode, $scrapedAssets)
    {
        $spaIndicator = $isSpaMode ? '<small class="text-info">SPA Mode</small><br>' : '';

        $template = '
            <div class="col-xl-3 col-sm-6 xl-4 website-card" data-id="' . $website->id . '">
                <div class="card">
                    <div class="product-box">
                        <div class="product-img">
                            <img class="img-fluid" src="' . asset($website->cover) . '" alt="">
                            <div class="product-hover">
                                <ul>';

        if (auth()->user()->hasPermission('website.trash')) {
            $template .= '
                            <li>
                                <a class="show-frame trash-website" data-bs-toggle="tooltip" data-bs-placement="top" title="' . __('locale.Delete') . '" data-id="' . $website->id . '">
                                    <i class="icon-trash"></i>
                                </a>
                            </li>';
        }

        if (auth()->user()->hasPermission('website.edit')) {
            $template .= '
                            <li>
                                <a class="show-frame edit-website" data-bs-toggle="tooltip" data-bs-placement="top" title="' . __('locale.Edit') . '" data-id="' . $website->id . '">
                                    <i class="icon-pencil-alt"></i>
                                </a>
                            </li>';
        }

        if (auth()->user()->hasPermission('website.view')) {
            $template .= '
                            <li>
                                <a class="show-frame view-website" data-bs-toggle="tooltip" data-bs-placement="top" title="' . __('locale.View') . '" data-id="' . $website->id . '">
                                    <i class="icon-eye"></i>
                                </a>
                            </li>';
        }

        if (auth()->user()->hasPermission('website.copy')) {
            $template .= '
                            <li>
                                <a class="show-frame copy-website" data-bs-toggle="tooltip" data-bs-placement="top" title="' . __('locale.Copy') . '" data-id="' . $website->id . '">
                                    <i class="icon-copy"></i>
                                </a>
                            </li>';
        }

        $template .= '
                        </ul>
                    </div>
                </div>
                <div class="product-details">
                    <div class="product-name">
                        <h6>' . $spaIndicator . $website->name . '</h6>
                    </div>
                    <div class="product-price">
                        <small class="text-muted">' . __('locale.Category') . ': ' . ($website->phishingCategory->name ?? 'N/A') . '</small><br>
                        <small class="text-muted">' . __('locale.Type') . ': ' . ucfirst($website->type) . '</small><br>
                        <small class="text-muted">' . __('locale.Updated') . ': ' . $website->updated_at->diffForHumans() . '</small>';

        if ($isSpaMode) {
            $template .= '<br><small class="text-info"><i class="fa fa-code"></i> SPA Website</small>';
        }

        if (!empty($scrapedAssets)) {
            $assetCount = count($scrapedAssets);
            $template .= '<br><small class="text-success"><i class="fa fa-download"></i> ' . $assetCount . ' ' . __('locale.Assets Downloaded') . '</small>';
        }

        $template .= '
                            </div>
                        </div>
                    </div>
                </div>
            </div>';

        return $template;
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
        $categories = PhishingCategory::all();

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

    public function show($name, $id)
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
        return view('admin.content.phishing.websites.show_website', compact('website', 'decodedName'));
    }

    public function testAction()
    {
        dd('Hello From Post ');
    }
}
