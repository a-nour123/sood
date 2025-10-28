<?php

namespace App\Http\Traits;

use App\Events\NotificationDataRealTime;
use App\Models\MailSetting;
use App\Models\SmsSetting;
use App\Models\AutoNotify;
use App\Models\MailAutoNotify;
use App\Models\SystemNotificationSetting;
use App\Models\UserToTeam;
use App\Services\Sms\SmsServiceProvider;
use App\Services\Sms\Twilio;
use App\Services\Mail\MailServiceProvider;
use App\Services\Mail\Sendgrid;
use Carbon\Carbon;
use App\Models\NotifyAtDateModel;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Notific;
use PHPMailer\PHPMailer\PHPMailer;

//this trait is used to handle the sending of different kinds of notifications

trait NotificationHandlingTrait
{


    /**
     * function to send different kinds of notifications for the action
     *
     */
    public function sendNotificationForAction($actionId1, $actionId2, $link, $model, $roles, $nextDateNotify, $modelId, $modelType,$proccess)
    {

        $this->handleSystemNotification($actionId1, $link, $model, $roles);
        $this->handleSms($actionId1, $model, $roles);
        $this->handleMail($actionId1, $model, $roles);
        $this->handleAutoNotifyBeforeDueDate($actionId2, $link, $model, $roles, $nextDateNotify, $modelId, $modelType,$proccess);
    //    $this->handleMailForAutoNotify($actionId2, $link, $model, $roles, $nextDateNotify, $modelId, $modelType);
    }

    /**
     * function to handle sending system notification for the action
     *
     */
    public function handleSystemNotification($actionId1, $link, $model = null, $roles = [])
    {
        // getting system notification settings of action
        $systemNotificationSettingOfAction = SystemNotificationSetting::where('action_id', $actionId1)->first();

        // checking if system notification is enabled for this action or not
        if ($systemNotificationSettingOfAction && $systemNotificationSettingOfAction['status']) {

            $message = $systemNotificationSettingOfAction['message'];                                                          // getting the message
            $message = $this->handleVariables($message, $model);                                                               // modifying the message with variables
            $notificationRolesInDB = $systemNotificationSettingOfAction->roles()->pluck('notifications_roles.role')->toArray();              // getting roles associated with this notification
            $notificationRecieversIds = $systemNotificationSettingOfAction->users()->pluck('users.id')->toArray();                              // getting users to recieve notification
            $receivers = $this->handleReceivers($notificationRolesInDB, $roles, $notificationRecieversIds);  // combining roles with users to get all receivers of notification

            $this->sendNotificationToArrayOfUsers($receivers, $message, $link);   // sending notification message to receivers
            broadcast(new NotificationDataRealTime($message));

        }
    }

    /**
     * function to handle sending sms for the action
     *
     */
    public function handleSms($actionId1, $model = null, $roles = [])
    {
        //getting sms settings of action
        $smsSettingOfAction = SmsSetting::where('action_id', $actionId1)->first();
        // checking if sms is enabled for this action or not
        if ($smsSettingOfAction && $smsSettingOfAction['status']) {
            $message = $smsSettingOfAction['message'];                                                     // getting the message
            $message = $this->handleVariables($message, $model);                                           // modifying the message with variables
            $notificationRolesInDB = $smsSettingOfAction->roles()->pluck('notifications_roles.role')->toArray();         // getting roles associated with this sms
            $notificationRecieversIds = $smsSettingOfAction->users()->pluck('users.id')->toArray();                         // getting users to recieve sms
            $receivers = $this->handleReceivers($notificationRolesInDB, $roles, $notificationRecieversIds);  // combining roles with users to get all receivers of sms

            $this->sendSmsToArrayOfUsers($receivers, $message);  // sending sms message to receivers
        }
    }

    /**
     * function to handle sending mail for the action
     *
     */
    public function handleMail($actionId1, $model = null, $roles = [])
    {
        //getting mail settings of action
        $mailSettingOfAction = MailSetting::where('action_id', $actionId1)->first();
        // checking if mail is enabled for this action or not
        if ($mailSettingOfAction && $mailSettingOfAction['status']) {
            $subject = $mailSettingOfAction['subject'];                                                    // getting the subject
            $body = $mailSettingOfAction['body'];                                                       // getting the body
            $subject = $this->handleVariables($subject, $model);                                           // modifying the subject with variables
            $body = $this->handleVariables($body, $model);                                              // modifying the body with variables
            $notificationRolesInDB = $mailSettingOfAction->roles()->pluck('notifications_roles.role')->toArray();        // getting roles associated with this mail
            $notificationRecieversIds = $mailSettingOfAction->users()->pluck('users.id')->toArray();                        // getting users to recieve mail
            $receivers = $this->handleReceivers($notificationRolesInDB, $roles, $notificationRecieversIds);  // combining roles with users to get all receivers of mail

            $this->sendmailToArrayOfUsers($receivers, $subject, $body); // sending mail to receivers
        }
    }

    /**
     * function to replace variables in message with their values in model
     *
    //  */
    // public function handleVariables($message, $model = null)
    // {
    //     $pattern = '/{(.*?)}/'; // Regular expression pattern to match text between {}

    //     //checking if a model as passed to compare its variables with variables of message
    //     if ($model != null) {
    //         //replacing all variables between {} in message with their equivalent variables of model "variables with the same exact name"
    //         $message = preg_replace_callback($pattern, function ($matches) use ($model) {
    //             $property = $matches[1];
    //             isset($model->$property) ? $model->$property : $matches[0];
    //         }, $message);
    //     }
    //        dd($message);

    //     return $message;
    // }

    public function handleVariables($message, $model = null)
    {
        $pattern = '/{(.*?)}/'; // Regular expression pattern to match text between {}

        //checking if a model as passed to compare its variables with variables of message
        if ($model != null) {
            //replacing all variables between {} in message with their equivalent variables of model "variables with the same exact name"
            $message = preg_replace_callback($pattern, function ($matches) use ($model) {
                $property = $matches[1];
                return isset($model[$property]) ? $model[$property] : $matches[0];
            }, $message);
        }
        // dd($message);
        return $message;
    }

    /**
     * function to specify all the receivers of notification in an array
     *
     */
    public function handleReceivers($notificationRolesInDB = [], $roles = [], $notificationRecieversIds = [])
    {
        $teams = [];
        $users = [];
        // checking if there are roles assigned to notifcation in database table 'notifications_roles'
        if (!empty($notificationRolesInDB)) {

            foreach ($notificationRolesInDB as $role) {
                //checking if the role exists in the array of roles of action to replace role with its users
                if (array_key_exists($role, $roles)) {
                    //checking if the key starts with word 'Team- or not' ,so it is teams or not
                    if (substr($role, 0, strlen('Team-')) == 'Team-') {
                        foreach ($roles[$role] as $team) {
                            $teams[] = $team;
                        }
                    } else {
                        foreach ($roles[$role] as $user) {
                            $users[] = $user;
                        }
                    }
                }
            }
        }
        if (!empty($notificationRecieversIds)) {
            foreach ($notificationRecieversIds as $notificationRecieverId) {
                $users[] = $notificationRecieverId;
            }
        }
        $teams = array_unique($teams);
        $users = array_unique($users);

        //getting users of teams
        $teamsUsersIds = $this->getUsersOfteams($teams);

        //merging arrays of users of teams and users to get all receivers and filtering the result so that every one receives the notification one time
        $finalReceivertUsersList = array_unique(array_merge($teamsUsersIds, $users));
        return $finalReceivertUsersList;
    }


    /**
     * function to get users ids of teams
     *
     */
    public function getUsersOfTeams($teams)
    {
        $UsersIDs = UserToTeam::whereIn('team_id', $teams)->pluck('user_id')->toarray();
        return $UsersIDs;
    }


    /**
     * function to send system notification to array of users
     *
     */
    public function sendNotificationToArrayOfUsers($usersIds, $message, $link)
    {
        foreach ($usersIds as $userId) {
            Notific::notify($userId, $message, 'notification', $link);
        }
    }


    /**
     * function to send sms to array of users
     *
     */
    public function sendSmsToArrayOfUsers($usersIds, $message)
    {

        foreach ($usersIds as $userId) {
            (new SmsServiceProvider)->send(new Twilio, $userId, $message);
        }
    }

    /**
     * function to send mail to array of users
     *
     */
    public function sendMailToArrayOfUsers($usersIds, $subject, $body)
    {
        foreach ($usersIds as $userId) {
            // (new MailServiceProvider)->send(new Sendgrid, $userId, $subject, $body);
            $this->sendEmail($userId, $subject, $body);
        }
    }
    public function sendEmail($userId, $subject, $body) {
        // dd($userId);

        $email_to = DB::table('users')->where('id', $userId)->value('email');
        $email_config = DB::table('email_config')->first();
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';

        try {
            $mail->isSMTP();
            $mail->isHTML(true);
            $mail->SMTPDebug = false;
            $mail->Mailer = "smtp";
            $mail->SMTPAuth = true;
            $mail->Port = $email_config->smtp_port;
            $mail->Host = $email_config->smtp_server;
            $mail->Username = $email_config->smtp_username;
            $mail->Password =   base64_decode($email_config->smtp_password);
            $mail->SMTPSecure = $email_config->ssl_tls;
            $mail->isHTML(true);
            $mail->addAddress($email_to);
            $mail->setFrom($email_config->smtp_from_username, $email_config->smtp_username);
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false
                )
            );
            if ($mail->send()) {
                $response = [
                    'status' => true,
                    'message' => __('success'),
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => __('error_occured'),
                ];
            }
        } catch (Exception $e) {
            $response = [
                'status' => false,
                'message' => __('error_occured'),
            ];
        }

        return response()->json($response, 500);
    }





    public function handleAutoNotifyBeforeDueDate($actionId2, $link, $model, $roles, $nextDateNotify, $modelId, $modelType,$proccess)
    {

        // getting system notification settings of action
        $systemNotificationSettingOfAutoNotify = AutoNotify::where('action_id', $actionId2)->first();
        $mailSettingOfAction = MailAutoNotify::where('action_id', $actionId2)->first();

        // checking if system notification is enabled for this action or not
        if ($systemNotificationSettingOfAutoNotify && $systemNotificationSettingOfAutoNotify['status']) {
            $notificationDate = $nextDateNotify;
            $today = date('Y-m-d');
            $datesNotEqualToToday = array_diff($notificationDate, [$today]);
            if (!empty($datesNotEqualToToday)) {
                // The $notificationDate array contains dates that are not equal to today
                // Run the code in the else block
                try {

                    $notification = NotifyAtDateModel::updateOrCreate(
                        ['model_id' => $modelId, 'model_type' => $modelType],
                        [
                            'model' => json_encode($model),
                            'roles' => json_encode($roles),
                            'action_id' => $actionId2,
                            'link' => json_encode($link),
                            'notification_date' => json_encode($notificationDate),
                            'model_type' => $modelType,
                            'model_id' => $modelId,
                            'proccess'=>$proccess
                        ]
                    );


                    // Other code or success message here

                } catch (\Exception $e) {
                    // Handle the error here, such as logging or displaying an error message
                    $error = $e->getMessage();
                    // dd($error);
                    // Example: return response()->json(['error' => $error], 500);
                }
            }
            if (in_array($today, $notificationDate)) {

                $message = $systemNotificationSettingOfAutoNotify['message'];
                $message = $this->handleVariables($message, $model);
                $subject = $mailSettingOfAction['subject'];

                $notificationRolesInDB = $systemNotificationSettingOfAutoNotify->roles()->pluck('notifications_roles.role')->toArray();

                $notificationRecieversIds = $systemNotificationSettingOfAutoNotify->users()->pluck('users.id')->toArray();
                $receivers = $this->handleReceivers($notificationRolesInDB, $roles, $notificationRecieversIds);
                $this->sendNotificationToArrayOfUsers($receivers, $message, $link);
                $this->sendmailToArrayOfUsers($receivers, $subject, $message);
            }
        }

    }

    // public function handleMailForAutoNotify($actionId2, $link, $model, $roles, $nextDateNotify, $modelId, $modelType)
    // {
    //     // getting system notification settings of action
    //     $mailSettingOfAction = MailAutoNotify::where('action_id', $actionId2)->first();

    //     // checking if system notification is enabled for this action or not
    //     if ($mailSettingOfAction && $mailSettingOfAction['status'] == 1) {

    //         $notificationDate = $nextDateNotify;
    //         $today = date('Y-m-d');
    //         if (in_array($today, $notificationDate)) {

    //             $message = $mailSettingOfAction['message'];
    //             $message = $this->handleVariables($message, $model);
    //             $subject = $mailSettingOfAction['subject'];
    //             // getting the subject
    //             // $body = $this->handleVariables($message, $model);
    //             $notificationRolesInDB = $mailSettingOfAction->roles()->pluck('notifications_roles.role')->toArray();
    //             // getting roles associated with this mail
    //             $notificationRecieversIds = $mailSettingOfAction->users()->pluck('users.id')->toArray();                        // getting users to recieve mail

    //             $receivers = $this->handleReceivers($notificationRolesInDB, $roles, $notificationRecieversIds);  // combining roles with users to get all receivers of mail
    //             $this->sendmailToArrayOfUsers($receivers, $subject, $message); // sending mail to receivers

    //         }
    //     }
    // }


        // public function handleAutoNotify($actionId2, $link, $model = null, $roles = [],$nextDateNotify)
    // {
    //     // getting system notification settings of action
    //     $systemNotificationSettingOfAutoNotify = AutoNotify::where('action_id', $actionId2)->first();
    //     // checking if system notification is enabled for this action or not
    //     if ($systemNotificationSettingOfAutoNotify && $systemNotificationSettingOfAutoNotify['status']) {
    //         $notificationDate = $nextDateNotify;
    //         $today = date('Y-m-d');

    //         if ($notificationDate == $today) {
    //             $message = $systemNotificationSettingOfAutoNotify['message'];
    //             $message = $this->handleVariables($message, $model);
    //             $notificationRolesInDB = $systemNotificationSettingOfAutoNotify->roles()->pluck('notifications_roles.role')->toArray();
    //             $notificationRecieversIds = $systemNotificationSettingOfAutoNotify->users()->pluck('users.id')->toArray();
    //             $receivers = $this->handleReceivers($notificationRolesInDB, $roles, $notificationRecieversIds);

    //             $this->sendNotificationToArrayOfUsers($receivers, $message, $link);
    //         }
    //     }
    // }

}
