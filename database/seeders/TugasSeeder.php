<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = [
            'Research Lomba',
            'Brainstorming',
            'Buat Materi Lomba',
            'Persiapan Tools Lomba',
            'Persiapan Logistik Lomba',
            'Test Materi',
            'Peer Review',
        ];

        foreach ($tasks as $title) {
            Task::create(['title' => $title]);
        }
    }
}
