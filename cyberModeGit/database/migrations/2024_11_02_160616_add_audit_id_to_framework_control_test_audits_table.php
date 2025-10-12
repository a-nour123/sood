<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuditIdToFrameworkControlTestAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('framework_control_test_audits', function (Blueprint $table) {
            $table->unsignedBigInteger('audit_id')->nullable()->after('id'); // Add the new column
            $table->foreign('audit_id')->references('id')->on('audits_responsibles')->onDelete('set null');
            $table->boolean('can_see')
            ->default(0)
            ->comment('0 = Sedation not created, 1 = Sedation created; responsible can see the audit')
            ->after('audit_id');
            $table->boolean('action_status')
            ->default(0)
            ->comment('0 = Auditer Make the Auditopen, 1 = Auditer Make the Audit closed For Any reason')
            ->after('status');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('framework_control_test_audits', function (Blueprint $table) {
            $table->dropForeign(['audit_id']);
            $table->dropColumn('audit_id');
            $table->dropColumn('can_see');

        });
    }
}
