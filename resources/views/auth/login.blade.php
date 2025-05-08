<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - LombaKuy</title>
  <meta name="description" content="Login page for LombaKuy, your ultimate platform to manage and participate in competitions." />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

  <!-- Header -->
  <header class="bg-indigo-600 sticky top-0 z-50 shadow-md">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
      <a href="/" class="text-3xl font-extrabold text-white flex items-center">
        <span class="mr-2">
            <i class="fas fa-trophy"></i>
          </span>
          LombaKuy
      </a>
      <div class="hidden md:flex space-x-4">
        <a href="/" class="text-white hover:text-indigo-200 transition">Home</a>
      </div>
    </div>
  </header>

  <!-- Login Section -->
  <section class="relative min-h-screen bg-gradient-to-b from-indigo-600 to-indigo-200 py-16">
    <!-- Background pattern -->
    <div class="absolute inset-0 opacity-10">
      <svg width="100%" height="100%" viewBox="0 0 800 800">
        <defs>
          <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
            <path d="M 0 10 L 40 10 M 10 0 L 10 40" stroke="white" stroke-width="1" fill="none" />
          </pattern>
        </defs>
        <rect width="100%" height="100%" fill="url(#grid)" />
      </svg>
    </div>
    
    <div class="container mx-auto px-6 flex flex-col md:flex-row items-center justify-center relative z-10">
      <!-- Left Column: Welcome Content -->
      <div data-aos="fade-right" data-aos-duration="1000" class="w-full md:w-1/2 text-white mb-10 md:mb-0 md:pr-10">
        <div class="max-w-md mx-auto md:ml-auto md:mr-0">
          <h1 class="text-4xl md:text-5xl font-extrabold mb-6">Welcome Back!</h1>
          <p class="text-lg mb-8">
            Log in and start exploring competitions, forming the best teams, and achieving success with LombaKuy.
          </p>
          
          <div class="bg-white bg-opacity-20 backdrop-blur-lg p-6 rounded-xl mb-8">
            <h3 class="text-lg font-bold mb-4">Main Features</h3>
            <ul class="space-y-3 text-sm">
              <li class="flex items-start">
                <svg class="w-5 h-5 text-indigo-200 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Discover the latest competitions</span>
              </li>
              <li class="flex items-start">
                <svg class="w-5 h-5 text-indigo-200 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Team collaboration based on recommendations</span>
              </li>
              <li class="flex items-start">
                <svg class="w-5 h-5 text-indigo-200 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Manage tasks & track competition progress</span>
              </li>
            </ul>
          </div>

          <div class="flex items-center">
            <div class="flex -space-x-2">
              <img src="{{ asset('storage/images/vilson.jpg') }}" alt="User" class="w-10 h-10 rounded-full border-2 border-white">
              <img src="{{ asset('storage/images/testi1.jpg') }}" alt="User" class="w-10 h-10 rounded-full border-2 border-white">
              <img src="{{ asset('storage/images/testi2.jpg') }}" alt="User" class="w-10 h-10 rounded-full border-2 border-white">
            </div>
            <p class="ml-4 text-sm">Trusted by over 1000+ students in Indonesia</p>
          </div>
        </div>
      </div>
      
      <!-- Right Column: Login Form -->
      <div data-aos="fade-left" data-aos-duration="1000" class="w-full md:w-1/2 max-w-md mx-auto">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
          <div class="bg-indigo-600 h-2"></div>
          <div class="p-8">
            <div class="text-center mb-8">
              <h2 class="text-3xl font-bold text-gray-800">Log In</h2>
              <p class="text-gray-600 mt-2">Access your LombaKuy account</p>
            </div>
            
            @if ($errors->any())
              <div class="mb-6 p-4 bg-red-50 rounded-lg border border-red-200">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li class="text-red-500 text-sm flex items-center">
                      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                      </svg>
                      {{ $error }}
                    </li>
                  @endforeach
                </ul>
              </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
              @csrf
              <div>
                <label class="block text-gray-700 font-medium mb-2" for="email">Email</label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                  </div>
                  <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus 
                         class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                         placeholder="your@email.com">
                </div>
              </div>
              
              <div>
                <div class="flex items-center justify-between mb-2">
                  <label class="block text-gray-700 font-medium" for="password">Password</label>
                  <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800">Forgot Password?</a>
                </div>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                  </div>
                  <input type="password" id="password" name="password" required autocomplete="current-password" 
                         class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                         placeholder="••••••••">
                </div>
              </div>
              
              <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-indigo-700 transition transform hover:scale-105 flex items-center justify-center">
                <span>Log In</span>
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
              </button>
            </form>
            
            <p class="mt-8 text-center text-gray-600">
              Don't have an account? 
              <a href="{{ route('register') }}" class="text-indigo-600 font-bold hover:underline">Sign Up</a>
            </p>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Wave separator -->
    <div class="absolute bottom-0 left-0 right-0">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#ffffff" fill-opacity="1" d="M0,224L60,213.3C120,203,240,181,360,186.7C480,192,600,224,720,240C840,256,960,256,1080,229.3C1200,203,1320,149,1380,122.7L1440,96L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
      </svg>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-gray-300 py-8">
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
          <a href="https://www.facebook.com/?locale=id_ID" class="text-gray-400 hover:text-white transition">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="https://twitter.com/" class="text-gray-400 hover:text-white transition">
            <i class="fab fa-twitter"></i>
          </a>
          <a href="https://www.instagram.com/" class="text-gray-400 hover:text-white transition">
            <i class="fab fa-instagram"></i>
          </a>
          <a href="https://www.linkedin.com/" class="text-gray-400 hover:text-white transition">
            <i class="fab fa-linkedin-in"></i>
          </a>
        </div>
      </div>
      <div class="border-t border-gray-800 mt-6 pt-6 text-center text-sm">
        <p>© 2025 LombaKuy. All Rights Reserved.</p>
      </div>
    </div>
  </footer>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
      });
    });
  </script>
</body>
</html>