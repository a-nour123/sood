<?php
// app/Services/MicrosoftGraphService.php

namespace App\Services;

use App\Jobs\ImportMicrosoftUsers;
use App\Models\MicrosoftConfiguration;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class MicrosoftGraphService
{
    protected $client;
    protected $baseUrl = 'https://graph.microsoft.com/v1.0';

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 30,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]
        ]);
    }

    public function getAccessToken()
    {
        $cacheKey = 'microsoft_graph_token';

           $config = MicrosoftConfiguration::first();
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }
        $tokenUrl = 'https://login.microsoftonline.com/'.$config['tenant_id'].'/oauth2/v2.0/token';


        try {
            $response = $this->client->post(
                str_replace('{tenant_id}', config('services.microsoft.tenant_id'), $tokenUrl),
                [
                    'form_params' => [
                        'client_id' =>  $config['client_id'],
                        'client_secret' => $config['client_secret'],
                        'scope' => 'https://graph.microsoft.com/.default',
                        'grant_type' => 'client_credentials'
                    ]
                ]
            );

            $data = json_decode($response->getBody()->getContents(), true);

            $token = $data['access_token'];

            Cache::put($cacheKey, $token, now()->addMinutes(55));

            return $token;

        } catch (RequestException $e) {
            dd($e);
            Log::error('Failed to get Microsoft Graph access token: ' . $e->getMessage());
            throw new \Exception('Unable to authenticate with Microsoft Graph API');
        }
    }

    public function getUsers($select = null, $filter = null, $top = 100)
    {

        $token = $this->getAccessToken();
        $defaultSelect = [
        'id',
        'businessPhones',
        'displayName',
        'givenName',
        'jobTitle',
        'mail',
        'mobilePhone',
        'officeLocation',
        'preferredLanguage',
        'surname',
        'userPrincipalName',
        'accountEnabled',
        'createdDateTime',
        'department',
        'employeeId',
        'employeeType',
        'identities',
        'mailNickname',
        'onPremisesDistinguishedName',
        'onPremisesDomainName',
        'onPremisesImmutableId',
        'onPremisesLastSyncDateTime',
        'onPremisesSecurityIdentifier',
        'onPremisesSamAccountName',
        'onPremisesSyncEnabled',
        'onPremisesUserPrincipalName',
        'otherMails',
        'passwordPolicies',
        'provisionedPlans',
        'proxyAddresses',
        'refreshTokensValidFromDateTime',
        'showInAddressList',
        'signInSessionsValidFromDateTime',
        'state',
        'streetAddress',
        'usageLocation',
        'userType'
        ];

        $queryParams = [];
        $select = $select ?: implode(',', $defaultSelect);
        $queryParams['$select'] = $select;
        if ($filter) {
            $queryParams['$filter'] = $filter;
        }
        if ($top) {
            $queryParams['$top'] = $top;
        }
        $url = $this->baseUrl . '/users';
        if (!empty($queryParams)) {
            $url .= '?' . http_build_query($queryParams);
        }

        try {
            $response = $this->client->get($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            return $data['value'] ?? [];

        } catch (RequestException $e) {
            Log::error('Failed to fetch users from Microsoft Graph: ' . $e->getMessage());
            throw new \Exception('Unable to fetch users from Microsoft Graph API');
        }
    }

   public function getAllUsers($select = null, $filter = null, $batchSize = 100)
    {
        $token = $this->getAccessToken();
        $allUsers = [];

        $defaultSelect = [
            'id',
            'businessPhones',
            'displayName',
            'givenName',
            'jobTitle',
            'mail',
            'mobilePhone',
            'officeLocation',
            'preferredLanguage',
            'surname',
            'userPrincipalName',
            'accountEnabled',
            'createdDateTime',
            'department',
            'employeeId',
            'employeeType',
            'identities',
            'mailNickname',
            'onPremisesDistinguishedName',
            'onPremisesDomainName',
            'onPremisesImmutableId',
            'onPremisesLastSyncDateTime',
            'onPremisesSecurityIdentifier',
            'onPremisesSamAccountName',
            'onPremisesSyncEnabled',
            'onPremisesUserPrincipalName',
            'otherMails',
            'passwordPolicies',
            'provisionedPlans',
            'proxyAddresses',
            'refreshTokensValidFromDateTime',
            'showInAddressList',
            'signInSessionsValidFromDateTime',
            'state',
            'streetAddress',
            'usageLocation',
            'userType'
        ];

        $queryParams = [];
        $select = $select ?: implode(',', $defaultSelect);
        $queryParams['$select'] = $select;
        $queryParams['$top'] = $batchSize; // Add batch size parameter

        if ($filter) {
            $queryParams['$filter'] = $filter;
        }

        $url = $this->baseUrl . '/users';
        if (!empty($queryParams)) {
            $url .= '?' . http_build_query($queryParams);
        }

        $batchCount = 0;

        do {
            try {
                $response = $this->client->get($url, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                    ]
                ]);

                $data = json_decode($response->getBody()->getContents(), true);
                $currentBatch = $data['value'] ?? [];

                // Dispatch a job for each batch of users
                if (!empty($currentBatch)) {
                    $batchCount++;
                    ImportMicrosoftUsers::dispatch($currentBatch, $batchCount)->delay(now()->addSeconds(10));
                    Log::info("Dispatched batch {$batchCount} with " . count($currentBatch) . " users");
                }

                $allUsers = array_merge($allUsers, $currentBatch);
                $url = $data['@odata.nextLink'] ?? null;

            } catch (RequestException $e) {
                Log::error('Failed to fetch users from Microsoft Graph: ' . $e->getMessage());
                break;
            }
        } while ($url);

        Log::info("Total users fetched: " . count($allUsers) . " in {$batchCount} batches");
        return $allUsers;
    }
}
