<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomRiskModelValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_risk_model_values', function (Blueprint $table) {
            // $table->integer('impact');
            $table->foreignId('impact_id')->constrained('impacts'); // column name must be impact_id
            // $table->integer('likelihood');
            $table->foreignId('likelihood_id')->constrained('likelihoods'); // column name must be likelihood_id
            $table->double('value', 3, 1);

            $table->unique(['impact_id', 'likelihood_id'], 'impact_likelihood_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_risk_model_values');
    }
}
