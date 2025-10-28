<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TruncateNotificationTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        $tables = [
            'user_notifications',
            'notifications'
        ];
        foreach ($tables as $table) {
            $name = $table;
            DB::table($name)->truncate();
        }
        Schema::enableForeignKeyConstraints();
    }
}
