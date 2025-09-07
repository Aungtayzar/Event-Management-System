<x-layout>
    <div class="min-h-screen">
        <div class="container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8">
                <div class="mb-4 lg:gap-2 mr-4">
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">
                        <i class="fas fa-user-edit text-green-600 mr-3"></i>
                        Edit User
                    </h1>
                    <p class="text-gray-600">Update user information and permissions. Modify the details below.</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('users.index') }}"
                        class="flex justify-center items-center px-4 py-4 text-gray-50 bg-green-500 hover:bg-green-600 font-semibold rounded-lg shadow-md transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Users
                    </a>
                    <a href="{{ route('users.show', $user) }}"
                        class="flex justify-center items-center px-4 py-4 text-gray-50 bg-blue-500 hover:bg-blue-600 font-semibold rounded-lg shadow-md transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-eye mr-2"></i>
                        View User
                    </a>
                </div>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center mb-2">
                    <i class="fas fa-exclamation-circle mr-3"></i>
                    <strong>Please fix the following errors:</strong>
                </div>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Edit User Form -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <!-- Form Header -->
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <i class="fas fa-user-edit mr-3"></i>
                        Edit User: {{ $user->name }}
                    </h2>
                </div>

                <!-- Form Content -->
                <form action="{{ route('users.update', $user) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name Field -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user mr-2"></i>Full Name *
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                class="w-full px-4 py-3 border outline-none border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                                placeholder="Enter full name" required>
                            @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-envelope mr-2"></i>Email Address *
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                class="w-full px-4 py-3 border outline-none border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                                placeholder="Enter email address" required>
                            @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-lock mr-2"></i>New Password
                            </label>
                            <input type="password" id="password" name="password"
                                class="w-full px-4 py-3 border outline-none border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                                placeholder="Leave blank to keep current password">
                            <p class="text-gray-500 text-xs mt-1">Leave blank to keep the current password</p>
                            @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password Field -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-lock mr-2"></i>Confirm New Password
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="w-full px-4 py-3 border outline-none border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                                placeholder="Confirm new password">
                            <p class="text-gray-500 text-xs mt-1">Required only when changing password</p>
                        </div>

                        <!-- Role Field -->
                        <div class="md:col-span-2">
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-shield-alt mr-2"></i>User Role *
                            </label>
                            <select id="role" name="role"
                                class="w-full px-4 py-3 border outline-none border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                                required>
                                <option value="">Select a role</option>
                                <option value="attendee" {{ old('role', $user->role) == 'attendee' ? 'selected' : '' }}>
                                    User - Regular user with basic permissions
                                </option>
                                <option value="organizer" {{ old('role', $user->role) == 'organizer' ? 'selected' : ''
                                    }}>
                                    Organizer - Can create and manage events
                                </option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                    Admin - Full system access and management
                                </option>
                            </select>
                            @error('role')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Account Information -->
                    <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Account Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                            <div>
                                <span class="font-medium">Created:</span> {{ $user->created_at->format('M d, Y') }}
                            </div>
                            <div>
                                <span class="font-medium">Last Updated:</span> {{ $user->updated_at->format('M d, Y') }}
                            </div>
                            <div>
                                <span class="font-medium">Current Role:</span> {{ ucfirst($user->role) }}
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex flex-col sm:flex-row justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('users.index') }}"
                            class="flex justify-center items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg shadow-md transition-all duration-300">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </a>
                        <button type="submit"
                            class="flex justify-center items-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold rounded-lg shadow-md transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-save mr-2"></i>
                            Update User
                        </button>
                    </div>
                </form>
            </div>

            <!-- Help Information -->
            <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-triangle text-yellow-600 mr-3 mt-1"></i>
                    <div>
                        <h3 class="text-yellow-800 font-semibold mb-2">Important Notes</h3>
                        <ul class="text-yellow-700 text-sm space-y-1">
                            <li>Changing a user's role will immediately affect their permissions</li>
                            <li>Password changes will require the user to log in again</li>
                            <li>Email changes should be communicated to the user</li>
                            <li>Admin users have full access to all system features</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>