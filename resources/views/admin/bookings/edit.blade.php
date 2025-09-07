<x-layout>
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Edit Booking</h1>
                <p class="text-gray-600 mt-1">Booking #{{ $booking->id }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.bookings.show', $booking) }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Details
                </a>
            </div>
        </div>

        <!-- Warning Message -->
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-md mb-6">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <div>
                    <strong>Important:</strong> Be cautious when editing bookings. Major changes should typically be
                    handled through cancellation and rebooking.
                    Only make corrections for genuine mistakes like name/email errors.
                </div>
            </div>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-6">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Edit Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Customer Selection -->
                        <div class="mb-6">
                            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Customer <span class="text-red-500">*</span>
                            </label>
                            <select name="user_id" id="user_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $booking->user_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                                @endforeach
                            </select>
                            <p class="text-sm text-gray-500 mt-1">Select the customer for this booking</p>
                        </div>

                        <!-- Ticket Type (Read-only for major changes) -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ticket Type</label>
                            <div class="bg-gray-100 p-3 rounded-md">
                                <p class="text-gray-900 font-medium">{{ $booking->ticketType->name }}</p>
                                <p class="text-sm text-gray-600">${{ number_format($booking->ticketType->price, 2) }}
                                    per ticket</p>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">
                                <i class="fas fa-info-circle mr-1"></i>
                                To change ticket type, cancel this booking and create a new one.
                            </p>
                        </div>

                        <!-- Event (Read-only for major changes) -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Event</label>
                            <div class="bg-gray-100 p-3 rounded-md">
                                <p class="text-gray-900 font-medium">{{ $booking->event->title }}</p>
                                <p class="text-sm text-gray-600">{{ date('F j, Y', strtotime($booking->event->date)) }}
                                    at {{ $booking->event->location }}</p>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">
                                <i class="fas fa-info-circle mr-1"></i>
                                To change event, cancel this booking and create a new one.
                            </p>
                        </div>

                        <!-- Quantity -->
                        <div class="mb-6">
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                                Quantity <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="quantity" id="quantity" min="1"
                                max="{{ $booking->ticketType->quantity + $booking->quantity }}"
                                value="{{ old('quantity', $booking->quantity) }}" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-sm text-gray-500 mt-1">
                                Available tickets: {{ $booking->ticketType->quantity + $booking->quantity }}
                                (including current booking)
                            </p>
                        </div>

                        <!-- Status -->
                        <div class="mb-6">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status" id="status" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>
                                    Confirmed
                                </option>
                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option>
                            </select>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Admin Notes</label>
                            <textarea name="notes" id="notes" rows="4"
                                placeholder="Add any notes about this booking edit..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes') }}</textarea>
                            <p class="text-sm text-gray-500 mt-1">Internal notes (not visible to customer)</p>
                        </div>

                        <!-- Total Price Display -->
                        <div class="mb-6 bg-blue-50 p-4 rounded-md">
                            <label class="block text-sm font-medium text-blue-700 mb-1">Total Price</label>
                            <p class="text-2xl font-bold text-blue-900" id="total-price">
                                ${{ number_format($booking->total_price, 2) }}
                            </p>
                            <p class="text-sm text-blue-600">Price will update automatically based on quantity</p>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex gap-4">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition duration-200">
                                <i class="fas fa-save mr-2"></i>Update Booking
                            </button>
                            <a href="{{ route('admin.bookings.show', $booking) }}"
                                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md transition duration-200">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current Booking Info -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Current Booking</h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Booking ID</label>
                            <p class="font-medium">#{{ $booking->id }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Current Customer</label>
                            <p class="font-medium">{{ $booking->user->name }}</p>
                            <p class="text-sm text-gray-600">{{ $booking->user->email }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Current Quantity</label>
                            <p class="font-medium">{{ $booking->quantity }} tickets</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Current Total</label>
                            <p class="font-bold text-green-600">${{ number_format($booking->total_price, 2) }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Booking Date</label>
                            <p class="text-sm">{{ $booking->created_at->format('F j, Y \a\t g:i A') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Guidelines -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mt-6">
                    <h4 class="text-md font-semibold text-yellow-800 mb-3">
                        <i class="fas fa-lightbulb mr-2"></i>Edit Guidelines
                    </h4>
                    <ul class="text-sm text-yellow-700 space-y-2">
                        <li>• Only correct genuine mistakes</li>
                        <li>• For major changes, consider cancellation + rebooking</li>
                        <li>• Always verify changes with the customer</li>
                        <li>• Document reasons in admin notes</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Update total price when quantity changes
        document.getElementById('quantity').addEventListener('input', function() {
            const quantity = parseInt(this.value) || 0;
            const pricePerTicket = {{ $booking->ticketType->price }};
            const total = quantity * pricePerTicket;
            
            document.getElementById('total-price').textContent = '$' + total.toFixed(2);
        });
    </script>
</x-layout>