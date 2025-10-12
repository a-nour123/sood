<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeVulnerabilitiesColumnsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vulnerabilities', function (Blueprint $table) {
            $table->string('cve')->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->text('recommendation')->nullable()->change();
            $table->text('plan')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('vulnerabilities', function (Blueprint $table) {
            //
        });
    }
}
