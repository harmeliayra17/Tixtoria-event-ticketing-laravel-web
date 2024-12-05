@extends('admin.partials.sidebar')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-0">
    <!-- KPI Cards -->
    <div class="grid grid-cols-3 gap-4 mt-2">

        <!-- Card 1: Total Sales -->
        <div class="bg-gradient-to-r from-[#640D5F] to-[#1B1464] shadow p-6 rounded-lg flex flex-col justify-between items-center">
            <span class="material-icons text-4xl mb-2 text-white">attach_money</span>
            <h3 class="text-lg font-semibold text-white">Total Sales</h3>
            <p class="text-2xl font-bold text-white mt-2">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
        </div>
    
        <!-- Card 2: Tickets Sold -->
        <div class="bg-gradient-to-r from-[#640D5F] to-[#1B1464] shadow p-6 rounded-lg flex flex-col justify-between items-center">
            <span class="material-icons text-4xl mb-2 text-white">confirmation_number</span>
            <h3 class="text-lg font-semibold text-white">Tickets Sold</h3>
            <p class="text-2xl font-bold text-white mt-2">{{ $totalTicketsSold }}</p>
        </div>
    
        <!-- Card 3: Total Events -->
        <div class="bg-gradient-to-r from-[#640D5F] to-[#1B1464] shadow p-6 rounded-lg flex flex-col justify-between items-center">
            <span class="material-icons text-4xl mb-2 text-white">event</span>
            <h3 class="text-lg font-semibold text-white">Total Events</h3>
            <p class="text-2xl font-bold text-white mt-2">{{ $totalEvents }}</p>
        </div>
    
    </div>
  

    <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Line Chart: Tickets Sold Per Day -->
      <div class="mt-8 bg-white shadow rounded-lg p-6">
          <h3 class="text-lg font-semibold text-gray-700">Tickets Sold Per Day</h3>
          <canvas id="ticketsPerDayChart" class="w-full h-64"></canvas>
      </div>

      <!-- Donut Chart: Sales by Event -->
      <div class="mt-8 bg-white shadow rounded-lg p-6">
          <h3 class="text-lg font-semibold text-gray-700">Ticket Sales by Event</h3>
          <canvas id="ticketSalesByEventChart" class="w-full h-64"></canvas>
      </div>

      <!-- Bar Chart: Sales vs Tickets Sold -->
      <div class="mt-8 bg-white shadow rounded-lg p-6">
          <h3 class="text-lg font-semibold text-gray-700">Sales vs Tickets Sold</h3>
          <canvas id="salesVsTicketsChart" class="w-full h-64"></canvas>
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
                fill: false,
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { x: { title: { text: 'Date', display: true } }, y: { beginAtZero: true } }
        }
    });

    // Donut Chart: Ticket Sales by Event
    const ticketSalesByEventChart = new Chart(document.getElementById('ticketSalesByEventChart'), {
      type: 'doughnut',
      data: {
          labels: {!! json_encode($eventSales->keys()) !!}, // Tetap disertakan dalam data, tapi tidak ditampilkan
          datasets: [{
              data: {!! json_encode($eventSales->values()) !!},
              backgroundColor: ['#640D5F', '#1B1464', '#FFC107', '#4CAF50']
          }]
      },
      options: {
          responsive: true,
          plugins: {
              legend: { display: false } // Menyembunyikan legenda
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
                    backgroundColor: '#640D5F'
                },
                {
                    label: 'Tickets Sold',
                    data: {!! json_encode($ticketsSold) !!},
                    backgroundColor: '#1B1464'
                }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'top' } },
            scales: { x: { beginAtZero: true }, y: { beginAtZero: true } }
        }
    });
</script>
@endsection
