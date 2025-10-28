<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentCriteriaScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incident_criteria_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incident_id')->constrained()->onDelete('cascade');
            $table->foreignId('incident_criteria_id')->constrained('incident_criterias')->onDelete('cascade');
            $table->foreignId('incident_score_id')->nullable()->constrained('incident_scores')->onDelete('set null');
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
        Schema::dropIfExists('incident_criteria_scores');
    }
}
