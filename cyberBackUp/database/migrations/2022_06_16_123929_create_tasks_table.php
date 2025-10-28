<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->text('description');
            $table->enum('priority', ['Urgent', 'High', 'Normal', 'Low', 'No Priority']);
            $table->enum('status', ['Open', 'In Progress', 'Completed', 'Accepted', 'Closed'])->default('Open');
            $table->date('start_date');
            $table->date('due_date');
            $table->timestamp('completed_date')->nullable();
            $table->timestamp('accepted_date')->nullable();
            $table->boolean('completed')->default(0);
            $table->unsignedBigInteger('assignable_id');
            $table->string('assignable_type');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('action_by')->nullable()->constrained('users'); // assigned action for ['In Progress', 'Completed'] status
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
        Schema::dropIfExists('tasks');
    }
}
