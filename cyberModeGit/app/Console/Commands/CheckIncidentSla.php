<?php

namespace App\Console\Commands;

use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use App\Models\Incident;
use App\Models\IncidentClassify;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckIncidentSla extends Command
{
    use NotificationHandlingTrait;

    /**
     * The name and signature of the console command.
     */
    protected $signature = 'incidents:check-sla';

    /**
     * The console command description.
     */
    protected $description = 'Check incidents whose due date (created_at + SLA) equals today and send notifications.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        $classifications = IncidentClassify::orderBy('value', 'asc')->get();

        $this->info('🔍 Checking incidents for SLA expiration on ' . $today->toDateString());
        $count = 0;

        Incident::chunk(200, function ($incidents) use (&$count, $classifications, $today) {
            foreach ($incidents as $incident) {
                $totalScore = $this->calculateTotalScore($incident);
                $classify = $classifications->first(fn($c) => $c->value >= $totalScore);

                if (!$classify || !$incident->created_at) {
                    continue;
                }

                $dueDate = $incident->created_at->copy()->addDays($classify->sla);

                if ($dueDate->isSameDay($today)) {
                    $this->info("⚠️ Incident #{$incident->id} reached SLA ({$classify->sla} days)");
                    $this->handleNotification($incident);
                    $count++;
                }
            }
        });

        return Command::SUCCESS;
    }

    /**
     * Calculate the total score of an incident.
     */
    private function calculateTotalScore($incident)
    {
        return DB::table('incident_criteria_scores as ics')
            ->join('incident_scores as is', 'ics.incident_score_id', '=', 'is.id')
            ->where('ics.incident_id', $incident->id)
            ->sum('is.point');
    }

    /**
     * Handle notification sending for an SLA-due incident.
     */
    private function handleNotification($incident)
    {
        $action = Action::where('name', 'play_book_sla_due_date')->first();
        $actionId = $action->id;
        $incident = Incident::find($incident->id); // Reload to ensure relationships available

        // Get playbook users and teams without relations
        $userIds = [];
        $teamIds = [];
        $userIraIds = [];
        $teamIraIds = [];

        if ($incident && $incident->play_book_id) {
            // For now, I'll keep your existing code but with null checks
            $userIds = $incident->playbookUsers->pluck('id')->toArray() ?? [];
            $teamIds = $incident->playbookTeams->pluck('id')->toArray() ?? [];
        }

        if ($incident->type) {
            $userIraIds = $incident->incidentUsers->pluck('id')->toArray() ?? [];
            $teamIraIds = $incident->incidentTeams->pluck('id')->toArray() ?? [];
        }
        $roles = [
            'incident_creator' => [$incident->created_by ?? null],
            'play_book_user' => $userIds ?? null,
            'Team-teams' => $teamIds ?? null,
            'Team-ira' => $userIraIds ?? null,
            'ira_users' => $teamIraIds ?? null,
        ];

        $link = ['link' => route('admin.incident.index')];

        $this->sendNotificationForAction(
            $actionId,
            null,     // $actionId2
            $link,
            $incident,
            $roles,
            null,     // $nextDateNotify
            null,     // $modelId
            null,     // $modelType
            null      // $process
        );
    }
}