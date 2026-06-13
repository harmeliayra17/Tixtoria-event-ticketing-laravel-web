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
        $totalSales = Booking::where('status', 'confirmed')
            ->join('events', 'bookings.id_event', '=', 'events.id')
            ->sum(DB::raw('bookings.quantity * events.price'));

        $totalEvents = Event::count();
        $totalTicketsSold = Booking::where('status', 'confirmed')->sum('quantity');
        $eventNames = Event::pluck('title');

        $eventSales = Event::select('events.title', DB::raw('SUM(bookings.quantity * events.price) as total_sales'))
            ->leftJoin('bookings', 'events.id', '=', 'bookings.id_event')
            ->where('bookings.status', 'confirmed')
            ->groupBy('events.id', 'events.title')
            ->pluck('total_sales', 'title');

        $ticketsPerDay = Booking::select(DB::raw('DATE(bookings.created_at) as date'), DB::raw('SUM(bookings.quantity) as total_tickets'))
            ->where('bookings.status', 'confirmed')
            ->groupBy(DB::raw('DATE(bookings.created_at)'))
            ->orderBy('date', 'asc')
            ->get();

        $dates = $ticketsPerDay->pluck('date');
        $ticketsSold = $ticketsPerDay->pluck('total_tickets');

        $topEvents = Event::select('events.title', DB::raw('SUM(bookings.quantity) as total_tickets'))
            ->join('bookings', 'events.id', '=', 'bookings.id_event')
            ->where('bookings.status', 'confirmed')
            ->groupBy('events.id', 'events.title')
            ->orderByDesc('total_tickets')
            ->take(5)
            ->get();

        $averageTicketPrice = Booking::where('status', 'confirmed')
            ->join('events', 'bookings.id_event', '=', 'events.id')
            ->average(DB::raw('events.price'));

        return view('admin.reports', compact('totalSales', 'totalEvents', 'totalTicketsSold', 'eventNames', 'eventSales', 'dates', 'ticketsSold','topEvents','averageTicketPrice'));
    }

    public function reportsDashboard()
    {
        $totalSales = Booking::where('status', 'confirmed')
            ->join('events', 'bookings.id_event', '=', 'events.id')
            ->sum(DB::raw('bookings.quantity * events.price'));

        $totalEvents = Event::count();
        $totalTicketsSold = Booking::where('status', 'confirmed')->sum('quantity');
        $eventNames = Event::pluck('title');

        $eventSales = Event::select('events.title', DB::raw('SUM(bookings.quantity * events.price) as total_sales'))
            ->leftJoin('bookings', 'events.id', '=', 'bookings.id_event')
            ->where('bookings.status', 'confirmed')
            ->groupBy('events.id', 'events.title')
            ->pluck('total_sales', 'title');

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
