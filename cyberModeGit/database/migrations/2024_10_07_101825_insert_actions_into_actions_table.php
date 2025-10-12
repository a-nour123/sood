<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertActionsIntoActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('actions')->insert([
            // ['id' => 99, 'name' => 'addpolicyClause'],
            // ['id' => 100, 'name' => 'deletepolicyClause'],
            // ['id' => 101, 'name' => 'addpolicyCenter'],
            // ['id' => 102, 'name' => 'updatepolicyCenter'],
            // ['id' => 103, 'name' => 'deletepolicyCenter'],
            // ['id' => 104, 'name' => 'AddAduitPolicy'],
            // ['id' => 105, 'name' => 'UpdateAduitPolicy'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('actions', function (Blueprint $table) {
            //
        });
    }
}
