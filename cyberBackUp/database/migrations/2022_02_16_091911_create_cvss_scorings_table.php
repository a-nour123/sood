<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCvssScoringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cvss_scorings', function (Blueprint $table) {
            $table->id();
            $table->string('metric_name', 30);
            $table->string('abrv_metric_name', 3);
            $table->string('metric_value', 30);
            $table->string('abrv_metric_value', 3);
            $table->float('numeric_value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cvss_scorings');
    }
}
