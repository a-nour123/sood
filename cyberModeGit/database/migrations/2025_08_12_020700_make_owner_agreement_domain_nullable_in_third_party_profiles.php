<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('third_party_profiles', function (Blueprint $table) {
            $table->string('owner')->nullable()->change();
            $table->string('agreement')->nullable()->change();
            $table->string('domain')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('third_party_profiles', function (Blueprint $table) {
            $table->string('owner')->nullable(false)->change();
            $table->string('agreement')->nullable(false)->change();
            $table->string('domain')->nullable(false)->change();
        });
    }
};
