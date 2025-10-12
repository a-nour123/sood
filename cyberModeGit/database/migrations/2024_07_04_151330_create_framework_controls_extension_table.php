<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrameworkControlsExtensionTable extends Migration
{
    public function up()
    {
        Schema::create('framework_controls_extension', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('control_id');
            $table->unsignedBigInteger('extend_control_id');
            $table->timestamps();

            $table->foreign('control_id')->references('id')->on('framework_controls')->onDelete('cascade');
            $table->foreign('extend_control_id')->references('id')->on('framework_controls')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('framework_controls_extension');
    }
}

