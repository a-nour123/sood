<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeFileColumnsNullableInAuditDocumentPolicyFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audit_document_policy_files', function (Blueprint $table) {
            $table->string('file_path')->nullable()->change();
            $table->string('file_name')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audit_document_policy_files', function (Blueprint $table) {
            $table->string('file_path')->nullable(false)->change();
            $table->string('file_name')->nullable(false)->change();
        });
    }
}