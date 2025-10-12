<?php

namespace App\Providers;

use App\Models\MicrosoftConfiguration;
use Illuminate\Support\ServiceProvider;
use App\Models\MsGraphConfig;

class MsGraphConfigServiceProvider extends ServiceProvider
{
    public function register()
    {
//        $this->app->singleton('msgraph-config', function () {
  //          return MicrosoftConfiguration::firstOrFail();
    //    });
    }

    public function boot()
    {
        // Override package config with database values
      //  $config = $this->app->make('msgraph-config');

        //config([
          //  'msgraph.clientId' => $config->client_id,
           // 'msgraph.clientSecret' => $config->client_secret,
           // 'msgraph.tenantId' => $config->tenant_id,
          //  'msgraph.redirectUri' => $config->redirect_uri,
          //  'msgraph.urlAuthorize' => 'https://login.microsoftonline.com/'. $config->tenant_id.'/oauth2/v2.0/authorize',
 //       ]);
    }
}
