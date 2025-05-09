<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTasksTable221809 extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Add columns for tracking task statuses and timelines
            if (!Schema::hasColumn('tasks', 'status')) {
                $table->enum('status', ['pending', 'in_progress', 'completed', 'blocked'])->default('pending');
            }
            
            if (!Schema::hasColumn('tasks', 'completed_at')) {
                $table->timestamp('completed_at')->nullable();
            }
            
            if (!Schema::hasColumn('tasks', 'blocked_at')) {
                $table->timestamp('blocked_at')->nullable();
            }
            
            if (!Schema::hasColumn('tasks', 'last_activity_at')) {
                $table->timestamp('last_activity_at')->nullable();
            }
            
            if (!Schema::hasColumn('tasks', 'due_date')) {
                $table->date('due_date')->nullable();
            }
            
            if (!Schema::hasColumn('tasks', 'blocker_reason')) {
                $table->string('blocker_reason')->nullable();
            }
            
            // Create indexes for better query performance
            $table->index('status');
            $table->index('completed_at');
            $table->index('blocked_at');
            $table->index('due_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Remove the columns added for productivity tracking
            $table->dropIndex(['status']);
            $table->dropIndex(['completed_at']);
            $table->dropIndex(['blocked_at']);
            $table->dropIndex(['due_date']);
            
            $table->dropColumn('blocker_reason');
            $table->dropColumn('due_date');
            $table->dropColumn('last_activity_at');
            $table->dropColumn('blocked_at');
            $table->dropColumn('completed_at');
            
            // Only drop status if we're sure it wasn't there before
            if (Schema::hasColumn('tasks', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
}