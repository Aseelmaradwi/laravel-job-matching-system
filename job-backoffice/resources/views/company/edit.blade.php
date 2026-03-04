@php
if(auth()->user()->role == 'admin') {
    $formAction = route('companies.update', $company->id);
} else {
    $formAction = route('my-company.update');
}
@endphp

<x-app-layout>
<x-slot name="header">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">

            <a href="{{ auth()->user()->role === 'admin'
                ? route('companies.index')
                : route('my-company.show') }}"
               class="text-gray-500 hover:text-gray-700 transition-colors text-lg">
                ←
            </a>

            <h2 class="text-2xl font-semibold text-gray-800">
                Edit Company
            </h2>

        </div>
    </div>
</x-slot>

<div class="py-8">
<div class="max-w-3xl mx-auto px-4">

<div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">

<div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
    <h3 class="text-lg font-medium text-gray-700">
        ✏️ Edit "{{ $company->name }}"
    </h3>
    <p class="text-sm text-gray-500 mt-1">
        Update company information below
    </p>
</div>

<form action="{{ $formAction }}" method="POST" class="p-6">
@csrf
@method('PUT')

@if ($errors->any())
<div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
    <div class="font-semibold mb-2">
        Please fix the following errors:
    </div>
    <ul class="list-disc pl-5 space-y-1 text-sm">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- Company Name --}}
<div class="mb-6">
    <label class="block text-sm font-medium text-gray-700 mb-2">
        Company Name <span class="text-red-500">*</span>
    </label>

    <input type="text"
           name="name"
           value="{{ old('name', $company->name) }}"
           class="w-full px-4 py-2.5 rounded-lg border 
           {{ $errors->has('name')
               ? 'border-red-400 bg-red-50'
               : 'border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500' }}
           focus:outline-none transition">

    @error('name')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Industry --}}
<div class="mb-6">
    <label class="block text-sm font-medium text-gray-700 mb-2">
        Industry
    </label>

    <input type="text"
           name="industry"
           value="{{ old('industry', $company->industry) }}"
           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none transition">

    @error('industry')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Address --}}
<div class="mb-6">
    <label class="block text-sm font-medium text-gray-700 mb-2">
        Address
    </label>

    <input type="text"
           name="address"
           value="{{ old('address', $company->address) }}"
           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none transition">

    @error('address')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Website --}}
<div class="mb-6">
    <label class="block text-sm font-medium text-gray-700 mb-2">
        Website
    </label>

    <input type="url"
           name="website"
           value="{{ old('website', $company->website) }}"
           placeholder="https://example.com"
           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none transition">

    @error('website')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Owner (ظاهر بس غير قابل للتعديل) --}}
<div class="mb-6">
    <label class="block text-sm font-medium text-gray-700 mb-2">
        Owner
    </label>

    <select disabled
        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white pointer-events-none">
        <option selected>{{ $company->owner->name }}</option>
    </select>
</div>

{{-- Buttons --}}
<div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">

<a href="{{ auth()->user()->role === 'admin'
        ? route('companies.index')
        : route('my-company.show') }}"
   class="px-5 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50 transition text-sm">
    Cancel
</a>

<button type="submit"
        class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm shadow-sm">
    Update Company
</button>

</div>

</form>
</div>

<div class="mt-4 bg-blue-50 rounded-lg p-4 border border-blue-200">
    <p class="text-sm text-blue-800">
        💡 Updating company details will affect all jobs associated with this company.
    </p>
</div>

</div>
</div>
</x-app-layout>k