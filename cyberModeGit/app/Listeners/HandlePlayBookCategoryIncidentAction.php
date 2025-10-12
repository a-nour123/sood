<?php

namespace App\Listeners;

use App\Events\playBookCategoryIncidentAction;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Action;
use App\Models\Incident;
use App\Models\IncidentPlayBookAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandlePlayBookCategoryIncidentAction
{
    use NotificationHandlingTrait;

    public function __construct()
    {
        //
    }

    public function handle(playBookCategoryIncidentAction $event)
    {
        $changedActions = $event->changedActions;
//dd($changeActions);
        // Get the action ID for notification (optional chaining used)
        $actionId1 = Action::where('name', 'play_book_incident_action')->first()?->id;

        $summaries = [];
        $statuses = [];
        $categoryTitles = [];
        $categoryTypes = [];

        // Get playbook users and teams without relations
        $userIds = [];
        $teamIds = [];
        $userIraIds = [];
        $teamIraIds = [];

        $incidentIds = collect($changedActions)->pluck('incident_id')->unique();
//dd($incidentsIds);
        $anyIncident = false;

        foreach ($incidentIds as $incidentId) {
            $incident = Incident::with(['playbookUsers', 'playbookTeams'])->find($incidentId);

            if (!$incident) {
                continue;
            }

            $anyIncident = true;

            $summaries[] = $incident->summary ?? '';
            $statuses[] = $incident->status ?? '';

            $userIds = array_merge($userIds, $incident->playbookUsers?->pluck('id')->toArray() ?? []);
            $teamIds = array_merge($teamIds, $incident->playbookTeams?->pluck('id')->toArray() ?? []);
            $userIraIds = array_merge($userIraIds, $incident->incidentUsers?->pluck('id')->toArray() ?? []);
            $teamIraIds = array_merge($teamIraIds, $incident->incidentTeams?->pluck('id')->toArray() ?? []);

            foreach ($changedActions as $action) {
                if ($action['incident_id'] != $incidentId) continue;

                $ipa = IncidentPlayBookAction::with('playBookAction.playBooks')->find($action['action_id']);

                $playBookAction = $ipa?->playBookAction;

                if (!$playBookAction) continue;

                $categoryTitles[] = $playBookAction->title ?? '';

                foreach ($playBookAction->playBooks ?? [] as $playbook) {
                    $categoryTypes[] = $playbook->pivot?->category_type ?? '';
                }
            }
        }
//dd("dddd");
        // Early exit if no incident was found at all
        if (!$anyIncident) {
            return;
        }

        // Remove duplicates and implode
        $summaryText = implode(' | ', array_unique(array_filter($summaries)));
        $statusText = implode(' | ', array_unique(array_filter($statuses)));
        $categoryTitleText = implode(' | ', array_unique(array_filter($categoryTitles)));
        $categoryTypeText = implode(' | ', array_unique(array_filter($categoryTypes)));

        // Instead of stdClass, use an associative array
        $incidentObj = [
            'summary' => $summaryText ?? '',
            'status' => $statusText ?? '',
            'category_title' => $categoryTitleText ?? '',
            'category_type' => $categoryTypeText ?? '',
        ];
//dd($incidentObj);
        $roles = [
            'incident_creator' => [$incidentObj['created_by'] ?? null],
            'play_book_user' => $userIds ?? null,
            'Team-teams' => $teamIds ?? null,
            'Team-ira' => $userIraIds ?? null,
            'ira_users' => $teamIraIds ?? null,
        ];

        $link = ['link' => route('admin.incident.index')];

        // Send notification using the fallback incident object (now associative array)
        $this->sendNotificationForAction(
            $actionId1,
            null,
            $link,
            $incidentObj, // Now using an associative array
            $roles,
            null,
            null,
            null,
            null
        );
    }
}
