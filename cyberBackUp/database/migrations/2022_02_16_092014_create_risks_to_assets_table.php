<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRisksToAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risks_to_assets', function (Blueprint $table) {
            // $table->integer('risk_id')->nullable();
            $table->foreignId('risk_id')->constrained('risks')->onDelete('cascade');
            // $table->integer('asset_id');
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');

            $table->unique(['risk_id', 'asset_id'], 'risk_id');
            $table->index(['asset_id', 'risk_id'], 'asset_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('risks_to_assets');
    }
}
