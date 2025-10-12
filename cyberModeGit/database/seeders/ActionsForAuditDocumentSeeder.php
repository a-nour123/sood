<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActionsForAuditDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('actions')->insert([
            // ['id' => 106, 'name' => 'addCommentForComplianceDocument'],
            // ['id' => 107, 'name' => 'RejectFromAuditer'],
            // ['id' => 108, 'name' => 'replyComment'],
            // ['id' => 109, 'name' => 'ApproveFromAuditer'],
            // ['id' => 110, 'name' => 'ChangeStatus'],
            // ['id' => 111, 'name' => 'ApproveCompliance'],
            // ['id' => 112, 'name' => 'incident_created'],
            // ['id' => 113, 'name' => 'incident_ira_created'],
        ]);
    }
}
