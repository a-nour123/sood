<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlAuditsObjectivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control_audits_objectives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('control_control_objective_id');
            $table->foreign('control_control_objective_id')->references('id')->on('controls_control_objectives')->onDelete('cascade');
            $table->unsignedBigInteger('framework_control_test_audit_id');
            $table->foreign('framework_control_test_audit_id','fk_control_test_audit_id')->references('id')->on('framework_control_test_audits')->onDelete('cascade');
            $table->enum('objective_audit_status', ['no_action', 'approved', 'rejected'])->default('no_action');
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
        Schema::dropIfExists('control_audits_objectives');
    }
}
