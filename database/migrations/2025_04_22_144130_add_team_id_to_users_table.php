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
    Schema::table('users', function (Blueprint $table) {
        $table->unsignedBigInteger('team_id')->nullable()->after('id');

        // Jika relasi foreign key juga mau diset
        $table->foreign('team_id')->references('id')->on('teams')->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['team_id']);
        $table->dropColumn('team_id');
    });
}

};
