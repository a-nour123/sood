<?php

namespace App\Jobs;

use App\Events\FinishTenableCreated;
use App\Models\Asset;
use App\Models\AssetGroup;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TenableImportAssetsGroup implements ShouldQueue
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
                $assetGroupId = $data['assetId'];
                $assetName = $data['assetName'];

                // Create or find the asset group based on 'id'
                $assetGroup = AssetGroup::updateOrCreate(
                    ['asset_group_id' => $assetGroupId],
                    ['name' => $assetName]
                );

                // Process IP addresses and associate assets to the correct groups
                foreach ($data['ipAddresses'] as $ip) {
                    // Validate the IP address format before proceeding
                    if (filter_var($ip, FILTER_VALIDATE_IP)) {
                        // Check if the asset exists first
                        $asset = Asset::where('ip', $ip)->first();

                        if ($asset) {
                             // We are using sync to make sure that only valid groups are associated
                            $assetGroup->assets()->syncWithoutDetaching([$asset->id]);

                        } else {
                            // Log asset not found for the given IP
                            Log::info('Asset not found for IP, skipping', ['ip' => $ip]);
                        }
                    } else {
                        // Log invalid IP address format
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
