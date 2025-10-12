<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThirdPartyQuestionnaireQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('third_party_questionnaire_question', function (Blueprint $table) {
            $table->id();
            $table->foreignId('questionnaire_id')->constrained('third_party_questionnaires', 'id')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('questions', 'id')->cascadeOnDelete();
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
        Schema::dropIfExists('third_party_questionnaire_question');
    }
}
