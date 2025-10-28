<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentExceptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_exceptions', function (Blueprint $table) {
            $table->id();
            // I think value must be id primary key  AS $table->id();
            $table->string('name', 100);
            $table->integer('policy_document_id')->nullable();
            $table->integer('control_framework_id')->nullable();
            $table->integer('owner')->nullable();
            $table->string('additional_stakeholders', 500);
            $table->date('creation_date')->default('0000-00-00');
            $table->integer('review_frequency')->default(0);
            $table->date('next_review_date')->default('0000-00-00');
            $table->date('approval_date')->default('0000-00-00');
            $table->integer('approver')->nullable();
            $table->boolean('approved')->default(0);
            $table->text('description');
            $table->text('justification');
            $table->integer('file_id');
            $table->text('associated_risks');
            $table->integer('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_exceptions');
    }
}
