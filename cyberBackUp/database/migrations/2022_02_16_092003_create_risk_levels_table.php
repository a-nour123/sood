<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_levels', function (Blueprint $table) {
            $table->id();
            $table->decimal('value', 3, 1);
            $table->string('name', 20);
            $table->string('color', 20);
            $table->string('display_name', 20)->nullable();
            $table->foreignId('review_level_id', 20)->constrained('review_levels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('risk_levels');
    }
}
