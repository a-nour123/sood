<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlObjectivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control_objectives', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->tinyText('description');
            $table->text('framework_id'); // To store comma-separated framework IDs
            $table->text('control_id'); // To store comma-separated control IDs
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
        Schema::dropIfExists('control_objectives');
    }
}
