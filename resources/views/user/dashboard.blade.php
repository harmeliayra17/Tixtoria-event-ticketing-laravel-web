@extends('user.partials.sidebar')

@section('title', 'Profile Hub')

@section('content')
<div class="space-y-6 pb-12 w-full">
    <!-- Welcome Header -->
    <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">
                <i data-lucide="sparkles" class="w-6 h-6 text-[#1B1464]"></i>
            </div>
            <div>
                <h2 class="text-2xl font-extrabold text-[#1B1464] tracking-tight">Welcome back, {{ $user->name }}!</h2>
                <p class="text-sm text-slate-500 mt-0.5">Manage your tickets, review event schedules, and track your favorites all in one place.</p>
            </div>
        </div>
    </div>

    <!-- Quick Navigation Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Tickets Summary Card -->
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Total Bookings</span>
                <h3 class="text-3xl font-extrabold text-[#1B1464] mt-2">{{ $bookingsCount }}</h3>
                <a href="{{ route('user.ticket') }}" class="text-xs font-bold text-[#640D5F] hover:text-[#1B1464] transition flex items-center gap-1 mt-3">
                    <span>View Ticket History</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center">
                <i data-lucide="ticket" class="w-7 h-7 text-[#1B1464]"></i>
            </div>
        </div>

        <!-- Favorites Summary Card -->
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Saved Favorites</span>
                <h3 class="text-3xl font-extrabold text-[#1B1464] mt-2">{{ $favoritesCount }}</h3>
                <a href="{{ route('user.favorites') }}" class="text-xs font-bold text-[#640D5F] hover:text-[#1B1464] transition flex items-center gap-1 mt-3">
                    <span>View Favorites</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-rose-50 flex items-center justify-center">
                <i data-lucide="heart" class="w-7 h-7 text-rose-500"></i>
            </div>
        </div>
    </div>

    <!-- Dashboard Content Area (Split Grid) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Column 1: Recent Tickets -->
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm flex flex-col justify-between overflow-hidden">
            <div>
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <i data-lucide="ticket" class="w-5 h-5 text-[#1B1464]"></i>
                        <span>Recent Tickets</span>
                    </h3>
                    <a href="{{ route('user.ticket') }}" class="text-xs font-semibold text-[#640D5F] hover:text-[#1B1464] transition">View All</a>
                </div>
                
                @if($recentBookings->isEmpty())
                    <div class="text-center py-12 px-6">
                        <i data-lucide="ticket" class="w-10 h-10 text-slate-300 mx-auto mb-3 opacity-60"></i>
                        <p class="text-slate-500 text-xs">You have not booked any tickets yet.</p>
                        <a href="{{ route('eventCatalog') }}" class="mt-4 inline-flex items-center gap-1.5 bg-[#640D5F] text-white px-4 py-2 rounded-xl text-[11px] font-semibold hover:brightness-110 transition">Browse Catalog</a>
                    </div>
                @else
                    <div class="divide-y divide-slate-100">
                        @foreach ($recentBookings as $booking)
                            <div class="p-5 flex items-center justify-between hover:bg-slate-50/30 transition">
                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm line-clamp-1">{{ $booking->event->title }}</h4>
                                    <div class="flex items-center gap-3 text-xs text-slate-400 mt-1.5 flex-wrap">
                                        <span class="flex items-center gap-1">
                                            <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                            <span>{{ date('d M Y', strtotime($booking->event->date)) }}</span>
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <i data-lucide="user" class="w-3.5 h-3.5"></i>
                                            <span>Qty: {{ $booking->quantity }}</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 flex-shrink-0">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold uppercase tracking-wider
                                        @if($booking->status === 'pending') bg-amber-50 text-amber-600 border border-amber-200
                                        @elseif($booking->status === 'confirmed') bg-emerald-50 text-emerald-600 border border-emerald-200
                                        @elseif($booking->status === 'cancelled') bg-rose-50 text-rose-600 border border-rose-200
                                        @endif">
                                        {{ $booking->status }}
                                    </span>
                                    @if($booking->status === 'confirmed')
                                        <a href="{{ route('user.bookings.invoice', $booking->id) }}" target="_blank"
                                           class="p-1.5 bg-indigo-50 border border-indigo-100 text-indigo-600 hover:bg-indigo-100/50 rounded-xl transition"
                                           title="Print Invoice">
                                            <i data-lucide="printer" class="w-4 h-4"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Column 2: Recent Favorites -->
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm flex flex-col justify-between overflow-hidden">
            <div>
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <i data-lucide="heart" class="w-5 h-5 text-rose-500"></i>
                        <span>Recent Favorites</span>
                    </h3>
                    <a href="{{ route('user.favorites') }}" class="text-xs font-semibold text-[#640D5F] hover:text-[#1B1464] transition">View All</a>
                </div>
                
                @if($recentFavorites->isEmpty())
                    <div class="text-center py-12 px-6">
                        <i data-lucide="heart" class="w-10 h-10 text-slate-300 mx-auto mb-3 opacity-60"></i>
                        <p class="text-slate-500 text-xs">No saved events in your favorites yet.</p>
                        <a href="{{ route('eventCatalog') }}" class="mt-4 inline-flex items-center gap-1.5 bg-[#640D5F] text-white px-4 py-2 rounded-xl text-[11px] font-semibold hover:brightness-110 transition">Discover Events</a>
                    </div>
                @else
                    <div class="divide-y divide-slate-100">
                        @foreach ($recentFavorites as $favorite)
                            @if($favorite->event)
                                <div class="p-5 flex items-center justify-between hover:bg-slate-50/30 transition">
                                    <div class="max-w-[70%]">
                                        <h4 class="font-bold text-slate-800 text-sm line-clamp-1">{{ $favorite->event->title }}</h4>
                                        <div class="flex items-center gap-3 text-xs text-slate-400 mt-1.5 flex-wrap">
                                            <span class="inline-block px-2 py-0.5 bg-slate-100 text-[#640D5F] text-[9px] font-bold uppercase tracking-wider rounded-md">
                                                {{ $favorite->event->category->name }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                                <span>{{ date('d M Y', strtotime($favorite->event->date)) }}</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 text-right">
                                        <div class="text-xs font-bold text-[#640D5F]">
                                            @if($favorite->event->price > 0)
                                                Rp{{ number_format($favorite->event->price, 0, ',', '.') }}
                                            @else
                                                Free
                                            @endif
                                        </div>
                                        <a href="{{ route('events.show', $favorite->event->id) }}" class="inline-flex items-center gap-0.5 text-[10px] font-bold text-indigo-600 hover:text-[#1B1464] transition mt-1">
                                            <span>Book Now</span>
                                            <i data-lucide="chevron-right" class="w-3 h-3"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
