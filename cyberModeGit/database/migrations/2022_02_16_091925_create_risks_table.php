<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRisksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risks', function (Blueprint $table) {
            $table->id();
            $table->string('status', 20)->index('status')->default('New'); // (String) ["New"]
            $table->longText('subject'); // (String) 
            $table->string('reference_id', 20)->nullable(); // (String) 
            $table->integer('regulation')->nullable()->index('regulation'); // (Int)
            // $table->string('control_number', 20)->nullable(); // (String) []
            // $table->foreignId('framework_id')->nullable()->constrained('frameworks');
            $table->foreignId('control_id')->nullable()->constrained('framework_controls');
            $table->foreignId('source_id')->nullable()->constrained('sources');
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->foreignId('owner_id')->nullable()->constrained('users');
            $table->foreignId('manager_id')->nullable()->constrained('users');
            $table->longText('assessment')->nullable(); // (String) 
            $table->longText('notes')->nullable(); // (String) 
            $table->timestamp('review_date')->default('0000-00-00 00:00:00');
            $table->foreignId('mitigation_id')->nullable()->constrained('mitigations');
            // $table->foreignId('mitigation_id')->constrained('mitigations')->default(0);
            $table->integer('mgmt_review')->nullable()->index('mgmt_review');
            // $table->integer('mgmt_review')->default(0)->index('mgmt_review');
            $table->foreignId('project_id')->nullable()->constrained('projects'); // (String) 

            $table->integer('close_id')->nullable()->index('close_id');
            // $table->foreignId('close_id')->constrained('close_reasons'); // column name must be close_reason_id        
            $table->integer('submitted_by')->default(1)->index('submitted_by'); // (Int) `submitted_by` is defaulted to 1 as that's the id of the pre-created Admin user,
            $table->string('risk_catalog_mapping')->nullable(); // (String) []
            $table->string('threat_catalog_mapping')->nullable(); // (String) []
            $table->integer('template_group_id')->default(1); // (Int)
            $table->timestamp('submission_date')->useCurrent(); // (String) 
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
        Schema::dropIfExists('risks');
    }
}
