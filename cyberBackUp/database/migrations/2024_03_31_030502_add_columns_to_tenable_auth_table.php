<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToTenableAuthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenable_auth', function (Blueprint $table) {
            $table->string('type_source')->nullable()->after('api_url');
            $table->integer('offset')->nullable()->after('type_source');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tenable_auth', function (Blueprint $table) {
            $table->dropColumn('type_source');
            $table->dropColumn('offset');
        });
    }
}
