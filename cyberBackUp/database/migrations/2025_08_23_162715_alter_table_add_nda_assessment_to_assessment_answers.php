<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableAddNdaAssessmentToAssessmentAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assessment_answers', function (Blueprint $table) {
            $table->boolean('submit_nda')->default(0);
            $table->foreignId('nda_id')->nullable()->constrained('ndas')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assessment_answers', function (Blueprint $table) {
            //
        });
    }
}