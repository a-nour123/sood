<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateValidationFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validation_files', function (Blueprint $table) {
            $table->id();
            // $table->integer('mitigation_id');
            $table->foreignId('mitigation_id')->constrained('mitigations');
            $table->integer('control_id');
            $table->string('name', 100);
            $table->string('type', 30);
            $table->integer('size');
            $table->timestamp('timestamp')->useCurrent();
            $table->integer('user');
            // $table->longblob('content');
        });

        // once the table is created use a raw query to ALTER it and add the MEDIUMBLOB
        DB::statement("ALTER TABLE `validation_files` ADD `content` longblob NOT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('validation_files');
    }
}
