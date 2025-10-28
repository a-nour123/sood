<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLMSUserTrainingModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('l_m_s_user_training_modules', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            $table->unsignedBigInteger('training_module_id')->nullable();
            $table->foreign('training_module_id')->references('id')->on('l_m_s_training_modules')->onDelete('set null');

            $table->decimal('score')->default(0);
            $table->boolean('passed')->default(false);
            $table->boolean('unlocked')->default(false);
            $table->tinyInteger('days_until_due')->nullable();
            
            $table->dateTime('completed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('l_m_s_user_training_modules');
    }
}
