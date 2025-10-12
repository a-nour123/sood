<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateEvidenceAuditStatusColumnInControlAuditsEvidencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('control_audits_evidences', function (Blueprint $table) {
            DB::statement("ALTER TABLE control_audits_evidences MODIFY evidence_audit_status ENUM('no_action', 'approved', 'rejected', 'not_relevant') default 'no_action'");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('control_audits_evidences', function (Blueprint $table) {
            DB::statement("ALTER TABLE control_audits_evidences MODIFY evidence_audit_status ENUM('no_action', 'approved', 'rejected') default 'no_action'");

        });
    }
}
