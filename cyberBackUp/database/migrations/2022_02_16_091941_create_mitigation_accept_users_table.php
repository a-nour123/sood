<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMitigationAcceptUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mitigation_accept_users', function (Blueprint $table) {
            $table->id();
            // $table->integer('risk_id')->index('risk_id');
            $table->foreignId('risk_id')->constrained('risks')->onDelete('cascade');
            // // $table->integer('user_id');
            // $table->integer('user_id');
            // $table->integer('user_id');
            // $table->foreign('user_id')->references('value')->on('users');

            $table->foreignId('user_id')->constrained('users');


            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mitigation_accept_users');
    }
}
