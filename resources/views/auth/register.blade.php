<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register - LombaKuy</title>
  <meta name="description" content="Register page for LombaKuy, the ultimate platform to manage and participate in competitions." />
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

  <!-- Header -->
  <header class="bg-indigo-600 sticky top-0 z-50">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
      <a href="/" class="text-3xl font-extrabold text-white">LombaKuy</a>
    </div>
  </header>

  <!-- Register Form Section -->
  <main class="flex items-center justify-center min-h-screen bg-gradient-to-b from-indigo-600 to-white">
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
      <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Sign Up</h2>
      @if ($errors->any())
        <div class="mb-4">
          <ul>
            @foreach ($errors->all() as $error)
              <li class="text-red-500 text-sm">{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-4">
          <label class="block text-gray-700 mb-2" for="name">Name</label>
          <input type="text" id="name" name="name" value="{{ old('name') }}" required 
                 class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 mb-2" for="email">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                 class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 mb-2" for="role">Role</label>
          <select id="role" name="role" required 
                  class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
            <option value="organizer" {{ old('role') == 'organizer' ? 'selected' : '' }}>Organizer</option>
          </select>
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 mb-2" for="password">Password</label>
          <input type="password" id="password" name="password" required 
                 class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div class="mb-6">
          <label class="block text-gray-700 mb-2" for="password_confirmation">Confirm Password</label>
          <input type="password" id="password_confirmation" name="password_confirmation" required 
                 class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div class="flex items-center justify-between">
          <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700 transition">
            Sign Up
          </button>
        </div>
      </form>
      <p class="mt-6 text-center text-gray-600">
        Already have an account? 
        <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:underline">Log In</a>
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
