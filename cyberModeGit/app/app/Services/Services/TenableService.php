<?php

namespace App\Services;

use App\Jobs\TenableImport;
use App\Jobs\TenableImportInfoVuln;
use GuzzleHttp\Client;
use App\Models\TenableAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class TenableService
{
    protected $accessKey;
    protected $secretKey;
    protected $apiUrl;
    protected $typeSource;
    protected $offset;
    protected $end;
    protected $total;
    protected $tenTotal;
    protected $totalRecord;
    protected $severity;
    protected $endSize;

    public function __construct()
    {
        try {
            $this->fetchApiKeys();
            $this->endSize = 500;
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
                $this->apiUrl = $tenableAuth->api_url;
                $this->typeSource = $tenableAuth->type_source;
                $this->offset = $tenableAuth->offset;
                $this->end = $tenableAuth->end;
                $this->total = $tenableAuth->total;
                $this->severity = $tenableAuth->severity;
            } else {
                $this->accessKey = '';
                $this->secretKey = '';
                $this->apiUrl = '';
                $this->typeSource = '';
                $this->offset = '';
                $this->end = '';
                $this->total = '';
                $this->severity = '';
            }
        } catch (\Exception $e) {
            Log::error('Error fetching API keys: ' . $e->getMessage());
        }
    }

    public function syncHostsAndVulnerabilities()
    {
        try {
            $offset = $this->fetchOffset();
            $start = $offset ? $offset->offset : 0;
            $end = $offset ? $offset->end : 500;
            $total = $offset ? $offset->total : null;
            if ($total == 1) {
                $client = new Client();
                $total = $this->fetchTotalRecords($client);
            }
            $hostsAndVulnerabilities = $this->getHostsAndVulnerabilities(500);

            if ($hostsAndVulnerabilities && $this->severity !== "INFO") {
                // dispatch(new TenableImport($hostsAndVulnerabilities, $this->typeSource, $start, $end, $total)->delay(now()->addMinutes(2));
                dispatch(new TenableImport($hostsAndVulnerabilities, $this->typeSource, $start, $end, $total))->delay(now()->addMinutes(1));
            } else {
                dispatch(new TenableImportInfoVuln($hostsAndVulnerabilities, $this->typeSource, $start, $end, $total))->delay(now()->addMinutes(1));
            }
        } catch (\Exception $e) {
            Log::error('Error syncing hosts and vulnerabilities: ' . $e->getMessage());
        }
    }

    public function getHostsAndVulnerabilities()
    {
        try {
            $client = new Client();
            $auth = $this->fetchOffset();
            $start = $auth ? $auth->offset : 0;
            $end = $auth ? $auth->end : 500;
            return $this->fetchHostsAndVulnerabilities($client, $start, $end);
        } catch (\Exception $e) {
            Log::error('Error getting hosts and vulnerabilities: ' . $e->getMessage());
            return [];
        }
    }

    private function fetchTotalRecords($client)
    {
        try {
            $severityOperator = ($this->severity == 'INFO') ? '=' : '!=';

            $response = $client->request('POST', $this->apiUrl . '/analysis', [
                'headers' => [
                    'Accept' => 'application/json',
                    'x-apikey' => 'accesskey=' . $this->accessKey . ';secretkey=' . $this->secretKey,
                ],
                'json' => [
                    'query' => [
                        'name' => '',
                        'description' => '',
                        'context' => '',
                        'createdTime' => 0,
                        'modifiedTime' => 0,
                        'groups' => [],
                        'type' => 'vuln',
                        'tool' => 'vulndetails', // or 'listvuln' depending on the sourceType
                        'sourceType' => $this->typeSource, // Pass the value from $tenableAuth->type_Sourc
                        'startOffset' => 0,
                        'endOffset' => 1,
                        'filters' => [
                            'filterName' => 'severity',
                            'operator' => $severityOperator, // Use the operator based on the severity
                            'value' => '0',
                        ]
                    ],
                    'sourceType' => $this->typeSource, // or 'patched' depending on the sourceType
                    'sortField' => 'severity',
                    'sortDir' => 'desc',
                    'columns' => [],
                    'type' => 'vuln'
                ],
                'verify' => false
            ]);

            $data = json_decode($response->getBody(), true);
dd($data);
            return $data['response']['totalRecords'] ?? 0;
        } catch (\Exception $e) {
dd($e);
            Log::error('Error fetching total records: ' . $e->getMessage());
            return 0;
        }
    }

    private function fetchHostsAndVulnerabilities($client, $start, $end)
    {
        try {
            $vulnerabilityData = $this->fetchVulnerabilities($client, $start, $end);
            $hostData = $this->fetchHosts($client);
            $indexedHosts = [];
            foreach ($hostData['response'] as $host) {
                $indexedHosts[$host['ipAddress']] = $host;
            }

            $hostsAndVulnerabilities = [];
            foreach ($vulnerabilityData['response']['results'] as $vuln) {
                $hostItem = $indexedHosts[$vuln['ip']] ?? null;
                $hostsAndVulnerabilities[] = [
                    'host' => $hostItem,
                    'vulnerabilities' => [$vuln]
                ];
            }

	    print_r($vulnerabilityData);
dd($hostsAndVulnerabilites);            
return $hostsAndVulnerabilities;
        } catch (\Exception $e) {
            Log::error('Error fetching hosts and vulnerabilities: ' . $e->getMessage());
            return [];
        }
    }

    private function fetchVulnerabilities($client, $start, $end)
    {
        try {
            $severityOperator = ($this->severity == 'INFO') ? '=' : '!=';

            $response = $client->request('POST', $this->apiUrl . '/analysis', [
                'headers' => [
                    'Accept' => 'application/json',
                    'x-apikey' => 'accesskey=' . $this->accessKey . ';secretkey=' . $this->secretKey,
                ],
                'json' => [
                    'query' => [
                        'name' => '',
                        'description' => '',
                        'context' => '',
                        'createdTime' => 0,
                        'modifiedTime' => 0,
                        'groups' => [],
                        'type' => 'vuln',
                        'tool' => 'vulndetails', // or 'listvuln' depending on the sourceType
                        'sourceType' => $this->typeSource, // Pass the value from $tenableAuth->type_Sourc
                        'startOffset' => $start,
                        'endOffset' => $end,
                        'filters' => [
                            'filters' => [
                                'filterName' => 'severity',
                                'operator' => $severityOperator, // Use the operator based on the severity
                                'value' => '0',
                            ]
                        ]
                    ],
                    'sourceType' => $this->typeSource, // or 'patched' depending on the sourceType
                    'sortField' => 'severity',
                    'sortDir' => 'desc',
                    'columns' => [],
                    'type' => 'vuln'
                ],
                'verify' => false
            ]);



            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            Log::error('Error fetching vulnerabilities: ' . $e->getMessage());
            return [];
        }
    }

    private function fetchHosts($client)
    {
        try {

            $response = $client->request('POST', $this->apiUrl . '/hosts/search', [
                'headers' => [
                    'Accept' => 'application/json',
                    'x-apikey' => 'accesskey=' . $this->accessKey . ';secretkey=' . $this->secretKey,
                ],
                'filters' => [
                    'and' => [
                        'property' => '',
                        'operator' => 'eq',
                        'value' => ''
                    ]
                ],
                'verify' => false
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            Log::error('Error fetching hosts: ' . $e->getMessage());
            return [];
        }
    }
}
