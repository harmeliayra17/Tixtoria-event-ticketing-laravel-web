@extends('organizer.partials.sidebar')

@section('title', 'Manage Tickets')

@section('content')
<style>
    select[name="status"][data-status="pending"] {
    background-color: orange;
    color: white;
    }

    select[name="status"][data-status="confirmed"] {
    background-color: green;
    color: white;
    }

    select[name="status"][data-status="cancelled"] {
    background-color: red;
    color: white;
    }

    /* Opsi Pending */
    select option[value="pending"] {
    background-color: orange; 
    color: white; 
    }

    /* Opsi Confirmed */
    select option[value="confirmed"] {
    background-color: green;
    color: white;
    }

    /* Opsi Cancelled */
    select option[value="cancelled"] {
    background-color: red;
    color: white; 
    }

</style>
<main class="flex-1 p-0 bg-gray-100">
  <!-- Tabel Pemesanan Tiket -->
  <div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-bold text-[#1B1464] mb-6">Daftar Pemesanan Tiket</h2>
    <table class="w-full table-auto border-collapse shadow-lg">
      <thead>
        <tr class="bg-[#640D5F] text-white">
          <th class="p-4 text-left">Nama User</th>
          <th class="p-4 text-left">Nama Event</th>
          <th class="p-4 text-left">Kuantitas</th>
          <th class="p-4 text-left">Total Harga</th>
          <th class="p-4 text-left">Payment Method</th>
          <th class="p-4 text-left">Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($bookings as $booking)
        <tr class="border-b hover:bg-gray-100 transition">
          <td class="p-4 text-[#1B1464] font-medium">{{ $booking->user->name }}</td>
          <td class="p-4 text-gray-700">{{ $booking->event->title }}</td>
          <td class="p-4 text-gray-700 text-center">{{ $booking->quantity }}</td>
          <td class="p-4 text-gray-700 text-center">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
          <td class="p-4 text-gray-700 text-center">
            {{ ucwords(str_replace('_', ' ', $booking->payment_method)) }}
          </td>          
          <td class="p-4">
            <form action="{{ route('organizer.updateBookingStatus', $booking->id) }}" method="POST">
              @csrf
              @method('PATCH')
              <select 
                name="status" 
                data-status="{{ $booking->status }}" 
                class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-[#640D5F]"
                onchange="this.form.submit()">
                <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</main>
@endsection
