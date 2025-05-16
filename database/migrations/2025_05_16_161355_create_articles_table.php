<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // admin as author
            $table->string('category')->nullable(); // just a string
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->text('excerpt')->nullable();
            $table->longText('body');
            $table->string('thumbnail')->nullable(); // optional image
            $table->json('hashtags')->nullable(); // stored as array in JSON
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('articles');
    }
};

