<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayBookTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('play_book_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('playbook_id')->constrained('play_books')->onDelete('cascade');
            $table->foreignId('team_id')->constrained('teams')->onDelete('restrict');
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
        Schema::dropIfExists('play_book_teams');
    }
}
