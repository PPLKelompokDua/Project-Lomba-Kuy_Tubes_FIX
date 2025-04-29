<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('assessment_histories', function (Blueprint $table) {
            $table->id(); // Kolom ID untuk AssessmentHistory
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key ke User
            $table->text('assessment_data'); // Kolom untuk menyimpan data penilaian
            $table->string('personality_type')->nullable();
            $table->string('preferred_role')->nullable();
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('assessment_histories');
    }
}