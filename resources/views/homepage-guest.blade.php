<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>{{ config('app.name', 'Tixtoria') }}</title>
    <link rel="icon" href="{{ asset('images/logo.ico') }}" type="image/x-icon">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .hero-bg {
            background: linear-gradient(to top, rgb(255, 255, 255), rgba(27, 20, 100, 0)), url('https://via.placeholder.com/1920x600');
            background-size: cover;
            background-position: center;
            height: 90vh; /* You can adjust the height to your preference */
            transition: background-image 1s ease-in-out;
        }

        .hero-bg::after {
            background: linear-gradient(0deg,#23A6F0, rgba(255, 255, 255, 0) 50%);
            z-index: 90;
        }

        .hero-bg img {
            object-fit: cover;
        }

        .hero-bg img.visible {
            opacity: 1;
        }

        .hero-bg .dots {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 14px;
        }

        .hero-bg .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.621);
            box-shadow: 0 0 4px 2px rgba(0, 0, 0, 0.2); 
            cursor: pointer;
        }

        .hero-bg .dot.active {
            background-color: #fffffff2;
            box-shadow: 0 0 6px 2px rgba(255, 255, 255, 0.8);
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

        .shadow-lg {
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.3); /* Smooth shadow */
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

        .card {
            min-width: 200px;
            box-shadow: 0 5px 15px #1b14645a;
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: scale(1.03); /* Membesar 5% */
            transition: transform 0.3s ease; /* Efek halus */
        }


        ::-webkit-scrollbar {
        width: 12px; 
        }
        ::-webkit-scrollbar-track {
        background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
        background-color: #640D5F; 
        border-radius: 6px; 
        border: 3px solid #f1f1f1; 
        }
        ::-webkit-scrollbar-thumb:hover {
        background: #640D5F; 
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
                     <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                    
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

    <!-- Hero Section -->
    <section class="hero-bg text-white py-12 relative">
        <div class="flex items-center justify-center text-center mt-12">
            <div class="lg:w-full">
                <h2 class="mt-12 text-4xl lg:text-5xl font-bold leading-tight">Discover Exciting Events with Tixtoria</h2>
                <p class="mt-4 text-lg">
                    From live concerts to exclusive workshops, Tixtoria connects you to unforgettable experiences. <br>
                    Start exploring and book your next adventure today!
                </p>
            </div>
        </div>        
    
        <!-- Dots -->
        <div class="dots mt-8 mb-8 flex justify-center gap-6">
            <span class="dot active" data-index="0"></span>
            <span class="dot" data-index="1"></span>
            <span class="dot" data-index="2"></span>
            <span class="dot" data-index="3"></span>
            <span class="dot" data-index="4"></span>
        </div>
    
        <!-- Search Box -->
        <div class="mt-12 mx-auto max-w-4xl text-gray-900 rounded-[50px] shadow-lg py-3 px-3 relative" style="background-color :rgba(255, 255, 255, 0.188)">
            <form action="{{ route('eventCatalog') }}" method="GET" class="flex items-center space-x-4">
                @csrf
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Search by event name or location" 
                    class="w-full h-12 text-lg rounded-full px-4 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#640D5F]"
                    required
                />
                <button 
                    type="submit" 
                    class="bg-[#640D5F] text-white px-6 py-3 rounded-full font-medium"
                >
                    Search
                </button>
            </form>
        </div>        
    </section>    

    <section class="mt-20 mb-6">
        <div class="mx-auto w-full lg:pl-20 mt-4 mb-4">
            <!-- Upcoming Events -->
            <h2 class="text-3xl font-bold mb-6">Upcoming Events</h2>
            <div class="scroll-container">
                @foreach ($latestEvents as $event)
                    <a href="{{ route('events.show', $event->id) }}" class="card bg-gradient-to-t from-[#1B1464] via-transparent shadow-lg rounded-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300 min-w-[300px] relative">
                        <!-- Image -->
                        <div class="relative">
                            <img src="{{ $event->first_image ? asset($event->first_image) : 'https://via.placeholder.com/400x200' }}" alt="{{ $event->title }}" class="h-48 w-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-70"></div>
                        </div>
                        <!-- Details -->
                        <div class="p-6 bg-white rounded-b-lg">
                            <h3 class="text-xl font-bold text-gray-800 truncate">{{ $event->title }}</h3>
                            <p class="mt-4 text-sm text-gray-600 truncate-lines">{{ Str::limit($event->description, 120) }}</p>
                            <div class="mt-6 flex justify-between items-center">
                                <button class="text-sm bg-[#640D5F] text-white py-1 px-4 rounded hover:bg-[#1B1464]">
                                    Buy Tickets
                                </button>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    
    <section class="mt-8 mb-6">
        <div class="mx-auto w-full lg:pl-20">
            <!-- Popular Events -->
            <h2 class="text-3xl font-bold mb-6">Popular Events</h2>
            <div class="scroll-container">
                @foreach ($popularEvents as $event)
                    <a href="{{ route('events.show', $event->id) }}" class="card bg-gradient-to-t from-[#1B1464] via-transparent shadow-lg rounded-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300 min-w-[300px] relative">
                        <!-- Image -->
                        <div class="relative">
                            <img src="{{ $event->first_image ? asset($event->first_image) : 'https://via.placeholder.com/400x200' }}" alt="{{ $event->title }}" class="h-48 w-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-70"></div>
                        </div>
                        <!-- Details -->
                        <div class="p-6 bg-white rounded-b-lg">
                            <h3 class="text-xl font-bold text-gray-800 truncate">{{ $event->title }}</h3>
                            <p class="mt-4 text-sm text-gray-600 truncate-lines">{{ Str::limit($event->description, 120) }}</p>
                            <div class="mt-6 flex justify-between items-center">
                                <button class="text-sm bg-[#640D5F] text-white py-1 px-4 rounded hover:bg-[#1B1464]">
                                    Buy Tickets
                                </button>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>    
        

    {{-- <!-- Filter Section -->
    <section class="bg-[#540E68] py-6 rounded-xl shadow-lg">
        <div class="container mx-auto px-6 lg:px-20">
            <form method="GET" action="{{ route('homepage') }}" 
                class="flex flex-wrap lg:flex-nowrap items-center justify-center lg:justify-between gap-6 text-white">
                
                <!-- Filter Kategori -->
                <div class="relative w-full lg:w-1/3">
                    <label for="category" class="absolute top-[-12px] left-4 bg-[#540E68] px-2 text-sm text-white">Category</label>
                    <select 
                        id="category"
                        name="category" 
                        class="px-4 py-3 bg-transparent border border-white text-white rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-[#E0AFFF]" 
                        onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Lokasi -->
                <div class="relative w-full lg:w-1/3">
                    <label for="location" class="absolute top-[-12px] left-4 bg-[#540E68] px-2 text-sm text-white">Place</label>
                    <select 
                        id="location"
                        name="location" 
                        class="px-4 py-3 bg-transparent border border-white text-white rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-[#E0AFFF]" 
                        onchange="this.form.submit()">
                        <option value="">All Locations</option>
                        @foreach ($locations as $location)
                            <option value="{{ $location->city }}" {{ request('location') == $location->city ? 'selected' : '' }}>
                                {{ $location->city }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Tanggal -->
                <div class="relative w-full lg:w-1/3">
                    <label for="date" class="absolute top-[-12px] left-4 bg-[#540E68] px-2 text-sm text-white">Date</label>
                    <input 
                        type="date" 
                        id="date"
                        name="date" 
                        value="{{ request('date') }}" 
                        class="px-4 py-3 bg-transparent border border-white text-white rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-[#E0AFFF]" 
                        onchange="this.form.submit()">
                </div>
            </form>
        </div>
    </section> --}}

    <!-- Upcoming Events -->
    {{-- <section class="py-12">
        <div class="container mx-auto px-6 lg:px-20">
            <h2 class="text-3xl font-bold mb-6">Upcoming Events</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-8">
                @foreach ($events as $event)
                    <a href="{{ route('events.show', $event->id) }}" class="card bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <img src="{{ $event->first_image ? asset($event->first_image) : 'https://via.placeholder.com/400x200' }}" alt="{{ $event->title }}" class="h-48 w-full object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 truncate">{{ $event->title }}</h3>
                            <p class="mt-4 text-sm text-gray-600 truncate-lines">{{ Str::limit($event->description, 120) }}</p>
                            <div class="mt-6 flex justify-between items-center">
                                <span class="text-[]#640D5F font-semibold">{{ $event->date }}</span>
                                <button class="text-sm bg-[#640D5F] text-white py-1 px-4 rounded hover:bg-puple-900">
                                    Buy Tickets
                                </button>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>            
        </div>
    </section> --}}

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

    <script>
        const images = [
            '{{ asset('images/homepage/image1.jpeg') }}',
            '{{ asset('images/homepage/image2.jpeg') }}',
            '{{ asset('images/homepage/image3.jpeg') }}',
            '{{ asset('images/homepage/image4.jpeg') }}',
            '{{ asset('images/homepage/image5.jpg') }}'
        ];
    
        let currentIndex = 0;
        const heroBg = document.querySelector('.hero-bg');
        const dots = document.querySelectorAll('.dot');
    
        function changeBackground(index) {
            heroBg.style.backgroundImage = `linear-gradient(to bottom, rgba(100, 13, 95, 0.7), rgba(27, 20, 100, 0.7)), url('${images[index]}')`;
    
            // Set active dot
            dots.forEach(dot => dot.classList.remove('active'));
            dots[index].classList.add('active');
        }
    
        // Set initial background
        changeBackground(currentIndex);
    
        // Change image every 5 seconds
        setInterval(() => {
            currentIndex = (currentIndex + 1) % images.length;
            changeBackground(currentIndex);
        }, 3000);
    
        // Dots click event
        dots.forEach(dot => {
            dot.addEventListener('click', () => {
                const index = parseInt(dot.getAttribute('data-index'));
                changeBackground(index);
            });
        });
    </script>

</body>

</html>
