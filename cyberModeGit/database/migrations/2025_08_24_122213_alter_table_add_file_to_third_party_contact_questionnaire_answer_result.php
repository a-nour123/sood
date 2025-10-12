<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableAddFileToThirdPartyContactQuestionnaireAnswerResult extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('third_party_contact_questionnaire_answer_result', function (Blueprint $table) {
            if (!Schema::hasColumn('third_party_contact_questionnaire_answer_result', 'file')) {
                $table->string('file')->nullable()->after('comment'); 
                // you can place it after a specific column if you want
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('third_party_contact_questionnaire_answer_result', function (Blueprint $table) {
            if (Schema::hasColumn('third_party_contact_questionnaire_answer_result', 'file')) {
                $table->dropColumn('file');
            }
        });
    }
}