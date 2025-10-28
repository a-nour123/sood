<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditsResponsiblesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audits_responsibles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('regulator_id')->constrained()->onDelete('cascade');
            $table->foreignId('framework_id')->constrained()->onDelete('cascade');
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->text('responsible')->nullable(); // Store users or teams
            $table->enum('responsible_type', ['users', 'teams']); // New column for type
            $table->date('start_date');
            $table->date('due_date');
            $table->integer('periodical_time');
            $table->date('next_initiate_date')->nullable();
            $table->timestamp('initiate_date')->useCurrent();
            $table->integer('test_number_initiated');
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
        Schema::dropIfExists('audits_responsibles');
    }
}
