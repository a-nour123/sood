<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditDocumentTotalStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_document_total_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('audit_id')->constrained('audit_document_policies'); // Assuming there's an audits table
            $table->foreignId('document_id')->constrained('documents'); // Assuming there's a documents table
            $table->foreignId('user_id')->constrained('users'); // Assuming there's a users table
            $table->string('total_status')->nullable(); // The total status column
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_document_total_statuses');
    }
}
