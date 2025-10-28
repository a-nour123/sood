<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDynamicSavedSelectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dynamic_saved_selections', function (Blueprint $table) {
            $table->id();
            // I think value must be id primary key  AS $table->id();
            // $table->integer('user_id');
            // $table->integer('user_id');
            // $table->foreign('user_id')->references('value')->on('users')->default(0);
            $table->foreignId('user_id')->constrained('users');
            $table->enum('type', ['private', 'public']);
            $table->string('name', 100);
            $table->string('custom_display_settings', 1000)->nullable();
            $table->string('custom_selection_settings', 1000);
            $table->text('custom_column_filters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dynamic_saved_selections');
    }
}
