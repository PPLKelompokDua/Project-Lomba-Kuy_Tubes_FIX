<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LearningVideo;

class LearningVideoSeeder extends Seeder
{
    public function run(): void
    {

        LearningVideo::truncate();
        $videos = [
            [
                'title' => 'TIPS & TRICK LOLOS TAHAP BUSINESS CASE | STRATEGI MENGERJAKAN BUSINESS CASE',
                'description' => 'Tips strategi efektif mengerjakan business case untuk kompetisi.',
                'url' => 'https://youtu.be/HZpZ3GFUJeI?si=3AVOLSdrKA9k06Ld',
                'thumbnail_url' => 'https://i.ytimg.com/vi/HZpZ3GFUJeI/hq720.jpg',
                'category' => 'Tips Juara',
                'duration' => '11:56',
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'title' => 'Menang Business Case Competition ala Vero',
                'description' => 'Mau lolos tahap business case di kompetisi bergengsi? Video ini menyajikan tips dan strategi efektif untuk mengerjakan business case dengan percaya diri. Dari memahami struktur kasus hingga menyusun solusi yang logis dan impactful, kami akan memandu Anda langkah demi langkah untuk meningkatkan peluang keberhasilan di setiap tahap kompetisi. Kami juga membagikan trik praktis untuk mengelola waktu, menganalisis data dengan cepat, dan mempresentasikan ide Anda secara persuasif kepada juri. Baik Anda pemula atau sudah berpengalaman, strategi ini dirancang untuk membantu Anda tampil maksimal dan meraih juara. Tonton sekarang dan kuasai seni menyelesaikan business case!',
                'url' => 'https://www.youtube.com/watch?v=rmfx0V7YSBo',
                'thumbnail_url' => 'https://i.ytimg.com/vi/rmfx0V7YSBo/hq720.jpg',
                'category' => 'Competition',
                'duration' => '14:43',
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title' => 'How to win an Oxbridge essay competition | Part 2: Tips and strategies',
                'description' => 'Video edukatif seputar how dan lomba.',
                'url' => 'https://www.youtube.com/watch?v=bnwNzKeOdag',
                'thumbnail_url' => 'https://i.ytimg.com/vi/bnwNzKeOdag/hq720.jpg',
                'category' => 'Tips Juara',
                'duration' => '16:35',
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title' => 'Contoh Essay Lomba yang Pernah Menjadi Juara',
                'description' => 'Video edukatif seputar contoh dan lomba.',
                'url' => 'https://youtu.be/KyYd6g69WOg?si=ntyzxTkC_8MZTELw',
                'thumbnail_url' => 'https://i.ytimg.com/vi/KyYd6g69WOg/hq720.jpg',
                'category' => 'Tutorial',
                'duration' => '14:09',
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title' => 'IMPORTANT TIPS FOR ESSAY COMPETITION📚',
                'description' => 'Video edukatif seputar important dan lomba.',
                'url' => 'https://youtu.be/z0Xz7DTJs3c?si=nlM2k9FbniwszgrI',
                'thumbnail_url' => 'https://i.ytimg.com/vi/z0Xz7DTJs3c/hq720.jpg',
                'category' => 'Workshop',
                'duration' => '11:01',
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'title' => 'Belajar Machine Learning Dari Awal Buat Yang Ga Jago Matematika',
                'description' => 'Video edukatif seputar belajar dan lomba.',
                'url' => 'https://youtu.be/WH1SduDRL_Y?si=-jLtJS1nKExZDwLv',
                'thumbnail_url' => 'https://i.ytimg.com/vi/WH1SduDRL_Y/hq720.jpg',
                'category' => 'Competition',
                'duration' => '10:45',
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title' => 'Statistics - A Full Lecture to learn Data Science (2025 Version)',
                'description' => 'Video edukatif seputar statistics dan lomba.',
                'url' => 'https://youtu.be/K9teElePNkk?si=E6rmmaphLIwBnsjn',
                'thumbnail_url' => 'https://i.ytimg.com/vi/K9teElePNkk/hq720.jpg',
                'category' => 'Tips Juara',
                'duration' => '10:45',
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title' => 'Business Case Tips from Harvard Alumni',
                'description' => 'Video edukatif seputar business dan lomba.',
                'url' => 'https://www.youtube.com/watch?v=Hk4YtM0R4Lo',
                'thumbnail_url' => 'https://i.ytimg.com/vi/K9teElePNkk/hq720.jpg',
                'category' => 'Competition',
                'duration' => '8:56',
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title' => 'Roadmap Juara Lomba Esai Nasional',
                'description' => 'Video edukatif seputar roadmap dan lomba.',
                'url' => 'https://www.youtube.com/watch?v=T1rT-H7EyRU',
                'thumbnail_url' => 'https://i.ytimg.com/vi/K9teElePNkk/hq720.jpg',
                'category' => 'Workshop',
                'duration' => '11:01',
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title' => 'Tips Memenangkan Lomba Debat Bahasa Inggris',
                'description' => 'Video edukatif seputar tips dan lomba.',
                'url' => 'https://www.youtube.com/watch?v=pGz3z9y2JdM',
                'thumbnail_url' => 'https://i.ytimg.com/vi/K9teElePNkk/hq720.jpg',
                'category' => 'Tips Juara',
                'duration' => '8:56',
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title' => 'Tutorial Membuat PPT yang Menarik untuk Lomba',
                'description' => 'Video edukatif seputar tutorial dan lomba.',
                'url' => 'https://www.youtube.com/watch?v=trTtOjVufRg',
                'thumbnail_url' => 'https://i.ytimg.com/vi/K9teElePNkk/hq720.jpg',
                'category' => 'Competition',
                'duration' => '9:12',
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'title' => 'Kunci Jawaban Sukses Olimpiade Sains',
                'description' => 'Video edukatif seputar kunci dan lomba.',
                'url' => 'https://www.youtube.com/watch?v=oc9vFiVUNF0',
                'thumbnail_url' => 'https://i.ytimg.com/vi/K9teElePNkk/hq720.jpg',
                'category' => 'Competition',
                'duration' => '17:21',
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title' => 'Strategi Memenangkan Hackathon Dalam 24 Jam',
                'description' => 'Video edukatif seputar strategi dan lomba.',
                'url' => 'https://www.youtube.com/watch?v=i8rUN8fA67I',
                'thumbnail_url' => 'https://i.ytimg.com/vi/K9teElePNkk/hq720.jpg',
                'category' => 'Competition',
                'duration' => '10:45',
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title' => 'Workshop Esai Digital Marketing 101',
                'description' => 'Video edukatif seputar workshop dan lomba.',
                'url' => 'https://www.youtube.com/watch?v=YT7YGuKe9oA',
                'thumbnail_url' => 'https://i.ytimg.com/vi/K9teElePNkk/hq720.jpg',
                'category' => 'Workshop',
                'duration' => '10:45',
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title' => 'Mempersiapkan Business Plan untuk Kompetisi',
                'description' => 'Video edukatif seputar mempersiapkan dan lomba.',
                'url' => 'https://www.youtube.com/watch?v=Hp06Nk9RYjc',
                'thumbnail_url' => 'https://i.ytimg.com/vi/K9teElePNkk/hq720.jpg',
                'category' => 'Tutorial',
                'duration' => '10:45',
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title' => 'How to Build an MVP for Startup Competitions',
                'description' => 'Video edukatif seputar how dan lomba.',
                'url' => 'https://www.youtube.com/watch?v=FbNWoDPERrE',
                'thumbnail_url' => 'https://i.ytimg.com/vi/K9teElePNkk/hq720.jpg',
                'category' => 'Workshop',
                'duration' => '11:01',
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title' => 'Mengatur Waktu saat Lomba Multi-Tahap',
                'description' => 'Video edukatif seputar mengatur dan lomba.',
                'url' => 'https://www.youtube.com/watch?v=6oZaLiwTP2s',
                'thumbnail_url' => 'https://i.ytimg.com/vi/K9teElePNkk/hq720.jpg',
                'category' => 'Tips Juara',
                'duration' => '11:01',
                'is_featured' => true,
                'is_published' => true,
            ],
        ];

        foreach ($videos as $video) {
            LearningVideo::create($video);
        }
    }
}
