<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskCatalogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_catalogs', function (Blueprint $table) {
            $table->id();
            $table->string('number', 20);
            $table->foreignId('risk_grouping_id')->constrained('risk_groupings');
            $table->string('name', 1000);
            $table->text('description');
            $table->foreignId('risk_function_id')->constrained('risk_functions');
            $table->integer('order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('risk_catalogs');
    }
}
