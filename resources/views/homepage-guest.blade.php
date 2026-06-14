<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <title>{{ config('app.name', 'Tixtoria') }}</title>
    <link rel="icon" href="{{ asset('images/logo.ico') }}" type="image/x-icon">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .hero-bg {
            background-size: cover;
            background-position: center;
            transition: background-image 1s ease-in-out;
        }

        .dots {
            display: flex;
            gap: 10px;
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.4);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .dot.active {
            width: 24px;
            border-radius: 4px;
            background-color: #ffffff;
        }

        
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
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased">

    
    <x-guest-navbar />

    
    <section class="hero-bg text-white relative flex items-center h-[calc(100vh-73px)] overflow-hidden">
        
        <div class="absolute inset-0 bg-gradient-to-tr from-[#1B1464]/60 via-slate-900/50 to-[#640D5F]/15 z-10"></div>
        
        <div class="container mx-auto px-6 lg:px-20 relative z-20 flex flex-col items-center justify-center text-center py-20">
            <h1 class="text-4xl md:text-6xl font-extrabold leading-tight tracking-tight max-w-4xl">
                Unforgettable Experiences <br class="hidden md:inline"> Await You with <span class="bg-gradient-to-r from-[#FFD0FC] to-white bg-clip-text text-transparent">Tixtoria</span>
            </h1>
            <p class="mt-6 text-sm md:text-base text-slate-200 max-w-2xl font-light">
                From live concerts to exclusive workshops, Tixtoria connects you to local and global premium live experiences. Start exploring now!
            </p>

            
            <div class="mt-10 w-full max-w-3xl bg-white/10 backdrop-blur-md border border-white/20 p-2 rounded-2xl md:rounded-full shadow-2xl">
                <form action="{{ route('eventCatalog') }}" method="GET" class="flex flex-col md:flex-row items-center gap-2">
                    @csrf
                    <div class="relative w-full flex-1">
                        <i data-lucide="search" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-300 w-5 h-5"></i>
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Search by event name, location, artist..." 
                            class="w-full h-12 bg-transparent text-white placeholder-slate-300 pl-12 pr-4 rounded-full border-none focus:outline-none focus:ring-0 text-base"
                            required
                        />
                    </div>
                    <button 
                        type="submit" 
                        class="w-full md:w-auto bg-gradient-to-r from-[#640D5F] to-[#1B1464] text-white px-8 h-12 rounded-xl md:rounded-full font-semibold hover:brightness-110 active:scale-95 transition-all duration-200 flex items-center justify-center gap-2"
                    >
                        <span>Search</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
            
            
            <div class="dots mt-12 flex justify-center gap-3">
                <span class="dot active" data-index="0"></span>
                <span class="dot" data-index="1"></span>
                <span class="dot" data-index="2"></span>
                <span class="dot" data-index="3"></span>
                <span class="dot" data-index="4"></span>
            </div>
        </div>
    </section>    

    
    <section class="py-16 bg-white border-b border-slate-100">
        <div class="container mx-auto px-6 lg:px-20">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <h2 class="text-3xl font-extrabold text-[#1B1464] tracking-tight">Browse Events by Category</h2>
                <p class="text-slate-500 mt-2 text-sm">Find exactly what you're interested in from our curated selections</p>
            </div>
            
            @php
                $categories = \App\Models\Category::all();
            @endphp
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($categories as $category)
                    <a href="{{ route('eventCatalog', ['category' => $category->id]) }}" 
                       class="group flex flex-col items-center justify-center p-6 bg-slate-50 border border-slate-100 rounded-2xl hover:bg-gradient-to-br hover:from-[#640D5F] hover:to-[#1B1464] hover:text-white hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="w-14 h-14 rounded-full bg-[#640D5F]/5 flex items-center justify-center mb-4 group-hover:bg-white/20 transition-all duration-300">
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
                            }}" class="w-7 h-7 text-[#640D5F] group-hover:text-white transition-all duration-300"></i>
                        </div>
                        <span class="text-sm font-bold text-slate-800 group-hover:text-white text-center transition-all duration-300">{{ $category->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    
    <section class="py-16 bg-slate-50">
        <div class="container mx-auto px-6 lg:px-20">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <h2 class="text-3xl font-extrabold text-[#1B1464] tracking-tight">Upcoming Events</h2>
                    <p class="text-slate-500 mt-1 text-sm">Be the first to secure your spot in these upcoming events</p>
                </div>
                <a href="{{ route('eventCatalog') }}" class="inline-flex items-center text-sm font-bold text-[#640D5F] hover:text-[#1B1464] transition-colors gap-1 group">
                    <span>Explore All</span>
                    <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
            
            <div class="flex overflow-x-auto gap-6 pb-6 -mx-6 px-6 lg:mx-0 lg:px-0 no-scrollbar">
                @foreach ($latestEvents as $event)
                    <a href="{{ route('events.show', $event->id) }}" class="min-w-[280px] md:min-w-[320px] max-w-[320px] flex-shrink-0 group bg-white border border-slate-100 rounded-2xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between h-full relative">
                        
                        <div class="relative overflow-hidden h-48 bg-slate-100">
                            <img src="{{ Str::startsWith($event->image, ['http://', 'https://']) ? $event->image : ($event->image ? asset($event->image) : 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=800&auto=format&fit=crop&q=80') }}" alt="{{ $event->title }}" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <span class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm text-[#640D5F] text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow-sm">
                                {{ $event->category->name }}
                            </span>
                        </div>
                        
                        
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
        </div>
    </section>

    
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6 lg:px-20">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <h2 class="text-3xl font-extrabold text-[#1B1464] tracking-tight">Popular Events</h2>
                    <p class="text-slate-500 mt-1 text-sm">Trending experiences that people are loving right now</p>
                </div>
                <a href="{{ route('eventCatalog') }}" class="inline-flex items-center text-sm font-bold text-[#640D5F] hover:text-[#1B1464] transition-colors gap-1 group">
                    <span>Explore All</span>
                    <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
            
            <div class="flex overflow-x-auto gap-6 pb-6 -mx-6 px-6 lg:mx-0 lg:px-0 no-scrollbar">
                @foreach ($popularEvents as $event)
                    <a href="{{ route('events.show', $event->id) }}" class="min-w-[280px] md:min-w-[320px] max-w-[320px] flex-shrink-0 group bg-white border border-slate-100 rounded-2xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between h-full relative">
                        
                        <div class="relative overflow-hidden h-48 bg-slate-100">
                            <img src="{{ Str::startsWith($event->image, ['http://', 'https://']) ? $event->image : ($event->image ? asset($event->image) : 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=800&auto=format&fit=crop&q=80') }}" alt="{{ $event->title }}" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <span class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm text-[#640D5F] text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow-sm">
                                {{ $event->category->name }}
                            </span>
                        </div>
                        
                        
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
        </div>
    </section>

    
    <section class="py-20 bg-gradient-to-r from-[#1B1464] to-[#640D5F] text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="container mx-auto px-6 lg:px-20 relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="max-w-2xl">
                <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight">Hosting an Event? Sell tickets on Tixtoria!</h2>
                <p class="mt-4 text-slate-200 text-sm md:text-base font-light">
                    From corporate seminars to local live concerts, create and customize your event tickets, control quotas, track sales with live graphs, and receive payments securely.
                </p>
            </div>
            <div class="flex-shrink-0">
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-white text-[#1B1464] px-8 py-4 rounded-full font-bold shadow-xl hover:bg-slate-50 active:scale-95 transition-all duration-200">
                    <span>Create Event Now</span>
                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </a>
            </div>
        </div>
    </section>

    
    <x-guest-footer />

    <script>
        const images = [
            'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=1920&q=80',
            'https://images.unsplash.com/photo-1511578314322-379afb476865?w=1920&q=80',
            'https://images.unsplash.com/photo-1460661419201-fd4cecdf8a8b?w=1920&q=80',
            'https://images.unsplash.com/photo-1502224562085-639556652f33?w=1920&q=80',
            'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=1920&q=80'
        ];
    
        let currentIndex = 0;
        const heroBg = document.querySelector('.hero-bg');
        const dots = document.querySelectorAll('.dot');
    
        function changeBackground(index) {
            heroBg.style.backgroundImage = `linear-gradient(to bottom, rgba(27, 20, 100, 0.5), rgba(15, 23, 42, 0.5)), url('${images[index]}')`;
    
            
            dots.forEach(dot => dot.classList.remove('active'));
            dots[index].classList.add('active');
        }
    
        
        changeBackground(currentIndex);
    
        
        setInterval(() => {
            currentIndex = (currentIndex + 1) % images.length;
            changeBackground(currentIndex);
        }, 3000);
    
        
        dots.forEach(dot => {
            dot.addEventListener('click', () => {
                const index = parseInt(dot.getAttribute('data-index'));
                changeBackground(index);
            });
        });

        lucide.createIcons();
    </script>

</body>

</html>
