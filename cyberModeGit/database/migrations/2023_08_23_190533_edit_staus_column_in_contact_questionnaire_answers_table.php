<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EditStausColumnInContactQuestionnaireAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('contact_questionnaire_answers', function (Blueprint $table) {
           DB::statement('ALTER TABLE `contact_questionnaire_answers` CHANGE  `approved_status` `approved_status` ENUM("yes","no") NULL DEFAULT NULL ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contact_questionnaire_answers', function (Blueprint $table) {
            //
        });
    }
}
