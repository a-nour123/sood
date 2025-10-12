<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThirdPartyContactQuestionnaireAnswerResultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('third_party_contact_questionnaire_answer_result', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_questionnaire_answer_id')
                ->constrained('third_party_contact_questionnaire_answer', 'id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete()
                ->index('fk_contact_questionnaire_answer_id');

            $table->foreignId('question_id')
                ->constrained('questions', 'id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete()
                ->name('fk_question_id'); // Shorter custom name for the constraint

            // $table->boolean('answer')->comment('0=> no, 1=> yes')->nullable();
            $table->foreignId('answer_id')->constrained('assessment_answers', 'id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete()
                ->name('fk_answer_id'); // Shorter custom name for the constraint

            $table->text('comment')->nullable();
            $table->text('file')->nullable();
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
        Schema::dropIfExists('third_party_contact_questionnaire_answer_result');
    }
}
