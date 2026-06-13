<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Catalog - Tixtoria</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="icon" href="{{ asset('images/logo.ico') }}" type="image/x-icon">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .scroll-container {
            display: flex;
            overflow-x: auto;
            gap: 0.75rem;
            padding-bottom: 0.5rem; 
            scrollbar-width: none; 
            -ms-overflow-style: none;
        }

        .scroll-container::-webkit-scrollbar {
            display: none;
        }

        /* Smooth scroll styling */
        ::-webkit-scrollbar {
            width: 10px; 
        }
        ::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        ::-webkit-scrollbar-thumb {
            background-color: #640D5F; 
            border-radius: 6px; 
            border: 2px solid #f8fafc; 
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #1B1464; 
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased">

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
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">Explore Event Catalog</h1>
            <p class="text-slate-200 mt-2 text-sm md:text-base font-light">Find upcoming classes, live performances, and local experiences.</p>
        </div>
    </section>

    <!-- Search Box & Filter Panel -->
    <section class="-mt-8 px-6 lg:px-20 relative z-20">
        <div class="mx-auto max-w-5xl bg-white text-slate-800 rounded-2xl shadow-xl border border-slate-100 p-6">
            <form action="{{ route('eventCatalog') }}" method="GET" class="flex flex-col md:flex-row items-center gap-4">
                @csrf
                
                <!-- Search input -->
                <div class="relative w-full flex-[2]">
                    <i data-lucide="search" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400 w-5 h-5"></i>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Search by event name or city..." 
                        class="w-full h-12 bg-slate-50 border border-slate-200 rounded-xl pl-12 pr-4 focus:outline-none focus:border-[#640D5F] focus:ring-1 focus:ring-[#640D5F] text-sm" 
                    />
                </div>

                <!-- Date selector -->
                <div class="relative w-full flex-[1]">
                    <i data-lucide="calendar" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400 w-4 h-4"></i>
                    <input 
                        type="date" 
                        name="date" 
                        value="{{ request('date') }}" 
                        class="w-full h-12 bg-slate-50 border border-slate-200 rounded-xl pl-12 pr-4 focus:outline-none focus:border-[#640D5F] focus:ring-1 focus:ring-[#640D5F] text-sm text-slate-500" 
                    />
                </div>
    
                <!-- Submit Button -->
                <button type="submit" class="w-full md:w-auto h-12 bg-gradient-to-r from-[#640D5F] to-[#1B1464] text-white px-8 rounded-xl font-semibold hover:brightness-110 active:scale-95 transition-all duration-200 flex items-center justify-center gap-2">
                    <span>Search</span>
                </button>
            </form>
        </div>
    </section>    

    <!-- Categories Filters -->
    <section class="container mx-auto px-6 lg:px-20 mt-10">
        <h2 class="text-lg font-bold text-[#1B1464] mb-4">Categories</h2>
        <div class="scroll-container py-2">
            <!-- All Categories Pill -->
            <a href="{{ route('eventCatalog') }}" 
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-xs font-bold transition-all duration-200 border shadow-sm {{ !request('category') ? 'bg-[#640D5F] text-white border-[#640D5F]' : 'bg-white hover:bg-slate-100 text-slate-700 border-slate-200' }}">
                <i data-lucide="tag" class="w-3.5 h-3.5"></i>
                <span>All Categories</span>
            </a>

            @foreach($categories as $category)
                <a href="{{ route('eventCatalog', ['category' => $category->id]) }}" 
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-xs font-bold transition-all duration-200 border shadow-sm {{ request('category') == $category->id ? 'bg-[#640D5F] text-white border-[#640D5F]' : 'bg-white hover:bg-slate-100 text-slate-700 border-slate-200' }}">
                    
                    <i data-lucide="{{ 
                        $category->name == 'Entertainment and Arts' ? 'music' : (
                        $category->name == 'Education and Seminar' ? 'graduation-cap' : (
                        $category->name == 'Sports and Health' ? 'activity' : (
                        $category->name == 'Culture and Traditions' ? 'landmark' : (
                        $category->name == 'Business and Networking' ? 'briefcase' : (
                        $category->name == 'Children and Family' ? 'baby' : (
                        $category->name == 'Technology and Science' ? 'cpu' : (
                        $category->name == 'Lifestyle and Community' ? 'heart' : 'tag'
                        )))))))
                    }}" class="w-3.5 h-3.5"></i>
                    <span>{{ $category->name }}</span>
                </a>
            @endforeach
        </div>
    </section>    

    <!-- Events Grid -->
    <section class="container mx-auto px-6 lg:px-20 py-8 mb-16">
        <h2 class="text-2xl font-extrabold text-[#1B1464] mb-6">
            {{ request('search') || request('date') || request('category') ? 'Search Results' : 'All Events' }}
        </h2>
        
        @if ($events->isEmpty())
            <div class="text-center py-20 bg-white border border-slate-100 rounded-2xl shadow-sm">
                <i data-lucide="frown" class="w-12 h-12 text-slate-400 mx-auto mb-4"></i>
                <h3 class="text-xl font-bold text-slate-700">No Events Found</h3>
                <p class="text-slate-500 mt-2 text-sm">Try adjusting your filters or search terms to find matching events.</p>
                <a href="{{ route('eventCatalog') }}" class="mt-6 inline-flex items-center gap-2 bg-[#640D5F] text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:brightness-110 transition">Reset Search</a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($events as $event)
                    <a href="{{ route('events.show', $event->id) }}" class="group bg-white border border-slate-100 rounded-2xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between h-full relative">
                        <!-- Image & Category Badge -->
                        <div class="relative overflow-hidden h-48 bg-slate-100">
                            <img src="{{ Str::startsWith($event->image, ['http://', 'https://']) ? $event->image : ($event->image ? asset($event->image) : 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=800&auto=format&fit=crop&q=80') }}" alt="{{ $event->title }}" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <span class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm text-[#640D5F] text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow-sm">
                                {{ $event->category->name }}
                            </span>
                        </div>
                        
                        <!-- Details -->
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-1.5 text-[#640D5F] text-xs font-semibold">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                    <span>{{ date('D, d M Y', strtotime($event->date)) }}</span>
                                </div>
                                <h3 class="text-base font-bold text-slate-900 mt-2.5 group-hover:text-[#640D5F] transition-colors line-clamp-1">{{ $event->title }}</h3>
                                <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ Str::limit($event->description, 100) }}</p>
                            </div>
                            
                            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="text-[9px] text-slate-400 font-medium uppercase tracking-wider">Price</span>
                                    <span class="text-sm font-extrabold text-[#640D5F]">
                                        @if ($event->price > 0)
                                            Rp{{ number_format($event->price, 0, ',', '.') }}
                                        @else
                                            Free
                                        @endif
                                    </span>
                                </div>
                                <span class="inline-flex items-center gap-1 text-xs font-bold text-white bg-gradient-to-r from-[#640D5F] to-[#1B1464] px-4 py-2 rounded-xl shadow-md group-hover:brightness-110 transition duration-200">
                                    <i data-lucide="ticket" class="w-3.5 h-3.5"></i>
                                    <span>Get Tickets</span>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif        
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
