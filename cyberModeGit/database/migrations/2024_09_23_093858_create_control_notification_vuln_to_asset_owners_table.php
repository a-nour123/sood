<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlNotificationVulnToAssetOwnersTable extends Migration
{
    public function up()
    {
        Schema::create('control_notification_vuln_to_asset_owners', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable();
            $table->string('severity')->nullable();
            $table->string('exploit')->nullable();
            $table->date('first_discovered')->nullable();
            $table->date('last_discovered')->nullable();
            $table->timestamps(); // For created_at and updated_at fields
        });
    }

    public function down()
    {
        Schema::dropIfExists('control_notification_vuln_to_asset_owners');
    }
}

