<?php

namespace App\Http\Controllers\admin\phishing;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\phishing\PhishingTemplateRequest;
use App\Interfaces\Admin\Phishing\PhishingTemplateInterface;
use Illuminate\Http\Request;

class PhishingTemplateController extends Controller
{
    protected $PhishingTemplateInterface;

    public function __construct(PhishingTemplateInterface $PhishingTemplateInterface)
    {
        $this->PhishingTemplateInterface = $PhishingTemplateInterface;
    }
    public function index()
    {
        return $this->PhishingTemplateInterface->index();
    }
    public function store(PhishingTemplateRequest $request)
    {
        return $this->PhishingTemplateInterface->store($request);
    }
    public function edit($id)
    {
        return $this->PhishingTemplateInterface->edit($id);
    }

    public function show($id)
    {
        return $this->PhishingTemplateInterface->show($id);
    }

    public function update($id,PhishingTemplateRequest $request)
    {
        return $this->PhishingTemplateInterface->update($id,$request);
    }

    public function getArchivedemailTemplate()
    {
        return $this->PhishingTemplateInterface->getArchivedemailTemplate();
    }

    public function trash($domain)
    {
        return $this->PhishingTemplateInterface->trash($domain);
    }
    public function restore($id,Request $request)
    {
        return $this->PhishingTemplateInterface->restore($id,$request);
    }
    public function delete($id)
    {
        return $this->PhishingTemplateInterface->delete($id);
    }

    public function uploadFile(Request $request)
    {
        return $this->PhishingTemplateInterface->uploadFile($request);
    }

    public function uploadImage(Request $request)
    {
        return $this->PhishingTemplateInterface->uploadImage($request);
    }

}
