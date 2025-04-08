<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title') - LombaKuy</title>
  <script src="https://cdn.tailwindcss.com"></script>
  @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Header -->
  <header class="bg-indigo-600 sticky top-0 z-50">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
      <!-- Logo -->
      <a href="{{ route('welcome') }}" class="text-3xl font-extrabold text-white">LombaKuy</a>

      <!-- Nav Menu -->
      <nav class="hidden md:flex items-center space-x-6 text-white font-medium">
        <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>

        <!-- Logout -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
          @csrf
        </form>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="hover:underline">
          Logout
        </a>
      </nav>

      <!-- Mobile menu button -->
      <button class="md:hidden text-white focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
          viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
      </button>
    </div>
  </header>

  <!-- Main Content -->
  <main class="container mx-auto my-8 px-6">
    @yield('content')
  </main>

  <!-- Footer -->
  <footer class="bg-gray-900 text-gray-300 text-center py-4">
    <p>&copy; {{ date('Y') }} LombaKuy. All Rights Reserved.</p>
  </footer>

  @stack('scripts')
</body>
</html>
