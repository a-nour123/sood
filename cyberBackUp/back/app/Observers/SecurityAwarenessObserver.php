<!-- <?php

namespace App\Observers;

use App\Models\SecurityAwareness;
use App\Models\Team;
use App\Models\User;
use Technovistalimited\Notific\Notific;

class SecurityAwarenessObserver
{
    // [1] => "Draft";
    // [2] => "InReview";
    // [3] => "Approved";

    /**
     * Handle the SecurityAwareness "created" event.
     *
     * @param  \App\Models\SecurityAwareness  $securityAwareness
     * @return void
     */
    public function created(SecurityAwareness $securityAwareness)
    {
        // $securityAwareness->exam()->create(); // create exam for security awareness
        $users = [];

        if ($securityAwareness->status == 1 && $securityAwareness->owner != $securityAwareness->created_by) { // Draft (Send notification to owner if owner isn't the creator)
            $message = ' create a new security awareness (' . $securityAwareness->title . ') and you are the owner';
            Notific::notify(
                [$securityAwareness->owner],
                'Employee ' . $securityAwareness->created_by_user->name . $message,
                'notification',
                ['link' => route('admin.security_awareness.index')],
                date('d F Y')
            );
        } else if ($securityAwareness->status == 2) { // InReview (Send notification to reviewer, stockholder and team members)
            if ($securityAwareness->owner != $securityAwareness->created_by) { // Owner notification
                $message = ' create a new security awareness (' . $securityAwareness->title . ') and you are the owner';
                Notific::notify(
                    [$securityAwareness->owner],
                    'Employee ' . $securityAwareness->created_by_user->name . $message,
                    'notification',
                    ['link' => route('admin.security_awareness.index')],
                    date('d F Y')
                );
            }

            $message = ' create a new security awareness (' . $securityAwareness->title . ') and you are the reviewer';
            Notific::notify(
                [$securityAwareness->reviewer],
                'Employee ' . $securityAwareness->created_by_user->name . $message,
                'notification',
                ['link' => route('admin.security_awareness.index')],
                date('d F Y')
            );

            $users = $this->getUsersToNotifySecurityAwareness($securityAwareness, [$securityAwareness->owner, $securityAwareness->created_by, $securityAwareness->reviewer], $securityAwareness->status);
        } else if ($securityAwareness->status == 3) { // Approved (Depend on privacy if public send notification for all users otherwise send to reviewer, stockholder and team members)
            if ($securityAwareness->owner != $securityAwareness->created_by) { // Owner notification
                $message = ' create a new security awareness (' . $securityAwareness->title . ') and you are the owner';
                Notific::notify(
                    [$securityAwareness->owner],
                    'Employee ' . $securityAwareness->created_by_user->name . $message,
                    'notification',
                    ['link' => route('admin.security_awareness.index')],
                    date('d F Y')
                );
            }

            $users = $this->getUsersToNotifySecurityAwareness($securityAwareness, [$securityAwareness->owner, $securityAwareness->created_by, $securityAwareness->reviewer], $securityAwareness->status);
        }

        logger(json_encode($users, JSON_PRETTY_PRINT));

        $message = ' create a new security awareness (' . $securityAwareness->title . ')';
        Notific::notify(
            $users,
            'Employee ' . $securityAwareness->created_by_user->name . $message,
            'notification',
            ['link' => route('admin.security_awareness.index')],
            date('d F Y')
        );
    }


    /**
     * Handle the SecurityAwareness "updating" event.

     *
     * @param  \App\User  $user
     * @return void
     */
    public function updating(SecurityAwareness $securityAwareness)
    {
        if ($securityAwareness->isDirty()) {

            $notifiedUsers = [];
            // Update reviewer
            if ($securityAwareness->isDirty('reviewer')) { // Notify security awareness new reviewer
                $message = ' assign security awareness reviewing (' . $securityAwareness->title . ') to you';
                Notific::notify(
                    [$securityAwareness->reviewer],
                    'Employee ' . $securityAwareness->owned_by_user->name . $message,
                    'notification',
                    ['link' => route('admin.security_awareness.index')],
                    date('d F Y')
                );
                array_push($notifiedUsers, $securityAwareness->reviewer);
            }

            // Update teams
            if ($securityAwareness->isDirty('team_ids')) { // Notify security awareness new teams
                $old_security_awareness_teams = explode(',', $securityAwareness->getOriginal('team_ids'));
                $new_security_awareness_teams = explode(',', $securityAwareness->team_ids);
                $newTeams = array_diff($new_security_awareness_teams, $old_security_awareness_teams);
                $message = ' allow access security awareness (' . $securityAwareness->title . ') to you';

                $usersInTeams = [];
                $teams = Team::with('users:id')->whereIn('id', $newTeams)->get();
                foreach ($teams as $team) {
                    $usersInTeams = array_merge($usersInTeams, $team->users()->pluck('user_id')->toArray());
                }

                $usersInTeams = array_unique($usersInTeams); // remove duplicated users
                $usersInTeams = array_diff($usersInTeams, $notifiedUsers); // remove previous notified users

                Notific::notify(
                    $usersInTeams,
                    'Employee ' . $securityAwareness->owned_by_user->name . $message,
                    'notification',
                    ['link' => route('admin.security_awareness.index')],
                    date('d F Y')
                );

                $notifiedUsers = array_merge($notifiedUsers, $usersInTeams);
            }

            // Update additional_stakeholders
            if ($securityAwareness->isDirty('additional_stakeholders')) { // Notify security awareness new additional_stakeholders
                $old_security_awareness_additional_stakeholders = explode(',', $securityAwareness->getOriginal('additional_stakeholders'));
                $new_security_awareness_additional_stakeholders = explode(',', $securityAwareness->additional_stakeholders);
                $newAdditionalStakeholders = array_diff($new_security_awareness_additional_stakeholders, $old_security_awareness_additional_stakeholders);
                $message = ' allow access security awareness (' . $securityAwareness->title . ') to you';

                $usersInadditionalStakeholders = $newAdditionalStakeholders;

                $usersInadditionalStakeholders = array_diff($usersInadditionalStakeholders, $notifiedUsers); // remove previous notified users

                Notific::notify(
                    $usersInadditionalStakeholders,
                    'Employee ' . $securityAwareness->owned_by_user->name . $message,
                    'notification',
                    ['link' => route('admin.security_awareness.index')],
                    date('d F Y')
                );

                $notifiedUsers = array_merge($notifiedUsers, $usersInadditionalStakeholders);
            }

            if ($securityAwareness->isDirty('status')) { // Notify security awareness status change
                // to draft notify current
                $statuses = [];
                $statuses[1] = "Draft";
                $statuses[2] = "InReview";
                $statuses[3] = "Approved";

                $old_status = $securityAwareness->getOriginal('status');
                $new_status = $securityAwareness->status;
                $users = [];

                $message = ' update status of security awareness (' . $securityAwareness->title . ') from ' . $statuses[$old_status] . ' to ' . $statuses[$new_status];

                if ($old_status == 1 /*Draft*/ && $new_status == 2 /*InReview*/) {
                    $users = [$securityAwareness->reviewer];
                } else if ($old_status == 1 /*Draft*/ && $new_status == 3 /*Approved*/) {
                    $expliciteUsers = [$securityAwareness->owner, $securityAwareness->reviewer];
                    $users = $this->getUsersToNotifySecurityAwareness($securityAwareness, $expliciteUsers, $securityAwareness->status);
                } else if ($old_status == 2 /*InReview*/ && $new_status == 1 /*Draft*/) {
                    // $securityAwareness->old_status = $old_status; // Simulate as old status to get users old status
                    $expliciteUsers = [$securityAwareness->owner, $securityAwareness->reviewer];
                    $users = $this->getUsersToNotifySecurityAwareness($securityAwareness, $expliciteUsers, $old_status);
                } else if ($old_status == 2 /*InReview*/ && $new_status == 3 /*Approved*/) {
                    $expliciteUsers = [$securityAwareness->owner, $securityAwareness->reviewer];
                    $users = $this->getUsersToNotifySecurityAwareness($securityAwareness, $expliciteUsers, $securityAwareness->status);
                } else if ($old_status == 3 /*Approved*/ && $new_status == 1 /*Draft*/) {
                    // $securityAwareness->old_status = $old_status; // Simulate as old status to get users old status
                    $expliciteUsers = [$securityAwareness->owner, $securityAwareness->reviewer];
                    $users = $this->getUsersToNotifySecurityAwareness($securityAwareness, $expliciteUsers, $old_status);
                } else if ($old_status == 3 /*Approved*/ && $new_status == 2 /*InReview*/) {
                    // $securityAwareness->old_status = $old_status; // Simulate as old status to get users old status
                    $expliciteUsers = [$securityAwareness->owner, $securityAwareness->reviewer];
                    $users = $this->getUsersToNotifySecurityAwareness($securityAwareness, $expliciteUsers, $old_status);
                }

                Notific::notify(
                    $users,
                    'Employee ' . $securityAwareness->owned_by_user->name . $message,
                    'notification',
                    ['link' => route('admin.security_awareness.index')],
                    date('d F Y')
                );
            }
        }
    }

    /**
     * Handle the SecurityAwareness "updated" event.
     *
     * @param  \App\Models\SecurityAwareness  $securityAwareness
     * @return void
     */
    public function updated(SecurityAwareness $securityAwareness)
    {
        //
    }

    /**
     * Handle the SecurityAwareness "deleted" event.
     *
     * @param  \App\Models\SecurityAwareness  $securityAwareness
     * @return void
     */
    public function deleted(SecurityAwareness $securityAwareness)
    {
        //
    }

    /**
     * Handle the SecurityAwareness "restored" event.
     *
     * @param  \App\Models\SecurityAwareness  $securityAwareness
     * @return void
     */
    public function restored(SecurityAwareness $securityAwareness)
    {
        //
    }

    /**
     * Handle the SecurityAwareness "force deleted" event.
     *
     * @param  \App\Models\SecurityAwareness  $securityAwareness
     * @return void
     */
    public function forceDeleted(SecurityAwareness $securityAwareness)
    {
        //
    }

    protected function getUsersToNotifySecurityAwareness($securityAwareness, $expliciteUsers, $securityAwarenessStatus)
    {
        // [1 => Draft],[2=> InReview, [3 => Approved]
        if ($securityAwarenessStatus == 3 /*Approved*/ && $securityAwareness->privacy == 2 /*public*/) {
            return User::whereNotIn('id', $expliciteUsers)->pluck('id')->toArray();
        } else if (($securityAwarenessStatus == 2 /*InReview*/) || ($securityAwarenessStatus == 3 /*Approved*/ && $securityAwareness->privacy == 1 /*private*/)) { // (InReview || Approved && private)  users will be reviewer, stockholder and team members
            // Get users from stockholders
            $additionalStakeholders = explode(',', $securityAwareness->additional_stakeholders);

            // Get users from team
            $usersInTeams = [];
            $teams = Team::with('users:id')->whereIn('id', explode(',', $securityAwareness->team_ids))->get();
            foreach ($teams as $team) {
                $usersInTeams = array_merge($usersInTeams, $team->users()->pluck('user_id')->toArray());
            }

            return array_diff(array_unique(array_merge($additionalStakeholders, $usersInTeams)), $expliciteUsers);
        }
    }
} -->
