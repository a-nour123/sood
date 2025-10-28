<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrameworkControlTypeMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('framework_control_type_mappings', function (Blueprint $table) {
            $table->id();
            // $table->integer('control_id');
            $table->foreignId('control_id')->constrained('framework_controls'); // column name must be 
            // $table->integer('control_type_id');
            // $table->integer('control_type_id');
            // $table->foreign('control_type_id')->references('value')->on('control_types');
            $table->foreignId('control_type_id')->constrained('control_types');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('framework_control_type_mappings');
    }
}
