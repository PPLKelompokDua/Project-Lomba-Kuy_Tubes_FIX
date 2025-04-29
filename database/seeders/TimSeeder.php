<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TimModel;

class TimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TimModel::Create([
            'name' => 'Tim Sandang',
        ]);
        TimModel::Create([
            'name' => 'Tim Pangan',
        ]);
        TimModel::Create([
            'name' => 'Tim Papan',
        ]);
    }
}
