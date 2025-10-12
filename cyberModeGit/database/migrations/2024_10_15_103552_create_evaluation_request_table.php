<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_request', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluation_id')->nullable()->constrained('third_party_evaluations','id')->cascadeOnDelete();
            $table->foreignId('request_id')->nullable()->constrained('third_party_requests','id')->cascadeOnDelete();
            $table->boolean('answer')->nullable()->comment('0=>No, 1=>Yes');
            $table->longText('comment')->nullable();
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
        Schema::dropIfExists('evaluation_request');
    }
}
