<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamVulnerabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_vulnerabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained('teams');
            $table->foreignId('vulnerability_id')->constrained('vulnerabilities')->onDelete('Cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_vulnerabilities');
    }
}
