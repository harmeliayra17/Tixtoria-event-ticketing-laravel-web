@extends('admin.partials.sidebar')

@section('title', 'Reports')

@section('content')
<div class="space-y-6 pb-12 w-full animate-fade-in">
    
    <div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-[#640D5F]/5 text-[#640D5F] flex items-center justify-center flex-shrink-0">
            <i data-lucide="bar-chart-3" class="w-4 h-4"></i>
        </div>
        <p class="text-xs text-slate-500">Platform-wide sales metrics, ticket statistics, and top performing events.</p>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Total Revenue Generated</span>
                <h3 class="text-3xl font-extrabold text-[#640D5F] mt-2">Rp{{ number_format($totalSales, 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[#640D5F]/5 flex items-center justify-center">
                <i data-lucide="dollar-sign" class="w-6 h-6 text-[#640D5F]"></i>
            </div>
        </div>

        
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Total Tickets Distributed</span>
                <h3 class="text-3xl font-extrabold text-[#1B1464] mt-2">{{ $totalTicketsSold }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[#1B1464]/5 flex items-center justify-center">
                <i data-lucide="ticket" class="w-6 h-6 text-[#1B1464]"></i>
            </div>
        </div>
    </div>

    
    <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
        <h3 class="text-base font-bold text-slate-800 mb-6 flex items-center gap-2">
            <i data-lucide="trophy" class="w-5 h-5 text-amber-500"></i>
            <span>Top 5 Performing Events</span>
        </h3>
        
        <ul class="divide-y divide-slate-100">
            @forelse ($topEvents as $event)
                <li class="py-4 first:pt-0 last:pb-0 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        
                        <div class="w-9 h-9 flex items-center justify-center rounded-xl font-bold text-sm shadow-sm
                            @if($loop->iteration == 1) bg-amber-50 text-amber-600 border border-amber-200
                            @elseif($loop->iteration == 2) bg-slate-50 text-slate-600 border border-slate-200
                            @elseif($loop->iteration == 3) bg-orange-50 text-orange-600 border border-orange-200
                            @else bg-slate-50 text-slate-400 border border-slate-100
                            @endif">
                            {{ $loop->iteration }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800 hover:text-[#640D5F] transition">{{ $event->title }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">Global ticket release</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center gap-1 bg-[#1B1464]/5 text-[#1B1464] text-xs font-bold px-3 py-1 rounded-full">
                            <i data-lucide="ticket" class="w-3.5 h-3.5"></i>
                            <span>{{ $event->total_tickets }} sold</span>
                        </span>
                    </div>
                </li>
            @empty
                <li class="text-center py-10 text-slate-400 text-sm">
                    No tickets have been sold yet to rank events.
                </li>
            @endforelse
        </ul>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        lucide.createIcons();
    });
</script>
@endsection
