<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTemplateIdToCoursesTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_certificates', function (Blueprint $table) {
            if (!Schema::hasColumn('course_certificates', 'template_id')) {
                $table->foreignId('template_id')
                    ->nullable()
                    ->constrained('certificate_templates')
                    ->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_certificates', function (Blueprint $table) {
            if (Schema::hasColumn('course_certificates', 'template_id')) {
                $table->dropForeign(['template_id']);
                $table->dropColumn('template_id');
            }
        });
    }
}
