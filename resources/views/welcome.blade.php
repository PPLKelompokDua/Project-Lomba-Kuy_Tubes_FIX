<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LombaKuy – Empower Your Competitive Spirit</title>
  <meta name="description" content="LombaKuy | The ultimate platform for discovering competitions, forming winning teams, and tracking your progress." />
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Header -->
  <header class="bg-indigo-600 sticky top-0 z-50">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
      <a href="/" class="text-3xl font-extrabold text-white">LombaKuy</a>
      <nav class="hidden md:flex space-x-6 text-white font-medium">
        <a href="#features" class="hover:underline">Features</a>
        <a href="#faq" class="hover:underline">FAQ</a>
        <a href="#aboutus" class="hover:underline">About Us</a>
      </nav>
      <div class="hidden md:flex space-x-4">
        <a href="/login">
          <button class="bg-white text-indigo-600 font-bold py-2 px-5 rounded-lg hover:bg-indigo-200 transition">
            Log In
          </button>
        </a>
        <a href="/register">
          <button class="bg-white text-indigo-600 font-bold py-2 px-5 rounded-lg hover:bg-indigo-200 transition">
            Sign Up
          </button>
        </a>
      </div>
      <button class="md:hidden text-white focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
      </button>
    </div>
  </header>

  <!-- Hero Section -->
  <main class="bg-gradient-to-b from-indigo-600 to-white text-white py-20">
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 items-center gap-10">
      <div class="text-center md:text-left relative z-10">
        <!-- Box dengan efek glassmorphism ringan -->
        <div class="bg-white bg-opacity-20 backdrop-blur-lg p-10 rounded-xl">
          <h1 class="text-5xl font-extrabold leading-tight text-white">
            Organize, Compete, Succeed
          </h1>
          <p class="mt-6 text-lg font-light text-white">
            Temukan kompetisi, bentuk tim terbaik, dan pantau progres kamu secara real-time dengan LombaKuy.
          </p>
          <div class="mt-8">
            <a href="/login">
              <button class="bg-white text-indigo-600 font-bold py-3 px-6 rounded-lg hover:bg-indigo-500 transition shadow-lg">
                Get Started
              </button>
            </a>
          </div>
        </div>
      </div>
      <div>
        <!-- Ganti asset() dengan URL ilustrasi kompetisi/tim yang sesuai -->
        <img src="{{ asset('storage/images/competition-illustration.png') }}" alt="Competition Illustration" class="w-full h-auto mx-auto rounded-xl">
      </div>
    </div>
  </main>

  <!-- Features Section -->
  <section id="features" class="bg-white py-16">
    <div class="container mx-auto px-6">
      <h2 class="text-4xl font-bold text-gray-800 text-center">Our Features</h2>
      <p class="mt-4 text-lg text-gray-600 text-center max-w-2xl mx-auto">
        LombaKuy menghadirkan serangkaian fitur inovatif untuk membantu kamu mencari kompetisi, membentuk tim, dan mengelola perjalanan kompetisi secara efektif.
      </p>
      
      <!-- Grid Fitur: 6 item, 2 baris x 3 kolom di resolusi md ke atas -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
        
        <!-- 1. Competition Search & Registration -->
        <div class="bg-gray-50 rounded-xl shadow-md p-6 hover:shadow-lg transition">
          <div class="flex items-center justify-center w-16 h-16 bg-indigo-100 rounded-full mx-auto mb-4">
            <!-- Ikon pencarian -->
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2"
              viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="11" cy="11" r="8" />
              <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-800 text-center mb-3">
            Competition Search & Registration
          </h3>
          <p class="text-gray-600 text-center">
            Cari kompetisi yang sesuai minat kamu dan daftar dengan mudah melalui tautan resmi.
          </p>
        </div>

        <!-- 2. Team Matching & Assessment -->
        <div class="bg-gray-50 rounded-xl shadow-md p-6 hover:shadow-lg transition">
          <div class="flex items-center justify-center w-16 h-16 bg-indigo-100 rounded-full mx-auto mb-4">
            <!-- Ikon assessment/team -->
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2"
              viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17 21v-2a4 4 0 00-3-3.87" />
              <path d="M7 21v-2a4 4 0 013-3.87" />
              <circle cx="12" cy="7" r="4" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-800 text-center mb-3">
            Team Matching & Assessment
          </h3>
          <p class="text-gray-600 text-center">
            Temukan rekan tim potensial melalui tes kecocokan dan rekomendasi berbasis data.
          </p>
        </div>

        <!-- 3. Task & Timeline Management -->
        <div class="bg-gray-50 rounded-xl shadow-md p-6 hover:shadow-lg transition">
          <div class="flex items-center justify-center w-16 h-16 bg-indigo-100 rounded-full mx-auto mb-4">
            <!-- Ikon kalender/tugas -->
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2"
              viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
              <line x1="16" y1="2" x2="16" y2="6" />
              <line x1="8" y1="2" x2="8" y2="6" />
              <line x1="3" y1="10" x2="21" y2="10" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-800 text-center mb-3">
            Task & Timeline Management
          </h3>
          <p class="text-gray-600 text-center">
            Pantau tugas, milestone, dan deadline kompetisi kamu dalam satu platform terintegrasi.
          </p>
        </div>

        <!-- 4. Performance Analytics -->
        <div class="bg-gray-50 rounded-xl shadow-md p-6 hover:shadow-lg transition">
          <div class="flex items-center justify-center w-16 h-16 bg-indigo-100 rounded-full mx-auto mb-4">
            <!-- Ikon grafik/analytics -->
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2"
              viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
              <line x1="3" y1="12" x2="7" y2="12" />
              <line x1="3" y1="6" x2="7" y2="6" />
              <line x1="3" y1="18" x2="7" y2="18" />
              <line x1="11" y1="18" x2="11" y2="9" />
              <line x1="15" y1="18" x2="15" y2="4" />
              <line x1="19" y1="18" x2="19" y2="14" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-800 text-center mb-3">
            Performance Analytics
          </h3>
          <p class="text-gray-600 text-center">
            Lihat data dan grafik performa tim untuk identifikasi area perbaikan dan sukses.
          </p>
        </div>

        <!-- 5. Community Stories & Feedback -->
        <div class="bg-gray-50 rounded-xl shadow-md p-6 hover:shadow-lg transition">
          <div class="flex items-center justify-center w-16 h-16 bg-indigo-100 rounded-full mx-auto mb-4">
            <!-- Ikon chat atau komentar -->
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2"
              viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h11l5 5z" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-800 text-center mb-3">
            Community Stories & Feedback
          </h3>
          <p class="text-gray-600 text-center">
            Bagikan pengalaman kompetisi kamu dan berikan feedback untuk peningkatan kualitas layanan.
          </p>
        </div>

        <!-- 6. Educational Resources -->
        <div class="bg-gray-50 rounded-xl shadow-md p-6 hover:shadow-lg transition">
          <div class="flex items-center justify-center w-16 h-16 bg-indigo-100 rounded-full mx-auto mb-4">
            <!-- Ikon buku atau video -->
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2"
              viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
              <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
              <path d="M4 4.5A2.5 2.5 0 0 1 6.5 7H20" />
              <path d="M4 4.5v15" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-800 text-center mb-3">
            Educational Resources
          </h3>
          <p class="text-gray-600 text-center">
            Akses artikel, video, dan tutorial untuk memperkuat strategi dan pengetahuan kompetisi kamu.
          </p>
        </div>

      </div>
    </div>
  </section>

  <!-- Stats Section -->
  <section class="bg-white py-16">
    <div class="container mx-auto text-center">
      <h2 class="text-4xl font-bold text-gray-800">Join a Thriving Competition Community</h2>
      <p class="mt-4 text-lg text-gray-600">
        Ratusan kompetisi telah diikuti, dan ribuan mahasiswa telah merasakan manfaat LombaKuy.
      </p>
      <div class="mt-12 flex justify-center space-x-16">
        <div class="text-center">
          <h3 class="text-6xl font-extrabold text-indigo-600">500+</h3>
          <p class="text-gray-700 mt-2">Competitions Registered</p>
        </div>
        <div class="text-center">
          <h3 class="text-6xl font-extrabold text-indigo-600">4.9</h3>
          <p class="text-gray-700 mt-2">User Rating</p>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <section id="faq" class="py-16 bg-white">
    <div class="container mx-auto">
      <h2 class="text-4xl font-bold text-gray-800 text-center">Frequently Asked Questions</h2>
      <div class="mt-12 space-y-8">
        <div class="border border-gray-300 rounded-lg p-6 shadow-md hover:shadow-lg transition">
          <h3 class="text-2xl font-semibold text-gray-800">What is LombaKuy?</h3>
          <p class="mt-3 text-gray-600 leading-relaxed">
            LombaKuy adalah platform yang membantu mahasiswa mencari informasi kompetisi, membentuk tim, dan mengelola progres kompetisi secara terintegrasi.
          </p>
        </div>
        <div class="border border-gray-300 rounded-lg p-6 shadow-md hover:shadow-lg transition">
          <h3 class="text-2xl font-semibold text-gray-800">Is LombaKuy free?</h3>
          <p class="mt-3 text-gray-600 leading-relaxed">
            Ya, LombaKuy menyediakan akses dasar yang gratis untuk membantu kamu mengelola kompetisi dengan mudah.
          </p>
        </div>
        <div class="border border-gray-300 rounded-lg p-6 shadow-md hover:shadow-lg transition">
          <h3 class="text-2xl font-semibold text-gray-800">How do I join a competition?</h3>
          <p class="mt-3 text-gray-600 leading-relaxed">
            Cari kompetisi melalui fitur pencarian kami, lalu lengkapi pendaftaran dengan mengikuti tautan resmi yang disediakan.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- About Us Section -->
  <section id="aboutus" class="relative py-16 bg-gradient-to-b from-indigo-50 to-white overflow-hidden">
    <!-- Wave SVG di bagian atas -->
    <div class="absolute inset-x-0 top-0 -z-10 overflow-hidden">
      <svg class="block w-full h-32" viewBox="0 0 1440 320" preserveAspectRatio="none">
        <path fill="#EEF2FF" fill-opacity="1"
              d="M0,224L60,234.7C120,245,240,267,360,272C480,277,600,267,720,245.3C840,224,960,192,1080,186.7C1200,181,1320,203,1380,213.3L1440,224L1440,0L1380,0C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0L0,0Z">
        </path>
      </svg>
    </div>
    <div class="container mx-auto px-6 text-center">
      <h2 class="text-4xl md:text-5xl font-extrabold text-indigo-600 tracking-tight drop-shadow-sm">
        Meet Our Team
      </h2>
      <div class="mt-10 flex justify-center">
        <!-- Ganti dengan foto grup tim LombaKuy -->
        <img src="{{ asset('images/aboutus-lombakuy.jpg') }}" alt="Team Photo of LombaKuy" class="w-full max-w-3xl rounded-lg shadow-xl object-cover">
      </div>
      <p class="mt-8 text-gray-600 leading-relaxed text-justify">
        Kami adalah tim LombaKuy, mahasiswa Sistem Informasi dari Telkom University Matakuliah Proyek Perangkat Lunak Kelas SI4609 Kelompok 2 berkomitmen menghadirkan platform terintegrasi untuk mempermudah pencarian kompetisi dan pengelolaan tim. Dengan semangat inovasi, kami mendukung setiap langkah untuk membangun pengalaman kompetisi yang lebih terstruktur, efektif, dan penuh inspirasi.
      </p>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-gray-300 py-16">
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">
      <div>
        <h3 class="text-lg font-bold">Ready to get started?</h3>
        <button class="mt-6 bg-indigo-600 text-white font-bold py-2 px-5 rounded-lg hover:bg-indigo-700 transition shadow-lg">
          Get Started
        </button>
      </div>
      <div>
        <h3 class="text-lg font-bold">Quick Links</h3>
        <ul class="mt-4 space-y-2">
          <li><a href="#" class="hover:underline">Home</a></li>
          <li><a href="#features" class="hover:underline">Features</a></li>
        </ul>
      </div>
      <div>
        <h3 class="text-lg font-bold">Stay Connected</h3>
        <ul class="mt-4 space-y-2">
          <li><a href="#" class="hover:underline">Instagram</a></li>
          <li><a href="#" class="hover:underline">Facebook</a></li>
        </ul>
      </div>
      <div>
        <h3 class="text-lg font-bold">Legal</h3>
        <ul class="mt-4 space-y-2">
          <li><a href="#" class="hover:underline">Privacy Policy</a></li>
          <li><a href="#" class="hover:underline">Terms of Service</a></li>
        </ul>
      </div>
    </div>
    <div class="text-center mt-12">
      <p>&copy; 2025 LombaKuy. All Rights Reserved.</p>
    </div>
  </footer>

</body>
</html>
