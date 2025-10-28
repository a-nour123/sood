<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlsControlObjectivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('controls_control_objectives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('control_id');
            $table->foreign('control_id', 'framework_controls_foreign')->references('id')->on('framework_controls');
            $table->unsignedBigInteger('objective_id');
            $table->foreign('objective_id', 'control_objectivess_foreign')->references('id')->on('control_objectives');
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
        Schema::dropIfExists('controls_control_objectives');
    }
}
