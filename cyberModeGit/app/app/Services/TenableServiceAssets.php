<?php

namespace App\Services;

use App\Jobs\TenableImportAssetsGroup;
use GuzzleHttp\Client;
use App\Models\TenableAuth;
use Illuminate\Support\Facades\Log;

class TenableServiceAssets
{
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

    public function syncAssetsWithHosts()
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
                        $chunkedAssetsWithHost = [
                            'assetName' => $assetsWithHost['assetName'],
                            'ipAddresses' => $ipChunk
                        ];
                        dispatch(new TenableImportAssetsGroup($chunkedAssetsWithHost))
                            ->delay(now()->addMinutes(1));
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
            $assetsData=json_decode($assetsData->getBody(), true);
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
            $ipList = $asset['ipList'] ?? '';

            // Process the IP list
            $ipAddresses = $this->expandIpList($ipList);

            // Store asset name with expanded IP list
            $assetsWithHosts[] = [
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
}
