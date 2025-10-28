<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            // $table->integer('risk_id')->default(0);
            $table->foreignId('risk_id')->nullable()->constrained('risks')->onDelete('cascade');
            $table->integer('view_type')->default(1);
            $table->string('name', 100);
            $table->string('unique_name', 100);
            $table->string('type', 128)->nullable();
            $table->integer('size');
            $table->timestamp('timestamp')->useCurrent();
            $table->integer('user');
            // $table->longblob('content');
        });

        // once the table is created use a raw query to ALTER it and add the MEDIUMBLOB
        // DB::statement("ALTER TABLE `files` ADD `content` longblob NOT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
