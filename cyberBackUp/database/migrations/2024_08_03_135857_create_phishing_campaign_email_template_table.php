<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhishingCampaignEmailTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phishing_campaign_email_template', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id')->nullable();
            $table->foreign('campaign_id')->references('id')->on('phishing_campaigns')->onDelete('set null'); // Domains

            $table->unsignedBigInteger('email_template_id')->nullable();
            $table->foreign('email_template_id')->references('id')->on('phishing_templates')->onDelete('set null'); // Domains

            $table->tinyInteger('is_delivered')->default(0);
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
        Schema::dropIfExists('campaign_email_template');
    }
}
