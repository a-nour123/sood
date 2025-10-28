<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incident_logs', function (Blueprint $table) {
            $table->id();

            // Regular unsigned big integers (no foreign key constraints)
            $table->unsignedBigInteger('incident_id')->nullable();
            $table->unsignedBigInteger('playbook_id')->nullable();
            $table->unsignedBigInteger('action_id')->nullable();

            // Only user_id has a foreign key
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incident_logs');
    }
};