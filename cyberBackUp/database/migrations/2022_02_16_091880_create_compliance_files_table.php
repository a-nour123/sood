<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateComplianceFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compliance_files', function (Blueprint $table) {
            $table->id();
            // $table->morphs('ref')->default(0); // instead of ref_id, ref_type
            $table->integer('ref_id');
            $table->string('ref_type', 100)->default('');
            $table->string('name', 100);
            $table->string('unique_name', 30);
            $table->string('type', 128)->nullable();
            $table->integer('size');
            $table->timestamp('timestamp')->useCurrent();
            $table->integer('user');
            // $table->foreignId('user')->constrained('users'); // column name must be user_id
            // $table->longblob('content');
            $table->integer('version')->nullable();
        });

        // once the table is created use a raw query to ALTER it and add the MEDIUMBLOB
        DB::statement("ALTER TABLE `compliance_files` ADD `content` longblob NOT NULL AFTER `user`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compliance_files');
    }
}
