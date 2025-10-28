<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ExceptionSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('exception_settings')->insert([
            [
                'id' => '1',
                'policy_approver' => '0',
                // 'policy_reviewer' => '2',
                'control_approver' => '0',
                // 'control_reviewer' => '2',
                'risk_approver' => '0',
            ]
        ]);
    }
}
