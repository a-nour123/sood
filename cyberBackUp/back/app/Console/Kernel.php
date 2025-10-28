<?php

namespace App\Console;

use App\Console\Commands\vulnerabilityStatus;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Asset;
use App\Models\NotifyAtDateModel;
use App\Models\Vulnerability;
use Carbon\Carbon;
use App\Repositories\SurveyRepo;

class Kernel extends ConsoleKernel
{
    use NotificationHandlingTrait;

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // \App\Console\Commands\AdminSettingsNotify::class,
        \App\Console\Commands\VulnerabilityStatus::class,

    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->command('asset:expirationDateAlert')->dailyAt('00:01'); // run at the first minute at every day
        $schedule->command(vulnerabilityStatus::class)->daily();
        $schedule->command('emails:send-campagin-scheduled')->everyMinute();  // Run every hour or adjust as needed
        $schedule->command('cleanup:old-files')->dailyAt('00:01'); // Runs daily

        // test for notification that notify at the before date

        // schedule of Auto Notification

        $schedule->call(function () {




            // Get today's date
            $today = Carbon::today()->toDateString();

            // Get all records
            $records = NotifyAtDateModel::all();

            // Loop through each record
            foreach ($records as $record) {
                // Decode the JSON-encoded dates
                $dates = json_decode($record->notification_date, true);

                // Check if all dates in the array are less than today
                if (collect($dates)->every(function ($date) use ($today) {
                    return $date < $today;
                })) {
                    // Delete the record
                    $record->delete();
                }
            }

            // in this i delete asset and survey and security awareness and documintation and task and control if user delete
            // it from grc
            $Proccess = NotifyAtDateModel::where('proccess', 'delete')->delete();

            $surveyActions = NotifyAtDateModel::where('model_type', 'survey')
                ->where('model->filter_status', 3) // Use '->' to access the nested key
                ->select('model')
                ->delete();
            $securityActions = NotifyAtDateModel::where('model_type', 'securityAwareness')
                ->where('model->status', 3) // Use '->' to access the nested key
                ->select('model')
                ->delete();
            $documentActions = NotifyAtDateModel::where('model_type', 'document')
                ->where('model->document_status', 3) // Use '->' to access the nested key
                ->select('model')
                ->delete();


            $today = Carbon::today()->toDateString();
            $pendingNotifications = NotifyAtDateModel::whereJsonContains('notification_date', $today)->get();
            foreach ($pendingNotifications as $notification) {
                $model = json_decode($notification->model, true);
                $roles = json_decode($notification->roles, true);
                $actionId2 = $notification->action_id;
                $link = $notification->link;
                $nextDateNotify = json_decode($notification->notification_date, true);
                $this->sendNotificationForAction($actionId1 = null, $actionId2, $link, $model, $roles, $nextDateNotify,  $modelId = null, $modelType = null, $proccess = null);
            }
        })->everyMinute();
    }


    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
