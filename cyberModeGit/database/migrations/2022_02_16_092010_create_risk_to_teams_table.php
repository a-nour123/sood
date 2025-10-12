<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskToTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_to_teams', function (Blueprint $table) {
            $table->foreignId('risk_id')->constrained('risks')->onDelete('cascade');
            $table->foreignId('team_id')->constrained('teams');

            $table->primary(['risk_id', 'team_id']);
            $table->index(['team_id', 'risk_id'], 'team_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('risk_to_teams');
    }
}
