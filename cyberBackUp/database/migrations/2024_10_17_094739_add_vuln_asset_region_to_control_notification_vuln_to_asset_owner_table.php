<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVulnAssetRegionToControlNotificationVulnToAssetOwnerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('control_notification_vuln_to_asset_owners', function (Blueprint $table) {
            $table->string('vuln_asset_region')->nullable()->after('status'); // Adjust the position as needed

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('control_notification_vuln_to_asset_owners', function (Blueprint $table) {
            $table->dropColumn('vuln_asset_region');

        });
    }
}
