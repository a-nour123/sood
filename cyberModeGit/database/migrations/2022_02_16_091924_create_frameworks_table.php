<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrameworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frameworks', function (Blueprint $table) {
            $table->id();
            // I think value must be id primary key  AS $table->id();
            $table->integer('parent')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->integer('status')->default(1);
            $table->integer('order')->nullable();
            $table->date('last_audit_date')->nullable();
            $table->date('next_audit_date')->nullable();
            $table->integer('desired_frequency')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('frameworks');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
     }
}
