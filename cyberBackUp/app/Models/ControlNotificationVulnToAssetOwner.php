<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControlNotificationVulnToAssetOwner extends Model
{
    protected $table = 'control_notification_vuln_to_asset_owners';

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'status',
        'severity',
        'exploit',
        'first_discovered',
        'last_discovered',
        'vuln_asset_region',
    ];
}
