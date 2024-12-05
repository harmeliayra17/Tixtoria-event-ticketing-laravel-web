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

    <!-- Contact Section -->
    <section class="py-4 bg-white mb-3">
        <div class="container mx-auto px-6 lg:px-20">
            <h1 class="text-4xl font-bold text-[#640D5F] text-center">Get In Touch</h1>
            <p class="text-gray-600 text-center mt-4">We’d love to hear from you. Whether you have questions, feedback, or ideas, feel free to reach out.</p>

            <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Contact Form -->
                <form class="bg-gray-50 p-8 shadow-md rounded-lg">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700" for="name">Your Name</label>
                        <input id="name" type="text" placeholder="Enter your name" class="mt-2 px-4 py-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#640D5F]">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700" for="email">Your Email</label>
                        <input id="email" type="email" placeholder="Enter your email" class="mt-2 px-4 py-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#640D5F]">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700" for="message">Message</label>
                        <textarea id="message" rows="4" placeholder="Write your message here" class="mt-2 px-4 py-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#640D5F]"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-[#640D5F] text-white py-2 rounded-lg hover:bg-[#4b0644] transition">Send Message</button>
                </form>

                <!-- Contact Details -->
                <div class="bg-white p-8 shadow-md rounded-lg">
                    <h2 class="text-2xl font-semibold text-[#640D5F]">Contact Information</h2>
                    <ul class="mt-4 space-y-4 text-gray-600">
                        <li class="flex items-center">
                            <svg class="w-6 h-6 text-[#640D5F] mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.14 12.89a2.38 2.38 0 11-2.24-2.24 2.39 2.39 0 012.24 2.24zM6.5 3.5l1.42 1.42L2.54 10.3a2.38 2.38 0 000 3.36l3.85 3.85 1.42-1.42-3.85-3.85a.49.49 0 010-.69L6.5 3.5zm7 14.18l3.85 3.85a.49.49 0 00.69 0l1.42-1.42-3.85-3.85z" />
                            </svg>
                            <span>support@tixtoria.com</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-6 h-6 text-[#640D5F] mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.75 6.5a.75.75 0 01.75-.75h12a.75.75 0 010 1.5h-12a.75.75 0 01-.75-.75z" />
                            </svg>
                            <span>+1 (123) 456-7890</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-6 h-6 text-[#640D5F] mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l1.57-2.64L7 5.64l4-2.64 4 2.64 2.43 3.72 1.57 2.64m-4-5.36l-.93 1.51m-6.14-1.51l-.93 1.51m8.47 5.59l1.5-.94M6.5 13.53l1.5-.94" />
                            </svg>
                            <span>1234 Tixtoria St, Suite 100, New York, NY</span>
                        </li>
                    </ul>
                </div>
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