<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecurityAwarenessExamQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('security_awareness_exam_questions', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('security_awareness_exams_id')->constrained('security_awareness_exams');
            $table->unsignedBigInteger('security_awareness_exams_id');
            $table->foreign('security_awareness_exams_id', 'security_awareness_exam_options_foreign')->references('id')->on('security_awareness_exams')->onDelete('Cascade');
            $table->text('question');
            $table->text('option_a');
            $table->text('option_b');
            $table->text('option_c');
            $table->text('option_d');
            $table->text('option_e');
            $table->enum('answer', ['A', 'B', 'C', 'D', 'E']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('security_awareness_exam_questions');
    }
}
