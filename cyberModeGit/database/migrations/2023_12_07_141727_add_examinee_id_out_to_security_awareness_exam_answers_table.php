<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExamineeIdOutToSecurityAwarenessExamAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('security_awareness_exam_answers', function (Blueprint $table) {
            $table->foreignId('examinee_idOut')->nullable()->references('id')->on('user_out_side_cybers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('security_awareness_exam_answers', function (Blueprint $table) {
            $table->dropForeign('security_awareness_exam_answers_examinee_idOut_foreign');
            $table->dropColumn('examinee_idOut');
        });
    }
}
