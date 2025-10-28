<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAffectedUsersAndOtherAssetsToIncidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incidents', function (Blueprint $table) {
            // Add affected_users field
            $table->text('affected_users')->nullable();
            
            // Add other_assets field
            $table->text('other_assets')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->dropColumn(['affected_users', 'other_assets']);
        });
    }
}