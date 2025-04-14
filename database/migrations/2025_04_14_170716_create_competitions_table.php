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
        Schema::create('competitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organizer_id')->constrained('users');
            $table->string('title');
            $table->text('description');
            $table->string('location');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('registration_deadline');
            $table->integer('max_participants')->nullable();
            $table->string('image')->nullable();
            $table->string('external_registration_link')->nullable();
            $table->string('status')->default('open'); // open, closed, completed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competitions');
    }
};
