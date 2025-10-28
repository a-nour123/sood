<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskScoringHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_scoring_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('risk_id')->constrained('risks')->onDelete('cascade');
            $table->float('calculated_risk');
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
        Schema::dropIfExists('risk_scoring_histories');
    }
}
