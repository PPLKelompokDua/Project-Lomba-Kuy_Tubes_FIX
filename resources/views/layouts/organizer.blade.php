<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') - LombaKuy Organizer</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.3/dist/css/splide.min.css">

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="//unpkg.com/alpinejs" defer></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
</head>

@stack('scripts')

<body class="bg-gray-50 text-gray-800 font-sans min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-indigo-600 sticky top-0 z-50 shadow-md">
    <div class="container mx-auto px-6 py-3 flex justify-between items-center">
      <a href="/" class="text-2xl font-extrabold text-white flex items-center">
        <span class="mr-2">
          <i class="fas fa-trophy"></i>
        </span>
        LombaKuy
      </a>
      <nav class="hidden md:flex space-x-6 items-center">
        <a href="{{ route('organizer.dashboard') }}" class="text-white hover:text-indigo-200 transition font-medium">Dashboard</a>
        <form action="{{ route('logout') }}" method="POST" class="inline">
          @csrf
          <button class="bg-white text-indigo-600 hover:bg-indigo-100 transition px-4 py-2 rounded-lg font-medium">Logout</button>
        </form>
      </nav>
      
      <!-- Mobile menu button -->
      <div class="md:hidden flex items-center">
        <button class="mobile-menu-button text-white" aria-label="Open menu">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
      </div>
    </div>
    
    <!-- Mobile menu -->
    <div class="mobile-menu hidden md:hidden p-4 bg-indigo-700">
      <nav class="flex flex-col space-y-3">
        <a href="{{ route('organizer.dashboard') }}" class="text-white hover:text-indigo-200 transition py-2">Dashboard</a>
        <form action="{{ route('logout') }}" method="POST" class="inline py-2">
          @csrf
          <button class="text-white hover:text-indigo-200 transition">Logout</button>
        </form>
      </nav>
    </div>
  </header>

  <!-- Content -->
  <main class="flex-grow container mx-auto px-6 py-10">
    @yield('content')
  </main>

  <!-- Footer -->
  <footer class="bg-gray-900 text-gray-300 py-8 mt-auto">
    <div class="container mx-auto px-6">
      <div class="flex flex-col md:flex-row justify-between items-center">
        <div class="mb-6 md:mb-0">
          <a href="/" class="text-2xl font-bold text-white flex items-center">
            <span class="mr-2">
              <i class="fas fa-trophy"></i>
            </span>
            LombaKuy
          </a>
          <p class="mt-2 text-sm">Platform penyelenggaraan lomba terpercaya</p>
        </div>
        <div class="flex space-x-6">
          <a href="#" class="text-gray-400 hover:text-white transition">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="#" class="text-gray-400 hover:text-white transition">
            <i class="fab fa-twitter"></i>
          </a>
          <a href="#" class="text-gray-400 hover:text-white transition">
            <i class="fab fa-instagram"></i>
          </a>
          <a href="#" class="text-gray-400 hover:text-white transition">
            <i class="fab fa-linkedin-in"></i>
          </a>
        </div>
      </div>
      <div class="border-t border-gray-800 mt-6 pt-6 text-center text-sm">
        <p>&copy; {{ date('Y') }} LombaKuy. All Rights Reserved.</p>
      </div>
    </div>
  </footer>

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.3/dist/js/splide.min.js"></script>

  <script>
    // Initialize AOS
    document.addEventListener('DOMContentLoaded', function() {
      AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
      });
      
      // Mobile menu toggle
      const mobileMenuButton = document.querySelector('.mobile-menu-button');
      const mobileMenu = document.querySelector('.mobile-menu');
      
      if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', () => {
          mobileMenu.classList.toggle('hidden');
        });
      }
    });
  </script>
</body>
</html>