<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TruncateControlsGrcTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // List of tables in proper truncation order (child to parent)
        $tables = [
            'framework_control_test_audits',
            'framework_control_test_comments',
            'framework_control_test_results',
            'control_audits_evidences',
            'control_audits_objectives',
            'objective_comments',
            'audits_responsibles',
            'control_audit_policies',
            'framework_control_mappings',
            'controls_control_objectives',
            'control_objectives',
            'framework_controls',
            'framework_families',
            'families',
            'frameworks',
            'seeded_frameworks',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                DB::statement("TRUNCATE TABLE {$table};");
            }
        }

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
