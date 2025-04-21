<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') - LombaKuy</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Header -->
  <header class="bg-indigo-600 text-white p-4 shadow">
    <div class="container mx-auto flex justify-between items-center">
      <h1 class="text-2xl font-bold">LombaKuy</h1>
      <nav class="space-x-4">
        <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>
        <form action="{{ route('logout') }}" method="POST" class="inline">
          @csrf
          <button class="hover:underline">Logout</button>
        </form>
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
