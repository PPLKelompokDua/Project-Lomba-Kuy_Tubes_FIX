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
        Schema::table('competitions', function (Blueprint $table) {
            // Tambahkan kolom status_lomba
            $table->enum('status_lomba', ['active', 'finished', 'cancelled'])->default('active')->after('organizer_id');
            // ^ sesuaikan opsi enum dan default value jika kamu punya standar lain
            // ^ 'after('organizer_id')' adalah opsional, untuk posisi kolom
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('competitions', function (Blueprint $table) {
            // Hapus kolom status_lomba jika migrasi di-rollback
            $table->dropColumn('status_lomba');
        });
    }
};