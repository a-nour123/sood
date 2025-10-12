<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrameworkControlToFrameworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('framework_control_to_frameworks', function (Blueprint $table) {
            // $table->integer('control_id');
            $table->foreignId('control_id')->constrained('framework_controls'); // column name must be framework_control_id
            // $table->integer('framework_id');
            // $table->integer('framework_id');
            // $table->foreign('framework_id')->references('value')->on('frameworks'); // column name must be framework_id
            $table->foreignId('framework_id')->constrained('frameworks');
            
            $table->primary(['control_id', 'framework_id']);
            $table->index(['framework_id', 'control_id'], 'framework_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::dropIfExists('framework_control_to_frameworks');
    }
}
