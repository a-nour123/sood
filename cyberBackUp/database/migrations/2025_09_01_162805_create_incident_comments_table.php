<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incident_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('incident_id');
            $table->unsignedBigInteger('playbook_id');
            $table->unsignedBigInteger('action_id');
            $table->unsignedBigInteger('user_id');
            $table->text('comment')->nullable();
            $table->string('file_display_name')->nullable(); // if user uploads evidence/files
            $table->string('file_unique_name')->nullable(); // if user uploads evidence/files
            
            $table->timestamps();

            $table->foreign('incident_id')->references('id')->on('incidents')->onDelete('cascade');
            $table->foreign('playbook_id')->references('id')->on('play_books')->onDelete('cascade');
            $table->foreign('action_id')->references('id')->on('incident_play_book_actions')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incident_comments');
    }
}