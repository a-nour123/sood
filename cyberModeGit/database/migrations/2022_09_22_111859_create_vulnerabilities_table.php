<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVulnerabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vulnerabilities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cve');
            $table->text('description');
            $table->enum('severity', ['Critical', 'High', 'Medium', 'Low', 'Informational']);
            $table->text('recommendation');
            $table->text('plan');
            $table->enum('status', ['Open', 'In Progress', 'Closed'])->default('Open');
            $table->timestamp('update_status_date')->nullable();
            $table->foreignId('update_status_user')->nullable()->constrained('users');
            $table->foreignId('created_by')->constrained('users');
            // Assets (asset_vulnerabilities)
            // Teams (team_vulnerabilities)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vulnerabilities');
    }
}
