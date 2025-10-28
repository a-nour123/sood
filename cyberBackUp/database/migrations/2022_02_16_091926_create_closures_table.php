<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClosuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('closures', function (Blueprint $table) {
            $table->id();
            // $table->integer('risk_id');
            $table->foreignId('risk_id')->constrained('risks')->onDelete('cascade');
            // $table->integer('user_id');
            // $table->integer('user_id');
            // $table->foreign('user_id')->references('value')->on('users');
            $table->foreignId('user_id')->constrained('users');

            $table->timestamp('closure_date')->useCurrent();
            $table->integer('close_reason')->nullable();
            $table->mediumText('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('closures');
    }
}
