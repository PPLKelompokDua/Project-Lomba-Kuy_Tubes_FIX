<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') - LombaKuy Admin</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="//unpkg.com/alpinejs" defer></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
</head>

@stack('scripts')

<body class="bg-gray-100 text-gray-800 font-sans min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-gray-900 sticky top-0 z-50 shadow-md">
    <div class="container mx-auto px-6 py-3 flex justify-between items-center">
      <a href="{{ route('admin.dashboard') }}" class="text-2xl font-extrabold text-white flex items-center">
        <span class="mr-2">
          <i class="fas fa-shield-alt"></i>
        </span>
        LombaKuy Admin
      </a>
      <nav class="hidden md:flex space-x-6 items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-white hover:text-gray-300 transition font-medium">Dashboard</a>
        <form action="{{ route('logout') }}" method="POST" class="inline">
          @csrf
          <button class="bg-red-600 text-white hover:bg-red-700 transition px-4 py-2 rounded-lg font-medium">Logout</button>
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
    <div class="mobile-menu hidden md:hidden p-4 bg-gray-800">
      <nav class="flex flex-col space-y-3">
        <a href="{{ route('admin.dashboard') }}" class="text-white hover:text-gray-300 transition py-2">Dashboard</a>
        <form action="{{ route('logout') }}" method="POST" class="inline py-2">
          @csrf
          <button class="text-white hover:text-gray-300 transition">Logout</button>
        </form>
      </nav>
    </div>
  </header>

  <!-- Sidebar and Content -->
  <div class="flex flex-grow">
    <!-- Sidebar -->
    <aside class="hidden md:block w-64 bg-white shadow-md">
      <div class="p-4">
        <div class="mb-4 pb-4 border-b border-gray-200">
          <div class="font-bold text-gray-700">Admin Navigation</div>
        </div>
        <nav class="flex flex-col space-y-1">
          <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
            <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
          </a>
        </nav>
      </div>
    </aside>

    <!-- Content -->
    <main class="flex-grow container mx-auto px-6 py-8">
      <div class="bg-white rounded-lg shadow-md p-6">
        @yield('content')
      </div>
    </main>
  </div>

  <!-- Footer -->
  <footer class="bg-gray-900 text-gray-300 py-6 mt-auto">
    <div class="container mx-auto px-6">
      <div class="flex flex-col md:flex-row justify-between items-center">
        <div class="mb-4 md:mb-0">
          <span class="text-xl font-bold text-white">LombaKuy Admin</span>
          <p class="mt-1 text-sm">Management System</p>
        </div>
        <div class="text-center text-sm">
          <p>&copy; {{ date('Y') }} LombaKuy. All Rights Reserved.</p>
        </div>
      </div>
    </div>
  </footer>

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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