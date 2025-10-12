<?php


namespace App\Interfaces\Admin\Phishing;
use Illuminate\Http\Request;

interface PhishingWebsiteInterface
{
    public function getAll();
    public function store(Request $request);
    public function edit($id);
    public function update($id,Request $request);
    public function trash($website);
    public function restore($id,Request $request);
    public function delete($id);
    public function getArchivedWebsites();
    public function search(Request $request);
    public function searchTrash(Request $request);
    public function show($name,$id);
    public function testAction();


}
