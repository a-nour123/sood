<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('incidents', function (Blueprint $table) {
            // Add the columns as nullable foreign keys
            $table->foreignId('tlp_level_id')
                  ->nullable()
                  ->constrained('tlp_levels')
                  ->onDelete('set null');
                  
            $table->foreignId('pap_level_id')
                  ->nullable()
                  ->constrained('pap_levels')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('incidents', function (Blueprint $table) {
            // Drop the foreign key constraints first
            $table->dropForeign(['tlp_level_id']);
            $table->dropForeign(['pap_level_id']);
            
            // Then drop the columns
            $table->dropColumn('tlp_level_id');
            $table->dropColumn('pap_level_id');
        });
    }
};