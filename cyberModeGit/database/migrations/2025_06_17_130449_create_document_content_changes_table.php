<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('document_content_changes', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('document_id');
            $table->string('status');
            $table->string('file_path');
            $table->string('file_name');
            
            $table->foreign('document_id')
                  ->references('id')
                  ->on('documents')
                  ->onDelete('cascade');
            
            $table->longText('old_content');
            $table->longText('new_content');
            
            $table->unsignedBigInteger('changed_by')->nullable();
            $table->foreign('changed_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('document_content_changes');
    }
};