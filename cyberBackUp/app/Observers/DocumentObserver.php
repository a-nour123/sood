<?php

namespace App\Observers;

use App\Models\Document;
use App\Models\Team;
use App\Models\User;
use Technovistalimited\Notific\Notific;

class DocumentObserver
{
    // [1] => "Draft";
    // [2] => "InReview";
    // [3] => "Approved";

    /**
     * Handle the Document "created" event.
     *
     * @param  \App\Models\Document  $document
     * @return void
     */
    public function created(Document $document)
    {
        $users = [];

        if ($document->document_status == 1 && $document->document_owner != $document->created_by) { // Draft (Send notification to owner if owner isn't the creator)
            $message = ' create a new document (' . $document->document_name . ') and you are the owner';
            Notific::notify(
                [$document->document_owner],
                'Employee ' . $document->created_by_user->name . $message,
                'notification',
                ['link' => route('admin.governance.category')],
                date('d F Y')
            );
        } else if ($document->document_status == 2) { // InReview (Send notification to reviewer, stockholder and team members)
            if ($document->document_owner != $document->created_by) { // Owner notification
                $message = ' create a new document (' . $document->document_name . ') and you are the owner';
                Notific::notify(
                    [$document->document_owner],
                    'Employee ' . $document->created_by_user->name . $message,
                    'notification',
                    ['link' => route('admin.governance.category')],
                    date('d F Y')
                );
            }

            $message = ' create a new document (' . $document->document_name . ') and you are the reviewer';
            Notific::notify(
                [$document->document_reviewer],
                'Employee ' . $document->created_by_user->name . $message,
                'notification',
                ['link' => route('admin.governance.category')],
                date('d F Y')
            );

            $users = $this->getUsersToNotifyAboutDocument($document, [$document->document_owner, $document->created_by, $document->document_reviewer]);
        } else if ($document->document_status == 3) { // Approved (Depend on privacy if public send notification for all users otherwise send to reviewer, stockholder and team members)
            if ($document->document_owner != $document->created_by) { // Owner notification
                $message = ' create a new document (' . $document->document_name . ') and you are the owner';
                Notific::notify(
                    [$document->document_owner],
                    'Employee ' . $document->created_by_user->name . $message,
                    'notification',
                    ['link' => route('admin.governance.category')],
                    date('d F Y')
                );
            }

            $users = $this->getUsersToNotifyAboutDocument($document, [$document->document_owner, $document->created_by, $document->document_reviewer]);
        }

        logger(json_encode($users, JSON_PRETTY_PRINT));

        $message = ' create a new document (' . $document->document_name . ')';
        Notific::notify(
            $users,
            'Employee ' . $document->created_by_user->name . $message,
            'notification',
            ['link' => route('admin.governance.category')],
            date('d F Y')
        );
    }


    /**
     * Handle the Document "updating" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updating(Document $document)
    {
        if ($document->isDirty()) {

            $notifiedUsers = [];
            // Update reviewer
            if ($document->isDirty('document_reviewer')) { // Notify document new reviewer
                $message = ' assign document reviewing (' . $document->document_name . ') to you';
                Notific::notify(
                    [$document->document_reviewer],
                    'Employee ' . $document->owned_by_user->name . $message,
                    'notification',
                    ['link' => route('admin.governance.category')],
                    date('d F Y')
                );
                array_push($notifiedUsers, $document->document_reviewer);
            }

            // Update teams
            if ($document->isDirty('team_ids')) { // Notify document new teams
                $old_document_teams = explode(',', $document->getOriginal('team_ids'));
                $new_document_teams = explode(',', $document->team_ids);
                $newTeams = array_diff($new_document_teams, $old_document_teams);
                $message = ' allow access document (' . $document->document_name . ') to you';

                $usersInTeams = [];
                $teams = Team::with('users:id')->whereIn('id', $newTeams)->get();
                foreach ($teams as $team) {
                    $usersInTeams = array_merge($usersInTeams, $team->users()->pluck('user_id')->toArray());
                }

                $usersInTeams = array_unique($usersInTeams); // remove duplicated users
                $usersInTeams = array_diff($usersInTeams, $notifiedUsers); // remove previous notified users

                Notific::notify(
                    $usersInTeams,
                    'Employee ' . $document->owned_by_user->name . $message,
                    'notification',
                    ['link' => route('admin.governance.category')],
                    date('d F Y')
                );

                $notifiedUsers = array_merge($notifiedUsers, $usersInTeams);
            }

            // Update additional_stakeholders
            if ($document->isDirty('additional_stakeholders')) { // Notify document new additional_stakeholders
                $old_document_additional_stakeholders = explode(',', $document->getOriginal('additional_stakeholders'));
                $new_document_additional_stakeholders = explode(',', $document->additional_stakeholders);
                $newAdditionalStakeholders = array_diff($new_document_additional_stakeholders, $old_document_additional_stakeholders);
                $message = ' allow access document (' . $document->document_name . ') to you';

                $usersInadditionalStakeholders = $newAdditionalStakeholders;

                $usersInadditionalStakeholders = array_diff($usersInadditionalStakeholders, $notifiedUsers); // remove previous notified users

                Notific::notify(
                    $usersInadditionalStakeholders,
                    'Employee ' . $document->owned_by_user->name . $message,
                    'notification',
                    ['link' => route('admin.governance.category')],
                    date('d F Y')
                );

                $notifiedUsers = array_merge($notifiedUsers, $usersInadditionalStakeholders);
            }

            if ($document->isDirty('document_status')) { // Notify document status change
                // to draft notify current
                $statuses = [];
                $statuses[1] = "Draft";
                $statuses[2] = "InReview";
                $statuses[3] = "Approved";

                $old_document_status = $document->getOriginal('document_status');
                $new_document_status = $document->document_status;
                $users = [];

                $message = ' update status of document (' . $document->document_name . ') from ' . $statuses[$old_document_status] . ' to ' . $statuses[$new_document_status];

                if ($old_document_status == 1 /*Draft*/ && $new_document_status == 2 /*InReview*/) {
                    $users = [$document->document_reviewer];
                } else if ($old_document_status == 1 /*Draft*/ && $new_document_status == 3 /*Approved*/) {
                    $expliciteUsers = [$document->document_owner, $document->document_reviewer];
                    $users = $this->getUsersToNotifyAboutDocument($document, $expliciteUsers);
                } else if ($old_document_status == 2 /*InReview*/ && $new_document_status == 1 /*Draft*/) {
                    $expliciteUsers = [$document->document_owner, $document->document_reviewer];
                    $users = $this->getUsersToNotifyAboutDocument($document, $expliciteUsers, $old_document_status); // Simulate as old status to get users old status
                } else if ($old_document_status == 2 /*InReview*/ && $new_document_status == 3 /*Approved*/) {
                    $expliciteUsers = [$document->document_owner, $document->document_reviewer];
                    $users = $this->getUsersToNotifyAboutDocument($document, $expliciteUsers, $old_document_status);
                } else if ($old_document_status == 3 /*Approved*/ && $new_document_status == 1 /*Draft*/) {
                    $expliciteUsers = [$document->document_owner, $document->document_reviewer];
                    $users = $this->getUsersToNotifyAboutDocument($document, $expliciteUsers, $old_document_status); // Simulate as old status to get users old status
                } else if ($old_document_status == 3 /*Approved*/ && $new_document_status == 2 /*InReview*/) {
                    $expliciteUsers = [$document->document_owner, $document->document_reviewer];
                    $users = $this->getUsersToNotifyAboutDocument($document, $expliciteUsers, $old_document_status); // Simulate as old status to get users old status
                }

                Notific::notify(
                    $users,
                    'Employee ' . $document->owned_by_user->name . $message,
                    'notification',
                    ['link' => route('admin.governance.category')],
                    date('d F Y')
                );
            }
        }
    }
    /**
     * Handle the Document "updated" event.
     *
     * @param  \App\Models\Document  $document
     * @return void
     */
    public function updated(Document $document)
    {
        //
    }

    /**
     * Handle the Document "deleted" event.
     *
     * @param  \App\Models\Document  $document
     * @return void
     */
    public function deleted(Document $document)
    {
        //
    }

    /**
     * Handle the Document "restored" event.
     *
     * @param  \App\Models\Document  $document
     * @return void
     */
    public function restored(Document $document)
    {
        //
    }

    /**
     * Handle the Document "force deleted" event.
     *
     * @param  \App\Models\Document  $document
     * @return void
     */
    public function forceDeleted(Document $document)
    {
        //
    }
    protected function getUsersToNotifyAboutDocument($document, $expliciteUsers, $status = null)
    {
        if (is_null($status))
            $status = $document->document_status;

        // [1 => Draft],[2=> InReview, [3 => Approved]
        if ($status == 3 /*Approved*/ && $document->privacy == 2 /*public*/) {
            return User::whereNotIn('id', $expliciteUsers)->pluck('id')->toArray();
        } else if (($status == 2 /*InReview*/) || ($status == 3 /*Approved*/ && $document->privacy == 1 /*private*/)) { // (InReview || Approved && private)  users will be reviewer, stockholder and team members
            // Get users from stockholders
            $additionalStakeholders = explode(',', $document->additional_stakeholders);

            // Get users from team
            $usersInTeams = [];
            $teams = Team::with('users:id')->whereIn('id', explode(',', $document->team_ids))->get();
            foreach ($teams as $team) {
                $usersInTeams = array_merge($usersInTeams, $team->users()->pluck('user_id')->toArray());
            }

            return array_diff(array_unique(array_merge($additionalStakeholders, $usersInTeams)), $expliciteUsers);
        }
    }
}
