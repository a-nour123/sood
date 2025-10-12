<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrameworkControlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('framework_controls', function (Blueprint $table) {
            $table->id();
            $table->string('short_name', 1000)->nullable();
            $table->string('long_name', 500)->nullable();
            $table->text('description')->nullable();
            $table->text('supplemental_guidance')->nullable();
            $table->string('control_number', 100)->nullable();
            $table->enum('control_status', ['Not Applicable', 'Not Implemented', 'Partially Implemented','Implemented'])->default('Not Applicable');
            $table->foreignId('family')->nullable()->constrained('families');
            $table->foreignId('control_owner')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('desired_maturity')->nullable()->constrained('control_desired_maturities')->nullOnDelete();
            $table->foreignId('control_priority')->nullable()->constrained('control_priorities')->nullOnDelete();
            $table->foreignId('control_class')->nullable()->constrained('control_classes')->nullOnDelete();
            $table->foreignId('control_maturity')->nullable()->default(1)->constrained('control_maturities')->nullOnDelete();
            $table->foreignId('control_phase')->nullable()->constrained('control_phases')->nullOnDelete();
            $table->foreignId('control_type')->nullable()->constrained('control_types')->nullOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('framework_controls');

            // $table->integer('control_owner')->nullable();
            // $table->integer('desired_maturity')->nullable();
            // $table->integer('control_priority')->nullable();
            // $table->integer('control_class')->nullable();
            // $table->integer('control_maturity')->nullable();
            // $table->integer('control_phase')->nullable();

            $table->timestamp('submission_date')->useCurrent();
            $table->date('last_audit_date')->nullable();
            $table->date('next_audit_date')->nullable();
            $table->integer('desired_frequency')->nullable();
            $table->integer('mitigation_percent')->nullable()->default(0);
            $table->integer('status')->nullable()->default(1);
            $table->boolean('deleted')->nullable()->default(0);
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

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('framework_controls');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
