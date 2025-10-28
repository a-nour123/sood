<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentScoringContributingImpactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment_scoring_contributing_impacts', function (Blueprint $table) {
            $table->id();
            // $table->integer('assessment_scoring_id');

            $table->unsignedBigInteger('assessment_scoring_id');
            $table->foreign('assessment_scoring_id', 'A_S_C_I_A_S_id_foreign')->references('id')->on('assessment_scorings');

            // $table->integer('contributing_risk_id');

            $table->unsignedBigInteger('contributing_risk_id');
            $table->foreign('contributing_risk_id', 'A_S_C_I_C_R_id_foreign')->references('id')->on('contributing_risks');

            $table->integer('impact');
            // $table->foreignId('impact')->constrained('impacts'); // column name must be impact_id
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assessment_scoring_contributing_impacts');
    }
}
