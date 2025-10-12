<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveObjectiveFromFrameworkControlTestsAndFrameworkControlTestAuditsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('framework_control_tests', function (Blueprint $table) {
            $table->dropColumn('objective');
        });
        Schema::table('framework_control_test_audits', function (Blueprint $table) {
            $table->dropColumn('objective');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('framework_control_tests', function (Blueprint $table) {
            $table->mediumText('objective')->nullable();
        });
        Schema::table('framework_control_test_audits', function (Blueprint $table) {
            $table->mediumText('objective')->nullable();
        });
    }
}
