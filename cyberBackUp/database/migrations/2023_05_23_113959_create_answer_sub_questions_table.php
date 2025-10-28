<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswerSubQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answer_sub_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('answer_id')->constrained('assessment_answers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('assessment_questions')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('answer_sub_questions');
    }
}
