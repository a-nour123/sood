<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToTableAssets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->text('url')->nullable();
            $table->foreignId('asset_environment_category_id')->nullable()->constrained('asset_environment_categories');
            $table->tinyInteger('os')->nullable(); // 0 windows , 1 linunx
            $table->string('os_version')->nullable();
            $table->tinyInteger('physical_virtual_type')->nullable(); // 0 physical , 1 virtual
            $table->string('owner_email')->nullable();
            $table->string('owner_manager_email')->nullable();
            $table->string('project_vlan')->nullable();
            $table->string('vlan')->nullable();
            $table->string('vendor_name')->nullable();
            $table->string('model')->nullable();
            $table->string('firmware')->nullable();
            $table->string('city')->nullable();
            $table->string('rack_location')->nullable();
            $table->string('mac_address')->nullable();
            $table->string('subnet_mask')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assets', function (Blueprint $table) {
            //
        });
    }
}
