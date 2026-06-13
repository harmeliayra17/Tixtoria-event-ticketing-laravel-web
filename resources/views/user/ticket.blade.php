@extends('user.partials.sidebar')

@section('title', 'My Tickets')

@section('content')
<div class="w-full pb-12">
    <!-- Header Summary Card -->
    <div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm mb-6 flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-[#1B1464]/5 text-[#1B1464] flex items-center justify-center flex-shrink-0">
            <i data-lucide="ticket" class="w-4 h-4"></i>
        </div>
        <p class="text-xs text-slate-500">Review your ticket purchase history, reservation statuses, and download invoice copies.</p>
    </div>

    <!-- Bookings Listing Card -->
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
        @if($bookings->isEmpty())
            <div class="text-center py-16">
                <i data-lucide="ticket" class="w-12 h-12 text-slate-300 mx-auto mb-4"></i>
                <h3 class="text-lg font-bold text-slate-700">No Tickets Yet</h3>
                <p class="text-slate-500 mt-2 text-xs">You haven't reserved any tickets yet.</p>
                <a href="{{ route('eventCatalog') }}" class="mt-6 inline-flex items-center gap-2 bg-[#640D5F] text-white px-6 py-2.5 rounded-xl text-xs font-semibold hover:brightness-110 transition">Discover Events</a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">
                            <th class="p-4 pl-6">Event Name</th>
                            <th class="p-4 text-center">Quantity</th>
                            <th class="p-4 text-center">Total Price</th>
                            <th class="p-4 text-center">Payment Method</th>
                            <th class="p-4 text-center">Payment Proof</th>
                            <th class="p-4 pr-6 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @foreach ($bookings as $booking)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4 pl-6">
                                <div class="font-bold text-slate-800">{{ $booking->event->title }}</div>
                                <div class="text-[11px] text-slate-400 mt-0.5 flex items-center gap-1">
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
                                @if($booking->payment_proof_path)
                                    <a href="{{ asset('storage/' . $booking->payment_proof_path) }}" target="_blank" class="inline-block group">
                                        <img src="{{ asset('storage/' . $booking->payment_proof_path) }}" alt="Proof" class="w-10 h-10 object-cover rounded-lg border border-slate-200 group-hover:scale-110 transition">
                                    </a>
                                    <p class="text-[9px] text-emerald-500 font-semibold mt-1">Uploaded</p>
                                @elseif($booking->status === 'pending')
                                    <form action="{{ route('user.bookings.uploadProof', $booking->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center gap-1">
                                        @csrf
                                        <label class="cursor-pointer inline-flex items-center gap-1 px-3 py-1.5 bg-[#640D5F]/5 border border-[#640D5F]/20 text-[#640D5F] rounded-lg text-[10px] font-semibold hover:bg-[#640D5F]/10 transition">
                                            <i data-lucide="upload" class="w-3 h-3"></i>
                                            <span>Choose File</span>
                                            <input type="file" name="payment_proof" accept="image/*" class="hidden" required onchange="this.form.submit()">
                                        </label>
                                        <p class="text-[9px] text-slate-400">Max 5MB</p>
                                    </form>
                                @else
                                    <span class="text-[10px] text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="p-4 pr-6 text-center">
                                <div class="flex items-center justify-center gap-2.5">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                        @if($booking->status === 'pending') bg-amber-50 text-amber-600 border border-amber-200
                                        @elseif($booking->status === 'confirmed') bg-emerald-50 text-emerald-600 border border-emerald-200
                                        @elseif($booking->status === 'cancelled') bg-rose-50 text-rose-600 border border-rose-200
                                        @endif">
                                        {{ ucwords($booking->status) }}
                                    </span>
                                    
                                    @if($booking->status === 'confirmed')
                                        <a href="{{ route('user.bookings.invoice', $booking->id) }}" target="_blank"
                                           class="inline-flex items-center gap-1 px-3 py-1 bg-indigo-50 border border-indigo-100 text-indigo-600 hover:bg-indigo-100/50 rounded-full text-xs font-semibold transition"
                                           title="Print Invoice">
                                            <i data-lucide="printer" class="w-3.5 h-3.5"></i>
                                            <span>Invoice</span>
                                        </a>
                                    @endif
                                </div>
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
