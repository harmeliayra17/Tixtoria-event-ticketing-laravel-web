<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <title>Contact - Tixtoria</title>
    <link rel="icon" href="{{ asset('images/logo.ico') }}" type="image/x-icon">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between">
    <!-- Navbar -->
    <header class="bg-white/90 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50 transition-all duration-300">
        <div class="mx-auto px-6 lg:px-20 py-4 flex justify-between gap-6 items-center">
            <a href="{{ url('/') }}" class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Tixtoria Logo" class="h-8 rounded-md">
            </a>
            
            <nav class="hidden lg:flex space-x-8">
                <a href="{{ url('/') }}" class="text-[#1B1464] hover:text-[#640D5F] text-sm font-medium relative py-1.5 transition {{ Request::is('/') ? 'text-[#640D5F]' : '' }}">
                    Home
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-[#640D5F] rounded-full scale-x-0 transition-transform duration-300 origin-left {{ Request::is('/') ? 'scale-x-100' : '' }}"></span>
                </a>
            
                <a href="{{ route('eventCatalog') }}" class="text-[#1B1464] hover:text-[#640D5F] text-sm font-medium relative py-1.5 transition {{ Request::is('eventCatalog') ? 'text-[#640D5F]' : '' }}">
                    Event Catalog
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-[#640D5F] rounded-full scale-x-0 transition-transform duration-300 origin-left {{ Request::is('eventCatalog') ? 'scale-x-100' : '' }}"></span>
                </a>
            
                <a href="{{ url('/about') }}" class="text-[#1B1464] hover:text-[#640D5F] text-sm font-medium relative py-1.5 transition {{ Request::is('about') ? 'text-[#640D5F]' : '' }}">
                    About
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-[#640D5F] rounded-full scale-x-0 transition-transform duration-300 origin-left {{ Request::is('about') ? 'scale-x-100' : '' }}"></span>
                </a>
            
                <a href="{{ url('/contact') }}" class="text-[#1B1464] hover:text-[#640D5F] text-sm font-medium relative py-1.5 transition {{ Request::is('contact') ? 'text-[#640D5F]' : '' }}">
                    Contact
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-[#640D5F] rounded-full scale-x-0 transition-transform duration-300 origin-left {{ Request::is('contact') ? 'scale-x-100' : '' }}"></span>
                </a>
            </nav>           

            @auth
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" 
                        class="text-[#640D5F] px-4 py-2 rounded-full hidden lg:flex items-center space-x-2 hover:bg-slate-50 border border-[#640D5F]/20 font-medium text-sm transition focus:outline-none">
                    <span>{{ Auth::user()->name }}</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}"></i>
                </button>
            
                <!-- Dropdown -->
                <div x-show="open" 
                     @click.away="open = false" 
                     class="absolute right-0 mt-2 w-48 bg-white border border-slate-100 rounded-2xl shadow-xl z-50 overflow-hidden"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-95">
                     @if(Auth::user()->role === 'admin')
                         <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-[#640D5F]/5 hover:text-[#640D5F]">Dashboard</a>
                     @elseif(Auth::user()->role === 'organizer')
                         <a href="{{ route('organizer.dashboard') }}" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-[#640D5F]/5 hover:text-[#640D5F]">Dashboard</a>
                     @else
                         <a href="{{ route('user.dashboard') }}" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-[#640D5F]/5 hover:text-[#640D5F]">Dashboard</a>
                     @endif
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full px-4 py-2.5 text-sm text-slate-700 hover:bg-[#640D5F]/5 hover:text-[#640D5F] text-left border-t border-slate-50">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>                       
            @else
                <a href="{{ route('login') }}" class="bg-gradient-to-r from-[#640D5F] to-[#1B1464] text-white text-sm font-semibold px-6 py-2.5 rounded-full hover:shadow-lg hover:brightness-110 transition hidden lg:block">
                    Login/Register
                </a>
            @endauth              
        </div>
    </header>

    <!-- Header Banner -->
    <section class="bg-gradient-to-r from-[#1B1464] to-[#640D5F] py-12 text-white">
        <div class="container mx-auto px-6 lg:px-20">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">Contact Us</h1>
            <p class="text-slate-200 mt-2 text-sm md:text-base font-light">Have questions, feedback, or ideas? We'd love to hear from you.</p>
        </div>
    </section>

    <!-- Contact Content -->
    <section class="py-16">
        <div class="container mx-auto px-6 lg:px-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">
                <!-- Contact Form Card -->
                <div class="bg-white border border-slate-100 rounded-2xl shadow-xl p-8">
                    <h2 class="text-2xl font-bold text-[#1B1464] mb-6 flex items-center gap-2">
                        <i data-lucide="mail" class="w-6 h-6 text-[#640D5F]"></i>
                        <span>Send a Message</span>
                    </h2>
                    <form class="space-y-4" onsubmit="event.preventDefault(); alert('Message sent successfully!');">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2" for="name">Your Name</label>
                            <input id="name" type="text" placeholder="Enter your name" class="w-full h-11 px-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#640D5F] focus:ring-1 focus:ring-[#640D5F]" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2" for="email">Your Email</label>
                            <input id="email" type="email" placeholder="Enter your email" class="w-full h-11 px-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#640D5F] focus:ring-1 focus:ring-[#640D5F]" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2" for="message">Message</label>
                            <textarea id="message" rows="4" placeholder="Write your message here..." class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#640D5F] focus:ring-1 focus:ring-[#640D5F]" required></textarea>
                        </div>
                        <button type="submit" class="w-full bg-gradient-to-r from-[#640D5F] to-[#1B1464] text-white py-3 rounded-xl font-semibold hover:brightness-110 active:scale-98 transition duration-200">Send Message</button>
                    </form>
                </div>

                <!-- Contact Info Card -->
                <div class="bg-white border border-slate-100 rounded-2xl shadow-xl p-8 flex flex-col justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-[#1B1464] mb-8">Contact Information</h2>
                        <div class="space-y-6">
                            <!-- Email -->
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-[#640D5F]/5 flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="mail" class="w-5 h-5 text-[#640D5F]"></i>
                                </div>
                                <div>
                                    <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Email Address</h4>
                                    <p class="text-sm font-semibold text-slate-800 mt-1">support@tixtoria.com</p>
                                </div>
                            </div>
                            
                            <!-- Phone -->
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-[#640D5F]/5 flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="phone" class="w-5 h-5 text-[#640D5F]"></i>
                                </div>
                                <div>
                                    <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Phone Support</h4>
                                    <p class="text-sm font-semibold text-slate-800 mt-1">+1 (123) 456-7890</p>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-[#640D5F]/5 flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="map-pin" class="w-5 h-5 text-[#640D5F]"></i>
                                </div>
                                <div>
                                    <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Office Location</h4>
                                    <p class="text-sm font-semibold text-slate-800 mt-1 leading-snug">1234 Tixtoria St, Suite 100</p>
                                    <p class="text-xs text-slate-500 mt-0.5">New York, NY 10001</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-12 mt-auto">
        <div class="container mx-auto px-6 lg:px-20 flex justify-between flex-wrap gap-8">
            <div class="w-full lg:w-1/3">
                <img src="{{ asset('images/logo-wht.png') }}" alt="Tixtoria Logo" class="h-8 rounded-md mb-4">
                <p class="text-sm">A global self-service ticketing platform for premium live experiences.</p>
            </div>
            <div class="w-full lg:w-1/4">
                <h3 class="text-white text-base font-bold mb-4">Plan Events</h3>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="#" class="hover:text-white transition">Create and Set Up</a></li>
                    <li><a href="#" class="hover:text-white transition">Sell Tickets</a></li>
                    <li><a href="#" class="hover:text-white transition">Online RSVP</a></li>
                </ul>
            </div>
            <div class="w-full lg:w-1/3">
                <h3 class="text-white text-base font-bold mb-4">Stay In The Loop</h3>
                <div class="flex gap-2">
                    <input type="email" placeholder="Enter your email address" class="px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:ring-1 focus:ring-[#640D5F] w-full text-sm">
                    <button class="bg-[#640D5F] text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:brightness-110 transition flex-shrink-0">Subscribe</button>
                </div>
            </div>
        </div>
        <div class="border-t border-slate-800 mt-10 pt-6 text-center text-xs">Copyright © 2026 Tixtoria. All rights reserved.</div>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>