<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $jobApplication->user?->name ?? '-' }}
            | Applied to
            {{ $jobApplication->jobVacancy?->title ?? '-' }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-xl p-6">

                {{-- Top Actions --}}
                <div class="flex justify-between items-start mb-6">
                    <a href="{{ route('job-applications.index') }}"
                       class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 text-sm">
                        ← Back
                    </a>

                    <div class="space-x-2">

                        <a href="{{ route('job-applications.edit', $jobApplication->id) }}"
                           class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                            Edit
                        </a>

                        <form action="{{ route('job-applications.destroy', $jobApplication->id) }}"
                              method="POST"
                              class="inline-block"
                              onsubmit="return confirm('Archive this application?')">
                            @csrf
                            @method('DELETE')

                            <button class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm">
                                Archive
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Application Details --}}
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">
                        Application Details
                    </h3>

                    <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">

                        <div>
                            <strong>Applicant:</strong>
                            <p>{{ $jobApplication->user?->name ?? '-' }}</p>
                        </div>

                        <div>
                            <strong>Job Vacancy:</strong>
                            <p>{{ $jobApplication->jobVacancy?->title ?? '-' }}</p>
                        </div>

                        <div>
                            <strong>Company:</strong>
                            <p>{{ $jobApplication->jobVacancy?->company?->name ?? '-' }}</p>
                        </div>

                        <div>
                            <strong>Status:</strong>
                            <p class="capitalize">
                                {{ $jobApplication->status }}
                            </p>
                        </div>

                        <div class="col-span-2">
                            <strong>Resume:</strong>
                            @if($jobApplication->resume?->file_path)
                                <a href="{{ asset('storage/'.$jobApplication->resume->file_path) }}"
                                   target="_blank"
                                   class="text-indigo-600 hover:underline">
                                    View Resume
                                </a>
                            @else
                                <p>-</p>
                            @endif
                        </div>

                    </div>
                </div>

                {{-- Tabs --}}
                <div x-data="{ tab: 'resume' }">

                    <div class="border-b mb-4">
                        <nav class="flex space-x-8 text-sm font-medium">

                            <button @click="tab='resume'"
                                    :class="tab==='resume'
                                    ? 'border-indigo-600 text-indigo-600'
                                    : 'text-gray-500'"
                                    class="pb-2 border-b-2">
                                Resume
                            </button>

                            <button @click="tab='feedback'"
                                    :class="tab==='feedback'
                                    ? 'border-indigo-600 text-indigo-600'
                                    : 'text-gray-500'"
                                    class="pb-2 border-b-2">
                                AI Feedback
                            </button>

                        </nav>
                    </div>

                    {{-- Resume Tab --}}
                   <div x-show="tab==='resume'" x-transition>
    @if($jobApplication->resume)

        <table class="min-w-full bg-gray-50 rounded-lg shadow text-sm text-gray-700">
            <thead>
                <tr>
                    <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">
                        Summary
                    </th>
                    <th class="py-2 px-4 text-left bg-gray-100">
                        Skills
                    </th>
                    <th class="py-2 px-4 text-left bg-gray-100">
                        Experience
                    </th>
                    <th class="py-2 px-4 text-left bg-gray-100 rounded-tr-lg">
                        Education
                    </th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td class="py-2 px-4 align-top">
                        {{ $jobApplication->resume->summary }}
                    </td>

                    <td class="py-2 px-4 align-top">
                        {{ $jobApplication->resume->skills }}
                    </td>

                    <td class="py-2 px-4 align-top">
                        {{ $jobApplication->resume->experience }}
                    </td>

                    <td class="py-2 px-4 align-top">
                        {{ $jobApplication->resume->education }}
                    </td>
                </tr>
            </tbody>
        </table>

    @else
        <div class="bg-gray-50 p-4 rounded-md text-sm text-gray-500">
            No resume available.
        </div>
    @endif
</div>

                    {{-- AI Feedback Tab --}}
                 <div x-show="tab==='feedback'" x-transition>

    <table class="min-w-full bg-gray-50 rounded-lg shadow text-sm text-gray-700">
        <thead>
            <tr>
                <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">
                    AI Score
                </th>
                <th class="py-2 px-4 text-left bg-gray-100 rounded-tr-lg">
                    Feedback
                </th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td class="py-2 px-4 align-top">
                    {{ $jobApplication->aiGeneratedScore ?? '-' }}
                </td>

               <td class="py-2 px-4 whitespace-pre-line text-center align-middle">
                {{ $jobApplication->aiGeneratedFeedback ?? 'No feedback generated.' }}
            </td>
            </tr>
        </tbody>
    </table>

</div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>