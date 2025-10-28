<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsCategoryToTenableAuthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenable_auth', function (Blueprint $table) {
            $table->string('access_key_category')->nullable()->after('id');
            $table->string('secret_key_category')->nullable()->after('access_key_category');
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
            $table->dropColumn(['access_key_category', 'secret_key_category']);
        });
    }
}
