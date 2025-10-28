<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ControlQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('control_questions',function (Blueprint  $table){
           $table->id();
           $table->foreignId('framework_control_id')
               ->constrained('framework_controls')
               ->cascadeOnUpdate()
               ->cascadeOnDelete();

           $table->foreignId('assessment_question_id')
               ->constrained('assessment_questions')
               ->cascadeOnUpdate()
               ->cascadeOnDelete();
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('control_questions');
    }
}
