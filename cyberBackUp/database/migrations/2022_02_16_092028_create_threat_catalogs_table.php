<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThreatCatalogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threat_catalogs', function (Blueprint $table) {
            $table->id();
            $table->string('number', 20);
            // $table->integer('grouping');
            $table->foreignId('threat_grouping_id')->constrained('threat_groupings');
            // $table->foreignId('grouping')->constrained('threat_groupings'); // column name must be threat_grouping_id
            $table->string('name', 1000);
            $table->text('description');
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
        Schema::dropIfExists('threat_catalogs');
    }
}
