<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSeverityToTenableAuthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenable_auth', function (Blueprint $table) {
            // Check and drop columns only if they exist
            if (Schema::hasColumn('tenable_auth', 'end_value_assets_group')) {
                $table->dropColumn('end_value_assets_group');
            }
            if (Schema::hasColumn('tenable_auth', 'total_assets_group')) {
                $table->dropColumn('total_assets_group');
            }
            if (Schema::hasColumn('tenable_auth', 'offset_assets_group')) {
                $table->dropColumn('offset_assets_group');
            }

            // Add the new severity column
            if (!Schema::hasColumn('tenable_auth', 'severity')) {
                $table->string('severity')->nullable()->after('total');
            }
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
            // Re-add the removed columns in case of rollback
            if (!Schema::hasColumn('tenable_auth', 'end_value_assets_group')) {
                $table->string('end_value_assets_group')->nullable();
            }
            if (!Schema::hasColumn('tenable_auth', 'total_assets_group')) {
                $table->integer('total_assets_group')->nullable();
            }
            if (!Schema::hasColumn('tenable_auth', 'offset_assets_group')) {
                $table->integer('offset_assets_group')->nullable();
            }

            // Drop the severity column in case of rollback
            if (Schema::hasColumn('tenable_auth', 'severity')) {
                $table->dropColumn('severity');
            }
        });
    }
}
