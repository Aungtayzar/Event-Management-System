<x-layout>
    <div class="min-h-screen">
        <div class="container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8">
                <div class="mb-4 lg:gap-2 mr-4">
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">
                        <i class="fas fa-users text-green-600 mr-3"></i>
                        User Management
                    </h1>
                    <p class="text-gray-600">Manage user accounts, roles, and permissions. Create, edit, and monitor
                        users.</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex justify-center items-center px-4 py-4 text-gray-50 bg-green-500 hover:bg-green-600 font-semibold rounded-lg shadow-md transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Dashboard
                    </a>
                    <a href="{{ route('users.create') }}"
                        class="flex justify-center items-center text-gray-50 bg-green-500 hover:bg-green-600 font-semibold rounded-lg shadow-md transition-all duration-300 transform hover:scale-105 px-4 py-4">
                        <i class="fas fa-plus mr-2"></i>
                        Create New User
                    </a>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
            <div
                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <i class="fas fa-check-circle mr-3"></i>
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <i class="fas fa-exclamation-circle mr-3"></i>
                {{ session('error') }}
            </div>
            @endif

            <!-- Users Table -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <!-- Table Header -->
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <i class="fas fa-list mr-3"></i>
                        All Users ({{ $users->count() }})
                    </h2>
                </div>

                @if($users->count() > 0)
                <!-- Table Content -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-hashtag mr-2"></i>ID
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-user mr-2"></i>User
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-shield-alt mr-2"></i>Role
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-calendar-alt mr-2"></i>Events
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-ticket-alt mr-2"></i>Bookings
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-clock mr-2"></i>Joined
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-cogs mr-2"></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $idx => $user)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $idx + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="bg-green-100 rounded-full p-2 mr-3">
                                            <i class="fas fa-user text-green-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                    $roleColors = [
                                    'admin' => 'bg-red-100 text-red-800',
                                    'organizer' => 'bg-blue-100 text-blue-800',
                                    'user' => 'bg-gray-100 text-gray-800'
                                    ];
                                    $roleIcons = [
                                    'admin' => 'fas fa-crown',
                                    'organizer' => 'fas fa-star',
                                    'user' => 'fas fa-user'
                                    ];
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $roleColors[$user->role] ?? $roleColors['user'] }}">
                                        <i class="{{ $roleIcons[$user->role] ?? $roleIcons['user'] }} mr-1"></i>
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                                 {{ $user->events_count > 0 ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800' }}">
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                        {{ $user->events_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                                 {{ $user->bookings_count > 0 ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                                        <i class="fas fa-ticket-alt mr-1"></i>
                                        {{ $user->bookings_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <i class="fas fa-clock mr-2"></i>
                                        {{ $user->created_at->format('M d, Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <!-- View Button -->
                                        <a href="{{ route('users.show', $user) }}"
                                            class="inline-flex items-center px-3 py-1 bg-gray-500 hover:bg-gray-600 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                            <i class="fas fa-eye mr-1"></i>
                                            View
                                        </a>

                                        <!-- Edit Button -->
                                        <a href="{{ route('users.edit', $user) }}"
                                            class="inline-flex items-center px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                            <i class="fas fa-edit mr-1"></i>
                                            Edit
                                        </a>

                                        <!-- Delete Button -->
                                        @if(auth()->user()->id !== $user->id && ($user->events_count == 0 &&
                                        $user->bookings_count == 0))
                                        <form action="{{ route('users.destroy', $user) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Are you sure you want to delete this user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                                <i class="fas fa-trash mr-1"></i>
                                                Delete
                                            </button>
                                        </form>
                                        @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 bg-gray-300 text-gray-500 text-xs font-medium rounded-md cursor-not-allowed"
                                            title="{{ auth()->user()->id === $user->id ? 'Cannot delete your own account' : 'Cannot delete user with events or bookings' }}">
                                            <i class="fas fa-lock mr-1"></i>
                                            Protected
                                        </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="mx-auto w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-users text-green-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No Users Found</h3>
                    <p class="text-gray-500 mb-6">Get started by creating your first user account.</p>
                    <a href="{{ route('users.create') }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold rounded-lg shadow-md transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-plus mr-2"></i>
                        Create Your First User
                    </a>
                </div>
                @endif
            </div>

            <!-- Footer Info -->
            @if($users->count() > 0)
            <div class="mt-6 bg-white rounded-lg shadow-md p-4">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm text-gray-600">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        Showing {{ $users->count() }} {{ Str::plural('user', $users->count()) }}
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-shield-alt mr-2"></i>
                        Active users cannot be deleted
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-lock mr-2"></i>
                        You cannot delete your own account
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-layout>