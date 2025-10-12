<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('document_type')->nullable()->constrained('document_types')->nullOnDelete();
            $table->foreignId('document_type')->constrained('document_types');
            $table->foreignId('privacy')->nullable()->constrained('privacies')->nullOnDelete();
            $table->text('document_name')->nullable();
            $table->integer('parent')->nullable();
            $table->integer('document_status')->default(1)->comment('[1 => Draft],[2=> InReview, [3 => Approved]');
            $table->integer('file_id');
            // $table->foreignId('file_id')->nullable()->constrained('files');
            $table->date('creation_date')->nullable();
            $table->date('last_review_date')->nullable();
            $table->integer('review_frequency')->nullable();
            $table->date('next_review_date')->nullable();
            $table->date('approval_date')->nullable();
            $table->string('control_ids', 500)->nullable();
            $table->string('framework_ids', 500)->nullable();

            // $table->foreignId('control_ids')->nullable()->')->nullOnDelete();
            // $table->foreignId('framework_ids')->nullable()->constrained('frameworks')->nullOnDelete();
            // $table->foreignId('document_owner')->nullable()->constrained('control_owners')->nullOnDelete();

            $table->foreignId('document_owner')->constrained('users');
            $table->foreignId('document_reviewer')->nullable()->constrained('users')->nullOnDelete();

            //$table->foreignId('document_owner')->nullable()->constrained('users')->nullOnDelete();; // column name must be document_owner_id
            $table->string('additional_stakeholders', 500)->nullable();
            $table->integer('approver')->nullable();
            $table->string('team_ids', 500)->nullable();
            $table->foreignId('created_by')->constrained('users');

            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
