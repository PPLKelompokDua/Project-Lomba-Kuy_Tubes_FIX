<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Header -->
    <header class="bg-indigo-700 text-white p-4 shadow">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Admin Panel - LombaKuy</h1>
            <nav class="space-x-4">
                <a href="{{ route('admin.dashboard') }}" class="hover:underline">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="hover:underline">Logout</button>
                </form>
            </nav>
        </div>
    </header>

    <main class="flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow h-screen px-6 py-8">
        <h2 class="text-xl font-bold mb-6">Organizer Menu</h2>
        <ul class="space-y-4">
            <li>
                <a href="{{ route('organizer.dashboard') }}" class="text-indigo-700 hover:underline">Dashboard</a>
            </li>
            <li>
                <a href="{{ route('organizer.task.index') }}" class="text-indigo-700 hover:underline">Task Management</a>
            </li>
            <!-- Tambahkan menu lain jika perlu -->
        </ul>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 p-6">
        @yield('content')
    </div>
</main>


    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center p-4 mt-12">
        <p>&copy; {{ date('Y') }} LombaKuy Admin. All rights reserved.</p>
    </footer>

</body>
</html>
