<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExceptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exceptions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('exception_status', ['0','1'])->default('1')->comment('Status of the exception: 1 for open, 0 for closed');
            $table->enum('request_status', ['0','1','2'])->default('0')->comment('Status of the request: 0 for pending, 1 for approved, 2 for rejected');
            $table->enum('type',  ['policy','control', 'risk'])->nullable();
            $table->unsignedBigInteger('exception_creator')->nullable();
            $table->foreign('exception_creator')->references('id')->on('users')->onDelete('set null'); // Owner
            // $table->unsignedBigInteger('reviewer')->nullable();
            // $table->foreign('reviewer')->references('id')->on('users')->onDelete('set null'); // reviewer
            $table->json('stakeholder')->nullable();
            // $table->string('review_frequency')->nullable();
            $table->string('request_duration')->nullable();
            $table->date('approval_date')->nullable();
            // $table->date('next_review_date')->nullable();
            $table->string('policy_approver_id')->nullable();
            $table->string('policy_owner_id')->nullable();
            $table->string('control_approver_id')->nullable();
            $table->string('control_owner_id')->nullable();
            $table->string('risk_approver_id')->nullable();
            $table->string('risk_owner_id')->nullable();
            $table->text('description')->nullable();
            $table->text('justification')->nullable();
            $table->text('comment')->nullable();
            $table->string('exception_file')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('exceptions');
    }
}
