<?php

use App\Models\Action;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotificationCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Action::insert([

            ['id' => 142, 'name' => 'add_asset_comment'],
            ['id' => 143, 'name' => 'add_task_note'],
            ['id' => 144, 'name' => 'add_document_note']

        ]);
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
