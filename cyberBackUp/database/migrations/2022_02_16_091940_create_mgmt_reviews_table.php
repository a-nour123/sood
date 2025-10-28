<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMgmtReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mgmt_reviews', function (Blueprint $table) {
            $table->id();
            // $table->integer('risk_id');
            $table->foreignId('risk_id')->constrained('risks')->onDelete('cascade');
            $table->timestamp('submission_date')->useCurrent();
            $table->foreignId('review')->nullable()->constrained('reviews');
            $table->foreignId('reviewer')->nullable()->constrained('users');
            // $table->integer('next_step');
            // $table->integer('next_step');
            // $table->foreign('next_step')->references('value')->on('next_steps');// column name must be next_step_id

            $table->foreignId('next_step_id')->nullable()->constrained('next_steps');

            
            $table->mediumText('comments')->nullable();
            $table->date('next_review')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mgmt_reviews');
    }
}
