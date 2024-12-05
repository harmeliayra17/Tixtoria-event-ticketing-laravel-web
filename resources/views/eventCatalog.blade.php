<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Tixtoria') }} </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <title>{{ config('app.name', 'Tixtoria') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    

    <link rel="icon" href="{{ asset('images/logo.ico') }}" type="image/x-icon">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .card-shadow {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .truncate-lines {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            overflow: hidden;
            -webkit-line-clamp: 2;
        }

        .scroll-container {
            display: flex;
            overflow-x: auto;
            gap: 1.5rem;
            padding-bottom: 0.5rem; 
            scrollbar-width: none; 
            -ms-overflow-style: none;
        }

        .scroll-container::-webkit-scrollbar {
            display: none;
        }

        .scroll-container {
            display: flex;
            overflow-x: auto;
            gap: 1rem;
            padding-bottom: 0.5rem;
            scrollbar-width: none; 
        }

        .scroll-container::-webkit-scrollbar {
            display: none;
        }

        .scroll-container > a {
            flex: 0 0 auto; 
        }

        .category-name {
            text-align: center;
            word-wrap: break-word;
            word-break: break-word; 
            line-height: 0.8; /* Sesuaikan jarak antar baris */
            display: block; 
        }

        .card {
            min-width: 200px;
            box-shadow: 0 5px 15px #1b14645a;
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: scale(1.03);
            transition: transform 0.3s ease;
        }
    </style>
</head>

<body class="bg-gray-100">

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

    {{-- <section class="relative w-full h-[200px] overflow-hidden">
        <!-- Carousel -->
        <div x-data="{ currentSlide: 0, slides: 3 }" 
             x-init="setInterval(() => { currentSlide = (currentSlide + 1) % slides }, 3000)" 
             class="h-full relative">
            <!-- Slides -->
            <div class="absolute inset-0 flex transition-transform duration-500 ease-in-out"
                 :style="'transform: translateX(-' + (currentSlide * 100) + '%); width: 300%'">
                
                <!-- Slide 1 -->
                <div class="w-full flex-shrink-0 h-full relative">
                    <img src="{{ asset('images/catalog/image1.jpeg') }}" 
                         alt="Slide 1" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-[#640D5F]/80 to-[#1B1464]/80 transition-opacity duration-500"></div>
                    <div class="flex items-center justify-center h-full relative z-10">
                        <h1 class="text-white text-2xl font-bold">
                            Find the best entertainment events near you!
                        </h1>
                    </div>
                </div>
                
                <!-- Slide 2 -->
                <div class="w-full flex-shrink-0 h-full relative">
                    <img src="{{ asset('images/catalog/image2.jpeg') }}" 
                         alt="Slide 2" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-[#640D5F]/80 to-[#1B1464]/80 transition-opacity duration-500"></div>
                    <div class="flex items-center justify-center h-full relative z-10">
                        <h1 class="text-white text-2xl font-bold">
                            Discover exciting seminars and workshops today!
                        </h1>
                    </div>
                </div>
                
                <!-- Slide 3 -->
                <div class="w-full flex-shrink-0 h-full relative">
                    <div class="w-full aspect-[16/9] relative">
                        <img src="{{ asset('images/catalog/image3.jpeg') }}" 
                             alt="Slide 3" 
                             class="absolute inset-0 w-full h-full object-cover">
                    </div>                                       
                    <div class="absolute inset-0 bg-gradient-to-r from-[#640D5F]/80 to-[#1B1464]/80 transition-opacity duration-500"></div>
                    <div class="flex items-center justify-center h-full relative z-10">
                        <h1 class="text-white text-2xl font-bold">
                            Explore community and cultural festivals nearby!
                        </h1>
                    </div>
                </div>
            </div>
    
            <!-- Navigation Dots -->
            <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-2">
                <button @click="currentSlide = 0"
                        :class="{ 'bg-white scale-125': currentSlide === 0, 'bg-gray-500': currentSlide !== 0 }"
                        class="w-3 h-3 rounded-full transition-all duration-300"></button>
                <button @click="currentSlide = 1"
                        :class="{ 'bg-white scale-125': currentSlide === 1, 'bg-gray-500': currentSlide !== 1 }"
                        class="w-3 h-3 rounded-full transition-all duration-300"></button>
                <button @click="currentSlide = 2"
                        :class="{ 'bg-white scale-125': currentSlide === 2, 'bg-gray-500': currentSlide !== 2 }"
                        class="w-3 h-3 rounded-full transition-all duration-300"></button>
            </div>
        </div>
    </section>
          --}}

    <!-- Search Box -->
    <section class="mt-8 mb-8 px-20">
        <div class="mx-auto max-w-[1050px] bg-white text-gray-900 rounded-[50px] shadow-lg py-4 px-6 relative">
            <form action="{{ route('eventCatalog') }}" method="GET" class="flex flex-wrap items-center space-x-4 space-y-4 md:space-y-0">
                @csrf
    
                <!-- Search by Name or Location -->
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Search by event name or location" 
                    class="w-full md:w-[595px] h-12 text-lg rounded-full px-4 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#640D5F]" 
                />            
    
                <!-- Filter by Date -->
                <input type="date" name="date" value="{{ request('date') }}" class="h-12 text-lg rounded-full px-4 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#640D5F] w-full md:w-60" />
    
                <!-- Submit Button -->
                <button type="submit" class="w-full md:w-auto bg-[#640D5F] text-white px-6 py-3 rounded-full font-medium">
                    Search
                </button>
            </form>
        </div>
    </section>    

    <section class="mx-auto w-full lg:pl-20 mt-4 mb-4">
        <h2 class="text-3xl font-bold mb-6">Categories</h2>
        <div class="scroll-container">
            @foreach($categories as $category)
                <a href="{{ route('eventCatalog', ['category' => $category->id]) }}" 
                   class="flex flex-col items-center justify-center bg-[#640D5F] text-white text-center rounded-full py-6 px-6 hover:bg-[#1B1464] transition-colors mx-2">
                    
                    <!-- Icon (Material Icon) -->
                    <span class="material-icons text-3xl mb-2">
                        {{ $category->name == 'Entertainment and Arts' ? 'music_note' : '' }}
                        {{ $category->name == 'Education and Seminar' ? 'school' : '' }}
                        {{ $category->name == 'Sports and Health' ? 'fitness_center' : '' }}
                        {{ $category->name == 'Culture and Traditions' ? 'festival' : '' }}
                        {{ $category->name == 'Business and Networking' ? 'business_center' : '' }}
                        {{ $category->name == 'Children and Family' ? 'child_care' : '' }}
                        {{ $category->name == 'Technology and Science' ? 'devices' : '' }}
                        {{ $category->name == 'Lifestyle and Community' ? 'home' : '' }}
                    </span>
                    
                    <!-- Category Name -->
                    <span class="text-sm font-bold category-name">{{ $category->name }}</span>
                </a>
            @endforeach
        </div>
    </section>    

    <!-- Events -->
    <section class="py-4 mb-12 mx-16">
        <h2 class="text-3xl font-bold mb-6 p-4">
            {{ request('search') || request('date') || request('location') || request('category') ? 'Search Results' : 'All Events' }}
        </h2>
        
        @if ($events->isEmpty())
            <div class="text-center py-20">
                <h3 class="text-2xl font-bold text-gray-700">No Results Found</h3>
                <p class="text-gray-500 mt-2">Try adjusting your search or filter to find events.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-8">
                @foreach ($events as $event)
                    <a href="{{ route('events.show', $event->id) }}" class="card bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 max-w-[300px] gap-20 mx-auto">
                        <img src="{{ $event->image ? asset($event->image) : 'https://via.placeholder.com/400x200' }}" alt="{{ $event->title }}" class="h-48 w-full object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 truncate">{{ $event->title }}</h3>
                            <p class="mt-4 text-sm text-gray-600 truncate-lines">{{ Str::limit($event->description, 120) }}</p>
                            <div class="mt-6 flex justify-between items-center">
                                <button class="text-sm bg-[#640D5F] text-white py-1 px-4 rounded hover:bg-purple-900">
                                    Buy Tickets
                                </button>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif        
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
