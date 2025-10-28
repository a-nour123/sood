<?php

namespace App\Repositories\Admin\Phishing;

use App\Interfaces\Admin\Phishing\PhishingDashboardInterface;
use App\Models\LMSCourse;
use App\Models\LMSTrainingModule;
use App\Models\PhishingCampaign;
use App\Models\PhishingDomains;
use App\Models\PhishingGroup;
use App\Models\PhishingTemplate;
use App\Models\PhishingWebsitePage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PhishingDashboardRepository implements PhishingDashboardInterface
{
    public function index()
    {
        $breadcrumbs = [
            ['link' => route('admin.phishing.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.phishing.campaign.index'), 'name' => __('phishing.campaign')],
            ['name' => __('phishing.campaign_pdf')],
        ];
        $websites = PhishingWebsitePage::withoutTrashed()->count();

        // $campaigns = PhishingCampaign::withoutTrashed()->count();
        // $phishingCampaigns = PhishingCampaign::withoutTrashed()->where('campaign_type','simulated_phishing')->count();
        // $awarenessCampaigns = PhishingCampaign::withoutTrashed()->where('campaign_type','security_awareness')->count();
        // $pendingCampaigns = PhishingCampaign::withoutTrashed()->where('approve',0)->count();
        // $approveCampaigns = PhishingCampaign::withoutTrashed()->where('approve',1)->count();
        // $scheduledCampaigns = PhishingCampaign::withoutTrashed()->where('delivery_type','setup')->count();


        $campaigns_count = PhishingCampaign::withoutTrashed()->count();
        $campaigns_approve = PhishingCampaign::withoutTrashed()->where('campaign_type','simulated_phishing')->where('approve',1)->count();
        $campaigns_pending = PhishingCampaign::withoutTrashed()->where('campaign_type','simulated_phishing')->where('approve',0)->count();
        $campaigns_complete = PhishingCampaign::withoutTrashed()->where('campaign_type','simulated_phishing')->where('delivery_status',1)->count();
        $campaigns_later = PhishingCampaign::withoutTrashed()->where('campaign_type','simulated_phishing')->where('delivery_type','later')->where('approve',0)->count();


        $now = Carbon::now();
        $campaigns_soon = PhishingCampaign::withoutTrashed()
        ->where('campaign_type','simulated_phishing')
        ->where('delivery_type', 'setup')
        ->where(function ($query) use ($now) {
            $query->where('schedule_date_from', '>', $now->toDateString())
                ->orWhere(function ($query) use ($now) {
                    $query->where('schedule_date_from', '=', $now->toDateString())
                          ->where('schedule_time_from', '>', $now->toTimeString());
                });
        })
        ->count();


        $mailTemplates = PhishingTemplate::withoutTrashed()->count();
        $employees = DB::table('phishing_campaign_employee_list')->distinct('employee_id')->count('employee_id');
        $top_phished_employees = $this->getTopPhisedEmployee();

        $phishingemployees = DB::table('phishing_campaign_employee_list')->distinct('employee_id')->count('employee_id');
        $trainingemployees = DB::table('l_m_s_user_training_modules')->distinct('user_id')->count('user_id');
        $allTargetedEmployees = $phishingemployees + $trainingemployees;

        // dd($top_phished_employees[0]);

        $courses = LMSCourse::withoutTrashed()->count();
        $trainings = LMSTrainingModule::withoutTrashed()->count();

        // Mail statistics
        $mail_statistic = PhishingTemplate::withoutTrashed()
        ->with(['campaignes' => function ($query) {
            $query->withCount('deliverdEmployees');
        }])
        ->withCount('openedMails','clickedOnLink','submitedDataInMails','downloadedFileInMails','mailTracking')->get();
        $email_labels = $mail_statistic->pluck('name');
        $opened_mails_count = $mail_statistic->pluck('opened_mails_count');
        $clicked_link_count = $mail_statistic->pluck('clicked_on_link_count');
        $submited_data_in_mails_count = $mail_statistic->pluck('submited_data_in_mails_count');
        $downloaded_file_in_mails_count = $mail_statistic->pluck('downloaded_file_in_mails_count');
        $employee_count = $mail_statistic->map(function ($template) {
            return $template->campaignes->sum('deliverd_employees_count');
        });

        // Training Statistic
        $trainings_statistic = $this->getTrainingStatistics();
        $training_labels = $trainings_statistic->pluck('month');
        $training_total_recieved_users = $trainings_statistic->pluck('total_recieved_users');
        $training_total_passed_users = $trainings_statistic->pluck('total_passed_users');
        $training_total_failed_users = $trainings_statistic->pluck('total_failed_users');
        $training_total_overdue_users = $trainings_statistic->pluck('total_overdue_users');

        return view('admin.content.phishing.dashboard.index', get_defined_vars());
    }

    public function getMailStatistic()
    {
        return DB::table('phishing_mail_trackings')
            ->selectRaw("
                DATE_FORMAT(created_at, '%b \'%y') as month,
                COUNT(CASE WHEN Page_link_clicked_at IS NOT NULL THEN 1 END) AS clicked_link,
                COUNT(CASE WHEN opened_at IS NOT NULL THEN 1 END) AS mails_opened,
                COUNT(CASE WHEN submited_at IS NOT NULL THEN 1 END) AS mails_submitted,
                COUNT(CASE WHEN downloaded_at IS NOT NULL THEN 1 END) AS mails_downloaded
            ")
            ->where(function($query) {
                $query->whereNotNull('opened_at')->orWhereNotNull('submited_at')->orWhereNotNull('downloaded_at');
            })
            ->groupBy('month')
            ->orderBy(DB::raw("STR_TO_DATE(month, '%b \'%y')"), 'ASC')
            ->get();
    }

    public function getTopPhisedEmployee()
    {
        return DB::table('phishing_mail_trackings')
            ->join('users', 'phishing_mail_trackings.employee_id', '=', 'users.id')
            ->select(
                'phishing_mail_trackings.employee_id',
                'users.name','users.email',
                DB::raw('
                    COUNT(*) as total_rows,
                    SUM(
                        CASE
                            WHEN opened_at IS NOT NULL AND submited_at IS NOT NULL AND downloaded_at IS NOT NULL AND Page_link_clicked_at IS NOT NULL THEN 100
                            ELSE
                                (CASE WHEN opened_at IS NOT NULL THEN 25 ELSE 0 END) +
                                (CASE WHEN submited_at IS NOT NULL THEN 25 ELSE 0 END) +
                                (CASE WHEN Page_link_clicked_at IS NOT NULL THEN 25 ELSE 0 END) +
                                (CASE WHEN downloaded_at IS NOT NULL THEN 25 ELSE 0 END)
                        END
                    ) AS total_points
                ')
            )
            ->groupBy('phishing_mail_trackings.employee_id')
            ->orderByDesc('total_points')
            ->limit(5)
            ->get()
            ->map(function ($employee) {
                // $maxPossiblePoints = $employee->total_rows * 250;
                // $employee->average_percentage = number_format(($employee->total_points / $maxPossiblePoints) * 100,2);

                $maxPossiblePoints = $employee->total_rows * 100;
                $employee->average_percentage = number_format(($employee->total_points / $maxPossiblePoints) * 100,2);
                return $employee;
            })
            ->sortByDesc('average_percentage')
            ->values()
            ->take(5);

    }


    public function getPhisedEmployee()
    {
        return DB::table('phishing_mail_trackings')
            ->join('users', 'phishing_mail_trackings.employee_id', '=', 'users.id')
            ->select(
                'phishing_mail_trackings.employee_id',
                'users.name','users.email',
                DB::raw('
                    COUNT(*) as total_rows,
                    SUM(
                        CASE
                            WHEN opened_at IS NOT NULL AND submited_at IS NOT NULL AND downloaded_at IS NOT NULL AND Page_link_clicked_at IS NOT NULL THEN 100
                            ELSE
                                (CASE WHEN opened_at IS NOT NULL THEN 25 ELSE 0 END) +
                                (CASE WHEN submited_at IS NOT NULL THEN 25 ELSE 0 END) +
                                (CASE WHEN Page_link_clicked_at IS NOT NULL THEN 25 ELSE 0 END) +
                                (CASE WHEN downloaded_at IS NOT NULL THEN 25 ELSE 0 END)
                        END
                    ) AS total_points
                ')
            )
            ->groupBy('phishing_mail_trackings.employee_id')
            ->orderByDesc('total_points')
            ->get()
            ->map(function ($employee) {
                $maxPossiblePoints = $employee->total_rows * 100;
                $employee->average_percentage = number_format(($employee->total_points / $maxPossiblePoints) * 100,2);
                return $employee;
            })
            ->sortByDesc('average_percentage')
            ->values();
    }

    public function reporting()
    {
        $breadcrumbs = [
            ['link' => route('admin.phishing.dashboard'), 'name' => __('locale.Dashboard')],
        ];
        $campaigns = PhishingCampaign::withoutTrashed()->count();
        $mailTemplates = PhishingTemplate::withoutTrashed()->count();

        // **************************** Mail statistics *******************************
        $mail_statistic = $this->getMailStatistic();
        $labels = $mail_statistic->pluck('month');
        $opened_count = $mail_statistic->pluck('mails_opened');
        $clicked_link_count = $mail_statistic->pluck('clicked_link');
        $submited_count = $mail_statistic->pluck('mails_submitted');
        $downloaded_count = $mail_statistic->pluck('mails_downloaded');

        $activeCampaigns = $this->getActiveCampaignMailStatistic();
        $archivedCampaigns =  $this->getArchivedCampaignMailStatistic();


        // ************************* Campaign statistics *********************************
        $campaignChart = PhishingCampaign::where("campaign_type","simulated_phishing")->withoutTrashed()
        ->withCount(
'deliverdEmailTemplates','deliverdEmployees','notDeliverdEmailTemplates',
            'notDeliverdEmployees', 'openedTrackings','downloadedTrackings',
            'clickedTrackings','submittedTrackings'
        )->get();

        $campaig_labels = $campaignChart->pluck('campaign_name');
        $deliverd_email_templates_count = $campaignChart->pluck('deliverd_email_templates_count');
        $deliverd_employees_count = $campaignChart->pluck('deliverd_employees_count');
        $not_deliverd_email_templates_count = $campaignChart->pluck('not_deliverd_email_templates_count');
        $not_deliverd_employees_count = $campaignChart->pluck('not_deliverd_employees_count');
        $campaign_opened_mails_count = $campaignChart->pluck('opened_trackings_count');
        $campaign_clicked_link_mails_count = $campaignChart->pluck('downloaded_trackings_count');
        $campaign_download_files_mails_count = $campaignChart->pluck('clicked_trackings_count');
        $campaign_submit_data_mails_count = $campaignChart->pluck('submitted_trackings_count');


        // *********************** organization statistics Way 1 ***************************

        // $phishGroups = PhishingGroup::withoutTrashed()
        // ->withCount('users')
        // ->with(['users.deliverdCampaigns.deliverdEmailTemplates' => function ($query) {
        //     $query->withCount(['openedMails','submitedDataInMails','clickedOnLink','downloadedFileInMails']);
        // }])
        // ->with(['users.deliverdCampaigns' => function ($query) {
        //     $query->withCount(['deliverdEmailTemplates','deliverdEmployees','notDeliverdEmailTemplates','notDeliverdEmployees']);
        // }])
        // ->with(['users' => function ($query) {
        //     $query->withCount('deliverdCampaigns');
        // }])
        // ->get();
        // $phish_groups_labels = $phishGroups->pluck('name');
        // $phish_groups_employee_count = $phishGroups->pluck('users_count');
        // $phish_groups_campaign_count = $phishGroups->map(function ($group) {
        //     return $group->users->sum('deliverd_campaigns_count');
        // });

        // $phish_groups_deliverd_email_templates_count = $phishGroups->map(function ($group) {
        //     return $group->users->sum(function ($user) {
        //         return $user->deliverdCampaigns->sum('deliverd_email_templates_count');
        //     });
        // });

        // $phish_groups_deliverd_employees_count = $phishGroups->map(function ($group) {
        //     return $group->users->sum(function ($user) {
        //         return $user->deliverdCampaigns->sum('deliverd_employees_count');
        //     });
        // });

        // $phish_groups_not_deliverd_email_templates_count = $phishGroups->map(function ($group) {
        //     return $group->users->sum(function ($user) {
        //         return $user->deliverdCampaigns->sum('not_deliverd_email_templates_count');
        //     });
        // });

        // $phish_groups_not_deliverd_employees_count = $phishGroups->map(function ($group) {
        //     return $group->users->sum(function ($user) {
        //         return $user->deliverdCampaigns->sum('not_deliverd_employees_count');
        //     });
        // });

        // $phish_groups_opened_mails_count = $phishGroups->map(function ($group) {
        //     return $group->users->sum(function ($user) {
        //         return $user->deliverdCampaigns->sum(function ($campaign) {
        //             return $campaign->deliverdEmailTemplates->sum('opened_mails_count');
        //         });
        //     });
        // });

        // $phish_groups_submited_data_in_mails_count = $phishGroups->map(function ($group) {
        //     return $group->users->sum(function ($user) {
        //         return $user->deliverdCampaigns->sum(function ($campaign) {
        //             return $campaign->deliverdEmailTemplates->sum('submited_data_in_mails_count');
        //         });
        //     });
        // });

        // $phish_groups_downloaded_file_in_mails_count = $phishGroups->map(function ($group) {
        //     return $group->users->sum(function ($user) {
        //         return $user->deliverdCampaigns->sum(function ($campaign) {
        //             return $campaign->deliverdEmailTemplates->sum('downloaded_file_in_mails_count');
        //         });
        //     });
        // });
        // $phish_groups_click_link_in_mails_count = $phishGroups->map(function ($group) {
        //     return $group->users->sum(function ($user) {
        //         return $user->deliverdCampaigns->sum(function ($campaign) {
        //             return $campaign->deliverdEmailTemplates->sum('clicked_on_link_count');
        //         });
        //     });
        // });

        // *********************** organization statistics Way 2 ***************************
        $phishGroups = PhishingGroup::withoutTrashed()
        ->withCount('users')
        ->with([
            'users' => function ($query) {
                $query->withCount([
                    'deliverdCampaigns',
                    'openedMails',
                    'submitedDataInMails',
                    'downloadedFileInMails',
                    'clickedLinkInMails'
                ])
                ->with(['deliverdCampaigns' => function ($query) {
                    $query->withCount([
                        'deliverdEmailTemplates as deliverd_email_templates_count',
                        'deliverdEmployees as deliverd_employees_count',
                        'notDeliverdEmailTemplates as not_deliverd_email_templates_count',
                        'notDeliverdEmployees as not_deliverd_employees_count'
                    ]);
                }]);
            },
            // 'users.deliverdCampaigns' => function ($query) {
            //     $query->withCount([
            //         // there is a problem here it return all 0
            //         'deliverdEmailTemplates',
            //         'deliverdEmployees',
            //         'notDeliverdEmailTemplates',
            //         'notDeliverdEmployees'
            //     ]);
            // }
        ])
        ->get();

        $phish_groups_labels = $phishGroups->pluck('name');
        $phish_groups_employee_count = $phishGroups->pluck('users_count');

        $phish_groups_campaign_count = $phishGroups->map(function ($group) {
            return $group->users->sum('deliverd_campaigns_count');
        });

        $phish_groups_deliverd_email_templates_count = $phishGroups->map(function ($group) {
            // return $group->users->sum('deliverd_email_templates_count');
            return $group->users->sum(function ($user) {
                return $user->deliverdCampaigns->sum('deliverd_email_templates_count');
            });
        });

        $phish_groups_deliverd_employees_count = $phishGroups->map(function ($group) {
            return $group->users->sum('deliverd_employees_count');
        });

        $phish_groups_not_deliverd_email_templates_count = $phishGroups->map(function ($group) {
            return $group->users->sum('not_deliverd_email_templates_count');
        });

        $phish_groups_not_deliverd_employees_count = $phishGroups->map(function ($group) {
            return $group->users->sum('not_deliverd_employees_count');
        });

        $phish_groups_opened_mails_count = $phishGroups->map(function ($group) {
            return $group->users->sum('opened_mails_count');
        });

        $phish_groups_submited_data_in_mails_count = $phishGroups->map(function ($group) {
            return $group->users->sum('submited_data_in_mails_count');
        });

        $phish_groups_downloaded_file_in_mails_count = $phishGroups->map(function ($group) {
            return $group->users->sum('downloaded_file_in_mails_count');
        });

        $phish_groups_click_link_in_mails_count = $phishGroups->map(function ($group) {
            return $group->users->sum('clicked_link_in_mails_count');
        });


        // ******************************** Employee statistic *********************
        $employees_statistic = User::whereHas('deliverdCampaigns')
        ->withCount('deliverdCampaigns','openedMails','submitedDataInMails','downloadedFileInMails','clickedLinkInMails')
        ->get();

        $employees_labels = $employees_statistic->pluck('name');
        $employees_campaigns_count = $employees_statistic->pluck('deliverd_campaigns_count');
        $employee_opened_mails_count = $employees_statistic->pluck('opened_mails_count');
        $employee_submited_data_in_mails_count = $employees_statistic->pluck('submited_data_in_mails_count');
        $employee_downloaded_file_in_mails_count = $employees_statistic->pluck('downloaded_file_in_mails_count');
        $employee_click_links_mails_count = $employees_statistic->pluck('clicked_link_in_mails_count');

        // ****************************** Training Statistic **********************
        $trainings_statistic = $this->getTrainingStatistics();
        $training_labels = $trainings_statistic->pluck('month');
        $training_total_recieved_users = $trainings_statistic->pluck('total_recieved_users');
        $training_total_passed_users = $trainings_statistic->pluck('total_passed_users');
        $training_total_failed_users = $trainings_statistic->pluck('total_failed_users');
        $training_total_overdue_users = $trainings_statistic->pluck('total_overdue_users');
        return view('admin.content.phishing.dashboard.reporting', get_defined_vars());
    }

    public function trainingReporting(){
        $breadcrumbs = [
            ['link' => route('admin.phishing.dashboard'), 'name' => __('locale.Dashboard')],
        ];
        $campaigns = PhishingCampaign::withoutTrashed()->count();
        $mailTemplates = PhishingTemplate::withoutTrashed()->count();
        $mail_statistic = $this->getMailStatistic();
        $labels = $mail_statistic->pluck('month');
        $opened_count = $mail_statistic->pluck('mails_opened');
        $submited_count = $mail_statistic->pluck('mails_submitted');
        $downloaded_count = $mail_statistic->pluck('mails_downloaded');
        $activeCampaigns = $this->getActiveCampaignMailStatistic();
        $archivedCampaigns =  $this->getArchivedCampaignMailStatistic();

        // Campaign statistics
        $campaignChart = PhishingCampaign::withoutTrashed()->withCount('deliverdEmailTemplates','deliverdEmployees','notDeliverdEmailTemplates','notDeliverdEmployees')->get();
        $campaig_labels = $campaignChart->pluck('campaign_name');
        $deliverd_email_templates_count = $campaignChart->pluck('deliverd_email_templates_count');
        $deliverd_employees_count = $campaignChart->pluck('deliverd_employees_count');
        $not_deliverd_email_templates_count = $campaignChart->pluck('not_deliverd_email_templates_count');
        $not_deliverd_employees_count = $campaignChart->pluck('not_deliverd_employees_count');

        // organization statistics
        $phishGroups = PhishingGroup::withoutTrashed()
        ->withCount('users')
        ->with(['users.campaigns.deliverdEmailTemplates' => function ($query) {
            $query->withCount(['openedMails','submitedDataInMails','downloadedFileInMails']);
        }])
        ->with(['users.campaigns' => function ($query) {
            $query->withCount(['deliverdEmailTemplates','deliverdEmployees','notDeliverdEmailTemplates','notDeliverdEmployees']);
        }])
        ->with(['users' => function ($query) {
            $query->withCount('campaigns');
        }])
        ->get();
        $phish_groups_labels = $phishGroups->pluck('name');
        $phish_groups_employee_count = $phishGroups->pluck('users_count');
        $phish_groups_campaign_count = $phishGroups->map(function ($group) {
            return $group->users->sum('campaigns_count');
        });

        $phish_groups_deliverd_email_templates_count = $phishGroups->map(function ($group) {
            return $group->users->sum(function ($user) {
                return $user->campaigns->sum('deliverd_email_templates_count');
            });
        });

        $phish_groups_deliverd_employees_count = $phishGroups->map(function ($group) {
            return $group->users->sum(function ($user) {
                return $user->campaigns->sum('deliverd_employees_count');
            });
        });

        $phish_groups_not_deliverd_email_templates_count = $phishGroups->map(function ($group) {
            return $group->users->sum(function ($user) {
                return $user->campaigns->sum('not_deliverd_email_templates_count');
            });
        });

        $phish_groups_not_deliverd_employees_count = $phishGroups->map(function ($group) {
            return $group->users->sum(function ($user) {
                return $user->campaigns->sum('not_deliverd_employees_count');
            });
        });

        $phish_groups_opened_mails_count = $phishGroups->map(function ($group) {
            return $group->users->sum(function ($user) {
                return $user->campaigns->sum(function ($campaign) {
                    return $campaign->deliverdEmailTemplates->sum('opened_mails_count');
                });
            });
        });

        $phish_groups_submited_data_in_mails_count = $phishGroups->map(function ($group) {
            return $group->users->sum(function ($user) {
                return $user->campaigns->sum(function ($campaign) {
                    return $campaign->deliverdEmailTemplates->sum('submited_data_in_mails_count');
                });
            });
        });

        $phish_groups_downloaded_file_in_mails_count = $phishGroups->map(function ($group) {
            return $group->users->sum(function ($user) {
                return $user->campaigns->sum(function ($campaign) {
                    return $campaign->deliverdEmailTemplates->sum('downloaded_file_in_mails_count');
                });
            });
        });


        // Employee statistic
        $employees_statistic = User::whereHas('campaigns')
        ->withCount('campaigns')
        ->with(['campaigns.deliverdEmailTemplates' => function ($query) {
            $query->withCount(['openedMails','submitedDataInMails','downloadedFileInMails']);
        }])
        ->get();

        $employees_labels = $employees_statistic->pluck('name');
        $employees_campaigns_count = $employees_statistic->pluck('campaigns_count');
        $employee_opened_mails_count = $employees_statistic->map(function ($user) {
            return $user->campaigns->sum(function ($campaign) {
                return $campaign->deliverdEmailTemplates->sum('opened_mails_count');
            });
        });

        $employee_submited_data_in_mails_count = $employees_statistic->map(function ($user) {
            return $user->campaigns->sum(function ($user) {
                return $user->deliverdEmailTemplates->sum('submited_data_in_mails_count');
            });
        });

        $employee_downloaded_file_in_mails_count = $employees_statistic->map(function ($user) {
            return $user->campaigns->sum(function ($user) {
                return $user->deliverdEmailTemplates->sum('downloaded_file_in_mails_count');
            });
        });

        // Training Statistic
        $trainings_statistic = $this->getTrainingStatistics();
        $training_labels = $trainings_statistic->pluck('month');
        $training_total_recieved_users = $trainings_statistic->pluck('total_recieved_users');
        $training_total_passed_users = $trainings_statistic->pluck('total_passed_users');
        $training_total_failed_users = $trainings_statistic->pluck('total_failed_users');
        $training_total_overdue_users = $trainings_statistic->pluck('total_overdue_users');
        return view('admin.content.phishing.dashboard.training-reporting', get_defined_vars());
    }

    public function getActiveCampaignMailStatistic()
    {
        return PhishingCampaign::withoutTrashed()
        ->withCount('deliverdEmailTemplates')
        ->get()
        ->map(function ($campaign) {
            $opend_count = 0;
            $submited_count = 0;
            $downloaded_count = 0;

            $campaign->emailTemplates->each(function ($emailTemplate) use (&$opend_count,&$downloaded_count,&$submited_count) {
                $opend_count += $emailTemplate->openedMails()->count();
                $submited_count += $emailTemplate->submitedDataInMails()->count();
                $downloaded_count += $emailTemplate->downloadedFileInMails()->count();
            });

            $campaign->opend_count = $opend_count;
            $campaign->submited_count = $submited_count;
            $campaign->downloaded_count = $downloaded_count;
            return $campaign;
        });
    }

    public function getArchivedCampaignMailStatistic()
    {
        return PhishingCampaign::onlyTrashed()
        ->withCount('deliverdEmailTemplates')
        ->get()
        ->map(function ($campaign) {
            $opend_count = 0;
            $submited_count = 0;
            $downloaded_count = 0;

            $campaign->emailTemplates->each(function ($emailTemplate) use (&$opend_count,&$downloaded_count,&$submited_count) {
                $opend_count += $emailTemplate->openedMails()->count();
                $submited_count += $emailTemplate->submitedDataInMails()->count();
                $downloaded_count += $emailTemplate->downloadedFileInMails()->count();
            });

            $campaign->opend_count = $opend_count;
            $campaign->submited_count = $submited_count;
            $campaign->downloaded_count = $downloaded_count;
            return $campaign;
        });
    }

    public function getTrainingStatistics()
    {
        $today = Carbon::today();
        return DB::table('l_m_s_user_training_modules')
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('COUNT(user_id) as total_recieved_users'),
                DB::raw('COUNT(CASE WHEN passed = 1 THEN 1 END) as total_passed_users'),
                DB::raw('COUNT(CASE WHEN count_of_entering_exam > 0 AND passed = 0 THEN 1 END) as total_failed_users'),
                DB::raw("COUNT(CASE WHEN passed = 0 AND DATE_ADD(created_at, INTERVAL days_until_due DAY) < '{$today}' THEN 1 END) as total_overdue_users")
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }
}
