<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentPoliciesTable extends Migration
{
    public function up()
    {
        Schema::create('document_policies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('policy_id');
            $table->unsignedBigInteger('document_id');
            $table->timestamps();

            // Define foreign keys after the columns are created
            $table->foreign('policy_id')
                ->references('id')->on('center_policies')
                ->onDelete('cascade');
            $table->foreign('document_id')
                ->references('id')->on('documents')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('document_policies');
    }
}
