<?php

namespace App\Services;

use App\Jobs\ExportAssetsJob;
use Illuminate\Support\Facades\Auth;

class AssetExportService
{
    public function exportAssets($type,$region=null)
    {
        $chunkSize = 500000;
        $userEmail = Auth::user()->id; // Ensure user email is properly set

        $downloadUrl = route('admin.asset_management.download.export'); // Use the named route here

        // Start the export process with the first job
        dispatch(new ExportAssetsJob($type,$region, $userEmail, 0, $chunkSize,$downloadUrl));

        // Return a response message immediately
        return 'Export process has started. You will receive a notification once it is completed.';
    }
}
