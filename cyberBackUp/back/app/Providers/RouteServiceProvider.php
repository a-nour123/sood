<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = 'admin/dashboard';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
           Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware(['web'])
                ->namespace($this->namespace)
                ->group(base_path('routes/website.php'));

             Route::middleware(['web', 'InvalidateSerial'])
                ->namespace($this->namespace)
                ->group(base_path('routes/serial.php'));

            Route::middleware(['web' ,'ValidateSerial'])
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            Route::middleware(['web', 'auth', 'havePermission','ValidateSerial'])
                ->namespace($this->namespace)
                ->as('user.')
                ->group(base_path('routes/admin/user.php'));

            Route::middleware(['web', 'auth', 'havePermission','ValidateSerial'])
                ->namespace($this->namespace)
                ->prefix('admin')
                ->as('admin.')
                ->group(function ($router) {
                    require base_path('routes/admin/assessment.php');
                    require base_path('routes/admin/asset-management.php');
                    require base_path('routes/admin/compliance.php');
                    require base_path('routes/admin/configure.php');
                    require base_path('routes/admin/governance.php');
                    require base_path('routes/admin/reporting.php');
                    require base_path('routes/admin/risk-management.php');
                    require base_path('routes/admin/hierarchy.php');
                    require base_path('routes/admin/phishing.php');
                    require base_path('routes/admin/task.php');
                    require base_path('routes/admin/change-request.php');
                    require base_path('routes/admin/vulnerability-management.php');
                    require base_path('routes/admin/KPI.php');
                    require base_path('routes/admin/security-awareness.php');
                    require base_path('routes/admin/control-objective.php');
                    require base_path('routes/admin/notification-setting.php');
                    require base_path('routes/admin/awareness-survey.php');
                    require base_path('routes/admin/import.php');
                    require base_path('routes/admin/phishing.php');
                    require base_path('routes/admin/incident.php');
                    require base_path('routes/admin/third_party.php');
                    require base_path('routes/admin/LMS.php');
                    require base_path('routes/admin/audit-plan.php');

                });
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
   });
}
}
