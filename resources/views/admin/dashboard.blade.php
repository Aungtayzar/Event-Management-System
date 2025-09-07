<x-layout>
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-cyan-50">
        <div class="container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">
                        <i class="fas fa-tachometer-alt text-indigo-600 mr-3"></i>
                        Admin Dashboard
                    </h1>
                    <p class="text-gray-600">Welcome back, {{ auth()->user()->name }}! Here's what's happening with your
                        event platform.</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Last updated</p>
                    <p class="text-lg font-semibold text-gray-700">{{ now()->format('M d, Y - H:i') }}</p>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
                <!-- Total Events -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Total Events</p>
                            <p class="text-3xl font-bold text-indigo-600">{{ $stats['total_events'] }}</p>
                        </div>
                        <div class="bg-indigo-100 rounded-full p-3">
                            <i class="fas fa-calendar-alt text-indigo-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Users -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Total Users</p>
                            <p class="text-3xl font-bold text-green-600">{{ $stats['total_users'] }}</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-3">
                            <i class="fas fa-users text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Bookings -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Total Bookings</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $stats['total_bookings'] }}</p>
                            <p class="text-xs text-gray-500">{{ $stats['this_month_bookings'] }} this month</p>
                        </div>
                        <div class="bg-blue-100 rounded-full p-3">
                            <i class="fas fa-ticket-alt text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Active Bookings -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Active Bookings</p>
                            <p class="text-3xl font-bold text-emerald-600">{{ $stats['active_bookings'] }}</p>
                            <p class="text-xs text-gray-500">{{ $stats['pending_bookings'] }} pending</p>
                        </div>
                        <div class="bg-emerald-100 rounded-full p-3">
                            <i class="fas fa-check-circle text-emerald-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Total Revenue</p>
                            <p class="text-3xl font-bold text-purple-600">${{ number_format($stats['total_revenue'], 0)
                                }}</p>
                            <p class="text-xs text-gray-500">{{ $stats['cancelled_bookings'] }} cancelled</p>
                        </div>
                        <div class="bg-purple-100 rounded-full p-3">
                            <i class="fas fa-dollar-sign text-purple-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Management Links -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-tools text-indigo-600 mr-3"></i>
                            Quick Management
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Manage Categories -->
                            <a href="{{ route('categories.index') }}"
                                class="group bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white rounded-lg p-6 transition-all duration-300 transform hover:scale-105">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold mb-2">Manage Categories</h3>
                                        <p class="text-purple-100 text-sm">Create and edit event categories</p>
                                    </div>
                                    <i class="fas fa-tags text-2xl opacity-80 group-hover:opacity-100"></i>
                                </div>
                            </a>

                            <!-- Manage Events -->
                            <a href="{{ route('admin.events.index') }}"
                                class="group bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white rounded-lg p-6 transition-all duration-300 transform hover:scale-105">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold mb-2">Manage Events</h3>
                                        <p class="text-indigo-100 text-sm">View and moderate events</p>
                                    </div>
                                    <i class="fas fa-calendar-alt text-2xl opacity-80 group-hover:opacity-100"></i>
                                </div>
                            </a>

                            <!-- User Management -->
                            <a href="{{ route('users.index') }}"
                                class="group bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-lg p-6 transition-all duration-300 transform hover:scale-105">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold mb-2">User Management</h3>
                                        <p class="text-green-100 text-sm">Manage user accounts and roles</p>
                                    </div>
                                    <i class="fas fa-users text-2xl opacity-80 group-hover:opacity-100"></i>
                                </div>
                            </a>

                            <!-- Booking Management -->
                            <a href="{{ route('admin.bookings.index') }}"
                                class="group bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg p-6 transition-all duration-300 transform hover:scale-105">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold mb-2">Manage Bookings</h3>
                                        <p class="text-blue-100 text-sm">View, edit and cancel bookings</p>
                                    </div>
                                    <i class="fas fa-ticket-alt text-2xl opacity-80 group-hover:opacity-100"></i>
                                </div>
                            </a>

                            <!-- Booking Reports -->
                            <a href="{{ route('admin.bookings.export') }}"
                                class="group bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white rounded-lg p-6 transition-all duration-300 transform hover:scale-105">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold mb-2">Booking Reports</h3>
                                        <p class="text-yellow-100 text-sm">Export detailed booking analytics</p>
                                    </div>
                                    <i class="fas fa-chart-bar text-2xl opacity-80 group-hover:opacity-100"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-clock text-indigo-600 mr-3"></i>
                            Recent Activity
                        </h2>
                        <div class="space-y-4">
                            <!-- Activity Item -->
                            <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                                <div class="bg-green-100 rounded-full p-2">
                                    <i class="fas fa-plus text-green-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-800">New event created</p>
                                    <p class="text-xs text-gray-600">Tech Conference 2024</p>
                                    <p class="text-xs text-gray-500">2 hours ago</p>
                                </div>
                            </div>

                            <!-- Activity Item -->
                            <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                                <div class="bg-blue-100 rounded-full p-2">
                                    <i class="fas fa-user-plus text-blue-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-800">New user registered</p>
                                    <p class="text-xs text-gray-600">john.doe@example.com</p>
                                    <p class="text-xs text-gray-500">4 hours ago</p>
                                </div>
                            </div>

                            <!-- Activity Item -->
                            <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                                <div class="bg-purple-100 rounded-full p-2">
                                    <i class="fas fa-tags text-purple-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-800">Category updated</p>
                                    <p class="text-xs text-gray-600">Technology category</p>
                                    <p class="text-xs text-gray-500">1 day ago</p>
                                </div>
                            </div>

                            <!-- Activity Item -->
                            <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                                <div class="bg-yellow-100 rounded-full p-2">
                                    <i class="fas fa-ticket-alt text-yellow-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-800">Multiple bookings</p>
                                    <p class="text-xs text-gray-600">15 new bookings today</p>
                                    <p class="text-xs text-gray-500">1 day ago</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Bookings Section -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-ticket-alt text-blue-600 mr-3"></i>
                        Recent Bookings
                    </h2>
                    <a href="{{ route('admin.bookings.index') }}"
                        class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                        View All <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Booking ID
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Customer
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Event
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Amount
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recentBookings as $booking)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <a href="{{ route('admin.bookings.show', $booking) }}"
                                        class="text-blue-600 hover:text-blue-800">
                                        #{{ $booking->id }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $booking->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $booking->user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ Str::limit($booking->event->title, 30) }}
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $booking->ticketType->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    ${{ number_format($booking->total_price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                    $statusColors = [
                                    'confirmed' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'refunded' => 'bg-blue-100 text-blue-800',
                                    ];
                                    @endphp
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $booking->created_at->format('M j, Y') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    <i class="fas fa-ticket-alt text-4xl text-gray-300 mb-4"></i>
                                    <p>No recent bookings found.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layout>