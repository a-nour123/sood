<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExceptionRiskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exception_risk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exception_id')->nullable();
            $table->foreign('exception_id')->references('id')->on('exceptions')->onDelete('set null'); // Exception

            $table->unsignedBigInteger('risk_id')->nullable();
            $table->foreign('risk_id')->references('id')->on('risks')->onDelete('set null'); // Risks
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
        Schema::dropIfExists('exception_risk');
    }
}
