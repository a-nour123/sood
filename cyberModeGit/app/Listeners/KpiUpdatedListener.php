<?php

namespace App\Listeners;

use App\Events\KpiUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notific;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\User;
use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class KpiUpdatedListener
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
     * @param  \App\Events\KpiUpdated  $event
     * @return void
     */
    public function handle(KpiUpdated $event)
    {
      // Get the action ID for Risk_Add
      $action1 = Action::where('name','Kpi_Update')->first();
      $actionId1 = $action1['id'];
      $action2 = Action::where('name', 'initiate_Assessment_value_Notify_Before_Last_End_Date')->first();
      $actionId2 = $action2['id'];
      // Get the risk object from the event
      $kpi = $event->kpi;
      // Define the roles array for notification

      $roles = [
        'manager' => [$kpi->Department->manager->id ?? null],
        'creator'=>[$kpi->created_by_user->id ?? null],
      ];
      
      // Define teams in the desired format for notification message
     
      // Define the link for redirection after clicking the system notification
      $link = ['link' => route('admin.KPI.index')];
  
      // Set the properties of the risk object for notification message
  
      $kpi->Created_by = $kpi->created_by_user ? $kpi->created_by_user->name : null;
      $kpi->Departement_Owner = $kpi->Department->manager ? $kpi->Department->manager->name: null;

      $modelId = $kpi->id;
      $proccess = "update";

      $modelType = "kpi";
      //   to get number od days
      $NumbersOfDays = DB::table('auto_notifies')
          ->join('actions', 'auto_notifies.action_id', '=', 'actions.id')
          ->where('actions.name', 'initiate_Assessment_value_Notify_Before_Last_End_Date')
          ->select('auto_notifies.date')
          ->first();

      if ($NumbersOfDays) {
          // Decode the JSON string to an array of integers
          $datesArray = json_decode($NumbersOfDays->date, true);

          if (is_array($datesArray)) {
              $DateNotify = now()->today();
              $nextDateNotify = [];

              foreach ($datesArray as $days) {
                  // Convert days to an integer and subtract from DateNotify
                  $numberOfDaysToSubtract = (int) $days;

                  // Parse the initial date with Carbon and add the specified number of days
                  $carbonDate = Carbon::parse($DateNotify)->addDays(($kpi->period_of_assessment) * 30);
                  // Subtract the calculated number of days
                  $nextDate = $carbonDate->subDays($numberOfDaysToSubtract);

                  // Format the result and store it in an array
                  $nextDateNotify[] = $nextDate->format('Y-m-d');
              }

              // $nextDateNotify now contains the results of subtracting each day from the adjusted DateNotify.
              // You can use this array as needed.
          }
      }

      // handling different kinds of notifications using the "sendNotificationForAction" function from the "NotificationHandlingTrait"
      if ($NumbersOfDays == null) {
          $this->sendNotificationForAction($actionId1, $actionId2, $link, $kpi, $roles, $nextDateNotify = null, $modelId, $modelType, $proccess);
      } else if ($NumbersOfDays !== null) {
          $this->sendNotificationForAction($actionId1, $actionId2, $link, $kpi, $roles, $nextDateNotify, $modelId, $modelType, $proccess);
      }
  }
}
