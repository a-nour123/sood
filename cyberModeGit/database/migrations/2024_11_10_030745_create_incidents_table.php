<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->string('summary');
            $table->text('details')->nullable();
            $table->foreignId('direction_id')->constrained('directions')->onDelete('restrict'); //direction
            $table->foreignId('attack_id')->constrained('attacks')->onDelete('restrict'); //  attacks
            $table->foreignId('occurrence_id')->constrained('occurrences')->onDelete('restrict'); //case type
            $table->foreignId('detected_id')->constrained('detecteds')->onDelete('restrict'); // discover
            $table->timestamp('detected_on');
            $table->foreignId('created_by')->constrained('users')->onDelete('restrict'); //direction
            $table->enum('type', ['user', 'team'])->default('user');
            $table->enum('status', ['open ','progress ', 'closed'])->default('open');
            $table->string('source')->nullable(); // For source input
            $table->string('destination')->nullable(); // For destination input
            // $table->json('documents')->nullable();

            $table->foreignId('reported_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('playbook_type', ['user', 'team'])->default('user');
            $table->foreignId('play_book_id')->nullable()->constrained('play_books')->onDelete('set null');

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
        Schema::dropIfExists('incidents');
    }
}
