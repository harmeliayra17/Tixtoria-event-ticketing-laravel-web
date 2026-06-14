<header x-data="{ mobileMenuOpen: false }" class="bg-white/95 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50 transition-all duration-300">
    <div class="mx-auto px-6 lg:px-20 py-4 flex justify-between gap-6 items-center">
        
        <a href="{{ url('/') }}" class="flex items-center shrink-0">
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

        
        <div class="hidden lg:flex items-center">
            @auth
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" 
                        class="text-[#640D5F] px-4 py-2 rounded-full flex items-center space-x-2 hover:bg-slate-50 border border-[#640D5F]/20 font-medium text-sm transition focus:outline-none">
                    <span>{{ Auth::user()->name }}</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}"></i>
                </button>
            
                
                <div x-show="open" 
                     @click.away="open = false" 
                     class="absolute right-0 mt-2 w-48 bg-white border border-slate-100 rounded-2xl shadow-xl z-50 overflow-hidden"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-95"
                     style="display: none;">
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
                <a href="{{ route('login') }}" class="bg-gradient-to-r from-[#640D5F] to-[#1B1464] text-white text-sm font-semibold px-6 py-2.5 rounded-full hover:shadow-lg hover:brightness-110 transition">
                    Login/Register
                </a>
            @endauth              
        </div>

        
        <button @click="mobileMenuOpen = !mobileMenuOpen" 
                class="lg:hidden text-slate-700 hover:text-[#640D5F] focus:outline-none flex items-center p-2 rounded-lg hover:bg-slate-50 transition" 
                aria-label="Toggle menu">
            
            <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
            
            <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    
    <div x-show="mobileMenuOpen" 
         @click.away="mobileMenuOpen = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="lg:hidden bg-white border-t border-slate-100 shadow-xl absolute w-full left-0 z-40 overflow-hidden"
         style="display: none;">
        <div class="px-6 py-4 space-y-4">
            <nav class="flex flex-col space-y-3">
                <a href="{{ url('/') }}" class="text-sm font-semibold py-2 px-3 rounded-xl transition {{ Request::is('/') ? 'bg-[#640D5F]/10 text-[#640D5F]' : 'text-slate-700 hover:bg-slate-50 hover:text-[#640D5F]' }}">
                    Home
                </a>
                <a href="{{ route('eventCatalog') }}" class="text-sm font-semibold py-2 px-3 rounded-xl transition {{ Request::is('eventCatalog') ? 'bg-[#640D5F]/10 text-[#640D5F]' : 'text-slate-700 hover:bg-slate-50 hover:text-[#640D5F]' }}">
                    Event Catalog
                </a>
                <a href="{{ url('/about') }}" class="text-sm font-semibold py-2 px-3 rounded-xl transition {{ Request::is('about') ? 'bg-[#640D5F]/10 text-[#640D5F]' : 'text-slate-700 hover:bg-slate-50 hover:text-[#640D5F]' }}">
                    About
                </a>
                <a href="{{ url('/contact') }}" class="text-sm font-semibold py-2 px-3 rounded-xl transition {{ Request::is('contact') ? 'bg-[#640D5F]/10 text-[#640D5F]' : 'text-slate-700 hover:bg-slate-50 hover:text-[#640D5F]' }}">
                    Contact
                </a>
            </nav>
            <div class="pt-4 border-t border-slate-100">
                @auth
                    <div class="px-3 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">
                        Signed in as {{ Auth::user()->name }}
                    </div>
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="block text-sm font-semibold py-2 px-3 text-slate-700 hover:bg-slate-50 hover:text-[#640D5F] rounded-xl transition">Dashboard</a>
                    @elseif(Auth::user()->role === 'organizer')
                        <a href="{{ route('organizer.dashboard') }}" class="block text-sm font-semibold py-2 px-3 text-slate-700 hover:bg-slate-50 hover:text-[#640D5F] rounded-xl transition">Dashboard</a>
                    @else
                        <a href="{{ route('user.dashboard') }}" class="block text-sm font-semibold py-2 px-3 text-slate-700 hover:bg-slate-50 hover:text-[#640D5F] rounded-xl transition">Dashboard</a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="w-full text-left text-sm font-semibold py-2 px-3 text-red-600 hover:bg-red-50 rounded-xl transition">
                            Log Out
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block text-center bg-gradient-to-r from-[#640D5F] to-[#1B1464] text-white text-sm font-bold py-3 px-4 rounded-xl hover:shadow-lg transition">
                        Login/Register
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>
