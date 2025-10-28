<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVideOrImageUrEnToLMSStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('l_m_s_statements', function (Blueprint $table) {
            $table->string('video_or_image_url_en')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('l_m_s_statements', function (Blueprint $table) {
            $table->dropColumn(['video_or_image_url_en']);
        });
    }
}
