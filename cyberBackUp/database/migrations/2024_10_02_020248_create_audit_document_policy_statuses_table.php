<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditDocumentPolicyStatusesTable extends Migration
{
    public function up()
    {
        Schema::create('audit_document_policy_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable();
            $table->string('auditer_status')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key to users
            $table->foreignId('aduit_id')->constrained('audit_document_policies')->onDelete('cascade'); // Foreign key to audit document policies
            $table->foreignId('document_policy_id')->constrained('document_policies')->onDelete('cascade'); // Foreign key to document_policies
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('audit_document_policy_statuses');
    }
}
