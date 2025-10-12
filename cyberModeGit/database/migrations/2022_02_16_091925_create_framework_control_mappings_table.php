<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrameworkControlMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('framework_control_mappings', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('framework_control_id')->constrained('framework_controls');
            $table->foreignId('framework_id')->constrained('frameworks');
            // $table->unsignedBigInteger('framework_control_id');
            // $table->unsignedBigInteger('framework_id');
            // $table->foreign('framework_control_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('framework_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('reference_name', 200);
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
        Schema::dropIfExists('framework_control_mappings');
    }
}
