@extends('organizer.partials.sidebar')

@section('title', 'Organizer Dashboard')

@section('content')
<div class="container mx-auto px-4">
    <!-- Header -->
    <div class="flex justify-between items-center mt-4">
        <h2 class="text-2xl font-bold text-gray-800">Organizer Dashboard</h2>
        <p class="text-sm text-gray-600">Today is {{ now()->format('l, d F Y') }}</p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
        <!-- Total Events -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-700">Total Events</h3>
            <p class="text-2xl font-bold text-[#640D5F] mt-2">{{ $totalEvents }}</p>
        </div>

        <!-- Tickets Sold -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-700">Tickets Sold</h3>
            <p class="text-2xl font-bold text-[#640D5F] mt-2">{{ $totalTicketsSold }}</p>
        </div>

        <!-- Revenue -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-700">Total Revenue</h3>
            <p class="text-2xl font-bold text-[#640D5F] mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Events Table -->
    <div class="mt-8 bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Upcoming Events</h3>
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="text-left text-sm text-gray-700 border-b">
                    <th class="py-2 px-4">Event</th>
                    <th class="py-2 px-4">Date</th>
                    <th class="py-2 px-4">Tickets Sold</th>
                    <th class="py-2 px-4">Revenue</th>
                    <th class="py-2 px-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($upcomingEvents as $event)
                    <tr class="text-sm text-gray-700 border-b">
                        <td class="py-2 px-4">{{ $event->title }}</td>
                        <td class="py-2 px-4">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</td>
                        <td class="py-2 px-4">{{ $event->tickets_sold }}</td>
                        <td class="py-2 px-4">Rp {{ number_format($event->revenue, 0, ',', '.') }}</td>
                        <td class="py-2 px-4 text-center">
                            <a href="{{ route('organizer.editEvent', $event->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">No upcoming events</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
        <!-- Tickets Sold Per Event Chart -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-700">Tickets Sold Per Event</h3>
            <canvas id="ticketsChart"></canvas>
        </div>

        <!-- Revenue Per Event Chart -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-700">Revenue Per Event</h3>
            <canvas id="revenueChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Tickets Sold Per Event Chart
    const ticketsChart = new Chart(document.getElementById('ticketsChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($eventNames) !!},
            datasets: [{
                label: 'Tickets Sold',
                data: {!! json_encode($eventTicketsSold) !!},
                backgroundColor: '#640D5F'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { x: { beginAtZero: true }, y: { beginAtZero: true } }
        }
    });

    // Revenue Per Event Chart
    const revenueChart = new Chart(document.getElementById('revenueChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($eventNames) !!},
            datasets: [{
                data: {!! json_encode($eventRevenues) !!},
                backgroundColor: ['#640D5F', '#1B1464', '#FFC107', '#4CAF50']
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'top' } }
        }
    });
</script>
@endsection
