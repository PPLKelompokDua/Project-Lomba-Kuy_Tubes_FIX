<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('team_recommendations', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('role_recommendation')->nullable();
            $table->string('strengths')->nullable();
            $table->string('weaknesses')->nullable();
            $table->integer('compatibility_score')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('team_recommendations', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn([
                'user_id',
                'role_recommendation',
                'strengths',
                'weaknesses',
                'compatibility_score'
            ]);
        });
    }
};
