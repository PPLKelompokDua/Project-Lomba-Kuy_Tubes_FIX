<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - LombaKuy</title>
  <meta name="description" content="Login page for LombaKuy, your ultimate platform to manage and participate in competitions." />
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

  <!-- Header -->
  <header class="bg-indigo-600 sticky top-0 z-50">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
      <a href="/" class="text-3xl font-extrabold text-white">LombaKuy</a>
    </div>
  </header>

  <!-- Login Form Section -->
  <main class="flex items-center justify-center min-h-screen bg-gradient-to-b from-indigo-600 to-white">
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
      <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Log In</h2>
      @if ($errors->any())
        <div class="mb-4">
          <ul>
            @foreach ($errors->all() as $error)
              <li class="text-red-500 text-sm">{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-4">
          <label class="block text-gray-700 mb-2" for="email">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus 
                 class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div class="mb-6">
          <label class="block text-gray-700 mb-2" for="password">Password</label>
          <input type="password" id="password" name="password" required autocomplete="current-password" 
                 class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div class="flex items-center justify-between">
          <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700 transition">
            Log In
          </button>
        </div>
      </form>
      <p class="mt-6 text-center text-gray-600">
        Don't have an account? 
        <a href="{{ route('register') }}" class="text-indigo-600 font-bold hover:underline">Sign Up</a>
      </p>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-gray-900 text-gray-300 py-4">
    <div class="container mx-auto text-center">
      <p>&copy; 2024 LombaKuy. All Rights Reserved.</p>
    </div>
  </footer>

</body>
</html>
