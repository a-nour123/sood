<?php

namespace App\Services;

use App\Http\Traits\NotificationHandlingTrait;
use App\Jobs\TenableImportAssetsGroup;
use App\Jobs\TenableImportAssetsRegion;
use App\Models\Action;
use App\Models\Asset;
use GuzzleHttp\Client;
use App\Models\TenableAuth;
use Illuminate\Support\Facades\Log;

class TenableServiceAssetsRegions
{
    use NotificationHandlingTrait;

    protected $accessKey;
    protected $secretKey;
    protected $api_url;
    protected $endSize;

    public function __construct()
    {
        try {
            $this->fetchApiKeys();
            $this->endSize = 500; // Define the number of assets to fetch in one request
        } catch (\Exception $e) {
            Log::error('Error in constructor: ' . $e->getMessage());
        }
    }

    private function fetchOffset()
    {
        try {
            return TenableAuth::first();
        } catch (\Exception $e) {
            Log::error('Error fetching offset: ' . $e->getMessage());
            return null;
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
            } else {
                throw new \Exception('TenableAuth not found.');
            }
        } catch (\Exception $e) {
            Log::error('Error fetching API keys: ' . $e->getMessage());
        }
    }

    public function syncHostsWithRegions()
    {
        try {
            $client = new Client();
            // Fetch assets and hosts
            $assetsWithHosts = $this->fetchAssetsAndHosts($client);

            if ($assetsWithHosts) {
                foreach ($assetsWithHosts as $assetsWithHost) {
                    // Chunk the IP addresses into groups of 500
                    $ipChunks = array_chunk($assetsWithHost['ipAddresses'], 500);
                    foreach ($ipChunks as $ipChunk) {
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
                        dispatch(new TenableImportAssetsRegion($chunkedAssetsWithHost))
                            ->delay(now()->addSeconds(10));
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Error syncing assets with hosts: ' . $e->getMessage());
        }
    }

    private function fetchAssetsAndHosts(Client $client)
    {

        try {

            $assetsData = $client->request('GET', $this->api_url . '/zone', [
                'headers' => [
                    'Accept' => 'application/json',
                    'x-apikey' => 'accesskey=' . $this->accessKey . ';secretkey=' . $this->secretKey,
                ],
                'json' => [
                    'query' => [
                        // 'name' => '',
                        // 'startOffset' => 0,
                        // 'endOffset' => 1,
                        // 'filters' => []
                    ],
                ],
                'verify' => false
            ]);
            $assetsData = json_decode($assetsData->getBody(), true);
            return $this->processAssetsWithHosts($assetsData['response'] ?? []);
        } catch (\Exception $e) {
            Log::error('Error fetching assets and hosts: ' . $e->getMessage());
            return [];
        }
    }




    private function processAssetsWithHosts(array $data)
    {
        $assetsWithHosts = [];

        foreach ($data as $asset) {
            $assetName = $asset['name'] ?? 'Unknown Asset';
            $assetId = $asset['id'] ?? 'Unknown Asset';
            $ipList = $asset['ipList'] ?? '';

            // Process the IP list
            $ipAddresses = $this->expandIpList($ipList);

            // Store asset name with expanded IP list
            $assetsWithHosts[] = [
                'id' => $assetId,
                'assetName' => $assetName,
                'ipAddresses' => $ipAddresses
            ];
        }

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
        $action1 = Action::where('name', 'FinishTenableAssetRegion')->first();
        $actionId1 = $action1['id'];

        // Get the vuln 
        $tenable = [];
        $roles = [];

        //defining the link we want user to be redirected to after clicking the system notification
        $link = ['link' => route('admin.vulnerability_management.index')];
        $actionId2 = null;
        $nextDateNotify = null;
        $modelId = null;
        $modelType = null;
        $proccess = null;
        // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
        $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $tenable, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}
