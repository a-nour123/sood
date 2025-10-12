<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ModifyOsColumnInAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assets', function (Blueprint $table) {
            DB::table('assets')->update(['os' => null]);
            // Change the column type to an unsigned big integer
            $table->unsignedBigInteger('os')->change();

            // Add foreign key constraint
            $table->foreign('os')->references('id')->on('operating_systems');
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
            // Drop foreign key constraint
            $table->dropForeign(['os']);

            // Change the column type back to tinyint
            $table->tinyInteger('os')->change();
        });
    }
}
