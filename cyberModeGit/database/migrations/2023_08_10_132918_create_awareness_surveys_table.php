<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwarenessSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('awareness_surveys', function (Blueprint $table) {
            $table->id();
            $table->string('name', 512);
            $table->string('additional_stakeholder',512)->nullable();
            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();

//             $table->foreignId('owner_id')
// ->nullable()->default(function () {return auth()->user()->id;})->constrained('users')->onDelete('cascade');            
            $table->string('team',512)->nullable();
            $table->date('last_review_date')->nullable();
            $table->integer('review_frequency')->nullable();
            $table->date('next_review_date')->nullable();
            $table->text('description',555);
            $table->foreignId('privacy')->references('id')->on('privacies')->onDelete('cascade')->default(1);
            $table->foreignId('filter_status')->references('id')->on('document_statuses')
            ->onDelete('cascade')->default(1);
            $table->date('approval_date')->nullable();
            $table->string('reviewer',255)->nullable();
            $table->boolean('all_questions_mandatory')->nullable();
            $table->boolean('answer_percentage')->nullable();
            $table->tinyInteger('percentage_number')->nullable();
            $table->boolean('specific_mandatory_questions')->nullable();
            $table->string('questions', 512)->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
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
        Schema::dropIfExists('awareness_surveys');
    }
}
