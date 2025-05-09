@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8 px-4">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-md">
        <h1 class="text-2xl font-bold mb-4 text-indigo-700">Assessment Kepribadian</h1>

        @if(session('result'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                <h2 class="font-semibold">Hasil Assessment:</h2>
                <ul class="list-disc pl-5">
                    @foreach(session('result') as $category => $score)
                        <li>{{ $category }}: {{ $score }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('assessment.store') }}" method="POST" class="space-y-6">
            @csrf

            @php
                $questions = [
                    'Gaya Kerja' => [
                        ['text' => 'Ketika mengerjakan tugas, mana yang lebih menggambarkan dirimu?', 'options' => ['A' => 'Lebih suka merancang ide dan konsep', 'B' => 'Lebih suka mengeksekusi dan menyelesaikan tugas dengan cepat']],
                        ['text' => 'Ketika menghadapi tenggat waktu, kamu cenderung:', 'options' => ['A' => 'Menyusun rencana matang dari awal', 'B' => 'Bergerak cepat dan menyelesaikan sambil berjalan']],
                        ['text' => 'Kamu lebih suka bekerja dengan orang yang:', 'options' => ['A' => 'Terstruktur dan detail', 'B' => 'Fleksibel dan kreatif']],
                        ['text' => 'Kalau diberi waktu luang dalam proyek, kamu akan:', 'options' => ['A' => 'Mengeksplor ide tambahan yang bisa memperkaya proyek', 'B' => 'Memperbaiki hal-hal teknis agar hasil lebih optimal']],
                        ['text' => 'Kamu lebih nyaman bekerja dalam tim yang:', 'options' => ['A' => 'Terorganisir dan terstruktur', 'B' => 'Dinamis dan spontan']],
                        ['text' => 'Saat diberikan tugas baru dalam tim, kamu akan:', 'options' => ['A' => 'Bertanya detail dulu sebelum mulai', 'B' => 'Langsung coba kerjakan dan sesuaikan sambil jalan']],
                    ],
                    'Leadership & Problem Solving' => [
                        ['text' => 'Saat ada masalah tak terduga dalam proyek, kamu akan:', 'options' => ['A' => 'Menghentikan pekerjaan untuk evaluasi dulu', 'B' => 'Coba selesaikan secepatnya agar proyek tetap jalan']],
                        ['text' => 'Ketika bekerja dalam tim, kamu lebih suka peran sebagai:', 'options' => ['A' => 'Perencana strategi', 'B' => 'Pelaksana dan penggerak']],
                        ['text' => 'Kalau melihat anggota tim bingung, kamu akan:', 'options' => ['A' => 'Memberi arahan agar jelas langkahnya', 'B' => 'Ajak diskusi agar semua punya solusi sendiri']],
                        ['text' => 'Ketika semua orang bingung harus mulai dari mana, kamu:', 'options' => ['A' => 'Ambil inisiatif menyusun urutan kerja', 'B' => 'Menunggu arahan dan mulai setelah jelas']],
                        ['text' => 'Dalam mengambil keputusan cepat, kamu lebih percaya pada:', 'options' => ['A' => 'Data dan analisis logis', 'B' => 'Intuisi dan pengalaman pribadi']],
                        ['text' => 'Saat bekerja dalam tim besar, kamu cenderung:', 'options' => ['A' => 'Mengatur pembagian tugas dengan jelas', 'B' => 'Menjadi penghubung antar bagian yang berbeda']],
                    ],
                    'Komunikasi dalam Tim' => [
                        ['text' => 'Dalam diskusi tim, kamu lebih sering:', 'options' => ['A' => 'Menjadi moderator yang menjaga jalannya diskusi', 'B' => 'Menjadi kontributor ide yang aktif']],
                        ['text' => 'Kalau ada konflik kecil dalam tim, kamu akan:', 'options' => ['A' => 'Menyelesaikannya dengan pendekatan rasional', 'B' => 'Menggunakan pendekatan emosional dan empati']],
                        ['text' => 'Saat mengomunikasikan ide, kamu:', 'options' => ['A' => 'Menyusun poin-poin penting sebelum berbicara', 'B' => 'Menyampaikan ide spontan dan alami']],
                        ['text' => 'Jika ada anggota tim tidak aktif, kamu akan:', 'options' => ['A' => 'Menanyakan alasannya dan mencari solusi bersama', 'B' => 'Mengisi perannya tanpa banyak komentar']],
                        ['text' => 'Dalam menyampaikan kritik, kamu:', 'options' => ['A' => 'Gunakan kalimat yang netral dan objektif', 'B' => 'Tambahkan pujian agar lebih diterima']],
                        ['text' => 'Ketika bertugas sebagai koordinator, kamu:', 'options' => ['A' => 'Memberikan laporan rutin dan update perkembangan', 'B' => 'Membuat suasana kerja tetap ringan dan menyenangkan']],
                        ['text' => 'Kamu merasa lebih produktif dalam komunikasi:', 'options' => ['A' => 'Lewat dokumen tertulis yang rapi', 'B' => 'Lewat diskusi langsung atau obrolan santai']],
                        ['text' => 'Saat presentasi kelompok, kamu biasanya:', 'options' => ['A' => 'Menyiapkan naskah dan latihan terlebih dahulu', 'B' => 'Lebih suka berbicara spontan dengan alur sendiri']],
                    ],
                ];
                $index = 0;
            @endphp

            @foreach($questions as $category => $qs)
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-indigo-600 mb-2">{{ $category }}</h2>
                    @foreach($qs as $q)
                        <div class="mb-4">
                            <p class="font-medium">{{ $loop->iteration }}. {{ $q['text'] }}</p>
                            @foreach($q['options'] as $key => $value)
                                <label class="block ml-4">
                                    <input type="radio" name="answers[{{ $index }}]" value="{{ $key }}" required class="mr-2">
                                    {{ $key }}. {{ $value }}
                                </label>
                            @endforeach
                        </div>
                        @php $index++; @endphp
                    @endforeach
                </div>
            @endforeach

            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Simpan Hasil</button>
        </form>
    </div>
</div>
@endsection
