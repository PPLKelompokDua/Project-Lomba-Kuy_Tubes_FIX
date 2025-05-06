<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') - LombaKuy</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Header -->
<<<<<<< Updated upstream
  <header class="bg-indigo-600 text-white p-4 shadow">
    <div class="container mx-auto flex justify-between items-center">
      <h1 class="text-2xl font-bold">LombaKuy</h1>
      <nav class="space-x-4">
        <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>
        <form action="{{ route('logout') }}" method="POST" class="inline">
          @csrf
          <button class="hover:underline">Logout</button>
        </form>
=======
  <header class="bg-indigo-600 sticky top-0 z-50 shadow-md">
    <div class="container mx-auto px-6 py-3 flex justify-between items-center">
      <!-- Logo -->
      <a href="/" class="text-2xl font-extrabold text-white flex items-center">
        <span class="mr-2">
          <i class="fas fa-trophy"></i>
        </span>
        LombaKuy
      </a>

      <!-- Desktop Navigation -->
      <nav class="hidden md:flex space-x-6 items-center">
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

        <a href="{{ route('dashboard') }}" class="text-white hover:text-indigo-200 transition font-medium">Dashboard</a>
        <a href="{{ route('explore') }}" class="text-white hover:text-indigo-200 transition font-medium">Eksplorasi Lomba</a>
        <a href="{{ route('teams.index') }}" class="text-white hover:text-indigo-200 transition font-medium">Team Saya</a>
        <a href="{{ route('invitations.index') }}" class="text-white hover:text-indigo-200 transition font-medium">Invitation</a>
        <a href="{{ route('posts.index') }}" class="text-white hover:text-indigo-200 transition font-medium">Story Space</a>
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
                <i class="fas fa-user mr-2"></i> Lihat Profil
              </a>
              @if(auth()->user()->role === 'user')
                <a href="{{ route('settings') }}" class="block px-4 py-2 text-sm text-gray-800 hover:bg-indigo-100 transition">
                  <i class="fas fa-cog mr-2"></i> Pengaturan
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
        <a href="{{ route('explore') }}" class="text-white hover:text-indigo-200 transition py-2">Eksplorasi Lomba</a>
        <a href="#" class="text-white hover:text-indigo-200 transition py-2">Team Saya</a>
        <a href="{{ route('posts.index') }}" class="text-white hover:text-indigo-200 transition py-2">Feed Story</a>
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
                <i class="fas fa-user mr-2"></i> Lihat Profil
              </a>
              @if(auth()->user()->role === 'user')
                <a href="{{ route('settings') }}" class="block py-2 text-white hover:text-indigo-200 transition">
                  <i class="fas fa-cog mr-2"></i> Pengaturan
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
>>>>>>> Stashed changes
      </nav>
    </div>
  </header>

 
  <!-- Content -->
  <main class="container mx-auto px-4 py-10">
    @yield('content')
  </main>

  <!-- Footer -->
  <footer class="bg-gray-900 text-white text-center py-4">
    &copy; {{ date('Y') }} LombaKuy. All rights reserved.
  </footer>

</body>
</html>
