<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskToTechnologiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_to_technologies', function (Blueprint $table) {
            $table->foreignId('risk_id')->constrained('risks')->onDelete('cascade');
            $table->foreignId('technology_id')->constrained('technologies');
            
            $table->primary(['risk_id', 'technology_id']);
            $table->index(['technology_id', 'risk_id'], 'technology_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('risk_to_technologies');
    }
}
