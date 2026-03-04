<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Job Applications
            </h2>

            @if(request()->boolean('archived'))
                <a href="{{ route('job-applications.index') }}"
                   class="px-4 py-2 bg-black text-white text-sm rounded-md hover:bg-gray-800">
                    Active Job Applications
                </a>
            @else
                <a href="{{ route('job-applications.index', ['archived' => 'true']) }}"
                   class="px-4 py-2 bg-black text-white text-sm rounded-md hover:bg-gray-800">
                    Archived Job Applications
                </a>
            @endif
        </div>
    </x-slot>

    {{-- Success Message --}}
    @if(session('success'))
        <div id="success-message"
             class="bg-green-100 text-green-700 p-4 rounded m-6 transition-opacity duration-500">
            {{ session('success') }}
        </div>
    @endif

    <div class="p-6">

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                            Applicant Name
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                            Position (Job Vacancy)
                        </th>
                        @if (auth()->user()->role=='admin')
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                            Company
                        </th>
                        @endif
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                            Status
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($jobApplications as $application)
                        <tr class="hover:bg-gray-50 transition">

                            {{-- Applicant Name --}}
                            <td class="px-6 py-4 font-medium">
                                <a href="{{ route('job-applications.show', $application->id) }}"
                                   class="text-indigo-600 hover:underline">
                                    {{ $application->user?->name ?? 'N/A' }}
                                </a>
                            </td>

                            {{-- Job Vacancy Title --}}
                            <td class="px-6 py-4 text-gray-700">
                                {{ $application->jobVacancy?->title ?? 'N/A' }}
                            </td>

                            {{-- Company --}}
                            @if (auth()->user()->role=='admin')
                            <td class="px-6 py-4 text-gray-700">
                             {{ $application->jobVacancy?->company?->name ?? 'N/A' }}
                            </td>
                            @endif


                            {{-- Status Badge --}}
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    @if($application->status === 'accepted')
                                        bg-green-100 text-green-700
                                    @elseif($application->status === 'rejected')
                                        bg-red-100 text-red-700
                                    @elseif($application->status === 'pending')
                                        bg-yellow-100 text-yellow-700
                                    @else
                                        bg-gray-100 text-gray-700
                                    @endif">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-right space-x-4">

                                @if(request()->boolean('archived'))

                                    {{-- Restore --}}
                                    <form action="{{ route('job-applications.restore', $application->id) }}"
                                          method="POST"
                                          class="inline-block">
                                        @csrf
                                        @method('PUT')

                                        <button type="submit"
                                                class="text-green-600 hover:text-green-800 font-medium">
                                            ♻ Restore
                                        </button>
                                    </form>

                                @else

                                    {{-- Edit --}}
                                    <a href="{{ route('job-applications.edit', $application->id) }}"
                                       class="text-yellow-600 hover:text-yellow-800 font-medium">
                                        ✏ Edit
                                    </a>

                                    {{-- Archive --}}
                                    <form action="{{ route('job-applications.destroy', $application->id) }}"
                                          method="POST"
                                          class="inline-block">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="text-red-600 hover:text-red-800 font-medium">
                                            🗑 Archive
                                        </button>
                                    </form>

                                @endif

                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-gray-500">
                                No job applications found.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $jobApplications->withQueryString()->links() }}
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