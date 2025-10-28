<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLMSQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('l_m_s_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->enum('question_type',['multi_choise','true_or_false']);
            $table->string('correct_answer')->nullable();
            $table->text('answer_description')->nullable();
            $table->unsignedBigInteger('training_module_id')->nullable();
            $table->tinyInteger('page_number')->nullable();
            $table->foreign('training_module_id')->references('id')->on('l_m_s_training_modules')->onDelete('set null');
            $table->softDeletes();
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
        Schema::dropIfExists('l_m_s_questions');
    }
}
