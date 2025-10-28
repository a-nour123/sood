<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrameworkControlTestResultsToRisksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('framework_control_test_results_to_risks', function (Blueprint $table) {
            $table->id();
            // $table->integer('test_results_id')->nullable();
            $table->foreignId('test_results_id')->nullable()->constrained('framework_control_test_results'); // column name must be framework_control_test_result_id
            // $table->integer('risk_id')->nullable();
            $table->foreignId('risk_id')->nullable()->constrained('risks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('framework_control_test_results_to_risks');
    }
}
