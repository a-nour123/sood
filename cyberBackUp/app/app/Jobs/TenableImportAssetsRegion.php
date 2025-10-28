<?php

namespace App\Jobs;

use App\Events\FinishTenableCreated;
use App\Models\Asset;
use App\Models\AssetGroup;
use App\Models\HostRegion;
use App\Models\TenableAuth;
use App\Services\TenableServiceAssets;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TenableImportAssetsRegion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $assetsWithHost;

    public function __construct($assetsWithHost)
    {
        $this->assetsWithHost = $assetsWithHost;
     }

    public function handle()
    {
        // Process the provided assets with hosts data
        $this->processInChunks($this->assetsWithHost);
    }

    protected function processInChunks($data)
    {
        DB::beginTransaction(); // Begin transaction for the entire dataset
    
        try {
            // Check if data is an array and has the expected structure
            if (is_array($data) && isset($data['assetId'], $data['ipAddresses'], $data['assetName'])) {
                $assetGroupRegionName = $data['assetName'];
                $assetGroupId = $data['assetId'];

                $assetGroup = HostRegion::updateOrCreate(
                    ['host_region_id' => $assetGroupId],
                    ['name' => $assetGroupRegionName]
                );
                // Process IP addresses
                foreach ($data['ipAddresses'] as $ip) {
                    // Validate the IP address format before proceeding
                    if (filter_var($ip, FILTER_VALIDATE_IP)) {
                        // Check if the asset exists first
                        $asset = Asset::where('ip', $ip)->first();
    
                        if ($asset) {

                            // $assetGroup->hosts()->attach($asset->id);
                            // Associate asset with the asset group
                            $assetGroup->hosts()->syncWithoutDetaching([$asset->id]);
 
                        } else {
                            // Optionally log that the asset was not found
                            Log::info('Asset not found for IP, skipping', ['ip' => $ip]);
                        }
                    } else {
                        // Log invalid IP address
                        Log::warning('Invalid IP address format', ['ip' => $ip]);
                    }
                }
            } else {
                // Log the entire item that failed validation
                Log::warning('Invalid data format', ['data' => $data]);
            }
    
            DB::commit(); // Commit the transaction after processing all data
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error
            Log::error('Error processing data: ' . $e->getMessage(), [
                'exception' => $e,
                'data' => $data
            ]);
        }
    }
    






}
