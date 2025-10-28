<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuditTypeToAuditsResponsiblesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('audits_responsibles', function (Blueprint $table) {
            $table->string('audit_type')->after('audit_name'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('audits_responsibles', function (Blueprint $table) {
            $table->dropColumn('audit_type');
        });
    }
}