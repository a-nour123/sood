<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhishingWebsitePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phishing_website_pages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('html_code');

            $table->text('description')->nullable();
            $table->string('website_url')->nullable();

            $table->string('cover');
            $table->unsignedBigInteger('phishing_category_id')->nullable();
            $table->foreign('phishing_category_id')->references('id')->on('phishing_categories')->onDelete('set null'); // Domains

            $table->enum('type',['own','managed']);
            $table->string('from_address_name');
            $table->unsignedBigInteger('domain_id')->nullable();
            $table->foreign('domain_id')->references('id')->on('phishing_domains')->onDelete('set null'); // Domains


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
        Schema::dropIfExists('phishing_website_pages');
    }
}
