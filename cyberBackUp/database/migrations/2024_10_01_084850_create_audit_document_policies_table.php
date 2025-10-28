<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditDocumentPoliciesTable extends Migration
{
    public function up()
    {
        Schema::create('audit_document_policies', function (Blueprint $table) {
            $table->id();
            $table->string('aduit_name');
            $table->boolean('enable_audit')->default(1);
            $table->foreignId('document_id')->constrained('documents')->onDelete('cascade');
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade'); // Assuming owner is a user
            $table->string('responsible')->nullable(); // Add the responsible column
            $table->date('start_date');
            $table->date('due_date');
            $table->integer('periodical_time')->default(0);
            $table->date('next_initiate_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('audit_document_policies');
    }
}
