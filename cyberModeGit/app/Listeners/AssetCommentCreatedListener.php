<?php

namespace App\Listeners;

use App\Events\AssetCommentCreated;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use App\Models\Asset;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AssetCommentCreatedListener
{
    use NotificationHandlingTrait;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(AssetCommentCreated $event)
    {
        // Get the action ID for Risk_Add
        $action1 = Action::where('name', 'add_asset_comment')->first();

        $actionId1 = $action1['id'];

        // Get the risk object from the event
        $assetComment = $event->comment;

        $roles = [
            'Asset-Owner' => [$assetComment?->asset?->asset_owner ?? null],
        ];

        $link = ['link' => route('admin.asset_management.index')];

        $assetComment->comment = $assetComment->comment ?? null;

        $assetComment->Name = $assetComment?->asset?->name ?? null;

        $assetComment->asset_owner = $assetComment?->asset?->owner?->name ?? null;
        $assetComment->created_by = $assetComment?->user?->name ?? null;

        // Call the function to handle different kinds of notifications
        $actionId2 = null;
        $nextDateNotify = null;
        $modelId = null;
        $modelType = null;
        $proccess = null;
        // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
        $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $assetComment, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}
