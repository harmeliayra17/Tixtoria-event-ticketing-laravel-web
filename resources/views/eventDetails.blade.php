<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Tixtoria') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
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

    <!-- Main Content -->

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <main class="py-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-4 mt-0 px-8">{{ $event->title }}</h1>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Event Image -->
            <div class="relative w-full h-[400px] rounded-lg overflow-hidden bg-gray-200">
                <img 
                    src="{{ asset($event->image) }}" 
                    alt="Event Image" 
                    class="w-full h-full object-cover">
            </div>
    

            <div class="bg-white shadow-md rounded-lg p-6 text-gray-800 space-y-6">
                <!-- Event Category -->
                <div class="flex items-center space-x-2">
                    <span class="material-icons text-[#640D5F]">category</span>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Category</p>
                        <p class="font-medium">{{ $event->category->name }}</p>
                    </div>
                </div>
            
                <!-- Location -->
                <div class="flex items-center space-x-2">
                    <span class="material-icons text-[#640D5F]">location_on</span>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Location</p>
                        <p class="font-medium">{{ $event->location->location_name }}, {{ $event->location->city }}, {{ $event->location->province }}</p>
                    </div>
                </div>
            
                <!-- Date and Time -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Date -->
                    <div class="flex items-center space-x-2">
                        <span class="material-icons text-[#640D5F]">event</span>
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Date</p>
                            <p class="font-medium">{{ date('d M Y', strtotime($event->date)) }}</p>
                        </div>
                    </div>
            
                    <!-- Time -->
                    <div class="flex items-center space-x-2">
                        <span class="material-icons text-[#640D5F]">schedule</span>
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Time</p>
                            <p class="font-medium">{{ date('H:i', strtotime($event->time)) }}</p>
                        </div>
                    </div>
                </div>
            
                <!-- Price -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex items-center space-x-2">
                        <span class="material-icons text-[#640D5F]">attach_money</span>
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Price</p>
                            <p class="font-bold text-[#640D5F] text-lg">
                                @if ($event->price > 0)
                                    Rp{{ number_format($event->price, 0, ',', '.') }}
                                @else
                                    Free
                                @endif
                            </p>
                        </div>
                    </div>
                
                    <!-- Quota -->
                    <div class="flex items-center space-x-2">
                        <span class="material-icons text-[#640D5F]">people</span>
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Quota</p>
                            <p class="font-medium">{{ $event->quota }} participants</p>
                        </div>
                    </div>
                </div>   
                
                <!-- Reserve Button -->
                <div class="mt-6 w-full flex items-center grid grid-cols-2 justify-center space-x-0">
                    @auth
                    <form action="{{ route('favorites.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <button 
                            type="submit" 
                            class="bg-[#640D5F] text-white py-3 px-4 rounded-lg hover:scale-105 transition-shadow duration-300">
                            <span class="material-icons text-white mr-2">favorite</span>
                            Add to Favorites
                        </button>
                    </form>
                        <!-- Jika pengguna sudah login, buka modal -->
                        <button 
                            onclick="openReservationModal()" 
                            class="mt-0 w-full flex items-center justify-center bg-gradient-to-r from-[#640D5F] to-[#1B1464] text-[#FFFFFF] py-3 px-4 rounded-lg hover:scale-105 transition duration-300">
                            <span class="material-icons text-white mr-2">event_available</span>
                            Reserve Now
                        </button>
                    @endauth

                    @guest
                        <!-- Jika pengguna belum login, arahkan ke halaman login -->
                        <a 
                            href="{{ route('login') }}" 
                            class="mt-6 w-full flex items-center justify-center bg-gradient-to-r from-gray-600 to-gray-800 text-white py-3 px-4 rounded-lg hover:shadow-lg transition-shadow duration-300">
                            <span class="material-icons text-white mr-2">login</span>
                            Login to Reserve
                        </a>
                    @endguest
                </div>
            </div>  
        </div>
            <!-- Event Desc -->
            <div class="bg-white shadow-lg rounded-lg p-6 ml-8 mr-8 mt-8">
                <p class="text-2xl mb-2 text-gray-600 font-semibold">Event Description</p>
                <p class="text-gray-600 mb-4">{!! nl2br(e($event->description)) !!}</p>
            </div>


        <!-- Reservation Modal -->
        <div id="reservation-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex justify-center items-center">
            <div class="bg-white rounded-lg shadow-lg p-6 w-1/2">
                <h2 class="text-2xl font-bold mb-4 text-[#640D5F]">Reserve Your Ticket</h2>
                <div class="mt-4">
                    <p class="text-gray-600">Price:</p>
                    <p id="ticket-price" class="text-[#640D5F] font-bold">
                        @if ($event->price > 0)
                            {{ 'Rp ' . number_format($event->price, 0, ',', '.') }}
                        @else
                            Free
                        @endif
                    </p>
                </div>
                
                <div class="mt-4">
                    <p class="text-gray-600">Total:</p>
                    <p id="total-price" class="text-[#640D5F] font-bold">
                        @if ($event->price > 0)
                            {{ 'Rp ' . number_format($event->price, 0, ',', '.') }}
                        @else
                            Free
                        @endif
                    </p>
                </div>

                <p class="text-gray-600 font-medium">Quantity:</p>
                <div class="flex items-center space-x-2">
                    <button 
                        onclick="updateQuantity(-1)" 
                        class="bg-white text-[#640D5F] px-3 py-1 rounded-lg hover:bg-gray-100 transition">
                        -
                    </button>
                    <span id="ticket-quantity" class="text-[#640D5F] text-lg font-semibold">1</span>
                    <button 
                        onclick="updateQuantity(1)" 
                        class="bg-white text-[#640D5F] px-3 py-1 rounded-lg hover:bg-gray-100 transition">
                        +
                    </button>
                </div>

                <form action="{{ route('book.store', $event->id) }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-1 gap-4">
                        <div>
 
                            <input type="hidden" id="quantity" name="quantity" value="1" required>
                        </div>
                        <div>
                            <label for="payment-method" class="block text-gray-600 font-semibold mb-2">Payment Method</label>
                            <select id="payment-method" name="payment_method" class="w-full border border-gray-300 rounded-lg p-2">
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="paypal">PayPal</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="mt-6 bg-[#640D5F] text-white py-2 px-4 rounded-lg hover:bg-[#1B1464]">
                        Checkout
                    </button>
                    <button 
                        type="button"
                        class="mt-4 bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600"
                        onclick="closeReservationModal()">Close</button>
                </form>
            </div>
        </div>
    </main>
    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
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

    <!-- JavaScript -->
    <script>
        let ticketQuantity = 1;
    
        // Function to open the reservation modal
        function openReservationModal() {
            const modal = document.getElementById('reservation-modal');
            if (modal) {
                modal.classList.remove('hidden');
            }
        }
    
        // Function to close the reservation modal
        function closeReservationModal() {
            const modal = document.getElementById('reservation-modal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }
    
        // Function to update the ticket quantity and total price
        function updateQuantity(change) {
        ticketQuantity += change;
        if (ticketQuantity < 1) ticketQuantity = 1; // Kuantitas minimal 1
        
        const ticketPriceElement = document.getElementById('ticket-price');
        const ticketPriceText = ticketPriceElement.innerText;
        
        let ticketPrice = ticketPriceText !== 'Free' 
            ? parseFloat(ticketPriceText.replace(/[^\d]/g, '')) 
            : 0;

        const quantityElement = document.getElementById('ticket-quantity');
        const totalPriceElement = document.getElementById('total-price');
        if (quantityElement) quantityElement.innerText = ticketQuantity;
        if (totalPriceElement) totalPriceElement.innerText = ticketPrice > 0 
            ? formatRupiah(ticketPrice * ticketQuantity)
            : 'Free';
    }


    
        // Update the quantity display and total price
        const quantityElement = document.getElementById('ticket-quantity');
        const totalPriceElement = document.getElementById('total-price');
        if (quantityElement) {
            quantityElement.innerText = ticketQuantity;
        }
        if (totalPriceElement) {
            totalPriceElement.innerText = ticketPrice > 0
                ? formatRupiah(ticketPrice * ticketQuantity)
                : 'Free'; // Show "Free" if ticket price is 0
        }
        
        // Function to format numbers to Rupiah currency format
        function formatRupiah(amount) {
            return 'Rp ' + amount.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }
    </script>
    
          
</body>
</html>
