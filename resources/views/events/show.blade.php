<x-layout>
    <div class="container mx-auto p-6">
        <div class="mb-6">
            <a href="{{ route('events.index') }}"
                class="inline-flex items-center text-indigo-600 hover:text-indigo-800 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Events
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Event Banner -->
            @if($event->banner_image)
            <div class="relative w-full">
                <!-- For wide landscape images like your stand-up comedy banner -->
                <div class="w-full aspect-[16/9] md:aspect-[21/9] overflow-hidden">
                    <img src="{{ asset('storage/' . $event->banner_image) }}" alt="{{ $event->title }}"
                        class="w-full h-full object-cover object-center">
                </div>

                <!-- Optional overlay for better text readability if needed -->
                <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-10 transition-all duration-300">
                </div>
            </div>
            @else
            <div
                class="w-full aspect-[16/9] md:aspect-[21/9] bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center">
                <h1 class="text-2xl md:text-4xl font-bold text-white text-center px-4">{{ $event->title }}</h1>
            </div>
            @endif

            <!-- Event Details -->
            <div class="p-6 md:p-8">
                <div class="flex flex-wrap items-center justify-between mb-6">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2 md:mb-0">{{ $event->title }}</h1>
                    @if($event->category)
                    <span class="bg-indigo-100 text-indigo-800 text-sm font-medium px-3 py-1 rounded-full">
                        {{ $event->category->name }}
                    </span>
                    @endif
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                    <!-- Left Column - Details -->
                    <div class="lg:col-span-2 space-y-6">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-700 mb-3 border-b border-gray-200 pb-2">Event
                                Description</h2>
                            <div class="prose max-w-none text-gray-600 leading-relaxed">
                                {{ $event->description }}
                            </div>
                        </div>

                        <!-- Additional Details Section -->
                        <div>
                            <h2 class="text-xl font-semibold text-gray-700 mb-3 border-b border-gray-200 pb-2">
                                Additional Information</h2>
                            <div class="prose max-w-none text-gray-600 leading-relaxed">
                                <p>Please arrive 15 minutes before the event start time. For any questions or special
                                    accommodations, contact the event organizer.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Meta Information -->
                    <div class="bg-gray-50 rounded-lg p-6 h-fit space-y-4">
                        <!-- Date & Time -->
                        <h3 class="text-gray-500 text-sm uppercase tracking-wide font-medium mb-2">Date & Time
                        </h3>
                        <div class="flex justify-between items-center">
                            <div class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 mr-3 mt-0.5 text-indigo-600 flex-shrink-0" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <div>
                                    <div class="text-gray-800 font-medium">{{
                                        \Carbon\Carbon::parse($event->date)->format('F d, Y') }}</div>
                                    <div class="text-gray-600 text-sm">{{
                                        \Carbon\Carbon::parse($event->date)->format('g:i A') }}</div>
                                </div>
                            </div>

                            <!-- Status badges -->
                            <div>
                                @if($event->is_published)
                                <span
                                    class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Published</span>
                                @else
                                <span
                                    class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Draft</span>
                                @endif
                            </div>
                        </div>

                        <!-- Location -->
                        <div>
                            <h3 class="text-gray-500 text-sm uppercase tracking-wide font-medium mb-2">Location</h3>
                            <div class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 mr-3 mt-0.5 text-indigo-600 flex-shrink-0" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="text-gray-800 font-medium">{{ $event->location }}</span>
                            </div>
                        </div>

                        <!-- Ticket Types Section -->
                        @if($event->ticketTypes && $event->ticketTypes->count() > 0)
                        <div class="pt-6 border-t border-gray-200">
                            <h3
                                class="text-gray-500 text-sm uppercase tracking-wide font-medium mb-4 flex items-center">
                                <i class="fas fa-ticket-alt text-indigo-500 mr-2"></i>
                                Book Tickets
                            </h3>

                            <form action="{{ route('bookings.store',$event) }}" method="POST" id="payment-form"
                                class="space-y-4">
                                @csrf

                                <!-- Ticket Type Selection -->
                                <div class="space-y-2">
                                    <label for="ticket_type_id" class="block text-sm font-semibold text-gray-700">
                                        <i class="fas fa-tags text-gray-400 mr-2"></i>Select Ticket Type
                                    </label>
                                    <div class="relative">
                                        <select name="ticket_type_id" id="ticket_type_id"
                                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white text-gray-900 appearance-none transition-colors">
                                            <option value="">Choose a ticket type</option>
                                            @foreach($event->ticketTypes as $ticket)
                                            <option value="{{ $ticket->id }}" data-quantity="{{ $ticket->quantity }}"
                                                data-price="{{ $ticket->price }}">
                                                {{ $ticket->name }} - ${{ number_format($ticket->price, 2) }}
                                                @if($ticket->quantity > 0)
                                                ({{ $ticket->quantity }} left)
                                                @else
                                                (Sold Out)
                                                @endif
                                            </option>
                                            @endforeach
                                        </select>
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-list text-gray-400"></i>
                                        </div>
                                        <div
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <i class="fas fa-chevron-down text-gray-400"></i>
                                        </div>
                                    </div>

                                    <!-- Availability indicator -->
                                    <div id="availability-info" class="text-xs mt-1 hidden">
                                        <div id="tickets-available" class="text-green-600">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            <span id="tickets-left">0</span> tickets available
                                        </div>
                                        <div id="tickets-sold-out" class="text-red-600 hidden">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            This ticket type is sold out
                                        </div>
                                    </div>
                                </div>

                                <!-- Quantity Selection -->
                                <div class="space-y-2">
                                    <label for="quantity" class="block text-sm font-semibold text-gray-700">
                                        <i class="fas fa-sort-numeric-up text-gray-400 mr-2"></i>Number of Tickets
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="quantity" id="quantity" min="1" max="10" value="1"
                                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 transition-colors"
                                            required placeholder="1" disabled>
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-hashtag text-gray-400"></i>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1" id="quantity-help">
                                        <i class="fas fa-info-circle mr-1"></i>Please select a ticket type first
                                    </p>
                                </div>

                                <!-- Total Price Display -->
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-medium text-gray-600">
                                            <i class="fas fa-calculator text-gray-400 mr-2"></i>Total Amount
                                        </span>
                                        <span id="total-price" class="text-lg font-bold text-indigo-600">$0.00</span>
                                    </div>
                                </div>

                                <!-- Book Now Button -->
                                <button type="submit" id="book-now-btn" disabled
                                    class="w-full bg-gray-400 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 flex items-center justify-center group cursor-not-allowed">
                                    <i class="fas fa-credit-card mr-2"></i>
                                    <span id="book-now-text">Select a ticket type to continue</span>
                                    <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </form>
                        </div>
                        @else
                        <div class="pt-6 border-t border-gray-200">
                            <div class="text-center py-6">
                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                                    </path>
                                </svg>
                                <p class="text-gray-500 text-sm">No tickets available yet</p>
                                <p class="text-gray-400 text-xs mt-1">Contact the organizer for more information</p>
                            </div>
                        </div>
                        @endif


                    </div>
                </div>
            </div>
        </div>

        <!-- Event Actions for Admins - Can be conditionally displayed -->
        <div class="mt-8 flex flex-wrap gap-4">
            @can('delete',$event)
            @if (Auth::user()->isAdmin())
            <a href="{{ route('admin.events.edit', $event->id) }}"
                class="bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-medium py-2 px-4 rounded-md transition duration-300 ease-in-out flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Event
            </a>
            @else
            <a href="{{ route('events.edit', $event->id) }}"
                class="bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-medium py-2 px-4 rounded-md transition duration-300 ease-in-out flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Event
            </a>
            @endif

            <button type="button" onclick="openDeleteModal()"
                class="bg-red-100 hover:bg-red-200 text-red-700 font-medium py-2 px-4 rounded-md transition duration-300 ease-in-out flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Delete Event
            </button>
            @endcan

            <!-- Delete Modal -->
            <div id="deleteModal"
                class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 hidden items-center justify-center">
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full transform transition-all">
                    <div class="p-6">
                        <div class="text-center">
                            <svg class="h-16 w-16 text-red-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Delete Event</h3>
                            <p class="text-gray-600 mb-6">Are you sure you want to delete <span class="font-semibold">{{
                                    $event->title }}</span>? This action cannot be undone.</p>
                        </div>
                        <div class="flex justify-center space-x-4">
                            <button type="button" onclick="closeDeleteModal()"
                                class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-6 rounded-md transition duration-300">
                                Cancel
                            </button>
                            <form method="POST" action="" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-6 rounded-md transition duration-300">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }
        
        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }
        
        // Close modal when clicking outside of it
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('deleteModal');
            if (event.target === modal) {
                closeDeleteModal();
            }
        });
        
        // Close modal on escape key press
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeDeleteModal();
            }
        });

        // Dynamic price calculation and availability display
        document.addEventListener('DOMContentLoaded', function() {
            const ticketSelect = document.getElementById('ticket_type_id');
            const quantityInput = document.getElementById('quantity');
            const totalPriceElement = document.getElementById('total-price');
            const availabilityInfo = document.getElementById('availability-info');
            const ticketsAvailable = document.getElementById('tickets-available');
            const ticketsSoldOut = document.getElementById('tickets-sold-out');
            const ticketsLeft = document.getElementById('tickets-left');
            const quantityHelp = document.getElementById('quantity-help');
            const bookNowBtn = document.getElementById('book-now-btn');
            const bookNowText = document.getElementById('book-now-text');

            // Store ticket data
            const ticketData = {
                @foreach($event->ticketTypes as $ticket)
                '{{ $ticket->id }}': {
                    price: {{ $ticket->price }},
                    quantity: {{ $ticket->quantity }}
                },
                @endforeach
            };

            function updateTicketInfo() {
                const selectedTicketId = ticketSelect.value;
                
                if (!selectedTicketId) {
                    // No ticket selected
                    availabilityInfo.classList.add('hidden');
                    quantityInput.disabled = true;
                    quantityInput.value = 1;
                    quantityHelp.innerHTML = '<i class="fas fa-info-circle mr-1"></i>Please select a ticket type first';
                    totalPriceElement.textContent = '$0.00';
                    
                    // Disable book button
                    bookNowBtn.disabled = true;
                    bookNowBtn.className = 'w-full bg-gray-400 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 flex items-center justify-center group cursor-not-allowed';
                    bookNowText.textContent = 'Select a ticket type to continue';
                    return;
                }

                const ticketInfo = ticketData[selectedTicketId];
                const availableQuantity = ticketInfo.quantity;

                // Show availability info
                availabilityInfo.classList.remove('hidden');
                
                if (availableQuantity > 0) {
                    // Tickets available
                    ticketsAvailable.classList.remove('hidden');
                    ticketsSoldOut.classList.add('hidden');
                    ticketsLeft.textContent = availableQuantity;
                    
                    // Enable quantity input
                    quantityInput.disabled = false;
                    quantityInput.max = Math.min(availableQuantity, 10);
                    
                    // Update help text
                    const maxTickets = Math.min(availableQuantity, 10);
                    quantityHelp.innerHTML = `<i class="fas fa-info-circle mr-1"></i>Maximum ${maxTickets} tickets available`;
                    
                    // Enable book button
                    bookNowBtn.disabled = false;
                    bookNowBtn.className = 'w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 transform hover:scale-105 hover:shadow-lg flex items-center justify-center group';
                    bookNowText.textContent = 'Book Now';
                    
                } else {
                    // Sold out
                    ticketsAvailable.classList.add('hidden');
                    ticketsSoldOut.classList.remove('hidden');
                    
                    // Disable quantity input
                    quantityInput.disabled = true;
                    quantityInput.value = 0;
                    quantityHelp.innerHTML = '<i class="fas fa-exclamation-circle mr-1"></i>This ticket type is sold out';
                    
                    // Disable book button
                    bookNowBtn.disabled = true;
                    bookNowBtn.className = 'w-full bg-gray-400 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 flex items-center justify-center group cursor-not-allowed';
                    bookNowText.textContent = 'Sold Out';
                }

                updateTotalPrice();
            }

            function updateTotalPrice() {
                const selectedTicketId = ticketSelect.value;
                const quantity = parseInt(quantityInput.value) || 0;
                
                if (!selectedTicketId || !ticketData[selectedTicketId]) {
                    totalPriceElement.textContent = '$0.00';
                    return;
                }
                
                const ticketPrice = ticketData[selectedTicketId].price;
                const total = ticketPrice * quantity;
                
                totalPriceElement.textContent = '$' + total.toFixed(2);
            }

            // Event listeners
            if (ticketSelect) {
                ticketSelect.addEventListener('change', updateTicketInfo);
            }
            
            if (quantityInput) {
                quantityInput.addEventListener('input', updateTotalPrice);
            }
            
            // Initial state
            updateTicketInfo();
        });
    </script>
</x-layout>