<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPersonalityAndRoleToAssessmentsTable extends Migration
{
    public function up()
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->string('personality_type')->nullable();
            $table->string('preferred_role')->nullable();
        });
    }

    public function down()
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->dropColumn(['personality_type', 'preferred_role']);
        });
    }
}