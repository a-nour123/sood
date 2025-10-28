<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskScoringContributingImpactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_scoring_contributing_impacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('risk_scoring_id')->constrained('risk_scorings');
            $table->foreignId('contributing_risk_id')->constrained('contributing_risks');
            $table->integer('impact');
            // $table->foreignId('impact')->constrained('impacts'); // table name must be impact_id
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('risk_scoring_contributing_impacts');
    }
}
