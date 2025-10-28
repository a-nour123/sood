<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttachedToAssessmentAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assessment_answers', function (Blueprint $table) {
            $table->boolean('attached')->default(false)->after('fail_control');
        });
    }
    
    public function down()
    {
        Schema::table('assessment_answers', function (Blueprint $table) {
            $table->dropColumn('attached');
        });
    }
    
}
