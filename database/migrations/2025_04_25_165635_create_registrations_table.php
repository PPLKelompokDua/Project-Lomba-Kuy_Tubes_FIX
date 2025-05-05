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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('competition_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->text('notes')->nullable();
            $table->json('additional_data')->nullable(); // For storing any additional registration fields
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'competition_id']); // A user can register only once for a competition
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};