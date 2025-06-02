<?php

namespace Database\Seeders;

use App\Models\Competition;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Faker\Factory as Faker;

class CompetitionSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Biar lebih lokal

        $categories = ['Teknologi', 'Seni', 'Bisnis', 'Lingkungan', 'Kesehatan', 'Pendidikan', 'Desain', 'Game', 'Penelitian'];
        $cities = ['Jakarta', 'Surabaya', 'Bandung', 'Yogyakarta', 'Denpasar', 'Medan', 'Makassar', 'Semarang', 'Tokyo', 'Seoul', 'Singapore', 'Bangkok', 'New York', 'London', 'Paris'];

        for ($i = 1; $i <= 100; $i++) {
            $start = Carbon::now()->addDays(rand(10, 30));
            $end = (clone $start)->addDays(rand(5, 20));
            $registrationDeadline = (clone $start)->subDays(rand(5, 10));

            Competition::create([
                'title' => $faker->sentence(3),
                'description' => $faker->paragraphs(rand(1, 3), true),
                'category' => $faker->randomElement($categories),
                'prize' => 'Rp ' . number_format(rand(500000, 10000000), 0, ',', '.'),
                'deadline' => $registrationDeadline,
                'registration_link' => $faker->url,
                'photo' => "images/lomba" . rand(1, 10) . ".png",
                'organizer_id' => 15, // Sesuaikan ID organizer kamu
                'max_participants' => rand(50, 500),
                'location' => $faker->randomElement($cities),
                'start_date' => $start,
                'end_date' => $end,
            ]);
        }
    }
}

