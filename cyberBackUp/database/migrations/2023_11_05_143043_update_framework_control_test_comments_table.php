<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFrameworkControlTestCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('framework_control_test_comments', function (Blueprint $table) {
            $table->unsignedBigInteger('user')->change();
            $table->foreign('user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('framework_control_test_comments', function (Blueprint $table) {
            $table->dropForeign(['user']);
        });
    }
}
