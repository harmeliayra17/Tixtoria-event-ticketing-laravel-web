<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
  <title>{{ config('app.name', 'Tixtoria') }}</title>
  <link class="rounded-md" rel="icon" href="{{ asset('images/logo.ico') }}" type="image/x-icon">

  <style>
    .sidebar-bg {
      background: linear-gradient(to bottom, #1B1464, #640D5F);
      mix-blend-mode: normal;
    }
    aside {
      position: fixed;
    }
    a {
      font-size: 14px;
    }
    .navbar {
      position: fixed;
    }
    .wrapper {
      margin-left: 215px; 
      height: 100vh;
      overflow-y: auto;
      width: calc(100% - 215px);
    }
    body {
      font-family: 'Poppins', sans-serif;
      color: #1B1464;
    }
    .active {
      background-color: white;
      color: #1B1464;
      font-weight: 600;
      border-radius: 0.5rem;
    }
    ::-webkit-scrollbar {
      width: 8px; 
    }
    ::-webkit-scrollbar-track {
      background: #f1f1f1;
    }
    ::-webkit-scrollbar-thumb {
      background-color: #640D5F; 
      border-radius: 4px; 
    }
  </style>
</head>
<body class="flex bg-slate-50 h-screen overflow-hidden">

  <!-- Sidebar -->
  <aside class="sidebar-bg w-[215px] h-full text-white flex flex-col z-40 shadow-xl">
    <div class="p-6 flex items-center border-b border-white/10">
      <img src="{{ asset('images/logo-wht.png') }}" alt="Tixtoria Logo" class="h-8 rounded-md">
    </div>
    <nav class="flex-1 px-3 mt-6">
      <ul class="space-y-2.5">
        <li>
          <a href="{{ url('/') }}" class="flex items-center px-4 py-2.5 rounded-lg text-white hover:bg-white/10 transition">
            <i data-lucide="home" class="w-5 h-5 mr-3"></i>
            Back to Home
          </a>
        </li>
        <div class="h-px bg-white/10 my-4"></div>
        <li>
          <a href="{{ route('user.dashboard') }}" class="flex items-center px-4 py-2.5 rounded-lg transition {{ Request::routeIs('user.dashboard') ? 'active bg-white text-[#1B1464] font-semibold' : 'text-white hover:bg-white/10' }}">
            <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></i>
            Profile Hub
          </a>
        </li>
        <li>
          <a href="{{ route('user.favorites') }}" class="flex items-center px-4 py-2.5 rounded-lg transition {{ Request::routeIs('user.favorites') ? 'active bg-white text-[#1B1464] font-semibold' : 'text-white hover:bg-white/10' }}">
            <i data-lucide="heart" class="w-5 h-5 mr-3"></i>
            Favorites
          </a>
        </li>       
        <li>
          <a href="{{ route('user.ticket') }}" class="flex items-center px-4 py-2.5 rounded-lg transition {{ Request::routeIs('user.ticket') || Request::routeIs('user.bookings.invoice') ? 'active bg-white text-[#1B1464] font-semibold' : 'text-white hover:bg-white/10' }}">
              <i data-lucide="ticket" class="w-5 h-5 mr-3"></i>
              Tickets
          </a>
        </li>
      </ul>
    </nav>      
  </aside>

  <!-- Main Content -->
  <div class="wrapper h-screen flex flex-col">
    <!-- Fixed Navbar -->
    <nav class="navbar bg-white border-b border-slate-100 fixed top-0 left-0 z-30 w-full p-4 flex items-center justify-between" style="margin-left: 215px; width: calc(100% - 215px);" x-data="{ openNotifications: false, openProfile: false }">
      <h1 id="page-title" class="text-lg font-bold text-[#1B1464] ml-5">@yield('title', 'Dashboard')</h1>

      <!-- Notifications and Profile -->
      <div class="flex items-center space-x-4 mr-5">
        <!-- Notification Dropdown -->
        <div class="relative">
          <button @click.stop="openNotifications = !openNotifications; openProfile = false" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50 rounded-full relative transition focus:outline-none">
            <i data-lucide="bell" class="w-5 h-5"></i>
            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full"></span>
          </button>
          <!-- Notification Dropdown Menu -->
          <div x-show="openNotifications" 
               @click.away="openNotifications = false" 
               class="absolute right-0 mt-2 w-80 bg-white border border-slate-100 rounded-2xl shadow-xl z-50 overflow-hidden"
               x-transition:enter="transition ease-out duration-200"
               x-transition:enter-start="opacity-0 transform scale-95"
               x-transition:enter-end="opacity-100 transform scale-100"
               x-transition:leave="transition ease-in duration-75"
               x-transition:leave-start="opacity-100 transform scale-100"
               x-transition:leave-end="opacity-0 transform scale-95"
               style="display: none;">
            <div class="p-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
              <span class="font-bold text-slate-800 text-xs">Notifications</span>
              <span class="text-[9px] bg-[#640D5F]/10 text-[#640D5F] font-bold px-2 py-0.5 rounded-full">1 New</span>
            </div>
            <div class="divide-y divide-slate-100 max-h-64 overflow-y-auto">
              <div class="p-4 flex gap-3 items-start hover:bg-slate-50/30 transition cursor-pointer">
                <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                  <i data-lucide="check" class="w-4 h-4"></i>
                </div>
                <div>
                  <p class="text-xs font-semibold text-slate-800">Booking Confirmed</p>
                  <p class="text-[10px] text-slate-500 mt-0.5">Your ticket is ready! Go to Tickets to download your invoice.</p>
                  <p class="text-[9px] text-slate-400 mt-1">Just now</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="h-6 w-px bg-slate-100"></div>

        <!-- Profile Dropdown -->
        <div class="relative">
          <button @click.stop="openProfile = !openProfile; openNotifications = false" class="flex items-center gap-2 focus:outline-none hover:opacity-90 transition">
            <img src="{{ $profileUrl ?? (Auth::user()->profile ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150&auto=format&fit=crop&q=80') }}" alt="Profile" class="w-9 h-9 rounded-full object-cover border border-slate-100 hover:ring-2 hover:ring-[#640D5F]/20 transition duration-200">
            <div class="flex flex-col text-left hidden md:flex">
              <span class="text-xs font-bold text-slate-700 line-clamp-1 leading-tight">{{ Auth::user()->name }}</span>
              <span class="text-[9px] text-indigo-600 font-extrabold tracking-wide uppercase mt-0.5">Client</span>
            </div>
            <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400 hidden md:inline"></i>
          </button>
          
          <!-- Profile Dropdown Menu -->
          <div x-show="openProfile" 
               @click.away="openProfile = false" 
               class="absolute right-0 mt-2 w-48 bg-white border border-slate-100 rounded-2xl shadow-xl z-50 overflow-hidden"
               x-transition:enter="transition ease-out duration-200"
               x-transition:enter-start="opacity-0 transform scale-95"
               x-transition:enter-end="opacity-100 transform scale-100"
               x-transition:leave="transition ease-in duration-75"
               x-transition:leave-start="opacity-100 transform scale-100"
               x-transition:leave-end="opacity-0 transform scale-95"
               style="display: none;">
            <div class="p-4 border-b border-slate-50 bg-slate-50/50">
              <p class="text-xs font-bold text-slate-800 line-clamp-1">{{ Auth::user()->name }}</p>
              <p class="text-[10px] text-slate-400 mt-0.5 line-clamp-1">{{ Auth::user()->email }}</p>
            </div>
            <div class="p-1">
              <a href="{{ route('user.profile.edit') }}" class="flex items-center gap-2 px-3 py-2.5 text-xs font-medium text-slate-600 hover:text-[#640D5F] hover:bg-slate-50 rounded-xl transition">
                <i data-lucide="settings" class="w-4 h-4"></i>
                <span>Edit Profile</span>
              </a>
              <div class="h-px bg-slate-100 my-1"></div>
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2.5 text-xs font-medium text-rose-600 hover:bg-rose-50/50 rounded-xl transition text-left">
                  <i data-lucide="log-out" class="w-4 h-4"></i>
                  <span>Log Out</span>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Scrollable Main Content -->
    <main class="flex-1 pt-24 p-8 bg-slate-50 overflow-auto">
      @yield('content')
    </main>
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      lucide.createIcons();
    });
  </script>
</body>
</html>
