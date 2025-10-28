<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToThirdPartyRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('third_party_requests', function (Blueprint $table) {
            $table->integer('status')->nullable()->after('job_id')->comment('1=>pending, 2=>in assessment, 3=>rejected')->default(1);
            $table->longText('reject_reason')->nullable()->after('status');
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
