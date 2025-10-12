<?php

namespace App\Http\Controllers\admin\phishing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Admin\Phishing\PhishingLandingPageInterface;

class PhishingLandingPageController extends Controller
{
    protected $PhishingLandingPageInterface;

    public function __construct(PhishingLandingPageInterface $PhishingLandingPageInterface)
    {
        $this->PhishingLandingPageInterface = $PhishingLandingPageInterface;
    }
    public function getAll()
    {
        return $this->PhishingLandingPageInterface->getAll();
    }
    public function store(Request $request)
    {
        return $this->PhishingLandingPageInterface->store($request);
    }
    public function update($id, Request $request)
    {
        return $this->PhishingLandingPageInterface->update($id, $request);
    }
    public function trash($page)
    {
        return $this->PhishingLandingPageInterface->trash($page);
    }
    public function restore($id, Request $request)
    {
        return $this->PhishingLandingPageInterface->restore($id, $request);
    }
    public function delete($id)
    {
        return $this->PhishingLandingPageInterface->delete($id);
    }
    public function getArchivedLandingPages()
    {
        return $this->PhishingLandingPageInterface->getArchivedLandingPages();
    }

    public function search(Request $request)
    {
        return $this->PhishingLandingPageInterface->search($request);
    }
    public function searchTrash(Request $request)
    {
        return $this->PhishingLandingPageInterface->searchTrash($request);
    }
    public function show($id)
    {
        return $this->PhishingLandingPageInterface->show($id);
    }


    public function testAction()
    {
        return $this->PhishingLandingPageInterface->testAction();
    }

    public function duplicate(Request $request,$id)
    {
        return $this->PhishingLandingPageInterface->duplicate($request,$id);
    }
}
