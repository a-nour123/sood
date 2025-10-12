<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLMSStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('l_m_s_statements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->enum('additional_content',['no','video','image','navbar','spot']);
            $table->string('video_or_image_url')->nullable();
            $table->string('image')->nullable();
            $table->string('navbar_title')->nullable();
            $table->text('navbar_content')->nullable();
            $table->tinyInteger('page_number')->nullable();
            $table->unsignedBigInteger('training_module_id')->nullable();
            $table->foreign('training_module_id')->references('id')->on('l_m_s_training_modules')->onDelete('set null');
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
        Schema::dropIfExists('l_m_s_statements');
    }
}
