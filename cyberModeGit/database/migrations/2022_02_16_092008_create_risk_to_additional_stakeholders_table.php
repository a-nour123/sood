<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskToAdditionalStakeholdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_to_additional_stakeholders', function (Blueprint $table) {
            $table->foreignId('risk_id')->constrained('risks')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users');
            
            $table->primary(['risk_id', 'user_id']);
            $table->index(['user_id', 'risk_id'], 'user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('risk_to_additional_stakeholders');
    }
}
