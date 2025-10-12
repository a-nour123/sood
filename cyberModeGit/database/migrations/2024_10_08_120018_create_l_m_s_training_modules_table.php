<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLMSTrainingModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('l_m_s_training_modules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('passing_score')->default(70);
            $table->string('module_language')->nullable();
            $table->integer('completion_time');
            $table->string('cover_image')->nullable();
            $table->string('cover_image_url')->nullable();
            $table->tinyInteger('order'); // Order within the level
            $table->unsignedBigInteger('level_id')->nullable();
            $table->foreign('level_id')->references('id')->on('l_m_s_levels')->onDelete('set null');
            $table->softDeletes();
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
        Schema::dropIfExists('l_m_s_training_modules');
    }
}
