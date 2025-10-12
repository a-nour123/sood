<?php

namespace App\Services;

use App\Jobs\ExportAssetsJob;
use App\Jobs\ExportVulnJob;
use Illuminate\Support\Facades\Auth;

class VulnsExportService
{
    public function exportVulns($type,$tenable_status= null,$severity= null,$region,$assetgroup= null)
    {

        $chunkSize = 500000;
        $userEmail = Auth::user()->id; // Ensure user email is properly set

        $downloadUrl = route('admin.vulnerability_management.download.export.vuln'); // Use the named route here
        $currentUser = auth()->user();

        // Start the export process with the first job
        dispatch(new ExportVulnJob($type,$tenable_status,$severity,$region, $userEmail, 0, $chunkSize,$downloadUrl,$currentUser,$assetgroup));

        // Return a response message immediately
        return 'Export process has started. You will receive a notification once it is completed.';
    }
}
