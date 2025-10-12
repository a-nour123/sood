<?php

namespace App\Http\Controllers\admin\configure;

use App\Http\Controllers\Controller;
use App\Models\MicrosoftConfiguration;
use App\Services\MicrosoftGraphService;
use App\Services\UserSyncService;
use Illuminate\Http\Request;

class MicrosoftConfigurationController extends Controller
{
       protected $graphService;
    protected $userSyncService;

    public function __construct(MicrosoftGraphService $graphService, UserSyncService $userSyncService)
    {
        $this->graphService = $graphService;
        $this->userSyncService = $userSyncService;
    }

      private $path='admin.content.configure.extras.';
    /**
     * Display extras page
     *
     * @return String
     */
    public function ConfigurationMicrosoft(){
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
         ['name' => __('locale.Microsoft Graph Authentication')]];
          $config = MicrosoftConfiguration::first();

        return view($this->path.'microsoft-Configuration', compact('breadcrumbs','config'));
    }
    /**
     * Display extras page
     *
     * @return String
     */


    public function ConfigurationMicrosoftSave(Request $request){

       $validated = $request->validate([
            'client_id' => 'required|string',
            'client_secret' => 'required|string',
            'tenant_id' => 'required|string',
            'redirect_uri' => 'nullable|url',
        ]);

        MicrosoftConfiguration::updateOrCreate(
            ['id' => 1], // Assuming single configuration
            $validated
        );

        return redirect()->route('admin.configure.extras.microsoft-Configuration');
    }

    public function MicrosoftTestConnection(){
    try {
                $users = $this->graphService->getUsers(null, null, 1);

                return response()->json([
                    'success' => true,
                    'message' => 'Connection successful',
                    'sample_user_count' => ($users)
                ]);

            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Connection failed: ' . $e->getMessage()
                ], 500);
            }
        }
}
