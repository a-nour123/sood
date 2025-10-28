<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKPIAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kpi_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kpi_id')->constrained('kpis');
            $table->string('assessment_value', 50)->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('action_by')->nullable()->constrained('users');
            $table->timestamp('assessment_date')->nullable();
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
        Schema::dropIfExists('kpi_assessments');
    }
}
