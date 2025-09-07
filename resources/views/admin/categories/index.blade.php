<x-layout>
    <div class="min-h-screen">
        <div class="container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8">
                <div class="mb-4 lg:gap-2 mr-4">
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">
                        <i class="fas fa-tags text-purple-600 mr-3"></i>
                        Category Management
                    </h1>
                    <p class="text-gray-600">Organize your events with categories. Create, edit, and manage event
                        categories.</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex justify-center items-center px-4 py-4 text-gray-50 bg-purple-500 hover:bg-purple-600 font-semibold rounded-lg shadow-md transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Dashboard
                    </a>
                    <a href="{{ route('categories.create') }}"
                        class="flex justify-center items-center text-gray-50 bg-purple-500 hover:bg-purple-600 font-semibold rounded-lg shadow-md transition-all duration-300 transform hover:scale-105 px-4 py-4">
                        <i class="fas fa-plus mr-2"></i>
                        Create New Category
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

            <!-- Categories Table -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <!-- Table Header -->
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <i class="fas fa-list mr-3"></i>
                        All Categories ({{ $categories->count() }})
                    </h2>
                </div>

                @if($categories->count() > 0)
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
                                    <i class="fas fa-tag mr-2"></i>Name
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-calendar-alt mr-2"></i>Events Count
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-clock mr-2"></i>Created At
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-cogs mr-2"></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($categories as $idx=>$category)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $idx + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="bg-purple-100 rounded-full p-2 mr-3">
                                            <i class="fas fa-tag text-purple-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $category->name }}</div>
                                            @if($category->description)
                                            <div class="text-sm text-gray-500">{{ Str::limit($category->description, 50)
                                                }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                                     {{ $category->events_count > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                        {{ $category->events_count }} {{ Str::plural('event', $category->events_count)
                                        }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <i class="fas fa-clock mr-2"></i>
                                        {{ $category->created_at->format('M d, Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <!-- Edit Button -->
                                        <a href="{{ route('categories.edit', $category) }}"
                                            class="inline-flex items-center px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                            <i class="fas fa-edit mr-1"></i>
                                            Edit
                                        </a>

                                        <!-- Delete Button -->
                                        @if($category->events_count == 0)
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Are you sure you want to delete this category?')">
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
                                            title="Cannot delete category with existing events">
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
                    <div class="mx-auto w-24 h-24 bg-purple-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-tags text-purple-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No Categories Found</h3>
                    <p class="text-gray-500 mb-6">Get started by creating your first event category.</p>
                    <a href="{{ route('categories.create') }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-semibold rounded-lg shadow-md transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-plus mr-2"></i>
                        Create Your First Category
                    </a>
                </div>
                @endif
            </div>

            <!-- Footer Info -->
            @if($categories->count() > 0)
            <div class="mt-6 bg-white rounded-lg shadow-md p-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between text-sm text-gray-600">
                    <div class="flex items-center mb-2 sm:mb-0">
                        <i class="fas fa-info-circle mr-2"></i>
                        Showing {{ $categories->count() }} {{ Str::plural('category', $categories->count()) }}
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-shield-alt mr-2"></i>
                        Categories with events cannot be deleted
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-layout>