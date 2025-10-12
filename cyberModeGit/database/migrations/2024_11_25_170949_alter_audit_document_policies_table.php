<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAuditDocumentPoliciesTable extends Migration
{
    public function up()
    {
        Schema::table('audit_document_policies', function (Blueprint $table) {
             $table->text('aduit_name')->change(); // Change to text for larger capacity
        });
    }

    public function down()
    {
        Schema::table('audit_document_policies', function (Blueprint $table) {
            $table->string('aduit_name', 255)->change(); // Revert back to 255 if rolled back
        });
    }
}
