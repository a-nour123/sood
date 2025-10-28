<?php

namespace App\Listeners;

use App\Events\AuditCommentCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notific;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\User;
use App\Models\FrameworkControlTestResult;
use App\Models\FrameworkControlTestAudit;
use App\Models\FrameworkControlTest;
use App\Models\FrameworkControl;
use App\Models\Risk;
use App\Models\RiskCatalog;
use App\Models\ThreatCatalog;
use App\Models\FrameworkControlTestComment;

class AuditCommentCreatedListener
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
   * @param  \App\Events\AuditCommentCreated  $event
   * @return void
   */
  public function handle(AuditCommentCreated $event)
  {

    // Get the action ID for Risk_Add
    $action1 = Action::where('name', 'Aduit_Comment_Add')->first();
    $actionId1 = $action1['id'];

    // Get the risk object from the event
    $FrameworkControlTestComment = $event->FrameworkControlTestComment;
    //   dd($FrameworkControlTestComment->UserCommented->name );
    //   dd($FrameworkControlTestComment->FrameworkControlTestAudit->FrameworkControl->control_owner);


    // Define the roles array for notification
    $roles = [
      'Control-Owner' => [$FrameworkControlTestComment->FrameworkControlTestAudit->FrameworkControl->control_owner ?? null],
      'Control-Tester' => [$FrameworkControlTestComment->FrameworkControlTestAudit->UserTester->id ?? null],
    ];
    //   dd($roles);


    $link = ['link' => route('admin.compliance.audit.index')];

    // Set the properties of the risk object for notification message
    $FrameworkControlTestComment->Comment_By = $FrameworkControlTestComment->UserCommented ? $FrameworkControlTestComment->UserCommented->name : null;
    $FrameworkControlTestComment->Tester = $FrameworkControlTestComment->FrameworkControlTestAudit->UserTester ? $FrameworkControlTestComment->FrameworkControlTestAudit->UserTester->name : null;
    $FrameworkControlTestComment->Test_Frequency = $FrameworkControlTestComment->FrameworkControlTestAudit->test_frequency ? $FrameworkControlTestComment->FrameworkControlTestAudit->test_frequency : null;
    $FrameworkControlTestComment->Test_Name = $FrameworkControlTestComment->FrameworkControlTestAudit->name ? $FrameworkControlTestComment->FrameworkControlTestAudit->name : null;
    $FrameworkControlTestComment->Test_Steps = $FrameworkControlTestComment->FrameworkControlTestAudit->test_steps ? $FrameworkControlTestComment->FrameworkControlTestAudit->test_steps : null;
    $FrameworkControlTestComment->Approximate_Time = $FrameworkControlTestComment->FrameworkControlTestAudit->approximate_time ? $FrameworkControlTestComment->FrameworkControlTestAudit->approximate_time : null;
    $FrameworkControlTestComment->Expected_Results = $FrameworkControlTestComment->FrameworkControlTestAudit->expected_results ? $FrameworkControlTestComment->FrameworkControlTestAudit->expected_results : null;
    $FrameworkControlTestComment->Control_Owner = $FrameworkControlTestComment->FrameworkControlTestAudit->FrameworkControl->User ? $FrameworkControlTestComment->FrameworkControlTestAudit->FrameworkControl->User->name : null;
    $FrameworkControlTestComment->Desired_Maturity = $FrameworkControlTestComment->FrameworkControlTestAudit->FrameworkControl->ControlDesiredMaturity ? $FrameworkControlTestComment->FrameworkControlTestAudit->FrameworkControl->ControlDesiredMaturity->name : null;
    $FrameworkControlTestComment->Control_Priority = $FrameworkControlTestComment->FrameworkControlTestAudit->FrameworkControl->priority ? $FrameworkControlTestComment->FrameworkControlTestAudit->FrameworkControl->priority->name : null;
    $FrameworkControlTestComment->Control_class = $FrameworkControlTestComment->FrameworkControlTestAudit->FrameworkControl->class ? $FrameworkControlTestComment->FrameworkControlTestAudit->FrameworkControl->class->name : null;
    $FrameworkControlTestComment->Control_Maturity = $FrameworkControlTestComment->FrameworkControlTestAudit->FrameworkControl->ControlMaturity ? $FrameworkControlTestComment->FrameworkControlTestAudit->FrameworkControl->ControlMaturity->name : null;
    $FrameworkControlTestComment->Control_Phase = $FrameworkControlTestComment->FrameworkControlTestAudit->FrameworkControl->ControlPhase ? $FrameworkControlTestComment->FrameworkControlTestAudit->FrameworkControl->ControlPhase->name : null;
    $FrameworkControlTestComment->Control_Type = $FrameworkControlTestComment->FrameworkControlTestAudit->FrameworkControl->type ? $FrameworkControlTestComment->FrameworkControlTestAudit->FrameworkControl->type->name : null;
    // Call the function to handle different kinds of notifications
    $actionId2 = null;
    $nextDateNotify = null;
    $modelId = null;
    $modelType = null;
    $proccess = null;
    // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
    $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $FrameworkControlTestComment, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
  }
}
