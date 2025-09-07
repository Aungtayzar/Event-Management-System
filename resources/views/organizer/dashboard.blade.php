<x-layout>
    <div class="bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 py-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Organizer Dashboard</h1>
                <a href="{{ route('events.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-lg transition duration-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create New Event
                </a>
            </div>

            @if($events->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-10 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <h2 class="text-xl font-medium text-gray-700">No events created yet</h2>
                <p class="text-gray-500 mt-2">Create your first event to get started</p>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($events as $event)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                    <div class="h-40 bg-gray-200 overflow-hidden">
                        @if($event->banner_image)
                        <img src="{{ asset('storage/' . $event->banner_image) }}" alt="{{ $event->title }}"
                            class="w-full h-full object-cover">
                        @else
                        <div
                            class="w-full h-full flex items-center justify-center bg-gradient-to-r from-blue-500 to-purple-500">
                            <span class="text-white font-bold text-xl">{{ strtoupper(substr($event->title, 0, 2))
                                }}</span>
                        </div>
                        @endif
                    </div>
                    <div class="p-5">
                        <h2 class="text-xl font-semibold text-gray-800 mb-2 truncate">{{ $event->title }}</h2>
                        <div class="flex items-center text-gray-600 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</span>
                        </div>

                        <div class="flex items-center text-gray-600 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($event->date)->format('g:i A') }}</span>
                        </div>

                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span class="text-gray-700 font-medium">{{ $event->bookings_count ?? 0 }}
                                    attendees</span>
                            </div>

                            <span
                                class="px-3 py-1 bg-{{ $event->is_published ? 'green' : 'amber' }}-100 text-{{ $event->is_published ? 'green' : 'amber' }}-800 rounded-full text-xs font-medium">
                                {{ $event->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </div>

                        <!-- Ticket Types Section -->
                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="text-md font-medium text-gray-800">Ticket Types</h4>
                                <a href="{{ route('ticket-types.create', $event) }}"
                                    class="bg-green-500 text-white px-3 py-1 rounded text-xs hover:bg-green-600 transition duration-200">
                                    <i class="fas fa-plus mr-1"></i>Add Ticket
                                </a>
                            </div>

                            @if($event->ticketTypes && $event->ticketTypes->count() > 0)
                            <div class="space-y-2">
                                @foreach($event->ticketTypes as $ticketType)
                                <div class="flex justify-between items-center bg-gray-50 p-2 rounded">
                                    <div class="flex-1">
                                        <span class="font-medium text-sm">{{ $ticketType->name }}</span>
                                        <div class="flex items-center text-xs text-gray-600 mt-1">
                                            <span class="mr-3">${{ number_format($ticketType->price, 2) }}</span>
                                            <span>{{ $ticketType->quantity }} available</span>
                                        </div>
                                    </div>
                                    <div class="flex gap-1">
                                        <a href="{{ route('ticket-types.edit', $ticketType) }}"
                                            class="text-blue-500 hover:text-blue-700 p-1">
                                            <i class="fas fa-edit text-xs"></i>
                                        </a>
                                        <form method="POST" action="{{ route('ticket-types.destroy', $ticketType) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this ticket type?')"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 p-1">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <p class="text-gray-500 text-xs">No ticket types created yet.</p>
                            @endif
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <a href="{{ route('events.edit', $event) }}"
                                class="text-blue-600 hover:text-blue-800 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                Edit
                            </a>

                            <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline"
                                onsubmit="return confirm('Are you sure you want to delete this event?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- <div class="mt-6">
                {{ $events->links() }}
            </div> --}}
            @endif
        </div>
    </div>
</x-layout>