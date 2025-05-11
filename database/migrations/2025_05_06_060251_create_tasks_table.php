<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Pembuat task
            $table->foreignId('team_id')->nullable()->constrained()->onDelete('cascade'); // Optional
            $table->foreignId('assigned_user_id')->nullable()->constrained('users')->onDelete('set null'); // Optional
            $table->date('due_date')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed', 'blocked'])->default('pending');
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('blocked_at')->nullable();
            $table->timestamp('last_activity_at')->nullable();
            $table->string('blocker_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
}