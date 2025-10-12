<?php

namespace App\Exports;

use App\Models\SecurityAwareness;
use App\Traits\LaravelExportPropertiesTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;

class SecurityAwarenessesExport implements FromCollection, WithMapping, WithHeadings, WithProperties
{

    use LaravelExportPropertiesTrait; // This trait implement properties function required by (WithProperties)
    private $counter = 1;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $currentUserId = auth()->id();
        $_securityAwarenesses = SecurityAwareness::get();

        // Filter if current user is adminstator, owner, creator or has ability to view security awarenesses depending on security awarenesses status and privacy
        $filteredSecurityAwareness = $_securityAwarenesses->filter(function ($securityAwareness) use ($currentUserId) {
            return (auth()->user()->role_id == 1 && $securityAwareness->opened) || ($currentUserId == $securityAwareness->owner) || ($currentUserId == $securityAwareness->created_by && $securityAwareness->opened) || ($this->getUserHaveAbilityToViewSecurityAwareness($securityAwareness, $currentUserId) && $securityAwareness->opened);
        })->values();

        return $filteredSecurityAwareness;
    }

    /**
     * @var SecurityAwareness $securityAwareness
     */
    public function map($securityAwareness): array
    {
        $statuses = [];
        $statuses[1] = "Draft";
        $statuses[2] = "InReview";
        $statuses[3] = "Approved";

        return [
            $this->counter++,
            $securityAwareness->title,
            $securityAwareness->description,
            $statuses[$securityAwareness->status] . ($securityAwareness->status == 3 ? ($securityAwareness->Privacy ? " (" . $securityAwareness->Privacy->title . ")" ?? '' : '') : ''),
            $securityAwareness->created_at->format('Y-m-d H:i')
        ];
    }


    public function headings(): array
    {
        return [
            __('locale.#'),
            __('locale.Title'),
            __('locale.Description'),
            __('locale.Status'),
            __('locale.CreatedDate')
        ];
    }

    protected function getUserHaveAbilityToViewSecurityAwareness($securityAwareness, $currentUserId)
    {
        // [1 => Draft],[2=> InReview, [3 => Approved]
        if ($securityAwareness->status == 3 /*Approved*/ && $securityAwareness->privacy == 2 /*public*/) {
            return true;
        } else if (($securityAwareness->status == 2 /*InReview*/) || ($securityAwareness->status == 3 /*Approved*/ && $securityAwareness->privacy == 1 /*private*/)) {
            if (
                $currentUserId == $securityAwareness->reviewer // current user is reviewer
            ) {
                return true;
            }

            // Get users from stockholders
            $additionalStakeholders = explode(',', $securityAwareness->additional_stakeholders);

            if (in_array($currentUserId, $additionalStakeholders)) {
                return true;
            }
            unset($additionalStakeholders);

            // Get users from team
            $usersInTeams = [];
            $teams = Team::with('users:id')->whereIn('id', explode(',', $securityAwareness->team_ids))->get();
            foreach ($teams as $team) {
                foreach ($team->users as $user) {
                    array_push($usersInTeams, $user->id);
                }
            }
            unset($teams);
            if (in_array($currentUserId, $usersInTeams)) {
                return true;
            }

            return false;
        }
    }
}
