<x-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                            <i class="fas fa-ticket-alt text-indigo-600 mr-3"></i>
                            My Bookings
                        </h1>
                        <p class="text-gray-600 mt-2">Manage and view all your event bookings</p>
                    </div>
                    <div class="hidden sm:block">
                        <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-calendar-check text-indigo-500 mr-2"></i>
                                <span class="font-medium">{{ $bookings->count() }}</span>
                                <span class="ml-1">{{ $bookings->count() === 1 ? 'Booking' : 'Bookings' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($bookings->count() > 0)
            <!-- Bookings Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($bookings as $booking)
                <div
                    class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <!-- Event Banner/Header -->
                    <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 h-32 relative">
                        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <h2 class="text-white font-bold text-lg leading-tight line-clamp-2">
                                {{ $booking->event->title }}
                            </h2>
                        </div>
                        <!-- Booking Status Badge -->
                        <div class="absolute top-4 right-4">
                            <span
                                class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full flex items-center">
                                <i class="fas fa-check-circle mr-1"></i>
                                Confirmed
                            </span>
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div class="p-6 space-y-4">
                        <!-- Event Date & Location -->
                        <div class="space-y-3">
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-calendar text-indigo-500 w-5 mr-3"></i>
                                <span class="text-sm font-medium">
                                    {{ \Carbon\Carbon::parse($booking->event->date)->format('M d, Y • g:i A') }}
                                </span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-map-marker-alt text-indigo-500 w-5 mr-3"></i>
                                <span class="text-sm">{{ $booking->event->location }}</span>
                            </div>
                        </div>

                        <!-- Ticket Information -->
                        <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-indigo-500">
                            <div class="space-y-2">
                                <!-- Ticket Type -->
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-tags text-gray-400 mr-2"></i>
                                        <span class="text-sm font-medium text-gray-700">Ticket Type</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-900 bg-white px-2 py-1 rounded">
                                        {{ $booking->ticketType->name }}
                                    </span>
                                </div>

                                <!-- Quantity -->
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-sort-numeric-up text-gray-400 mr-2"></i>
                                        <span class="text-sm font-medium text-gray-700">Quantity</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-900 bg-white px-2 py-1 rounded">
                                        {{ $booking->quantity }} {{ $booking->quantity === 1 ? 'ticket' : 'tickets' }}
                                    </span>
                                </div>

                                <!-- Total Price -->
                                <div class="flex items-center justify-between border-t border-gray-200 pt-2 mt-2">
                                    <div class="flex items-center">
                                        <i class="fas fa-dollar-sign text-green-500 mr-2"></i>
                                        <span class="text-sm font-medium text-gray-700">Total Paid</span>
                                    </div>
                                    <span class="text-lg font-bold text-green-600">
                                        ${{ number_format($booking->total_price, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-2 pt-2">
                            <a href="{{ route('events.show', $booking->event) }}"
                                class="flex-1 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-medium py-2 px-4 rounded-lg transition duration-300 ease-in-out flex items-center justify-center text-sm">
                                <i class="fas fa-eye mr-2"></i>
                                View Event
                            </a>
                        </div>

                        <!-- Booking Reference -->
                        <div class="text-center pt-2 border-t border-gray-100">
                            <p class="text-xs text-gray-500">
                                <i class="fas fa-hashtag mr-1"></i>
                                Booking ID: <span class="font-mono font-medium">{{ str_pad($booking->id, 6, '0',
                                    STR_PAD_LEFT) }}</span>
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Additional Stats/Info Section -->
            <div class="mt-12 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div
                            class="bg-blue-100 rounded-full p-3 w-16 h-16 mx-auto mb-3 flex items-center justify-center">
                            <i class="fas fa-calendar-check text-blue-600 text-xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Total Bookings</h3>
                        <p class="text-2xl font-bold text-blue-600">{{ $bookings->count() }}</p>
                    </div>
                    <div class="text-center">
                        <div
                            class="bg-green-100 rounded-full p-3 w-16 h-16 mx-auto mb-3 flex items-center justify-center">
                            <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Total Spent</h3>
                        <p class="text-2xl font-bold text-green-600">${{ number_format($bookings->sum('total_price'), 2)
                            }}</p>
                    </div>
                    <div class="text-center">
                        <div
                            class="bg-purple-100 rounded-full p-3 w-16 h-16 mx-auto mb-3 flex items-center justify-center">
                            <i class="fas fa-ticket-alt text-purple-600 text-xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Total Tickets</h3>
                        <p class="text-2xl font-bold text-purple-600">{{ $bookings->sum('quantity') }}</p>
                    </div>
                </div>
            </div>

            @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 max-w-md mx-auto">
                    <div class="bg-gray-100 rounded-full p-6 w-24 h-24 mx-auto mb-6 flex items-center justify-center">
                        <i class="fas fa-ticket-alt text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">No Bookings Yet</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        You haven't booked any events yet. Start exploring amazing events and make your first booking!
                    </p>
                    <a href="{{ route('events.index') }}"
                        class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 transform hover:scale-105 hover:shadow-lg inline-flex items-center">
                        <i class="fas fa-search mr-2"></i>
                        Browse Events
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-layout>