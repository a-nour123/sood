<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSurveyCompletedToLMSUserTrainingModules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('l_m_s_user_training_modules', function (Blueprint $table) {
            $table->boolean('survey_completed')->default(0)->after('completed_at')->comment('Indicates if the user has completed the survey for the training module');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('l_m_s_user_training_modules', function (Blueprint $table) {
            $table->dropColumn('survey_completed');
        });
    }
}
