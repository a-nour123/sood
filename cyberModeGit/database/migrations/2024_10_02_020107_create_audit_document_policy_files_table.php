<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditDocumentPolicyFilesTable extends Migration
{
    public function up()
    {
        Schema::create('audit_document_policy_files', function (Blueprint $table) {
            $table->id();
            $table->string('evidenc_name')->nullable();
            $table->string('description')->nullable();
            $table->string('file_path');
            $table->string('file_name');
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade'); // Foreign key to users
            $table->foreignId('aduit_id')->constrained('audit_document_policies')->onDelete('cascade'); // Foreign key to audit document policies
            $table->foreignId('document_policy_id')->constrained('document_policies')->onDelete('cascade'); // Foreign key to document_policies
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('audit_document_policy_files');
    }
}
