<?php

namespace App\Http\Controllers\admin\phishing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Admin\Phishing\PhishingGroupInterface;

class PhishingGroupController extends Controller
{
    protected $PhishingGroupInterface;

    public function __construct(PhishingGroupInterface $PhishingGroupInterface)
    {
        $this->PhishingGroupInterface = $PhishingGroupInterface;
    }
    public function getAll()
    {
        return $this->PhishingGroupInterface->getAll();
    }
    public function PhishingGroupeDatatable(Request $request)
    {
        return $this->PhishingGroupInterface->PhishingGroupeDatatable($request);
    }
    public function store(Request $request)
    {
        return $this->PhishingGroupInterface->store($request);
    }
    public function update($id, Request $request)
    {
        return $this->PhishingGroupInterface->update($id, $request);
    }
    public function trash($page)
    {
        return $this->PhishingGroupInterface->trash($page);
    }
    public function restore($id, Request $request)
    {
        return $this->PhishingGroupInterface->restore($id, $request);
    }
    public function delete($id)
    {
        return $this->PhishingGroupInterface->delete($id);
    }
    public function getArchivedGroups()
    {
        return $this->PhishingGroupInterface->getArchivedGroups();
    }

    public function archivedGroupsDatatable(Request $request)
    {
        return $this->PhishingGroupInterface->archivedGroupsDatatable($request);
    }
    public function AddUsersTogroup(Request $request)
    {
        return $this->PhishingGroupInterface->AddUsersTogroup($request);
    }
    public function getUsersForGroup($id)
    {
        return $this->PhishingGroupInterface->getUsersForGroup($id);
    }

}
