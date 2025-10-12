<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserToTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_to_teams', function (Blueprint $table) {
            // $table->integer('user_id');
            // $table->integer('user_id');
            // $table->foreign('user_id')->references('value')->on('users');
            $table->foreignId('user_id')->constrained('users');

            // $table->integer('team_id');
            // $table->integer('team_id');
            // $table->foreign('team_id')->references('value')->on('teams');
            $table->foreignId('team_id')->constrained('teams');

            $table->primary(['user_id', 'team_id']);
            $table->index(['team_id', 'user_id'], 'team_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_to_teams');
    }
}
