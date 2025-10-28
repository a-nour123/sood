<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->timestamp('timestamp')->useCurrent();
            $table->integer('risk_id'); // this colums mean record_id of the related table
            $table->foreignId('user_id')->constrained('users');
            $table->mediumText('message');
            $table->string('log_type', 100)->comment('This is table name');

            // $table->bigIncrements('id');
            // $table->text('description');
            // $table->unsignedBigInteger('subject_id')->nullable();
            // $table->string('subject_type')->nullable();
            // // $table->unsignedBigInteger('user_id')->nullable();
            // $table->foreignId('user_id')->nullable()->constrained('users');

            // $table->text('properties')->nullable();
            // $table->string('host', 46)->nullable();
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
        Schema::dropIfExists('audit_logs');
    }
}
