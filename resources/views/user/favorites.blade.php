@extends('user.partials.sidebar')

@section('title', 'My Favorites')

@section('content')
<div class="w-full pb-12">
    <!-- Header Summary Card -->
    <div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm mb-6 flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-500 flex items-center justify-center flex-shrink-0">
            <i data-lucide="heart" class="w-4 h-4"></i>
        </div>
        <p class="text-xs text-slate-500">Easily access events you have bookmarked for later.</p>
    </div>
    
    @if($favorites->isEmpty())
        <div class="text-center py-16 bg-white border border-slate-100 rounded-2xl shadow-sm">
            <i data-lucide="heart" class="w-12 h-12 text-slate-300 mx-auto mb-4"></i>
            <h3 class="text-lg font-bold text-slate-700">No Favorites Yet</h3>
            <p class="text-slate-500 mt-2 text-xs">Explore the event catalog and bookmark events you love.</p>
            <a href="{{ route('eventCatalog') }}" class="mt-6 inline-flex items-center gap-2 bg-[#640D5F] text-white px-6 py-2.5 rounded-xl text-xs font-semibold hover:brightness-110 transition">Browse Catalog</a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($favorites as $favorite)
                @if($favorite->event)
                    <a href="{{ route('events.show', $favorite->event->id) }}" class="group bg-white border border-slate-100 rounded-2xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between h-full relative">
                        <!-- Image & Category Badge -->
                        <div class="relative overflow-hidden h-48 bg-slate-100">
                            <img src="{{ Str::startsWith($favorite->event->image, ['http://', 'https://']) ? $favorite->event->image : ($favorite->event->image ? asset($favorite->event->image) : 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=800&auto=format&fit=crop&q=80') }}" alt="{{ $favorite->event->title }}" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <span class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm text-[#640D5F] text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow-sm">
                                {{ $favorite->event->category->name }}
                            </span>
                        </div>
                        
                        <!-- Details -->
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-1.5 text-[#640D5F] text-xs font-semibold">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                    <span>{{ date('D, d M Y', strtotime($favorite->event->date)) }}</span>
                                </div>
                                <h3 class="text-base font-bold text-slate-900 mt-2.5 group-hover:text-[#640D5F] transition-colors line-clamp-1">{{ $favorite->event->title }}</h3>
                                <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ Str::limit($favorite->event->description, 100) }}</p>
                            </div>
                            
                            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="text-[9px] text-slate-400 font-medium uppercase tracking-wider">Price</span>
                                    <span class="text-sm font-extrabold text-[#640D5F]">
                                        @if ($favorite->event->price > 0)
                                            Rp{{ number_format($favorite->event->price, 0, ',', '.') }}
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
                @endif
            @endforeach
        </div>
    @endif
</div>
@endsection
