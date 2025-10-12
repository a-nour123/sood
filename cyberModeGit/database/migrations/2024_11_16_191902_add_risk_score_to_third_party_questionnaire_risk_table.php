<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRiskScoreToThirdPartyQuestionnaireRiskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('third_party_questionnaire_risk', function (Blueprint $table) {
            $table->integer('risk_score')->nullable()->after('impact_id')->comment('liklehood * impact (max 25)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('third_party_questionnaire_risk', function (Blueprint $table) {
            //
        });
    }
}
