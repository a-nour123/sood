<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionnairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionnaires', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('instructions')->nullable();
            $table->foreignId('assessment_id')->nullable()->constrained('assessments')->cascadeOnDelete()->cascadeOnUpdate();
            // TODO:: create questionnaires contact table ( questionnaires belongs to many contacts )
            $table->boolean('all_questions_mandatory')->default(false);
            $table->boolean('answer_percentage')->default(false);
            $table->tinyInteger('percentage_number')->default(0);
            $table->boolean('specific_mandatory_questions')->default(false);
             // TODO:: create questionnaires questions table ( questionnaires belongs to many questions )
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
        Schema::dropIfExists('questionnaires');
    }
}
