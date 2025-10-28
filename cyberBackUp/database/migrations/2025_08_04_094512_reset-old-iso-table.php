<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ResetOldIsoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
 public function up(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        try {
            // Step 1: Get framework control IDs before deleting mappings
            $controlIds = DB::table('framework_control_mappings as fcm')
                ->join('frameworks as f', 'fcm.framework_id', '=', 'f.id')
                ->where('f.name', 'ISO-27001')
                ->pluck('fcm.framework_control_id')
                ->toArray();

            // Log the operation for reference
            if (!empty($controlIds)) {
                \Log::info('Deleting ISO-27001 framework with control IDs: ' . implode(', ', $controlIds));
            }

            // Step 2: Delete from framework_control_tests first
            $deletedTests = DB::table('framework_control_tests')
                ->whereIn('framework_control_id', function($query) {
                    $query->select('fcm.framework_control_id')
                        ->from('framework_control_mappings as fcm')
                        ->join('frameworks as f', 'fcm.framework_id', '=', 'f.id')
                        ->where('f.name', 'ISO-27001');
                })
                ->delete();

            // Step 3: Delete from framework_control_mappings
            $deletedMappings = DB::table('framework_control_mappings')
                ->whereIn('framework_id', function($query) {
                    $query->select('id')
                        ->from('frameworks')
                        ->where('name', 'ISO-27001');
                })
                ->delete();

            // Step 4: Delete from framework_controls using the stored IDs
            $deletedControls = 0;
            if (!empty($controlIds)) {
                $deletedControls = DB::table('framework_controls')
                    ->whereIn('id', $controlIds)
                    ->delete();
            }

            // Step 5: Delete from seeded_frameworks
            $deletedSeeded = DB::table('seeded_frameworks')
                ->where('framework', 'ISO-27001')
                ->delete();

            // Step 6: Finally, delete from frameworks table
            $deletedFramework = DB::table('frameworks')
                ->where('name', 'ISO-27001')
                ->delete();

            // Log the deletion summary
            \Log::info('ISO-27001 framework deletion completed:', [
                'framework_control_tests_deleted' => $deletedTests,
                'framework_control_mappings_deleted' => $deletedMappings,
                'framework_controls_deleted' => $deletedControls,
                'seeded_frameworks_deleted' => $deletedSeeded,
                'frameworks_deleted' => $deletedFramework
            ]);

        } catch (\Exception $e) {
            // Re-enable foreign key checks before throwing exception
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            throw $e;
        }

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Note: This migration is destructive and cannot be easily reversed
        // You would need to re-seed the ISO-27001 framework data
        throw new \Exception('This migration cannot be reversed. ISO-27001 framework data has been permanently deleted.');
    }
}
