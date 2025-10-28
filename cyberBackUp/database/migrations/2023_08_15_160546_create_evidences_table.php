<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvidencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evidences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('control_control_objective_id');
            $table->foreign('control_control_objective_id', 'controls_control_objectives_foreign')->references('id')->on('controls_control_objectives');
            $table->unsignedBigInteger('creator_id');
            $table->foreign('creator_id', 'users_foreign')->references('id')->on('users');
            $table->text('description');
            $table->text('file_name')->nullable();
            $table->text('file_unique_name')->nullable();
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
        Schema::dropIfExists('evidences');
    }
}
