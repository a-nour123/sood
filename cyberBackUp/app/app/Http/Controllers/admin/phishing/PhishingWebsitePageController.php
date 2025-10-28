<?php

namespace App\Http\Controllers\admin\phishing;

use App\Http\Controllers\Controller;
use App\Interfaces\Admin\Phishing\PhishingWebsiteInterface;
use Illuminate\Http\Request;

class PhishingWebsitePageController extends Controller
{
    protected $PhishingWebsiteInterface;
    public function __construct(PhishingWebsiteInterface $PhishingWebsiteInterface)
    {
        $this->PhishingWebsiteInterface = $PhishingWebsiteInterface;
    }
    public function getAll()
    {
        return $this->PhishingWebsiteInterface->getAll();
    }
    public function store(Request $request)
    {
        return $this->PhishingWebsiteInterface->store($request);
    }

    public function edit($id)
    {
        return $this->PhishingWebsiteInterface->edit($id);
    }

    public function update($id, Request $request)
    {
        return $this->PhishingWebsiteInterface->update($id, $request);
    }
    public function trash($website)
    {
        return $this->PhishingWebsiteInterface->trash($website);
    }
    public function restore($id, Request $request)
    {
        return $this->PhishingWebsiteInterface->restore($id, $request);
    }
    public function delete($id)
    {
        return $this->PhishingWebsiteInterface->delete($id);
    }
    public function getArchivedWebsites()
    {
        return $this->PhishingWebsiteInterface->getArchivedWebsites();
    }

    public function search(Request $request)
    {
        return $this->PhishingWebsiteInterface->search($request);
    }
    public function searchTrash(Request $request)
    {
        return $this->PhishingWebsiteInterface->searchTrash($request);
    }
    public function show($name, $id)
    {
        return $this->PhishingWebsiteInterface->show($name, $id);
    }


    public function testAction()
    {
        return $this->PhishingWebsiteInterface->testAction();
    }

}
