<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Vilson',
                'email' => 'vilson@gmail.com',
                'role' => 'user',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'TalentGrowth',
                'email' => 'talentgrowth@gmail.com',
                'role' => 'organizer',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Admin1',
                'email' => 'admin@lombakuy.com',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
