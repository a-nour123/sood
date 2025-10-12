<?php

namespace App\Http\Controllers\admin\phishing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PhishingEmployeeListController extends Controller
{
    protected $PhishingEmployeeListInterface;

    // public function __construct(PhishingEmployeeListInterface $PhishingEmployeeListInterface)
    // {
    //     $this->PhishingEmployeeListInterface = $PhishingEmployeeListInterface;
    // }
    public function index()
    {
        return $this->PhishingEmployeeListInterface->index();
    }
    public function store(Request $request)
    {
        return $this->PhishingEmployeeListInterface->store($request);
    }
    public function edit($id)
    {
        return $this->PhishingEmployeeListInterface->edit($id);
    }

    public function update($id,Request $request)
    {
        return $this->PhishingEmployeeListInterface->update($id,$request);
    }

    public function getArchivedemailTemplate()
    {
        return $this->PhishingEmployeeListInterface->getArchivedemailTemplate();
    }

    public function trash($domain)
    {
        return $this->PhishingEmployeeListInterface->trash($domain);
    }
    public function restore($id,Request $request)
    {
        return $this->PhishingEmployeeListInterface->restore($id,$request);
    }
    public function delete($id)
    {
        return $this->PhishingEmployeeListInterface->delete($id);
    }
}
