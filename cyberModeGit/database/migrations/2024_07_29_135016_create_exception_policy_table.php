<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExceptionPolicyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exception_policy', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('exception_id')->nullable();
            $table->foreign('exception_id')->references('id')->on('exceptions')->onDelete('set null'); // Exception

            $table->unsignedBigInteger('policy_id')->nullable();
            $table->foreign('policy_id')->references('id')->on('documents')->onDelete('set null'); // Policies

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
        Schema::dropIfExists('exception_policy');
    }
}
