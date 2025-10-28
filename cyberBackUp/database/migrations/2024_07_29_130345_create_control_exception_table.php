<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlExceptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control_exception', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exception_id')->nullable();
            $table->foreign('exception_id')->references('id')->on('exceptions')->onDelete('set null'); // Exception

            $table->unsignedBigInteger('control_id')->nullable();
            $table->foreign('control_id')->references('id')->on('framework_controls')->onDelete('set null'); // Controls
            
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
        Schema::dropIfExists('control_exception');
    }
}
