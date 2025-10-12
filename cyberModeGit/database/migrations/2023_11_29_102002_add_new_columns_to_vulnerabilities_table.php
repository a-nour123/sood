<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToVulnerabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vulnerabilities', function (Blueprint $table) {
            $table->string('ip_address', 15)->nullable();
            $table->string('netbios_name')->nullable();
            $table->string('dns_name')->nullable();
            $table->string('plugin_id')->nullable();
            $table->string('protocol')->nullable();
            $table->integer('port')->nullable();
            $table->enum('exploit', ['yes', 'no'])->nullable();
            $table->string('synopsis')->nullable();
            $table->timestamp('first_discovered')->nullable();
            $table->timestamp('last_observed')->nullable();
            $table->timestamp('plugin_publication_date')->nullable();
            $table->timestamp('plugin_modification_date')->nullable();
        });
        DB::statement("ALTER TABLE vulnerabilities MODIFY COLUMN status ENUM('Open', 'In Progress', 'Closed', 'Overdue') NOT NULL DEFAULT 'Open'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vulnerabilities', function (Blueprint $table) {
            $table->dropColumn('ip_address');
            $table->dropColumn('netbios_name');
            $table->dropColumn('dns_name');
            $table->dropColumn('plugin_id');
            $table->dropColumn('protocol');
            $table->dropColumn('port');
            $table->dropColumn('exploit');
            $table->dropColumn('synopsis');
            $table->dropColumn('first_discovered');
            $table->dropColumn('last_observed');
            $table->dropColumn('plugin_publication_date');
            $table->dropColumn('plugin_modification_date');
        });
        DB::statement("ALTER TABLE vulnerabilities MODIFY COLUMN status ENUM('Open', 'In Progress', 'Closed') NOT NULL DEFAULT 'Open'");
    }
}
