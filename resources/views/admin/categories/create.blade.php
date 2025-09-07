<x-layout>
    <div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-indigo-50">
        <div class="container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="max-w-2xl mx-auto">
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-plus-circle text-purple-600 mr-3"></i>
                        Create New Category
                    </h1>
                    <p class="text-gray-600">Add a new category to organize your events better</p>
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
                    <span class="text-purple-600 font-medium">Create</span>
                </nav>

                <!-- Form Card -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <!-- Card Header -->
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-8 py-6">
                        <h2 class="text-2xl font-bold text-white flex items-center">
                            <i class="fas fa-tag mr-3"></i>
                            Category Information
                        </h2>
                        <p class="text-purple-100 mt-2">Fill in the details below to create a new category</p>
                    </div>

                    <!-- Form Content -->
                    <div class="p-8">
                        <form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
                            @csrf

                            <!-- Category Name -->
                            <div class="space-y-2">
                                <label for="name" class="flex items-center text-sm font-semibold text-gray-700">
                                    <i class="fas fa-tag text-purple-600 mr-2"></i>
                                    Category Name
                                    <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                                        class="w-full px-4 py-3 pl-12 outline-none border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200 @error('name') border-red-500 @else border-gray-300 @enderror"
                                        placeholder="Enter category name (e.g., Technology, Business, Arts)" required>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-tag text-gray-400"></i>
                                    </div>
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
                                        class="w-full px-4 py-3 pl-12 border rounded-lg outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200 resize-none @error('description') border-red-500 @else border-gray-300 @enderror"
                                        placeholder="Provide a brief description of this category...">{{ old('description') }}</textarea>
                                    <div class="absolute top-3 left-3 pointer-events-none">
                                        <i class="fas fa-align-left text-gray-400"></i>
                                    </div>
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
                                        Create Category
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

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