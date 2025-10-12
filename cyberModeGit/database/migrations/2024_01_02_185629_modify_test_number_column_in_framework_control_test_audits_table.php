<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyTestNumberColumnInFrameworkControlTestAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('framework_control_test_audits', function (Blueprint $table) {
            // $table->json('test_number')->default(json_encode(["", "", ""]))->change();
            $table->string('test_number')->default('')->change();

        });
    }

    public function down()
    {
        Schema::table('framework_control_test_audits', function (Blueprint $table) {
            $table->integer('test_number')->default(1)->change();
        });
    }
}
