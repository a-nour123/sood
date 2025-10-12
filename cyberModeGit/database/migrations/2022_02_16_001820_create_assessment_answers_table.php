<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->nullable()->constrained('assessments')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('sub_question_assessment_id')->nullable()->constrained('assessments')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('question_id')->constrained('questions')->cascadeOnUpdate()->cascadeOnDelete();
            $table->longText('answer')->nullable();
            $table->boolean('fail_control')->default(false);
            $table->foreignId('maturity_control_id')->nullable()->constrained('control_maturities')->nullOnDelete();
            $table->boolean('submit_risk')->default(0);
            $table->text('risk_subject')->nullable();
            $table->foreignId('risk_scoring_method_id')->nullable()->constrained('scoring_methods')->nullOnDelete();
            $table->foreignId('likelihood_id')->nullable()->constrained('likelihoods')->nullOnDelete();
            $table->foreignId('impact_id')->nullable()->constrained('impacts')->nullOnDelete();
            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->json('assets_ids')->nullable();
            $table->json('tags_ids')->nullable();
            $table->json('framework_controls_ids')->nullable();
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
        Schema::dropIfExists('assessment_answers');
    }
}
