<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentAnswersToAssetGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment_answers_to_asset_groups', function (Blueprint $table) {
            // $table->integer('assessment_answer_id');
            $table->foreignId('assessment_answer_id')->constrained('assessment_answers');
            // $table->integer('asset_group_id');
            $table->foreignId('asset_group_id')->constrained('asset_groups');
            
            $table->unique(['assessment_answer_id', 'asset_group_id'], 'assessment_answer_asset_group_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assessment_answers_to_asset_groups');
    }
}
