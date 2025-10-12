<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayBookActionPlayBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('play_book_action_play_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('play_book_action_id')->constrained('play_book_actions')->onDelete('cascade');
            $table->foreignId('play_book_id')->constrained('play_books')->onDelete('cascade');
            $table->enum('category_type', ['containments', 'eradications', 'recoveries']);
            $table->unsignedBigInteger('category_id')->nullable();
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
        Schema::dropIfExists('play_book_action_play_books');
    }
}
