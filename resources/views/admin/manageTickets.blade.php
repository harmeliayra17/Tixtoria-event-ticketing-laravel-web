@extends('admin.partials.sidebar')

@section('title', 'Manage Tickets')

@section('content')
<div class="w-full pb-12 animate-fade-in">
    
    <div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm mb-6 flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-[#1B1464]/5 text-[#1B1464] flex items-center justify-center flex-shrink-0">
            <i data-lucide="ticket" class="w-4 h-4"></i>
        </div>
        <p class="text-xs text-slate-500">Review ticket reservations and update payment status for all platform events.</p>
    </div>

    
    @if(session('success'))
        <div id="success-banner" class="bg-emerald-50 border border-emerald-100 rounded-xl p-4 mb-6 flex items-center gap-3 text-emerald-800 text-sm">
            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
        <script>
            setTimeout(() => {
                const banner = document.getElementById('success-banner');
                if(banner) {
                    banner.style.opacity = '0';
                    banner.style.transition = 'opacity 0.5s ease-out';
                    setTimeout(() => banner.remove(), 500);
                }
            }, 3000);
        </script>
    @endif

    
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
        @if($bookings->isEmpty())
            <div class="text-center py-16">
                <i data-lucide="ticket" class="w-12 h-12 text-slate-300 mx-auto mb-4"></i>
                <h3 class="text-lg font-bold text-slate-700">No Reservations Yet</h3>
                <p class="text-slate-500 mt-2 text-xs">No users have reserved tickets on the platform yet.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">
                            <th class="p-4 pl-6">User Details</th>
                            <th class="p-4">Event Details</th>
                            <th class="p-4 text-center">Quantity</th>
                            <th class="p-4 text-center">Total Price</th>
                            <th class="p-4 text-center">Payment Method</th>
                            <th class="p-4 pr-6 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @foreach ($bookings as $booking)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4 pl-6">
                                <div class="font-bold text-slate-800">{{ $booking->user->name }}</div>
                                <div class="text-[11px] text-slate-400 mt-0.5">{{ $booking->user->email }}</div>
                            </td>
                            <td class="p-4">
                                <div class="font-semibold text-slate-700">{{ $booking->event->title }}</div>
                                <div class="text-[10px] text-slate-400 mt-0.5 flex items-center gap-1">
                                    <i data-lucide="calendar" class="w-3 h-3"></i>
                                    <span>{{ date('d M Y', strtotime($booking->event->date)) }}</span>
                                </div>
                            </td>
                            <td class="p-4 text-center font-semibold text-slate-700">{{ $booking->quantity }}</td>
                            <td class="p-4 text-center font-bold text-[#640D5F]">
                                @if($booking->total_price > 0)
                                    Rp{{ number_format($booking->total_price, 0, ',', '.') }}
                                @else
                                    Free
                                @endif
                            </td>
                            <td class="p-4 text-center text-xs font-medium text-slate-500">
                                {{ ucwords(str_replace('_', ' ', $booking->payment_method)) }}
                            </td>
                            <td class="p-4 pr-6 text-center">
                                <form action="{{ route('admin.updateBookingStatus', $booking->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <select 
                                        name="status" 
                                        onchange="this.form.submit()" 
                                        class="h-9 px-3 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-1 focus:ring-[#640D5F] cursor-pointer
                                            @if($booking->status === 'pending') bg-amber-50 text-amber-600 border-amber-200
                                            @elseif($booking->status === 'confirmed') bg-emerald-50 text-emerald-600 border-emerald-200
                                            @elseif($booking->status === 'cancelled') bg-rose-50 text-rose-600 border-rose-200
                                            @endif">
                                        <option value="pending" class="bg-white text-amber-600 font-semibold" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" class="bg-white text-emerald-600 font-semibold" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="cancelled" class="bg-white text-rose-600 font-semibold" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
