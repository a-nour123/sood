<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TruncateAllTables extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php artisan db:seed --class=TruncateAllTables
        // php artisan db:seed

        Schema::disableForeignKeyConstraints();
        $databaseName = DB::getDatabaseName();
        $tables = DB::select("SELECT `TABLE_NAME` FROM information_schema.tables WHERE table_schema = '$databaseName' AND `TABLE_NAME` <> 'migrations'");

        foreach ($tables as $table) {
            $name = $table->TABLE_NAME;
            DB::table($name)->truncate();
        }
        Schema::enableForeignKeyConstraints();
    }
}
