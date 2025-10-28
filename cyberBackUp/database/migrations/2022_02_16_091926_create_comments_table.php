<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            // $table->integer('risk_id');
            $table->foreignId('risk_id')->constrained('risks')->onDelete('cascade');
            $table->timestamp('date')->useCurrent();
            $table->integer('user');
            // $table->foreignId('user')->constrained('users'); // column name must be user_id
            $table->mediumText('comment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
