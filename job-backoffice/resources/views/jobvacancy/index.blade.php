<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Job Vacancies
                @if(request('archived') == 'true')
                    <span class="text-sm text-gray-500 ml-2">(Archived)</span>
                @endif
            </h2>
        </div>
    </x-slot>

    <div class="p-6">

        {{-- Success Message --}}
        @if(session('success'))
            <div id="success-message"
                 class="mb-4 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg transition-opacity duration-500">
                {{ session('success') }}
            </div>
        @endif

        {{-- Top Bar --}}
        <div class="flex justify-between items-center mb-6">

            <div>
                <h3 class="text-lg font-semibold text-gray-700">
                    Vacancies List
                    <span class="text-sm text-gray-500 ml-2">
                        (Total: {{ $jobVacancies->total() }})
                    </span>
                </h3>
            </div>

            <div class="flex items-center space-x-3">

                @if(request('archived') == 'true')

                    <a href="{{ route('job-vacancies.index') }}"
                       class="px-4 py-2 bg-black text-white text-sm rounded-md hover:bg-gray-800">
                        Active Vacancies
                    </a>

                @else

                    <a href="{{ route('job-vacancies.index', ['archived' => 'true']) }}"
                       class="px-4 py-2 bg-gray-700 text-white text-sm rounded-md hover:bg-gray-800">
                        Archived Vacancies
                    </a>

                    <a href="{{ route('job-vacancies.create') }}"
                       class="px-5 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700">
                        ➕ Add Vacancy
                    </a>

                @endif

            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                            Title
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                            Company
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                            Category
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                            Location
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                            Type
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                            Salary
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($jobVacancies as $job)
                        <tr class="hover:bg-gray-50 transition">

                            <td class="px-6 py-4 font-medium">
                                <a href="{{ route('job-vacancies.show', $job->id) }}"
                                   class="text-gray-800 hover:text-indigo-600 hover:underline">
                                    {{ $job->title }}
                                </a>
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $job->company?->name ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $job->jobcategory?->name ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $job->location }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ ucfirst($job->type) }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                ${{ number_format($job->salary, 2) }}
                            </td>

<td class="px-6 py-4">
    <div class="flex justify-end items-center gap-4">
                                @if(request('archived') == 'true')

                                    <form action="{{ route('job-vacancies.restore', $job->id) }}"
                                          method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('Restore this vacancy?')">
                                        @csrf
                                        @method('PUT')

                                        <button type="submit"
                                                class="text-green-600 hover:text-green-800 font-medium">
                                            ♻️ Restore
                                        </button>
                                    </form>
                                @else

                                    <a href="{{ route('job-vacancies.edit', $job->id) }}"
                                       class="text-blue-600 hover:text-blue-800 font-medium">
                                        ✏️ Edit
                                    </a>

                                    <form action="{{ route('job-vacancies.destroy', $job->id) }}"
                                          method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="text-red-600 hover:text-red-800 font-medium">
                                            🗑 Archive
                                        </button>
                                    </form>

                                @endif

                            </td>
                            </div>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-6 text-center text-gray-500">
                                No vacancies found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $jobVacancies->withQueryString()->links() }}
        </div>

    </div>

    <script>
        setTimeout(function() {
            const message = document.getElementById('success-message');
            if (message) {
                message.style.opacity = '0';
                setTimeout(() => message.remove(), 500);
            }
        }, 3000);
    </script>

</x-app-layout>