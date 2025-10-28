<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArabicColumnsToLMSQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('l_m_s_questions', function (Blueprint $table) {
            $table->string('question_ar')->nullable();
            $table->string('correct_answer_ar')->nullable();
            $table->text('answer_description_ar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('l_m_s_questions', function (Blueprint $table) {
            $table->dropColumn(['question_ar', 'correct_answer_ar','answer_description_ar']);
        });
    }
}
