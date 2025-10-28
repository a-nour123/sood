<?php


namespace App\Interfaces\Admin\Phishing;

use App\Http\Requests\admin\phishing\PhishingDomainsRequest;
use Illuminate\Http\Request;

// use Illuminate\Http\Request;

interface PhishingDomainsInterface
{
    public function index();
    public function store(PhishingDomainsRequest $request);
    public function update($id,PhishingDomainsRequest $request);
    public function trash($domain);
    public function restore($id,Request $request);
    public function delete($id);
    public function getProfiles($id);
    public function getProfilesDataTable($id);
    public function getArchivedDomains();
}
