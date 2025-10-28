<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsToTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_to_teams', function (Blueprint $table) {
            $table->integer('item_id');
            // $table->integer('team_id');
            // $table->integer('team_id');
            // $table->foreign('team_id')->references('value')->on('teams');
            $table->foreignId('team_id')->constrained('teams');
            $table->string('type', 20)->index('type');

            $table->unique(['item_id', 'team_id', 'type'], 'item_team_unique');
            $table->index(['item_id', 'type'], 'item_type');
            $table->index(['team_id', 'type'], 'team_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items_to_teams');
    }
}
