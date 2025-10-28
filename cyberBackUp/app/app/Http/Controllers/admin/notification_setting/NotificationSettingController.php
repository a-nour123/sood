<?php

namespace App\Http\Controllers\admin\notification_setting;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\AutoNotify;
use App\Models\MailAutoNotify;
use App\Models\MailSetting;
use App\Models\NotificationRole;
use App\Models\SmsSetting;
use App\Models\SystemNotificationSetting;
use App\View\Components\Admin\Notification_setting\SmsForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class NotificationSettingController extends Controller
{
    public function updateSystemNotificationSetting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'action_id' => ['required', 'exists:actions,id'], //action id that we are adding notification for
            'message' => ['required', 'string'], //message of notification
            'users' => ['required_without:roles', 'array'], //users that notification will be sent to
            'users.*' => ['exists:users,id'],
            'roles' => ['array'],
        ]);
        
        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            
            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('locale.ThereWasAProblemUpdatingSystemNotificationSetting') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();
            try {
         
                $notificationSetting = SystemNotificationSetting::UpdateOrCreate(['id' => $request->system_notification_setting_id], [
                    'action_id' => $request->action_id,
                    'message' => $request->message,
                    'status' => $request->has('status') ? true : false,
                ]);
                $notificationSetting->users()->sync($request->users);
                $notificationSetting->roles()->delete();
                if (!empty($request->roles)) {
                    foreach ($request->roles as $role) {
                        $notificationRole = new NotificationRole(['role' => $role]);
                        $notificationSetting->roles()->save($notificationRole);
                    }
                }
             


                $notificationSettingId = $notificationSetting['action_id'];
                $notificationSettingWriteLogActionName = SystemNotificationSetting::with('action')->where('action_id', $notificationSettingId)->first();                
                //log
                $message = __("locale.A system notification setting with message") . ' "' . $notificationSetting['message'] . '" ' . __("locale.in the action") . ' "' . $notificationSettingWriteLogActionName->action->name . '" ' . __("locale.was added by username") . ' "' . auth()->user()->name . '".';
                write_log($notificationSetting->id, auth()->id(), $message, 'system_notification_Setting');
             
                DB::commit();
                $notificationData = array(
                    'action_id'                      => $notificationSetting['action_id'],
                    'status'                         => $notificationSetting['status'],
                    'system_notification_setting_id' => $notificationSetting['id'],
                );
                $response = array(
                    'status'  => true,
                    'data'    => $notificationData,
                    'message' => __('locale.SystemNotificationSettingWasUpdatedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => $th->getMessage(),
                    'message' => __('locale.Error'),
                );
                return response()->json($response, 502);
            }
        }
    }

    public function updateMailSetting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'action_id' => ['required', 'exists:actions,id'], //action id that we are adding mail for
            'subject' => ['required', 'string'], //title of mail
            'body' => ['required', 'string'], //message of mail
            'users' => ['required_without:roles', 'array'], //users that mail will be sent to
            'users.*' => ['exists:users,id'],
            'roles' => ['array']
        ]);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('locale.ThereWasAProblemUpdatingMailSetting') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();
            try {

                $mailSetting = MailSetting::UpdateOrCreate(['id' => $request->mail_setting_id], [
                    'action_id' => $request->action_id,
                    'subject' => $request->subject,
                    'body' => $request->body,
                    'status' => $request->has('status') ? true : false,
                ]);
                $mailSetting->users()->sync($request->users);
                $mailSetting->roles()->delete();
                if (!empty($request->roles)) {
                    foreach ($request->roles as $role) {
                        $notificationRole = new NotificationRole(['role' => $role]);
                        $mailSetting->roles()->save($notificationRole);
                    }
                }


                $notificationSettingId = $mailSetting->action_id;
                $notificationSettingWriteLogActionName = MailSetting::with('action')->where('action_id', $notificationSettingId)->first();
                //log
                $message = __("locale.A mail setting with subject") . ' "' . $mailSetting['subject'] . '" ' . __("locale.in the action") . ' "' . $notificationSettingWriteLogActionName->action->name . '" ' . __("locale.was added by username") . ' "' . auth()->user()->name . '".';
                write_log($mailSetting->id, auth()->id(), $message, 'mail_Setting');
                //log


                DB::commit();
                $mailData = array(
                    'action_id'       => $mailSetting['action_id'],
                    'status'          => $mailSetting['status'],
                    'mail_setting_id' => $mailSetting['id'],
                );
                $response = array(
                    'status'  => true,
                    'data'    => $mailData,
                    'message' => __('locale.MailSettingWasUpdatedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => $th->getMessage(),
                    'message' => __('locale.Error'),
                );
                return response()->json($response, 502);
            }
        }
    }

    // public function updateSmsSetting(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'action_id' => ['required', 'exists:actions,id'], //action id that we are adding sms for
    //         'message' => ['required', 'string'], //title of sms
    //         'users' => ['required_without:roles', 'array'], //users that sms will be sent to
    //         'users.*' => ['exists:users,id'],
    //         'roles' => ['array']
    //     ]);

    //     // Check if there is any validation errors
    //     if ($validator->fails()) {
    //         $errors = $validator->errors()->toArray();

    //         $response = array(
    //             'status' => false,
    //             'errors' => $errors,
    //             'message' => __('locale.ThereWasAProblemUpdatingSmsSetting') . "<br>" . __('locale.Validation error'),
    //         );
    //         return response()->json($response, 422);
    //     } else {
    //         DB::beginTransaction();
    //         try {

    //             $smsSetting = SmsSetting::UpdateOrCreate(['id' => $request->sms_setting_id], [
    //                 'action_id' => $request->action_id,
    //                 'message' => $request->message,
    //                 'status' => $request->has('status') ? true : false,
    //             ]);
    //             $smsSetting->users()->sync($request->users);
    //             $smsSetting->roles()->delete();
    //             if (!empty($request->roles)) {
    //                 foreach ($request->roles as $role) {
    //                     $notificationRole = new NotificationRole(['role' => $role]);
    //                     $smsSetting->roles()->save($notificationRole);
    //                 }
    //             }

    //             //log
    //             $message = "An sms setting with message \"" . $smsSetting->message . "\" was added by username \"" . (auth()->user()->name) . "\".";
    //             write_log($smsSetting->id, auth()->id(), $message, 'sms_Setting');

    //             DB::commit();
    //             $smsData = array(
    //                 'action_id'       => $smsSetting['action_id'],
    //                 'status'          => $smsSetting['status'],
    //                 'sms_setting_id'  => $smsSetting['id'],
    //             );
    //             $response = array(
    //                 'status'  => true,
    //                 'data'    => $smsData,
    //                 'message' => __('locale.SmsSettingWasUpdatedSuccessfully'),
    //             );
    //             return response()->json($response, 200);
    //         } catch (\Throwable $th) {
    //             DB::rollBack();

    //             $response = array(
    //                 'status' => false,
    //                 'errors' => $th->getMessage(),
    //                 'message' => __('locale.Error'),
    //             );
    //             return response()->json($response, 502);
    //         }
    //     }
    // }

    public function updateAutoNotifySetting(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'action_id' => ['required', 'exists:actions,id'], //action id that we are adding sms for
            'message' => ['required', 'string'], //title of sms
            'date' => ['required'], //message of mail
            'users' => ['required_without:roles', 'array'], //users that sms will be sent to
            'users.*' => ['exists:users,id'],
            'roles' => ['array']
        ]);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('locale.ThereWasAProblemUpdatingSmsSetting') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();
            try {
                // $number = $request->input('date');
                // $currentDate = Carbon::now();
                // $resultDate = $currentDate->addDays($number)->format('Y-m-d');
            
                $AutoNOtifySetting = AutoNotify::UpdateOrCreate(['id' => $request->auto_notifies_id], [
                    'date' => json_encode($request->date),
                    'action_id' => $request->action_id,
                    'message' => $request->message,
                    'status' => $request->has('status') ? true : false,
                ]);
                $AutoNotify_id = $AutoNOtifySetting;
                $dates = json_decode($AutoNotify_id->date, true); // Decode the JSON string to an array

                $mailSetting = MailAutoNotify::UpdateOrCreate(['id' =>$AutoNotify_id->id], [
                    'action_id' =>$AutoNotify_id->action_id,
                    'subject' =>"Notify From Cyber Mode",
                    'message' => $AutoNotify_id->message,
                    'date'=>json_encode($dates),
                    'status' => $AutoNotify_id->status,
                ]);
                $AutoNOtifySetting->users()->sync($request->users);
                $AutoNOtifySetting->roles()->delete();
                if (!empty($request->roles)) {
                    foreach ($request->roles as $role) {
                        $notificationRole = new NotificationRole(['role' => $role]);
                        $AutoNOtifySetting->roles()->save($notificationRole);
                    }
                }

                $mailSetting->users()->sync($request->users);
                $mailSetting->roles()->delete();
                if (!empty($request->roles)) {
                    foreach ($request->roles as $role) {
                        $notificationRole = new NotificationRole(['role' => $role]);
                        $mailSetting->roles()->save($notificationRole);
                    }
                }

                $notificationSettingId = $mailSetting->action_id;
                $notificationSettingWriteLogActionName = AutoNotify::with('action')->where('action_id', $notificationSettingId)->first();
                //log
                $message = __("locale.An Auto notify setting with message") . ' "' . $AutoNOtifySetting['message'] . '" ' . __("locale.in the action") . ' "' . $notificationSettingWriteLogActionName->action->name . '" ' . __("locale.was added by username") . ' "' . auth()->user()->name . '".';
                write_log($AutoNOtifySetting->id, auth()->id(), $message, 'mail_Setting');
                DB::commit();
                $AutoNOtifyData = array(
                    'action_id'       => $AutoNOtifySetting['action_id'],
                    'status'          => $AutoNOtifySetting['status'],
                    'auto_notifies_id'  => $AutoNOtifySetting['id'],
                );
                $response = array(
                    'status'  => true,
                    'data'    => $AutoNOtifyData,
                    'message' => __('locale.AutoSettingWasUpdatedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => $th->getMessage(),
                    'message' => __('locale.Error'),
                );
                return response()->json($response, 502);
            }
        }
    }

    public function getSystemNotificationSetting($systemNotificationSettingId)
    {
        $systemNotificationSetting = SystemNotificationSetting::find($systemNotificationSettingId);
        if ($systemNotificationSetting) {
            $data = $systemNotificationSetting->toArray();
            $data['users'] = $systemNotificationSetting->users()->pluck('users.id')->toArray();
            $data['roles'] = $systemNotificationSetting->roles()->pluck('notifications_roles.role')->toArray();
            $response = array(
                'status' => true,
                'data' => $data,
            );
            return response()->json($response, 200);
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404'),
            );
            return response()->json($response, 404);
        }
    }

    public function getMailSetting($mailSettingId)
    {
        $mailSetting = MailSetting::find($mailSettingId);
        if ($mailSetting) {
            $data = $mailSetting->toArray();
            $data['users'] = $mailSetting->users()->pluck('users.id')->toArray();
            $data['roles'] = $mailSetting->roles()->pluck('notifications_roles.role')->toArray();
            $response = array(
                'status' => true,
                'data' => $data,
            );
            return response()->json($response, 200);
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404'),
            );
            return response()->json($response, 404);
        }
    }
    public function getSmsSetting($smsSettingId)
    {
        $smsSetting = SmsSetting::find($smsSettingId);
        if ($smsSetting) {
            $data = $smsSetting->toArray();
            $data['users'] = $smsSetting->users()->pluck('users.id')->toArray();
            $data['roles'] = $smsSetting->roles()->pluck('notifications_roles.role')->toArray();
            $response = array(
                'status' => true,
                'data' => $data,
            );
            return response()->json($response, 200);
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404'),
            );
            return response()->json($response, 404);
        }
    }


    public function getAutoNotifySetting($AutoNotifyId)
    {
        $AutoNOtifySetting = AutoNotify::find($AutoNotifyId);
        if ($AutoNOtifySetting) {
            $data = $AutoNOtifySetting->toArray();
            $data['users'] = $AutoNOtifySetting->users()->pluck('users.id')->toArray();
            $data['roles'] = $AutoNOtifySetting->roles()->pluck('notifications_roles.role')->toArray();
            $response = array(
                'status' => true,
                'data' => $data,
                'date' => json_decode($AutoNOtifySetting->date), // Decode the JSON string to an array
            );
            return response()->json($response, 200);
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404'),
            );
            return response()->json($response, 404);
        }
    }

}
