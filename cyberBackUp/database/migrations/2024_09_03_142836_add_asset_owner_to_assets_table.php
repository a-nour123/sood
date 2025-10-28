<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssetOwnerToAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->unsignedBigInteger('asset_owner')->nullable(); // Add the new column

            $table->foreign('asset_owner') // Set up the foreign key constraint
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null')
                  ->nullable(); // Optional: what happens when the user is deleted
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
            $table->dropForeign(['asset_owner']); // Drop the foreign key constraint
            $table->dropColumn('asset_owner'); // Drop the column
        });
    }
}
