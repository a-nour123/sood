<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentAnswersToAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment_answers_to_assets', function (Blueprint $table) {
            // $table->integer('assessment_answer_id');
            $table->foreignId('assessment_answer_id')->constrained('assessment_answers');
            // $table->integer('asset_id');
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            
            $table->unique(['assessment_answer_id', 'asset_id'], 'assessment_answer_asset_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assessment_answers_to_assets');
    }
}
