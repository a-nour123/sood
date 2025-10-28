<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMitigationToControlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mitigation_to_controls', function (Blueprint $table) {
            // $table->integer('mitigation_id');
            $table->foreignId('mitigation_id')->constrained('mitigations')->onDelete('cascade');
            // $table->integer('control_id');
            $table->foreignId('control_id')->constrained('framework_controls');
            $table->mediumText('validation_details')->nullable();
            $table->integer('validation_owner');
            $table->integer('validation_mitigation_percent')->default(0);
            
            $table->primary(['mitigation_id', 'control_id']);
            $table->index(['control_id', 'mitigation_id'], 'control_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mitigation_to_controls');
    }
}
