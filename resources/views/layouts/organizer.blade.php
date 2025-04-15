<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') - LombaKuy</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.3/dist/css/splide.min.css">

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="//unpkg.com/alpinejs" defer></script>
</head>

@stack('scripts')

<body class="d-flex flex-column min-vh-100 bg-gray-50 text-gray-800">

  <!-- Header -->
  <header class="bg-indigo-600 text-white p-4 shadow">
    <div class="container mx-auto flex justify-between items-center">
      <h1 class="text-2xl font-bold">LombaKuy</h1>
      <nav class="space-x-4 flex items-center">
        <a href="{{ route('organizer.dashboard') }}" class="hover:underline">Dashboard</a>
        <form action="{{ route('logout') }}" method="POST" class="inline">
          @csrf
          <button class="hover:underline">Logout</button>
        </form>
      </nav>
    </div>
  </header>

  <!-- Content -->
  <main class="flex-grow-1 container mx-auto px-4 py-10">
    @yield('content')
  </main>

  <!-- Footer -->
  <footer class="bg-gray-900 text-white text-center py-4 mt-auto">
    &copy; {{ date('Y') }} LombaKuy. All rights reserved.
  </footer>

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.3/dist/js/splide.min.js"></script>
</body>
</html>
