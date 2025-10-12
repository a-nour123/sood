<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrameworkControlTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('framework_control_test_results', function (Blueprint $table) {
            $table->id();
            // $table->integer('test_audit_id');
            $table->foreignId('test_audit_id')->constrained('framework_control_test_audits')->onDelete('cascade'); // table name nust be framework_control_test_audit_id
            $table->foreignId('test_result')->nullable()->constrained('test_results');

            $table->text('summary');
            $table->date('test_date');
            $table->integer('submitted_by');
            $table->dateTime('submission_date');
            $table->integer('remediation')->comment("1 = yes, 0 = no"); // Adjust 'after' to place it correctly
            $table->timestamp('last_updated')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('framework_control_test_results');
    }
}
