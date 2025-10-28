<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionnaireRisksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionnaire_risks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('questionnaire_id')->constrained('questionnaires')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('answer_id')->constrained('assessment_answers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->text('risk_subject')->nullable();
            $table->foreignId('risk_scoring_method_id')->nullable()->constrained('scoring_methods')->nullOnDelete();
            $table->foreignId('likelihood_id')->nullable()->constrained('likelihoods')->nullOnDelete();
            $table->foreignId('impact_id')->nullable()->constrained('impacts')->nullOnDelete();
            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->json('assets_ids')->nullable();
            $table->json('tags_ids')->nullable();
            $table->json('framework_controls_ids')->nullable();
            $table->enum('status', ['pending', 'rejected', 'added'])->default('pending');
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
        Schema::dropIfExists('questionnaire_risks');
    }
}
