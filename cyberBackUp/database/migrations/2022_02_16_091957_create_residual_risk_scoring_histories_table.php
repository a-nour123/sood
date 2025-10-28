<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResidualRiskScoringHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('residual_risk_scoring_histories', function (Blueprint $table) {
            $table->id();
            // $table->integer('risk_id');
            $table->foreignId('risk_id')->constrained('risks')->onDelete('cascade');
            $table->float('residual_risk');
            $table->dateTime('last_update');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('residual_risk_scoring_histories');
    }
}
