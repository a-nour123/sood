<?php

namespace App\Console;

use App\Console\Commands\CheckIncidentSla;
use App\Console\Commands\EsclationAuditeesDocumentAudit;
use App\Console\Commands\EsclationObjectiveControl;
use App\Console\Commands\FetchVulnerabilities;
use App\Console\Commands\vulnerabilityStatus;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Asset;
use App\Models\ControlControlObjective;
use App\Models\ControlObjective;
use App\Models\NotifyAtDateModel;
use App\Models\ScheduledVulnerability;
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
        \App\Console\Commands\FetchVulnerabilities::class,
        \App\Console\Commands\EsclationAuditeesDocumentAudit::class,
        \App\Console\Commands\EsclationObjectiveControl::class,
        \App\Console\Commands\CheckIncidentSla::class,

    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $scheduleVulnerabilityTunable = ScheduledVulnerability::first(); // Retrieve the first record, or null if none exist
        $currentTime = Carbon::now()->format('H:i');
        $todayName = Carbon::now()->format('l');

        // Check if the scheduleVulnerabilityTunable is not null and is an instance of the expected model
        if ($scheduleVulnerabilityTunable) {
            $futuredate = Carbon::now()->format('m-d H:i');
            $convert_Month = Carbon::parse($scheduleVulnerabilityTunable->date_monthly)->format('d');
            $convert_time = Carbon::parse($scheduleVulnerabilityTunable->date_monthly)->format('H:i');
            $dateString = $scheduleVulnerabilityTunable->date_monthly;
            $dayOfMonth = (int)substr($dateString, 8, 2);

            // Define the scheduling commands based on the presence and properties of $scheduleVulnerabilityTunable
            if ($scheduleVulnerabilityTunable->time_schedule == "daily" && $scheduleVulnerabilityTunable->due_time == $currentTime) {
                $schedule->command(FetchVulnerabilities::class)->everyMinute();
            }

            if ($scheduleVulnerabilityTunable->time_schedule == "weekly" && $scheduleVulnerabilityTunable->due_weekly_time == $currentTime && $scheduleVulnerabilityTunable->due_weekly_day == $todayName) {
                $schedule->command(FetchVulnerabilities::class)->everyMinute();
            }

            if ($scheduleVulnerabilityTunable->time_schedule == "monthly") {
                $currentMonthDays = Carbon::now()->daysInMonth;
                if ($currentMonthDays <= $dayOfMonth) {
                    $lastDayOfMonth = Carbon::now()->endOfMonth()->format('d');
                    $schedule->command(FetchVulnerabilities::class)->monthlyOn($lastDayOfMonth, $convert_time);
                } else {
                    $schedule->command(FetchVulnerabilities::class)->monthlyOn($convert_Month, $convert_time);
                }
            }
        }

        // Schedule asset expiration alert
        $schedule->command('asset:expirationDateAlert')->dailyAt('00:01'); // Run at the first minute of every day

        // Schedule cleanup task
        $schedule->command('cleanup:old-files')->dailyAt('00:01'); // Runs daily
        $schedule->command(EsclationObjectiveControl::class)->dailyAt('00:01'); // Runs daily

        // Schedule vulnerability status check
        $schedule->command(vulnerabilityStatus::class)->dailyAt('00:01'); // Runs daily
        $schedule->command(EsclationAuditeesDocumentAudit::class)->dailyAt('07:01'); // Runs daily

        $schedule->command(CheckIncidentSla::class)->dailyAt('07:01');


        // Auto Notification cleanup and processing
        $schedule->call(function () {
            // Get today's date
            $today = Carbon::today()->toDateString();

            // Get and process all records
            $records = NotifyAtDateModel::all();

            // Loop through each record
            foreach ($records as $record) {
                // Decode the JSON-encoded dates
                $dates = json_decode($record->notification_date, true);

                // Check if the notification_date is an empty array
                if (empty($dates)) {
                    // You can perform any additional logic here for empty arrays if needed
                    // For example, skip deletion or set default behavior
                    continue; // Skip this record and move to the next one
                }

                // Check if all dates in the array are less than today
                if (collect($dates)->every(fn($date) => $date < $today)) {
                    // Delete the record
                    $record->delete();
                }
            }


            // Additional cleanup for specific processes and models
            NotifyAtDateModel::where('proccess', 'delete')->delete();
            NotifyAtDateModel::where('model_type', 'survey')
                ->where('model->filter_status', 3)
                ->select('model')
                ->delete();
            NotifyAtDateModel::where('model_type', 'securityAwareness')
                ->where('model->status', 3)
                ->select('model')
                ->delete();
            NotifyAtDateModel::where('model_type', 'document')
                ->where('model->document_status', 3)
                ->select('model')
                ->delete();


            // Notify for pending notifications
            $pendingNotifications = NotifyAtDateModel::whereJsonContains('notification_date', $today)
                ->whereNotIn('model_type', ['Audit_Policy_Skip_Due_Date', 'esclationObjectiveNotify'])
                ->get();
            foreach ($pendingNotifications as $notification) {
                $model = json_decode($notification->model, true);
                $roles = json_decode($notification->roles, true);
                $actionId2 = $notification->action_id;
                $link = $notification->link;
                $nextDateNotify = json_decode($notification->notification_date, true);
                $this->sendNotificationForAction($actionId1 = null, $actionId2, ['link' => $link], $model, $roles, $nextDateNotify,  $modelId = null, $modelType = null, $proccess = null);
            }
        })->dailyAt('00:01'); // Runs daily
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