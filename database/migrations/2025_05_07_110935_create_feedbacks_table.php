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
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
        
            // target bisa team member / organizer / aplikasi
            $table->foreignId('target_user_id')->nullable()->constrained('users')->nullOnDelete(); // untuk anggota
            $table->enum('type', ['member', 'organizer', 'platform']);
        
            $table->text('content');
            $table->timestamps();
        
            // unique: satu feedback per target oleh satu sender
            $table->unique(['team_id', 'sender_id', 'target_user_id', 'type'], 'unique_feedback');
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
