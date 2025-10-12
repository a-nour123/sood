<?php


namespace App\Interfaces\Admin\Phishing;
use Illuminate\Http\Request;

interface PhishingLandingPageInterface
{
    public function getAll();
    public function store(Request $request);
    public function update($id,Request $request);
    public function trash($page);
    public function restore($id,Request $request);
    public function delete($id);
    public function getArchivedLandingPages();
    public function search(Request $request);
    public function searchTrash(Request $request);
    public function show($id);
    public function testAction();
    public function duplicate(Request $request,$id);


}
