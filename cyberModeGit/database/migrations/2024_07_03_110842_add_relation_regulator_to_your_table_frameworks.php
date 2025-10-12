<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationRegulatorToYourTableFrameworks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('frameworks', function (Blueprint $table) {
            $table->unsignedBigInteger('regulator_id')->nullable();
            $table->foreign('regulator_id')->references('id')->on('regulators')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('frameworks', function (Blueprint $table) {
            $table->dropForeign(['regulator_id']);
            $table->dropColumn('regulator_id');
        });
    }
}
