<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('job-categories.index') }}" 
                   class="text-gray-500 hover:text-gray-700 transition-colors text-lg">
                    ←
                </a>
                <h2 class="text-2xl font-semibold text-gray-800">
                    Edit Category
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4">
            
            {{-- Card --}}
            <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                
                {{-- Header --}}
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-700">
                        ✏️ Edit "{{ $category->name }}"
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Update the category information below
                    </p>
                </div>

                {{-- Form --}}
                <form action="{{ route('job-categories.update', $category->id) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    {{-- Category Name --}}
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Category Name <span class="text-red-500">*</span>
                        </label>
                        
                        <input 
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name', $category->name) }}"
                            placeholder="e.g., Information Technology"
                            class="w-full px-4 py-2.5 rounded-lg border 
                                   {{ $errors->has('name') 
                                       ? 'border-red-400 bg-red-50' 
                                       : 'border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500' }}
                                   focus:outline-none transition"
                        >

                        @error('name')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                  

                  

                    {{-- Buttons --}}
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                        
                        <a href="{{ route('job-categories.index') }}" 
                           class="px-5 py-2 rounded-lg border border-gray-300 text-gray-600 
                                  hover:bg-gray-50 transition text-sm">
                            Cancel
                        </a>
                        
                        <button type="submit"
                                class="px-5 py-2 bg-blue-600 text-white rounded-lg 
                                       hover:bg-blue-700 transition text-sm shadow-sm">
                            Update Category
                        </button>
                    </div>

                </form>
            </div>

            {{-- Help Box --}}
            <div class="mt-4 bg-blue-50 rounded-lg p-4 border border-blue-200">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm text-blue-800">
                        <span class="font-medium">💡 Tip:</span> Changing the category name will affect all jobs associated with it.
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>