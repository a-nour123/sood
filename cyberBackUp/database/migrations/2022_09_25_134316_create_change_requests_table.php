<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChangeRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('change_requests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('display_file_name', 250)->nullable();
            $table->string('unique_file_name', 100)->nullable();
            $table->enum('status', ['Department-Manager-In-Review', 'Department-Manager-Rejected', 'Responsible-Department-In-Review', 'Responsible-Department-Accepted', 'Responsible-Department-Rejected']);
            $table->enum('review_cycle', ['Department-Manager-Review', 'Responsible-Department-Review']);
            $table->enum('start_review_cycle', ['Department-Manager-Review', 'Responsible-Department-Review']);
            $table->string('rejection_reason', 500)->nullable();
            $table->foreignId('created_by')->constrained('users');

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
        Schema::dropIfExists('change_requests');
    }
}
