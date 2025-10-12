<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteDataFrameworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        try {
            // Step 1: Get framework ID
            $frameworkId = DB::table('frameworks')
                ->where('name', 'ISO-27001-2022')
                ->value('id');

            if (!$frameworkId) {
                Log::info('NCA-ECC – 2: 2024 framework not found, skipping deletion.');
                return;
            }

            // Step 2: Get framework control IDs
            $controlIds = DB::table('framework_control_mappings')
                ->where('framework_id', $frameworkId)
                ->pluck('framework_control_id')
                ->toArray();

            // Step 3: Get audits_responsibles IDs linked to ISO framework
            $auditIds = DB::table('audits_responsibles')
                ->where('framework_id', $frameworkId)
                ->pluck('id')
                ->toArray();

            if (!empty($auditIds)) {
                // Get framework_control_test_audit IDs
                $testAuditIds = DB::table('framework_control_test_audits')
                    ->whereIn('audit_id', $auditIds)
                    ->pluck('id')
                    ->toArray();

                if (!empty($testAuditIds)) {
                    // Get evidence IDs before deletion
                    $evidenceIds = DB::table('control_audits_evidences')
                        ->whereIn('framework_control_test_audit_id', $testAuditIds)
                        ->pluck('evidence_id')
                        ->toArray();

                    if (!empty($evidenceIds)) {
                        DB::table('evidences')
                            ->whereIn('id', $evidenceIds)
                            ->delete();
                    }

                    DB::table('control_audits_evidences')
                        ->whereIn('framework_control_test_audit_id', $testAuditIds)
                        ->delete();

                    DB::table('control_audits_objectives')
                        ->whereIn('framework_control_test_audit_id', $testAuditIds)
                        ->delete();
                }

                DB::table('framework_control_test_results')
                    ->whereIn('test_audit_id', $auditIds)
                    ->delete();

                DB::table('framework_control_test_comments')
                    ->whereIn('test_audit_id', $auditIds)
                    ->delete();

                DB::table('framework_control_test_audits')
                    ->whereIn('id', $testAuditIds)
                    ->delete();

                DB::table('audits_responsibles')
                    ->whereIn('id', $auditIds)
                    ->delete();
            }

            // Step 4: Delete from controls_control_objectives
            if (!empty($controlIds)) {
                $controlEntityIds = DB::table('framework_controls')
                    ->whereIn('id', $controlIds)
                    ->pluck('id')
                    ->toArray();

                if (!empty($controlEntityIds)) {
                    DB::table('controls_control_objectives')
                        ->whereIn('control_id', $controlEntityIds)
                        ->delete();
                }
            }

            // Step 5: Delete from framework_control_tests
            DB::table('framework_control_tests')
                ->whereIn('framework_control_id', $controlIds)
                ->delete();

            // Step 6: Delete from framework_control_mappings
            DB::table('framework_control_mappings')
                ->where('framework_id', $frameworkId)
                ->delete();

            // Step 7: Delete from framework_controls
            DB::table('framework_controls')
                ->whereIn('id', $controlIds)
                ->delete();

            // Step 8: Delete from seeded_frameworks
            DB::table('seeded_frameworks')
                ->where('framework', 'ISO-27001')
                ->delete();

            // Step 9: Delete from frameworks
            DB::table('frameworks')
                ->where('id', $frameworkId)
                ->delete();

            Log::info('NCA-ECC – 2: 2024 framework deletion completed.');

        } catch (\Exception $e) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            throw $e;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}