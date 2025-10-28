<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddControlIdToQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            if (Schema::hasTable('control_questions')) {
                Schema::disableForeignKeyConstraints();
                Schema::drop('control_questions');
                Schema::enableForeignKeyConstraints();
            }

            $table->foreignId('control_id')->after('answer_type')->nullable()->constrained('framework_controls')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropForeign('control_id');
            Schema::enableForeignKeyConstraints();
        });
    }
}
