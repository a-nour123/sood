<?php

namespace App\Listeners;

use App\Events\AssetsGroupCreated;
use App\Http\Traits\NotificationTeamTrait;
use Notific;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Team;
use App\Models\User;
use App\Models\AssetGroup;

class AssetsGroupCreatedListener
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
     * @param  \App\Events\AssetsGroupCreated  $event
     * @return void
     */
    public function handle(AssetsGroupCreated $event)
    {
        
              // getting the action id of event
      $action1 = Action::where('name', 'Asset_Group_Add')->first();
      $actionId1 = $action1['id'];
      // getting the model of event
      $assetGroup = $event->assetGroup;
      $allAssets = $event->allAssets;
      $ownerEmails = $allAssets->pluck('owner_email')->unique()->toArray();
      $AssetValues = $allAssets->pluck('owner_email')->unique()->toArray();

      if (!empty($ownerEmails)) {
          $ownerAssetIds = User::whereIn('email', $ownerEmails)->pluck('id')->toArray();
      } else {
          $ownerAssetIds = [];
      }
      
      

    //   $mainAsset=$assetGroup->assets;
      $roles = [
        'Asset-Owner'=>$ownerAssetIds ?? null
      ];

       // to get the column in database appear in notification as string not int
       $assetGroup->Name = $assetGroup->name ?? null;
      //  $allAssets->Asset_value_level = $assetGroup->name ?? null;
       
      // defining the link we want the user to be redirected to after clicking the system notification
      $link = ['link' => route('admin.asset_management.asset_group.index')];
  
      $actionId2=null;
      $nextDateNotify = null;
      $modelId=null;
      $modelType=null;
      $proccess=null;
      // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
      $this->sendNotificationForAction($actionId1, $actionId2=null,$link, $assetGroup, $roles, $nextDateNotify = null, $modelId=null, $modelType=null,$proccess=null);
    }
}
