<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSurveyIdToTrainingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('l_m_s_training_modules', function (Blueprint $table) {
            if (!Schema::hasColumn('l_m_s_training_modules', 'survey_id')) {
                $table->foreignId('survey_id')
                    ->nullable()
                    ->constrained('awareness_surveys')
                    ->nullOnDelete();
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
        Schema::table('l_m_s_training_modules', function (Blueprint $table) {
            if (Schema::hasColumn('l_m_s_training_modules', 'survey_id')) {
                $table->dropForeign(['survey_id']);
                $table->dropColumn('survey_id');
            }
        });
    }
}
