<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMitigationToTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mitigation_to_teams', function (Blueprint $table) {
            // $table->integer('mitigation_id');
            $table->foreignId('mitigation_id')->constrained('mitigations')->onDelete('cascade');
            // $table->integer('team_id');
            // $table->integer('team_id');
            // $table->foreign('team_id')->references('value')->on('teams');
            $table->foreignId('team_id')->constrained('teams');


            $table->primary(['mitigation_id', 'team_id']);
            $table->index(['team_id', 'mitigation_id'], 'team_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mitigation_to_teams');
    }
}
