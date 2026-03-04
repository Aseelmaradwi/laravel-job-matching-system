<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12 px-6 space-y-8">

        {{-- Overview Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="p-6 bg-white shadow-sm rounded-lg">
                <h3 class="text-gray-500 text-sm">Active Users</h3>
                <p class="text-3xl font-bold text-indigo-600">
                    {{ $analytics['activeUsers'] ?? 0 }}
                </p>
                <p class="text-sm text-gray-400">Last 30 days</p>
            </div>

            <div class="p-6 bg-white shadow-sm rounded-lg">
                <h3 class="text-gray-500 text-sm">Total Jobs</h3>
                <p class="text-3xl font-bold text-indigo-600">
                    {{ $analytics['totalJobs'] ?? 0 }}
                </p>
                <p class="text-sm text-gray-400">All time</p>
            </div>

            <div class="p-6 bg-white shadow-sm rounded-lg">
                <h3 class="text-gray-500 text-sm">Total Applications</h3>
                <p class="text-3xl font-bold text-indigo-600">
                    {{ $analytics['totalApplications'] ?? 0 }}
                </p>
                <p class="text-sm text-gray-400">All time</p>
            </div>

        </div>

        {{-- Most Applied Jobs --}}
        <div class="p-6 bg-white shadow-sm rounded-lg">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                Most Applied Jobs
            </h3>

            <table class="w-full divide-y divide-gray-200">
                <thead>
                    <tr class="text-left text-gray-500 uppercase text-sm">
                        <th class="py-3">Job Title</th>
                        <th>Company</th>
                        <th>Total Applications</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($mostAppliedJobs as $job)
                        <tr>
                            <td class="py-4 font-medium">
                                {{ $job->title }}
                            </td>
                            <td>
                                {{ $job->company?->name ?? 'N/A' }}
                            </td>
                            <td class="font-semibold">
                                {{ $job->totalCount }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-4 text-center text-gray-400">
                                No data available
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Conversion Rates --}}
        <div class="p-6 bg-white shadow-sm rounded-lg">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                Conversion Rates
            </h3>

            <table class="w-full divide-y divide-gray-200">
                <thead>
                    <tr class="text-left text-gray-500 uppercase text-sm">
                        <th class="py-3">Job Title</th>
                        <th>Views</th>
                        <th>Applications</th>
                        <th>Conversion Rate</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($conversionRates as $job)
                        <tr>
                            <td class="py-4 font-medium">
                                {{ $job->title }}
                            </td>
                            <td>
                                {{ $job->viewCount }}
                            </td>
                            <td>
                                {{ $job->totalCount }}
                            </td>
                            <td class="font-semibold text-indigo-600">
                                {{ $job->conversionRate }}%
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 text-center text-gray-400">
                                No data available
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>