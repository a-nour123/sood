<?php

namespace App\Services;

use App\Jobs\TenableImport;
use GuzzleHttp\Client;
use App\Models\Asset;
use App\Models\Vulnerability;
use App\Models\TenableAuth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use File;

class TenableService
{
    protected $accessKey;
    protected $secretKey;
    protected $apiUrl;
    protected $typeSource;
    protected $offset;
    protected $totalRecord;
    protected $endSize;
    protected $end;
    protected $total;

    public function __construct()
    {
        // Fetch API keys from the database
        $this->fetchApiKeys();
        $this->endSize = 500;
    }

    private function fetchOffset()
    {
        $tenableAuth = TenableAuth::first();
        if ($tenableAuth) {
            return $tenableAuth;
        } else {
            return null;
        }
    }

    private function fetchApiKeys()
    {
        // Fetch API keys from the database (assuming you have a model named TenableAuth)
        $tenableAuth = TenableAuth::first();

        if ($tenableAuth) {
            // If API keys are found in the database, assign them
            $this->accessKey = base64_decode($tenableAuth->access_key);
            $this->secretKey = base64_decode($tenableAuth->secret_key);
            $this->apiUrl = $tenableAuth->api_url;
            $this->typeSource = $tenableAuth->type_source;
            $this->offset = $tenableAuth->offset;
            $this->end = $tenableAuth->end;
            $this->total = $tenableAuth->total;
        } else {
            $this->accessKey = '';
            $this->secretKey = '';
            $this->apiUrl = '';
            $this->typeSource = '';
            $this->offset = '';
            $this->end = '';
            $this->total = '';
        }
    }

    public function syncHostsAndVulnerabilities()
    {
        $offset = $this->fetchOffset();
        $start = ($offset) ? $offset->offset : 0;
        $end = ($offset) ? $offset->end : 500;
        $hostsAndVulnerabilities = $this->getHostsAndVulnerabilities(500);
        // dump(count($hostsAndVulnerabilities));
        $chunkSize = 500;
        $total=$this->totalRecord;
        $hostsAndVulnerabilitiesChunks = $this->getHostsAndVulnerabilitiesChunks($hostsAndVulnerabilities, $chunkSize);
        // dd($hostsAndVulnerabilitiesChunks);//1000
        if ($hostsAndVulnerabilitiesChunks->isNotEmpty()) {
            foreach ($hostsAndVulnerabilitiesChunks as $chunk) {//1000
                // Otherwise, dispatch the job
                // dump($chunk);
                dispatch(new TenableImport($chunk, $this->typeSource, $start, $end,$total));
            }
        }
    }

    private function getHostsAndVulnerabilitiesChunks($hostsAndVulnerabilities, $chunkSize)
    {
        return collect($hostsAndVulnerabilities)->chunk($chunkSize);
    }


    // public function getHostsAndVulnerabilities($count)
    // {
    //     $hostsAndVulnerabilities = [];
    //     for ($i = 0; $i < $count; $i++) {
    //         $hostData = [
    //             'name' => 'Host' .  rand(0, 1),
    //             'ipAddress' => '192.168.0.' .  rand(0, 999)
    //         ];

    //         $vuln = [
    //             'pluginID' => rand(1000, 9999),
    //             'pluginName' => 'Vuln' . ($this->offset + $i),
    //             'cve' => 'CVE-' . rand(2000, 2024) . '-' . rand(1000, 9999),
    //             'description' => 'Description for Vuln' . ($this->offset + $i),
    //             'severity' => ['name' => ['Low', 'Medium', 'High', 'Critical'][rand(0, 3)]],
    //             'solution' => 'Solution for Vuln' . ($this->offset + $i),
    //             'pluginInfo' => 'Plugin Info for Vuln' . ($this->offset + $i),
    //             'firstSeen' => time() - rand(0, 1000000),
    //             'lastSeen' => time() - rand(0, 100000),
    //             'pluginPubDate' => time() - rand(0, 100000),
    //             'pluginModDate' => time() - rand(0, 50000),
    //             'ip' => '192.168.0.' . (($this->offset + $i) % 256),
    //             'netbiosName' => 'NetBIOS' . ($this->offset + $i),
    //             'dnsName' => 'dns' . ($this->offset + $i) . '.example.com',
    //             'protocol' => 'TCP',
    //             'port' => rand(1, 65535),
    //             'exploitAvailable' => rand(0, 1) == 1,
    //             'synopsis' => 'Synopsis for Vuln' . ($this->offset + $i),
    //         ];

    //         $hostsAndVulnerabilities[] = [
    //             'host' => $hostData,
    //             'vulnerabilities' => [$vuln] // Wrap the vulnerability in an array to maintain consistency
    //         ];
    //     }

    //     return $hostsAndVulnerabilities;
    // }


    // public function getHostsAndVulnerabilities()
    // {
    //     $client = new Client();
    //     $auth = $this->fetchOffset();
    //     $start = ($auth) ? $auth->offset : 0;
    //     $end = ($auth) ? $auth->end : 499;

    //     // $responseForTotal = $client->request('POST', $this->apiUrl . '/analysis', [
    //     //     'headers' => [
    //     //         'Accept' => 'application/json',
    //     //         'x-apikey' => 'accesskey=' . $this->accessKey . ';secretkey=' . $this->secretKey,
    //     //     ],
    //     //     'json' => [
    //     //         'query' => [
    //     //             'name' => '',
    //     //             'description' => '',
    //     //             'context' => '',
    //     //             'createdTime' => 0,
    //     //             'modifiedTime' => 0,
    //     //             'groups' => [],
    //     //             'type' => 'vuln',
    //     //             'tool' => 'vulndetails', // or 'listvuln' depending on the sourceType
    //     //             'sourceType' => $this->typeSource, // Pass the value from $tenableAuth->type_Sourc
    //     //             'startOffset' => 0,
    //     //             'endOffset' => 1,
    //     //             'filters' => []
    //     //         ],
    //     //         'sourceType' => $this->typeSource, // or 'patched' depending on the sourceType
    //     //         'sortField' => 'severity',
    //     //         'sortDir' => 'desc',
    //     //         'columns' => [],
    //     //         'type' => 'vuln'
    //     //     ],
    //     //     'verify' => false
    //     // ]);

    //     // $responseForTotalData = json_decode($responseForTotal->getBody(), true);

    //     // $this->totalRecord =  $responseForTotalData['response']['totalRecords'];

    //     $responseForTotal = [
    //         "response" =>  [
    //             "totalRecords" => "1500",
    //             "returnedRecords" => 1,
    //             "startOffset" => "0",
    //             "endOffset" => "1",
    //             "matchingDataElementCount" => "-1",
    //             "results" =>
    //             [
    //                 "pluginID" => "19948",
    //                 "severity" =>  [
    //                     "name" => "Critical",
    //                 ],
    //                 "ip" => "10.10.206.7",
    //                 "port" => "6000",
    //                 "protocol" => "TCP",
    //                 "pluginName" => "X11 Server Unauthenticated Access",
    //                 "firstSeen" => "1710690882",
    //                 "lastSeen" => "1710690882",
    //                 "exploitAvailable" => "Yes",
    //                 "exploitFrameworks" => "Metasploit (X11 No-Auth Scanner)",
    //                 "synopsis" => "The remote X11 server accepts connections from anywhere.",
    //                 "description" => "The remote X11 server accepts .",
    //                 "solution" => "Restrict access .",
    //                 "riskFactor" => "Critical",
    //                 "vulnPubDate" => "631195200",
    //                 "pluginPubDate" => "1128945600",
    //                 "pluginModDate" => "1608638400",
    //                 "cve" => "CVE-1999-0526",
    //                 "ips" => "10.10.206.7",
    //                 "pluginInfo" => "19948 (6000/6) X11 Server Unauthenticated Access",
    //             ],
    //         ],
    //     ];

    //     $this->totalRecord =  $responseForTotal['response']['totalRecords'];

    //     if ($this->totalRecord >= $start) {
    //          try {
    //             if ($end > $this->totalRecord){
    //                 $end=$this->totalRecord;
    //             }
    //             // // Make a request to fetch vulnerabilities
    //             // $vulnerabilityResponse = $client->request('POST', $this->apiUrl . '/analysis', [
    //             //     'headers' => [
    //             //         'Accept' => 'application/json',
    //             //         'x-apikey' => 'accesskey=' . $this->accessKey . ';secretkey=' . $this->secretKey,
    //             //     ],
    //             //     'json' => [
    //             //         'query' => [
    //             //             'name' => '',
    //             //             'description' => '',
    //             //             'context' => '',
    //             //             'createdTime' => 0,
    //             //             'modifiedTime' => 0,
    //             //             'groups' => [],
    //             //             'type' => 'vuln',
    //             //             'tool' => 'vulndetails', // or 'listvuln' depending on the sourceType
    //             //             'sourceType' => $this->typeSource, // Pass the value from $tenableAuth->type_Sourc
    //             //             'startOffset' => $start,
    //             //             'endOffset' => $end,
    //             //             'filters' => []
    //             //         ],
    //             //         'sourceType' => $this->typeSource, // or 'patched' depending on the sourceType
    //             //         'sortField' => 'severity',
    //             //         'sortDir' => 'desc',
    //             //         'columns' => [],
    //             //         'type' => 'vuln'
    //             //     ],
    //             //     'verify' => false
    //             // ]);


    //             // // Decode the response for vulnerabilities
    //             // $vulnerabilityData = json_decode($vulnerabilityResponse->getBody(), true);

    //             $vulnerabilityResponse = [
    //                 "response" =>  [
    //                     "totalRecords" => "500",
    //                     "returnedRecords" => 1,
    //                     "startOffset" => "0",
    //                     "endOffset" => "1",
    //                     "matchingDataElementCount" => "-1",
    //                     "results" =>  [
    //                         [
    //                             "pluginID" => "19948",
    //                             "severity" =>  [
    //                                 "name" => "Critical",
    //                             ],
    //                             "ip" => "10.10.206.7",
    //                             "port" => "6000",
    //                             "protocol" => "TCP",
    //                             "pluginName" => "X11 Server Unauthenticated Access",
    //                             "firstSeen" => "1710690882",
    //                             "lastSeen" => "1710690882",
    //                             "exploitAvailable" => "Yes",
    //                             "exploitFrameworks" => "Metasploit (X11 No-Auth Scanner)",
    //                             "synopsis" => "The remote X11 server accepts connections from anywhere.",
    //                             "description" => "The remote X11 server accepts .",
    //                             "solution" => "Restrict access .",
    //                             "riskFactor" => "Critical",
    //                             "vulnPubDate" => "631195200",
    //                             "pluginPubDate" => "1128945600",
    //                             "pluginModDate" => "1608638400",
    //                             "cve" => "CVE-1999-0526",
    //                             "ips" => "10.10.206.7",
    //                             "pluginInfo" => "19948 (6000/6) X11 Server Unauthenticated Access",
    //                         ],
    //                         [
    //                             "pluginID" => "19948",
    //                             "severity" =>  [
    //                                 "name" => "Critical",
    //                             ],
    //                             "ip" => "10.10.206.8",
    //                             "port" => "6000",
    //                             "protocol" => "TCP",
    //                             "pluginName" => "X11 Server Unauthenticated Access",
    //                             "firstSeen" => "1710690882",
    //                             "lastSeen" => "1710690882",
    //                             "exploitAvailable" => "Yes",
    //                             "exploitFrameworks" => "Metasploit (X11 No-Auth Scanner)",
    //                             "synopsis" => "The remote X11 server accepts connections from anywhere.",
    //                             "description" => "The remote X11 server accepts .",
    //                             "solution" => "Restrict access .",
    //                             "riskFactor" => "Critical",
    //                             "vulnPubDate" => "631195200",
    //                             "pluginPubDate" => "1128945600",
    //                             "pluginModDate" => "1608638400",
    //                             "cve" => "CVE-1999-0526",
    //                             "ips" => "10.10.206.7",
    //                             "pluginInfo" => "19948 (6000/6) X11 Server Unauthenticated Access",
    //                         ],
    //                         [
    //                             "pluginID" => "19948",
    //                             "severity" =>  [
    //                                 "name" => "Critical",
    //                             ],
    //                             "ip" => "10.10.206.9",
    //                             "port" => "6000",
    //                             "protocol" => "TCP",
    //                             "pluginName" => "X11 Server Unauthenticated Access",
    //                             "firstSeen" => "1710690882",
    //                             "lastSeen" => "1710690882",
    //                             "exploitAvailable" => "Yes",
    //                             "exploitFrameworks" => "Metasploit (X11 No-Auth Scanner)",
    //                             "synopsis" => "The remote X11 server accepts connections from anywhere.",
    //                             "description" => "The remote X11 server accepts .",
    //                             "solution" => "Restrict access .",
    //                             "riskFactor" => "Critical",
    //                             "vulnPubDate" => "631195200",
    //                             "pluginPubDate" => "1128945600",
    //                             "pluginModDate" => "1608638400",
    //                             "cve" => "CVE-1999-0526",
    //                             "ips" => "10.10.206.7",
    //                             "pluginInfo" => "19948 (6000/6) X11 Server Unauthenticated Access",
    //                         ],
    //                         [
    //                             "pluginID" => "19949",
    //                             "severity" =>  [
    //                                 "name" => "Critical",
    //                             ],
    //                             "ip" => "10.10.206.7",
    //                             "port" => "6000",
    //                             "protocol" => "TCP",
    //                             "pluginName" => "X11 Server Unauthenticated Access",
    //                             "firstSeen" => "1710690882",
    //                             "lastSeen" => "1710690882",
    //                             "exploitAvailable" => "Yes",
    //                             "exploitFrameworks" => "Metasploit (X11 No-Auth Scanner)",
    //                             "synopsis" => "The remote X11 server accepts connections from anywhere.",
    //                             "description" => "The remote X11 server accepts .",
    //                             "solution" => "Restrict access .",
    //                             "riskFactor" => "Critical",
    //                             "vulnPubDate" => "631195200",
    //                             "pluginPubDate" => "1128945600",
    //                             "pluginModDate" => "1608638400",
    //                             "cve" => "CVE-1999-0526",
    //                             "ips" => "10.10.206.7",
    //                             "pluginInfo" => "19948 (6000/6) X11 Server Unauthenticated Access",
    //                         ],
    //                         [
    //                             "pluginID" => "19949",
    //                             "severity" =>  [
    //                                 "name" => "Critical",
    //                             ],
    //                             "ip" => "10.10.206.8",
    //                             "port" => "6000",
    //                             "protocol" => "TCP",
    //                             "pluginName" => "X11 Server Unauthenticated Access",
    //                             "firstSeen" => "1710690882",
    //                             "lastSeen" => "1710690882",
    //                             "exploitAvailable" => "Yes",
    //                             "exploitFrameworks" => "Metasploit (X11 No-Auth Scanner)",
    //                             "synopsis" => "The remote X11 server accepts connections from anywhere.",
    //                             "description" => "The remote X11 server accepts .",
    //                             "solution" => "Restrict access .",
    //                             "riskFactor" => "Critical",
    //                             "vulnPubDate" => "631195200",
    //                             "pluginPubDate" => "1128945600",
    //                             "pluginModDate" => "1608638400",
    //                             "cve" => "CVE-1999-0526",
    //                             "ips" => "10.10.206.7",
    //                             "pluginInfo" => "19948 (6000/6) X11 Server Unauthenticated Access",
    //                         ],
    //                         [
    //                             "pluginID" => "19950",
    //                             "severity" =>  [
    //                                 "name" => "Critical",
    //                             ],
    //                             "ip" => "10.10.206.7",
    //                             "port" => "6000",
    //                             "protocol" => "TCP",
    //                             "pluginName" => "X11 Server Unauthenticated Access",
    //                             "firstSeen" => "1710690882",
    //                             "lastSeen" => "1710690882",
    //                             "exploitAvailable" => "Yes",
    //                             "exploitFrameworks" => "Metasploit (X11 No-Auth Scanner)",
    //                             "synopsis" => "The remote X11 server accepts connections from anywhere.",
    //                             "description" => "The remote X11 server accepts .",
    //                             "solution" => "Restrict access .",
    //                             "riskFactor" => "Critical",
    //                             "vulnPubDate" => "631195200",
    //                             "pluginPubDate" => "1128945600",
    //                             "pluginModDate" => "1608638400",
    //                             "cve" => "CVE-1999-0526",
    //                             "ips" => "10.10.206.7",
    //                             "pluginInfo" => "19948 (6000/6) X11 Server Unauthenticated Access",
    //                         ],
    //                         [
    //                             "pluginID" => "19927",
    //                             "severity" =>  [
    //                                 "name" => "Critical",
    //                             ],
    //                             "ip" => "10.10.206.7",
    //                             "port" => "6000",
    //                             "protocol" => "TCP",
    //                             "pluginName" => "X11 Server Unauthenticated Access",
    //                             "firstSeen" => "1710690880",
    //                             "lastSeen" => "1710690882",
    //                             "exploitAvailable" => "Yes",
    //                             "exploitFrameworks" => "Metasploit (X11 No-Auth Scanner)",
    //                             "synopsis" => "The remote X11 server accepts connections from anywhere.",
    //                             "description" => "The remote X11 server accepts .",
    //                             "solution" => "Restrict access .",
    //                             "riskFactor" => "Critical",
    //                             "vulnPubDate" => "631195200",
    //                             "pluginPubDate" => "1128945600",
    //                             "pluginModDate" => "1608638400",
    //                             "cve" => "CVE-1999-0526",
    //                             "ips" => "10.10.206.7",
    //                             "pluginInfo" => "19948 (6000/6) X11 Server Unauthenticated Access",
    //                         ]
    //                       ]
    //                     ],
    //                 ];

    //             $vulnerabilityData = $vulnerabilityResponse;


    //                 // $hostResponse = $client->request('POST', $this->apiUrl . '/hosts/search', [
    //                 //     'headers' => [
    //                 //         'Accept' => 'application/json',
    //                 //         'x-apikey' => 'accesskey=' . $this->accessKey . ';secretkey=' . $this->secretKey,
    //                 //     ],
    //                 //     'filters'=>[
    //                 //         'and'=>[
    //                 //             'property' =>'',
    //                 //             'operator'=>'eq',
    //                 //             'value'=>''
    //                 //         ]
    //                 //     ],
    //                 //     'verify' => false
    //                 // ]);

    //                 // // Decode the response for host
    //                 // $hostData = json_decode($hostResponse->getBody(), true);


    //                 $hostResponse = [
    //                     "type" => "regular",
    //                     "response" => [
    //                         [
    //                             "id" => "1136417",
    //                             "uuid" => "58b4c347-28fd-4084-bfea-c6e06bdbd893",
    //                             "tenableUUID" => "147dc370-e8a3-4b57-a915-809bb82ddf41",
    //                             "name" => "MDM-DS-01",
    //                             "ipAddress" => "10.10.206.8",
    //                             "os" => "Microsoft Windows Server 2016 Standard Build 14393",
    //                             "firstSeen" => "1656250085",
    //                             "lastSeen" => "1687316410",
    //                         ],
    //                         [
    //                             "id" => "1136418",
    //                             "uuid" => "58b4c347-28fd-4084-bfea-c6e06bdbd893",
    //                             "tenableUUID" => "147dc370-e8a3-4b57-a915-809bb82ddf41",
    //                             "name" => "MDM-DS-01",
    //                             "ipAddress" => "10.10.206.7",
    //                             "os" => "Microsoft Windows Server 2016 Standard Build 14393",
    //                             "firstSeen" => "1656250085",
    //                             "lastSeen" => "1687316410",
    //                         ],
    //                         [
    //                             "id" => "1136419",
    //                             "uuid" => "58b4c347-28fd-4084-bfea-c6e06bdbd893",
    //                             "tenableUUID" => "147dc370-e8a3-4b57-a915-809bb82ddf41",
    //                             "name" => "MDM-DS-03",
    //                             "ipAddress" => "10.10.206.3",
    //                             "os" => "Microsoft Windows Server 2016 Standard Build 14393",
    //                             "firstSeen" => "1656250085",
    //                             "lastSeen" => "1687316410",
    //                         ], [
    //                             "id" => "1136420",
    //                             "uuid" => "58b4c347-28fd-4084-bfea-c6e06bdbd893",
    //                             "tenableUUID" => "147dc370-e8a3-4b57-a915-809bb82ddf41",
    //                             "name" => "MDM-DS-04",
    //                             "ipAddress" => "10.10.206.9",
    //                             "os" => "Microsoft Windows Server 2016 Standard Build 14393",
    //                             "firstSeen" => "1656250085",
    //                             "lastSeen" => "1687316410",
    //                         ], [
    //                             "id" => "1136421",
    //                             "uuid" => "58b4c347-28fd-4084-bfea-c6e06bdbd893",
    //                             "tenableUUID" => "147dc370-e8a3-4b57-a915-809bb82ddf41",
    //                             "name" => "MDM-DS-05",
    //                             "ipAddress" => "10.10.206.10",
    //                             "os" => "Microsoft Windows Server 2016 Standard Build 14393",
    //                             "firstSeen" => "1656250085",
    //                             "lastSeen" => "1687316410",
    //                         ]
    //                     ]
    //                 ];
    //                 // Decode the response for host
    //                 // $hostData = json_decode($hostResponse->getBody(), true);
    //                 $hostData = $hostResponse;


    //                 $indexedHosts = [];
    //                 foreach ($hostData['response'] as $host) {
    //                     $indexedHosts[$host['ipAddress']] = $host;
    //                 }

    //                 // Initialize array to store hosts and their vulnerabilities
    //                 $hostsAndVulnerabilities = [];

    //                 // Iterate over vulnerabilities to fetch hosts
    //                 foreach ($vulnerabilityData['response']['results'] as $vuln) {

    //                     $hostItem = null;
    //                     if (isset($indexedHosts[$vuln['ip']])) {
    //                         $hostItem = $indexedHosts[$vuln['ip']];
    //                     }
    //                     $hostData = $hostItem;

    //                     $hostsAndVulnerabilities[] = [
    //                         'host' => $hostData,
    //                         'vulnerabilities' => [$vuln] // Wrap the vulnerability in an array to maintain consistency
    //                     ];
    //                 }
    //                 // dd($hostsAndVulnerabilities);

    //                 return $hostsAndVulnerabilities;


    //         } catch (\Exception $e) {
    //             // Log or handle the exception
    //             dd($e);
    //             return [];
    //         }
    //     } else {
    //         return [];
    //     }
    // }


    public function getHostsAndVulnerabilities($count)
{
    $hostsAndVulnerabilities = [];
    for ($i = 0; $i < $count; $i++) {
        $hostData = [
            'name' => 'Host' . ($this->offset + $i),
            'ipAddress' => '192.168.0.' . (($this->offset + $i) % 256)
        ];

        $vuln = [
            'pluginID' => rand(1000, 9999),
            'pluginName' => 'Vuln' . ($this->offset + $i),
            'cve' => 'CVE-' . rand(2000, 2024) . '-' . rand(1000, 9999),
            'description' => 'Description for Vuln' . ($this->offset + $i),
            'severity' => ['name' => ['Low', 'Medium', 'High', 'Critical'][rand(0, 3)]],
            'solution' => 'Solution for Vuln' . ($this->offset + $i),
            'pluginInfo' => 'Plugin Info for Vuln' . ($this->offset + $i),
            'firstSeen' => time() - rand(0, 1000000),
            'lastSeen' => time() - rand(0, 100000),
            'pluginPubDate' => time() - rand(0, 100000),
            'pluginModDate' => time() - rand(0, 50000),
            'ip' => '192.168.0.' . (($this->offset + $i) % 256),
            'netbiosName' => 'NetBIOS' . ($this->offset + $i),
            'dnsName' => 'dns' . ($this->offset + $i) . '.example.com',
            'protocol' => 'TCP',
            'port' => rand(1, 65535),
            'exploitAvailable' => rand(0, 1) == 1,
            'synopsis' => 'Synopsis for Vuln' . ($this->offset + $i),
        ];

        $hostsAndVulnerabilities[] = [
            'host' => $hostData,
            'vulnerabilities' => [$vuln] // Wrap the vulnerability in an array to maintain consistency
        ];
    }

    return $hostsAndVulnerabilities;
}

}
