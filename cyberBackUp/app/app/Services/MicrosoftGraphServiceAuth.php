<?php
namespace App\Services;

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use League\OAuth2\Client\Provider\GenericProvider;
use App\Models\MicrosoftConfig;
use App\Models\MicrosoftConfiguration;
use App\Models\User;

class MicrosoftGraphServiceAuth
{
    protected $provider;
    protected $graph;
    protected $config;

    public function __construct()
    {
        $this->config = MicrosoftConfiguration::first();

        if (!$this->config) {
            throw new \RuntimeException('Microsoft Graph configuration not found in database');
        }

        $this->provider = new GenericProvider([
            'clientId'                => $this->config->client_id,
            'clientSecret'            => $this->config->client_secret,
            'redirectUri'             => $this->config->redirect_uri,
            'urlAuthorize'             => 'https://login.microsoftonline.com/' . $this->config->tenant_id . '/oauth2/v2.0/authorize',
            'urlAccessToken'          => 'https://login.microsoftonline.com/' . $this->config->tenant_id . '/oauth2/v2.0/token',
            'urlResourceOwnerDetails'  => '',
            'scopes'                  => $this->config->scopes,
        ]);

        $this->graph = new Graph();
    }

      public function getAuthUrl()
    {
        return $this->provider->getAuthorizationUrl();
    }

    public function getAccessToken($code)
    {
        return $this->provider->getAccessToken('authorization_code', [
            'code' => $code
        ]);
    }

    public function getUser($accessToken)
    {
        $this->graph->setAccessToken($accessToken);

        $user = $this->graph->createRequest('GET', '/me')
            ->setReturnType(User::class)
            ->execute();

        return $user;
    }

}
