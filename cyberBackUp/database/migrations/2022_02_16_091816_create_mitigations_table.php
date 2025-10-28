<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMitigationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mitigations', function (Blueprint $table) {
            $table->id();
            // $table->integer('risk_id')->index('risk_id');
            $table->timestamp('submission_date')->useCurrent();
            $table->timestamp('last_update')->nullable();
            // $table->integer('planning_strategy');
            $table->foreignId('planning_strategy')->nullable()->constrained('planning_strategies'); // column name must be planning_strategy_id
            // $table->integer('mitigation_effort');
            $table->foreignId('mitigation_effort')->nullable()->constrained('mitigation_efforts'); // column name must be mitigation_effort_id
            // $table->integer('mitigation_cost')->default(1);
            $table->integer('mitigation_cost')->nullable()->constrained('asset_values'); // column name must be asset_values_id
            // $table->integer('mitigation_owner');
            $table->foreignId('mitigation_owner')->nullable()->constrained('users'); // column name must be mitigation_owner_id
            $table->mediumText('current_solution')->nullable();
            $table->mediumText('security_requirements')->nullable();
            $table->mediumText('security_recommendations')->nullable();
            $table->integer('submitted_by')->default(1);
            $table->date('planning_date');
            $table->integer('mitigation_percent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mitigations');
    }
}
