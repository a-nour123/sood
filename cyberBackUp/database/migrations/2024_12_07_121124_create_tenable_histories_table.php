<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenableHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenable_histories', function (Blueprint $table) {
            $table->id();
            $table->string('vuln_id');
            $table->string('asset_id');
            $table->string('severity'); // Example: High, Medium, Low
            $table->string('status');   // Example: Open, Closed, In Progress
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
        Schema::dropIfExists('tenable_histories');
    }
}
