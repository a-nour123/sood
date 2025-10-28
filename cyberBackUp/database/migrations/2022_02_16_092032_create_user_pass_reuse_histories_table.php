<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPassReuseHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_pass_reuse_histories', function (Blueprint $table) {
            $table->id();
            // $table->integer('user_id');
            // $table->integer('user_id');
            // $table->foreign('user_id')->references('value')->on('users');
            $table->foreignId('user_id')->constrained('users');

            $table->string('password', 60);
            $table->integer('counts')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_pass_reuse_histories');
    }
}
