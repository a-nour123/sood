<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditDocumentPolicyPolicyDocumentTable extends Migration
{
    public function up()
    {
        Schema::create('audit_document_policy_policy_document', function (Blueprint $table) {
            $table->id();
            $table->foreignId('audit_document_policy_id')->unsigned();
            $table->foreignId('policy_document_id')->unsigned();
            $table->timestamps();
        });

        // Add foreign key constraints separately
        Schema::table('audit_document_policy_policy_document', function (Blueprint $table) {
            $table->foreign('audit_document_policy_id', 'fk_audit_document_policy')
                  ->references('id')->on('audit_document_policies')
                  ->onDelete('cascade');

            $table->foreign('policy_document_id', 'fk_policy_document')
                  ->references('id')->on('document_policies')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('audit_document_policy_policy_document');
    }
}
