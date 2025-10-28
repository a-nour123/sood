<?php
// app/Services/UserSyncService.php

namespace App\Services;

use App\Models\MicrosoftUser;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserSyncService
{
    protected $graphService;

    public function __construct(MicrosoftGraphService $graphService)
    {
        $this->graphService = $graphService;
    }

    public function syncAllUsers()
    {
        // Log::info('Starting Microsoft Graph user sync');

        // try {
        //     $users = $this->graphService->getAllUsers(
        //         'id,displayName,givenName,surname,userPrincipalName,mail,jobTitle,department,officeLocation,mobilePhone,businessPhones,accountEnabled'
        //     );

        //     $syncStats = [
        //         'total' => count($users),
        //         'created' => 0,
        //         'updated' => 0,
        //         'errors' => 0
        //     ];

        //     DB::beginTransaction();

        //     foreach ($users as $userData) {
        //         try {
        //             $isNew = !MicrosoftUser::where('microsoft_id', $userData['id'])->exists();

        //             $this->syncUser($userData);

        //             if ($isNew) {
        //                 $syncStats['created']++;
        //             } else {
        //                 $syncStats['updated']++;
        //             }

        //         } catch (\Exception $e) {
        //             Log::error('Failed to sync user: ' . ($userData['id'] ?? 'unknown'), [
        //                 'error' => $e->getMessage(),
        //                 'user_data' => $userData
        //             ]);
        //             $syncStats['errors']++;
        //         }
        //     }

        //     DB::commit();

        //     Log::info('Microsoft Graph user sync completed', $syncStats);

        //     return $syncStats;

        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     Log::error('Microsoft Graph user sync failed: ' . $e->getMessage());
        //     throw $e;
        // }
    }

    public function syncUser(array $userData)
    {
        // return MicrosoftUser::updateOrCreate(
        //     ['microsoft_id' => $userData['id']],
        //     [
        //         'display_name' => $userData['displayName'] ?? null,
        //         'given_name' => $userData['givenName'] ?? null,
        //         'surname' => $userData['surname'] ?? null,
        //         'user_principal_name' => $userData['userPrincipalName'] ?? null,
        //         'mail' => $userData['mail'] ?? null,
        //         'job_title' => $userData['jobTitle'] ?? null,
        //         'department' => $userData['department'] ?? null,
        //         'office_location' => $userData['officeLocation'] ?? null,
        //         'mobile_phone' => $userData['mobilePhone'] ?? null,
        //         'business_phones' => $userData['businessPhones'] ?? [],
        //         'account_enabled' => $userData['accountEnabled'] ?? true,
        //         'last_synced_at' => now(),
        //         'raw_data' => $userData
        //     ]
        // );
    }

    public function getSyncStats()
    {
        // return [
        //     'total_users' => MicrosoftUser::count(),
        //     'active_users' => MicrosoftUser::where('account_enabled', true)->count(),
        //     'inactive_users' => MicrosoftUser::where('account_enabled', false)->count(),
        //     'last_sync' => MicrosoftUser::max('last_synced_at'),
        //     'users_with_email' => MicrosoftUser::whereNotNull('mail')->count(),
        // ];
    }
}
