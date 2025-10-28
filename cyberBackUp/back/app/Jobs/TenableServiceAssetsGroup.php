<?php

namespace App\Services;

use App\Http\Traits\NotificationHandlingTrait;
use App\Jobs\TenableImportAssetsGroup;
use App\Models\Action;
use App\Models\Asset;
use GuzzleHttp\Client;
use App\Models\TenableAuth;
use Illuminate\Support\Facades\Log;

class TenableServiceAssetsGroup
{
    use NotificationHandlingTrait;


    protected $accessKey;
    protected $secretKey;
    protected $api_url;
    protected $endSize;
    protected $idsAssetGroups;

    public function __construct()
    {
        try {
            $this->fetchApiKeys();
            $this->endSize = 500; // Define the number of assets to fetch in one request
        } catch (\Exception $e) {
            Log::error('Error in constructor: ' . $e->getMessage());
        }
    }


    private function fetchApiKeys()
    {
        try {
            $tenableAuth = TenableAuth::first();
            if ($tenableAuth) {
                $this->accessKey = base64_decode($tenableAuth->access_key);
                $this->secretKey = base64_decode($tenableAuth->secret_key);
                $this->api_url = $tenableAuth->api_url;
                $this->idsAssetGroups = $tenableAuth->idsAssetGroup;
            } else {
                throw new \Exception('TenableAuth not found.');
            }
        } catch (\Exception $e) {
            Log::error('Error fetching API keys: ' . $e->getMessage());
        }
    }

    public function syncAssetsgroups()
    {
        try {
            $client = new Client();

            // Fetch all assets and hosts from all asset groups
            $assetsWithHosts = $this->fetchAssetsAndHosts($client);

            if (!empty($assetsWithHosts)) {
                foreach ($assetsWithHosts as $assetsWithHost) {
                    // Chunk the IP addresses into groups of 500
                    $ipChunks = array_chunk($assetsWithHost['ipAddresses'], 500);

                    foreach ($ipChunks as $ipChunk) {
                        // Fetch only the IPs that exist in the Asset model
                        $existingIPs = Asset::whereIn('ip', $ipChunk)->pluck('ip')->toArray();
                        // Check if existingIPs is empty
                        if (empty($existingIPs)) {
                            // If no existing IPs, get the next chunk of IP addresses
                            continue; // Skip this iteration and move to the next chunk
                        }

                        $chunkedAssetsWithHost = [
                            'assetId' => $assetsWithHost['id'],
                            'assetName' => $assetsWithHost['assetName'],
                            'ipAddresses' => $existingIPs,
                        ];

                        dispatch(new TenableImportAssetsGroup($chunkedAssetsWithHost))
                            ->delay(now()->addSeconds(10));
                    }
                }
                $this->HandelNotification();
            }
        } catch (\Exception $e) {
            Log::error('Error syncing assets with hosts: ' . $e->getMessage());
        }
    }


    private function fetchAssetsAndHosts(Client $client)
    {
        $idsAssetGroupsLists = explode(',', $this->idsAssetGroups);
        $allAssetsWithHosts = [];

        foreach ($idsAssetGroupsLists as $idsAssetGroup) {
            try {
                // Fetch data from API for each asset group
                $response = $client->request('GET', $this->api_url . '/asset/' . $idsAssetGroup, [
                    'headers' => [
                        'Accept' => 'application/json',
                        'x-apikey' => 'accesskey=' . $this->accessKey . ';secretkey=' . $this->secretKey,
                    ],
                    'verify' => false

                ]);

                $assetsData = json_decode($response->getBody(), true);

                // Process and aggregate assets from each response
                $processedAssets = $this->processAssetsWithHosts($assetsData['response'] ?? []);
                $allAssetsWithHosts = array_merge($allAssetsWithHosts, $processedAssets);
            } catch (\Exception $e) {
                Log::error('Error fetching assets and hosts for group ' . $idsAssetGroup . ': ' . $e->getMessage());
            }
        }

        return $allAssetsWithHosts;
    }




    private function processAssetsWithHosts(array $data)
    {
        $assetsWithHosts = [];

        // Get asset name, defaulting to 'Unknown Asset' if not set
        $assetName = $data['name'] ?? 'Unknown Asset';
        $assetId = $data['id'] ?? 'Unknown Asset';

        // Check if 'typeFields' and 'definedIPs' exist and get the IP list
        $ipList = isset($data['typeFields']['definedIPs']) ? $data['typeFields']['definedIPs'] : '';
        // Process the IP list (assuming you have a method for expanding IP ranges, such as 'expandIpList')
        $ipAddresses = $this->expandIpList($ipList);

        // Store asset name with expanded IP list
        $assetsWithHosts[] = [
            'id' => $assetId,
            'assetName' => $assetName,
            'ipAddresses' => $ipAddresses,
        ];

        return $assetsWithHosts;
    }

    private function expandIpList($ipList)
    {
        $ipRanges = explode(',', $ipList);
        $allIPs = [];

        foreach ($ipRanges as $range) {
            // Check if the range is CIDR notation
            if (strpos($range, '/') !== false) {
                // Handle CIDR range
                $allIPs = array_merge($allIPs, $this->expandCIDR($range));
            } elseif (strpos($range, '-') !== false) {
                // Handle IP range
                [$startIP, $endIP] = explode('-', $range);
                $allIPs = array_merge($allIPs, $this->generateIPRange(trim($startIP), trim($endIP)));
            } else {
                // Single IP
                $allIPs[] = trim($range);
            }
        }

        return $allIPs;
    }

    private function expandCIDR($cidr)
    {
        [$baseIP, $netmask] = explode('/', $cidr);
        $ipLong = ip2long($baseIP);
        $numOfIPs = pow(2, (32 - (int)$netmask));
        $ipRange = [];

        for ($i = 0; $i < $numOfIPs; $i++) {
            $ipRange[] = long2ip($ipLong + $i);
        }

        return $ipRange;
    }

    private function generateIPRange($startIP, $endIP)
    {
        $startLong = ip2long($startIP);
        $endLong = ip2long($endIP);
        $ipRange = [];

        // Generate all IPs in the range
        for ($ip = $startLong; $ip <= $endLong; $ip++) {
            $ipRange[] = long2ip($ip);
        }

        return $ipRange;
    }

    public function HandelNotification()
    {
        // dd($event);

        // Get the action ID for Risk_Add
        $action1 = Action::where('name', 'FinishTenableAssetGroup')->first();
        $actionId1 = $action1['id'];

        // Get the vuln 
        $tenable = [];
        $roles = [];

        //defining the link we want user to be redirected to after clicking the system notification
        $link = ['link' => route('admin.asset_management.asset_group.index')];
        $actionId2 = null;
        $nextDateNotify = null;
        $modelId = null;
        $modelType = null;
        $proccess = null;
        // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
        $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $tenable, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}
