<x-layout>
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Cancel Booking</h1>
                <p class="text-gray-600 mt-1">Booking #{{ $booking->id }} - {{ $booking->user->name }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.bookings.show', $booking) }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Details
                </a>
            </div>
        </div>

        <!-- Warning Message -->
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-6">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <div>
                    <strong>Warning:</strong> This action cannot be undone. The booking will be cancelled and tickets
                    will be returned to the available pool.
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
            <!-- Cancellation Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Cancellation Details</h2>

                    <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST">
                        @csrf

                        <!-- Reason -->
                        <div class="mb-6">
                            <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                                Cancellation Reason <span class="text-red-500">*</span>
                            </label>
                            <select name="reason" id="reason" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                                <option value="">Select a reason...</option>
                                @foreach($cancellationReasons as $value => $label)
                                <option value="{{ $value }}" {{ old('reason')==$value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Additional Notes
                            </label>
                            <textarea name="notes" id="notes" rows="4"
                                placeholder="Provide additional details about the cancellation..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">{{ old('notes') }}</textarea>
                            <p class="text-sm text-gray-500 mt-1">These notes will be recorded for audit purposes</p>
                        </div>

                        <!-- Refund Amount -->
                        <div class="mb-6">
                            <label for="refund_amount" class="block text-sm font-medium text-gray-700 mb-2">
                                Refund Amount <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-gray-500">$</span>
                                <input type="number" name="refund_amount" id="refund_amount" min="0"
                                    max="{{ $booking->total_price }}" step="0.01"
                                    value="{{ old('refund_amount', $booking->total_price) }}" required
                                    class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                            </div>
                            <div class="flex justify-between mt-2">
                                <p class="text-sm text-gray-500">Maximum: ${{ number_format($booking->total_price, 2) }}
                                </p>
                                <div class="flex gap-2">
                                    <button type="button" onclick="setRefundAmount({{ $booking->total_price }})"
                                        class="text-sm text-blue-600 hover:text-blue-800">Full Refund</button>
                                    <span class="text-gray-300">|</span>
                                    <button type="button" onclick="setRefundAmount(0)"
                                        class="text-sm text-blue-600 hover:text-blue-800">No Refund</button>
                                </div>
                            </div>
                        </div>

                        <!-- Refund Status -->
                        <div class="mb-6">
                            <label for="refund_status" class="block text-sm font-medium text-gray-700 mb-2">
                                Refund Status <span class="text-red-500">*</span>
                            </label>
                            <select name="refund_status" id="refund_status" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                                <option value="pending" {{ old('refund_status', 'pending' )=='pending' ? 'selected' : ''
                                    }}>
                                    Pending - Refund to be processed
                                </option>
                                <option value="completed" {{ old('refund_status')=='completed' ? 'selected' : '' }}>
                                    Completed - Refund has been processed
                                </option>
                                <option value="failed" {{ old('refund_status')=='failed' ? 'selected' : '' }}>
                                    Failed - Refund processing failed
                                </option>
                            </select>
                        </div>

                        <!-- Confirmation Checkbox -->
                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="confirm_cancellation" id="confirm_cancellation" required
                                    class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">
                                    I understand that this booking will be permanently cancelled and cannot be undone.
                                </span>
                            </label>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex gap-4">
                            <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-md transition duration-200"
                                onclick="return confirm('Are you sure you want to cancel this booking? This action cannot be undone.')">
                                <i class="fas fa-ban mr-2"></i>Cancel Booking
                            </button>
                            <a href="{{ route('admin.bookings.show', $booking) }}"
                                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md transition duration-200">
                                <i class="fas fa-times mr-2"></i>Keep Booking
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Booking Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Booking Summary</h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Booking ID</label>
                            <p class="font-medium">#{{ $booking->id }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Customer</label>
                            <p class="font-medium">{{ $booking->user->name }}</p>
                            <p class="text-sm text-gray-600">{{ $booking->user->email }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Event</label>
                            <p class="font-medium">{{ $booking->event->title }}</p>
                            <p class="text-sm text-gray-600">{{ date('F j, Y', strtotime($booking->event->date)) }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Tickets</label>
                            <p class="font-medium">{{ $booking->quantity }} × {{ $booking->ticketType->name }}</p>
                            <p class="text-sm text-gray-600">${{ number_format($booking->ticketType->price, 2) }} each
                            </p>
                        </div>

                        <div class="border-t pt-4">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Total Paid</label>
                            <p class="font-bold text-lg text-green-600">${{ number_format($booking->total_price, 2) }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Booking Date</label>
                            <p class="text-sm">{{ $booking->created_at->format('F j, Y \a\t g:i A') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Impact Warning -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                    <h4 class="text-md font-semibold text-yellow-800 mb-3">
                        <i class="fas fa-exclamation-circle mr-2"></i>Cancellation Impact
                    </h4>
                    <ul class="text-sm text-yellow-700 space-y-2">
                        <li>• {{ $booking->quantity }} tickets will be returned to available pool</li>
                        <li>• Customer will receive cancellation notification</li>
                        <li>• Cancellation record will be created for audit</li>
                        <li>• Action cannot be reversed</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setRefundAmount(amount) {
            document.getElementById('refund_amount').value = amount.toFixed(2);
        }

        // Auto-select reason-specific refund amounts
        document.getElementById('reason').addEventListener('change', function() {
            const reason = this.value;
            const totalPrice = {{ $booking->total_price }};
            const refundInput = document.getElementById('refund_amount');
            
            switch(reason) {
                case 'fraud':
                case 'system_error':
                    refundInput.value = totalPrice.toFixed(2);
                    break;
                case 'payment_failed':
                    refundInput.value = '0.00';
                    break;
                case 'event_cancelled':
                    refundInput.value = totalPrice.toFixed(2);
                    break;
                default:
                    // Keep current value
                    break;
            }
        });
    </script>
</x-layout>