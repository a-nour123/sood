<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContributingRisksImpactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contributing_risks_impacts', function (Blueprint $table) {
            $table->id();
            // $table->integer('contributing_risks_id');
            $table->foreignId('contributing_risks_id')->constrained('contributing_risks'); // column name must be contributing_risk_id
            $table->integer('value');
            $table->string('name', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contributing_risks_impact');
    }
}
