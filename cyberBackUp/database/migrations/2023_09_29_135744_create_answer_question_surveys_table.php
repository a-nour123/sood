<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswerQuestionSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answer_question_surveys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->references('id')->on('survey_questions')->onDelete('cascade');
            $table->string('answer');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('draft')->default(0);
            $table->foreignId('user_idOut')->nullable()->references('id')->on('user_out_side_cybers')->onDelete('cascade');           
            $table->foreignId('survey_id')->references('id')->on('awareness_surveys')->onDelete('cascade');
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
        Schema::dropIfExists('answer_question_surveys');
    }
}
