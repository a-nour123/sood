<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactQuestionnaireAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_questionnaire_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->nullable()->constrained('assets')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('percentage_complete')->default(0);
            $table->enum('approved_status', ['yes', 'no'])->default('no');
            $table->enum('status', ['incomplete', 'complete'])->default('incomplete');
            $table->enum('submission_type', ['draft', 'complete'])->default('draft');
            $table->foreignId('contact_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('questionnaire_id')->constrained('questionnaires')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('contact_questionnaire_answers');
    }
}
