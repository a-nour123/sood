<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhishingMailTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phishing_mail_trackings', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('email_id')->nullable();
            $table->foreign('email_id')->references('id')->on('phishing_templates')->onDelete('set null');

            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id')->references('id')->on('users')->onDelete('set null');

            $table->dateTime('opened_at')->nullable();
            $table->dateTime('downloaded_at')->nullable();
            $table->dateTime('Page_link_clicked_at')->nullable();
            $table->dateTime('submited_at')->nullable();
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
        Schema::dropIfExists('phishing_mail_trackings');
    }
}
