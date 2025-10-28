<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailAutoNotfies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_auto_notfies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('action_id');
            $table->foreign('action_id', 'mail_auto_notify_foreign')->references('id')->on('actions');
            $table->text('subject');
            $table->text('message');
            $table->string('date');
            $table->boolean('status');
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
        Schema::dropIfExists('mail_auto_notfies');
    }
}
