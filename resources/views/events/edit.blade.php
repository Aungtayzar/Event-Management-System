<x-layout>
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-blue-50 to-purple-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <!-- Form Header -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ isset($event) ? 'Edit Event' : 'Create New Event' }}</h1>
                <p class="text-gray-600">{{ isset($event) ? 'Update the event details below' : 'Fill in the details to create a new event' }}</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow-xl overflow-hidden border border-indigo-100">
                <div class="p-8">
                    <form action="{{ isset($event) ? route('events.update', $event) : route('events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @if(isset($event))
                            @method('PUT')
                        @endif

                        <!-- Title Field -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Event Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $event->title ?? '') }}" 
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 shadow-sm focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50 transition-colors duration-200 px-3 py-2 outline-none"
                                placeholder="Enter event title" required>
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description Field -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" id="description" rows="5" 
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 shadow-sm focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50 transition-colors duration-200 px-3 py-2 outline-none"
                                placeholder="Describe your event" required>{{ old('description', $event->description ?? '') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Two-column layout for date and location -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Date Field -->
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date & Time</label>
                                <input type="datetime-local" name="date" id="date" value="{{ old('date', isset($event) ? date('Y-m-d\TH:i', strtotime($event->date)) : '') }}" 
                                    class="w-full rounded-lg border border-gray-300 bg-gray-50 shadow-sm focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50 transition-colors duration-200 px-3 py-2 outline-none" required>
                                @error('date')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Location Field -->
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                <input type="text" name="location" id="location" value="{{ old('location', $event->location ?? '') }}" 
                                    class="w-full rounded-lg border border-gray-300 bg-gray-50 shadow-sm focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50 transition-colors duration-200 px-3 py-2 outline-none"
                                    placeholder="Event location" required>
                                @error('location')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Category Field -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select name="category_id" id="category_id" 
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 shadow-sm focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50 transition-colors duration-200 px-3 py-2 outline-none" required>
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (old('category_id', $event->category_id ?? '') == $category->id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Banner Image Field - Two Column Layout -->
                        <div>
                            <label for="banner_image" class="block text-sm font-medium text-gray-700 mb-1">Banner Image</label>
                            <div id="image-upload-container" class="mt-1">
                                <!-- Upload Column -->
                                <div class="w-full">
                                    <label class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:bg-gray-50 transition-colors duration-200 h-full">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <span class="relative rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                                    Upload a file
                                                </span>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">
                                                PNG, JPG, GIF up to 2MB
                                            </p>
                                        </div>
                                        <input id="banner_image" name="banner_image" type="file" class="sr-only" accept="image/*">
                                    </label>
                                </div>
                                
                                <!-- Preview Column (initially hidden, will be populated by JS) -->
                                <div id="image-preview-container" class="hidden w-full">
                                    <!-- Preview will be inserted here by JavaScript -->
                                </div>
                            </div>
                            
                            @if(isset($event) && $event->banner_image)
                                <div class="mt-2">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $event->banner_image) }}" alt="Current banner">
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-900">Current banner image</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @error('banner_image')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Published Status -->
                        <div class="flex items-center bg-indigo-50 p-4 rounded-lg">
                            <input type="checkbox" name="is_published" id="is_published" value="1" 
                                {{ old('is_published', $event->is_published ?? true) ? 'checked' : '' }}
                                class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="is_published" class="ml-3 block text-sm text-gray-700 font-medium">
                                Publish this event immediately
                            </label>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end pt-6 border-t border-gray-200">
                            <a href="{{ route('organizer.dashboard') }}" class="bg-white py-2 px-5 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                Cancel
                            </a>
                            <button type="submit" class="ml-4 inline-flex justify-center py-2 px-5 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                {{ isset($event) ? 'Update Event' : 'Create Event' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Preview uploaded image in a side-by-side layout
    document.getElementById('banner_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            const previewContainer = document.getElementById('image-preview-container');
            const uploadContainer = document.getElementById('image-upload-container');
            uploadContainer.className = "grid grid-cols-1 md:grid-cols-2 gap-4";

            reader.onload = function(e) {
                // Create preview content with cancel button
                previewContainer.innerHTML = `
                    <div class="bg-indigo-50 rounded-lg p-4 h-full flex flex-col items-center justify-center relative">
                        <button type="button" id="clear-image" class="absolute top-2 right-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-full p-1 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <img src="${e.target.result}" class="w-full h-auto max-h-48 object-contain rounded mb-2" alt="Image preview">
                        <p class="text-sm text-indigo-700 font-medium text-center">Preview of your banner</p>
                        <p class="text-xs text-gray-500 text-center mt-1">${file.name}</p>
                    </div>
                `;
                
                // Show the preview container
                previewContainer.classList.remove('hidden');
                
                // Add event listener to the cancel button
                document.getElementById('clear-image').addEventListener('click', function() {
                    // Clear the file input
                    document.getElementById('banner_image').value = '';
                    
                    // Hide the preview
                    previewContainer.classList.add('hidden');
                    previewContainer.innerHTML = '';
                    
                    // Reset the container layout
                    uploadContainer.className = "mt-1";
                });
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Initialize preview if there's a pre-selected file (for edit form)
    window.addEventListener('DOMContentLoaded', () => {
        const fileInput = document.getElementById('banner_image');
        if (fileInput.files && fileInput.files[0]) {
            // Trigger the change event to initialize preview
            fileInput.dispatchEvent(new Event('change'));
        }
    });
</script>
</x-layout>