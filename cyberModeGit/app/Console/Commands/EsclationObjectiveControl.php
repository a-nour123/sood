<?php

namespace App\Console\Commands;

use App\Http\Traits\NotificationHandlingTrait;
use App\Models\ControlControlObjective;
use App\Models\NotifyAtDateModel;
use Carbon\Carbon;
use Illuminate\Console\Command;

class EsclationObjectiveControl extends Command
{
    use NotificationHandlingTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature =  'Check the EsclationObjectiveCheck Action';
    protected $description =  'Check the EsclationObjectiveCheck Action';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $today = Carbon::today()->toDateString();
        $objectivesWithNoEvidence = ControlControlObjective::whereIn('objective_id', function ($query) use ($today) {
            $query->select('model_id')
                ->from('notify_at_date_models')
                ->whereJsonContains('notification_date', $today)
                ->where('model_type', 'esclationObjectiveNotify');
        })
            ->where('due_date', '<', $today)
            ->withCount('evidences')
            ->having('evidences_count', 0)
            ->get();

        foreach ($objectivesWithNoEvidence as $objective) {
            $notification = NotifyAtDateModel::where('model_type', 'esclationObjectiveNotify')
                ->where('model_id', $objective->objective_id)
                ->first();

            if ($notification) {
                $this->sendNotificationForAction(
                    null, // actionId1
                    $notification->action_id,
                    ['link' => $notification->link],
                    json_decode($notification->model, true),
                    json_decode($notification->roles, true),
                    json_decode($notification->notification_date, true),
                    null, // modelId
                    null, // modelType
                    null  // process
                );
            }
        }
    }
}
