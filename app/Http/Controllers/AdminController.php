<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_events' => Event::count(),
            'total_categories' => Category::count(),
            'total_users' => User::count(),
            'total_organizers' => User::where('role', 'organizer')->count(),
            'total_bookings' => Booking::count(),
            'active_bookings' => Booking::where('status', 'confirmed')->count(),
            'cancelled_bookings' => Booking::where('status', 'cancelled')->count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'total_revenue' => Booking::where('status', 'confirmed')->sum('total_price'),
            'this_month_bookings' => Booking::whereRaw('EXTRACT(MONTH FROM created_at) = ?', [Carbon::now()->month])
                ->whereRaw('EXTRACT(YEAR FROM created_at) = ?', [Carbon::now()->year])
                ->count(),
        ];

        $recentEvents = Event::with('category')->latest()->limit(5)->get();
        $recentCategories = Category::withCount('events')->latest()->limit(5)->get();
        $recentBookings = Booking::with(['user', 'event', 'ticketType'])
            ->latest()
            ->limit(10)
            ->get();

        // Monthly booking stats for chart
        $monthlyBookings = Booking::selectRaw('EXTRACT(MONTH FROM created_at) as month, COUNT(*) as count, SUM(total_price) as revenue')
            ->whereRaw('EXTRACT(YEAR FROM created_at) = ?', [Carbon::now()->year])
            ->groupByRaw('EXTRACT(MONTH FROM created_at)')
            ->orderByRaw('EXTRACT(MONTH FROM created_at)')
            ->get()
            ->keyBy('month');        // Fill in missing months with 0
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[$i] = [
                'month' => Carbon::create()->month($i)->format('M'),
                'bookings' => $monthlyBookings->get($i)->count ?? 0,
                'revenue' => $monthlyBookings->get($i)->revenue ?? 0,
            ];
        }

        return view('admin.dashboard', compact('stats', 'recentEvents', 'recentCategories', 'recentBookings', 'chartData'));
    }
}
