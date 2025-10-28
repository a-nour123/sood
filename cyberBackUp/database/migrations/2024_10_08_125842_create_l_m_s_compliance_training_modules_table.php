<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLMSComplianceTrainingModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('l_m_s_compliance_training_modules', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('framework_control_id')->nullable();
            $table->foreign('framework_control_id')->references('id')->on('framework_controls')->onDelete('set null');

            $table->unsignedBigInteger('training_module_id')->nullable();
            $table->foreign('training_module_id')->references('id')->on('l_m_s_training_modules')->onDelete('set null');

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
        Schema::dropIfExists('l_m_s_compliance_training_modules');
    }
}
