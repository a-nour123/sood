<?php

namespace App\Listeners;

use App\Events\ControlEvidenceCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notific;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\User;
use App\Models\ControlControlObjective;
use App\Models\Evidence;
use App\Models\FrameworkControlTestAudit;

class ControlEvidenceCreatedListener
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
   * @param  \App\Events\ControlEvidenceCreated  $event
   * @return void
   */
  public function handle(ControlEvidenceCreated $event)
  {
    // Get the action ID for Risk_Add
    $action1 = Action::where('name', 'Evidence_Add')->first();
    $actionId1 = $action1['id'];

    // Get the risk object from the event
    $Evidence = $event->Evidence;
    $Auditer = FrameworkControlTestAudit::where('framework_control_id', $Evidence->controlControlObjective->control['id'])->latest()->first()->tester ?? Null;

    // Define the roles array for notification
    $roles = [
      'Evidence-Creator' => [$Evidence->creator_id ?? null],
      'Control-Owner' => [$Evidence->controlControlObjective->control->User->id ?? null],
      'Responsible_Person' => [$Evidence->controlControlObjective->responsibleUser->id ?? null],
      'Control-Tester' => [$Evidence->controlControlObjective->control->FrameworkControlTest->UserTester->id ?? null],
      'Auditer' => [$Auditer ?? null]

    ];

    // Define the link to be used in the notification
    $link = ['link' => route('admin.governance.control.list')];

    // Set the properties of the evidence object for notification message
    $Evidence->Evidence_Creator = $Evidence->creator->name ?? null;
    $Evidence->Control_Objective = $Evidence->controlControlObjective->objective->name ?? __('locale.[No Objective]'); // Check if the objective exists
    $Evidence->Control_Objective_Responsible = $Evidence->controlControlObjective->responsibleUser->name ?? __('locale.[No Responsible Person]');
    $Evidence->Control_Name = $Evidence->controlControlObjective->control->short_name ?? __('locale.[No Control Name]');
    $Evidence->Control_Owner = $Evidence->controlControlObjective->control->User->name ?? __('locale.[No Owner]');
    $Evidence->Control_Tester = $Evidence->controlControlObjective->control->FrameworkControlTest->UserTester->name ?? __('locale.[No Tester]');

    // Call the function to handle different kinds of notifications
    $actionId2 = null;
    $nextDateNotify = null;
    $modelId = null;
    $modelType = null;
    $proccess = null;
    // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
    $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $Evidence, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
  }
}
