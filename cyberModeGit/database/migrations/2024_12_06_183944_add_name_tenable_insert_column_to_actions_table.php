<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class AddNameTenableInsertColumnToActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Insert records with explicit 'id' values
        DB::table('actions')->insert([
            ['id' => 121, 'name' => 'FinishTenableAssetRegion'],
            ['id' => 122, 'name' => 'FinishTenableAssetGroup'],
            ['id' => 123, 'name' => 'AlertSuccessfullySenttoAssetOwner'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Delete the records that were inserted by the migration
        DB::table('actions')->where('id', 113)->delete();
        DB::table('actions')->where('id', 114)->delete();
    }
}
