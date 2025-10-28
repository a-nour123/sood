<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArabicColumnsToLMSStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('l_m_s_statements', function (Blueprint $table) {
            $table->string('title_ar')->nullable();
            $table->text('content_ar')->nullable();
            $table->string('image_ar')->nullable();
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
            $table->dropColumn(['title_ar', 'content_ar','image_ar']);
        });
    }
}
