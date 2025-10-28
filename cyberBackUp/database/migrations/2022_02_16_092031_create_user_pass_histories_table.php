<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPassHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_pass_histories', function (Blueprint $table) {
            $table->id();
            // $table->integer('user_id');
            // $table->integer('user_id');
            // $table->foreign('user_id')->references('value')->on('users');
            $table->foreignId('user_id')->constrained('users');
            
            $table->string('salt', 20);
            $table->string('password', 60);
            $table->timestamp('add_date')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_pass_histories');
    }
}
