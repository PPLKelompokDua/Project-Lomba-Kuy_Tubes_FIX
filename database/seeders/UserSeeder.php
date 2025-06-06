<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $focusAreas = ['Teknologi', 'Bisnis', 'Desain', 'Kesehatan', 'Lingkungan', 'Pendidikan', 'Kewirausahaan'];

        // Seed user tetap yang manual
        $users = [
            [
                'name' => 'Vilson',
                'email' => 'vilson@gmail.com',
                'role' => 'user',
                'password' => Hash::make('12345678'),
                'description' => 'Mahasiswa yang bersemangat di bidang teknologi.',
                'achievements' => 'Juara 2 Hackathon Nasional 2024.',
                'focus_area' => 'Teknologi',
            ],
            [
                'name' => 'TalentGrowth',
                'email' => 'talentgrowth@gmail.com',
                'role' => 'organizer',
                'password' => Hash::make('12345678'),
                'description' => 'Organisasi penyelenggara lomba profesional.',
                'achievements' => 'Menyelenggarakan lebih dari 50 lomba.',
                'focus_area' => 'Pendidikan',
            ],
            [
                'name' => 'Admin1',
                'email' => 'admin@lombakuy.com',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
                'description' => 'Administrator platform lomba.',
                'achievements' => 'Meningkatkan pengguna 200% dalam setahun.',
                'focus_area' => 'Manajemen',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        // Seed tambahan 100 random users
        // Tambahan untuk pilihan personality dan role
        $personalities = ['Conscientiousness', 'Openness to Experience', 'Extraversion', 'Neuroticism', 'Agreeableness'];
        $preferredRoles = ['Leader', 'Planner', 'Supporter', 'Creative'];
        $focusAreas = ['Programming', 'Design', 'Business', 'Engineering', 'Science', 'Art'];
        $experiences = ['["Desain"]', '["Musik"]', '["Pendidikan"]', '["Teknologi"]', '["Olahraga"]', '["Other"]'];

        for ($i = 1; $i <= 100; $i++) {
            User::create([
                'name' => 'User' . $i,
                'email' => 'user' . $i . '@example.com',
                'role' => 'user',
                'password' => Hash::make('password123'),
                'profile_image' => null,
                'description' => 'Saya tertarik mengikuti lomba ' . $focusAreas[array_rand($focusAreas)] . ' dan ingin memperluas jaringan.',
                'achievements' => 'Pernah memenangkan beberapa lomba lokal.',
                'focus_area' => $focusAreas[array_rand($focusAreas)],
                'personality_type' => $personalities[array_rand($personalities)], // baru ditambah
                'preferred_role' => $preferredRoles[array_rand($preferredRoles)], // baru ditambah
                'experience' => json_decode($experiences[array_rand($experiences)]),
            ]);
        }
    }
}
