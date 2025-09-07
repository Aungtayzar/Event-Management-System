<x-layout>
    <div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-indigo-50">
        <div class="container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="max-w-2xl mx-auto">
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-edit text-purple-600 mr-3"></i>
                        Edit Category
                    </h1>
                    <p class="text-gray-600">Update the category information below</p>
                </div>

                <!-- Navigation Breadcrumb -->
                <nav class="flex items-center space-x-2 text-sm text-gray-600 mb-8">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-purple-600 transition-colors">
                        <i class="fas fa-tachometer-alt mr-1"></i>Dashboard
                    </a>
                    <i class="fas fa-chevron-right text-gray-400"></i>
                    <a href="{{ route('categories.index') }}" class="hover:text-purple-600 transition-colors">
                        <i class="fas fa-tags mr-1"></i>Categories
                    </a>
                    <i class="fas fa-chevron-right text-gray-400"></i>
                    <span class="text-purple-600 font-medium">Edit "{{ $category->name }}"</span>
                </nav>

                <!-- Form Card -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <!-- Card Header -->
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-8 py-6">
                        <h2 class="text-2xl font-bold text-white flex items-center">
                            <i class="fas fa-tag mr-3"></i>
                            Category Information
                        </h2>
                        <p class="text-purple-100 mt-2">Update the details for "{{ $category->name }}"</p>
                    </div>

                    <!-- Form Content -->
                    <div class="p-8">
                        <!-- Category Stats -->
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg p-4 mb-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="bg-white rounded-full p-3">
                                        <i class="fas fa-calendar-alt text-indigo-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Events in this category</p>
                                        <p class="text-2xl font-bold text-indigo-600">{{ $category->events()->count() }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="bg-white rounded-full p-3">
                                        <i class="fas fa-clock text-purple-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Created</p>
                                        <p class="text-lg font-semibold text-purple-600">{{
                                            $category->created_at->format('M
                                            d, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- Category Name -->
                            <div class="space-y-2">
                                <label for="name" class="flex items-center text-sm font-semibold text-gray-700">
                                    <i class="fas fa-tag text-purple-600 mr-2"></i>
                                    Category Name
                                    <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}"
                                        class="w-full px-4 py-3 border rounded-lg outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200 @error('name') border-red-500 @else border-gray-300 @enderror"
                                        placeholder="Enter category name (e.g., Technology, Business, Arts)" required>
                                </div>
                                @error('name')
                                <p class="text-red-500 text-sm flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                                <p class="text-gray-500 text-sm flex items-center">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Choose a clear, descriptive name for your category
                                </p>
                            </div>

                            <!-- Category Description -->
                            <div class="space-y-2">
                                <label for="description" class="flex items-center text-sm font-semibold text-gray-700">
                                    <i class="fas fa-align-left text-purple-600 mr-2"></i>
                                    Description
                                    <span class="text-gray-500 text-xs ml-2">(Optional)</span>
                                </label>
                                <div class="relative">
                                    <textarea id="description" name="description" rows="4"
                                        class="w-full px-4 py-3 outline-none border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200 resize-none @error('description') border-red-500 @else border-gray-300 @enderror"
                                        placeholder="Provide a brief description of this category...">{{ old('description', $category->description) }}</textarea>
                                </div>
                                @error('description')
                                <p class="text-red-500 text-sm flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                                <p class="text-gray-500 text-sm flex items-center">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Help organizers understand what types of events belong in this category
                                </p>
                            </div>

                            <!-- Action Buttons -->
                            <div class="pt-6 border-t border-gray-200">
                                <div class="flex flex-col sm:flex-row gap-4 sm:justify-end">
                                    <a href="{{ route('categories.index') }}"
                                        class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                        <i class="fas fa-times mr-2"></i>
                                        Cancel
                                    </a>
                                    <button type="submit"
                                        class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                        <i class="fas fa-save mr-2"></i>
                                        Update Category
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Warning Section (if category has events) -->
                @if($category->events()->count() > 0)
                <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                    <div class="flex items-start space-x-3">
                        <div class="bg-yellow-100 rounded-full p-2">
                            <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-yellow-800 mb-2">Important Notice</h3>
                            <p class="text-yellow-700 mb-3">
                                This category currently has <strong>{{ $category->events()->count() }} {{
                                    Str::plural('event', $category->events()->count()) }}</strong> assigned to it.
                                Changing the category name or description will affect how these events are displayed and
                                organized.
                            </p>
                            <div class="flex items-center space-x-4 text-sm">
                                <span class="flex items-center text-yellow-600">
                                    <i class="fas fa-shield-alt mr-1"></i>
                                    This category cannot be deleted
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

                <!-- Help Section -->
                <div class="mt-8 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                        Category Tips
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                        <div class="flex items-start space-x-2">
                            <i class="fas fa-check text-green-500 mt-1"></i>
                            <span>Use clear, specific names (e.g., "Web Development" instead of "Tech")</span>
                        </div>
                        <div class="flex items-start space-x-2">
                            <i class="fas fa-check text-green-500 mt-1"></i>
                            <span>Keep descriptions concise but informative</span>
                        </div>
                        <div class="flex items-start space-x-2">
                            <i class="fas fa-check text-green-500 mt-1"></i>
                            <span>Consider your target audience when naming</span>
                        </div>
                        <div class="flex items-start space-x-2">
                            <i class="fas fa-check text-green-500 mt-1"></i>
                            <span>Avoid creating duplicate or overlapping categories</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-resize textarea
    document.getElementById('description').addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    });

    // Character counter for name field
    const nameInput = document.getElementById('name');
    nameInput.addEventListener('input', function() {
        const maxLength = 100;
        const currentLength = this.value.length;
        
        // Optional: Add character counter display
        if (currentLength > maxLength - 10) {
            this.style.borderColor = '#ef4444';
        } else {
            this.style.borderColor = '#d1d5db';
        }
    });
    </script>
</x-layout>