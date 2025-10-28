<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeededFrameworksTable extends Migration
{
    public function up()
    {
        Schema::create('seeded_frameworks', function (Blueprint $table) {
            $table->id();
            $table->string('framework');
            $table->boolean('mapping')->default(false);
            $table->boolean('document')->default(false);
            $table->boolean('requirement')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('seeded_frameworks');
    }
}
