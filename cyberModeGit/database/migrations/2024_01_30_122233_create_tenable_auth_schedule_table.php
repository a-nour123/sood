<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenableAuthScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenable_auth_schedule', function (Blueprint $table) {
            $table->id();
            $table->string('time_schedule')->nullable();
            $table->string('due_time')->nullable();
            $table->string('due_weekly_day')->nullable();
            $table->string('due_weekly_time')->nullable();
            $table->string('date_monthly')->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenable_auth_schedule');
    }
}
