@extends('admin.partials.sidebar')

@section('title', 'Reports')

@section('content')
<div class="container mx-auto px-0">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Total Sales -->
        <div class="bg-gradient-to-r from-[#640D5F] to-[#1B1464] shadow p-6 rounded-lg flex flex-col justify-between items-center">
            <h3 class="text-lg font-semibold text-white">Total Sales</h3>
            <p class="text-2xl font-bold text-white mt-2">
                Rp {{ number_format($totalSales, 0, ',', '.') }}
            </p>
        </div>

        <!-- Total Tickets Sold -->
        <div class="bg-gradient-to-r from-[#640D5F] to-[#1B1464] shadow p-6 rounded-lg flex flex-col justify-between items-center">
            <h3 class="text-lg font-semibold text-white">Tickets Sold</h3>
            <p class="text-2xl font-bold text-white mt-2">
                {{ $totalTicketsSold }}
            </p>
        </div>        
    </div>

    <div class="p-6 rounded-lg shadow bg-gradient-to-r from-[#640D5F] to-[#1B1464] mt-8">
        <h3 class="text-lg font-semibold text-white mb-4">🎉 Top 5 Events</h3>
        <ul class="space-y-3">
            @foreach ($topEvents as $event)
                <li class="flex items-center bg-white rounded-lg shadow p-4">
                    <div class="w-10 h-10 flex items-center justify-center rounded-full bg-gradient-to-r from-[#172c6d] to-[#713461] text-white font-bold">
                        {{ $loop->iteration }}
                    </div>
                    <div class="ml-4">
                        <p class="text-lg font-semibold text-[#640D5F]">{{ $event->title }}</p>
                        <p class="text-sm text-gray-600">{{ $event->total_tickets }} tickets sold</p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>    


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
