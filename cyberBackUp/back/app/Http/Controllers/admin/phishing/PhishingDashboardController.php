<?php

namespace App\Http\Controllers\admin\phishing;

use App\Http\Controllers\Controller;
use App\Interfaces\Admin\Phishing\PhishingDashboardInterface;

class PhishingDashboardController extends Controller
{
    protected $PhishingDashboardInterface;

    public function __construct(PhishingDashboardInterface $PhishingDashboardInterface)
    {
        $this->PhishingDashboardInterface = $PhishingDashboardInterface;
    }
    public function index()
    {
        return $this->PhishingDashboardInterface->index();
    }

    public function reporting()
    {
        return $this->PhishingDashboardInterface->reporting();
    }

    public function trainingReporting()
    {
        return $this->PhishingDashboardInterface->trainingReporting();
    }





}
