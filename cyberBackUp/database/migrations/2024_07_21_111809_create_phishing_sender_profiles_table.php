<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhishingSenderProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phishing_sender_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('from_display_name');
            $table->enum('type',['own','managed']);
            $table->string('from_address_name');

            $table->unsignedBigInteger('website_domain_id')->nullable();
            $table->foreign('website_domain_id')->references('id')->on('phishing_domains')->onDelete('set null'); // Domains

            $table->softDeletes();
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
        Schema::dropIfExists('phishing_sender_profiles');
    }
}
