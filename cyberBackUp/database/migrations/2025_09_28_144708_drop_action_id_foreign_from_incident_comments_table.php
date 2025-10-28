<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropActionIdForeignFromIncidentCommentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('incident_comments', function (Blueprint $table) {
            // Drop all foreign keys if they exist
            try {
                $table->dropForeign(['incident_id']);
            } catch (\Exception $e) {}

            try {
                $table->dropForeign(['playbook_id']);
            } catch (\Exception $e) {}

            try {
                $table->dropForeign(['action_id']);
            } catch (\Exception $e) {}

            // Make them nullable if needed
            $table->unsignedBigInteger('incident_id')->nullable()->change();
            $table->unsignedBigInteger('playbook_id')->nullable()->change();
            $table->unsignedBigInteger('action_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('incident_comments', function (Blueprint $table) {
            // Recreate the foreign keys (optional rollback)
            $table->unsignedBigInteger('incident_id')->nullable(false)->change();
            $table->foreign('incident_id')
                  ->references('id')
                  ->on('incidents')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('playbook_id')->nullable()->change();
            $table->foreign('playbook_id')
                  ->references('id')
                  ->on('incident_play_books')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('action_id')->nullable()->change();
            $table->foreign('action_id')
                  ->references('id')
                  ->on('incident_play_book_actions')
                  ->onDelete('cascade');
        });
    }
}