<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') - LombaKuy</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.3/dist/css/splide.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

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
      <!-- Logo -->
      <a href="{{ route('dashboard') }}" class="text-2xl font-extrabold text-white flex items-center">
        <span class="mr-2">
          <i class="fas fa-trophy"></i>
        </span>
        LombaKuy
      </a>

      <!-- Desktop Navigation -->
      <nav class="hidden md:flex space-x-6 items-center">
        <a href="{{ route('dashboard') }}" class="text-white hover:text-indigo-200 transition font-medium">Dashboard</a>
        <a href="{{ route('explore') }}" class="text-white hover:text-indigo-200 transition font-medium">Explore Competitions</a>
        <a href="{{ route('teams.index') }}" class="text-white hover:text-indigo-200 transition font-medium">My Team</a>
        <a href="{{ route('invitations.index') }}" class="text-white hover:text-indigo-200 transition font-medium">Invitations</a>
        <a href="{{ route('posts.index') }}" class="text-white hover:text-indigo-200 transition font-medium">Story Space</a>
        <a href="{{ route('feedbacks.index') }}" class="text-white hover:text-indigo-200 transition font-medium">Feedbacks</a>
        @auth
          @php 
            // ambil unread notification
            $notif = \App\Models\Notification::where('user_id', auth()->id())
                      ->where('is_read', false)
                      ->orderBy('created_at','desc')
                      ->get();
          @endphp

          <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="relative text-white">
              <i class="fas fa-bell"></i>
              @if($notif->count())
                <span class="absolute top-0 right-0 bg-red-600 text-xs text-white rounded-full px-1">
                  {{ $notif->count() }}
                </span>
              @endif
            </button>
            <div x-show="open" @click.away="open = false"
                class="absolute right-0 mt-2 w-64 bg-white text-black shadow-lg rounded">
              @forelse($notif as $notification)
                <form method="POST" action="{{ route('notifications.markAsRead', $notification->id) }}">
                <a href="{{ route('notifications.read', $notification->id) }}" class="block px-4 py-2 hover:bg-gray-100">
                  📩 {{ $notification->message }}
                </a>

                </form>
              @empty
                <div class="px-4 py-2 text-sm text-gray-500">
                  Tidak ada notifikasi baru
                </div>
              @endforelse
            </div>
          </div>
        @endauth
        @auth
          <div x-data="{ open: false }" class="relative">
            <!-- Profile Picture -->
            <button @click="open = !open" class="flex items-center focus:outline-none" aria-label="User menu">
              <img 
                src="{{ auth()->user()->profile_image ? asset('storage/images/' . auth()->user()->profile_image) : 'https://via.placeholder.com/150' }}" 
                alt="Profile Picture" 
                class="w-10 h-10 rounded-full object-cover border-2 border-white"
              >
            </button>
            <!-- Dropdown -->
            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
              <div class="px-4 py-2 border-b border-gray-200">
                <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-600">{{ auth()->user()->email }}</p>
              </div>
              <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-800 hover:bg-indigo-100 transition">
                <i class="fas fa-user mr-2"></i> View Profile
              </a>
              @if(auth()->user()->role === 'user')
                <a href="{{ route('settings') }}" class="block px-4 py-2 text-sm text-gray-800 hover:bg-indigo-100 transition">
                  <i class="fas fa-cog mr-2"></i> Settings
                </a>
              @endif
              <form action="{{ route('logout') }}" method="POST" class="block">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-800 hover:bg-indigo-100 transition">
                  <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
              </form>
            </div>
          </div>
        @endauth
      </nav>
      
      <!-- Mobile Menu Button -->
      <div class="md:hidden flex items-center">
        <button class="mobile-menu-button text-white" aria-label="Open menu">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
      </div>
    </div>
    
    <!-- Mobile Menu -->
    <div class="mobile-menu hidden md:hidden p-4 bg-indigo-700">
      <nav class="flex flex-col space-y-3">
        <a href="{{ route('dashboard') }}" class="text-white hover:text-indigo-200 transition py-2">Dashboard</a>
        <a href="{{ route('explore') }}" class="text-white hover:text-indigo-200 transition py-2">Explore Competitions</a>
        <a href="{{ route('teams.index') }}" class="text-white hover:text-indigo-200 transition font-medium">My Team</a>
        <a href="{{ route('invitations.index') }}" class="text-white hover:text-indigo-200 transition font-medium">Invitations</a>
        <a href="{{ route('posts.index') }}" class="text-white hover:text-indigo-200 transition font-medium">Story Space</a>
        <a href="{{ route('feedbacks.index') }}" class="text-white hover:text-indigo-200 transition font-medium">Feedbacks</a>
        @auth
          <div x-data="{ open: false }" class="relative">
            <!-- Profile Picture -->
            <button @click="open = !open" class="flex items-center text-white hover:text-indigo-200 transition py-2" aria-label="User menu">
              <img 
                src="{{ auth()->user()->profile_image ? asset('storage/images/' . auth()->user()->profile_image) : 'https://via.placeholder.com/150' }}" 
                alt="Profile Picture" 
                class="w-8 h-8 rounded-full object-cover mr-2"
              >
              <span>{{ auth()->user()->name }}</span>
            </button>
            <!-- Dropdown -->
            <div x-show="open" class="pl-4 mt-1">
              <div class="text-sm text-indigo-200">
                <p>{{ auth()->user()->email }}</p>
              </div>
              <a href="{{ route('profile.show') }}" class="block py-2 text-white hover:text-indigo-200 transition">
                <i class="fas fa-user mr-2"></i> View Profile
              </a>
              @if(auth()->user()->role === 'user')
                <a href="{{ route('settings') }}" class="block py-2 text-white hover:text-indigo-200 transition">
                  <i class="fas fa-cog mr-2"></i> Settings
                </a>
              @endif
              <form action="{{ route('logout') }}" method="POST" class="block py-2">
                @csrf
                <button type="submit" class="text-white hover:text-indigo-200 transition">
                  <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
              </form>
            </div>
          </div>
        @endauth
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
          <p class="mt-2 text-sm">Empowering your competitive spirit</p>
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
        <p>© {{ date('Y') }} LombaKuy. All Rights Reserved.</p>
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