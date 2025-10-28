<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrameworkControlTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('framework_control_tests', function (Blueprint $table) {
            $table->id();
            // $table->integer('tester');
            $table->foreignId('tester')->constrained('users');
            $table->integer('test_frequency')->nullable()->default(0);
            $table->date('last_date')->nullable();
            $table->date('next_date')->nullable();
            $table->mediumText('name')->nullable();
            $table->mediumText('objective')->nullable();
            $table->mediumText('test_steps')->nullable();
            $table->integer('approximate_time')->nullable();
            $table->mediumText('expected_results')->nullable();
            // $table->integer('framework_control_id');
            $table->foreignId('framework_control_id')->nullable()->constrained('framework_controls')->onDelete('cascade');
            $table->integer('desired_frequency')->nullable();
            $table->integer('status')->nullable()->default(1);
            // $table->date('created_at')->nullable();
            $table->string('additional_stakeholders', 500)->nullable();
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
      DB::statement('SET FOREIGN_KEY_CHECKS = 0');
      Schema::dropIfExists('framework_control_tests');
      DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
