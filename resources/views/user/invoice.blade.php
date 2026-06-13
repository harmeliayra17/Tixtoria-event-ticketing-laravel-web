<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <title>Invoice - INV/{{ date('Ymd', strtotime($booking->created_at)) }}/TX-{{ $booking->id }}</title>
    <link rel="icon" href="{{ asset('images/logo.ico') }}" type="image/x-icon">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background-color: white !important;
                color: black !important;
            }
            .invoice-card {
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen py-12 px-4 md:px-8">

    <!-- Top Action Bar (hidden when printing) -->
    <div class="max-w-3xl mx-auto mb-6 flex justify-between items-center no-print">
        <a href="{{ route('user.ticket') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-[#640D5F] font-semibold text-sm transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Back to Tickets</span>
        </a>
        <button onclick="window.print()" class="inline-flex items-center gap-2 bg-gradient-to-r from-[#640D5F] to-[#1B1464] text-white px-5 py-2.5 rounded-xl font-bold hover:brightness-110 shadow-md active:scale-95 transition text-sm">
            <i data-lucide="printer" class="w-4 h-4"></i>
            <span>Print Invoice</span>
        </button>
    </div>

    <!-- Invoice Sheet -->
    <div class="max-w-3xl mx-auto bg-white border border-slate-100 rounded-2xl shadow-xl p-8 md:p-12 invoice-card">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 border-b border-slate-100 pb-8">
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Tixtoria Logo" class="h-8 rounded-md mb-2">
                <p class="text-xs text-slate-400 font-light">Premium Ticketing Experience Platform</p>
            </div>
            <div class="text-left md:text-right">
                <span class="inline-block px-3 py-1 bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-full text-xs font-bold uppercase tracking-wider mb-2">
                    PAID
                </span>
                <h2 class="text-sm font-bold text-slate-800">Invoice Reference</h2>
                <p class="text-xs text-slate-500 font-mono mt-0.5">INV/{{ date('Ymd', strtotime($booking->created_at)) }}/TX-{{ $booking->id }}</p>
            </div>
        </div>

        <!-- Bill To & Metadata -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 py-8 border-b border-slate-100 text-sm">
            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Billing Details</h3>
                <p class="font-bold text-slate-800">{{ $booking->user->name }}</p>
                <p class="text-slate-500 mt-1">{{ $booking->user->email }}</p>
                <p class="text-slate-400 text-xs mt-1">Payment Method: {{ ucwords(str_replace('_', ' ', $booking->payment_method)) }}</p>
            </div>
            <div class="md:text-right">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Payment Date</h3>
                <p class="font-bold text-slate-800">{{ date('d M Y, H:i', strtotime($booking->updated_at)) }} WIB</p>
                
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mt-4 mb-2">Transaction ID</h3>
                <p class="font-mono text-xs text-slate-500">TX-{{ str_pad($booking->id, 8, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>

        <!-- Event Details List -->
        <div class="py-8">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Ticket details</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-400 font-semibold text-xs uppercase tracking-wider">
                            <th class="py-3 pr-4">Description</th>
                            <th class="py-3 px-4 text-center">Unit Price</th>
                            <th class="py-3 px-4 text-center">Qty</th>
                            <th class="py-3 pl-4 text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        <tr>
                            <td class="py-4 pr-4">
                                <div class="font-bold text-slate-800">{{ $booking->event->title }}</div>
                                <div class="text-xs text-slate-400 mt-1 flex items-center gap-1.5">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400"></i>
                                    <span>{{ $booking->event->location->location_name }}, {{ $booking->event->location->city }}</span>
                                </div>
                                <div class="text-[11px] text-slate-400 mt-0.5 flex items-center gap-1.5">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i>
                                    <span>{{ date('D, d M Y', strtotime($booking->event->date)) }} @ {{ date('H:i', strtotime($booking->event->time)) }} WIB</span>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-center font-mono">
                                @if($booking->event->price > 0)
                                    Rp{{ number_format($booking->event->price, 0, ',', '.') }}
                                @else
                                    Free
                                @endif
                            </td>
                            <td class="py-4 px-4 text-center font-semibold">{{ $booking->quantity }}</td>
                            <td class="py-4 pl-4 text-right font-bold text-slate-800 font-mono">
                                @if($booking->event->price > 0)
                                    Rp{{ number_format($booking->event->price * $booking->quantity, 0, ',', '.') }}
                                @else
                                    Free
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Grand Total & QR Code Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pt-8 border-t border-slate-100">
            <!-- QR Verification -->
            <div class="md:col-span-1 flex flex-col items-center md:items-start text-center md:text-left">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Entrance Ticket</h4>
                <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=TIXX-{{ $booking->id }}" alt="Ticket QR" class="w-28 h-28">
                </div>
                <span class="text-[9px] text-slate-400 mt-2 font-medium">Scan QR code at the entrance gate.</span>
            </div>

            <!-- Price Breakdown -->
            <div class="md:col-span-2 space-y-3 text-sm flex flex-col justify-end">
                <div class="flex justify-between items-center text-slate-500">
                    <span>Subtotal Price</span>
                    <span class="font-semibold font-mono">
                        @if($booking->event->price > 0)
                            Rp{{ number_format($booking->event->price * $booking->quantity, 0, ',', '.') }}
                        @else
                            Free
                        @endif
                    </span>
                </div>
                <div class="flex justify-between items-center text-slate-500">
                    <span>Platform Admin Fee</span>
                    <span class="font-semibold font-mono">Rp0</span>
                </div>
                <div class="h-px bg-slate-100 my-1"></div>
                <div class="flex justify-between items-center text-[#640D5F] font-bold text-lg">
                    <span>Grand Total</span>
                    <span class="font-extrabold font-mono">
                        @if($booking->total_price > 0)
                            Rp{{ number_format($booking->total_price, 0, ',', '.') }}
                        @else
                            Free
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Terms and Notes -->
        <div class="mt-12 pt-8 border-t border-slate-100 text-center md:text-left text-xs text-slate-400 space-y-1">
            <p class="font-semibold text-slate-500">Terms & Conditions</p>
            <p>1. Please present either a printed copy of this invoice or show the QR code on your mobile device at the venue entrance.</p>
            <p>2. Tickets purchased are non-refundable and cannot be exchanged unless the event is canceled by the organizers.</p>
            <p class="pt-4 text-[10px]">Thank you for choosing Tixtoria. Have a wonderful experience!</p>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            lucide.createIcons();
        });
    </script>
</body>
</html>
