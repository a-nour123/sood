<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThirdPartyContactQuestionnaireTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('third_party_contact_questionnaire', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained('third_party_profile_contact')->cascadeOnDelete();
            $table->foreignId('questionnaire_id')->constrained('third_party_questionnaires')->cascadeOnDelete();
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
        Schema::dropIfExists('third_party_contact_questionnaire');
    }
}
