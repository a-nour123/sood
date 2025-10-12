<?php

namespace App\Console\Commands;

use App\Models\Asset;
use App\Models\User;
use App\Models\UserToTeam;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Technovistalimited\Notific\Notific;

class AssetExpirationAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'asset:expirationDateAlert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Push alert for responsible(s) for asset as expiration date is near';

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
        // Get all asset that is not expired
        $assets = Asset::where('expiration_date', '>', Carbon::today())->get();


        foreach ($assets as $asset) {
            $alertDate = Carbon::today()->addDays($asset->alert_period);
            
            // if alert period is match today
            if ($asset->expiration_date->eq($alertDate)) {
                // Get all users assigned in asset teams
                $usersId = UserToTeam::whereIn('team_id', $assets[0]->teamsId())->pluck('user_id')->toArray();
                // Add all admin users
                $usersId = array_unique(array_merge($usersId, User::where('role_id', 1)->pluck('id')->toArray(), $usersId));

                Notific::notify(
                    $usersId,
                    'Asset ' . $asset->name . ' Expiration date will be after ' . $asset->alert_period . trans_choice('locale.custom_days', $asset->alert_period),
                    'alarm',
                    [],
                    date('d F Y')
                );
            }
        }
    }
}
