<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDefaultStatusOfControl extends Migration
{
    public function up()
    {
        Schema::table('framework_controls', function ($table) {
            $table->string('control_status', 255)
                ->default('Not Implemented')
                ->change();
        });
    }

    public function down()
    {
        Schema::table('framework_controls', function ($table) {
            $table->string('control_status', 255)
                ->default('Not Applicable')
                ->change();
        });
    }
}






