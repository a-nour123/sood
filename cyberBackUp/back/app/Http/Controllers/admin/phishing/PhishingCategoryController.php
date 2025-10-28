<?php

namespace App\Http\Controllers\admin\phishing;

use App\Http\Controllers\Controller;
use App\Interfaces\Admin\Phishing\PhishingCategoryInterface;
use Illuminate\Http\Request;

class PhishingCategoryController extends Controller
{
    protected $PhishingCategoryInterface;
    public function __construct(PhishingCategoryInterface $PhishingCategoryInterface)
    {
        $this->PhishingCategoryInterface = $PhishingCategoryInterface;
    }
   public function getAll(){
    return $this->PhishingCategoryInterface->getAll();
   }
   public function store(Request $request){
    return $this->PhishingCategoryInterface->store($request);

   }
   public function update($id,Request $request)
   {
       return $this->PhishingCategoryInterface->update($id,$request);
   }
   public function trash($category)
   {
       return $this->PhishingCategoryInterface->trash($category);
   }
   public function restore($id,Request $request)
   {
       return $this->PhishingCategoryInterface->restore($id,$request);
   }
   public function delete($id)
   {
       return $this->PhishingCategoryInterface->delete($id);
   }
   public function getArchivedCategories()
   {
       return $this->PhishingCategoryInterface->getArchivedCategories();
   }
   public function getCategoryWebsites($id)
   {
       return $this->PhishingCategoryInterface->getCategoryWebsites($id);
   }
}
