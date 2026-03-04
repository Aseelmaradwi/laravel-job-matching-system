<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $company->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-xl p-6">

             {{-- ✅ Success Alert --}}
    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
                {{-- Top Actions --}}
              <div class="flex justify-end items-start mb-6 space-x-2">

    {{-- Edit --}}
   <a href="{{ auth()->user()->role === 'admin'? route('companies.edit', $company->id): route('my-company.edit') }}"
   class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
    Edit
</a>

    @if(auth()->user()->role === 'admin')
        <form action="{{ route('companies.destroy', $company->id) }}"
              method="POST"
              onsubmit="return confirm('Archive this company?')">
            @csrf
            @method('DELETE')

            <button class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm">
                Archive
            </button>
        </form>
    @endif

</div>
                {{-- Company Info --}}
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">
                        Company Information
                    </h3>

                    <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
                        <div>
                            <strong>Address:</strong>
                            <p>{{ $company->address ?? '-' }}</p>
                        </div>

                        <div>
                            <strong>Industry:</strong>
                            <p>{{ $company->industry ?? '-' }}</p>
                        </div>

                        <div>
                            <strong>Owner:</strong>
                            <p>{{ $company->owner->name ?? '-' }}</p>
                        </div>

                        <div>
                            <strong>Website:</strong>
                            @if($company->website)
                                <a href="{{ $company->website }}" target="_blank"
                                   class="text-indigo-600 hover:underline">
                                    {{ $company->website }}
                                </a>
                            @else
                                -
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Tabs --}}
                <div x-data="{ tab: 'jobs' }">

                    <div class="border-b mb-4">
                        <nav class="flex space-x-8 text-sm font-medium">

                            <button @click="tab='jobs'"
                                    :class="tab==='jobs'
                                    ? 'border-indigo-600 text-indigo-600'
                                    : 'text-gray-500'"
                                    class="pb-2 border-b-2">

                                Jobs ({{ $company->jobVacancies->count() }})
                            </button>

                            <button @click="tab='applications'"
                                    :class="tab==='applications'
                                    ? 'border-indigo-600 text-indigo-600'
                                    : 'text-gray-500'"
                                    class="pb-2 border-b-2">

                                Applications ({{ $company->jobApplications->count() }})
                            </button>

                        </nav>
                    </div>

                    {{-- ===================== --}}
                    {{-- Jobs Tab --}}
                    {{-- ===================== --}}
                    <div x-show="tab==='jobs'" x-transition>

                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-left text-gray-600">
                                    <th class="py-2 px-3">Title</th>
                                    <th class="py-2 px-3">Type</th>
                                    <th class="py-2 px-3">Location</th>
                                    <th class="py-2 px-3 text-right">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y">
                                @forelse($company->jobVacancies as $job)
                                    <tr>
                                        <td class="py-2 px-3 font-medium">
                                            {{ $job->title }}
                                        </td>
                                        <td class="py-2 px-3">
                                            {{ $job->type }}
                                        </td>
                                        <td class="py-2 px-3">
                                            {{ $job->location }}
                                        </td>
                                        <td class="py-2 px-3 text-right">
                                            <a href="{{ route('job-vacancies.show', $job->id) }}"
                                               class="text-indigo-600 hover:underline">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-6 text-gray-500">
                                            No jobs found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>

                    {{-- ===================== --}}
                    {{-- Applications Tab --}}
                    {{-- ===================== --}}
                    <div x-show="tab==='applications'" x-cloak x-transition>

                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-left text-gray-600">
                                    <th class="py-2 px-3">Applicant</th>
                                    <th class="py-2 px-3">Vacancy</th>
                                    <th class="py-2 px-3">Status</th>
                                    <th class="py-2 px-3">Score</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y">
                                @forelse($company->jobApplications as $app)
                                    <tr>
                                        <td class="py-2 px-3">
                                            {{ $app->user->name ?? '-' }}
                                        </td>

                                        <td class="py-2 px-3">
                                            {{ $app->jobVacancy->title ?? '-' }}
                                        </td>

                                        <td class="py-2 px-3">
                                            <span class="px-2 py-1 text-xs rounded
                                                {{ $app->status === 'accepted' ? 'bg-green-100 text-green-700' :
                                                   ($app->status === 'rejected' ? 'bg-red-100 text-red-700' :
                                                   'bg-gray-100 text-gray-700') }}">
                                                {{ ucfirst($app->status) }}
                                            </span>
                                        </td>

                                        <td class="py-2 px-3">
                                            {{ $app->aiGeneratedScore ?? '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-6 text-gray-500">
                                            No applications found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>