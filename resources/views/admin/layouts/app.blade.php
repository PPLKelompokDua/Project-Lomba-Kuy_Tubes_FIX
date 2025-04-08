<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Header Admin -->
    <header class="bg-pink-500 text-white p-4">
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold">Admin Panel</h1>
        </div>
    </header>

    <!-- Content Admin -->
    <main class="container mx-auto my-8">
        @yield('content')
    </main>

    <!-- Footer Admin -->
    <footer class="bg-gray-900 text-gray-300 text-center py-4">
        <p>&copy; {{ date('Y') }} LombaKuy - Admin Panel. All Rights Reserved.</p>
    </footer>
</body>
</html>
