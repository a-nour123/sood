<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhishingLandingPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phishing_landing_pages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            // $table->string('screenshot_url');
            $table->enum('type',['own','managed']);
            $table->string('website_domain_name')->nullable();
            $table->string('website_url')->nullable();

            $table->unsignedBigInteger('website_domain_id')->nullable();
            $table->unsignedBigInteger('website_page_id')->nullable();

            $table->foreign('website_domain_id')->references('id')->on('phishing_domains')->onDelete('set null'); // Domains
            $table->foreign('website_page_id')->references('id')->on('phishing_website_pages')->onDelete('set null'); // Website Pages

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
        Schema::dropIfExists('phishing_landing_pages');
    }
}
