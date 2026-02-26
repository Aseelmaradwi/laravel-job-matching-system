<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Job Vacancy
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-6">

            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">

                <div class="bg-gray-50 px-6 py-5 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-700">
                        Job Vacancy Details
                    </h3>
                    <p class="text-sm text-gray-500">
                        Enter the job vacancy details
                    </p>
                </div>

                <form action="{{ route('job-vacancies.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    {{-- Title --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Title *
                        </label>
                        <input type="text" name="title"
                               value="{{ old('title') }}"
                               class="w-full px-4 py-2.5 rounded-lg border 
                               {{ $errors->has('title') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                        @error('title')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Location --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Location *
                        </label>
                        <input type="text" name="location"
                               value="{{ old('location') }}"
                               class="w-full px-4 py-2.5 rounded-lg border 
                               {{ $errors->has('location') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                        @error('location')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Salary --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Expected Salary (USD) *
                        </label>
                        <input type="number" step="0.01" name="salary"
                               value="{{ old('salary') }}"
                               class="w-full px-4 py-2.5 rounded-lg border 
                               {{ $errors->has('salary') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                        @error('salary')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Type --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Type *
                        </label>
                        <select name="type"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300">
                            <option value="">Select Type</option>
                            @foreach(['full-time','contract','hybrid','remote'] as $type)
                                <option value="{{ $type }}"
                                    {{ old('type') == $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Company --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Company *
                        </label>
                        <select name="companyId"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300">
                            <option value="">Select Company</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}"
                                    {{ old('companyId') == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Category --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Job Category *
                        </label>
                        <select name="categoryId"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('categoryId') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Job Description *
                        </label>
                        <textarea name="description" rows="4"
                                  class="w-full px-4 py-2.5 rounded-lg border 
                                  {{ $errors->has('description') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-end gap-3 pt-6 border-t">
                        <a href="{{ route('job-vacancies.index') }}"
                           class="px-5 py-2 border rounded-lg text-gray-600">
                            Cancel
                        </a>

                        <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg">
                            Save Job Vacancy
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>