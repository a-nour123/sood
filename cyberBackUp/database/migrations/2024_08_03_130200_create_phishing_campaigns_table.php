<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhishingCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phishing_campaigns', function (Blueprint $table) {
            $table->id();
            // tap number #1
            $table->string('campaign_name');
            $table->enum('status',['pending','inProgress','finsihed'])->default('pending');
            $table->enum('campaign_type',['simulated_phishing','security_awareness','simulated_phishing_and_security_awareness']);
            $table->enum('training_frequency',['daily','weekly','monthly','quarterly','annually'])->nullable();
            $table->date('expire_after')->nullable();
            $table->enum('sssignment_schedule',['immediatly','setup_schedule'])->nullable();
            $table->date('sssignment_date')->nullable();
            $table->time('sssignment_time')->nullable();

            // tap number #2 => many to many with email templates

            // tap number #3
            $table->enum('delivery_type',['immediatly','setup','later'])->nullable();
            $table->date('schedule_date_from')->nullable();
            $table->date('schedule_date_to')->nullable();
            $table->time('schedule_time_from')->nullable();
            $table->time('schedule_time_to')->nullable();
            $table->enum('campaign_frequency',['oneOf','weekly','monthly','quarterly'])->nullable();

            // tap number #4 Training
            $table->tinyInteger('days_until_due')->nullable();
            $table->enum('assignments',['all','one'])->nullable();

            $table->tinyInteger('approve')->default(0);
            $table->tinyInteger('delivery_status')->default(0);
            $table->text('comment')->comment('comment of approval in case of reject approve')->nullable();
            $table->string('time_zone')->nullable();

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
        Schema::dropIfExists('phishing_campaigns');
    }
}
