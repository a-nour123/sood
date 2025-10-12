<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question', 1000);
            $table->foreignId('survey_id')->references('id')->on('awareness_surveys')->onDelete('cascade');
            $table->integer('answer_type')->default(1);
            $table->string('option_A', 1000);
            $table->string('option_B', 1000);
            $table->string('option_C', 1000);
            $table->string('option_D', 1000)->nullable();
            $table->string('option_E', 1000)->nullable();
            // $table->string('answer');
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
        Schema::dropIfExists('survey_questions');
    }
}
