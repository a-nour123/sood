<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExceptionSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // It should be one row in this table, and update it when you need
        Schema::create('exception_settings', function (Blueprint $table) {
            $table->id();
            $table->enum('policy_approver', ['0','1'])->default('1')->comment('Options of the policy approver: 0 for policy owner, 1 for any person');
            $table->unsignedBigInteger('policy_approver_id')->nullable();
            // $table->enum('policy_reviewer', ['0','1','2'])->default('2')->comment('Options of the policy reviewer: 0 for exception owner, 1 for policy owner, 2 for any person');
            $table->enum('control_approver', ['0','1'])->default('1')->comment('Options of the control approver: 0 for control owner, 1 for any person');
            $table->unsignedBigInteger('control_approver_id')->nullable();
            // $table->enum('control_reviewer', ['0','1','2'])->default('2')->comment('Options of the control reviewer: 0 for exception owner, 1 for control owner, 2 for any person');
            $table->enum('risk_approver', ['0','1'])->default('1')->comment('Options of the risk approver: 0 for risk owner, 1 for any person');
            $table->unsignedBigInteger('risk_approver_id')->nullable();
            // $table->enum('risk_reviewer', ['0','1','2'])->default('2')->comment('Options of the risk reviewer: 0 for exception owner, 1 for risk owner, 2 for any person');
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
        Schema::dropIfExists('exception_settings');
    }
}
