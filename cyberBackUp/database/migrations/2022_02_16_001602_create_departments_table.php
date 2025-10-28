<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('code', 10)->nullable()->unique();
            // $table->foreignId('manager_id')->nullable()->constrained('users');
            $table->foreignId('parent_id')->nullable()->constrained('departments');
            $table->integer('required_num_emplyees')->nullable();
            $table->foreignId('color_id')->constrained('department_colors');
            // $table->string('color', 9); // #545b63 (6 digits) or  (8 digits) added two digits for opacity
            $table->longText('vision')->nullable();
            $table->longText('message')->nullable();
            $table->longText('mission')->nullable();
            $table->longText('objectives')->nullable();
            $table->longText('responsibilities')->nullable();
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
        Schema::dropIfExists('departments');
    }
};
