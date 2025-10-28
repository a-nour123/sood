<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentIraTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incident_ira_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incident_ira_id')->constrained('incident_iras')->onDelete('cascade');
            $table->foreignId('team_id')->constrained('teams')->onDelete('restrict');
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
        Schema::dropIfExists('incident_ira_teams');
    }
}
