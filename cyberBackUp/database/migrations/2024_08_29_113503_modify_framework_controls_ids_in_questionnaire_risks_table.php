<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyFrameworkControlsIdsInQuestionnaireRisksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questionnaire_risks', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['framework_controls_ids']);
            
            // Modify the column to be nullable
            $table->foreignId('framework_controls_ids')->nullable()->change();

            // Reapply the foreign key constraint
            $table->foreign('framework_controls_ids')
                  ->references('id')
                  ->on('framework_controls')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
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
            // Drop the foreign key constraint
            $table->dropForeign(['framework_controls_ids']);
            
            // Change the column back to not nullable if needed (adjust as required)
            $table->foreignId('framework_controls_ids')->nullable(false)->change();

            // Reapply the original foreign key constraint
            $table->foreign('framework_controls_ids')
                  ->references('id')
                  ->on('framework_controls')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        });
    }
}
