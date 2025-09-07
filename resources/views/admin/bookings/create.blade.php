<x-layout>
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Create New Booking</h1>
                <p class="text-gray-600 mt-1">Create a booking on behalf of a customer</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.bookings.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Back to List
                </a>
            </div>
        </div>

        <!-- Info Message -->
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-md mb-6">
            <div class="flex items-center">
                <i class="fas fa-info-circle mr-2"></i>
                <div>
                    Use this form to create bookings manually for customers who booked over phone, in-person, or for
                    administrative purposes.
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
            <!-- Create Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <form action="{{ route('admin.bookings.store') }}" method="POST" id="booking-form">
                        @csrf

                        <!-- Customer Selection -->
                        <div class="mb-6">
                            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Customer <span class="text-red-500">*</span>
                            </label>
                            <select name="user_id" id="user_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select a customer...</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id')==$user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                                @endforeach
                            </select>
                            <p class="text-sm text-gray-500 mt-1">Select the customer for this booking</p>
                        </div>

                        <!-- Event Selection -->
                        <div class="mb-6">
                            <label for="event_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Event <span class="text-red-500">*</span>
                            </label>
                            <select name="event_id" id="event_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select an event...</option>
                                @foreach($events as $event)
                                <option value="{{ $event->id }}" {{ old('event_id')==$event->id ? 'selected' : '' }}>
                                    {{ $event->title }} - {{ date('M j, Y', strtotime($event->date)) }}
                                </option>
                                @endforeach
                            </select>
                            <p class="text-sm text-gray-500 mt-1">Only upcoming events are shown</p>
                        </div>

                        <!-- Ticket Type Selection -->
                        <div class="mb-6">
                            <label for="ticket_type_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Ticket Type <span class="text-red-500">*</span>
                            </label>
                            <select name="ticket_type_id" id="ticket_type_id" required disabled
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:bg-gray-100">
                                <option value="">Select an event first...</option>
                            </select>
                            <p class="text-sm text-gray-500 mt-1">Available ticket types will load after selecting an
                                event</p>
                        </div>

                        <!-- Quantity -->
                        <div class="mb-6">
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                                Quantity <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="quantity" id="quantity" min="1" value="{{ old('quantity', 1) }}"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-sm text-gray-500 mt-1" id="availability-info">
                                Select a ticket type to see availability
                            </p>
                        </div>

                        <!-- Status -->
                        <div class="mb-6">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status" id="status" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="confirmed" {{ old('status', 'confirmed' )=='confirmed' ? 'selected' : ''
                                    }}>
                                    Confirmed
                                </option>
                                <option value="pending" {{ old('status')=='pending' ? 'selected' : '' }}>
                                    Pending
                                </option>
                            </select>
                            <p class="text-sm text-gray-500 mt-1">Set to pending if payment is not yet confirmed</p>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Admin Notes</label>
                            <textarea name="notes" id="notes" rows="4"
                                placeholder="Add any notes about this manual booking..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes') }}</textarea>
                            <p class="text-sm text-gray-500 mt-1">Internal notes (not visible to customer)</p>
                        </div>

                        <!-- Total Price Display -->
                        <div class="mb-6 bg-green-50 p-4 rounded-md">
                            <label class="block text-sm font-medium text-green-700 mb-1">Total Price</label>
                            <p class="text-2xl font-bold text-green-900" id="total-price">$0.00</p>
                            <p class="text-sm text-green-600">Price will calculate automatically</p>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex gap-4">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition duration-200">
                                <i class="fas fa-plus mr-2"></i>Create Booking
                            </button>
                            <a href="{{ route('admin.bookings.index') }}"
                                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md transition duration-200">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help & Guidelines -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>Guidelines
                    </h3>

                    <div class="space-y-4 text-sm text-gray-700">
                        <div>
                            <h4 class="font-medium text-gray-900 mb-2">When to use manual booking:</h4>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Phone or in-person bookings</li>
                                <li>Group bookings with special arrangements</li>
                                <li>Complimentary tickets</li>
                                <li>System error corrections</li>
                            </ul>
                        </div>

                        <div>
                            <h4 class="font-medium text-gray-900 mb-2">Remember to:</h4>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Verify customer details</li>
                                <li>Confirm payment if applicable</li>
                                <li>Send confirmation email</li>
                                <li>Document reason in notes</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h4 class="text-md font-semibold text-blue-800 mb-3">
                        <i class="fas fa-chart-bar mr-2"></i>Quick Stats
                    </h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-blue-700">Total Customers:</span>
                            <span class="font-medium text-blue-900">{{ $users->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-blue-700">Upcoming Events:</span>
                            <span class="font-medium text-blue-900">{{ $events->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentTicketTypes = [];

        // Load ticket types when event changes
        document.getElementById('event_id').addEventListener('change', function() {
            const eventId = this.value;
            const ticketTypeSelect = document.getElementById('ticket_type_id');
            const quantityInput = document.getElementById('quantity');
            
            if (eventId) {
                // Enable ticket type dropdown and show loading
                ticketTypeSelect.disabled = false;
                ticketTypeSelect.innerHTML = '<option value="">Loading...</option>';
                
                // Fetch ticket types
                fetch(`/admin/bookings/events/${eventId}/ticket-types`)
                    .then(response => response.json())
                    .then(data => {
                        currentTicketTypes = data;
                        ticketTypeSelect.innerHTML = '<option value="">Select a ticket type...</option>';
                        
                        data.forEach(ticketType => {
                            const option = document.createElement('option');
                            option.value = ticketType.id;
                            option.textContent = `${ticketType.name} - $${parseFloat(ticketType.price).toFixed(2)} (${ticketType.quantity} available)`;
                            option.dataset.price = ticketType.price;
                            option.dataset.quantity = ticketType.quantity;
                            ticketTypeSelect.appendChild(option);
                        });
                        
                        // Reset quantity and price
                        quantityInput.value = 1;
                        updateTotalPrice();
                    })
                    .catch(error => {
                        console.error('Error loading ticket types:', error);
                        ticketTypeSelect.innerHTML = '<option value="">Error loading ticket types</option>';
                    });
            } else {
                ticketTypeSelect.disabled = true;
                ticketTypeSelect.innerHTML = '<option value="">Select an event first...</option>';
                updateAvailabilityInfo();
                updateTotalPrice();
            }
        });

        // Update availability info when ticket type changes
        document.getElementById('ticket_type_id').addEventListener('change', function() {
            updateAvailabilityInfo();
            updateTotalPrice();
        });

        // Update total price when quantity changes
        document.getElementById('quantity').addEventListener('input', function() {
            updateTotalPrice();
        });

        function updateAvailabilityInfo() {
            const ticketTypeSelect = document.getElementById('ticket_type_id');
            const availabilityInfo = document.getElementById('availability-info');
            const quantityInput = document.getElementById('quantity');
            
            if (ticketTypeSelect.value) {
                const selectedOption = ticketTypeSelect.options[ticketTypeSelect.selectedIndex];
                const availableQuantity = selectedOption.dataset.quantity;
                
                availabilityInfo.textContent = `${availableQuantity} tickets available`;
                quantityInput.max = availableQuantity;
                
                if (parseInt(quantityInput.value) > parseInt(availableQuantity)) {
                    quantityInput.value = availableQuantity;
                }
            } else {
                availabilityInfo.textContent = 'Select a ticket type to see availability';
                quantityInput.removeAttribute('max');
            }
        }

        function updateTotalPrice() {
            const ticketTypeSelect = document.getElementById('ticket_type_id');
            const quantityInput = document.getElementById('quantity');
            const totalPriceElement = document.getElementById('total-price');
            
            if (ticketTypeSelect.value && quantityInput.value) {
                const selectedOption = ticketTypeSelect.options[ticketTypeSelect.selectedIndex];
                const price = parseFloat(selectedOption.dataset.price) || 0;
                const quantity = parseInt(quantityInput.value) || 0;
                const total = price * quantity;
                
                totalPriceElement.textContent = '$' + total.toFixed(2);
            } else {
                totalPriceElement.textContent = '$0.00';
            }
        }

        // Initialize
        updateAvailabilityInfo();
        updateTotalPrice();
    </script>
</x-layout>