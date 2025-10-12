<?php
namespace App\Jobs;

use App\Models\Department;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ImportMicrosoftUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $users;
    protected $batchNumber;

    public function __construct(array $users, int $batchNumber)
    {
        $this->users = $users;
        $this->batchNumber = $batchNumber;
    }

    public function handle()
    {
        $defaultDepartment = Department::where('name', 'default')->first();

        if (!$defaultDepartment) {
            Log::error("Batch {$this->batchNumber}: Default department not found");
            return;
        }

        $processed = 0;
        $failed = 0;

        foreach ($this->users as $graphUser) {
            try {
                $this->processUser($graphUser, $defaultDepartment);
                $processed++;
            } catch (\Exception $e) {
                Log::error("Batch {$this->batchNumber}: Failed to process user {$graphUser['id']} - " . $e->getMessage());
                $failed++;
            }
        }

        Log::info("Batch {$this->batchNumber} completed: {$processed} users processed, {$failed} failures");
    }

    protected function processUser(array $graphUser, Department $defaultDepartment)
    {
          $username = $graphUser['mailNickname'] ?? explode('@', $graphUser['mail'] ?? $graphUser['userPrincipalName'])[0];
            $userData = [
            'name' => $graphUser['displayName'] ?? null,
                'email' =>  $graphUser['mail'] ?? null,
                'phone_number' =>  $graphUser['mobilePhone'] ?? null,
                'enabled' =>  $graphUser['accountEnabled'] ?? 1,
                'password' =>  Hash::make('12345678'),
                'username' => $username,
                'type' => 'microsoft_graph',
                'microsoft_id' => $graphUser['id'] ,
                'role_id' => 3,

            ];


        // // Handle department assignment
        $department = $defaultDepartment;
        if (!empty($graphUser['department'])) {
            $department_exist = Department::where('name' , $graphUser['department'])->first();
            if($department_exist){
                $userData['department_id'] = $department_exist->id;
            }else{
                $userData['department_id'] = $department->id;
            }
        }else{
                $userData['department_id'] = $department->id;
        }

        User::updateOrCreate(
            ['email' => $userData['email']],
            $userData
        );
        // dd('1');
    }
}
