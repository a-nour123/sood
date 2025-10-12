<?php

namespace App\Http\Controllers\admin\phishing;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\phishing\PhishingSenderProfileRequest;
use App\Interfaces\Admin\Phishing\PhishingSenderProfileInterface;
use Illuminate\Http\Request;

class PhishingSenderProfileController extends Controller
{
    protected $PhishingSenderProfileInterface;

    public function __construct(PhishingSenderProfileInterface $PhishingSenderProfileInterface)
    {
        $this->PhishingSenderProfileInterface = $PhishingSenderProfileInterface;
    }
    public function index()
    {
        return $this->PhishingSenderProfileInterface->index();
    }
    public function PhishingSenderProfileDatatable(Request $request)
    {
        return $this->PhishingSenderProfileInterface->PhishingSenderProfileDatatable($request);
    }
    public function store(PhishingSenderProfileRequest $request)
    {
        return $this->PhishingSenderProfileInterface->store($request);
    }
    public function update($id,PhishingSenderProfileRequest $request)
    {
        return $this->PhishingSenderProfileInterface->update($id,$request);
    }
    public function trash($domain)
    {
        return $this->PhishingSenderProfileInterface->trash($domain);
    }
    public function restore($id,Request $request)
    {
        return $this->PhishingSenderProfileInterface->restore($id,$request);
    }
    public function delete($id)
    {
        return $this->PhishingSenderProfileInterface->delete($id);
    }
    public function getArchivedSenderProfile()
    {
        return $this->PhishingSenderProfileInterface->getArchivedSenderProfile();
    }

    public function archivedSenderProfileDatatable(Request $request)
    {
        return $this->PhishingSenderProfileInterface->archivedSenderProfileDatatable($request);
    }

}
