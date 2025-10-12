<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLMSTrainingModuleCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('l_m_s_training_module_certificates', function (Blueprint $table) {
            $table->id();
            $table->integer('grade')->nullable();
            $table->string('certificate_file')->nullable();
            $table->string('certificate_id')->unique();
            $table->date('issued_at');
            $table->foreignId('template_id')->nullable()->constrained('certificate_templates')->nullOnDelete();
            $table->foreignId('campaign_id')->nullable()->constrained('phishing_campaigns')->cascadeOnDelete();
            $table->foreignId('training_id')->nullable()->trained('l_m_s_training_modules')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('l_m_s_training_module_certificates');
    }
}
