<x-layout>
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Booking Details</h1>
                <p class="text-gray-600 mt-1">Booking #{{ $booking->id }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.bookings.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Back to List
                </a>

                @if($booking->canBeEdited())
                <a href="{{ route('admin.bookings.edit', $booking) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-200">
                    <i class="fas fa-edit mr-2"></i>Edit Booking
                </a>
                @endif

                @if($booking->canBeCancelled())
                <a href="{{ route('admin.bookings.cancel.form', $booking) }}"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md transition duration-200">
                    <i class="fas fa-times mr-2"></i>Cancel Booking
                </a>
                @endif
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md mb-6">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-6">
            {{ session('error') }}
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Booking Information -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Booking Information</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Booking ID</label>
                            <p class="text-lg font-medium text-gray-900">#{{ $booking->id }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                            @php
                            $statusColors = [
                            'confirmed' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'refunded' => 'bg-blue-100 text-blue-800',
                            ];
                            @endphp
                            <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $booking->status_color }}">
                                @if($booking->isCancelled())
                                <i class="fas fa-times-circle mr-1"></i>
                                {{ $booking->status_display }}
                                @else
                                <i class="fas fa-check-circle mr-1"></i>
                                {{ $booking->status_display }}
                                @endif
                            </span>

                            @if($booking->cancelled_at)
                            <p class="text-sm text-gray-500 mt-1">
                                <i class="fas fa-clock mr-1"></i>
                                Cancelled on {{ $booking->cancelled_at->format('M d, Y \a\t g:i A') }}
                            </p>
                            @endif
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Booking Date</label>
                            <p class="text-lg text-gray-900">{{ $booking->created_at->format('F j, Y \a\t g:i A') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Quantity</label>
                            <p class="text-lg text-gray-900">{{ $booking->quantity }} ticket(s)</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Ticket Type</label>
                            <p class="text-lg text-gray-900">{{ $booking->ticketType->name }}</p>
                            <p class="text-sm text-gray-600">${{ number_format($booking->ticketType->price, 2) }} per
                                ticket</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Total Price</label>
                            <p class="text-xl font-bold text-green-600">${{ number_format($booking->total_price, 2) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Customer Information</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Name</label>
                            <p class="text-lg text-gray-900">{{ $booking->user->name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                            <p class="text-lg text-gray-900">{{ $booking->user->email }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Customer Since</label>
                            <p class="text-lg text-gray-900">{{ $booking->user->created_at->format('F j, Y') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Total Bookings</label>
                            <p class="text-lg text-gray-900">{{ $booking->user->bookings->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Event Information -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Event Information</h2>

                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Event Title</label>
                            <p class="text-lg text-gray-900">{{ $booking->event->title }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Event Date</label>
                            <p class="text-lg text-gray-900">{{ date('F j, Y', strtotime($booking->event->date)) }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Location</label>
                            <p class="text-lg text-gray-900">{{ $booking->event->location }}</p>
                        </div>

                        @if($booking->event->description)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Description</label>
                            <p class="text-gray-900">{{ Str::limit($booking->event->description, 200) }}</p>
                        </div>
                        @endif

                        <div>
                            <a href="{{ route('events.show', $booking->event) }}"
                                class="inline-flex items-center text-blue-600 hover:text-blue-800 transition duration-200"
                                target="_blank">
                                <i class="fas fa-external-link-alt mr-2"></i>View Event Page
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>

                    <div class="space-y-3">
                        @if($booking->canBeEdited())
                        <a href="{{ route('admin.bookings.edit', $booking) }}"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition duration-200 flex items-center justify-center">
                            <i class="fas fa-edit mr-2"></i>Edit Booking
                        </a>
                        @endif

                        @if($booking->canBeCancelled())
                        <a href="{{ route('admin.bookings.cancel.form', $booking) }}"
                            class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-md transition duration-200 flex items-center justify-center">
                            <i class="fas fa-times mr-2"></i>Cancel Booking
                        </a>
                        @endif

                        <a href="mailto:{{ $booking->user->email }}"
                            class="w-full bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-md transition duration-200 flex items-center justify-center">
                            <i class="fas fa-envelope mr-2"></i>Email Customer
                        </a>
                    </div>
                </div>

                <!-- Cancellation Information -->
                @if($booking->isCancelled() && $booking->cancellation)
                <div class="bg-red-50 border border-red-200 rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-red-900 mb-4">
                        <i class="fas fa-ban mr-2"></i>Cancellation Details
                    </h3>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-red-700 mb-1">Cancelled At</label>
                            <p class="text-red-900">{{ $booking->cancelled_at->format('F j, Y \a\t g:i A') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-red-700 mb-1">Cancelled By</label>
                            <p class="text-red-900">{{ $booking->cancellation->cancelledBy->name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-red-700 mb-1">Reason</label>
                            <p class="text-red-900">{{ $booking->cancellation->reason }}</p>
                        </div>

                        @if($booking->cancellation->notes)
                        <div>
                            <label class="block text-sm font-medium text-red-700 mb-1">Notes</label>
                            <p class="text-red-900">{{ $booking->cancellation->notes }}</p>
                        </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-red-700 mb-1">Refund Amount</label>
                            <p class="text-red-900 font-bold">${{ number_format($booking->cancellation->refund_amount,
                                2) }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-red-700 mb-1">Refund Status</label>
                            @php
                            $refundStatusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'completed' => 'bg-green-100 text-green-800',
                            'failed' => 'bg-red-100 text-red-800',
                            ];
                            @endphp
                            <span
                                class="px-2 py-1 text-xs font-semibold rounded-full {{ $refundStatusColors[$booking->cancellation->refund_status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($booking->cancellation->refund_status) }}
                            </span>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>