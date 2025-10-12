<?php
namespace App\Http\Controllers\admin\phishing;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\phishing\PhishingDomainsRequest;
use App\Interfaces\Admin\Phishing\PhishingDomainsInterface;
use Illuminate\Http\Request;

class PhishingDomainsController extends Controller
{
    protected $PhishingDomainsInterface;

    public function __construct(PhishingDomainsInterface $PhishingDomainsInterface)
    {
        $this->PhishingDomainsInterface = $PhishingDomainsInterface;
    }
    public function index()
    {
        return $this->PhishingDomainsInterface->index();
    }
    public function store(PhishingDomainsRequest $request)
    {
        return $this->PhishingDomainsInterface->store($request);
    }
    public function update($id,PhishingDomainsRequest $request)
    {
        return $this->PhishingDomainsInterface->update($id,$request);
    }
    public function trash($domain)
    {
        return $this->PhishingDomainsInterface->trash($domain);
    }
    public function restore($id,Request $request)
    {
        return $this->PhishingDomainsInterface->restore($id,$request);
    }
    public function delete($id)
    {
        return $this->PhishingDomainsInterface->delete($id);
    }
    public function getProfiles($id)
    {
        return $this->PhishingDomainsInterface->getProfiles($id);
    }

    public function getProfilesDataTable($id)
    {
        return $this->PhishingDomainsInterface->getProfilesDataTable($id);
    }

    public function getArchivedDomains()
    {
        return $this->PhishingDomainsInterface->getArchivedDomains();
    }
}
