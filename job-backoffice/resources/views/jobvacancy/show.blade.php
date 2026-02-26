<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $jobVacancy->title }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-xl p-6">

                {{-- Top Actions --}}
                <div class="flex justify-between items-start mb-6">
                    <a href="{{ route('job-vacancies.index') }}"
                       class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 text-sm">
                        ← Back
                    </a>

                    <div class="space-x-2">
                        <a href="{{ route('job-vacancies.edit', $jobVacancy->id) }}"
                           class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                            Edit
                        </a>

                        <form action="{{ route('job-vacancies.destroy', $jobVacancy->id) }}"
                              method="POST"
                              class="inline-block"
                              onsubmit="return confirm('Archive this vacancy?')">
                            @csrf
                            @method('DELETE')
                            <button class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm">
                                Archive
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Vacancy Info --}}
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">
                        Vacancy Information
                    </h3>

                    <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">

                        <div>
                            <strong>Company:</strong>
                            <p>{{ $jobVacancy->company?->name ?? '-' }}</p>
                        </div>

                        <div>
                            <strong>Category:</strong>
                            <p>{{ $jobVacancy->jobcategory?->name ?? '-' }}</p>
                        </div>

                        <div>
                            <strong>Location:</strong>
                            <p>{{ $jobVacancy->location ?? '-' }}</p>
                        </div>

                        <div>
                            <strong>Type:</strong>
                            <p>{{ ucfirst($jobVacancy->type) ?? '-' }}</p>
                        </div>

                        <div>
                            <strong>Salary:</strong>
                            <p>
                                {{ $jobVacancy->salary ? '$'.number_format($jobVacancy->salary,2) : '-' }}
                            </p>
                        </div>

                        <div class="col-span-2">
                            <strong>Description:</strong>
                            <p class="mt-1 text-gray-600 whitespace-pre-line">
                                {{ $jobVacancy->description ?? '-' }}
                            </p>
                        </div>

                    </div>
                </div>

                {{-- Tabs --}}
                <div x-data="{ tab: 'applications' }">

                    <div class="border-b mb-4">
                        <nav class="flex space-x-8 text-sm font-medium">

                            <button @click="tab='applications'"
                                    :class="tab==='applications'
                                    ? 'border-indigo-600 text-indigo-600'
                                    : 'text-gray-500'"
                                    class="pb-2 border-b-2">

                                Applications ({{ $jobVacancy->jobApplications->count() }})
                            </button>

                        </nav>
                    </div>

                    {{-- Applications Tab --}}
                    <div x-show="tab==='applications'" x-transition>

                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-left text-gray-600">
                                    <th class="py-2 px-3">Applicant</th>
                                    <th class="py-2 px-3">Status</th>
                                    <th class="py-2 px-3">Score</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y">
                                @forelse($jobVacancy->jobApplications as $app)
                                    <tr>
                                        <td class="py-2 px-3">
                                            {{ $app->user->name ?? '-' }}
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
                                        <td colspan="3" class="text-center py-6 text-gray-500">
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