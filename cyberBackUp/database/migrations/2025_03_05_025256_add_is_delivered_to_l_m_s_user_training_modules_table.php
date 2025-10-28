<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsDeliveredToLMSUserTrainingModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('l_m_s_user_training_modules', function (Blueprint $table) {
            $table->tinyInteger('is_delivered')->default(0);
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
            $table->dropColumn(['is_delivered']);
        });
    }
}
