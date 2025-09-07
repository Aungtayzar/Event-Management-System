<x-layout>
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-blue-50">
        <div class="container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-edit text-indigo-600 mr-3"></i>
                        Edit Event
                    </h1>
                    <p class="text-gray-600">Update the event information below</p>
                </div>

                <!-- Navigation Breadcrumb -->
                <nav class="flex items-center space-x-2 text-sm text-gray-600 mb-8">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 transition-colors">
                        <i class="fas fa-tachometer-alt mr-1"></i>Dashboard
                    </a>
                    <i class="fas fa-chevron-right text-gray-400"></i>
                    <a href="{{ route('admin.events.index') }}" class="hover:text-indigo-600 transition-colors">
                        <i class="fas fa-calendar-alt mr-1"></i>Events
                    </a>
                    <i class="fas fa-chevron-right text-gray-400"></i>
                    <span class="text-indigo-600 font-medium">Edit "{{ $event->title }}"</span>
                </nav>

                <!-- Form Card -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <!-- Card Header -->
                    <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-8 py-6">
                        <h2 class="text-2xl font-bold text-white flex items-center">
                            <i class="fas fa-calendar-alt mr-3"></i>
                            Event Information
                        </h2>
                        <p class="text-indigo-100 mt-2">Update the details for "{{ $event->title }}"</p>
                    </div>

                    <!-- Form Content -->
                    <div class="p-8">
                        <!-- Event Stats -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 mb-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-white rounded-full p-3">
                                        <i class="fas fa-ticket-alt text-indigo-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Ticket Types</p>
                                        <p class="text-xl font-bold text-indigo-600">{{ $event->ticketTypes()->count()
                                            }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="bg-white rounded-full p-3">
                                        <i class="fas fa-users text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Bookings</p>
                                        <p class="text-xl font-bold text-green-600">{{ $event->bookings()->count() }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="bg-white rounded-full p-3">
                                        <i class="fas fa-clock text-purple-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Created</p>
                                        <p class="text-lg font-semibold text-purple-600">{{
                                            $event->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('admin.events.update', $event) }}" method="POST"
                            enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Event Title -->
                                <div class="space-y-2">
                                    <label for="title" class="flex items-center text-sm font-semibold text-gray-700">
                                        <i class="fas fa-heading text-indigo-600 mr-2"></i>
                                        Event Title
                                        <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <input type="text" id="title" name="title" value="{{ old('title', $event->title) }}"
                                        class="w-full px-4 py-3 outline-none border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('title') border-red-500 @else border-gray-300 @enderror"
                                        placeholder="Enter event title" required>
                                    @error('title')
                                    <p class="text-red-500 text-sm flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>

                                <!-- Category -->
                                <div class="space-y-2">
                                    <label for="category_id"
                                        class="flex items-center text-sm font-semibold text-gray-700">
                                        <i class="fas fa-tag text-indigo-600 mr-2"></i>
                                        Category
                                        <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <select id="category_id" name="category_id"
                                        class="w-full px-4 py-3 border outline-none rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('category_id') border-red-500 @else border-gray-300 @enderror"
                                        required>
                                        <option value="">Select a category</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (old('category_id', $event->category_id)
                                            == $category->id) ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                    <p class="text-red-500 text-sm flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>

                                <!-- Date -->
                                <div class="space-y-2">
                                    <label for="date" class="flex items-center text-sm font-semibold text-gray-700">
                                        <i class="fas fa-calendar text-indigo-600 mr-2"></i>
                                        Event Date
                                        <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <input type="datetime-local" id="date" name="date"
                                        value="{{ old('date', \Carbon\Carbon::parse($event->date)->format('Y-m-d\TH:i')) }}"
                                        class="w-full px-4 py-3 border rounded-lg outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('date') border-red-500 @else border-gray-300 @enderror"
                                        required>
                                    @error('date')
                                    <p class="text-red-500 text-sm flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>

                                <!-- Location -->
                                <div class="space-y-2">
                                    <label for="location" class="flex items-center text-sm font-semibold text-gray-700">
                                        <i class="fas fa-map-marker-alt text-indigo-600 mr-2"></i>
                                        Location
                                        <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <input type="text" id="location" name="location"
                                        value="{{ old('location', $event->location) }}"
                                        class="w-full px-4 py-3 border rounded-lg outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('location') border-red-500 @else border-gray-300 @enderror"
                                        placeholder="Enter event location" required>
                                    @error('location')
                                    <p class="text-red-500 text-sm flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="space-y-2">
                                <label for="description" class="flex items-center text-sm font-semibold text-gray-700">
                                    <i class="fas fa-align-left text-indigo-600 mr-2"></i>
                                    Description
                                    <span class="text-red-500 ml-1">*</span>
                                </label>
                                <textarea id="description" name="description" rows="4"
                                    class="w-full px-4 py-3 border rounded-lg outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 resize-none @error('description') border-red-500 @else border-gray-300 @enderror"
                                    placeholder="Provide a detailed description of the event..."
                                    required>{{ old('description', $event->description) }}</textarea>
                                @error('description')
                                <p class="text-red-500 text-sm flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <!-- Current Banner Image -->
                            @if($event->banner_image)
                            <div class="space-y-2">
                                <label class="flex items-center text-sm font-semibold text-gray-700">
                                    <i class="fas fa-image text-indigo-600 mr-2"></i>
                                    Current Banner
                                </label>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <img src="{{ asset('storage/' . $event->banner_image) }}" alt="Current banner"
                                        class="h-32 w-full object-cover rounded-lg">
                                </div>
                            </div>
                            @endif

                            <!-- Banner Image -->
                            <div class="space-y-2">
                                <label for="banner_image" class="flex items-center text-sm font-semibold text-gray-700">
                                    <i class="fas fa-image text-indigo-600 mr-2"></i>
                                    Banner Image
                                    <span class="text-gray-500 text-xs ml-2">(Optional)</span>
                                </label>
                                <input type="file" id="banner_image" name="banner_image" accept="image/*"
                                    class="w-full px-4 py-3 border outline-none rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('banner_image') border-red-500 @else border-gray-300 @enderror">
                                @error('banner_image')
                                <p class="text-red-500 text-sm flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                                <p class="text-gray-500 text-sm flex items-center">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Upload a new banner image to replace the current one (JPEG, PNG, JPG, GIF - Max:
                                    2MB)
                                </p>
                            </div>

                            <!-- Publish Status -->
                            <div class="space-y-2">
                                <label class="flex items-center text-sm font-semibold text-gray-700">
                                    <i class="fas fa-eye text-indigo-600 mr-2"></i>
                                    Publication Status
                                </label>
                                <div class="flex items-center space-x-4">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" id="is_published" name="is_published" value="1" {{
                                            old('is_published', $event->is_published) ? 'checked' : '' }}
                                        class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700">Publish event</span>
                                    </label>
                                </div>
                                <p class="text-gray-500 text-sm flex items-center">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    If unchecked, the event will be saved as a draft
                                </p>
                            </div>

                            <!-- Action Buttons -->
                            <div class="pt-6 border-t border-gray-200">
                                <div class="flex flex-col sm:flex-row gap-4 sm:justify-end">
                                    <a href="{{ route('admin.events.index') }}"
                                        class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                        <i class="fas fa-times mr-2"></i>
                                        Cancel
                                    </a>
                                    <button type="submit"
                                        class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                        <i class="fas fa-save mr-2"></i>
                                        Update Event
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Warning Section (if event has bookings) -->
                @if($event->bookings()->count() > 0)
                <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                    <div class="flex items-start space-x-3">
                        <div class="bg-yellow-100 rounded-full p-2">
                            <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-yellow-800 mb-2">Important Notice</h3>
                            <p class="text-yellow-700 mb-3">
                                This event currently has <strong>{{ $event->bookings()->count() }} {{
                                    Str::plural('booking', $event->bookings()->count()) }}</strong> from users.
                                Making significant changes to the event details may affect attendees.
                            </p>
                            <div class="flex items-center space-x-4 text-sm">
                                <span class="flex items-center text-yellow-600">
                                    <i class="fas fa-users mr-1"></i>
                                    Consider notifying attendees of changes
                                </span>
                                <span class="flex items-center text-yellow-600">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Changes will be reflected immediately
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>