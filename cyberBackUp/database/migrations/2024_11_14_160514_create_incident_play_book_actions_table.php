<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentPlayBookActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incident_play_book_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('playbook_id')->constrained('play_books')->onDelete('cascade');
            $table->foreignId('incident_id')->constrained()->onDelete('cascade');
            $table->foreignId('play_book_action_id')->constrained('play_book_actions')->onDelete('cascade');
            $table->integer('status')->default(0);
            $table->integer('active')->default(0);
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
        Schema::dropIfExists('incident_play_book_actions');
    }
}
