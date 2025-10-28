<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('policy_signatures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('policy_id');
            $table->string('reviewer_id')->nullable();
            $table->string('owner_id')->nullable();
            $table->string('authorized_person_id')->nullable();
            $table->timestamps();

            // Optional: Foreign key constraint
            $table->foreign('policy_id')
                  ->references('id')
                  ->on('policy_adoptions')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('policy_signatures');
    }
};