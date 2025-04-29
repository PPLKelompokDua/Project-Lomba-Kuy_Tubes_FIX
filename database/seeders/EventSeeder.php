<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EventModel;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EventModel::Create([
            'title' => 'Event Pengembangan WEB',
        ]);

        EventModel::Create([
            'title' => 'Event IoT',
        ]);

        EventModel::Create([
            'title' => 'Event Cyber Security',
        ]);
    }
}
