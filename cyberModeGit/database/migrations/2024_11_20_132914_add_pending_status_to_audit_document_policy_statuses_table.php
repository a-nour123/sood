<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPendingStatusToAuditDocumentPolicyStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audit_document_policy_statuses', function (Blueprint $table) {
            $table->string('pending_status')->nullable()->after('status')->commwnt("this status is created to collect all status of the user before submit the end result"); // Replace 'column_name' with the column after which you want to add 'pending_status'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audit_document_policy_statuses', function (Blueprint $table) {
            $table->dropColumn('pending_status');
        });
    }
}

