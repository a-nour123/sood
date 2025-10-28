<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNameColumnLengthInMitigationEffortsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mitigation_efforts', function (Blueprint $table) {
            $table->string('name', 255)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mitigation_efforts', function (Blueprint $table) {
            $table->string('name', 20)->change();
        });
    }
}
