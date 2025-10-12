<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThirdPartyContactQuestionnaireAnswerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('third_party_contact_questionnaire_answer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained('third_party_profile_contact')->cascadeOnDelete()->index('fk_contact_id');
            $table->foreignId('questionnaire_id')->constrained('third_party_questionnaires')->cascadeOnDelete()->index('fk_questionnaire_id');
            $table->string('access_password')->nullable();
            $table->enum('submission_type', ['draft', 'complete'])->default('draft');
            $table->enum('status', ['incomplete', 'complete'])->default('incomplete');
            $table->longText('note')->nullable();
            $table->integer('percentage_complete')->default(0);
            $table->enum('approved_status', ['yes', 'no','remeidation'])->default('no')->nullable();
            $table->timestamp('send_date')->nullable();
            $table->timestamp('submission_date')->nullable();
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
        Schema::dropIfExists('third_party_contact_questionnaire_answer');
    }
}
