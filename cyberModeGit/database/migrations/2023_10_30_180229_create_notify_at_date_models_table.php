<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifyAtDateModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notify_at_date_models', function (  $table) {
            $table->id();
            $table->json('model');
            $table->json('roles');
            $table->integer('action_id');
            $table->integer('model_id');
            $table->string('model_type');
            $table->text('link');
            $table->text('proccess');
            $table->json('notification_date');
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
        Schema::dropIfExists('notify_at_date_models');
    }
}
