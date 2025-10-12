<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDocumentTypeToAuditDocumentPolicies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audit_document_policies', function (Blueprint $table) {
            // Add the document_type column as a nullable foreign key
            $table->unsignedBigInteger('document_type')->nullable()->before('document_id'); // Replace 'some_existing_column' with the column after which the new column should appear
            
            // Create the foreign key constraint
            $table->foreign('document_type')
                  ->references('id')
                  ->on('document_types')
                  ->onDelete('set null'); // You can use 'cascade', 'restrict', etc., based on your needs
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audit_document_policies', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['document_type']);
            
            // Drop the document_type column
            $table->dropColumn('document_type');
        });
    }
}
