<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuditFunctionToAuditsResponsiblesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audits_responsibles', function (Blueprint $table) {
            $table->string('audit_function')->after('audit_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audits_responsibles', function (Blueprint $table) {
            $table->dropColumn('audit_function');
        });
    }
}