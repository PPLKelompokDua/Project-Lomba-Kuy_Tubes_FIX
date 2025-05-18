<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LombaKuy – Empower Your Competitive Spirit</title>
  <meta name="description" content="LombaKuy | The ultimate platform for discovering competitions, forming winning teams, and tracking your progress." />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
      <nav class="hidden md:flex space-x-8 text-white font-medium">
        <a href="#features" class="hover:text-indigo-200 transition">Features</a>
        <a href="#how-it-works" class="hover:text-indigo-200 transition">How It Works</a>
        <a href="#testimonials" class="hover:text-indigo-200 transition">Testimonials</a>
        <a href="#faq" class="hover:text-indigo-200 transition">FAQ</a>
        <a href="#aboutus" class="hover:text-indigo-200 transition">About Us</a>
        <a href="#contact" class="hover:text-indigo-200 transition">Contact Us</a>
      </nav>
      <div class="hidden md:flex space-x-4">
        <a href="/login">
          <button class="bg-white text-indigo-600 font-bold py-2 px-5 rounded-lg hover:bg-indigo-200 transition transform hover:scale-105">
            Log In
          </button>
        </a>
        <a href="/register">
          <button class="bg-white text-indigo-600 font-bold py-2 px-5 rounded-lg hover:bg-indigo-200 transition transform hover:scale-105">
            Sign Up
          </button>
        </a>
      </div>
      <button class="md:hidden text-white focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
      </button>
    </div>
    <!-- Mobile menu (hidden by default) -->
    <div class="md:hidden hidden bg-indigo-700 pb-4 px-6 text-white">
      <a href="#features" class="block py-2 hover:bg-indigo-800 px-3 rounded">Features</a>
      <a href="#how-it-works" class="block py-2 hover:bg-indigo-800 px-3 rounded">How It Works</a>
      <a href="#testimonials" class="block py-2 hover:bg-indigo-800 px-3 rounded">Testimonials</a>
      <a href="#faq" class="block py-2 hover:bg-indigo-800 px-3 rounded">FAQ</a>
      <a href="#aboutus" class="block py-2 hover:bg-indigo-800 px-3 rounded">About Us</a>
      <a href="#contact" class="block py-2 hover:bg-indigo-800 px-3 rounded">Contact Us</a>
      <div class="flex space-x-3 mt-4">
        <a href="/login" class="block w-1/2">
          <button class="w-full bg-white text-indigo-600 font-bold py-2 px-4 rounded-lg">
            Log In
          </button>
        </a>
        <a href="/register" class="block w-1/2">
          <button class="w-full bg-white text-indigo-600 font-bold py-2 px-4 rounded-lg">
            Sign Up
          </button>
        </a>
      </div>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="relative bg-gradient-to-b from-indigo-600 to-indigo-400 text-white py-20 overflow-hidden">
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
    
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 items-center gap-12 px-6 relative z-10">
      <div data-aos="fade-right" data-aos-duration="1000">
        <div class="bg-white bg-opacity-20 backdrop-blur-lg p-10 rounded-xl shadow-xl">
          <h1 class="text-5xl md:text-6xl font-extrabold leading-tight text-white">
            Organize, Compete, <span class="text-indigo-200">Succeed</span>
          </h1>
          <p class="mt-6 text-lg font-light text-white">
            Discover competitions, form the best teams, and track your progress in real-time with LombaKuy. The most comprehensive competition platform for Telkom University students.
          </p>
          <div class="mt-8 flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
            <a href="/register">
              <button class="w-full sm:w-auto bg-white text-indigo-600 font-bold py-3 px-8 rounded-lg hover:bg-indigo-200 transition shadow-lg transform hover:scale-105 flex items-center justify-center">
                <span>Get Started</span>
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
              </button>
            </a>
            <a href="#features">
              <button class="w-full sm:w-auto border-2 border-white text-white font-bold py-3 px-8 rounded-lg hover:bg-white hover:text-indigo-600 transition shadow-lg flex items-center justify-center">
                <span>Explore Features</span>
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
              </button>
            </a>
          </div>
        </div>
      </div>
      <div data-aos="fade-left" data-aos-duration="1000" class="relative">
        <div class="absolute -top-10 -right-10 w-20 h-20 bg-indigo-300 rounded-full opacity-50"></div>
        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-indigo-300 rounded-full opacity-50"></div>
        <img src="{{ asset('storage/images/competition-illustration.png') }}" alt="Competition Dashboard" class="w-full h-auto mx-auto rounded-xl shadow-2xl border-4 border-white border-opacity-30">
      </div>
    </div>
    
    <!-- Wave separator -->
    <div class="absolute bottom-0 left-0 right-0">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#ffffff" fill-opacity="1" d="M0,224L60,213.3C120,203,240,181,360,186.7C480,192,600,224,720,240C840,256,960,256,1080,229.3C1200,203,1320,149,1380,122.7L1440,96L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
      </svg>
    </div>
  </section>

  <!-- Feature highlights -->
  <section class="py-20 bg-white">
    <div class="container mx-auto px-6">
      <div class="text-center max-w-3xl mx-auto mb-16">
        <span class="inline-block py-1 px-3 rounded-full bg-indigo-100 text-indigo-600 font-semibold text-sm mb-4">WHY CHOOSE US</span>
        <h2 class="text-4xl font-bold text-gray-800 mb-4">Why Students Choose LombaKuy</h2>
        <p class="text-gray-600">A complete platform that simplifies the competition journey for students from start to finish.</p>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Card 1 -->
        <div data-aos="zoom-in" data-aos-delay="100" class="bg-white rounded-xl border border-gray-200 shadow-lg overflow-hidden transform transition hover:-translate-y-2">
          <div class="bg-indigo-600 h-2"></div>
          <div class="p-8">
            <div class="text-indigo-600 mb-4">
              <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
              </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-4">All-in-One Competition Platform</h3>
            <p class="text-gray-600">Discover, register, and manage various competitions in one integrated platform. No need to search for information in multiple places.</p>
          </div>
        </div>

        <!-- Card 2 -->
        <div data-aos="zoom-in" data-aos-delay="200" class="bg-white rounded-xl border border-gray-200 shadow-lg overflow-hidden transform transition hover:-translate-y-2">
          <div class="bg-indigo-600 h-2"></div>
          <div class="p-8">
            <div class="text-indigo-600 mb-4">
              <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
              </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-4">Smart Team Formation</h3>
            <p class="text-gray-600">Find suitable teammates through psychological tests and a recommendation system based on skills and interests.</p>
          </div>
        </div>

        <!-- Card 3 -->
        <div data-aos="zoom-in" data-aos-delay="300" class="bg-white rounded-xl border border-gray-200 shadow-lg overflow-hidden transform transition hover:-translate-y-2">
          <div class="bg-indigo-600 h-2"></div>
          <div class="p-8">
            <div class="text-indigo-600 mb-4">
              <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-4">Real-time Progress Tracking</h3>
            <p class="text-gray-600">Monitor team progress and analyze performance with clear and intuitive data visualizations for better results.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section id="features" class="bg-gray-50 py-24">
    <div class="container mx-auto px-6">
      <div class="text-center max-w-3xl mx-auto mb-16">
        <span class="inline-block py-1 px-3 rounded-full bg-indigo-100 text-indigo-600 font-semibold text-sm mb-4">FEATURES</span>
        <h2 class="text-4xl font-bold text-gray-800 mb-4">LombaKuy’s Comprehensive Features</h2>
        <p class="text-gray-600">Designed specifically to help Telkom University students maximize their potential in competitions.</p>
      </div>
      
      <!-- Feature Grid: 6 items, 2 rows x 3 columns on md resolution and above -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- 1. Competition Search & Registration -->
        <div data-aos="fade-up" data-aos-delay="100" class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition group">
          <div class="flex items-center justify-center w-16 h-16 bg-indigo-100 rounded-full group-hover:bg-indigo-200 transition mb-6">
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2"
              viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="11" cy="11" r="8" />
              <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-800 mb-4">
            Competition Exploration & Registration
          </h3>
          <p class="text-gray-600 mb-6">
            Search and filter competitions by category, deadline, and difficulty level. Get detailed information and register easily through official links.
          </p>
          <ul class="text-gray-600 space-y-2">
            <li class="flex items-start">
              <svg class="w-5 h-5 text-indigo-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>Filter by category</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 text-indigo-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>Detailed competition information</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 text-indigo-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>Official registration links</span>
            </li>
          </ul>
        </div>

        <!-- 2. Team Matching & Assessment -->
        <div data-aos="fade-up" data-aos-delay="200" class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition group">
          <div class="flex items-center justify-center w-16 h-16 bg-indigo-100 rounded-full group-hover:bg-indigo-200 transition mb-6">
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2"
              viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17 21v-2a4 4 0 00-3-3.87" />
              <path d="M7 21v-2a4 4 0 013-3.87" />
              <circle cx="12" cy="7" r="4" />
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-800 mb-4">
            Team Compatibility Test & Formation
          </h3>
          <p class="text-gray-600 mb-6">
            Find potential teammates through psychological tests and a data-driven recommendation system to form complementary teams.
          </p>
          <ul class="text-gray-600 space-y-2">
            <li class="flex items-start">
              <svg class="w-5 h-5 text-indigo-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>Psychological tests and assessments</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 text-indigo-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>Teammate search system</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 text-indigo-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>Team invitation management</span>
            </li>
          </ul>
        </div>

        <!-- 3. Task & Timeline Management -->
        <div data-aos="fade-up" data-aos-delay="300" class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition group">
          <div class="flex items-center justify-center w-16 h-16 bg-indigo-100 rounded-full group-hover:bg-indigo-200 transition mb-6">
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2"
              viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
              <line x1="16" y1="2" x2="16" y2="6" />
              <line x1="8" y1="2" x2="8" y2="6" />
              <line x1="3" y1="10" x2="21" y2="10" />
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-800 mb-4">
            Milestones & Task Management
          </h3>
          <p class="text-gray-600 mb-6">
            Monitor tasks, milestones, and competition deadlines in a structured visual timeline with automatic reminders.
          </p>
          <ul class="text-gray-600 space-y-2">
            <li class="flex items-start">
              <svg class="w-5 h-5 text-indigo-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>Interactive visual timeline</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 text-indigo-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>Integrated task management</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 text-indigo-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>Automatic deadline reminders</span>
            </li>
          </ul>
        </div>

        <!-- 4. Performance Analytics -->
        <div data-aos="fade-up" data-aos-delay="100" class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition group">
          <div class="flex items-center justify-center w-16 h-16 bg-indigo-100 rounded-full group-hover:bg-indigo-200 transition mb-6">
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2"
              viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
              <line x1="3" y1="12" x2="7" y2="12" />
              <line x1="3" y1="6" x2="7" y2="6" />
              <line x1="3" y1="18" x2="7" y2="18" />
              <line x1="11" y1="18" x2="11" y2="9" />
              <line x1="15" y1="18" x2="15" y2="4" />
              <line x1="19" y1="18" x2="19" y2="14" />
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-800 mb-4">
            Performance & Productivity Analytics
          </h3>
          <p class="text-gray-600 mb-6">
            View team performance data and graphs to identify areas for improvement and success through easy-to-understand visualizations.
          </p>
          <ul class="text-gray-600 space-y-2">
            <li class="flex items-start">
              <svg class="w-5 h-5 text-indigo-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>Team productivity dashboard</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 text-indigo-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>Competition progress graphs</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 text-indigo-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>Member activity reports</span>
            </li>
          </ul>
        </div>

        <!-- 5. Community Stories & Feedback -->
        <div data-aos="fade-up" data-aos-delay="200" class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition group">
          <div class="flex items-center justify-center w-16 h-16 bg-indigo-100 rounded-full group-hover:bg-indigo-200 transition mb-6">
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2"
              viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h11l5 5z" />
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-800 mb-4">
            Story Space & Feedback System
          </h3>
          <p class="text-gray-600 mb-6">
            Share your competition experiences, provide feedback on teams and organizers for continuous evaluation.
          </p>
          <ul class="text-gray-600 space-y-2">
            <li class="flex items-start">
              <svg class="w-5 h-5 text-indigo-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>Winning Post sharing</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 text-indigo-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>Evaluation system for teams, competitions, and LombaKuy features</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 text-indigo-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>Sharing competition experiences</span>
            </li>
          </ul>
        </div>

        <!-- 6. Educational Resources -->
        <div data-aos="fade-up" data-aos-delay="300" class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition group">
          <div class="flex items-center justify-center w-16 h-16 bg-indigo-100 rounded-full group-hover:bg-indigo-200 transition mb-6">
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2"
              viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
              <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
              <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-800 mb-4">
            Educational Resources & Competition Guides
          </h3>
          <p class="text-gray-600 mb-6">
            Access video tutorials, guide articles, and competition strategies to increase your team’s chances of success.
          </p>
          <ul class="text-gray-600 space-y-2">
            <li class="flex items-start">
              <svg class="w-5 h-5 text-indigo-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>Video tips & competition strategies</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 text-indigo-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>Competition guide articles</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 text-indigo-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>Personal development resources</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- How It Works Section -->
  <section id="how-it-works" class="bg-white py-24">
    <div class="container mx-auto px-6">
      <div class="text-center max-w-3xl mx-auto mb-16">
        <span class="inline-block py-1 px-3 rounded-full bg-indigo-100 text-indigo-600 font-semibold text-sm mb-4">PROCESS</span>
        <h2 class="text-4xl font-bold text-gray-800 mb-4">How LombaKuy Works</h2>
        <p class="text-gray-600">Four simple steps to maximize your competition experience</p>
      </div>
      
      <!-- Timeline Steps -->
      <div class="relative">
        <!-- Progress Line -->
        <div class="hidden md:block absolute left-1/2 transform -translate-x-1/2 h-full w-1 bg-indigo-100"></div>
        
        <!-- Step 1 -->
        <div data-aos="fade-right" class="relative flex flex-col md:flex-row items-center mb-16">
          <div class="flex-1 w-full md:w-1/2 md:pr-16 mb-8 md:mb-0 md:text-right">
            <span class="text-indigo-600 font-bold text-lg mb-2 block">STEP 1</span>
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Find Your Ideal Competition</h3>
            <p class="text-gray-600 max-w-md ml-auto">
              Search for competitions that match your interests and skills. Filter by category, level, deadline, and prizes to find the best opportunities.
            </p>
          </div>
          <div class="mx-auto md:mx-0 z-10 flex items-center justify-center w-16 h-16 bg-indigo-500 rounded-full text-white text-2xl font-bold">1</div>
          <div class="flex-1 w-full md:w-1/2 md:pl-16 hidden md:block">
            <img src="/api/placeholder/400/240" alt="Find Competition" class="rounded-lg shadow-lg mx-auto md:ml-0 w-full max-w-sm">
          </div>
        </div>
        
        <!-- Step 2 -->
        <div data-aos="fade-left" class="relative flex flex-col md:flex-row-reverse items-center mb-16">
          <div class="flex-1 w-full md:w-1/2 md:pl-16 mb-8 md:mb-0 md:text-left">
            <span class="text-indigo-600 font-bold text-lg mb-2 block">STEP 2</span>
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Build a Quality Team</h3>
            <p class="text-gray-600 max-w-md">
              Take the team compatibility test and find partners who complement your skillset. Utilize the invitation system to recruit the best members for the competition.
            </p>
          </div>
          <div class="mx-auto md:mx-0 z-10 flex items-center justify-center w-16 h-16 bg-indigo-500 rounded-full text-white text-2xl font-bold">2</div>
          <div class="flex-1 w-full md:w-1/2 md:pr-16 hidden md:block">
            <img src="/api/placeholder/400/240" alt="Build Team" class="rounded-lg shadow-lg mx-auto md:mr-0 w-full max-w-sm">
          </div>
        </div>
        
        <!-- Step 3 -->
        <div data-aos="fade-right" class="relative flex flex-col md:flex-row items-center mb-16">
          <div class="flex-1 w-full md:w-1/2 md:pr-16 mb-8 md:mb-0 md:text-right">
            <span class="text-indigo-600 font-bold text-lg mb-2 block">STEP 3</span>
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Manage Progress & Tasks</h3>
            <p class="text-gray-600 max-w-md ml-auto">
              Set milestones, assign tasks, and monitor team progress through an interactive dashboard. Use analytics to maximize productivity.
            </p>
          </div>
          <div class="mx-auto md:mx-0 z-10 flex items-center justify-center w-16 h-16 bg-indigo-500 rounded-full text-white text-2xl font-bold">3</div>
          <div class="flex-1 w-full md:w-1/2 md:pl-16 hidden md:block">
            <img src="/api/placeholder/400/240" alt="Track Progress" class="rounded-lg shadow-lg mx-auto md:ml-0 w-full max-w-sm">
          </div>
        </div>
        
        <!-- Step 4 -->
        <div data-aos="fade-left" class="relative flex flex-col md:flex-row-reverse items-center">
          <div class="flex-1 w-full md:w-1/2 md:pl-16 mb-8 md:mb-0 md:text-left">
            <span class="text-indigo-600 font-bold text-lg mb-2 block">STEP 4</span>
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Evaluate & Grow</h3>
            <p class="text-gray-600 max-w-md">
              Receive feedback, share achievements on Winning Post, and continuously improve performance with available educational resources.
            </p>
          </div>
          <div class="mx-auto md:mx-0 z-10 flex items-center justify-center w-16 h-16 bg-indigo-500 rounded-full text-white text-2xl font-bold">4</div>
          <div class="flex-1 w-full md:w-1/2 md:pr-16 hidden md:block">
            <img src="/api/placeholder/400/240" alt="Evaluate and Share" class="rounded-lg shadow-lg mx-auto md:mr-0 w-full max-w-sm">
          </div>
        </div>
      </div>
      
      <!-- CTA Button -->
      <div class="mt-16 text-center">
        <a href="/register" data-aos="zoom-in">
          <button dusk="footer-get-started-button" class="bg-indigo-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-indigo-700 transition shadow-lg transform hover:scale-105">
            Start Your Competition Journey
            <svg class="w-5 h-5 ml-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
            </svg>
          </button>
        </a>
      </div>
    </div>
  </section>

  <!-- Testimonials Section -->
  <section id="testimonials" class="bg-gray-50 py-24">
    <div class="container mx-auto px-6">
      <div class="text-center max-w-3xl mx-auto mb-16">
        <span class="inline-block py-1 px-3 rounded-full bg-indigo-100 text-indigo-600 font-semibold text-sm mb-4">TESTIMONIALS</span>
        <h2 class="text-4xl font-bold text-gray-800 mb-4">What Students Say</h2>
        <p class="text-gray-600">Experiences of Telkom University students who have used LombaKuy to succeed in competitions</p>
      </div>
      
      <!-- Testimonials Grid -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Testimonial 1 -->
        <div data-aos="fade-up" data-aos-delay="100" class="bg-white rounded-xl shadow-lg p-8 relative">
          <div class="absolute -top-5 left-8">
            <div class="bg-indigo-600 text-white p-3 rounded-full">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
              </svg>
            </div>
          </div>
          <div class="pt-6">
            <p class="text-gray-600 italic mb-6">
              "LombaKuy greatly helped our team organize preparations for the UI/UX Design competition. Thanks to this platform, we won 2nd place at the national level!"
            </p>
            <div class="flex items-center">
              <img src="{{ asset('storage/images/testi1.jpg') }}" alt="User Avatar" class="w-12 h-12 rounded-full mr-4 object-cover">
              <div>
                <h4 class="font-bold text-gray-900">Anita Wijaya</h4>
                <p class="text-sm text-gray-600">Visual Communication Design Student</p>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Testimonial 2 -->
        <div data-aos="fade-up" data-aos-delay="200" class="bg-white rounded-xl shadow-lg p-8 relative">
          <div class="absolute -top-5 left-8">
            <div class="bg-indigo-600 text-white p-3 rounded-full">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
              </svg>
            </div>
          </div>
          <div class="pt-6">
            <p class="text-gray-600 italic mb-6">
              "The team compatibility test helped me find the right partner for the programming competition. Performance analytics were also very useful for team evaluation."
            </p>
            <div class="flex items-center">
              <img src="{{ asset('storage/images/testi2.jpg') }}" alt="User Avatar" class="w-12 h-12 rounded-full mr-4 object-cover">
              <div>
                <h4 class="font-bold text-gray-900">Diana Putri</h4>
                <p class="text-sm text-gray-600">Informatics Engineering Student</p>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Testimonial 3 -->
        <div data-aos="fade-up" data-aos-delay="300" class="bg-white rounded-xl shadow-lg p-8 relative">
          <div class="absolute -top-5 left-8">
            <div class="bg-indigo-600 text-white p-3 rounded-full">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
              </svg>
            </div>
          </div>
          <div class="pt-6">
            <p class="text-gray-600 italic mb-6">
              "The timeline and progress tracker made team coordination more effective. The tips & strategies videos were also very helpful for our preparation!"
            </p>
            <div class="flex items-center">
              <img src="{{ asset('storage/images/testi3.jpg') }}" alt="User Avatar" class="w-12 h-12 rounded-full mr-4 object-cover">
              <div>
                <h4 class="font-bold text-gray-900">Budi Tan</h4>
                <p class="text-sm text-gray-600">Business Management Student</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Statistics Section -->
  <section class="bg-indigo-600 py-16 text-white">
    <div class="container mx-auto px-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
        <!-- Stat 1 -->
        <div data-aos="fade-up" data-aos-delay="100">
          <div class="text-4xl font-bold mb-2">500+</div>
          <div class="text-indigo-200 font-medium">Registered Competitions</div>
        </div>
        
        <!-- Stat 2 -->
        <div data-aos="fade-up" data-aos-delay="200">
          <div class="text-4xl font-bold mb-2">2,500+</div>
          <div class="text-indigo-200 font-medium">Student Users</div>
        </div>
        
        <!-- Stat 3 -->
        <div data-aos="fade-up" data-aos-delay="300">
          <div class="text-4xl font-bold mb-2">350+</div>
          <div class="text-indigo-200 font-medium">Teams Formed</div>
        </div>
        
        <!-- Stat 4 -->
        <div data-aos="fade-up" data-aos-delay="400">
          <div class="text-4xl font-bold mb-2">75+</div>
          <div class="text-indigo-200 font-medium">Achievements Earned</div>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <section id="faq" class="bg-white py-24">
    <div class="container mx-auto px-6">
      <div class="text-center max-w-3xl mx-auto mb-16">
        <span class="inline-block py-1 px-3 rounded-full bg-indigo-100 text-indigo-600 font-semibold text-sm mb-4">FAQ</span>
        <h2 class="text-4xl font-bold text-gray-800 mb-4">Frequently Asked Questions</h2>
        <p class="text-gray-600">Find answers to common questions about LombaKuy</p>
      </div>

      <div class="max-w-3xl mx-auto space-y-6">
        <!-- FAQ Item 1 -->
        <div x-data="{ open: false }" class="border-b border-gray-200 pb-4">
          <button @click="open = !open" class="flex justify-between items-center w-full text-left focus:outline-none">
            <span class="text-xl font-bold text-gray-800">Is LombaKuy free to use?</span>
            <svg :class="{'rotate-180': open}" class="w-6 h-6 text-indigo-600 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div x-show="open" x-collapse x-transition.duration.300ms class="mt-3 text-gray-600">
            Yes, LombaKuy is free to use for all Telkom University students. All core features are available at no cost to support student competition activities.
          </div>
        </div>

        <!-- FAQ Item 2 -->
        <div x-data="{ open: false }" class="border-b border-gray-200 pb-4">
          <button @click="open = !open" class="flex justify-between items-center w-full text-left focus:outline-none">
            <span class="text-xl font-bold text-gray-800">How does the team compatibility test work?</span>
            <svg :class="{'rotate-180': open}" class="w-6 h-6 text-indigo-600 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div x-show="open" x-collapse x-transition.duration.300ms class="mt-3 text-gray-600">
            The team compatibility test uses psychological algorithms to analyze personality, technical skills, and work preferences to recommend complementary team member combinations.
          </div>
        </div>

        <!-- FAQ Item 3 -->
        <div x-data="{ open: false }" class="border-b border-gray-200 pb-4">
          <button @click="open = !open" class="flex justify-between items-center w-full text-left focus:outline-none">
            <span class="text-xl font-bold text-gray-800">Who can upload competition information?</span>
            <svg :class="{'rotate-180': open}" class="w-6 h-6 text-indigo-600 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div x-show="open" x-collapse x-transition.duration.300ms class="mt-3 text-gray-600">
            Competition information can be uploaded by competition organizers and LombaKuy admins. Students can also propose unlisted competitions for admin verification.
          </div>
        </div>

        <!-- FAQ Item 4 -->
        <div x-data="{ open: false }" class="border-b border-gray-200 pb-4">
          <button @click="open = !open" class="flex justify-between items-center w-full text-left focus:outline-none">
            <span class="text-xl font-bold text-gray-800">Can I use LombaKuy for off-campus competitions?</span>
            <svg :class="{'rotate-180': open}" class="w-6 h-6 text-indigo-600 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div x-show="open" x-collapse x-transition.duration.300ms class="mt-3 text-gray-600">
            Absolutely! LombaKuy supports various types of competitions, including campus, regional, national, and international levels.
          </div>
        </div>

        <!-- FAQ Item 5 -->
        <div x-data="{ open: false }" class="border-b border-gray-200 pb-4">
          <button @click="open = !open" class="flex justify-between items-center w-full text-left focus:outline-none">
            <span class="text-xl font-bold text-gray-800">How secure is my data on LombaKuy?</span>
            <svg :class="{'rotate-180': open}" class="w-6 h-6 text-indigo-600 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div x-show="open" x-collapse x-transition.duration.300ms class="mt-3 text-gray-600">
            We implement high security standards to protect user data. Personal data and test results are used solely for platform purposes and will not be shared with third parties without consent.
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- About Us Section -->
  <section id="aboutus" class="bg-gray-50 py-24">
    <div class="container mx-auto px-6">
      <div class="text-center max-w-3xl mx-auto mb-16">
        <span class="inline-block py-1 px-3 rounded-full bg-indigo-100 text-indigo-600 font-semibold text-sm mb-4">ABOUT US</span>
        <h2 class="text-4xl font-bold text-gray-800 mb-4">Behind LombaKuy</h2>
        <p class="text-gray-600">A platform developed by students for students</p>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
        <div data-aos="fade-right">
          <img src="/api/placeholder/550/400" alt="Team LombaKuy" class="rounded-xl shadow-xl w-full">
        </div>
        
        <div data-aos="fade-left">
          <h3 class="text-2xl font-bold text-gray-800 mb-6">Our Mission</h3>
          <p class="text-gray-600 mb-6">
            LombaKuy was born from the need of Telkom University students for an integrated system to find and manage competitions. We aim to create a structured, collaborative, and supportive competition ecosystem that fosters students’ soft skills development.
          </p>
          <p class="text-gray-600 mb-6">
            The platform is designed with a focus on ease of use, comprehensive features, and support for various types of competitions. We believe that with the right tools, students can maximize their potential and achieve remarkable accomplishments.
          </p>
          <p class="text-gray-600">
            LombaKuy also supports SDG 4 (Quality Education) by providing access to information and educational resources to enhance the quality of students’ learning experiences through competitions.
          </p>
          
          <div class="mt-8 flex space-x-4">
            <a href="https://www.facebook.com/?locale=id_ID" class="bg-indigo-600 text-white p-3 rounded-full hover:bg-indigo-700 transition">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z" />
              </svg>
            </a>
            <a href="https://twitter.com/" class="bg-indigo-600 text-white p-3 rounded-full hover:bg-indigo-700 transition">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63a9.936 9.936 0 002.46-2.548l-.047-.02z" />
              </svg>
            </a>
            <a href="https://www.instagram.com/" class="bg-indigo-600 text-white p-3 rounded-full hover:bg-indigo-700 transition">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
              </svg>
            </a>
            <a href="https://www.linkedin.com/" class="bg-indigo-600 text-white p-3 rounded-full hover:bg-indigo-700 transition">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
              </svg>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Team Section -->
  <section id="team" class="bg-white py-24">
    <div class="container mx-auto px-6">
      <div class="text-center max-w-3xl mx-auto mb-16">
        <span class="inline-block py-1 px-3 rounded-full bg-indigo-100 text-indigo-600 font-semibold text-sm mb-4">OUR TEAM</span>
        <h2 class="text-4xl font-bold text-gray-800 mb-4">LombaKuy Developer Team</h2>
        <p class="text-gray-600">Telkom University students committed to developing an innovative platform</p>
      </div>
      
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
        <!-- Team Member 1 -->
        <div data-aos="fade-up" data-aos-delay="100" class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition transform hover:-translate-y-2">
          <div class="mb-4">
            <img src="{{ asset('storage/images/vilson.jpg') }}" alt="Team Member" class="rounded-full mx-auto w-32 h-32 object-cover border-4 border-indigo-100">
          </div>
          <h4 class="font-bold text-xl text-gray-800 mb-1">Vilson</h4>
          <p class="text-indigo-600 font-medium mb-3">Project Manager | Scrum Master | Fullstack</p>
          <p class="text-gray-600 text-sm mb-4">Information Systems student responsible for coordination, scrum processes, and implementation of key features.</p>
          <div class="flex justify-center space-x-3">
            <a href="https://www.facebook.com/?locale=id_ID" class="text-indigo-500 hover:text-indigo-700">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z" />
              </svg>
            </a>
            <a href="https://www.linkedin.com/" class="text-indigo-500 hover:text-indigo-700">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
              </svg>
            </a>
          </div>
        </div>
        
        <!-- Team Member 2 -->
        <div data-aos="fade-up" data-aos-delay="200" class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition transform hover:-translate-y-2">
          <div class="mb-4">
            <img src="/api/placeholder/150/150" alt="Team Member" class="rounded-full mx-auto w-32 h-32 object-cover border-4 border-indigo-100">
          </div>
          <h4 class="font-bold text-xl text-gray-800 mb-1">Muhammad Avrisad Garin Rahaguna</h4>
          <p class="text-indigo-600 font-medium mb-3">Fullstack</p>
          <p class="text-gray-600 text-sm mb-4">Information Systems student responsible for implementing key features.</p>
          <div class="flex justify-center space-x-3">
            <a href="https://www.facebook.com/?locale=id_ID" class="text-indigo-500 hover:text-indigo-700">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z" />
              </svg>
            </a>
            <a href="https://www.instagram.com/" class="text-indigo-500 hover:text-indigo-700">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
              </svg>
            </a>
          </div>
        </div>
        
        <!-- Team Member 3 -->
        <div data-aos="fade-up" data-aos-delay="300" class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition transform hover:-translate-y-2">
          <div class="mb-4">
            <img src="/api/placeholder/150/150" alt="Team Member" class="rounded-full mx-auto w-32 h-32 object-cover border-4 border-indigo-100">
          </div>
          <h4 class="font-bold text-xl text-gray-800 mb-1">Dhimas Faza Wicaksana</h4>
          <p class="text-indigo-600 font-medium mb-3">Fullstack</p>
          <p class="text-gray-600 text-sm mb-4">Information Systems student responsible for implementing core features.</p>
          <div class="flex justify-center space-x-3">
            <a href="https://github.com/" class="text-indigo-500 hover:text-indigo-700">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
              </svg>
            </a>
            <a href="https://www.linkedin.com/" class="text-indigo-500 hover:text-indigo-700">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
              </svg>
            </a>
          </div>
        </div>
        
        <!-- Team Member 4 -->
        <div data-aos="fade-up" data-aos-delay="400" class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition transform hover:-translate-y-2">
          <div class="mb-4">
            <img src="/api/placeholder/150/150" alt="Team Member" class="rounded-full mx-auto w-32 h-32 object-cover border-4 border-indigo-100">
          </div>
          <h4 class="font-bold text-xl text-gray-800 mb-1">Angelyca Ruth Dhebora Samosir</h4>
          <p class="text-indigo-600 font-medium mb-3">Fullstack</p>
          <p class="text-gray-600 text-sm mb-4">Information Systems student responsible for implementing core features.</p>
          <div class="flex justify-center space-x-3">
            <a href="https://www.linkedin.com/" class="text-indigo-500 hover:text-indigo-700">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
              </svg>
            </a>
            <a href="https://github.com/" class="text-indigo-500 hover:text-indigo-700">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
              </svg>
            </a>
          </div>
        </div>

        <!-- Team Member 5 -->
        <div data-aos="fade-up" data-aos-delay="500" class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition transform hover:-translate-y-2">
          <div class="mb-4">
            <img src="/api/placeholder/150/150" alt="Team Member" class="rounded-full mx-auto w-32 h-32 object-cover border-4 border-indigo-100">
          </div>
          <h4 class="font-bold text-xl text-gray-800 mb-1">Revalina Aurellia Indrawan</h4>
          <p class="text-indigo-600 font-medium mb-3">Fullstack</p>
          <p class="text-gray-600 text-sm mb-4">Information Systems student responsible for implementing core features.</p>
          <div class="flex justify-center space-x-3">
            <a href="https://www.linkedin.com/" class="text-indigo-500 hover:text-indigo-700">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
              </svg>
            </a>
          </div>
        </div>

        <!-- Team Member 6 -->
        <div data-aos="fade-up" data-aos-delay="600" class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition transform hover:-translate-y-2">
          <div class="mb-4">
            <img src="/api/placeholder/150/150" alt="Team Member" class="rounded-full mx-auto w-32 h-32 object-cover border-4 border-indigo-100">
          </div>
          <h4 class="font-bold text-xl text-gray-800 mb-1">Susanti Afrilia</h4>
          <p class="text-indigo-600 font-medium mb-3">Fullstack</p>
          <p class="text-gray-600 text-sm mb-4">Information Systems student responsible for implementing core features.</p>
          <div class="flex justify-center space-x-3">
            <a href="https://github.com/" class="text-indigo-500 hover:text-indigo-700">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 0C5.373 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.6.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.547-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.84 1.237 1.84 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.666-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.237-3.221-.124-.303-.536-1.524.117-3.176 0 0 1.008-.322 3.301 1.23a11.41 11.41 0 016.006 0c2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.236 1.911 1.236 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.824 1.102.824 2.222v3.293c0 .319.192.694.801.576C20.562 21.8 24 17.303 24 12c0-6.627-5.373-12-12-12z"/>
              </svg>
            </a>
          </div>
        </div>
      </div>
      </div>
      </section>

      <!-- Featured In Section -->
      <section class="bg-gray-50 py-16">
      <div class="container mx-auto px-6">
        <div class="text-center mb-12">
          <span class="inline-block py-1 px-3 rounded-full bg-indigo-100 text-indigo-600 font-semibold text-sm mb-4">RECOGNITION</span>
          <h2 class="text-3xl font-bold text-gray-800">Supported & Recognized By</h2>
        </div>
        
        <div class="flex flex-wrap justify-center items-center gap-x-16 gap-y-8">
          <div data-aos="fade-up" class="grayscale hover:grayscale-0 transition">
            <img src="{{ asset('storage/images/telulogo.png') }}" alt="Telkom University Logo" class="h-12">
          </div>
          <div data-aos="fade-up" data-aos-delay="100" class="grayscale hover:grayscale-0 transition">
            <img src="{{ asset('storage/images/frilogo.png') }}" alt="HMIF Logo" class="h-12">
          </div>
          <div data-aos="fade-up" data-aos-delay="200" class="grayscale hover:grayscale-0 transition">
            <img src="{{ asset('storage/images/tglogo.jpg') }}" alt="BEM Logo" class="h-12">
          </div>
        </div>
      </div>
      </section>

      <!-- Contact Us Section -->
      <section id="contact" class="bg-gradient-to-r from-indigo-600 to-indigo-800 py-24 relative">
      <div class="absolute inset-0 bg-pattern opacity-10"></div>
      <div class="container mx-auto px-6 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-16">
          <span class="inline-block py-1 px-3 rounded-full bg-indigo-200 text-indigo-800 font-semibold text-sm mb-4">CONTACT US</span>
          <h2 class="text-4xl font-bold text-white mb-4">Contact Us</h2>
          <p class="text-indigo-100">Have questions or suggestions? Don't hesitate to reach out to the LombaKuy team.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <!-- Contact Info -->
          <div data-aos="fade-up" class="bg-white rounded-xl shadow-lg p-8 md:col-span-1">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Contact Information</h3>
            
            <div class="space-y-6">
              <div class="flex items-start">
                <div class="flex-shrink-0 bg-indigo-100 p-3 rounded-full">
                  <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                </div>
                <div class="ml-4">
                  <h4 class="text-lg font-semibold text-gray-800">Address</h4>
                  <p class="text-gray-600 mt-1">TULT Building, Telkom University, Bandung, West Java, Indonesia</p>
                </div>
              </div>
              
              <div class="flex items-start">
                <div class="flex-shrink-0 bg-indigo-100 p-3 rounded-full">
                  <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                  </svg>
                </div>
                <div class="ml-4">
                  <h4 class="text-lg font-semibold text-gray-800">Email</h4>
                  <p class="text-gray-600 mt-1">hello@lombakuy.id</p>
                  <p class="text-gray-600">support@lombakuy.id</p>
                </div>
              </div>
              
              <div class="flex items-start">
                <div class="flex-shrink-0 bg-indigo-100 p-3 rounded-full">
                  <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                  </svg>
                </div>
                <div class="ml-4">
                  <h4 class="text-lg font-semibold text-gray-800">Phone</h4>
                  <p class="text-gray-600 mt-1">+62 822 8807 0000</p>
                </div>
              </div>
              
              <div class="flex items-start">
                <div class="flex-shrink-0 bg-indigo-100 p-3 rounded-full">
                  <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                  </svg>
                </div>
                <div class="ml-4">
                  <h4 class="text-lg font-semibold text-gray-800">Social Media</h4>
                  <div class="flex space-x-3 mt-2">
                    <a href="https://www.facebook.com/?locale=id_ID" class="text-indigo-600 hover:text-indigo-800">
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z" />
                      </svg>
                    </a>
                    <a href="https://twitter.com/" class="text-indigo-600 hover:text-indigo-800">
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63a9.936 9.936 0 002.46-2.548l-.047-.02z" />
                      </svg>
                    </a>
                    <a href="https://www.instagram.com/" class="text-indigo-600 hover:text-indigo-800">
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                          d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5A4.25 4.25 0 0 0 7.75 20.5h8.5a4.25 4.25 0 0 0 4.25-4.25v-8.5A4.25 4.25 0 0 0 16.25 3.5h-8.5zm4.25 3a4.75 4.75 0 1 1 0 9.5 4.75 4.75 0 0 1 0-9.5zm0 1.5a3.25 3.25 0 1 0 0 6.5 3.25 3.25 0 0 0 0-6.5zm5.25-.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0z" />
                      </svg>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Contact Form -->
          <div id="contact" data-aos="fade-up" data-aos-delay="200" class="bg-white rounded-xl shadow-lg p-8 md:col-span-2">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Send a Message</h3>

            @if(session('success'))
                <div dusk="contact-success" class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <input type="text" id="name" name="name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" dusk="contact-nama" placeholder="Enter your full name" required>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" dusk="contact-email" placeholder="example@email.com" required>
                    </div>
                </div>

                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                    <input type="text" id="subject" name="subject" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" dusk="contact-subjek" placeholder="Message subject" required>
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                    <textarea id="message" name="message" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" dusk="contact-pesan" placeholder="Write your message here..." required></textarea>
                </div>

                <div>
                    <button type="submit" dusk="contact-submit" class="w-full bg-indigo-600 text-white py-3 px-6 rounded-lg hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Send Message
                    </button>
                </div>
            </form>
          </div>
        </div>
      </div>
      </section>

      <!-- Footer -->
      <footer class="bg-indigo-800 text-white py-12">
      <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
          <!-- Brand Info -->
          <div>
            <a href="/" class="text-2xl font-extrabold text-white flex items-center mb-4">
              <span class="mr-2">
                <i class="fas fa-trophy"></i>
              </span>
              LombaKuy
            </a>
            <p class="text-indigo-200">Empowering students to discover, join, and succeed in competitions with ease.</p>
          </div>
          
          <!-- Quick Links -->
          <div>
            <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
            <ul class="space-y-2">
              <li><a href="#features" class="text-indigo-200 hover:text-white transition">Features</a></li>
              <li><a href="#how-it-works" class="text-indigo-200 hover:text-white transition">How It Works</a></li>
              <li><a href="#testimonials" class="text-indigo-200 hover:text-white transition">Testimonials</a></li>
              <li><a href="#faq" class="text-indigo-200 hover:text-white transition">FAQ</a></li>
              <li><a href="#aboutus" class="text-indigo-200 hover:text-white transition">About Us</a></li>
            </ul>
          </div>
          
          <!-- Contact Info -->
          <div>
            <h4 class="text-lg font-semibold mb-4">Contact Us</h4>
            <ul class="space-y-2">
              <li class="flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <a href="mailto:hello@lombakuy.id" class="text-indigo-200 hover:text-white transition">hello@lombakuy.id</a>
              </li>
              <li class="flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                <a href="tel:+6282288070000" class="text-indigo-200 hover:text-white transition">+62 822 8807 0000</a>
              </li>
            </ul>
          </div>
          
          <!-- Social Media -->
          <div>
            <h4 class="text-lg font-semibold mb-4">Follow Us</h4>
            <div class="flex space-x-4">
              <a href="https://www.facebook.com/?locale=id_ID" class="text-indigo-200 hover:text-white transition">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z" />
                </svg>
              </a>
              <a href="https://twitter.com/" class="text-indigo-200 hover:text-white transition">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63a9.936 9.936 0 002.46-2.548l-.047-.02z" />
                </svg>
              </a>
              <a href="https://www.instagram.com/" class="text-indigo-200 hover:text-white transition">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                  <path
                    d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5A4.25 4.25 0 0 0 7.75 20.5h8.5a4.25 4.25 0 0 0 4.25-4.25v-8.5A4.25 4.25 0 0 0 16.25 3.5h-8.5zm4.25 3a4.75 4.75 0 1 1 0 9.5 4.75 4.75 0 0 1 0-9.5zm0 1.5a3.25 3.25 0 1 0 0 6.5 3.25 3.25 0 0 0 0-6.5zm5.25-.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0z" />
                </svg>
              </a>
            </div>
          </div>
        </div>
        
        <div class="mt-8 pt-8 border-t border-indigo-700 text-center">
          <p class="text-indigo-200">© 2025 LombaKuy. All rights reserved.</p>
        </div>
      </div>
      </footer>

      <!-- Scripts -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
      <script>
      AOS.init();
      </script>
      </body>
      </html>
        