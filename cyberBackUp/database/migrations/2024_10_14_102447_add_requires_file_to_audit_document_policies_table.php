<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRequiresFileToAuditDocumentPoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audit_document_policies', function (Blueprint $table) {
            $table->boolean('requires_file')->default(0)->after('document_id'); // replace 'column_name' with the column after which you want to add the new one
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
            $table->dropColumn('requires_file');
        });
    }
}
