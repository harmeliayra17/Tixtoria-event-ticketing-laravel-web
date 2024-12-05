<?php

namespace App\Http\Controllers;
use App\Models\Event;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function reports()
    {
        // Total penjualan (semua event)
        $totalSales = Booking::where('status', 'confirmed')
            ->join('events', 'bookings.id_event', '=', 'events.id') // Menyambungkan tabel Booking dengan Event
            ->sum(DB::raw('bookings.quantity * events.price')); // Langsung menghitung total    

        // Total jumlah event
        $totalEvents = Event::count();

        // Total tiket terjual (semua event)
        $totalTicketsSold = Booking::where('status', 'confirmed')->sum('quantity');

        // Nama event
        $eventNames = Event::pluck('title');

        // Total penjualan per event (hitung secara dinamis)
        $eventSales = Event::select('events.title', DB::raw('SUM(bookings.quantity * events.price) as total_sales'))
            ->leftJoin('bookings', 'events.id', '=', 'bookings.id_event') // Menghubungkan tabel Event dengan Booking
            ->where('bookings.status', 'confirmed') // Hanya menghitung booking yang dikonfirmasi
            ->groupBy('events.id', 'events.title') // Kelompokkan berdasarkan ID atau nama event
            ->pluck('total_sales', 'title'); // Mengembalikan hasil sebagai array key-value (title => total_sales)

        // Tiket terjual per hari
        $ticketsPerDay = Booking::select(DB::raw('DATE(bookings.created_at) as date'), DB::raw('SUM(bookings.quantity) as total_tickets'))
            ->where('bookings.status', 'confirmed') // Hanya booking yang statusnya confirmed
            ->groupBy(DB::raw('DATE(bookings.created_at)')) // Kelompokkan berdasarkan tanggal
            ->orderBy('date', 'asc') // Urutkan berdasarkan tanggal
            ->get(); // Ambil hasilnya

        // Siapkan data tanggal dan jumlah tiket terjual per hari
        $dates = $ticketsPerDay->pluck('date'); // Ambil tanggal
        $ticketsSold = $ticketsPerDay->pluck('total_tickets'); // Ambil jumlah tiket terjual

        // 5 Event teratas dengan tiket terjual terbanyak
        $topEvents = Event::select('events.title', DB::raw('SUM(bookings.quantity) as total_tickets'))
            ->join('bookings', 'events.id', '=', 'bookings.id_event')
            ->where('bookings.status', 'confirmed')
            ->groupBy('events.id', 'events.title')
            ->orderByDesc('total_tickets')
            ->take(5) // Ambil 5 data teratas
            ->get();

        // 4. Harga rata-rata tiket yang terjual
        $averageTicketPrice = Booking::where('status', 'confirmed')
            ->join('events', 'bookings.id_event', '=', 'events.id')
            ->average(DB::raw('events.price'));

        return view('admin.reports', compact('totalSales', 'totalEvents', 'totalTicketsSold', 'eventNames', 'eventSales', 'dates', 'ticketsSold','topEvents','averageTicketPrice'));
    }

    public function reportsDashboard()
    {
        // Total penjualan (semua event)
        $totalSales = Booking::where('status', 'confirmed')
            ->join('events', 'bookings.id_event', '=', 'events.id')
            ->sum(DB::raw('bookings.quantity * events.price'));

        // Total jumlah event
        $totalEvents = Event::count();

        // Total tiket terjual (semua event)
        $totalTicketsSold = Booking::where('status', 'confirmed')->sum('quantity');

        // Nama event
        $eventNames = Event::pluck('title');

        // Total penjualan per event
        $eventSales = Event::select('events.title', DB::raw('SUM(bookings.quantity * events.price) as total_sales'))
            ->leftJoin('bookings', 'events.id', '=', 'bookings.id_event')
            ->where('bookings.status', 'confirmed')
            ->groupBy('events.id', 'events.title')
            ->pluck('total_sales', 'title');

        // Tiket terjual per hari
        $ticketsPerDay = Booking::select(DB::raw('DATE(bookings.created_at) as date'), DB::raw('SUM(bookings.quantity) as total_tickets'))
            ->where('bookings.status', 'confirmed')
            ->groupBy(DB::raw('DATE(bookings.created_at)'))
            ->orderBy('date', 'asc')
            ->get();

        $dates = $ticketsPerDay->pluck('date');
        $ticketsSold = $ticketsPerDay->pluck('total_tickets');

        return view('admin.dashboard', compact(
            'totalSales',
            'totalEvents',
            'totalTicketsSold',
            'eventNames',
            'eventSales',
            'dates',
            'ticketsSold'
        ));
    }
}
