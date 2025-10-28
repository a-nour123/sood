<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServiceIdToThirdPartyRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('third_party_requests', function (Blueprint $table) {
            $table->foreignId('third_party_service_id')->after('third_party_profile_id')->constrained('third_party_services')->cascadeOnDelete();
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
