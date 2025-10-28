<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTrainingTypeToTariningModuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('l_m_s_training_modules', function (Blueprint $table) {
            $table->enum('training_type', ['public', 'campaign'])
                ->default('public')
                ->after('name')
                ->comment('Type of training module: public or campaign');
            $table->tinyInteger('count_of_entering_exam')
                ->default(0)
                ->after('training_type')
                ->comment('Number of times the exam can be entered');
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
            $table->dropColumn('training_type');
            $table->dropColumn('count_of_entering_exam');
        });
    }
}
