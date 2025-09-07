<x-layout>
    <div class="min-h-screen">
        <div class="container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8">
                <div class="mb-4 lg:gap-2 mr-4">
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">
                        <i class="fas fa-user text-green-600 mr-3"></i>
                        User Details
                    </h1>
                    <p class="text-gray-600">View complete user information, activity, and account details.</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('users.index') }}"
                        class="flex justify-center items-center px-4 py-4 text-gray-50 bg-green-500 hover:bg-green-600 font-semibold rounded-lg shadow-md transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Users
                    </a>
                    <a href="{{ route('users.edit', $user) }}"
                        class="flex justify-center items-center px-4 py-4 text-gray-50 bg-blue-500 hover:bg-blue-600 font-semibold rounded-lg shadow-md transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-edit mr-2"></i>
                        Edit User
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- User Profile Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <!-- Profile Header -->
                        <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-8 text-center">
                            <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-user text-green-600 text-3xl"></i>
                            </div>
                            <h2 class="text-xl font-bold text-white mb-2">{{ $user->name }}</h2>
                            <p class="text-green-100">{{ $user->email }}</p>

                            @php
                            $roleColors = [
                            'admin' => 'bg-red-500',
                            'organizer' => 'bg-blue-500',
                            'attendee' => 'bg-gray-500'
                            ];
                            $roleIcons = [
                            'admin' => 'fas fa-crown',
                            'organizer' => 'fas fa-star',
                            'attendee' => 'fas fa-user'
                            ];
                            @endphp

                            <div class="mt-4">
                                <span
                                    class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium text-white {{ $roleColors[$user->role] ?? $roleColors['attendee'] }}">
                                    <i class="{{ $roleIcons[$user->role] ?? $roleIcons['attendee'] }} mr-2"></i>
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>
                        </div>

                        <!-- Profile Details -->
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Account Information</h3>

                            <div class="space-y-4">
                                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <span class="text-gray-600 flex items-center">
                                        <i class="fas fa-calendar-plus mr-2"></i>
                                        Joined
                                    </span>
                                    <span class="font-medium text-gray-800">{{ $user->created_at->format('M d, Y')
                                        }}</span>
                                </div>

                                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <span class="text-gray-600 flex items-center">
                                        <i class="fas fa-calendar-check mr-2"></i>
                                        Last Updated
                                    </span>
                                    <span class="font-medium text-gray-800">{{ $user->updated_at->format('M d, Y')
                                        }}</span>
                                </div>

                                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <span class="text-gray-600 flex items-center">
                                        <i class="fas fa-hashtag mr-2"></i>
                                        Attendee ID
                                    </span>
                                    <span class="font-medium text-gray-800">#{{ $user->id }}</span>
                                </div>

                                <div class="flex items-center justify-between py-2">
                                    <span class="text-gray-600 flex items-center">
                                        <i class="fas fa-envelope-open mr-2"></i>
                                        Email Verified
                                    </span>
                                    <span class="font-medium">
                                        @if($user->email_verified_at)
                                        <span class="text-green-600">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Verified
                                        </span>
                                        @else
                                        <span class="text-red-600">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Not Verified
                                        </span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Overview -->
                <div class="lg:col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Events Card -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Events Created</h3>
                                    <p class="text-gray-600 text-sm">Total events organized</p>
                                </div>
                                <div class="bg-indigo-100 rounded-full p-3">
                                    <i class="fas fa-calendar-alt text-indigo-600 text-xl"></i>
                                </div>
                            </div>
                            <div class="text-3xl font-bold text-indigo-600 mb-2">{{ $user->events_count }}</div>
                            @if($user->role === 'organizer' || $user->role === 'admin')
                            <p class="text-sm text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                Can create and manage events
                            </p>
                            @else
                            <p class="text-sm text-gray-500">
                                <i class="fas fa-lock mr-1"></i>
                                Cannot create events
                            </p>
                            @endif
                        </div>

                        <!-- Bookings Card -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Bookings Made</h3>
                                    <p class="text-gray-600 text-sm">Total ticket bookings</p>
                                </div>
                                <div class="bg-purple-100 rounded-full p-3">
                                    <i class="fas fa-ticket-alt text-purple-600 text-xl"></i>
                                </div>
                            </div>
                            <div class="text-3xl font-bold text-purple-600 mb-2">{{ $user->bookings_count }}</div>
                            <p class="text-sm text-gray-500">
                                <i class="fas fa-chart-line mr-1"></i>
                                Event participation history
                            </p>
                        </div>
                    </div>

                    <!-- Role Permissions -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                            <h3 class="text-xl font-semibold text-white flex items-center">
                                <i class="fas fa-shield-alt mr-3"></i>
                                Role Permissions
                            </h3>
                        </div>

                        <div class="p-6">
                            @php
                            $permissions = [
                            'attendee' => [
                            'View events and browse catalog',
                            'Make event bookings',
                            'Manage personal profile',
                            'View booking history'
                            ],
                            'organizer' => [
                            'All user permissions',
                            'Create and manage events',
                            'Set up ticket types and pricing',
                            'View event analytics and reports',
                            ],
                            'admin' => [
                            'All organizer permissions',
                            'Manage user accounts and roles',
                            'Create and manage categories',
                            'Access admin dashboard',
                            'View system-wide analytics',
                            'Moderate all content'
                            ]
                            ];
                            @endphp

                            <div class="mb-4">
                                <h4 class="font-semibold text-gray-800 mb-2">
                                    Current Role: <span
                                        class="text-{{ $user->role === 'admin' ? 'red' : ($user->role === 'organizer' ? 'blue' : 'gray') }}-600">{{
                                        ucfirst($user->role) }}</span>
                                </h4>
                            </div>

                            <ul class="space-y-2">
                                @foreach($permissions[$user->role] as $permission)
                                <li class="flex items-center text-gray-700">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    {{ $permission }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('users.edit', $user) }}"
                    class="flex justify-center items-center px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg shadow-md transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-edit mr-2"></i>
                    Edit User Details
                </a>

                @if(Auth::user()->id !== $user->id && ($user->events_count == 0 && $user->bookings_count == 0))
                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline-block"
                    onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="flex justify-center items-center px-6 py-3 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg shadow-md transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-trash mr-2"></i>
                        Delete User
                    </button>
                </form>
                @endif
            </div>

            <!-- Additional Information -->
            @if(Auth::user()->id === $user->id || ($user->events_count > 0 || $user->bookings_count > 0))
            <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-yellow-600 mr-3 mt-1"></i>
                    <div>
                        <h3 class="text-yellow-800 font-semibold mb-2">Account Protection</h3>
                        <p class="text-yellow-700 text-sm">
                            @if(Auth::user()->id === $user->id)
                            This is your own account and cannot be deleted.
                            @else
                            This user has active events or bookings and cannot be deleted to maintain data integrity.
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-layout>