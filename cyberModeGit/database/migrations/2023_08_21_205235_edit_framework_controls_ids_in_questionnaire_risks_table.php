<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditFrameworkControlsIdsInQuestionnaireRisksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questionnaire_risks', function (Blueprint $table) {

            if (Schema::hasColumn('questionnaire_risks', 'framework_controls_ids')) {
                $table->dropColumn('framework_controls_ids');
            }else{
                $table->foreignId('framework_controls_ids')->change()->constrained('framework_controls')->nullOnDelete()->cascadeOnUpdate('set null');
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
        Schema::table('questionnaire_risks', function (Blueprint $table) {
            $table->dropColumn('framework_controls_ids');
        });
    }
}
