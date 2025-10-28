<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThirdPartyProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('third_party_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('third_party_name');
            $table->string('owner');
            $table->string('place_of_incorporation');
            $table->string('head_office_location');
            $table->string('agreement');
            $table->date('date_of_incorporation');
            $table->integer('classification');
            $table->integer('contract_term');
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
        Schema::dropIfExists('third_party_profiles');
    }
}
