<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddActionPolicyAuditActions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('actions')->insert([
            ['id' => 114, 'name' => 'addpolicyClause'],
            ['id' => 115, 'name' => 'deletepolicyClause'],
            ['id' => 116, 'name' => 'addpolicyCenter'],
            ['id' => 117, 'name' => 'updatepolicyCenter'],
            ['id' => 118, 'name' => 'deletepolicyCenter'],
            ['id' => 119, 'name' => 'AddAduitPolicy'],
            ['id' => 120, 'name' => 'UpdateAduitPolicy'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('actions')->whereIn('id', [
            114, 115, 116, 117, 118, 119, 120, 121, 122, 123, 124, 125, 126, 127
        ])->delete();
    }
}
