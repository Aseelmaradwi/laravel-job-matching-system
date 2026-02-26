<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Job Vacancy
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-xl p-6">

                <form action="{{ route('job-vacancies.update', $jobVacancy->id) }}"
                      method="POST"
                      class="space-y-6">

                    @csrf
                    @method('PUT')

                    {{-- Title --}}
                    <div>
                        <label class="block font-medium mb-1">Title *</label>
                        <input type="text"
                               name="title"
                               value="{{ old('title', $jobVacancy->title) }}"
                               class="w-full px-4 py-2.5 rounded-lg border
                               {{ $errors->has('title') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                        @error('title')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Location --}}
                    <div>
                        <label class="block font-medium mb-1">Location *</label>
                        <input type="text"
                               name="location"
                               value="{{ old('location', $jobVacancy->location) }}"
                               class="w-full px-4 py-2.5 rounded-lg border
                               {{ $errors->has('location') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                    </div>

                    {{-- Salary --}}
                    <div>
                        <label class="block font-medium mb-1">Salary *</label>
                        <input type="number"
                               name="salary"
                               value="{{ old('salary', $jobVacancy->salary) }}"
                               class="w-full px-4 py-2.5 rounded-lg border
                               {{ $errors->has('salary') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                    </div>

                    {{-- Type --}}
                    <div>
                        <label class="block font-medium mb-1">Type *</label>
                        <select name="type"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300">

                            <option value="">Select Type</option>

                            @foreach(['full-time','contract','hybrid','remote'] as $type)
                                <option value="{{ $type }}"
                                    {{ old('type', $jobVacancy->type) == $type ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('-', ' ', $type)) }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    {{-- Company --}}
                    <div>
                        <label class="block font-medium mb-1">Company *</label>
                        <select name="companyId"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300">

                            <option value="">Select Company</option>

                            @foreach($companies as $company)
                                <option value="{{ $company->id }}"
                                    {{ old('companyId', $jobVacancy->companyId) == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Category --}}
                    <div>
                        <label class="block font-medium mb-1">Category *</label>
                        <select name="categoryId"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300">

                            <option value="">Select Category</option>

                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('categoryId', $jobVacancy->categoryId) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block font-medium mb-1">Description *</label>
                        <textarea name="description"
                                  rows="4"
                                  class="w-full px-4 py-2.5 rounded-lg border border-gray-300">{{ old('description', $jobVacancy->description) }}</textarea>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-end space-x-3">

                        <a href="{{ route('job-vacancies.index', $jobVacancy->id) }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md">
                            Cancel
                        </a>

                        <button type="submit"
                                class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            Update
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>