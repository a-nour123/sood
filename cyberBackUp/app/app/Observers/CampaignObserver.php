<?php

namespace App\Observers;

use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use App\Models\PhishingCampaign;
use Illuminate\Support\Facades\Log;

class CampaignObserver
{
    use NotificationHandlingTrait;
    /**
     * Handle the PhishingCampaign "created" event.
     *
     * @param  \App\Models\PhishingCampaign  $phishingCampaign
     * @return void
     */
    public function created(PhishingCampaign $phishingCampaign)
    {
        $this->setCampaignNotificationData($phishingCampaign,130);
        Log::info('Campaign Created: ' . $phishingCampaign->id);
    }

    /**
     * Handle the PhishingCampaign "updated" event.
     *
     * @param  \App\Models\PhishingCampaign  $phishingCampaign
     * @return void
     */
    public function updated(PhishingCampaign $phishingCampaign)
    {
        if($phishingCampaign->isDirty('approve')){
            $this->setCampaignNotificationData($phishingCampaign,131);
            Log::info('Campaign Approved: ' . $phishingCampaign->id);
        }

        if($phishingCampaign->isDirty('delivery_status')){
            $this->setCampaignNotificationData($phishingCampaign,132);
            Log::info('Campaign Sended: ' . $phishingCampaign->id);
        }
    }

    /**
     * Handle the PhishingCampaign "deleted" event.
     *
     * @param  \App\Models\PhishingCampaign  $phishingCampaign
     * @return void
     */
    public function deleted(PhishingCampaign $phishingCampaign)
    {
        //
    }

    /**
     * Handle the PhishingCampaign "restored" event.
     *
     * @param  \App\Models\PhishingCampaign  $phishingCampaign
     * @return void
     */
    public function restored(PhishingCampaign $phishingCampaign)
    {
        //
    }

    /**
     * Handle the PhishingCampaign "force deleted" event.
     *
     * @param  \App\Models\PhishingCampaign  $phishingCampaign
     * @return void
     */
    public function forceDeleted(PhishingCampaign $phishingCampaign)
    {
        //
    }

    public function setCampaignNotificationData($phishingCampaign,$id)
    {
        // Get the action ID for Add Course
        $action1 = Action::where('id', $id)->first();
        $actionId1 = $action1['id'];

        // Define the roles array for notification
        $roles = [
            'Name' => [$phishingCampaign->campaign_name ?? null],
            'Type' => [$phishingCampaign->campaign_type ?? null],
        ];

        // Define the link for redirection after clicking the system notification
        $link = ['link' => route('admin.phishing.campaign.index')];

        // Set the properties of the Course object for notification message
        $phishingCampaign->Name = $phishingCampaign->campaign_name;
        $phishingCampaign->Type = $phishingCampaign->campaign_type;

        // parentDepartment ??
        $actionId2 = null;
        $nextDateNotify = null;
        $modelId = null;
        $modelType = null;
        $proccess = null;
        // Call the function to handle different kinds of notifications
        $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $phishingCampaign, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}
