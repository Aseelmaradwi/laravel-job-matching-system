<x-app-layout>

<div class="py-12">
<div class="bg-black shadow-lg rounded-lg p-6 max-w-7xl mx-auto">

<h2 class="text-2xl font-bold text-white mb-6">
Welcome back, Admin!
</h2>

<!-- Search and Filter Section -->
<form method="GET" action="{{ route('dashboard') }}" class="mb-6">
    <div class="flex justify-between items-center gap-4 flex-wrap">
        
        <!-- Search Bar -->
        <div class="flex flex-1 min-w-64">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search by title or location"
                class="bg-gray-800 text-white px-4 py-2 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 flex-1"
            />
            <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 px-6 py-2 text-white rounded-r-lg font-medium">
                Search
            </button>
        </div>

        <!-- Type Filter -->
        <select name="type" onchange="this.form.submit()" class="bg-gray-800 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">All Types</option>
            @foreach ($jobTypes as $jobType)
                <option value="{{ $jobType }}" {{ request('type') === $jobType ? 'selected' : '' }}>
                    {{ $jobType }}
                </option>
            @endforeach
        </select>

        <!-- Category Filter -->
        <select name="category" onchange="this.form.submit()" class="bg-gray-800 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">All Categories</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') === $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <!-- Clear Filters -->
        @if (request('search') || request('type') || request('category'))
            <a href="{{ route('dashboard') }}" class="bg-red-500 hover:bg-red-600 px-4 py-2 text-white rounded-lg font-medium">
                Clear
            </a>
        @endif
        
    </div>
</form>

<!-- Job List -->
<!-- Job List -->
<div class="space-y-6">

@forelse ($jobs as $job)

<div class="bg-gray-900 rounded-xl p-6 shadow-lg hover:bg-gray-800 transition duration-200 flex justify-between items-start">

    <!-- LEFT SIDE -->
    <div class="space-y-2">

        <!-- TITLE -->
<a href="{{ route('job.show', $job->id) }}"
   class="text-xl font-semibold text-blue-400 hover:underline">
    {{ $job->title }}
</a>

        <!-- COMPANY + LOCATION -->
        <p class="text-sm text-white/70">
            <span class="font-medium">{{ $job->company->name ?? 'Unknown' }}</span> ·
            <span class="text-indigo-400">{{ $job->location }}</span>
        </p>

        <!-- CATEGORY -->
        <p class="text-sm text-white/60">
            Category:
            <span class="text-indigo-300">
                {{ $job->jobcategory->name ?? 'N/A' }}
            </span>
        </p>

        <!-- SALARY -->
        <p class="text-green-400 font-semibold text-lg">
            ${{ number_format((float) $job->salary) }} / Year
        </p>

    </div>

    <!-- RIGHT SIDE -->
    <div class="flex flex-col items-end gap-3">

        <span class="bg-blue-500 text-white px-4 py-1 rounded-full text-sm font-medium">
            {{ $job->type }}
        </span>

        <span class="text-white/60 text-xs">
            Views: {{ $job->viewCount ?? 0 }}
        </span>

    </div>

</div>

@empty

<div class="text-center py-12">
    <p class="text-white/50 text-lg">
        No jobs found matching your criteria.
    </p>
</div>

@endforelse

</div>

<!-- Pagination -->
@if ($jobs->count())
    <div class="mt-8">
        {{ $jobs->links() }}
    </div>
@endif

</div>
</div>

</x-app-layout>