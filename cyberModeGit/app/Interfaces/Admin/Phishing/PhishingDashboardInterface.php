<?php


namespace App\Interfaces\Admin\Phishing;

use App\Http\Requests\admin\phishing\PhishingDomainsRequest;
use Illuminate\Http\Request;

interface PhishingDashboardInterface
{
    public function index();
    public function reporting();
    public function trainingReporting();

}
