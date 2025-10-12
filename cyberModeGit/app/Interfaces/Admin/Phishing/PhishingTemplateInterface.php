<?php


namespace App\Interfaces\Admin\Phishing;

use App\Http\Requests\admin\phishing\PhishingTemplateRequest;
use Illuminate\Http\Request;

interface PhishingTemplateInterface
{
    public function index();
    public function store(PhishingTemplateRequest $request);
    public function edit($id);
    public function show($id);
    public function update($id,PhishingTemplateRequest $request);
    public function trash($domain);
    public function getArchivedemailTemplate();
    public function restore($id,Request $request);
    public function delete($id);

    public function uploadFile(Request $request);
    public function uploadImage(Request $request);
}
