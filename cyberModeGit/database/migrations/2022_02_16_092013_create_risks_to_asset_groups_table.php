<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRisksToAssetGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risks_to_asset_groups', function (Blueprint $table) {
            // $table->integer('risk_id');
            $table->foreignId('risk_id')->constrained('risks')->onDelete('cascade');
            // $table->integer('asset_group_id');
            $table->foreignId('asset_group_id')->constrained('asset_groups');
            
            $table->unique(['risk_id', 'asset_group_id'], 'risk_asset_group_unique');
            $table->index(['asset_group_id', 'risk_id'], 'asset_group_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('risks_to_asset_groups');
    }
}
