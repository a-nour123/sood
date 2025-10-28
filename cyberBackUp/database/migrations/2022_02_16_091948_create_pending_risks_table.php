<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendingRisksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_risks', function (Blueprint $table) {
            $table->id();
            // $table->integer('assessment_id');
            $table->foreignId('assessment_id')->constrained('assessments');
            // $table->integer('assessment_answer_id');
            $table->foreignId('assessment_answer_id')->constrained('assessment_answers');
            $table->string('subject');
            $table->float('score');
            $table->integer('owner')->nullable();
            // $table->integer('owner')->nullable()->constrained('users'); // column name must be owner_id
            $table->text('affected_assets')->nullable();
            $table->string('comment', 500)->nullable();
            $table->timestamp('submission_date')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pending_risks');
    }
}
