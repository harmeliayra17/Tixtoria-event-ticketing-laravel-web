<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>{{ config('app.name', 'Tixtoria') }}</title>
    <link rel="icon" href="{{ asset('images/logo.ico') }}" type="image/x-icon">
</head>
<body>
    <!-- Navbar -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="mx-auto px-20 lg:px-20 py-4 flex justify-between gap-6 items-center">
            <img src="{{ asset('images/logo.png') }}" alt="Tixtoria Logo" class="h-8 rounded-md">
            <nav class="hidden lg:flex space-x-6">
                <a href="{{ url('/') }}" class="text-[#1B1464] hover:text-[#640D5F] relative inline-block {{ Request::is('/') ? 'text-[#640D5F]' : '' }}" style="position: relative; display: inline-block;">
                    Home
                    <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-px bg-[#640D5F] transition-all duration-300 {{ Request::is('/') ? 'w-full rounded-full' : 'w-0' }}"></span>
                </a>
            
                <a href="{{ route('eventCatalog') }}" class="text-[#1B1464] hover:text-[#640D5F] relative inline-block {{ Request::is('eventCatalog') ? 'text-[#640D5F]' : '' }}" style="position: relative; display: inline-block;">
                    Event Catalog
                    <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-px bg-[#640D5F] transition-all duration-300 {{ Request::is('eventCatalog') ? 'w-full rounded-full' : 'w-0' }}"></span>
                </a>
            
                <a href="{{ url('/about') }}" class="text-[#1B1464] hover:text-[#640D5F] relative inline-block {{ Request::is('about') ? 'text-[#640D5F]' : '' }}" style="position: relative; display: inline-block;">
                    About
                    <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-px bg-[#640D5F] transition-all duration-300 {{ Request::is('about') ? 'w-full rounded-full' : 'w-0' }}"></span>
                </a>
            
                <a href="{{ url('/contact') }}" class="text-[#1B1464] hover:text-[#640D5F] relative inline-block {{ Request::is('contact') ? 'text-[#640D5F]' : '' }}" style="position: relative; display: inline-block;">
                    Contact
                    <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-px bg-[#640D5F] transition-all duration-300 {{ Request::is('contact') ? 'w-full rounded-full' : 'w-0' }}"></span>
                </a>
            </nav>           
            @auth
            <div x-data="{ open: false }" class="relative">
                <!-- Nama Pengguna -->
                <button @click="open = !open" 
                        class="text-[#640D5F] px-6 py-2 rounded-lg hidden lg:flex items-center space-x-2 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#640D5F]">
                    <span>{{ Auth::user()->name }}</span>
                    <!-- Ikon Panah -->
                    <svg xmlns="http://www.w3.org/2000/svg" 
                         class="w-4 h-4 transition-transform duration-200" 
                         :class="{'rotate-180': open}" 
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            
                <!-- Dropdown -->
                <div x-show="open" 
                     @click.away="open = false" 
                     class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-10"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-95">
                     <a href="{{ url('/dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 text-left">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>                       
            @else
                <!-- Jika belum login, tampilkan tombol Login -->
                <a href="{{ route('login') }}" class="text-[#640D5F] hover:text-[#1B1464] text-lg hidden lg:block" style="font-size: 16px">
                    Login/Register
                </a>                
                </button>
            @endauth              
        </div>
    </header>

    <!-- About Section -->
<!-- About Section -->
<section class="bg-white py-12">
    <div class="container mx-auto px-6 flex flex-col lg:flex-row items-center gap-8">
        <!-- Gambar -->
        <div class="w-full lg:w-1/2">
            <img src="https://via.placeholder.com/500x300" alt="About Image" class="rounded-lg shadow-md">
        </div>
        <!-- Teks -->
        <div class="w-full lg:w-1/2">
            <h2 class="text-3xl font-bold text-purple-700 mb-4">About Tixtoria</h2>
            <p class="text-lg text-gray-600 mb-6">
                Tixtoria is a platform designed to connect event organizers and attendees seamlessly. With cutting-edge tools, we empower communities to create unforgettable experiences. Whether you're hosting concerts, conferences, or local gatherings, Tixtoria ensures smooth management and unparalleled engagement.
            </p>
            <p class="text-lg text-gray-600">
                Our platform supports organizers with easy ticketing, attendee management, and insightful analytics. Join thousands of happy users and explore how Tixtoria can revolutionize your events. Together, we create moments that last a lifetime.
            </p>
        </div>
    </div>
</section>


            </div>
        </div>
    </section>

      <!-- Footer -->
      <footer class="bg-gray-900 text-white py-8">
        <div class="container mx-auto px-6 lg:px-20 flex justify-between flex-wrap">
            <div class="w-full lg:w-1/3 mb-6 lg:mb-0">
                <img src="{{ asset('images/logo-wht.png') }}" alt="Tixtoria Logo" class="h-8 rounded-md">
                <p class="mt-2 text-gray-400">A global self-service ticketing platform for live experiences.</p>
            </div>
            <div class="w-full lg:w-1/3 mb-6 lg:mb-0">
                <h3 class="text-lg font-bold">Plan Events</h3>
                <ul class="text-gray-400 space-y-2 mt-2">
                    <li><a href="#" class="hover:underline">Create and Set Up</a></li>
                    <li><a href="#" class="hover:underline">Sell Tickets</a></li>
                    <li><a href="#" class="hover:underline">Online RSVP</a></li>
                </ul>
            </div>
            <div class="w-full lg:w-1/3">
                <h3 class="text-lg font-bold">Stay In The Loop</h3>
                <div class="mt-4">
                    <input type="email" placeholder="Enter your email address" class="px-4 py-2 rounded-lg w-full">
                    <button class="bg-[#640D5F] text-white px-6 py-2 rounded-lg mt-4 block w-full">Subscribe Now</button>
                </div>
            </div>
        </div>
        <div class="text-center mt-8 text-gray-400">Copyright © 2023 Tixtoria. All rights reserved.</div>
    </footer>
</body>
</html>