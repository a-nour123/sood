<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTestNumberColumnToFrameworkControlTestAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('framework_control_test_audits', function (Blueprint $table) {
            $table->integer('test_number')->default(1);
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('framework_control_test_audits', function (Blueprint $table) {
            $table->dropColumn('test_number');
        });
    }
}
