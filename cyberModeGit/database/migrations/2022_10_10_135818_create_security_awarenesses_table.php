<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecurityAwarenessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('security_awarenesses', function (Blueprint $table) {
            $table->id();
            $table->string('title', 512);
            $table->text('description');
            $table->string('team_ids', 500)->nullable();
            $table->string('additional_stakeholders', 500)->nullable();
            $table->foreignId('privacy')->nullable()->constrained('privacies')->nullOnDelete(); // Public or Private
            $table->integer('status')->default(1)->comment('[1 => Draft],[2=> InReview, [3 => Approved]');
            $table->foreignId('file_id')->nullable()->constrained('files');
            $table->date('last_review_date')->nullable();
            $table->integer('review_frequency')->nullable();
            $table->date('next_review_date')->nullable();
            $table->date('approval_date')->nullable();
            $table->foreignId('owner')->constrained('users');
            $table->foreignId('reviewer')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->constrained('users');
            $table->boolean('opened');

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
        Schema::dropIfExists('security_awarenesses');
    }
}
