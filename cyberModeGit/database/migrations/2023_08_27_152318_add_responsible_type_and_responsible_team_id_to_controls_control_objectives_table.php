<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResponsibleTypeAndResponsibleTeamIdToControlsControlObjectivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('controls_control_objectives', function (Blueprint $table) {
            $table->string('responsible_type')->after('updated_at')->nullable();
            $table->unsignedBigInteger('responsible_team_id')->nullable();
            $table->foreign('responsible_team_id')
                ->references('id')->on('teams')->onDelete('cascade');
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
            $table->dropForeign(['responsible_team_id']);
            $table->dropColumn('responsible_team_id');
            $table->dropColumn('responsible_type');
        });
    }
}
