<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSecurityAwarenessExamAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('security_awareness_exam_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('security_awareness_exams_id');
            $table->foreign('security_awareness_exams_id', 'security_awareness_exam_answers_foreign')->references('id')->on('security_awareness_exams');
            $table->foreignId('examinee')->nullable()->constrained('users');
            $table->tinyInteger('success_answers');
            $table->tinyInteger('fail_answers');
            $table->string('uniqid')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('security_awareness_exam_answers');
    }
}
