<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThirdPartyRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('third_party_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requested_by')->constrained('users','id')->cascadeOnDelete();
            $table->foreignId('department_id')->constrained('departments','id')->cascadeOnDelete();
            $table->foreignId('job_id')->constrained('jobs','id')->cascadeOnDelete();
            $table->longText('business_info');
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
        Schema::dropIfExists('third_party_requests');
    }
}
