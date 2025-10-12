<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThirdPartyQuestionnairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('third_party_questionnaires', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('instructions')->nullable();
            $table->foreignId('request_id')->nullable()->constrained('third_party_requests')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('assessment_id')->nullable()->constrained('assessments')->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('all_questions_mandatory')->default(false);
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
        Schema::dropIfExists('third_party_questionnaires');
    }
}
