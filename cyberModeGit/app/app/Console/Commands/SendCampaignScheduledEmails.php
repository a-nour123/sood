<?php

namespace App\Console\Commands;

use App\Jobs\SendCampaignEmailsJob;
use Illuminate\Console\Command;
use App\Models\PhishingCampaign;
use App\Mail\PhishingEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendCampaignScheduledEmails extends Command
{
    protected $signature = 'emails:send-campagin-scheduled';
    protected $description = 'Send scheduled emails for campaigns with delivery_type "setup"';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $currentDate = now()->toDateString(); // Current date in 'YYYY-MM-DD' format
        $currentTime = now()->toTimeString(); // Current time in 'HH:MM:SS' format

        $campaigns = PhishingCampaign::with(['employees', 'emailTemplates'])
            ->where('delivery_type', 'setup')
            ->where('approve', 1)
            ->whereDate('schedule_date_from', '<=', $currentDate)
            ->whereDate('schedule_date_to', '>=', $currentDate)
            ->whereTime('schedule_time_from', '<=', $currentTime)
            ->whereTime('schedule_time_to', '>=', $currentTime)
            ->get();

        foreach ($campaigns as $campaign) {
            SendCampaignEmailsJob::dispatch($campaign->employees, $campaign->emailTemplates);
        }

        Log::info("Scheduled emails sent successfully.");
    }
}
