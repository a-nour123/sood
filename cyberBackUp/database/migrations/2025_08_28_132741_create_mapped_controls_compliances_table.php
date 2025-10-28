<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMappedControlsCompliancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mapped_controls_compliances', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->foreignId('regulator_id')->constrained()->onDelete('cascade');
            $table->foreignId('framework_id')->constrained()->onDelete('cascade');
            $table->text('reviewer_id'); // Storing as text for imploded values
            $table->date('start_date');
            $table->date('due_date');
            $table->integer('periodical_date')->nullable();
            $table->integer('enable_edit')->default(0);
            $table->date('next_initiate_date')->nullable();
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
        Schema::dropIfExists('mapped_controls_compliances');
    }
}