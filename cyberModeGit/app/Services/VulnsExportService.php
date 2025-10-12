<?php

namespace App\Services;

use App\Jobs\ExportVulnJob;
use Illuminate\Support\Facades\Auth;

class VulnsExportService
{
    public function exportVulns(
        $type,
        $tenable_status = null,
        $severity = null,
        $region,
        $assetgroup = null,
        $firstObserved = null,
        $lastObserved = null,
        $cve = null,
        $exploit = null,
        $owner_email = null,
        $ip = null

    ) {
        $chunkSize = 500000;

        $downloadUrl = route('admin.vulnerability_management.download.export.vuln');
        $currentUser = auth()->user();

        // Dispatch the job with all filter parameters
        dispatch(new ExportVulnJob(
            $type,
            $tenable_status,
            $severity,
            $region,
            0,
            $chunkSize,
            $downloadUrl,
            $currentUser,
            $assetgroup,
            $firstObserved,
            $lastObserved,
            $cve,
            $exploit,
            $owner_email,
            $ip
        ));

        return 'Export process has started. You will receive a notification once it is completed.';
    }
}