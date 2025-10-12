<?php


namespace App\Repositories\Admin\Phishing;

use App\Helpers\Helper;
use App\Interfaces\Admin\Phishing\PhishingCategoryInterface;
use App\Models\PhishingCategory;
use App\Models\PhishingDomains;
use App\Models\PhishingWebsitePage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PhishingCategoryRepository implements PhishingCategoryInterface
{

    public function getAll()
    {
        try {

            $categories = PhishingCategory::withoutTrashed()->orderBy('created_at','desc')->get();
            $breadcrumbs = [
                ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
                ['link' => route('admin.phishing.campaign.index'), 'name' => __('phishing.campaign')],
                ['name' => __('phishing.category')]
            ];

            return view('admin.content.phishing.category.index', compact('breadcrumbs', 'categories'));
        } catch (\Exception $e) {
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:200', 'unique:phishing_categories,name'],
        ]);

        // Check if there are any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = [
                'status' => false,
                'errors' => $errors,
                'message' => __('locale.ThereWasAProblemAddingcategory') . "<br>" . __('locale.Validation error'),
            ];
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();
            try {
                $newCategory = PhishingCategory::create([
                    'name' => $request->name,
                ]);

                // Audit log
                $message = __('category.An phishing category name') . ' "' . ($newCategory->name ?? __('locale.[No Name]')) . '" ' . __('asset.was added by username') . ' "' . (auth()->user()->name ?? __('locale.[No User Name]')) . '".';
                $newCategoryTemplate = '<div class="col-4">
                <div class="regulator-item p-3">
                    <div class="card" style="background-image: url(\'' . asset('images/widget-bg.png') . '\');">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="chart-progress me-3" data-color=""
                                        data-series="' . Helper::ImplementedStatistic($newCategory->id) . '" data-progress_variant="true"></div>
                                </div>
                                <div class="col-md-9 py-1">
                                    <h4>' . $newCategory->name . '</h4>
                                    <button class="btn btn-secondary show-frame edit-regulator" type="button" data-bs-toggle="modal"
                                        data-id="' . $newCategory->id . '" data-name="' . $newCategory->name . '">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <a class="btn btn-secondary show-frame" href="' . route('admin.phishing.domain.profiles', $newCategory->id) . '" title="Profiles">
                                        <i class="fa-solid fa-users"></i>
                                    </a>
                                    <button class="btn btn-secondary show-frame trash-domain" type="button" data-bs-toggle="modal"
                                        data-id="' . $newCategory->id . '" onclick="ShowModalDeleteCategory(' . $newCategory->id . ')" data-name="' . $newCategory->name . '">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';

                DB::commit();
                $response = [
                    'status' => true,
                    'message' => __('asset.CategoryWasAddedSuccessfully'),
                    'newCategoryTemplate' => $newCategoryTemplate, // Include the new category in the response
                ];
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();
                $response = [
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                ];
                return response()->json($response, 502);
            }
        }
    }

    public function update($id, Request $request)
    {
        $category = PhishingCategory::find($id);
        if ($category) {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'max:200', 'unique:phishing_categories,name'],
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('locale.ThereWasAProblemUpdatingThecategory') . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                try {
                    $category->update([
                        'name' => $request->name,
                    ]);
                    $response = array(
                        'status' => true,
                        'message' => __('locale.CategoryWasUpdatedSuccessfully'),
                    );
                    return response()->json($response, 200);
                } catch (\Throwable $th) {
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
    public function trash($category)
    {
        $Category = PhishingCategory::findOrFail($category);

        // Check if the category has any associated websites
        if ($Category->websites()->exists()) {
            $response = array(
                'status' => false,
                'message' => __('phishing.CategoryCannotBeTrashedAsItHasWebsites'),
            );
            return response()->json($response, 400);
        }

        // Proceed with soft deletion if no websites are associated
        $Category->update([
            'deleted_at' => now(),
        ]);

        $response = array(
            'status' => true,
            'message' => __('phishing.CategoryWasTrashedSuccessfully'),
        );
        return response()->json($response, 200);
    }

    public function restore($id,Request $request)
    {
        try {
            // Use withTrashed() to include soft-deleted records
            $Category = PhishingCategory::withTrashed()->findOrFail($id);
            // Restore the soft-deleted record
            $Category->restore();

            $response = [
                'status' => true,
                'message' => __('phishing.CategoryRestoreSuccessfully'),
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
        $Category = PhishingCategory::withTrashed()->findOrFail($id);
      if($Category){

          $Category->forceDelete();
          $response = array(
            'status' => true,
            'message' => __('phishing.CategoryWasDeletedSuccessfully'),
        );
        return response()->json($response, 200);
      }else{
        $response = [
            'status' => false,
            'message' => __('locale.Error'),
        ];
        return response()->json($response, 502);
      }

    }

    public function getArchivedCategories()
    {
        $archived_categories = PhishingCategory::onlyTrashed()->get();
        return view('admin.content.phishing.category.archived', get_defined_vars());
    }
    public function getCategoryWebsites($id)
    {
        $categories = PhishingCategory::withoutTrashed()->get();
        $domains = PhishingDomains::withoutTrashed()->orderBy('created_at','desc')->get();
        $websites = PhishingWebsitePage::where('phishing_category_id',$id)->withoutTrashed()->get();
        return view('admin.content.phishing.websites.index', get_defined_vars());
    }

}
