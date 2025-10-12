<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFrameworkControlsIdsToQuestionnaireRisks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questionnaire_risks', function (Blueprint $table) {
            $table->foreignId('framework_controls_ids')->after('owner_id')->constrained('framework_controls')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questionnaire_risks', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropForeign('framework_controls_ids');
        });
    }
}
