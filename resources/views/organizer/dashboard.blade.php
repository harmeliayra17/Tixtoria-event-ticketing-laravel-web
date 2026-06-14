@extends('organizer.partials.sidebar')

@section('title', 'Organizer Dashboard')

@section('content')
<div class="space-y-6 pb-12">
    
    <div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-[#1B1464]/5 text-[#1B1464] flex items-center justify-center flex-shrink-0">
                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
            </div>
            <p class="text-xs text-slate-500">Review event performances, total revenues, and upcoming schedules.</p>
        </div>
        <div class="flex items-center gap-1.5 text-xs font-semibold text-slate-400 bg-slate-50 border border-slate-200/60 rounded-xl px-4 py-2">
            <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i>
            <span>{{ now()->format('l, d F Y') }}</span>
        </div>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Total Events</span>
                <h3 class="text-3xl font-extrabold text-[#1B1464] mt-2">{{ $totalEvents }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[#640D5F]/5 flex items-center justify-center">
                <i data-lucide="calendar" class="w-6 h-6 text-[#640D5F]"></i>
            </div>
        </div>

        
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Tickets Sold</span>
                <h3 class="text-3xl font-extrabold text-[#1B1464] mt-2">{{ $totalTicketsSold }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[#640D5F]/5 flex items-center justify-center">
                <i data-lucide="ticket" class="w-6 h-6 text-[#640D5F]"></i>
            </div>
        </div>

        
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Total Revenue</span>
                <h3 class="text-2xl font-extrabold text-[#640D5F] mt-2">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[#640D5F]/5 flex items-center justify-center">
                <i data-lucide="dollar-sign" class="w-6 h-6 text-[#640D5F]"></i>
            </div>
        </div>
    </div>

    
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h3 class="text-lg font-bold text-[#1B1464]">Upcoming Events</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">
                        <th class="p-4 pl-6">Event</th>
                        <th class="p-4">Date</th>
                        <th class="p-4 text-center">Tickets Sold</th>
                        <th class="p-4 text-center">Revenue</th>
                        <th class="p-4 pr-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($upcomingEvents as $event)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4 pl-6 font-bold text-slate-800">{{ $event->title }}</td>
                            <td class="p-4 text-slate-500">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</td>
                            <td class="p-4 text-center font-semibold text-slate-700">{{ $event->tickets_sold }}</td>
                            <td class="p-4 text-center font-bold text-[#640D5F]">Rp{{ number_format($event->revenue, 0, ',', '.') }}</td>
                            <td class="p-4 pr-6 text-center">
                                <a href="{{ route('organizer.editEvent', $event->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-50 border border-slate-200 text-slate-600 hover:text-[#640D5F] hover:border-[#640D5F]/30 rounded-xl text-xs font-semibold transition">
                                    <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                                    <span>Edit</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-12 text-slate-400">
                                <i data-lucide="calendar" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                                <span>No upcoming events</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-5 flex flex-col justify-between">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Tickets Sold Per Event</h3>
            <div class="h-56 relative w-full">
                <canvas id="ticketsChart"></canvas>
            </div>
        </div>

        
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-5 flex flex-col justify-between">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Revenue Per Event</h3>
            <div class="h-56 relative w-full">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    
    const ticketsChart = new Chart(document.getElementById('ticketsChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($eventNames) !!},
            datasets: [{
                label: 'Tickets Sold',
                data: {!! json_encode($eventTicketsSold) !!},
                backgroundColor: '#640D5F',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { x: { grid: { display: false } }, y: { beginAtZero: true } }
        }
    });

    
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
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endsection
