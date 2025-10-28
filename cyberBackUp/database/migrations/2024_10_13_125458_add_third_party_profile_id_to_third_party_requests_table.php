<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddThirdPartyProfileIdToThirdPartyRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('third_party_requests', function (Blueprint $table) {
            $table->foreignId('third_party_profile_id')->after('job_id')->constrained('third_party_profiles','id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('third_party_requests', function (Blueprint $table) {
            //
        });
    }
}
