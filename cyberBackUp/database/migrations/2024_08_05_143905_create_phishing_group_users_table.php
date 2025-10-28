<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhishingGroupUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phishing_group_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('phishing_group_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('phishing_group_id')->references('id')->on('phishing_groups')->onDelete('set null'); // Domains
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null'); // Website Pages
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
        Schema::dropIfExists('phishing_group_users');
    }
}
