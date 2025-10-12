<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThirdPartyProfileSubsidiaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('third_party_profile_subsidiary', function (Blueprint $table) {
            $table->id();
            $table->foreignId('third_party_profile_id')->constrained('third_party_profiles','id')->cascadeOnDelete();
            $table->string('affiliation');
            $table->date('date');
            $table->string('involvement');
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
        Schema::dropIfExists('third_party_profile_subsidiary');
    }
}
