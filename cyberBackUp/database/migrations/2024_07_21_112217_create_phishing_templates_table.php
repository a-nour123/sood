<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhishingTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phishing_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->enum('payload_type',['website','data_entry','attachment']);
            $table->enum('email_difficulty',['easy','modrate','hard']);
            $table->string('subject');
            $table->longText('body');
            $table->string('attachment')->nullable();
            $table->string('mail_attachment')->nullable();

            $table->unsignedBigInteger('sender_profile_id')->nullable();
            $table->foreign('sender_profile_id')->references('id')->on('phishing_sender_profiles')->onDelete('set null'); // Domains
            $table->unsignedBigInteger('phishing_website_id')->nullable();
            $table->foreign('phishing_website_id')->references('id')->on('phishing_website_pages')->onDelete('set null'); // Domains

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
        Schema::dropIfExists('phishing_templates');
    }
}
