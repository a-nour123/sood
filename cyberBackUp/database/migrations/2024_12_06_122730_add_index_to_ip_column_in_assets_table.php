<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToIpColumnInAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->index('ip');
        });
    }
    
    public function down()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropIndex(['ip']);
        });
    }
}
