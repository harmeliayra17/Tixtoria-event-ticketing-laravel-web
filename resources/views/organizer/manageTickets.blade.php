@extends('organizer.partials.sidebar')

@section('title', 'Manage Tickets')

@section('content')
<div class="w-full pb-12" x-data="{ showInvoice: {{ session('show_invoice_id') ? 'true' : 'false' }}, invoiceId: {{ session('show_invoice_id') ?? 0 }} }">
    
    <div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm mb-6 flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-[#1B1464]/5 text-[#1B1464] flex items-center justify-center flex-shrink-0">
            <i data-lucide="ticket" class="w-4 h-4"></i>
        </div>
        <p class="text-xs text-slate-500">Review ticket reservations and update payment status for your events.</p>
    </div>

    
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
        @if($bookings->isEmpty())
            <div class="text-center py-16">
                <i data-lucide="ticket" class="w-12 h-12 text-slate-300 mx-auto mb-4"></i>
                <h3 class="text-lg font-bold text-slate-700">No Reservations Yet</h3>
                <p class="text-slate-500 mt-2 text-xs">No users have reserved tickets for your events yet.</p>
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
                            <th class="p-4 text-center">Sender</th>
                            <th class="p-4 pr-6 text-center">Buyer Proof</th>
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
                            <td class="p-4 text-center">
                                @if($booking->sender_account_name)
                                    <div class="font-semibold text-slate-700 text-xs">{{ $booking->sender_account_name }}</div>
                                    <div class="text-[10px] text-slate-400 mt-0.5">{{ $booking->sender_bank ?? '-' }}</div>
                                @else
                                    <span class="text-[10px] text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="p-4 pr-6 text-center">
                                @if($booking->payment_proof_path)
                                    <a href="{{ asset('storage/' . $booking->payment_proof_path) }}" target="_blank" class="inline-block group">
                                        <img src="{{ asset('storage/' . $booking->payment_proof_path) }}" alt="Buyer Proof" class="w-10 h-10 object-cover rounded-lg border border-slate-200 group-hover:scale-110 transition mx-auto">
                                    </a>
                                    <p class="text-[9px] text-emerald-500 font-semibold mt-1">Verified</p>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-50 text-amber-500 border border-amber-200">Not Uploaded</span>
                                @endif
                            </td>
                            <td class="p-4 pr-6 text-center">
                                <form action="{{ route('organizer.updateBookingStatus', $booking->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="h-9 px-3 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-1 focus:ring-[#640D5F] cursor-pointer
                                        @if($booking->status === 'pending') bg-amber-50 text-amber-600 border-amber-200
                                        @elseif($booking->status === 'confirmed') bg-emerald-50 text-emerald-600 border-emerald-200
                                        @elseif($booking->status === 'cancelled') bg-rose-50 text-rose-600 border-rose-200
                                        @endif">
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
        @endif
    </div>

    
    <div x-show="showInvoice"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
         style="display: none;">
        
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="showInvoice = false"></div>
        
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full max-h-[85vh] overflow-y-auto z-10 border border-slate-100"
             @click.stop
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            
            <button @click="showInvoice = false" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500 hover:text-slate-700 transition z-20">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
            
            <template x-if="showInvoice && invoiceId">
                <div x-html="document.getElementById('invoice-data-' + invoiceId)?.innerHTML || '<p class=\'p-6 text-slate-500 text-sm\'>Invoice not found.</p>'"></div>
            </template>
        </div>
    </div>

    
    @foreach ($bookings as $booking)
        <div id="invoice-data-{{ $booking->id }}" class="hidden">
            @include('organizer.invoice', ['booking' => $booking])
        </div>
    @endforeach
</div>
@endsection
