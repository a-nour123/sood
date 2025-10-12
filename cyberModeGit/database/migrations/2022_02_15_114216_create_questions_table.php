<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->tinyInteger('answer_type')->default(1);
            $table->boolean('file_attachment')->default(0);
            $table->boolean('question_logic')->default(0);
            $table->boolean('risk_assessment')->default(0);
            $table->boolean('compliance_assessment')->default(0);
            $table->boolean('maturity_assessment')->default(0);
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
        Schema::dropIfExists('questions');
    }
}
