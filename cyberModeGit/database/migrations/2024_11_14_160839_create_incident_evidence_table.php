<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentEvidenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incident_evidence', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incident_play_book_action_id')->constrained('incident_play_book_actions')->onDelete('cascade');
            $table->foreignId('creator_id')->constrained('users')->onDelete('restrict');
            $table->text('description');
            $table->text('file_name')->nullable();
            $table->text('file_unique_name')->nullable();
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
        Schema::dropIfExists('inciden_evidence');
    }
}
