<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEvents = Event::count();
        $totalRegistrations = EventRegistration::count();
        $upcomingEvents = Event::where('event_date', '>=', now())
            ->where('status', 'published')
            ->count();
        $totalRevenue = EventRegistration::where('payment_status', 'paid')
            ->with('event')
            ->get()
            ->sum(function($reg) {
                return $reg->event->price ?? 0;
            });

        $recentRegistrations = EventRegistration::with('event')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalEvents', 
            'totalRegistrations', 
            'upcomingEvents',
            'totalRevenue',
            'recentRegistrations'
        ));
    }
}