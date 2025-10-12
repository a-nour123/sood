<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCourse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->unsignedBigInteger('certificate_template_id')->nullable()->after('passing_grade');
            $table->boolean('auto_send_certificate')->default(false)->after('certificate_template_id');
            $table->foreign('certificate_template_id')->references('id')->on('certificate_templates')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['certificate_template_id']);
            $table->dropColumn('certificate_template_id');
            $table->dropColumn('auto_send_certificate');
        });
    }
}
