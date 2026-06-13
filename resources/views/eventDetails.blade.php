<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }} - Tixtoria</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="icon" href="{{ asset('images/logo.ico') }}" type="image/x-icon">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
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

    <!-- Success / Error Status Alerts -->
    <div class="container mx-auto px-6 lg:px-20 mt-6">
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl flex items-center gap-3">
                <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600 flex-shrink-0"></i>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-xl flex items-center gap-3">
                <i data-lucide="alert-circle" class="w-5 h-5 text-rose-600 flex-shrink-0"></i>
                <p class="text-sm font-medium">{{ session('error') }}</p>
            </div>
        @endif
    </div>

    <!-- Main Container -->
    <main class="container mx-auto px-6 lg:px-20 py-8">
        <!-- Event Header Info -->
        <div class="mb-8">
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-[#640D5F]/10 text-[#640D5F] text-xs font-bold uppercase tracking-wider mb-3">
                {{ $event->category->name }}
            </span>
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight">{{ $event->title }}</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column: Media & Description -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Large Event Image -->
                <div class="relative w-full aspect-[16/9] rounded-2xl overflow-hidden shadow-md bg-slate-100">
                    <img 
                        src="{{ Str::startsWith($event->image, ['http://', 'https://']) ? $event->image : ($event->image ? asset($event->image) : 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=800&auto=format&fit=crop&q=80') }}" 
                        alt="{{ $event->title }}" 
                        class="w-full h-full object-cover">
                </div>

                <!-- Event Details Grid -->
                <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Location Detail -->
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#640D5F]/5 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="map-pin" class="w-5 h-5 text-[#640D5F]"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Location</h4>
                            <p class="text-sm font-semibold text-slate-800 mt-1 leading-snug">
                                {{ $event->location->location_name }}
                            </p>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $event->location->city }}, {{ $event->location->province }}</p>
                        </div>
                    </div>

                    <!-- Date & Time Detail -->
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#640D5F]/5 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="calendar" class="w-5 h-5 text-[#640D5F]"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Date & Time</h4>
                            <p class="text-sm font-semibold text-slate-800 mt-1 leading-snug">
                                {{ date('D, d M Y', strtotime($event->date)) }}
                            </p>
                            <p class="text-xs text-slate-500 mt-0.5">{{ date('H:i', strtotime($event->time)) }} WIB</p>
                        </div>
                    </div>

                    <!-- Quota/Capacity Detail -->
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#640D5F]/5 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="users" class="w-5 h-5 text-[#640D5F]"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Quota Available</h4>
                            <p class="text-sm font-semibold text-slate-800 mt-1 leading-snug">
                                {{ $event->quota }} Tickets left
                            </p>
                            <p class="text-xs text-slate-500 mt-0.5">Secure yours before it closes</p>
                        </div>
                    </div>
                </div>

                <!-- Event Rich Description -->
                <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6 md:p-8">
                    <h3 class="text-xl font-bold text-[#1B1464] border-b border-slate-50 pb-4 mb-4">Event Description</h3>
                    <div class="text-sm text-slate-600 leading-relaxed space-y-4">
                        {!! nl2br(e($event->description)) !!}
                    </div>
                </div>
            </div>

            <!-- Right Column: Sticky Booking / Checkout Card -->
            <div class="lg:col-span-1">
                <div class="sticky top-24 bg-white border border-slate-100 rounded-2xl shadow-xl p-6 space-y-6">
                    <div>
                        <span class="text-xs text-slate-400 uppercase font-semibold tracking-wider">Ticket Price</span>
                        <h2 class="text-2xl font-extrabold text-[#640D5F] mt-1" id="display-price">
                            @if ($event->price > 0)
                                Rp{{ number_format($event->price, 0, ',', '.') }}
                            @else
                                Free
                            @endif
                        </h2>
                    </div>

                    <div class="border-t border-slate-100 pt-6">
                        @auth
                            <!-- Booking Form -->
                            <form action="{{ route('book.store', $event->id) }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" id="quantity" name="quantity" value="1" required>

                                <!-- Quantity Selector -->
                                <div class="flex items-center justify-between bg-slate-50 p-3.5 rounded-xl border border-slate-200/50">
                                    <span class="text-sm font-semibold text-slate-700">Quantity</span>
                                    <div class="flex items-center gap-3">
                                        <button 
                                            type="button"
                                            onclick="updateQuantity(-1)" 
                                            class="w-8 h-8 rounded-full bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 font-bold flex items-center justify-center transition focus:outline-none">
                                            -
                                        </button>
                                        <span id="ticket-quantity" class="text-[#640D5F] font-bold text-base w-6 text-center">1</span>
                                        <button 
                                            type="button"
                                            onclick="updateQuantity(1)" 
                                            class="w-8 h-8 rounded-full bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 font-bold flex items-center justify-center transition focus:outline-none">
                                            +
                                        </button>
                                    </div>
                                </div>

                                <!-- User Billing Information -->
                                <div class="space-y-3">
                                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Billing Contact</h4>
                                    <div>
                                        <input type="text" value="{{ Auth::user()->name }}" class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-xs text-slate-500 font-medium" readonly>
                                    </div>
                                    <div>
                                        <input type="email" value="{{ Auth::user()->email }}" class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-xs text-slate-500 font-medium" readonly>
                                    </div>
                                    <div>
                                        <input type="tel" name="phone" placeholder="Phone Number (e.g. +62 812 3456)" class="w-full h-11 bg-white border border-slate-200 rounded-xl px-4 text-xs text-slate-700 focus:outline-none focus:border-[#640D5F] focus:ring-1 focus:ring-[#640D5F]" required>
                                    </div>
                                </div>

                                <!-- Payment Selector -->
                                <div class="space-y-3">
                                    <label for="payment-method" class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Payment Method</label>
                                    <div class="relative">
                                        <select id="payment-method" name="payment_method" class="w-full h-11 bg-white border border-slate-200 rounded-xl px-4 text-xs focus:outline-none focus:border-[#640D5F] focus:ring-1 focus:ring-[#640D5F] appearance-none cursor-pointer" onchange="togglePaymentFields(this.value)">
                                            <option value="bank_transfer">Bank Transfer</option>
                                            <option value="credit_card">Credit Card</option>
                                            <option value="paypal">PayPal</option>
                                        </select>
                                        <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none text-slate-500">
                                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dynamic payment method sections -->
                                <!-- Bank Transfer -->
                                <div id="payment-bank_transfer" class="payment-details-panel space-y-3 bg-slate-50/50 p-4 rounded-xl border border-slate-200/40">
                                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Select Target Bank</label>
                                    <select name="sender_bank" class="w-full h-10 bg-white border border-slate-200 rounded-xl px-3 text-xs focus:outline-none focus:border-[#640D5F]">
                                        <option value="BCA">Bank BCA (Account: 8830129381)</option>
                                        <option value="Mandiri">Bank Mandiri (Account: 112009381223)</option>
                                        <option value="BNI">Bank BNI (Account: 0293812838)</option>
                                        <option value="BRI">Bank BRI (Account: 00192838183)</option>
                                    </select>
                                    <input type="text" name="sender_account_name" placeholder="Sender Account Name" class="w-full h-10 bg-white border border-slate-200 rounded-xl px-3 text-xs focus:outline-none focus:border-[#640D5F]" required>
                                    <p class="text-[10px] text-slate-400 leading-normal">Transfer total amount to the selected bank account and enter your sender account name for verification.</p>
                                </div>

                                <!-- Credit Card -->
                                <div id="payment-credit_card" class="payment-details-panel space-y-3 bg-slate-50/50 p-4 rounded-xl border border-slate-200/40 hidden">
                                    <input type="text" placeholder="Card Number (16 digits)" maxlength="16" class="w-full h-10 bg-white border border-slate-200 rounded-xl px-3 text-xs focus:outline-none focus:border-[#640D5F]">
                                    <div class="grid grid-cols-2 gap-3">
                                        <input type="text" placeholder="MM/YY" maxlength="5" class="w-full h-10 bg-white border border-slate-200 rounded-xl px-3 text-xs focus:outline-none focus:border-[#640D5F]">
                                        <input type="text" placeholder="CVV" maxlength="3" class="w-full h-10 bg-white border border-slate-200 rounded-xl px-3 text-xs focus:outline-none focus:border-[#640D5F]">
                                    </div>
                                    <input type="text" placeholder="Cardholder Name" class="w-full h-10 bg-white border border-slate-200 rounded-xl px-3 text-xs focus:outline-none focus:border-[#640D5F]">
                                </div>

                                <!-- PayPal -->
                                <div id="payment-paypal" class="payment-details-panel space-y-3 bg-slate-50/50 p-4 rounded-xl border border-slate-200/40 hidden">
                                    <input type="email" placeholder="PayPal Email Address" class="w-full h-10 bg-white border border-slate-200 rounded-xl px-3 text-xs focus:outline-none focus:border-[#640D5F]">
                                    <p class="text-[10px] text-slate-400 leading-normal">You will be redirected to PayPal authorization upon clicking confirm.</p>
                                </div>

                                <!-- Total Pricing Row -->
                                <div class="flex justify-between items-center py-2.5 border-t border-slate-50 mt-4">
                                    <span class="text-sm font-semibold text-slate-500">Total Price</span>
                                    <span id="total-price" class="text-lg font-extrabold text-[#640D5F]">
                                        @if ($event->price > 0)
                                            Rp{{ number_format($event->price, 0, ',', '.') }}
                                        @else
                                            Free
                                        @endif
                                    </span>
                                </div>

                                <!-- Action Buttons -->
                                <div class="grid grid-cols-1 gap-2 pt-2">
                                    <button 
                                        type="submit" 
                                        class="w-full bg-gradient-to-r from-[#640D5F] to-[#1B1464] text-white py-3 px-4 rounded-xl font-bold hover:brightness-110 shadow-lg active:scale-98 transition duration-200 flex items-center justify-center gap-2">
                                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                                        <span>Confirm Reservation</span>
                                    </button>
                                </div>
                            </form>

                            <!-- Add to Favorites Form -->
                            <form action="{{ route('favorites.store') }}" method="POST" class="pt-2">
                                @csrf
                                <input type="hidden" name="event_id" value="{{ $event->id }}">
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <button 
                                    type="submit" 
                                    class="w-full bg-slate-50 border border-slate-200 text-slate-600 hover:text-rose-600 hover:bg-rose-50/30 hover:border-rose-200 py-2.5 px-4 rounded-xl font-medium transition duration-200 flex items-center justify-center gap-2">
                                    <i data-lucide="heart" class="w-4 h-4"></i>
                                    <span>Save to Favorites</span>
                                </button>
                            </form>
                        @else
                            <!-- Guest CTA Button -->
                            <div class="space-y-4">
                                <p class="text-xs text-slate-500 text-center leading-relaxed">Login to reserve your spots and access complete ticketing history.</p>
                                <a 
                                    href="{{ route('login') }}" 
                                    class="w-full bg-slate-800 text-white py-3 px-4 rounded-xl font-bold hover:bg-slate-900 active:scale-98 transition duration-200 flex items-center justify-center gap-2">
                                    <i data-lucide="log-in" class="w-4 h-4"></i>
                                    <span>Login to Reserve</span>
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-12 mt-20">
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

    <!-- JavaScript -->
    <script>
        let ticketQuantity = 1;
        const pricePerUnit = {{ $event->price }};

        // Function to update the ticket quantity and total price
        function updateQuantity(change) {
            ticketQuantity += change;
            if (ticketQuantity < 1) ticketQuantity = 1;

            const quantityElement = document.getElementById('ticket-quantity');
            const hiddenQuantityInput = document.getElementById('quantity');
            const totalPriceElement = document.getElementById('total-price');
            
            if (quantityElement) quantityElement.innerText = ticketQuantity;
            if (hiddenQuantityInput) hiddenQuantityInput.value = ticketQuantity;
            
            if (totalPriceElement) {
                if (pricePerUnit > 0) {
                    totalPriceElement.innerText = formatRupiah(pricePerUnit * ticketQuantity);
                } else {
                    totalPriceElement.innerText = 'Free';
                }
            }
        }
        
        // Function to format numbers to Rupiah currency format
        function formatRupiah(amount) {
            return 'Rp' + amount.toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
        }

        // Toggle payment details panel based on selected method
        function togglePaymentFields(value) {
            document.querySelectorAll('.payment-details-panel').forEach(panel => {
                panel.classList.add('hidden');
            });
            const selectedPanel = document.getElementById('payment-' + value);
            if (selectedPanel) {
                selectedPanel.classList.remove('hidden');
            }
        }
        
        lucide.createIcons();
    </script>
</body>

</html>
