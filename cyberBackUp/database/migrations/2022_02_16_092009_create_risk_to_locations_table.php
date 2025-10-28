<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskToLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_to_locations', function (Blueprint $table) {
            $table->foreignId('risk_id')->constrained('risks')->onDelete('cascade');
            $table->foreignId('location_id')->constrained('locations');

            $table->primary(['risk_id', 'location_id']);
            $table->index(['location_id', 'risk_id'], 'location_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('risk_to_locations');
    }
}
