<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdsAssetGroupToTenableAuthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenable_auth', function (Blueprint $table) {
            $table->string('idsAssetGroup')->nullable()->after('api_url'); // Add the new column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tenable_auth', function (Blueprint $table) {
            $table->dropColumn('idsAssetGroup'); // Remove the new column
        });
    }
}
