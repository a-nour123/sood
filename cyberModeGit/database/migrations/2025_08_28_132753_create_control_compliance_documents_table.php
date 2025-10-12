<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlComplianceDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control_compliance_documents', function (Blueprint $table) {
            $table->id();

            // Must match parent table type (BIGINT UNSIGNED)
            $table->unsignedBigInteger('mapped_controls_compliance_id');
            $table->unsignedBigInteger('control_id');

            $table->json('document_actions');
            $table->timestamps();

            // Short foreign key names
            $table->foreign('mapped_controls_compliance_id', 'ccdocs_mcc_id_fk')
                ->references('id')
                ->on('mapped_controls_compliances')
                ->onDelete('cascade');

            $table->foreign('control_id', 'ccdocs_control_id_fk')
                ->references('id')
                ->on('framework_controls')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('control_compliance_documents');
    }
}