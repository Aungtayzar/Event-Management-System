<x-layout>
    <!-- Hero Section with Overlay -->
    <div class="relative bg-gradient-to-r from-indigo-600 to-purple-700">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-800 to-purple-900 mix-blend-multiply opacity-90">
            </div>
            <div class="absolute inset-0 bg-cover bg-center opacity-20"
                style="background-image: url('{{ asset('storage/event_banners/eventbanner.jpg') }}')"></div>
        </div>
        <div class="container mx-auto px-6 py-16 relative z-10">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 leading-tight">
                Discover Extraordinary <span class="text-yellow-300">Events</span>
            </h1>
            <p class="text-lg md:text-xl text-indigo-100 mb-8 max-w-2xl">
                Find and book the best events in your area. From conferences to concerts, we've got you covered.
            </p>
        </div>

        <!-- Search Panel -->
        <div class="container mx-auto relative z-20 -bottom-10">
            <div class="bg-white rounded-lg shadow-xl p-6">
                <form action="{{ route('events.search') }}" method="GET" class="relative">
                    <div class="grid grid-cols-1 md:grid-cols-7 gap-4">
                        <div class="md:col-span-2">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Keywords</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" name="search" id="search" placeholder="Search events..."
                                    value="{{ request('search') }}"
                                    class="pl-10 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full outline-0 border p-2 sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div>
                            <label for="category_id"
                                class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select name="category_id" id="category_id"
                                class="shadow-sm border focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md outline-none p-2">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id')==$category->id ?
                                    'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                            <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                                class="shadow-sm border focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md outline-none p-2"
                                placeholder="Start date">
                        </div>

                        <div>
                            <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                            <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                                class="shadow-sm border focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md outline-none p-2"
                                placeholder="End date">
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                            <input type="text" name="location" id="location" placeholder="Any location"
                                value="{{ request('location') }}"
                                class="shadow-sm border focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md outline-none p-2">
                        </div>

                        <div class="md:col-span-1 flex items-end gap-2">
                            <button type="submit"
                                class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-md shadow-sm transition duration-200 flex items-center justify-center">
                                <span>Search</span>
                                <svg class="ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                            <a href="{{ route('events.index') }}"
                                class="px-3 py-2 border border-gray-300 hover:border-gray-400 text-gray-700 hover:text-gray-900 rounded-md shadow-sm transition duration-200 flex items-center justify-center bg-white"
                                title="Clear all filters">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Advanced Filter -->
                    <div class="mt-3 text-right relative z-30">
                        <button type="button" id="advancedFilterToggle"
                            class="text-sm text-indigo-600 hover:text-indigo-800 inline-flex items-center">
                            <span>Advanced filters</span>
                            <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </div>

                    <div id="advancedFilters" class="hidden mt-4 pt-4 border-t border-gray-200 relative z-30 bg-white">
                        <div class="flex items-end gap-4">
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                                <select name="price" id="price"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-40 sm:text-sm border-gray-300 rounded-md p-2 border outline-none">
                                    <option value="">Any Price</option>
                                    <option value="free" {{ request('price')=='free' ? 'selected' : '' }}>Free</option>
                                    <option value="paid" {{ request('price')=='paid' ? 'selected' : '' }}>Paid</option>
                                </select>
                            </div>
                            <div>
                                <a href="{{ route('events.index') }}"
                                    class="text-gray-600 hover:text-gray-800 inline-flex items-center">
                                    <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Reset all filters
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-gray-50 pt-20 pb-12 ">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">
                        @if(request()->anyFilled(['search', 'category_id', 'date_from', 'date_to', 'location', 'price']))
                            Search Results
                        @else
                            Upcoming Events
                        @endif
                    </h2>
                    <p class="text-gray-600 mt-1">
                        @if(request()->anyFilled(['search', 'category_id', 'date_from', 'date_to', 'location', 'price']))
                            @php
                                $filters = [];
                                if(request('search')) $filters[] = 'keyword: "' . request('search') . '"';
                                if(request('category_id')) {
                                    $category = $categories->find(request('category_id'));
                                    if($category) $filters[] = 'category: ' . $category->name;
                                }
                                if(request('date_from') && request('date_to')) {
                                    $filters[] = 'dates: ' . \Carbon\Carbon::parse(request('date_from'))->format('M j, Y') . ' - ' . \Carbon\Carbon::parse(request('date_to'))->format('M j, Y');
                                } elseif(request('date_from')) {
                                    $filters[] = 'from: ' . \Carbon\Carbon::parse(request('date_from'))->format('M j, Y');
                                } elseif(request('date_to')) {
                                    $filters[] = 'until: ' . \Carbon\Carbon::parse(request('date_to'))->format('M j, Y');
                                }
                                if(request('location')) $filters[] = 'location: "' . request('location') . '"';
                                if(request('price')) $filters[] = 'price: ' . request('price');
                            @endphp
                            Filtered by {{ implode(', ', $filters) }}
                        @else
                            Discover events that match your interests
                        @endif
                    </p>
                </div>
                <div class="hidden md:block">
                    <div class="inline-flex bg-green-300 rounded-full shadow px-2 py-1">
                        <!-- Sort options would go here -->
                        <span class="text-sm">{{ count($events) }} events
                            found</span>
                    </div>
                </div>
            </div>

            <!-- Events Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-10">
                @forelse($events as $event)
                <div class="group">
                    <div
                        class="bg-white rounded-xl shadow-sm overflow-hidden group-hover:shadow-md transition-all duration-300 {{ $event->isPast() ? 'opacity-75' : '' }}">
                        <div class="relative">
                            @if($event->banner_image)
                            <img src="{{ asset('storage/' . $event->banner_image) }}" alt="{{ $event->title }}"
                                class="w-full h-56 object-cover transition-transform duration-500 group-hover:scale-105 {{ $event->isPast() ? 'grayscale' : '' }}"
                                onerror="this.src='{{ asset('storage/event-placeholder.jpg') }}';this.onerror='';">
                            @else
                            <div
                                class="w-full h-56 bg-gradient-to-br from-indigo-500 to-purple-700 flex items-center justify-center {{ $event->isPast() ? 'grayscale' : '' }}">
                                <span class="text-white text-xl font-bold">{{ $event->title }}</span>
                            </div>
                            @endif

                            <!-- Category Badge -->
                            <div class="absolute top-4 left-4">
                                <span
                                    class="px-3 py-1.5 bg-white bg-opacity-90 text-indigo-800 rounded-full text-xs font-medium shadow-sm">
                                    {{ $event->category->name ?? 'Event' }}
                                </span>
                            </div>

                            <!-- Date Badge or Past Event Badge -->
                            <div class="absolute top-4 right-4">
                                @if($event->isPast())
                                <div class="bg-gray-500 text-white rounded-lg px-3 py-2 text-center shadow-lg">
                                    <span class="text-xs font-medium">EVENT ENDED</span>
                                </div>
                                @else
                                <div
                                    class="bg-indigo-600 text-white rounded-lg overflow-hidden text-center w-16 shadow-lg">
                                    <div class="bg-indigo-700 py-1">
                                        <span class="text-xs font-medium uppercase">{{
                                            \Carbon\Carbon::parse($event->date)->format('M') }}</span>
                                    </div>
                                    <div class="py-1">
                                        <span class="text-lg font-bold">{{
                                            \Carbon\Carbon::parse($event->date)->format('d') }}</span>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="p-6">
                            <h3
                                class="text-xl font-bold text-gray-800 mb-2 group-hover:text-indigo-600 transition-colors duration-200">
                                {{ $event->title }}
                                @if($event->isPast())
                                <span class="text-sm text-gray-500 font-normal">(Past Event)</span>
                                @endif
                            </h3>

                            <p class="text-gray-600 mb-5 line-clamp-2">{{
                                \Illuminate\Support\Str::limit($event->description, 120) }}</p>

                            <div class="flex items-center text-gray-500 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ $event->location }}</span>
                            </div>

                            <div class="flex justify-between items-center mt-6">
                                <!-- Price would go here if available -->
                                <div class="text-gray-900 font-semibold">
                                    @if($event->ticketTypes && $event->ticketTypes->count() > 0)
                                    @php
                                    $minPrice = $event->ticketTypes->min('price');
                                    $maxPrice = $event->ticketTypes->max('price');
                                    @endphp
                                    @if($minPrice == 0 && $maxPrice == 0)
                                    <span class="text-green-600">Free</span>
                                    @elseif($minPrice == $maxPrice)
                                    ${{ number_format($minPrice, 2) }}
                                    @else
                                    ${{ number_format($minPrice, 2) }} - ${{ number_format($maxPrice, 2) }}
                                    @endif
                                    @else
                                    <span class="text-gray-500">No tickets available</span>
                                    @endif
                                </div>

                                <a href="{{ route('events.show', $event->id) }}"
                                    class="inline-flex items-center px-4 py-2 border {{ $event->isPast() ? 'border-gray-400 text-gray-500' : 'border-indigo-600 text-indigo-600 hover:bg-indigo-600 hover:text-white' }} text-sm font-medium rounded-md bg-white transition-colors duration-200">
                                    {{ $event->isPast() ? 'View Event' : 'View Details' }}
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 ml-2 group-hover:translate-x-1 transition-transform duration-200"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-3">
                    <div class="bg-white border border-gray-200 rounded-lg p-8 text-center shadow-sm">
                        <svg class="w-16 h-16 mx-auto text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <h3 class="mt-4 text-xl font-medium text-gray-900">No events found</h3>
                        <p class="mt-2 text-gray-600 mb-6">We couldn't find any events matching your criteria.</p>
                        <a href="{{ route('events.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                            Clear filters
                        </a>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination would go here -->

        </div>
    </div>

    <!-- JavaScript for Advanced Filter Toggle and Date Range -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const advancedFilterToggle = document.getElementById('advancedFilterToggle');
            const advancedFilters = document.getElementById('advancedFilters');
            
            if (advancedFilterToggle && advancedFilters) {
                advancedFilterToggle.addEventListener('click', function() {
                    advancedFilters.classList.toggle('hidden');
                    
                    // Toggle icon
                    const svg = advancedFilterToggle.querySelector('svg');
                    if (svg) {
                        if (advancedFilters.classList.contains('hidden')) {
                            svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />';
                        } else {
                            svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />';
                        }
                    }
                });
            }

            // Date range validation
            const dateFromInput = document.getElementById('date_from');
            const dateToInput = document.getElementById('date_to');
            
            if (dateFromInput && dateToInput) {
                // When from date changes, update min date for to date
                dateFromInput.addEventListener('change', function() {
                    if (this.value) {
                        dateToInput.min = this.value;
                        // If to date is before from date, clear it
                        if (dateToInput.value && dateToInput.value < this.value) {
                            dateToInput.value = '';
                        }
                    } else {
                        dateToInput.min = '';
                    }
                });

                // When to date changes, update max date for from date
                dateToInput.addEventListener('change', function() {
                    if (this.value) {
                        dateFromInput.max = this.value;
                        // If from date is after to date, clear it
                        if (dateFromInput.value && dateFromInput.value > this.value) {
                            dateFromInput.value = '';
                        }
                    } else {
                        dateFromInput.max = '';
                    }
                });

                // Initialize constraints if values are already set
                if (dateFromInput.value) {
                    dateToInput.min = dateFromInput.value;
                }
                if (dateToInput.value) {
                    dateFromInput.max = dateToInput.value;
                }
            }
        });
    </script>
</x-layout>