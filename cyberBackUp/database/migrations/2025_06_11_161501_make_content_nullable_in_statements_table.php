<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeContentNullableInStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('l_m_s_statements', function (Blueprint $table) {
            $table->text('title')->nullable()->change();
            $table->text('content')->nullable()->change();
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
            $table->text('title')->nullable(false)->change();
            $table->text('content')->nullable(false)->change();
        });
    }
}
