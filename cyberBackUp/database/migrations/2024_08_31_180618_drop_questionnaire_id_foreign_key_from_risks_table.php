<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropQuestionnaireIdForeignKeyFromRisksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risks', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['questionnaire_id']);
            
            // Drop the column (optional but safer to ensure no issues)
            $table->dropColumn('questionnaire_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('risks', function (Blueprint $table) {
            // Re-add the column with a foreign key
            $table->foreignId('questionnaire_id')->nullable()->constrained('questionnaires');
        });
    }
}