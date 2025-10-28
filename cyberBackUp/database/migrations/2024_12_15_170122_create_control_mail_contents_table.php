<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlMailContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control_mail_contents', function (Blueprint $table) {
            $table->id();
            $table->string('type');   // Column for survey type
            $table->string('subject');   // Column for survey type
            $table->text('content');  // Column for survey content
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
        Schema::dropIfExists('control_mail_contents');
    }
}
