<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reset Password - LombaKuy</title>
  <meta name="description" content="Create a new password for your LombaKuy account." />
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
        <a href="{{ route('login') }}" class="text-white hover:text-indigo-200 transition">Login</a>
      </div>
    </div>
  </header>

  <!-- Reset Password Section -->
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
      <!-- Left Column: Security Information -->
      <div data-aos="fade-right" data-aos-duration="1000" class="w-full md:w-1/2 text-white mb-10 md:mb-0 md:pr-10">
        <div class="max-w-md mx-auto md:ml-auto md:mr-0">
          <h1 class="text-4xl md:text-5xl font-extrabold mb-6">Create New Password</h1>
          <p class="text-lg mb-8">
            Almost done! Create a strong and secure password to protect your LombaKuy account and continue your competitive journey.
          </p>
          
          <div class="bg-white bg-opacity-20 backdrop-blur-lg p-6 rounded-xl mb-8">
            <h3 class="text-lg font-bold mb-4">Password Requirements</h3>
            <ul class="space-y-3 text-sm">
              <li class="flex items-start">
                <svg class="w-5 h-5 text-indigo-200 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>At least 8 characters long</span>
              </li>
              <li class="flex items-start">
                <svg class="w-5 h-5 text-indigo-200 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Mix of uppercase and lowercase letters</span>
              </li>
              <li class="flex items-start">
                <svg class="w-5 h-5 text-indigo-200 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Include numbers and special characters</span>
              </li>
              <li class="flex items-start">
                <svg class="w-5 h-5 text-indigo-200 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Avoid common words or patterns</span>
              </li>
            </ul>
          </div>

          <div class="bg-white bg-opacity-15 backdrop-blur-lg p-4 rounded-xl border border-white border-opacity-20">
            <div class="flex items-center">
              <div class="bg-yellow-400 rounded-full p-2 mr-3">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
              </div>
              <div>
                <p class="text-sm font-medium">Security Tip</p>
                <p class="text-xs opacity-90">Use a unique password that you don't use elsewhere</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Right Column: Reset Password Form -->
      <div data-aos="fade-left" data-aos-duration="1000" class="w-full md:w-1/2 max-w-md mx-auto">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
          <div class="bg-indigo-600 h-2"></div>
          <div class="p-8">
            <div class="text-center mb-8">
              <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
              </div>
              <h2 class="text-3xl font-bold text-gray-800">Reset Password</h2>
              <p class="text-gray-600 mt-2">Enter your new password below</p>
            </div>
            
            @if ($errors->any())
              <div class="mb-6 p-4 bg-red-50 rounded-lg border border-red-200">
                <div class="flex items-center">
                  <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                  </svg>
                  <span class="text-red-600 text-sm font-medium">{{ $errors->first() }}</span>
                </div>
              </div>
            @endif
            
            <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
              @csrf
              
              <div>
                <label class="block text-gray-700 font-medium mb-2" for="password">New Password</label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                  </div>

                  <!-- Eye toggle button -->
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" onclick="togglePassword('password')">
                    <i id="eyeIcon1" class="fas fa-eye text-gray-400"></i>
                  </div>

                  <input type="password" id="password" name="password" required autocomplete="new-password" 
                        class="pl-10 pr-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                        placeholder="Enter new password">
                </div>
              </div>

              <div>
                <label class="block text-gray-700 font-medium mb-2" for="password_confirmation">Confirm Password</label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                  </div>

                  <!-- Eye toggle button -->
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" onclick="togglePassword('password_confirmation')">
                    <i id="eyeIcon2" class="fas fa-eye text-gray-400"></i>
                  </div>

                  <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" 
                        class="pl-10 pr-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                        placeholder="Confirm new password">
                </div>
                <p class="text-xs text-gray-500 mt-1">Re-enter your password to confirm</p>
              </div>
              
              <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-indigo-700 transition transform hover:scale-105 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>Save New Password</span>
              </button>
            </form>
            
            <div class="mt-8 pt-6 border-t border-gray-200">
              <div class="text-center">
                <p class="text-gray-600 text-sm mb-4">Remember your password now?</p>
                <a href="{{ route('login') }}" class="inline-flex items-center text-indigo-600 font-bold hover:text-indigo-800 transition">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                  </svg>
                  Back to Login
                </a>
              </div>
            </div>
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

    function togglePassword(fieldId) {
      const passwordInput = document.getElementById(fieldId);
      const eyeIcon = fieldId === 'password' ? document.getElementById('eyeIcon1') : document.getElementById('eyeIcon2');

      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
      }
    }
  </script>
</body>
</html>