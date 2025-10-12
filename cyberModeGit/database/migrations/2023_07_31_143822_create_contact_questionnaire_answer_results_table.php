<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactQuestionnaireAnswerResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_questionnaire_answer_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contact_questionnaire_answer_id');
            $table->foreign('contact_questionnaire_answer_id','contact_q_answer_id')->references('id')->on('contact_questionnaire_answers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('question_id')->constrained('questions')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('answer_id')->nullable()->default(null)->constrained('assessment_answers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('answer_type', [1, 2, 3])->comment('1:single select 2:multiple select 3:fill in the blank');
            $table->longText('answer')->nullable();
            $table->text('file')->nullable();
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('contact_questionnaire_answer_results');
    }
}
