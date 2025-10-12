<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_to_users', function (Blueprint $table) {
            $table->integer('item_id');
            $table->foreignId('user_id')->constrained('users');
            $table->string('type', 20)->index('type');

            $table->unique(['item_id', 'user_id', 'type'], 'item_user_unique');
            $table->index(['item_id', 'type'], 'item_type');
            $table->index(['user_id', 'type'], 'user_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items_to_users');
    }
}
