<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyQuestionAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_question_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('response_id')->nullable()->constrained('survey_responses')->nullOnDelete();
            $table->foreignId('question_id')->nullable()->constrained('survey_questions')->nullOnDelete();
            $table->text('answer_text')->nullable();
            $table->char('selected_option', 1)->nullable(); // A, B, C, D, E
            $table->boolean('is_draft')->default(false);
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
        Schema::dropIfExists('survey_question_answers');
    }
}
