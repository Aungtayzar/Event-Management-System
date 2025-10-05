<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    public function index()
    {
        // Cache dashboard stats for 5 minutes to improve performance
        $stats = Cache::remember('admin_dashboard_stats', 300, function () {
            return [
                'total_events' => Event::count(),
                'published_events' => Event::where('is_published', true)->count(),
                'upcoming_events' => Event::where('date', '>', Carbon::now())->count(),
                'total_categories' => Category::count(),
                'total_users' => User::count(),
                'total_organizers' => User::where('role', 'organizer')->count(),
                'total_bookings' => Booking::count(),
                'active_bookings' => Booking::where('status', 'confirmed')->count(),
                'cancelled_bookings' => Booking::where('status', 'cancelled')->count(),
                'pending_bookings' => Booking::where('status', 'pending')->count(),
                'total_revenue' => Booking::where('status', 'confirmed')->sum('total_price'),
                'pending_revenue' => Booking::where('status', 'pending')->sum('total_price'),
                'this_month_bookings' => Booking::getMonthlyBookingsCount(),
                'this_week_bookings' => Booking::getWeeklyBookingsCount(),
                'today_bookings' => Booking::getTodayBookingsCount(),
                'this_month_revenue' => Booking::getMonthlyRevenue(),
            ];
        });

        $recentEvents = Event::with('category')->latest()->limit(5)->get();
        $recentCategories = Category::withCount('events')->latest()->limit(5)->get();
        $recentBookings = Booking::with(['user', 'event', 'ticketType'])
            ->latest()
            ->limit(10)
            ->get();

        // Recent activities - combining different model activities
        $recentActivities = collect();
        
        // Recent events
        $recentEventActivities = Event::latest()
            ->limit(3)
            ->get()
            ->map(function ($event) {
                return [
                    'type' => 'event_created',
                    'icon' => 'fas fa-calendar-plus',
                    'icon_color' => 'text-green-600',
                    'bg_color' => 'bg-green-100',
                    'title' => 'New event created',
                    'description' => $event->title,
                    'time' => $event->created_at,
                    'time_human' => $event->created_at->diffForHumans(),
                ];
            });

        // Recent users
        $recentUserActivities = User::where('role', '!=', 'admin')
            ->latest()
            ->limit(2)
            ->get()
            ->map(function ($user) {
                return [
                    'type' => 'user_registered',
                    'icon' => 'fas fa-user-plus',
                    'icon_color' => 'text-blue-600',
                    'bg_color' => 'bg-blue-100',
                    'title' => 'New user registered',
                    'description' => $user->email,
                    'time' => $user->created_at,
                    'time_human' => $user->created_at->diffForHumans(),
                ];
            });

        // Recent bookings
        $recentBookingActivities = Booking::with('event')
            ->latest()
            ->limit(2)
            ->get()
            ->map(function ($booking) {
                $statusInfo = [
                    'confirmed' => ['icon' => 'fas fa-check-circle', 'color' => 'text-green-600', 'bg' => 'bg-green-100', 'title' => 'Booking confirmed'],
                    'cancelled' => ['icon' => 'fas fa-times-circle', 'color' => 'text-red-600', 'bg' => 'bg-red-100', 'title' => 'Booking cancelled'],
                    'pending' => ['icon' => 'fas fa-clock', 'color' => 'text-yellow-600', 'bg' => 'bg-yellow-100', 'title' => 'Booking pending'],
                ];
                
                $info = $statusInfo[$booking->status] ?? $statusInfo['pending'];
                
                return [
                    'type' => 'booking_' . $booking->status,
                    'icon' => $info['icon'],
                    'icon_color' => $info['color'],
                    'bg_color' => $info['bg'],
                    'title' => $info['title'],
                    'description' => $booking->event->title,
                    'time' => $booking->created_at,
                    'time_human' => $booking->created_at->diffForHumans(),
                ];
            });

        // Combine and sort all activities by time
        $recentActivities = $recentEventActivities
            ->concat($recentUserActivities)
            ->concat($recentBookingActivities)
            ->sortByDesc('time')
            ->take(5)
            ->values();

        // Monthly booking stats for chart
        $monthlyBookings = Booking::selectRaw('EXTRACT(MONTH FROM created_at) as month, COUNT(*) as count, SUM(total_price) as revenue')
            ->whereRaw('EXTRACT(YEAR FROM created_at) = ?', [Carbon::now()->year])
            ->groupByRaw('EXTRACT(MONTH FROM created_at)')
            ->orderByRaw('EXTRACT(MONTH FROM created_at)')
            ->get()
            ->keyBy('month');
            
        // Fill in missing months with 0
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[$i] = [
                'month' => Carbon::create()->month($i)->format('M'),
                'bookings' => $monthlyBookings->get($i)->count ?? 0,
                'revenue' => $monthlyBookings->get($i)->revenue ?? 0,
            ];
        }

        return view('admin.dashboard', compact('stats', 'recentEvents', 'recentCategories', 'recentBookings', 'recentActivities', 'chartData'));
    }
}
