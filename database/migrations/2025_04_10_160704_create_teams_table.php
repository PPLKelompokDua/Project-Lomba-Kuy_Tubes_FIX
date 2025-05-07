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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('competition_id')->nullable(); // tanpa FK
            $table->foreignId('leader_id')->constrained('users')->onDelete('cascade');
            $table->string('competition_name')->nullable();
            $table->string('category')->nullable();
            $table->date('deadline')->nullable();
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->enum('status_team', ['ongoing', 'finished'])->default('ongoing');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};