<?php

namespace App\Jobs;

use App\Http\Traits\PhishingMailTrait;
use App\Mail\PhishingEmail;
use App\Models\PhishingEmployeeList;
use App\Models\PhishingTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class SendCampaignEmailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels, PhishingMailTrait;

    protected $campaign;
    protected $employees;
    protected $emailTemplates;

    public function __construct($campaign,$employees, $emailTemplates)
    {
        $this->employees = $employees;
        $this->campaign = $campaign;
        $this->emailTemplates = $emailTemplates;
    }

    public function handle()
    {
        foreach ($this->emailTemplates as $mail) {
            foreach ($this->employees as $employee) {
                $mailObject = new PhishingEmail($mail, $employee,$this->campaign->id);
                $isSent = $this->sendPhishingMail2("hamam@pk.com", $mail, $employee->email, $mailObject);
                // Update database based on email status
                if ($isSent) {
                    $this->updateCampaignStatus($mail, $employee);
                }
            }
        }
    }

    protected function updateCampaignStatus($mail, $employee)
    {
        try {
            switch ($this->campaign->campaign_type) {
                case "simulated_phishing":
                    $this->updateSimulatedPhishing($mail, $employee);
                    break;

                case "simulated_phishing_and_security_awareness":
                    $this->updateSimulatedPhishingAndAwareness($mail, $employee);
                    break;
                default:
                    dump("Failed to update PhishingEmployeeList records: Invalid campaign type.");
            }
        } catch (\Exception $e) {
            dump("Failed to update records: " . $e->getMessage());
        }
    }

    protected function updateSimulatedPhishing($mail, $employee)
    {
        DB::beginTransaction(); // Start a transaction

        try {
            // Update the phishing_campaign_employee_list table
            $updateEmployee = DB::table('phishing_campaign_employee_list')
                ->where('campaign_id', $this->campaign->id)
                ->where('employee_id', $employee->id)
                ->update(['is_delivered' => 1]);

            // Check if the first query was successful
            if ($updateEmployee === false) {
                throw new \Exception('Failed to update phishing_campaign_employee_list');
            }

            // Update the phishing_campaign_email_template table
            $updateTemplate = DB::table('phishing_campaign_email_template')
                ->where('campaign_id', $this->campaign->id)
                ->where('email_template_id', $mail->id)
                ->update(['is_delivered' => 1]);

            // Check if the second query was successful
            if ($updateTemplate === false) {
                throw new \Exception('Failed to update phishing_campaign_email_template');
            }

            // Update the phishing_campaigns table
            $updateCampaign = DB::table('phishing_campaigns')
                ->where('id', $this->campaign->id)
                ->update(['delivery_status' => 1]);

            // Check if the third query was successful
            if ($updateCampaign === false) {
                throw new \Exception('Failed to update phishing_campaigns');
            }

            // Commit the transaction if all queries are successful
            DB::commit();
            return true; // All queries were successful

        } catch (\Exception $e) {
            // Rollback the transaction if any query fails
            DB::rollBack();

            // Log the error for debugging
            dd('Error in updateSimulatedPhishing: ' . $e->getMessage());

            return false; // Indicate failure
        }
    }

    protected function updateSimulatedPhishingAndAwareness($mail, $employee)
    {
        DB::table('phishing_campaign_employee_list')
            ->where('campaign_id', $this->campaign->id)
            ->where('employee_id', $employee->id)
            ->update(['is_delivered' => 1]);

        DB::table('phishing_campaign_email_template')
            ->where('campaign_id', $this->campaign->id)
            ->where('email_template_id', $mail->id)
            ->update(['is_delivered' => 1]);

        DB::table('phising_campaign_training_module')
            ->where('campaign_id', $this->campaign->id)
            ->update(['is_delivered' => 1]);
    }


}
