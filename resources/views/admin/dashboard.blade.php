@extends('admin.partials.sidebar')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-6 pb-12">
    <!-- Header -->
    <div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-[#1B1464]/5 text-[#1B1464] flex items-center justify-center flex-shrink-0">
                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
            </div>
            <p class="text-xs text-slate-500">Global statistics, ticketing counts, event distributions, and system overview.</p>
        </div>
        <div class="flex items-center gap-1.5 text-xs font-semibold text-slate-400 bg-slate-50 border border-slate-200/60 rounded-xl px-4 py-2">
            <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i>
            <span>{{ now()->format('l, d F Y') }}</span>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1: Total Sales -->
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Total Sales</span>
                <h3 class="text-2xl font-extrabold text-[#640D5F] mt-2">Rp{{ number_format($totalSales, 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[#640D5F]/5 flex items-center justify-center">
                <i data-lucide="dollar-sign" class="w-6 h-6 text-[#640D5F]"></i>
            </div>
        </div>
    
        <!-- Card 2: Tickets Sold -->
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Tickets Sold</span>
                <h3 class="text-3xl font-extrabold text-[#1B1464] mt-2">{{ $totalTicketsSold }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[#640D5F]/5 flex items-center justify-center">
                <i data-lucide="ticket" class="w-6 h-6 text-[#1B1464]"></i>
            </div>
        </div>
    
        <!-- Card 3: Total Events -->
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Total Events</span>
                <h3 class="text-3xl font-extrabold text-[#1B1464] mt-2">{{ $totalEvents }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[#640D5F]/5 flex items-center justify-center">
                <i data-lucide="calendar" class="w-6 h-6 text-[#1B1464]"></i>
            </div>
        </div>
    </div>
  
    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Line Chart: Tickets Sold Per Day -->
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-5 flex flex-col justify-between">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Tickets Sold Per Day</h3>
            <div class="h-56 relative w-full">
                <canvas id="ticketsPerDayChart"></canvas>
            </div>
        </div>

        <!-- Donut Chart: Sales by Event -->
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-5 flex flex-col justify-between">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Ticket Sales by Event</h3>
            <div class="h-56 relative w-full">
                <canvas id="ticketSalesByEventChart"></canvas>
            </div>
        </div>

        <!-- Bar Chart: Sales vs Tickets Sold -->
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-5 flex flex-col justify-between">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Sales vs Tickets Sold</h3>
            <div class="h-56 relative w-full">
                <canvas id="salesVsTicketsChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Line Chart: Tickets Sold Per Day
    const ticketsPerDayChart = new Chart(document.getElementById('ticketsPerDayChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($dates) !!},
            datasets: [{
                label: 'Tickets Sold',
                data: {!! json_encode($ticketsSold) !!},
                borderColor: '#640D5F',
                backgroundColor: 'rgba(100, 13, 95, 0.05)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { x: { grid: { display: false } }, y: { beginAtZero: true } }
        }
    });

    // Donut Chart: Ticket Sales by Event
    const ticketSalesByEventChart = new Chart(document.getElementById('ticketSalesByEventChart'), {
      type: 'doughnut',
      data: {
          labels: {!! json_encode($eventSales->keys()) !!},
          datasets: [{
              data: {!! json_encode($eventSales->values()) !!},
              backgroundColor: ['#640D5F', '#1B1464', '#FFC107', '#4CAF50']
          }]
      },
      options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
              legend: { position: 'bottom' }
          }
      }
  });

    // Bar Chart: Sales vs Tickets Sold
    const salesVsTicketsChart = new Chart(document.getElementById('salesVsTicketsChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($eventNames) !!},
            datasets: [
                {
                    label: 'Sales (Rp)',
                    data: {!! json_encode($eventSales->values()) !!},
                    backgroundColor: '#640D5F',
                    borderRadius: 6
                },
                {
                    label: 'Tickets Sold',
                    data: {!! json_encode($ticketsSold) !!},
                    backgroundColor: '#1B1464',
                    borderRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'top' } },
            scales: { x: { grid: { display: false } }, y: { beginAtZero: true } }
        }
    });
</script>
@endsection
