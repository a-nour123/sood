<?php
/**
 * @Author: Eng: Mahmoud Ahmed
 **/
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        // $this->app->bind(
        //     'Interface',
        //     'Repository'
        // );

        $this->app->bind(
            'App\Interfaces\Admin\Phishing\TestInterface',
            'App\Repositories\Admin\TestRepository'

        );
        $this->app->bind(
            'App\Interfaces\Admin\Phishing\PhishingCategoryInterface',
            'App\Repositories\Admin\Phishing\PhishingCategoryRepository'
        );
        $this->app->bind(
            'App\Interfaces\Admin\Phishing\PhishingDomainsInterface',
            'App\Repositories\Admin\Phishing\PhishingDomainsRepository'
        );

        $this->app->bind(
            'App\Interfaces\Admin\Phishing\PhishingSenderProfileInterface',
            'App\Repositories\Admin\Phishing\PhishingSenderProfileRepository'
        );


        $this->app->bind(
            'App\Interfaces\Admin\Phishing\PhishingWebsiteInterface',
            'App\Repositories\Admin\Phishing\PhishingWebsiteRepository'
        );


        $this->app->bind(
            'App\Interfaces\Admin\Phishing\PhishingTemplateInterface',
            'App\Repositories\Admin\Phishing\PhishingTemplateRepository'
        );


        $this->app->bind(
            'App\Interfaces\Admin\Phishing\PhishingCampaignInterface',
            'App\Repositories\Admin\Phishing\PhishingCampaignRepository'
        );

        $this->app->bind(
            'App\Interfaces\Admin\Phishing\PhishingLandingPageInterface',
            'App\Repositories\Admin\Phishing\PhishingLandingPageRepository'
        );

        $this->app->bind(
            'App\Interfaces\Admin\Phishing\PhishingGroupInterface',
            'App\Repositories\Admin\Phishing\PhishingGroupRepository'
        );

        $this->app->bind(
            'App\Interfaces\Admin\Phishing\PhishingDashboardInterface',
            'App\Repositories\Admin\Phishing\PhishingDashboardRepository'
        );

        // LMS
        $this->app->bind(
            'App\Interfaces\Admin\LMS\LMSCourseInterface',
            'App\Repositories\Admin\LMS\LMSCourseRepository'
        );

        $this->app->bind(
            'App\Interfaces\Admin\LMS\LMSLevelInterface',
            'App\Repositories\Admin\LMS\LMSLevelRepository'
        );

        $this->app->bind(
            'App\Interfaces\Admin\LMS\LMSTrainingModuleInterface',
            'App\Repositories\Admin\LMS\LMSTrainingModuleRepository'
        );


        // Start Quiz
        $this->app->bind(
            'App\Interfaces\User\LMSQuizInterface',
            'App\Repositories\User\LMSQuizRepository'
        );

    }
}
