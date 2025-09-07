<x-layout>
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-purple-600 to-indigo-700 text-white">
        <div class="container mx-auto px-4 py-24">
            <div class="max-w-3xl">
                <h1 class="text-5xl font-extrabold mb-6 leading-tight">Discover Amazing Events Near You</h1>
                <p class="text-xl mb-8 opacity-90">Join thousands of people attending the most exciting events in your
                    area.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('events.index') }}"
                        class="px-6 py-3 bg-white text-indigo-700 font-semibold rounded-lg shadow-md hover:bg-gray-100 transition duration-200">Browse
                        Events</a>
                    @auth
                    @if (Auth::user()->isOrganizer())
                    <a href="{{ route('events.create') }}"
                        class="px-6 py-3 bg-white text-indigo-700 font-semibold rounded-lg shadow-md hover:bg-gray-100 transition duration-200">Create
                        Event</a>
                    @else
                    <a href=""
                        class="px-6 py-3 bg-white text-indigo-700 font-semibold rounded-lg shadow-md hover:bg-gray-100 transition duration-200">Register
                        for Event</a>
                    @endif
                    @endauth
                </div>
            </div>
        </div>
        <div class="hidden lg:block absolute right-0 bottom-0 w-1/3 h-full">
            <div class="absolute inset-0 bg-white opacity-10 rounded-tl-[100px]"></div>
        </div>
    </div>

    <!-- Featured Events Section -->
    <div class="bg-gray-50 py-16">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">Featured Events</h2>
                    <p class="text-gray-600 mt-2">Don't miss out on these popular events</p>
                </div>
                <a href="{{ route('events.index') }}"
                    class="text-indigo-600 font-medium hover:text-indigo-800 flex items-center">
                    View all events
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($events as $event)
                <div
                    class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <!-- Image wrapper with aspect ratio -->
                    <div class="aspect-w-16 aspect-h-9">
                        <img src="{{ asset('storage/' . $event->banner_image) }}" alt="{{ $event->title }}"
                            class="w-full h-64 object-cover"
                            onerror="this.src='https://via.placeholder.com/800x400?text=Event+Image';this.onerror='';">
                    </div>

                    <div class="p-6">
                        <div class="flex items-center gap-x-3 mb-4">
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs font-medium">
                                {{ $event->category->name ?? 'Event' }}
                            </span>
                            <span class="text-gray-500 text-sm">
                                {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}
                            </span>
                        </div>

                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $event->title }}</h3>
                        <p class="text-gray-600 line-clamp-2 mb-4">
                            {{ \Illuminate\Support\Str::limit($event->description, 120) }}
                        </p>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('events.show', $event) }}"
                                class="text-indigo-600 font-medium hover:text-indigo-800 flex items-center">
                                View details
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 
                                   7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 
                                   010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>

                            <div class="text-gray-800 font-semibold">
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
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-8">
                    <p class="text-gray-500">No events available at the moment. Please check back soon!</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- How It Works Section -->
    <div class="container mx-auto py-16 px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800">How It Works</h2>
            <p class="text-gray-600 mt-2 max-w-2xl mx-auto">Our platform makes it easy to discover, book, and enjoy
                events</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-6">
                <div
                    class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Discover Events</h3>
                <p class="text-gray-600">Browse through our curated list of events, filter by category, date, or
                    location to find the perfect event for you.</p>
            </div>

            <div class="text-center p-6">
                <div
                    class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Book Tickets</h3>
                <p class="text-gray-600">Secure your spot with our easy booking system. Choose your ticket type and
                    complete your purchase in minutes.</p>
            </div>

            <div class="text-center p-6">
                <div
                    class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Attend & Enjoy</h3>
                <p class="text-gray-600">Receive your tickets instantly. Show up at the event, present your ticket, and
                    enjoy an unforgettable experience.</p>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-indigo-700 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-6">Ready to Host Your Own Event?</h2>
            <p class="text-xl opacity-90 max-w-2xl mx-auto mb-8">Join our community of event organizers and reach
                thousands of potential attendees.</p>
            <a href="{{ route('register') }}"
                class="px-8 py-4 bg-white text-indigo-700 font-bold rounded-lg shadow-lg hover:bg-gray-100 transition duration-200 inline-block">
                Become an Organizer
            </a>
        </div>
    </div>
</x-layout>