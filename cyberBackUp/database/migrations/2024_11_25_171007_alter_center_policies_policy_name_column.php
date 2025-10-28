<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCenterPoliciesPolicyNameColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('center_policies', function (Blueprint $table) {
            $table->text('policy_name')->change(); // Change to text for larger capacity
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('center_policies', function (Blueprint $table) {
            $table->string('policy_name', 255)->change(); // Revert back to string with default length
        });
    }
}
