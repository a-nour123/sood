<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAssetValueIdAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->foreignId('asset_value_id')->nullable()->change();
            $table->foreignId('asset_value_level_id')->nullable()->constrained('asset_value_levels');
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
            $table->dropForeign(['asset_value_id'])->nullable(false)->change();
            $table->dropColumn(['asset_value_level_id']);
        });
    }
}
