<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentOption;

class AssessmentQuestionsSeeder extends Seeder
{
    public function run()
    {
        $questions = [
            // Gaya Kerja
            [
                'category' => 'Gaya Kerja',
                'question' => 'Ketika mengerjakan tugas, mana yang lebih menggambarkan dirimu?',
                'options' => [
                    'A' => 'Lebih suka merancang ide dan konsep',
                    'B' => 'Lebih suka mengeksekusi dan menyelesaikan tugas dengan cepat',
                ],
            ],
            [
                'category' => 'Gaya Kerja',
                'question' => 'Ketika menghadapi tenggat waktu, kamu cenderung:',
                'options' => [
                    'A' => 'Menyusun rencana matang dari awal',
                    'B' => 'Bergerak cepat dan menyelesaikan sambil berjalan',
                ],
            ],
            [
                'category' => 'Gaya Kerja',
                'question' => 'Kamu lebih suka bekerja dengan orang yang:',
                'options' => [
                    'A' => 'Terstruktur dan detail',
                    'B' => 'Fleksibel dan kreatif',
                ],
            ],
            [
                'category' => 'Gaya Kerja',
                'question' => 'Kalau diberi waktu luang dalam proyek, kamu akan:',
                'options' => [
                    'A' => 'Mengeksplor ide tambahan yang bisa memperkaya proyek',
                    'B' => 'Memperbaiki hal-hal teknis agar hasil lebih optimal',
                ],
            ],
            [
                'category' => 'Gaya Kerja',
                'question' => 'Kamu lebih nyaman bekerja dalam tim yang:',
                'options' => [
                    'A' => 'Terorganisir dan terstruktur',
                    'B' => 'Dinamis dan spontan',
                ],
            ],
            [
                'category' => 'Gaya Kerja',
                'question' => 'Saat diberikan tugas baru dalam tim, kamu akan:',
                'options' => [
                    'A' => 'Bertanya detail dulu sebelum mulai',
                    'B' => 'Langsung coba kerjakan dan sesuaikan sambil jalan',
                ],
            ],

            // Leadership & Problem Solving
            [
                'category' => 'Leadership & Problem Solving',
                'question' => 'Saat ada masalah tak terduga dalam proyek, kamu akan:',
                'options' => [
                    'A' => 'Menghentikan pekerjaan untuk evaluasi dulu',
                    'B' => 'Coba selesaikan secepatnya agar proyek tetap jalan',
                ],
            ],
            [
                'category' => 'Leadership & Problem Solving',
                'question' => 'Ketika bekerja dalam tim, kamu lebih suka peran sebagai:',
                'options' => [
                    'A' => 'Perencana strategi',
                    'B' => 'Pelaksana dan penggerak',
                ],
            ],
            [
                'category' => 'Leadership & Problem Solving',
                'question' => 'Kalau melihat anggota tim bingung, kamu akan:',
                'options' => [
                    'A' => 'Memberi arahan agar jelas langkahnya',
                    'B' => 'Ajak diskusi agar semua punya solusi sendiri',
                ],
            ],
            [
                'category' => 'Leadership & Problem Solving',
                'question' => 'Ketika semua orang bingung harus mulai dari mana, kamu:',
                'options' => [
                    'A' => 'Ambil inisiatif menyusun urutan kerja',
                    'B' => 'Menunggu arahan dan mulai setelah jelas',
                ],
            ],
            [
                'category' => 'Leadership & Problem Solving',
                'question' => 'Dalam mengambil keputusan cepat, kamu lebih percaya pada:',
                'options' => [
                    'A' => 'Data dan analisis logis',
                    'B' => 'Intuisi dan pengalaman pribadi',
                ],
            ],
            [
                'category' => 'Leadership & Problem Solving',
                'question' => 'Saat bekerja dalam tim besar, kamu cenderung:',
                'options' => [
                    'A' => 'Mengatur pembagian tugas dengan jelas',
                    'B' => 'Menjadi penghubung antar bagian yang berbeda',
                ],
            ],

            // Komunikasi dalam Tim
            [
                'category' => 'Komunikasi dalam Tim',
                'question' => 'Dalam diskusi tim, kamu lebih sering:',
                'options' => [
                    'A' => 'Menjadi moderator yang menjaga jalannya diskusi',
                    'B' => 'Menjadi kontributor ide yang aktif',
                ],
            ],
            [
                'category' => 'Komunikasi dalam Tim',
                'question' => 'Kalau ada konflik kecil dalam tim, kamu akan:',
                'options' => [
                    'A' => 'Menyelesaikannya dengan pendekatan rasional',
                    'B' => 'Menggunakan pendekatan emosional dan empati',
                ],
            ],
            [
                'category' => 'Komunikasi dalam Tim',
                'question' => 'Saat mengomunikasikan ide, kamu:',
                'options' => [
                    'A' => 'Menyusun poin-poin penting sebelum berbicara',
                    'B' => 'Menyampaikan ide spontan dan alami',
                ],
            ],
            [
                'category' => 'Komunikasi dalam Tim',
                'question' => 'Jika ada anggota tim tidak aktif, kamu akan:',
                'options' => [
                    'A' => 'Menanyakan alasannya dan mencari solusi bersama',
                    'B' => 'Mengisi perannya tanpa banyak komentar',
                ],
            ],
            [
                'category' => 'Komunikasi dalam Tim',
                'question' => 'Dalam menyampaikan kritik, kamu:',
                'options' => [
                    'A' => 'Gunakan kalimat yang netral dan objektif',
                    'B' => 'Tambahkan pujian agar lebih diterima',
                ],
            ],
            [
                'category' => 'Komunikasi dalam Tim',
                'question' => 'Ketika bertugas sebagai koordinator, kamu:',
                'options' => [
                    'A' => 'Memberikan laporan rutin dan update perkembangan',
                    'B' => 'Membuat suasana kerja tetap ringan dan menyenangkan',
                ],
            ],
            [
                'category' => 'Komunikasi dalam Tim',
                'question' => 'Kamu merasa lebih produktif dalam komunikasi:',
                'options' => [
                    'A' => 'Lewat dokumen tertulis yang rapi',
                    'B' => 'Lewat diskusi langsung atau obrolan santai',
                ],
            ],
            [
                'category' => 'Komunikasi dalam Tim',
                'question' => 'Saat presentasi kelompok, kamu biasanya:',
                'options' => [
                    'A' => 'Menyiapkan naskah dan latihan terlebih dahulu',
                    'B' => 'Lebih suka berbicara spontan dengan alur sendiri',
                ],
            ],
        ];

        foreach ($questions as $q) {
            $question = AssessmentQuestion::create([
                'category' => $q['category'],
                'question' => $q['question'],
            ]);

            foreach ($q['options'] as $label => $text) {
                AssessmentOption::create([
                    'assessment_question_id' => $question->id,
                    'label' => $label,
                    'text' => $text,
                ]);
            }
        }
    }
}
