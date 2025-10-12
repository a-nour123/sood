<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemediationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remediation_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('responsible_user');
            $table->foreign('responsible_user')->references('id')->on('users');
            $table->text('corrective_action_plan')->nullable();
            $table->decimal('budgetary', 10, 2)->nullable();
            $table->integer('status')->nullable()->comment('Status of the remediation, where 1 is approved and 2 is rejected');
            $table->date('due_date')->nullable();
            $table->text('comments')->nullable();
            $table->unsignedBigInteger('control_test_id')->nullable(); // Replace 'existing_column' with the column name after which you want to add this column
            $table->foreign('control_test_id')->references('id')->on('framework_control_test_audits');
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
        Schema::dropIfExists('remediation_details');
    }
}
