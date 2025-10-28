<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateNamesInTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            UPDATE subgroups
            SET name = 'Control Requirements'
            WHERE name = 'Control Objectives'
        ");

        DB::statement("
            UPDATE permissions
            SET name = 'list requirements'
            WHERE name = 'list objectives'
        ");

        DB::statement("
            UPDATE permissions
            SET name = 'add requirements'
            WHERE name = 'add objectives'
        ");
    }

    public function down()
    {
        // If you need to rollback these updates, you can implement the rollback logic here
    }
}
