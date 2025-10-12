<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThirdPartyProfileContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('third_party_profile_contact', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->comment('1=>contact, 2=>business, 3=>technical, 4=>cyber security');
            $table->foreignId('third_party_profile_id')->constrained('third_party_profiles','id')->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
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
        Schema::dropIfExists('third_party_profile_contact');
    }
}
