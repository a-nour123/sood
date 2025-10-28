<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TenableService;

class FetchVulnerabilities extends Command
{
    protected $signature = 'fetch:vulnerabilities';

    protected $description = 'Fetch new vulnerabilities from Tenable';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $tenableService = new TenableService();
        $tenableService->syncHostsAndVulnerabilities();
    }
}
