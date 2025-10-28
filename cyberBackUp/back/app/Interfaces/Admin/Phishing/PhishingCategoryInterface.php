<?php


namespace App\Interfaces\Admin\Phishing;
use Illuminate\Http\Request;

interface PhishingCategoryInterface
{
    public function getAll();
    public function store(Request $request);
    public function update($id,Request $request);
    public function trash($category);
    public function restore($id,Request $request);
    public function delete($id);
    public function getArchivedCategories();
    public function getCategoryWebsites($id);

}
