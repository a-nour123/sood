<?php

namespace App\Console\Commands;

use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Asset;
use App\Models\AuditDocumentPolicy;
use App\Models\AuditDocumentPolicyStatus;
use App\Models\AutoNotify;
use App\Models\DocumentPolicy;
use App\Models\MailAutoNotify;
use App\Models\NotifyAtDateModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EsclationAuditeesDocumentAudit extends Command
{
    use NotificationHandlingTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'EsclationAuditeesDocumentAudit';
    protected $description = 'Check the EsclationAuditeesDocumentAudit Action';

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

        // Fetch audit IDs that exist in NotifyAtDateModel for today
        $notifiedAuditIds = NotifyAtDateModel::whereJsonContains('notification_date', $today)
            ->where('model_type', 'Audit_Policy_Skip_Due_Date')
            ->pluck('model_id')
            ->toArray();

        // Get all AuditDocumentPolicy records that exist in NotifyAtDateModel
        $allAuditsDocument = AuditDocumentPolicy::whereIn('id', $notifiedAuditIds)
            ->where('due_date', '<', $today)
            ->where('enable_audit', 1)
            ->get();

        foreach ($allAuditsDocument as $audit) {

            $responsibleIds = explode(',', $audit->responsible);

            $allDocumentPolicy = DB::table('audit_document_policy_policy_document')
                ->where('audit_document_policy_id', $audit->id)
                ->pluck('policy_document_id')
                ->toArray();

            $documentPolicy = DocumentPolicy::whereIn('policy_id', $allDocumentPolicy)
                ->pluck('id')
                ->toArray();

            foreach ($responsibleIds as $responsible) {
                $allstatusTake = AuditDocumentPolicyStatus::where('aduit_id', $audit->id)
                    ->where('user_id', $responsible)
                    ->whereIn('document_policy_id', $documentPolicy)
                    ->get();

                if ($allstatusTake->count() <= count($documentPolicy)) {
                    $notification = NotifyAtDateModel::where('model_type', 'Audit_Policy_Skip_Due_Date')
                        ->where('model_id', $audit->id)
                        ->first();

                    if ($notification) {
                        $model = json_decode($notification->model, true);
                        $manager = User::where('id', $responsible)->first()->manager_id ?? '';
                        $roles = array_merge([$responsible], [$manager]);

                        $this->handleAutoNotifyBeforeDueDate(
                            $notification->action_id,
                            $notification->link,
                            $model,
                            $roles
                        );
                    } else {
                        Log::warning("No notification found for Audit ID: {$audit->id}");
                    }
                }
            }
        }
    }

    private function handleAutoNotifyBeforeDueDate($actionId2, $link, $model, $roles)
    {
        // getting system notification settings of action
        $systemNotificationSettingOfAutoNotify = AutoNotify::where('action_id', $actionId2)->first();
        $mailSettingOfAction = MailAutoNotify::where('action_id', $actionId2)->first();

        if ($systemNotificationSettingOfAutoNotify && $systemNotificationSettingOfAutoNotify['status']) {
            $message = $systemNotificationSettingOfAutoNotify['message'];

            $message = $this->handleVariables($message, $model);

            $subject = $mailSettingOfAction['subject'];

            // getting users to receive notification
            $notificationRecieversIds = $roles;
            $receivers = $this->handleReceivers($notificationRolesInDB = [], $roles = [], $notificationRecieversIds);
            // Pass link as an array to notification and email functions
            $this->sendNotificationToArrayOfUsers($receivers, $message, $link);
            $this->sendmailToArrayOfUsers($receivers, $subject, $message, ['link' => $link]);
        }
    }
}
