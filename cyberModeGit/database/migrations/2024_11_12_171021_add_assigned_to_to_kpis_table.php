<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssignedToToKpisTable extends Migration
{
    public function up()
    {
        Schema::table('kpi_assessments', function (Blueprint $table) {
            // Add the assigned_to column as a nullable foreign key to the users table
            $table->unsignedBigInteger('assigned_to')->nullable()->after('kpi_id');
            // Create a foreign key constraint that references the id on the users table
             $table->foreign('assigned_to')->references('id')->on('users')->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::table('kpis', function (Blueprint $table) {
            // Drop the foreign key and the column in case we roll back the migration
            $table->dropForeign(['assigned_to']);
            $table->dropColumn('assigned_to');
        });
    }
}
