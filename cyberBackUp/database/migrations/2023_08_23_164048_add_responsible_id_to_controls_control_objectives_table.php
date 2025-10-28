<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResponsibleIdToControlsControlObjectivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('controls_control_objectives', function (Blueprint $table) {
            $table->unsignedBigInteger('responsible_id')->nullable();
            $table->foreign('responsible_id')
            ->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('controls_control_objectives', function (Blueprint $table) {
            $table->dropForeign(['responsible_id']);
            $table->dropColumn('responsible_id');
        });
    }
}
