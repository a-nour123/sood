<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class UpdateStatusInFrameworkControlTestAudits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update all rows in the framework_control_test_audits table
        DB::table('framework_control_test_audits')->update(['status' => 1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Optionally, reset status back to its default value (if applicable)
        DB::table('framework_control_test_audits')->update(['status' => 0]);
    }
}
