<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTeamIdToTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->foreignId('team_id')->nullable()->after('id')->constrained();
        });

        // Optional: Populate team_id from user's team_id for existing tasks
        if (Schema::hasColumn('users', 'team_id')) {
            DB::statement('
                UPDATE tasks 
                JOIN users ON tasks.user_id = users.id 
                SET tasks.team_id = users.team_id 
                WHERE users.team_id IS NOT NULL
            ');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
            $table->dropColumn('team_id');
        });
    }
}