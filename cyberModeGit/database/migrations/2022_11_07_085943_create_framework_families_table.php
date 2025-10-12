<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrameworkFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('framework_families', function (Blueprint $table) {
            $table->id();
            $table->foreignId('framework_id')->constrained('frameworks')->onDelete('cascade');
            $table->foreignId('family_id')->constrained('families');
            $table->foreignId('parent_family_id')->nullable()->constrained('families');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('framework_families');
    }
}
