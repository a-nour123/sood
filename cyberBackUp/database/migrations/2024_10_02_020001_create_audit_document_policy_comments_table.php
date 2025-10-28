<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditDocumentPolicyCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('audit_document_policy_comments', function (Blueprint $table) {
            $table->id();
            $table->text('comment');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key to users
            $table->foreignId('aduit_id')->constrained('audit_document_policies')->onDelete('cascade'); // Foreign key to audit document policies
            $table->foreignId('document_policy_id')->constrained('document_policies')->onDelete('cascade'); // Foreign key to document_policies
            $table->unsignedBigInteger('replier_id')->nullable();
            $table->foreign('replier_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('audit_document_policy_comments');
    }
}
